<?php
namespace RavenDB\Client\Serverwide\Operations;
use RavenDB\Client\Http\RavenCommand;
use RavenDB\Client\Http\ServerNode;
use RavenDB\Client\Http\CurlCommand;
class GetDatabaseNamesCommand extends RavenCommand
{
    private $curlCMD;
    public function __construct(private int $_start,private int $_pageSize,private $response) {

    }

    public function isReadRequest():bool{ return true; }

    public function createRequest(ServerNode $node): \stdClass
    {
        $curlCmd = new CurlCommand($node);
        return $curlCmd->createRequest("/databases",
            ["start"=>$this->_start,"pageSize"=>$this->_pageSize,"namesOnly"=>true]
        );
    }

    public function setResponse(){

    }
}