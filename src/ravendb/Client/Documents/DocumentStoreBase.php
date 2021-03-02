<?php

namespace RavenDB\Client\Documents;

use Exception;
use RavenDB\Client\Primitives\Closable;

/**
 * Class DocumentStoreBase
 * @package RavenDB\Client\Documents
 */
abstract class DocumentStoreBase implements Closable
{
    /**
     * @var bool
     */
    protected bool $disposed;
    /**
     * @var bool
     */
    protected bool $initialized;
    /**
     * @var string|array
     */
    protected string|array $urls;
    /**
     * @var string|null
     */
    protected string|null $database;

    /**
     * @return bool
     */
    public function isDisposed(): bool
    {
        return $this->disposed;
    }

    public function close()
    {
        // TODO: Implement close() method.
    }

    /**
     * @throws Exception
     */
    private function assertInitialized(): void
    {
        if (!$this->initialized) {
            throw new Exception("You cannot open a session or access the database commands
            before initializing the document store. Did you forget calling initialize()?");
        }
    }

    /**
     * @param string $property
     * @throws Exception
     */
    private function assertNotInitialized(string $property): void
    {
        if ($this->initialized) {
            throw new Exception("You cannot set $property after the document store has been initialized.");
        }
    }

    /**
     * Format the url values
     * @param array|string $values
     * @return void
     */
    public function setUrls(array|string $values): void
    {
        if (null === $values) throw new \InvalidArgumentException("value cannot be null");

        $collect = $values;

        if (is_array($values)) {

            $collect = [];
            for ($i = 0; $i < count($values); $i++) {

                $values[$i] ?: throw new \InvalidArgumentException("value cannot be null");

                if (false === filter_var($values[$i], FILTER_VALIDATE_URL)) {
                    throw new \InvalidArgumentException("The url " . $values[$i] . " is not valid");
                }

                $collect[$i] = rtrim($values[$i], "/");
            }
        }

        $this->urls = $collect;
    }

    /**
     * @return array|string
     */
    public function getUrls(): array|string
    {
        return $this->urls;
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * Set the database instance
     * @param string $database
     * @return string
     */
    public function setDatabase(string $database): string
    {
        return $this->database = $database;
    }

    /**
     * Ensure the resource is not closed
     * @return void
     * @throws Exception
     */
    protected function ensureNotClosed(): void
    {
        if ($this->disposed) {
            throw new Exception('The document store has already been disposed and cannot be used');
        }
    }


    /**
     * @param string $database
     * @param bool|null $secured
     * @param int|null $waitIndexingTimeout
     */
    public function getDocumentStore(string $database, ?bool $secured, ?int $waitIndexingTimeout)
    {
    }


}