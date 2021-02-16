<?php
namespace RavenDB\Dev\Component;
use RavenDB\Dev\Contractor\ConnectorInterface;

/**
 * Class Connector
 * @package RavenDB\Dev\Component
 */
final class Connector implements ConnectorInterface
{
    private ConnectorInterface $connector;
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector= $connector;
    }

     public function getConfig(): array
     {
         return $this->connector->getConfig();
     }

    public function connect()
    {
        return $this->connector->connect();
    }
}