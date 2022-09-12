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
        Assert::assertNotEmpty($isRunning);
        sleep(1);
        $cmd = sprintf("kill -%s %s", SIGILL, $pid);
        exec($cmd);
        $isRunning = shell_exec("pgrep -f runScript.php");
        Assert::assertNull($isRunning);
    }
    
    public function testTerminateMock()
    {
        $mock = $this->getMockBuilder(SignalHandler::class)
            ->onlyMethods(['isTerminate'])->getMock();
    
        $mock->method('isTerminate')->will($this->returnValue(true));
        
        $mock->terminate();
        Assert::assertTrue(true);
        
    }
    
}