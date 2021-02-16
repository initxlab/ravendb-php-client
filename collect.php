<?php
require __DIR__ . '/vendor/autoload.php';
use RavenDB\Component\Connector;
use RavenDB\Connector\CurlConnector;
use RavenDB\Entity\Address;
use RavenDB\Entity\Company;
use RavenDB\Annotation\Registry\Registry;
$config=[
    "url"=>"http://live-test.ravendb.net/databases?namesOnly=true",
    "user"=>"username",
    "password"=>"password"
];
$connector = new CurlConnector($config);
$curl = (new Connector($connector))->getConfig();
var_dump($connector->connect());
var_dump($connector->startSession());
var_dump($curl);

/// ANNOTATIONS ACCESS VIA REGISTRY
/**
 * GOAL : returning the format object type based on annotations bind to specific Entity/Object
 * Allow formation
 */

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

