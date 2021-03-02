<?php

namespace RavenDB\Client\Http;

use RavenDB\Client\Auth\AuthOptions;
use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Primitives\CleanCloseable;
use RavenDB\Client\Primitives\Closable;

class RequestExecutor implements Closable
{
    private object $client;
    private AuthOptions $authOptions;
    private string $_databaseName;
    private Date $_lastReturnedResponse;
    private DocumentConventions $conventions;
    private int $_defaultTimeout;
    private int $_secondBroadcastAttemptTimeout;
    private int $_firstBroadcastAttemptTimeout;
    private static GetStatisticsOperation $backwardCompatibilityFailureCheckOperation;
    private static DatabaseHealthCheckOperation $failureCheckOperation;
    public static ?Consumer $requestPostProcessor = null;
    public static string $CLIENT_VERSION = "5.0.0";
    private Semaphore $_updateDatabaseTopologySemaphore;
    private Semaphore $_updateClientConfigurationSemaphore;
    private Log $logger;
    private HttpCache $cache;
    private ServerNode $_topologyTakenFromNode;
    public ThreadLocal $aggressiveCaching;
    protected NodeSelector $_nodeSelector;  // TODO: CHECK FOR IMPORT
    public AtomicLong $numberOfServerRequests;
    private static int $INITIAL_TOPOLOGY_ETAG = -2;
    public static ?Consumer $configureHttpClient = null;
    private CloseableHttpClient $_httpClient;
    protected float $clientConfigurationEtag;

    private Timer $_updateTopologyTimer;// TODO: TIMER CHECK FOR IMPORT
    protected float $topologyEtag;

    protected bool $_disableTopologyUpdates;

    protected bool $_disableClientConfigurationUpdates;

    protected string $lastServerVersion;

    protected function __construct(string $databaseName, AuthOptions $authOptions, DocumentConventions $conventions, array $initialUrls)
    {
        $cache = new HttpCache($conventions->getMaxHttpCacheSize());
        $this->_databaseName = $databaseName;
        $this->authOptions = $authOptions;
        $this->_lastReturnedResponse = new Date();
        $this->conventions = $conventions->clone();
        $this->_defaultTimeout = $conventions->getRequestTimeout();
        $this->_secondBroadcastAttemptTimeout = $conventions->getSecondBroadcastAttemptTimeout();
        $this->_firstBroadcastAttemptTimeout = $conventions->getFirstBroadcastAttemptTimeout();
        // $this->client = new HttpClient();
    }

    public static function getBackwardCompatibilityFailureCheckOperation(): GetStatisticsOperation
    {
        return self::$backwardCompatibilityFailureCheckOperation = new GetStatisticsOperation("failure=check");  // TODO: REMOVE
    }

    public static function getFailureCheckOperation(): DatabaseHealthCheckOperation
    {
        return self::$failureCheckOperation = new DatabaseHealthCheckOperation();  // TODO: CHECK FOR IMPORT --- to migrate - static install
    }

    public function getUpdateDatabaseTopologySemaphore(): Semaphore
    {
        return $this->_updateDatabaseTopologySemaphore = new Semaphore(1);  // TODO: NOT IN PHP SCOPE
    }

    public function getUpdateClientConfigurationSemaphore(): Semaphore
    {
        return $this->_updateClientConfigurationSemaphore = new Semaphore(1); // TODO: NOT IN PHP SCOPE
    }

    private static function getLogger(): Log
    {
        //return LogFactory::getLog(RequestExecutor::class);  // TODO: To import -- to keep find a secure package for logger
    }

    public function getCache(): HttpCache   // TODO : WAIT FOR GO
    {
        return $this->cache;
    }

    public function getTopology(): ?Topology
    {
        return $this->_nodeSelector !== null ? $this->_nodeSelector->getTopology() : null; //TODO : WAIT ON GO
    }

    public function getHttpClient(): CloseableHttpClient
    {
        $httpClient = $this->_httpClient;
        if ($httpClient != null) {
            return $httpClient;
        }

        return $this->_httpClient = $this->createHttpClient();
    }

    private function createHttpClient(): CloseableHttpClient
    {
        // ConcurrentMap<String, CloseableHttpClient> httpClientCache = getHttpClientCache();

        // $name = getHttpClientName();

        // return httpClientCache.computeIfAbsent(name, n -> createClient());
    } // TODO: CHECK FOR IMPORT

    public function getTopologyEtag(): float
    {
        return $this->topologyEtag;
    }

    public function getClientConfigurationEtag(): float
    {
        return $this->clientConfigurationEtag;
    }

    public static function create(string|array $initialUrls, string $databaseName, AuthOptions $authOptions, DocumentConventions $conventions): self
    {
        return new RequestExecutor($databaseName, $authOptions, $conventions, $initialUrls);
    }

    public static function createForSingleNodeWithConfigurationUpdates(string|array $initialUrls, string $databaseName, AuthOptions $authOptions, DocumentConventions $conventions): self
    {
        $executor = new createForSingleNodeWithoutConfigurationUpdates($databaseName, $authOptions, $conventions, $initialUrls);
    }

    public function getSecondBroadcastAttemptTimeout(): int
    {
        return $this->_secondBroadcastAttemptTimeout;
    }

    public function setSecondBroadcastAttemptTimeout(int $secondBroadcastAttemptTimeout): int
    {
        $this->_secondBroadcastAttemptTimeout = $secondBroadcastAttemptTimeout;
    }

    public function execute(DocumentStore|ServerNode $chosenNode, object $command): string
    {
        $chosenNode->setUrls($chosenNode->getUrls());
        $url = $chosenNode->getUrls();
        return $command->createRequest($chosenNode, $url);
    }

    public function close()
    {
    }

    public function getLastServerVersion(): string
    {
        return $this->lastServerVersion;
    }

    public function getDefaultTimeout(): int
    {
        return $this->_defaultTimeout;
    }

    public function setDefaultTimeout(int $timeout): void
    {
        $this->_defaultTimeout = $timeout;
    }

    public function getFirstBroadcastAttemptTimeout(): int
    {
        return $this->_firstBroadcastAttemptTimeout;
    }

    public function setFirstBroadcastAttemptTimeout(int $firstBroadcastAttemptTimeout): void
    {
        $this->_firstBroadcastAttemptTimeout = $firstBroadcastAttemptTimeout;
    }
}