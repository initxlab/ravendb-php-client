<?php

namespace RavenDB\Client\Http;

use stdClass;

/**
 * Class HttpClientCommand
 * @package RavenDB\Client\Http
 * TODO : TO REMOVE
 */
class HttpClientCurl
{
    private stdClass|bool $response;
    private string $url;
    private int $headerCode;

    /**
     * HttpClientCommand constructor.
     * @param ServerNode $node
     * @param false $fullHeader
     * TODO CHECK IF NEEDED
     */
    public function __construct(private ServerNode $node, private $fullHeader = false)
    {
        $this->headerCode = false === $this->fullHeader ? 0 : 42;
        $this->url = $this->node->getUrl();
    }

    /**
     * Return bool or CurlHandle resource
     * @return stdClass|bool
     */
    public function getResponse(): stdClass|bool
    {
        return $this->response;
    }

    /**
     * @param $curlInit
     * @param string $method
     * @return stdClass|null
     */
    public function curlQuery($curlInit,$method="GET"): ?stdClass
    {
        $resource = curl_init($curlInit);
        curl_setopt($resource, CURLOPT_HEADER, $this->headerCode);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($resource, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($resource,CURLOPT_TIMEOUT,1);
        $response = curl_exec($resource);

        if (!curl_errno($resource)) {
            return $this->response = json_decode($response);
        }
        curl_close($resource);

        return null;
    }

    public function isReadRequest(): bool
    {
        // TODO: Implement isReadRequest() method.
    }



    }