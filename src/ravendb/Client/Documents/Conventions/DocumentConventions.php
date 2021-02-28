<?php
namespace RavenDB\Client\Documents\Conventions;

class DocumentConventions
{

    public final static function defaultConventions(): DocumentConventions
    {
        return new DocumentConventions();
    }

    public final static function defaultForServerConventions(): DocumentConventions
    {
        return new DocumentConventions();
    }

}