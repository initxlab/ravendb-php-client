<?php

namespace RavenDB\Client\Http;

class URL extends HttpClient
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $this->curlUrl($url);
        parent::__construct();
    }

    public function getHost()
    {
        return $this->url->getInfo()["url"];
    }
}