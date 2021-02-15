<?php
namespace RavenDB\Entity;
use RavenDB\Annotation\MyAnnotation;
class Company
{
    /**
     * @MyAnnotation(myProperty="CompanyTypeFormating")
     */
    private $dataFormat;

    public function __construct(string $data)
    {
    }
}