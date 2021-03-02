<?php

namespace RavenDB\Client\Http;

use Exception;
use http\Exception\RuntimeException;
use RavenDB\Client\Exceptions\IllegalStateException;
use function PHPUnit\Framework\isEmpty;

abstract class RavenCommand
{
    protected $resultClass;
    protected int $statusCode;
    protected $responseType;
    protected int $timeout;
    protected bool $canCache;
    protected bool $canCacheAggressively;
    protected string $selectedNodeTag;
    protected int $numberOfAttempts;
    public const CLIENT_VERSION = "5.0.0";
    protected mixed $result;
    public $failoverTopologyEtag = -2;

    public abstract function isReadRequest(): bool;

    public abstract function createRequest(ServerNode $node, &$url);

    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseType(): RavenCommandResponseType
    {
        return $this->responseType;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult(mixed $result): void
    {
        $this->result = $result;
    }

    public function canCache(): bool
    {
        return $this->canCache;
    }

    public function canCacheAggressively(): bool
    {
        return $this->canCacheAggressively;
    }

    public function getSelectedNodeTag(): string
    {
        return $this->selectedNodeTag;
    }

    public function getNumberOfAttempts(): int
    {
        return $this->numberOfAttempts;
    }

    public function setNumberOfAttempts(int $numberOfAttempts): void
    {
        $this->numberOfAttempts = $numberOfAttempts;
    }

    protected static function throwInvalidResponse(?Exception $cause = null): void
    {
        if (null === $cause) {
            throw new IllegalStateException("Response is invalid");
        }

        throw new IllegalStateException("Response is invalid: " . $cause->getMessage());
    }

    public function setResponse(string $response, bool $fromCache)
    {

        if ($this->responseType == RavenCommandResponseType::EMPTY || $this->responseType == RavenCommandResponseType::RAW) {
            $this->throwInvalidResponse();
        }

        throw new Exception(" command must override the setResponse method which expects response with the following type: ");
    }


    protected function RavenCommand($resultClass): void
    {
        $this->resultClass = $resultClass;
        $this->responseType = RavenCommandResponseType::OBJECT;
        $this->canCache = true;
        $this->canCacheAggressively = true;
    }

    protected function urlEncode(string $value): string
    {
        try {
            return utf8_encode($value);
        } catch (UnsupportedEncodingException $e) {
            throw new RuntimeException($e);
        }
    }

    public static function ensureIsNotNullOrString(string $value, string $name): void
    {
        if (isEmpty($value)) {
            throw new Exception($name . " cannot be null or empty");
        }
    }
}

