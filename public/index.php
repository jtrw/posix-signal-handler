<?php

include_once __DIR__.'/../vendor/autoload.php';
$signal = new Signal();

$k = 10000;
while (true) {
    echo $k."\n";
    sleep(1);
    $k++;
    $signal->terminate();
}