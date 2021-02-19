<?php
namespace RavenDB\Tests\Executor;
use PHPUnit\Framework\TestCase;
use RavenDB\Client\Http\CurlCommand;
use RavenDB\Client\Http\ServerNode;

class CurlCommandTest extends TestCase
{
    private ServerNode $node;
    private CurlCommand $curlCmd;

    private function resource():void{
        $this->node = new ServerNode();
        $this->node->setUrl(IEnv::URL);
        $this->curlCmd = new CurlCommand($this->node,false);
    }

    public function testCurlCommandCurlAssertCurlHandle(){
        $this->resource();
        $this->curlCmd->createRequest(IEnv::ROUTE_DATABASES,[IEnv::QUERY_NAME=>"db1","param"=>"value"]);
        $output = $this->curlCmd->getResponse();
        $this->assertInstanceOf(\CurlHandle::class,$output);
    }
}