<?php
namespace RavenDB\Tests\Executor;
use PHPUnit\Framework\TestCase;
use RavenDB\Client\Documents\DocumentStore;

class DocumentStoreTest extends TestCase
{
    private const DOCUMENT_STORE_URL_AS_ARRAY=["http://link.com","http://backup.link.com"];
    private const DOCUMENT_STORE_IDENTIFIER =  null;
    private const DOCUMENT_STORE_DB =  "db1";

    public function testDocumentStore(){
        $store = new DocumentStore(self::DOCUMENT_STORE_URL_AS_ARRAY,self::DOCUMENT_STORE_DB);
        $store->setIdentifier(self::DOCUMENT_STORE_IDENTIFIER);
        $store->getIdentifier();
        $this->assertIsString($store->getIdentifier());
    }
}