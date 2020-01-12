<?php

namespace App\Sources;

use App\Helpers\DateTimeHelper;
use App\Helpers\UrlHelper;
use App\Models\Source;
use Exception;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class HtmlSource implements SourceInterface
{
    protected $config;

    protected $client;

    protected $crawler;

    protected $dateTimeHelper;

    protected const ID_PREFIX = 'html';

    protected const DATA_ATTRIBUTE_SYMBOL = '?';

    protected const BACKGROUND_STYLE_SYMBOL = '!';

    public function __construct(Source $source)
    {
        $this->config = $source;
        $this->client = new Client();
        $this->dateTimeHelper = new DateTimeHelper();
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEvents()
    {
        $events = collect();

        foreach (explode('|', $this->config->source) as $source) {
            $crawler = $this->getContent($source);

            $nodes = $this->getNode($crawler, $this->config->map_items);

            $nodes->each(function($node) use ($events) {
                $events->push([
                    'uuid' => $this->getNodeUuid($node),
                    'title' => $this->config->map_title ? $this->getNodeValue($node, $this->config->map_title) : null,
                    'url' => $this->getNodeUrl($node),
                    'description' => $this->config->map_description ? $this->getNodeValue($node, $this->config->map_description) : null,
                    'image' => $this->getNodeImage($node),
                    'date' => $this->getNodeDate($node),
                ]);
            });
        }

        return $events;
    }

    /**
     * @param string $source
     *
     * @return Crawler
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getContent(string $source): Crawler
    {
        $html = (string)($this->client->request('GET', $source, [
            'timeout' => 10,
            'verify' => false,
        ]))->getBody();

        preg_match('/\<meta[^\>]+charset *= *["\']?([a-zA-Z\-0-9_:.]+)/i', $html, $charset);

        $crawler = new Crawler(null, null, $source);

        $crawler->addHtmlContent($html, (array_last($charset) ?: 'UTF-8'));

        return $crawler;
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $node
     * @param string $rule
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     * @throws \Exception
     */
    protected function getNode(Crawler $node, string $rule)
    {
        [$type, $selector] = explode('|', $rule);

        switch ($type) {
            case 'css':
                return $node->filter($selector);
            case 'xpath':
                return $node->filterXPath($selector);
            default:
                throw new Exception('Invalid filter type');
        }
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $parent
     * @param string $rule
     *
     * @return null|string
     * @throws \Exception
     */
    protected function getNodeValue(Crawler $parent, string $rule)
    {
        if (str_contains($rule, self::DATA_ATTRIBUTE_SYMBOL)) {
            [$rule, $attr] = explode(self::DATA_ATTRIBUTE_SYMBOL, $rule);
        }

        $node = $this->getNode($parent, $rule);

        if ($node->count()) {
            if (!empty($attr)) {
                $value = $node->attr($attr);
            } elseif ($node->nodeName() == 'img') {
                $value = $node->image()->getUri();
            } elseif ($node->nodeName() == 'a') {
                $value = $node->link()->getUri();
            } else {
                $value = implode(PHP_EOL, $node->each(function(Crawler $child) {
                    return $child->text();
                }));
            }

            return trim(str_replace("\xc2\xa0", ' ', $value));
        } else {
            return null;
        }
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $node
     *
     * @return null|string
     * @throws \Exception
     */
    protected function getNodeUuid(Crawler $node)
    {
        if (empty($this->config->map_id)) {
            return null;
        }

        if (empty($nodeValue = $this->getNodeValue($node, $this->config->map_id))) {
            return null;
        }

        return implode('_', [
            self::ID_PREFIX,
            $this->config->id,
            md5($nodeValue),
        ]);
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $node
     *
     * @return \Illuminate\Support\Carbon|null
     * @throws \Exception
     */
    protected function getNodeDate(Crawler $node)
    {
        if (empty($this->config->map_date)) {
            return null;
        }

        if (empty($nodeValue = $this->getNodeValue($node, $this->config->map_date))) {
            return null;
        }

        return $this->dateTimeHelper->getDateFromFormat(
            $nodeValue,
            $this->config->map_date_format,
            $this->config->map_date_regex
        );
    }

    /**
     * @param $node
     *
     * @return null|string
     * @throws \Exception
     */
    protected function getNodeUrl($node)
    {
        if (empty($this->config->map_url)) {
            return $this->config->source;
        }

        return $this->getNodeValue($node, $this->config->map_url);
    }

    /**
     * @param $node
     *
     * @return null|string
     * @throws \Exception
     */
    protected function getNodeImage($node): ?string
    {
        if (empty($this->config->map_image)) {
            return null;
        }

        if (ends_with($this->config->map_image, self::BACKGROUND_STYLE_SYMBOL)) {
            $node = $this->getNode($node, trim($this->config->map_image, self::BACKGROUND_STYLE_SYMBOL));

            $style = $node->attr('style');
            $pattern = '/background-image:\s*url\(\s*([\'"]*)(?P<file>[^\1]+)\1\s*\)/i';
            $matches = [];

            if (preg_match($pattern, $style, $matches)) {
                return UrlHelper::relToAbs($matches['file'], $this->config->source);
            }

            return null;
        }

        return $this->getNodeValue($node, $this->config->map_image);
    }
}
