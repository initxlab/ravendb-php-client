<?php
namespace RavenDB\Tests\Executor;
use PHPUnit\Framework\TestCase;
use RavenDB\Client\Http\ServerNode;
use RavenDB\Client\Serverwide\Operations\GetDatabaseNamesOperation;

class GetDatabaseNamesOperationTest extends TestCase
{
    public function testGetDatabaseNamesOperation(){
        $db = new GetDatabaseNamesOperation( 1, 1);
        $serverNode = new ServerNode();
        $serverNode->setUrl(IEnv::URL);
        $command = $db->getCommand( null)->createRequest($serverNode);
        $this->assertIsString($command);
    }
}