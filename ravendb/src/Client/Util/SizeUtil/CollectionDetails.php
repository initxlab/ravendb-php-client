<?php
namespace RavenDB\Client\Util\SizeUtil;

interface CollectionDetails
{
    public function getName():string;
    public function getCountDocuments():int;
    public function getSize(): int;
}