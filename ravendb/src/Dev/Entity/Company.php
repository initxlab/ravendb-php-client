<?php
namespace RavenDB\Dev\Entity;
use RavenDB\Dev\Annotation\MyAnnotation;
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