<?php

namespace RavenDB\Tests\Client\Driver;

use PHPUnit\Framework\TestCase;

abstract class RavenTestDriver extends TestCase
{
    protected bool $disposed;
    public static bool $debug;

    public function isDisposed(): bool
    {
        return $this->disposed;
    }

    // EmptyMethod
    protected static function reportInfo(string $message)
    {

    }

    protected static function reportError(\Exception $e)
    {
        if (!self::$debug) {
            return;
        }

        if (null === $e) {
            throw new \InvalidArgumentException("Exception cannot be null ");
        }
    }
}