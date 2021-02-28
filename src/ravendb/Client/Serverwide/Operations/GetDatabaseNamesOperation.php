<?php
namespace RavenDB\Client\Serverwide\Operations;
use Exception;
use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Http\ServerNode;
use stdClass;

class GetDatabaseNamesOperation implements IServerOperation
{

    /**
     * GetDatabaseNamesOperation constructor.
     * @param int $_start
     * @param int $_pageSize
     */
    public function __construct(private int $_start, private int $_pageSize){ }

    /**
     * @param DocumentConventions|null $conventions
     * @return GetDatabaseNamesCommand
     */
    public function getCommand(?DocumentConventions $conventions=null): GetDatabaseNamesCommand {
        return new GetDatabaseNamesCommand($this->_start,$this->_pageSize);
    }

}