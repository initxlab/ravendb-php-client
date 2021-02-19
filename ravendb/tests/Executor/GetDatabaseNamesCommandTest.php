<?php
namespace RavenDB\Tests\Executor;
use PHPUnit\Framework\TestCase;
use RavenDB\Client\Http\ServerNode;
use RavenDB\Client\Serverwide\Operations\GetDatabaseNamesCommand;

class GetDatabaseNamesCommandTest extends TestCase
{
    public function testGetDatabaseNamesCommand(){
        $serverNode = new ServerNode();
        $serverNode->setUrl(IEnv::URL);
        $db = new GetDatabaseNamesCommand( 0, 2);
        $request = $db->createRequest($serverNode);
        $this->assertIsString( $request);
    }
}