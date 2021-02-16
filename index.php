<?php
require __DIR__ . '/vendor/autoload.php';
use RavenDB\Dev\Entity\Address;
use RavenDB\Dev\Entity\Company;
use RavenDB\Dev\Annotation\Registry\Registry;

$company = new Company('{}');
try {
    $companyFormatScope = new Registry($company);
    echo $companyFormatScope->getFormatScope().PHP_EOL;
} catch (ReflectionException $e) {
    // RAVENDB-TASK: implement exception message
}
$address = new Address('{}');
try {
    $addressFormatScope = new Registry($address);
   echo $addressFormatScope->getFormatScope();
} catch (ReflectionException $e) {
    // RAVENDB-TASK: implement exception message
}

