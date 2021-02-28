<?php
namespace RavenDB\Client\Primitives;

interface Closable
{
    public function close(\Exception $e);
}