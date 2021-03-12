<?php

namespace RavenDB\Client\Documents\Commands;

use RavenDB\Client\Http\HttpClient;
use RavenDB\Client\Http\RavenCommand;
use RavenDB\Client\Http\ServerNode;

class GetNextOperationIdCommand extends RavenCommand
{
    private string $_nodeTag;

    public function __construct()
    {
        //TODO : super(Long.class)
    }

    public function getNodeTag(): string
    {
        return $this->_nodeTag;
    }

    public function isReadRequest(): bool
    {
        return false;
    }

    public function createRequest(ServerNode $node, &$url): string
    {
        $url = $node->getUrl() . "/databases/" . $node->getDatabase() . "/operations/next-operation-id";
        return (new HttpClient())->curlRequest($url);
    }

    public function setResponse(string $response, bool $fromCache)
    {
        $jsonNode = json_decode($response);

        if (property_exists($jsonNode, 'Id')) {
            $this->result = $jsonNode->Id;
        }

        if (property_exists($jsonNode, 'NodeTag')) {
            $this->_nodeTag = $jsonNode->NodeTag;
        }
    }
}
