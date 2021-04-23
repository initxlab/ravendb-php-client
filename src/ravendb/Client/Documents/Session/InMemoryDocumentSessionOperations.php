<?php /** @noinspection ALL */

/** @noinspection PhpUnhandledExceptionInspection */

namespace RavenDB\Client\Documents\Session;

use Doctrine\Common\Collections\ArrayCollection;
use RavenDB\Client\Documents\Commands\Batches\BatchOptions;
use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Documents\DocumentStoreBase;
use RavenDB\Client\Documents\IDocumentStore;
use RavenDB\Client\Documents\Operations\OperationExecutor;
use RavenDB\Client\Documents\Operations\SessionOperationExecutor;
use RavenDB\Client\Exceptions\IllegalStateException;
use RavenDB\Client\Http\RequestExecutor;
use RavenDB\Client\Http\ServerNode;
use RavenDB\Client\Json\MetadataAsDictionary;
use RavenDB\Client\Primitives\Closable;
use RavenDB\Client\Util\ObjectUtils;
use RavenDB\Client\Util\StringUtils;
use RavenDB\Client\DataBind\Node\ObjectNode;
abstract class InMemoryDocumentSessionOperations implements Closable
{
    protected RequestExecutor $_requestExecutor;
    private OperationExecutor $_operationExecutor;
    protected ArrayCollection $_knownMissingIds;
    private const TRANSACTION_MODE_SINGLE_NODE = "SINGLE_NODE"; // NO ENUM YET IN PHP
    private const TRANSACTION_MODE_CLUSTER_WIDE = "CLUSTER_WIDE"; // NO ENUM YET IN PHP
    protected SessionInfo $sessionInfo;
    protected $mapper;
    private string $id;
    private string $databaseName;
    protected DocumentStoreBase $_documentStore;
    public bool $noTracking;
    public ?BatchOptions $_saveChangesOptions=null;
    private int $numberOfRequests;
    private array $externalState;
    private array $deferredCommands;
    private bool $useOptimisticConcurrency;
    private int $maxNumberOfRequestsPerSession;
    // TODO : PRIORITY ON THE CRUD OPERATION AND UNIT OF WORK
    protected function __construct(DocumentStoreBase $documentStore, string $id, SessionOptions $options)
    {
        $this->id = $id;
        $this->databaseName = ObjectUtils::firstNonNull([$options->getDatabase(),$documentStore->getDatabase()]);
        if(StringUtils::isBlank($this->databaseName)){
            static::throwNoDatabase();
        }
        $this->_documentStore = $documentStore;
        $this->_requestExecutor = ObjectUtils::firstNonNull($options->getRequestExecutor(),$documentStore->getRequestExecutor($this->databaseName));
        $this->noTracking = $options->isNoTracking();
        $this->useOptimisticConcurrency = $this->_requestExecutor->getConventions()->isUseOptimisticConcurrency();
        $this->maxNumberOfRequestsPerSession
    }

    /**
     * @return bool
     */
    public function isUseOptimisticConcurrency(): bool
    {
        return $this->useOptimisticConcurrency;
    }

    /**
     * @param bool $useOptimisticConcurrency
     */
    public function setUseOptimisticConcurrency(bool $useOptimisticConcurrency): void
    {
        $this->useOptimisticConcurrency = $useOptimisticConcurrency;
    }



    public function getDatabaseName(): string
    {
        return $this->databaseName;
    }

    public function getExternalState(){
        if(null === $this->externalState){
            $this->externalState = [];
        }
        return $this->externalState;
    }

    public function getConvetions():DocumentConventions {
        return $this->_requestExecutor->getConventions();
    }

    public function getDocumentId(object $instance):string|null {
        if(null === $instance) return null;
    }

    /***************** LifeCycle/UOW/Workflow ********************/
    public function prepareForSaveChanges():SaveChangesData {
        $result = new SaveChangesData($this);
        $deferredCommandsCount = count($this->deferredCommands);
        $this->prepareForEntitiesDeletion($result,null);
        $this->prepareForEntitiesPuts($result);
        $this->prepareForCreatingRevisionsFromIds($result);
        $this->prepareCompareExchangeEntities($result);
        return $result;
    }
    public function prepareForEntitiesPuts(SaveChangesData $result,array $changes):void {
         $putsContext = $this->documentsByEntity()->prepareEntitiesPuts();
         $shouldIgnoreEntityChanges = $this->getConvetions()->getShouldIgnoreEntityChanges();

         foreach($this->documentsByEntity() as $entity){
             /**
              *@var DocumentsByEntityEnumeratorResult $entity
              */
             if($entity->getValue()->isIgnoreChanges()) continue;

             if(null !== $shouldIgnoreEntityChanges){
                 if($shouldIgnoreEntityChanges->check(
                     $this,
                     $entity->getValue()->getEntity(),
                     $entity->getValue()->getId())){
                     continue;
                 }
             }

             if($this->isDeleted($entity->getValue()->getId())) continue;

             $dirtyMetadata = self::updateMetadataModifications($entity->getValue());

             /**
              * var ObjectNode $document
             */
         //    $document =
         }
    }

    /**
     * Returns whether a document with the specified id is deleted
     * or known to be missing
     *
     * @param id Document id to check
     * @return true is document is deleted
     */
    public function isDeleted(string $id) {
        return $this->_knownMissingIds->containsKey(id);
    }

    private static function updateMetadataModifications(DocumentInfo $documentInfo):bool{
        $dirty = false;
        if(null !== $documentInfo->getMetadataInstance()){
            $dirty = true;
        }
        foreach ($documentInfo->getMetadataInstance() as $pop) { // TODO : CHECK FOR THE KEYSET
            $dirty = false;
            /**
             * @var MetadataAsDictionary $propValue
            */
            $propValue = $documentInfo->getMetadataInstance()->getLong($pop);
            if(null === $propValue || $propValue instanceof MetadataAsDictionary && ($propValue->isDirty())){
                $dirty = true;
            }
        }
    }
    public function prepareForEntitiesDeletion(SaveChangesData $result, ?array $changes=null):void { }
    public function prepareForCreatingRevisionsFromIds(SaveChangesData $result):void { }
    public function prepareCompareExchangeEntities(SaveChangesData $result):void { }
    /** *************************************************** **/

    public function internalPrepareEntitiesPuts():Closable{

    }

    private static function throwNoDatabase(){
        throw new IllegalStateException("Cannot open a Session without specifying a name of a database ".
            "to operate on. Database name can be passed as an argument when Session is".
            " being opened or default database can be defined using 'DocumentStore.setDatabase()' method");
    }
    public function getCurrentSessionNode():ServerNode {
        return $this->getSessionInfo()->getCurrentSessionNode($this->_requestExecutor);
    }

    public function getDocumentStore():IDocumentStore|ArrayCollection {
        return $this->_documentStore;
    }

    public function getRequestExecutor():RequestExecutor {
        return $this->_requestExecutor;
    }

    public function getSessionInfo(): SessionInfo {
        return $this->sessionInfo;
    }

    public function getOperations():OperationExecutor {
        if(null === $this->_operationExecutor){
            $this->_operationExecutor = new SessionOperationExecutor($this);
        }
    }

    public function getNumberOfRequests(): int
    {
        return $this->numberOfRequests;
    }

    /**
     * hold the data required to manage the data for RavenDB's Unit of Work
     */
    public function documentsByEntity():DocumentsByEntityHolder{
        return new DocumentsByEntityHolder();
    }

    /**
     * @return int
     */
    public function getDeferredCommands(): int
    {
        return count($this->deferredCommands);
    }

    public function storeEntityInUnitOfWork(string $id, object $entity, string $changeVector, ObjectNode $metadata, ConcurrencyCheckMode $forceConcurrencyCheck){
        if(null != $id){
            $this->_knownMissingIds->remove($id);
        }
        $documentInfo = new DocumentInfo();
        $documentInfo->setId($id);
        $documentInfo->setMetadataInstance($metadata);
        $documentInfo->setChangeVector($changeVector);
        $documentInfo->setConcurrencyCheckMode($forceConcurrencyCheck);
        $documentInfo->setEntity($entity);
        $documentInfo->setNewDocument(true);
        $documentInfo->setDocument(null);
        $this->documentsByEntity;
    }
}