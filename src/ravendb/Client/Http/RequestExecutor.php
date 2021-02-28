<?php

namespace RavenDB\Client\Http;

use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Primitives\CleanCloseable;
use RavenDB\Client\Serverwide\Operations\GetDatabaseNamesCommand;

class RequestExecutor implements CleanCloseable
{
    private object $client;

    public function __construct
    (
        private array|string $initialUrls, private string $databaseName, private ?string $certificate = null,
        private array $keyPassword = [], private ?string $trustStore = null, private ?object $executorService = null,
        private ?DocumentConventions $conventions = null
    )
    {
        $this->client = new HttpClient();
    }

    public static function create(string|array $initialUrls, string $databaseName, string $certificate, array $keyPassword, string $trustStore,
                                  ?object $executorService, DocumentConventions $conventions): self
    {
        return new self($initialUrls, $databaseName, $certificate, $keyPassword, $trustStore, $executorService, $conventions);
    }

    public function execute(DocumentStore|ServerNode $chosenNode, GetDatabaseNamesCommand $command): string
    {
        $chosenNode->setUrls($chosenNode->getUrls());
        $url = $chosenNode->getUrls();
        return $command->createRequest($chosenNode, $url);
    }

    public function close(\Exception $e)
    {
        // TODO: Implement close() method.
    }
}
