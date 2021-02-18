<?php
namespace RavenDB\Client\Serverwide\Operations;
use RavenDB\Client\Http\RavenCommand;
use RavenDB\Client\Http\ServerNode;

class GetDatabaseNamesCommand extends RavenCommand
{
    public function __construct(private int $_start, private int $_pageSize) {
    }

    public function isReadRequest():bool{
        return true;
    }

    public function createRequest(ServerNode $node): string
    {
        return $node->getUrl()."/databases?start=".$this->_start."&pageSize=".$this->_pageSize."&namesOnly=true";
    }
}