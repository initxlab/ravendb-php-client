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

    protected static function killProcess(Process $p):void {
        if ($p != null && $p->isAlive()) {
            self::reportInfo("Kill global server");
            try {
                $p->destroyForcibly(); // do implement process
            } catch (Exception $e) {
                self::reportError($e);
            }
        }
    }

    //@SuppressWarnings("EmptyMethod")
    protected function setupDatabase(IDocumentStore $documentStore): void {
        // empty
    }
}
