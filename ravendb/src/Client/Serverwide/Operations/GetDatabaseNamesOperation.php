<?php
namespace RavenDB\Client\Serverwide\Operations;
use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Http\RavenCommand;

class GetDatabaseNamesOperation implements IServerOperation
{
     public function __construct(private int $_start, private int $_pageSize){
     }
    /**
     * @return RavenCommand
     */
    public function getCommand(): GetDatabaseNamesCommand {
         return new GetDatabaseNamesCommand($this->_start,$this->_pageSize);
     }
}