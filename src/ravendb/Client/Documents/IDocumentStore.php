<?php

namespace RavenDB\Client\Documents;

use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Primitives\Closable;
use RavenDB\Client\Util\IDisposalNotification;

interface IDocumentStore extends IDisposalNotification
{
    /**
     * Subscribe to change notifications from the server
     * @param string $database
     * @param string $nodeTag
     * TODO : CHECK WITH MARCIN IF CLEANCLOSABLE IS NOW REPLACED BY CLOSABLE (SEEN YESTERDAY)
     * AGGRESSIVE CACHE TO REMOVE, CHANGES, SUBSCRIPTIONS
     */

    public function getIdentifier(): string;

    public function setIdentifier(string $identifier): void;

    public function initialize(): IDocumentStore;

    public function openSession(SessionOptions $sessionOptions): IDocumentStore;

    function executeIndex(IAbstractIndexCreationTask $task, string $database): void;

    function executeIndexes(IAbstractIndexCreationTask $tasks): void;

    public function getConventions(): DocumentConventions;

    public function getUrls(): array|string;

    public function bulkInsert(string $database): BulkInsertOperation; // TODO class

    public function getDatabase(): string;

    public function getRequestExecutor(?string $databaseName): RequestExecutor; // accept null

    public function timeSeries(): TimeSeriesOperations;

    public function maintenance(): MaintenanceOperationExecutor;

    public function operations(): OperationExecutor;

    public function smuggler(): DatabaseSmuggler;

    public function setRequestTimeout(int $timeout, ?string $database): Closable;
}