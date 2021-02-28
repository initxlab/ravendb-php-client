<?php

namespace RavenDB\Client\Serverwide\Operations;

use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Http\RavenCommand;
use RavenDB\Client\Http\ServerNode;
use RavenDB\Client\Http\HttpClient;

class GetDatabaseNamesCommand extends RavenCommand
{
    public function __construct(private int $_start, private int $_pageSize)
    {
    }

    public function isReadRequest(): bool
    {
        return true;
    }

    public function createRequest(DocumentStore|ServerNode $node, &$url): string
    {
        $node->setUrls($url);
        $requestURL = $node->getUrls() . "/databases?start=" . $this->_start . "&pageSize=" . $this->_pageSize . "&namesOnly=true";
        return (new HttpClient())->curlRequest($requestURL);
    }

    public static function invalidResponseException(?\Exception $cause)
    {
        parent::throwInvalidResponse($cause);
    }

    /**
     * @param string $response
     * @param bool $fromCache
     * @return array
     */
    public function setResponse(string $response, bool $fromCache): array
    {
        if (null === $response) {
            self::invalidResponseException(null);
        }

        $names = json_decode($response);

        if (!property_exists($names, "Databases")) {
            self::invalidResponseException(null);
        }

        $databases = $names->Databases;
        if (!is_array($databases)) {
            self::invalidResponseException(null);
        }

        return $databases;
    }
}