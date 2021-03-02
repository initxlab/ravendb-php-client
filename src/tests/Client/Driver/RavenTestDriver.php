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

    protected static function reportInfo(string $message)  // TODO: MIGRATION SOURCE IS EMPTY AS WELL
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

    protected static function killProcess(Process $p): void // TODO: IMPLEMENT PROCESS MANAGEMENT LIBRAIRY
    {

        if ($p != null && $p->isAlive()) {
            self::reportInfo("Kill global server");
            try {
                $p->destroyForcibly();
            } catch (Exception $e) {
                self::reportError($e);
            }
        }
    }

    //@SuppressWarnings("EmptyMethod")
    protected function setupDatabase(IDocumentStore $documentStore): void // TODO: MIGRATION SOURCE IS EMPTY AS WELL
    {
        // empty
    }
}
