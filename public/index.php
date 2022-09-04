<?php
//declare(ticks = 1);

require_once __DIR__."/../vendor/autoload.php";
$signal = new \Jtrw\PosixSignal\SignalHandler();

$k = 10000;
while (true) {
    echo $k."\n";
    sleep(1);
    $k++;
    $signal->terminate();
}