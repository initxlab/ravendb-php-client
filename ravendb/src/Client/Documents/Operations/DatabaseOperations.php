<?php
namespace RavenDB\Client\Documents\Operations;

use RavenDB\Client\Http\RavenCommand;

class DatabaseOperations extends RavenCommand
{

    public function __construct(private array|string $url, private string $database)
    {

    }

}