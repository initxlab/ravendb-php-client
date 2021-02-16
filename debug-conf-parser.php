<?php
use RavenDB\Dev\Toolkit\Parser;

require __DIR__ . '/vendor/autoload.php';
$parser = new Parser('ravendb.exceptions.json');

$toObject = $parser->toObject();

/*var_dump($parser->loopObject($toObject->exceptions));*/
$parser->exceptionsGenerator($toObject->exceptions,'Exceptions');
