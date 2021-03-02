<?php

namespace RavenDB\Client\Http;

class CurrentIndexAndNode
{
    public int $currentIndex;
    public ServerNode $currentNode;

    public function __construct(int $currentIndex, ServerNode $currentNode)
    {
        $this->currentIndex = $currentIndex;
        $this->currentNode = $currentNode;
    }
}
