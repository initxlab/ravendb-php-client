<?php

namespace RavenDB\Client\Documents\Session\Loaders;

interface ILoaderWithInclude
{
    public function include(string $path): ILoaderWithInclude;
}