<?php

namespace Jtrw\PosixSignal\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class SignalHandlerTest extends TestCase
{
    public function testTerminate()
    {
        $pid = exec('php -q '.__DIR__.'/command/runScript.php > /dev/null 2>&1 & echo $!;');
    
        exec("ps -p ".$pid, $output);
        print_r($output);
        Assert::assertNotEmpty($output[1]);
        sleep(1);
        $cmd = sprintf("kill -%s %s", SIGILL, $pid);
        exec($cmd);
        //posix_kill($pid, SIGILL);
        $output = [];
        exec("ps -p ".$pid, $output);
        print_r($output);
        Assert::assertArrayNotHasKey(1, $output);
    }
    
}