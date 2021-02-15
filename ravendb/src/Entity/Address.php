<?php
namespace RavenDB\Entity;
use RavenDB\Annotation\MyAnnotation;
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