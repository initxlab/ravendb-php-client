<?php

namespace RavenDB\Client\Documents\Operations;

interface IMaintenanceOperation
{
    public function getCommand(DocumentConventions $conventions): RavenCommand|VoidRavenCommand;
}
