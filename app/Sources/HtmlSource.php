<?php

namespace App\Sources;

use App\Models\Source;
use GuzzleHttp\Client;

class HtmlSource implements SourceInterface
{
    private $config;

    private $client;

    public function __construct(Source $source)
    {
        $this->config = $source;
        $this->client = new Client();
    }

    public function getEvents()
    {
        // TODO: Implement getEvents() method.
    }
}