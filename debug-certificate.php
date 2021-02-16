<?php
require __DIR__ . '/vendor/autoload.php';
use RavenDB\Dev\PlaceHolder\Buffer;
use RavenDB\Migration\Auth\Certificate;
$certString = "Certificate from String";
$certBuffer = new Buffer();
$debugFromString = (new Certificate($certString))->getCertificate();
$debugFromBuffer = (new Certificate($certBuffer))->getCertificate();
echo PHP_EOL;
echo $debugFromString;
echo PHP_EOL;
echo "Certificate as instance of ".get_class($debugFromBuffer);



