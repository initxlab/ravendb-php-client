<?php
namespace RavenDB\Dev\Entity;
use RavenDB\Dev\Annotation\MyAnnotation;
class Address
{
    /**
     * @MyAnnotation(myProperty="AddressTypeFormating")
     */
    private $dataFormat;

    public function __construct(string $data)
    {
    }
}