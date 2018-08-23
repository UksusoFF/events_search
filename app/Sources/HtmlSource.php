<?php

namespace App\Sources;

use App\Models\Source;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class HtmlSource implements SourceInterface
{
    private $config;

    private $client;

    private $crawler;

    private const ID_PREFIX = 'html';

    public function __construct(Source $source)
    {
        $this->config = $source;
        $this->client = new Client();
        $this->crawler = new Crawler(null, null, $source->source);
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEvents()
    {
        $this->crawler->addHtmlContent($this->getHtml());

        return collect($this->getNode($this->crawler, 'css', $this->config->map_items)->each(function ($node) {
            $e = [
                'uuid' => $this->config->map_id ? implode('_', [
                    self::ID_PREFIX,
                    $this->config->id,
                    md5($this->getNodeValue($node, $this->config->map_id)),
                ]) : null,
                'title' => $this->config->map_title ? $this->getNodeValue($node, $this->config->map_title) : null,
                'description' => $this->config->map_description ? $this->getNodeValue($node, $this->config->map_description) : null,
                'image' => $this->config->map_image ? $this->getNodeValue($node, $this->config->map_image) : null,
                'date' => $this->config->map_date ? $this->getDate($this->getNodeValue($node, $this->config->map_date)) : null,
            ];
            return $e;
        }));
    }

    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getHtml()
    {
        $res = $this->client->request('GET', $this->config->source, [
            'timeout' => 10,
            'verify' => false,
        ]);
        return (string)$res->getBody();
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $node
     * @param string $type
     * @param string $selector
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     * @throws \Exception
     */
    private function getNode(Crawler $node, string $type, string $selector)
    {
        switch ($type) {
            case 'css':
                return $node->filter($selector);
            case 'xpath':
                return $node->filterXPath($selector);
            default :
                throw new Exception('Invalid filter type');
        }
    }

    /**
     * @param \Symfony\Component\DomCrawler\Crawler $parent
     * @param string $selector
     *
     * @return null|string
     * @throws \Exception
     */
    private function getNodeValue(Crawler $parent, string $selector)
    {
        $node = $this->getNode($parent, 'css', $selector);

        if ($node->count()) {
            if ($node->nodeName() == 'img') {
                return $node->image()->getUri();
            } elseif ($node->nodeName() == 'a') {
                return $node->link()->getUri();
            } else {
                return implode(PHP_EOL, $node->each(function (Crawler $item) {
                    return $item->text();
                }));
            }
        } else {
            return null;
        }
    }

    private function getDate(string $string)
    {
        if (str_is('*/assets/tpl/img/*.jpg', $string)) {
            if (preg_match('/([0-9]{2})([a-z]{3})([0-9]{2})/', trim(basename($string), '.jpg'), $matches)) {
                $months = [
                    'yan' => '01',
                    'fev' => '02',
                    'mar' => '03',
                    'apr' => '04',
                    'may' => '05',
                    'jun' => '06',
                    'jul' => '07',
                    'avg' => '08',
                    'sen' => '09',
                    'okt' => '10',
                    'nov' => '11',
                    'dec' => '12',
                ];
                return Carbon::create("20$matches[3]", $months[$matches[2]], $matches[1], 20, 00);
            }
        }
        return null;
    }
}