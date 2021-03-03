<?php

namespace RavenDB\Tests\Client;

use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Documents\IDocumentStore;
use RavenDB\Client\Primitives\Closable;
use RavenDB\Client\Serverwide\DatabaseRecord;
use RavenDB\Client\Serverwide\Operations\CreateDatabaseOperation;
use RavenDB\Tests\Client\Driver\RavenServerLocator;
use RavenDB\Tests\Client\Driver\RavenTestDriver;

class RemoteTestBase extends RavenTestDriver implements Closable
{
    private static int $_index = 0;

    private RavenServerLocator $locator;
    private RavenServerLocator $securedLocator;

    private static ?IDocumentStore $globalServer;
    private static ?Process $globalServerProcess; // TODO Class Process to implement

    private static ?IDocumentStore $globalSecuredServer;
    private static ?Process $globalSecuredServerProcess;

    public function close()
    {
    }

    public function remoteTestBase()
    {
        $this->locator = new RavenServerLocator();
        $this->securedLocator = new RavenServerLocator();
    }

    protected function customizeDbRecord(DatabaseRecord $dbRecord): void // TODO : JVM API MODEL TO MIGRATE
    {

    }

    private static function getGlobalServer(bool $secured): IDocumentStore
    {
        return $secured ? self::$globalSecuredServer : self::$globalServer;
    }

    protected function customizeStore(DocumentStore $store): void // TODO : JVM API MODEL TO MIGRATE
    {

    }

    public function getSecuredDocumentStore(): DocumentStore
    {
        return $this->getDocumentStore("test_db", true, null);
    }

    private function getLocator(bool $secured): RavenServerLocator
    {
        return $secured ? $this->securedLocator : $this->locator;
    }

    private static function getGlobalProcess(bool $secured): Process
    {
        return $secured ? self::$globalSecuredServerProcess : self::$globalServerProcess;
    }

    private static function setGlobalServerProcess(bool $secured, Process $p): void
    {
        if ($secured) {
            self::$globalSecuredServerProcess = $p;
        } else {
            self::$globalServerProcess = $p;
        }
    }

    private static function killGlobalServerProcess(bool $secured, Process $process): void // TODO : CORRECTIONS UNUSED PARAM
    {
        if ($secured) {
            $p = self::$globalSecuredServerProcess;
            self::$globalSecuredServerProcess = null;
            self::$globalSecuredServer->close();
            self::$globalSecuredServer = null;
        } else {
            $p = self::$globalServerProcess;
            self::$globalServerProcess = null;
            self::$globalServer->close();
            self::$globalServer = null;
        }
        // TODO MIGRATION STEP linked to Process task
        RavenTestDriver::killProcess($p);
    }


    public function getDocumentStore(?string $database = null, ?bool $secured = null, int $waitForIndexingTimeout = null): DocumentStore
    {
        $name = $database . "_" . ++self::$_index;
        self::reportInfo("getDocumentStore for db " . $database . ".");
        $documentStore = self::getGlobalServer($secured);
        $databaseRecord = new DatabaseRecord();
        $databaseRecord->setDatabaseName($name);

        $this->customizeDbRecord($databaseRecord);

        $createDatabaseOperation = new CreateDatabaseOperation($databaseRecord);
        $documentStore->maintenance();
        $documentStore->server(); // TODO MIGRATION jvm source MaintenanceOperationExecutor
        $documentStore->send($createDatabaseOperation); // TODO MIGRATION jvm source ServerOperationExecutor

        $store = new DocumentStore();
        $store->setUrls($documentStore->getUrls());
        $store->setDatabase($name);
        $this->customizeStore($store);
        // hookLeakedConnectionCheck(store);
        $store->initialize(); // TODO MIGRATION jvm source DocumentStore

        $this->setupDatabase($store);
        if ($waitForIndexingTimeout != null) {
            waitForIndexing($store, $name, $waitForIndexingTimeout);
        }

        $documentStore->add($store);
        return $store;
    }
}
