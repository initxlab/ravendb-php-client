<?php

namespace RavenDB\Client\Documents\Operations;

use RavenDB\Tests\Client\Util\StringUtils;

class MaintenanceOperationExecutor
{
    private DocumentStore $store;
    private string $databaseName;
    private RequestExecutor $requestExecutor;
    private ServerOperationExecutor $serverOperationExecutor;

    public function MaintenanceOperationExecutor(DocumentStore $store)
    {
        //TODO: $this(store, null);
    }

    public function __construct(DocumentStore $store, string $databaseName)
    {
        $this->store = $store;
        // TODO: $this->databaseName = ObjectUtils.firstNonNull(databaseName, store.getDatabase());
    }

    private function getRequestExecutor(): RequestExecutor
    {
        if ($this->requestExecutor !== null) {
            return $this->requestExecutor;
        }

        // $this->requestExecutor = $this->databaseName !== null ? $this->store->getRequestExecutor($this->databaseName) : null;
        return $this->requestExecutor;
    }

    public function server(): ServerOperationExecutor
    {
        if ($this->serverOperationExecutor !== null) {
            return $this->serverOperationExecutor;
        } else {
            $this->serverOperationExecutor = new ServerOperationExecutor($this->store);
            return $this->serverOperationExecutor;
        }
    }

    public function forDatabase(string $databaseName): MaintenanceOperationExecutor
    {
        if (StringUtils::equalsIgnoreCase($this->databaseName, $databaseName)) {
            return $this;
        }
        return new MaintenanceOperationExecutor($this->store, $this->databaseName);
    }

    private function assertDatabaseNameSet(): void
    {
        if ($this->databaseName === null) {
            throw new IllegalStateException("Cannot use maintenance without a database defined, did you forget to call forDatabase?");
        }
    }
}
/*
 *
 * public function send(IVoidMaintenanceOperation operation): void {
        $this->assertDatabaseNameSet();
        VoidRavenCommand command = $operation->getCommand($this->getRequestExecutor().getConventions());
        getRequestExecutor().execute(command);
    }





*/