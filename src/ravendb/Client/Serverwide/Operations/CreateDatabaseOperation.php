<?php

namespace RavenDB\Client\Serverwide\Operations;

use RavenDB\Client\Serverwide\DatabaseRecord;

class CreateDatabaseOperation implements IServerOperation
{
    private DatabaseRecord $databaseRecord;
    private ?int $replicationFactor;

    public function __construct(DatabaseRecord $databaseRecord, ?int $replicationFactor = null)
    {
        $this->databaseRecord = $databaseRecord;
        $this->replicationFactor = $replicationFactor;
    }
}
