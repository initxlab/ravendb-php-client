<?php

namespace RavenDB\Client\Serverwide;

class DatabaseRecord
{
    private $databaseName;
    private bool $disabled;
    private bool $encrypted;
    private float $etagForBackup;

    public function dataBaseRecord(?string $databaseName)
    {
        $this->databaseName = $databaseName;
    }

    public function setDatabaseName(string $databaseName)
    {
        $this->databaseName = $databaseName;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }


    public function isEncrypted(): bool
    {
        return $this->encrypted;
    }


    public function setEncrypted(bool $encrypted): void
    {
        $this->encrypted = $encrypted;
    }


    public function getEtagForBackup(): float
    {
        return $this->etagForBackup;
    }


    public function setEtagForBackup(float $etagForBackup): void
    {
        $this->etagForBackup = $etagForBackup;
    }
}