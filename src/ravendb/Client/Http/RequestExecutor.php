<?php

namespace RavenDB\Client\Http;

use RavenDB\Client\Auth\AuthOptions;
use RavenDB\Client\Documents\Conventions\DocumentConventions;
use RavenDB\Client\Documents\DocumentStore;
use RavenDB\Client\Primitives\Closable;
/**
 * TODO: SOME OBJECT RESOURCE TO IMPORT
 * TODO: Date (if not native class to confirm)
 */
class RequestExecutor implements Closable
{
    private AuthOptions $authOptions;
    private string $_databaseName;
    private Date $_lastReturnedResponse;
    private DocumentConventions $conventions;
    private int $_defaultTimeout;
    private int $_secondBroadcastAttemptTimeout;
    private int $_firstBroadcastAttemptTimeout;
    private static DatabaseHealthCheckOperation $failureCheckOperation;
    public static ?Consumer $requestPostProcessor = null;
    public static string $CLIENT_VERSION = "5.0.0";
    private Log $logger;
    private HttpCache $cache;
    public ThreadLocal $aggressiveCaching;
    protected NodeSelector $_nodeSelector;  // TODO: CHECK FOR IMPORT
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
    }


    public static function getFailureCheckOperation(): DatabaseHealthCheckOperation
    {
        return self::$failureCheckOperation = new DatabaseHealthCheckOperation();  // TODO: CHECK FOR IMPORT --- to migrate - static install
    }


    private static function getLogger(): Log
    {
        //return LogFactory::getLog(RequestExecutor::class);  // TODO : Import a secure package for logging
    }

    public function getCache(): HttpCache   // TODO MIGRATION : wait on go for http cache
    {
        return $this->cache;
    }

    public function getTopology(): ?Topology
    {
        return $this->_nodeSelector !== null ? $this->_nodeSelector->getTopology() : null; //TODO MIGRATION : wait on go
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
        //$executor = new createForSingleNodeWithoutConfigurationUpdates($databaseName, $authOptions, $conventions, $initialUrls);
        // TODO MIGRATION TO COMPLETE FROM JVM SOURCE
    }

    public function getSecondBroadcastAttemptTimeout(): int
    {
        return $this->_secondBroadcastAttemptTimeout;
    }

    public function setSecondBroadcastAttemptTimeout(int $secondBroadcastAttemptTimeout): int
    {
        $this->_secondBroadcastAttemptTimeout = $secondBroadcastAttemptTimeout;
    }

    public function execute(ServerNode $chosenNode, object $command): string
    {
        $chosenNode->setUrls($chosenNode->getUrls());
        $url = $chosenNode->getUrls();
        return $command->createRequest($chosenNode, $url);
    }

    public function close()
    {
        // no instructions yet to setup a content here
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
