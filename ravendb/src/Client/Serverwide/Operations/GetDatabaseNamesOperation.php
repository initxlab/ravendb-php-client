<?php
namespace RavenDB\Client\Serverwide\Operations;
use RavenDB\Client\Documents\Conventions\DocumentConventions;

class GetDatabaseNamesOperation implements IServerOperation
{
     public function __construct(private int $_start, private int $_pageSize){ }

    /**
     * @param DocumentConventions|null $conventions
     * @return GetDatabaseNamesCommand
     */
    public function getCommand(?DocumentConventions $conventions): GetDatabaseNamesCommand {
         return new GetDatabaseNamesCommand($this->_start,$this->_pageSize);
     }
}