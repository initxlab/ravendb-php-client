<?php
require __DIR__ . '/vendor/autoload.php';


function hexTo32Float($strHex) {
    $v = hexdec($strHex);
    $x = ($v & ((1 << 23) - 1)) + (1 << 23) * ($v >> 31 | 1);
    $exp = ($v >> 23 & 0xFF) - 127;
    return $x * pow(2, $exp - 23);
}
$float = hexdec("0.025d") ;
echo $float;