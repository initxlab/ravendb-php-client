<?php
namespace RavenDB\Client\Primitives;

interface CleanCloseable extends Closable
{
    public function close(\Exception $e);
}