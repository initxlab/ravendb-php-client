<?php
namespace RavenDB\Client\Http;
Use Symfony\Component\HttpClient\CurlHttpClient;
Use Symfony\Component\HttpClient\NativeHttpClient;
/**
 * Class HttpClientCommand
 * @package RavenDB\Client\Http
 */
class HttpClient
{
    private $curlClient;
    private $phpClient;
    public function __construct()
    {
        $this->curlClient = new CurlHttpClient();
        $this->phpClient = new NativeHttpClient();
    }

    public function curlRequest(string $url,string $method="GET"): string
    {
        return $this->curlClient->request($method,$url)->getContent();
    }
}