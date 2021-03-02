<?php

namespace RavenDB\Client\Documents\Operations;

interface IVoidMaintenanceOperation extends IMaintenanceOperation
{
    public function getCommand(DocumentConventions $conventions): VoidRavenCommand;
}