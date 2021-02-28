<?php


namespace RavenDB\Client\Serverwide;


class DatabaseRecord
{
    private $databaseName;
    private bool $disabled;
    private bool $encrypted;
    private float $etagForBackup;

}