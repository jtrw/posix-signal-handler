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
        Assert::assertNotEmpty($output[1]);
        
        posix_kill($pid, SIGILL);
        $output = [];
        exec("ps -p ".$pid, $output);
        Assert::assertArrayNotHasKey(1, $output);
    }
    
}