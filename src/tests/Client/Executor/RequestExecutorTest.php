<?php

namespace RavenDB\Tests\Client\Executor;

use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Http\RequestExecutor;
use RavenDB\Client\Serverwide\Operations\GetDatabaseNamesOperation;
use RavenDB\Tests\Client\RemoteTestBase;

class RequestExecutorTest extends RemoteTestBase
{
    // TODO: TEST RUN PENDING ON THE DEPENDENCIES MIGRATION
    public function testCanFetchDatabasesNames()
    {
        $conventions = new DocumentConventions();
        $store = $this->getDocumentStore();

        try {
            $executor = RequestExecutor::create($store->getUrls(), $store->getDatabase(), null, $conventions);
            try {
                $databaseNamesOperation = new GetDatabaseNamesOperation(0, 20);
                $command = $databaseNamesOperation->getCommand($conventions);
                $executor->execute($store, $command);
                $dbNames = $command->getResult();
                // TODO: IMPLEMENT assertAs UTIL FOLLOWING API CONVENTION
                $isStoreDbName = in_array($store->getDatabase(), $dbNames);
                $this->assertTrue($isStoreDbName);
                $this->assertThat();
            } finally {
                $executor->close();
            }
        } finally {
            $store->close();
        }
    }

}