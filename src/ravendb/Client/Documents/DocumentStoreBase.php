<?php
namespace RavenDB\Client\Documents;
use Exception;
/**
 * Class DocumentStoreBase
 * @package RavenDB\Client\Documents
 */
abstract class DocumentStoreBase implements IDocumentStore
{

    protected bool $disposed;
    protected bool $initialized;
    protected string|array $urls;
    protected string|null $database;

    public function isDisposed(): bool
    {
        return $this->disposed;
    }

    /**
     * @throws Exception
     */
    private function assertInitialized(): void
    {
        if(!$this->initialized){
            throw new Exception("You cannot open a session or access the database commands
            before initializing the document store. Did you forget calling initialize()?");
        }
    }

    /**
     * @param string $property
     * @throws Exception
     */
    private function assertNotInitialized(string $property) : void
    {
        if($this->initialized){
            throw new Exception("You cannot set $property after the document store has been initialized.");
        }
    }

    /**
     * Format the url values
     * @param array $values
     * @return void
     */
    public function setUrls(array|string $values) : void
    {
        if(null === $values ) throw new \InvalidArgumentException("value cannot be null");
        $collect = $values;
        if(is_array($values)){
            $collect=[];
            for( $i=0 ; $i<count($values) ; $i++ ) {
                $values[$i]?: throw new \InvalidArgumentException("value cannot be null");

                if (false === filter_var($values[$i], FILTER_VALIDATE_URL)) {
                    throw new \InvalidArgumentException("The url ".$values[$i]." is not valid");
                }
                $collect[$i] =  rtrim($values[$i], "/");
            }
        }
        $this->urls = $collect;
    }

    public function getUrls(): array|string
    {
        return $this->urls;
    }

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
        if($this->disposed){
            throw new Exception('The document store has already been disposed and cannot be used');
        }
    }

    public function getDocumentStore(string $database, ?bool $secured, ?int $waitIndexingTimeout){

    }
}