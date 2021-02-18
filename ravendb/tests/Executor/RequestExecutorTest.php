<?php
namespace RavenDB\Tests\Executor;
use PHPUnit\Framework\TestCase;
use RavenDB\Client\Http\ServerNode;
use RavenDB\Client\Serverwide\Operations\GetDatabaseNamesCommand;
use RavenDB\Client\Serverwide\Operations\GetDatabaseNamesOperation;

final class RequestExecutorTest extends TestCase
{
    public function testGetDatabaseName(){
        $serverNode = new ServerNode();
        $serverNode->setUrl("http://localhost:8080");
        $db = new GetDatabaseNamesCommand(0,2);
        $request = $db->createRequest($serverNode);
        $this->assertIsString($request);
    }

    public function testGetDatabaseNamersOperations(){
        $db = new GetDatabaseNamesOperation(0,2);
        $serverNode = new ServerNode();
        $serverNode->setUrl('http://localhost:8080');
        $command = $db->getCommand()->createRequest($serverNode);
        dd($command);
    }
}