<?php
require __DIR__ . '/vendor/autoload.php';
use RavenDB\Migration\Exceptions\TimeoutException;
$expired = false;

function timeout($maxCount=4){
    if($maxCount > 4) throw new TimeoutException();
}

function pingNode($node){

}

try {
   timeout(4);
    echo "No timeout detected";
} catch (Exception $e) {
    echo $e->getMessage();
}