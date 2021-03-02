<?php

namespace RavenDB\Client\Util;

use RavenDB\Client\Primitives\Closable;

interface IDisposalNotification extends Closable
{
    public function addAfterCloseListener(EventHandler $event): void;

    public function removeAfterCloseListener(EventHandler $event);

    public function isDisposed(): bool;

    public function close();
}
