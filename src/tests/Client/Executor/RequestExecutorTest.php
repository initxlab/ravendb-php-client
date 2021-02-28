<?php

namespace RavenDB\Tests\Client\Executor;

use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Http\RequestExecutor;
use RavenDB\Client\Serverwide\Operations\GetDatabaseNamesOperation;
use RavenDB\Tests\Client\RemoteTestBase;

class RequestExecutorTest extends RemoteTestBase
{

    public function testCanFetchDatabasesNames()
    {
        $conventions = new DocumentConventions();

        try {
            $store = new DocumentStore("http://devtool.infra:9095", 'db1');
            try {

                $executor = RequestExecutor::create($store->getUrls(), $store->getDatabase(), '', [], '', null, $conventions);
                $databaseNamesOperation = new GetDatabaseNamesOperation(0, 20);
                $command = $databaseNamesOperation->getCommand($conventions);
                $request = $executor->execute($store, $command);
                $dbNames = $command->setResponse($request, false);
                $this->assertIsArray($dbNames);
                $isStoreDbName = in_array($store->getDatabase(), $dbNames);
                $this->assertTrue($isStoreDbName);

            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
