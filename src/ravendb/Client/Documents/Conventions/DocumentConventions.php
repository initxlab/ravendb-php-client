<?php

namespace RavenDB\Client\Documents\Conventions;

use RavenDB\Client\Documents\Operations\ClientConfiguration;
use RavenDB\Client\Http\LoadBalanceBehavior;
use RavenDB\Client\Http\ReadBalanceBehavior;

class DocumentConventions
{
    private int $_maxHttpCacheSize;
    private array $_listOfRegisteredIdConventions;
    private bool $_frozen;
    private ClientConfiguration $_originalConfiguration;
    private bool $_saveEnumsAsIntegers;
    private bool $_identityPartsSeparator;
    private bool $_disableTopologyUpdates;
    private bool $_useOptimisticConcurrency;
    private bool $_throwIfQueryPageSizeIsNotSet;
    private int $_maxNumberOfRequestsPerSession;
    private int $_requestTimeout;
    private int $_firstBroadcastAttemptTimeout;
    private int $_secondBroadcastAttemptTimeout;
    private LoadBalanceBehavior $_loadBalanceBehavior;
    private ReadBalanceBehavior $_readBalanceBehavior;
    private ObjectMapper $_entityMapper;
    private Boolean $_useCompression;

    public function getMaxHttpCacheSize(): int
    {
        return $this->_maxHttpCacheSize;
    }

    public function getRequestTimeout(): int
    {
        return $this->_requestTimeout;
    }

    public function setRequestTimeout(int $requestTimeout)
    {
        $this->assertNotFrozen();
        $this->_requestTimeout = $requestTimeout;
    }

    public function setMaxHttpCacheSize(int $maxHttpCacheSize)
    {
        $this->assertNotFrozen();
        $this->_maxHttpCacheSize = $maxHttpCacheSize;
    }

    public function clone(): DocumentConventions
    {
        $cloned = clone new DocumentConventions();
        $cloned->_listOfRegisteredIdConventions = $this->_listOfRegisteredIdConventions;
        $cloned->_frozen = $this->_frozen;
        $cloned->_originalConfiguration = $this->_originalConfiguration;
        $cloned->_saveEnumsAsIntegers = $this->_saveEnumsAsIntegers;
        $cloned->_identityPartsSeparator = $this->_identityPartsSeparator;
        $cloned->_disableTopologyUpdates = $this->_disableTopologyUpdates;
        $cloned->_useOptimisticConcurrency = $this->_useOptimisticConcurrency;
        $cloned->_throwIfQueryPageSizeIsNotSet = $this->_throwIfQueryPageSizeIsNotSet;
        $cloned->_maxNumberOfRequestsPerSession = $this->_maxNumberOfRequestsPerSession;
        $cloned->_readBalanceBehavior = $this->_readBalanceBehavior;
        $cloned->_loadBalanceBehavior = $this->_loadBalanceBehavior;
        $cloned->_maxHttpCacheSize = $this->_maxHttpCacheSize;
        $cloned->_entityMapper = $this->_entityMapper;
        $cloned->_useCompression = $this->_useCompression;
        return $cloned;
    }

    public function freeze(): void
    {
        $this->_frozen = true;
    }

    private function assertNotFrozen(): void
    {
        if ($this->_frozen) {
            throw new IllegalStateException("Conventions has been frozen after documentStore.initialize() and no changes can be applied to them");
        }
    }

    public function setSecondBroadcastAttemptTimeout(int $secondBroadcastAttemptTimeout): void
    {
        $this->assertNotFrozen();
        $this->_secondBroadcastAttemptTimeout = $secondBroadcastAttemptTimeout;
    }

    public function getSecondBroadcastAttemptTimeout(): int
    {
        return $this->_secondBroadcastAttemptTimeout;
    }

    public function getFirstBroadcastAttemptTimeout(): int
    {
        return $this->_firstBroadcastAttemptTimeout;
    }

    public function setFirstBroadcastAttemptTimeout(int $firstBroadcastAttemptTimeout): void
    {
        $this->assertNotFrozen();
        $this->_firstBroadcastAttemptTimeout = $firstBroadcastAttemptTimeout;
    }

}