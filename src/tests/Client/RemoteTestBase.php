<?php
namespace RavenDB\Tests\Client;
use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Primitives\CleanCloseable;
use RavenDB\Tests\Client\Driver\RavenTestDriver;

class RemoteTestBase extends RavenTestDriver implements CleanCloseable
{

    private string $name;
    private DocumentStore $documentStore;
    private static int $index;
    private static $globalServer;
    private static $globalSecuredServer;

    public function close(\Exception $e)
    {
        // TODO: Implement close() method.
    }

    public function getDocumentStore(string $database,bool $secured, ):DocumentStore {
        $this->name = $database."_".self::$index++;
        $this->reportInfo("getDocumentStore for db ".$database.".");



    }
}