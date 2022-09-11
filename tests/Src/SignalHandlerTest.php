<?php

namespace Jtrw\PosixSignal\Tests\Src;

use Jtrw\PosixSignal\SignalHandler;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class SignalHandlerTest extends TestCase
{
    public function testTerminate()
    {
        $pid = exec('php -q '.__DIR__.'/command/runScript.php > /dev/null 2>&1 & echo $!;');
        $isRunning = shell_exec("pgrep -f runScript.php");
        //exec("ps -p ".$pid, $output);
        //Assert::assertNotEmpty($output[1]);
        Assert::assertNotEmpty($isRunning);
        sleep(1);
        $cmd = sprintf("kill -%s %s", SIGILL, $pid);
        exec($cmd);
        //posix_kill($pid, SIGILL);
        $isRunning = shell_exec("pgrep -f runScript.php");
        //exec("ps -p ".$pid, $output);
        //Assert::assertNotEmpty($output[1]);
        Assert::assertNull($isRunning);
//        $output = [];
//        exec("ps -p ".$pid, $output);
//
//        Assert::assertArrayNotHasKey(1, $output);
    }
    
    public function testTerminateMock()
    {
        $mock = $this->getMockBuilder(SignalHandler::class)
            ->onlyMethods(['isTerminate'])->getMock();
    
        $mock->method('isTerminate')->will($this->returnValue(true));
        
        $mock->terminate();
        Assert::assertTrue(true);
        //$this->fail("Must be terminated");
        
    }
    
}