<?php

namespace RavenDB\Client\Documents\Operations\Configuration;

use RavenDB\Client\Http\LoadBalanceBehavior;
use RavenDB\Client\Http\ReadBalanceBehavior;

class ClientConfiguration
{
    private string $identityPartsSeparator;
    private int $etag;
    private bool $disabled;
    private int $maxNumberOfRequestsPerSession;
    private ReadBalanceBehavior $readBalanceBehavior;
    private LoadBalanceBehavior $loadBalanceBehavior;
    private int $loadBalancerContextSeed;

    public function getEtag(): int
    {
        return $this->etag;
    }

    public function setEtag($etag): void
    {
        $this->etag = $etag;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled)
    {
        $this->disabled = $disabled;
    }

    public function getMaxNumberOfRequestsPerSession(): int
    {
        return $this->maxNumberOfRequestsPerSession;
    }

    public function setMaxNumberOfRequestsPerSession($maxNumberOfRequestsPerSession): void
    {
        $this->maxNumberOfRequestsPerSession = $maxNumberOfRequestsPerSession;
    }

    public function getReadBalanceBehavior(): ReadBalanceBehavior
    {
        return $this->readBalanceBehavior;
    }

    public function setReadBalanceBehavior(ReadBalanceBehavior $readBalanceBehavior): void
    {
        $this->readBalanceBehavior = $readBalanceBehavior;
    }

    public function getLoadBalanceBehavior(): LoadBalanceBehavior
    {
        return $this->loadBalanceBehavior;
    }

    public function setLoadBalanceBehavior(LoadBalanceBehavior $loadBalanceBehavior): void
    {
        $this->loadBalanceBehavior = $loadBalanceBehavior;
    }

    public function getIdentityPartsSeparator(): string
    {
        return $this->identityPartsSeparator;
    }

    public function setIdentityPartsSeparator(string $identityPartsSeparator): void
    {
        if (null !== $this->identityPartsSeparator && '|' == $this->identityPartsSeparator) {
            throw new \Exception("Cannot set identity parts separator to '|'");
        }

        $this->identityPartsSeparator = $identityPartsSeparator;
    }

    public function getLoadBalancerContextSeed(): int
    {
        return $this->loadBalancerContextSeed;
    }

    public function setLoadBalancerContextSeed(int $loadBalancerContextSeed): void
    {
        $this->loadBalancerContextSeed = $loadBalancerContextSeed;
    }
}