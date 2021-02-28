<?php
namespace RavenDB\Client\Documents\Operations;


class ClientConfiguration
{
    private bool $_frozen;
    private ClientConfiguration $_originalConfiguration;

    private bool $_saveEnumsAsIntegers;
    private string $_identityPartsSeparator;
    private bool $_disableTopologyUpdates;
}