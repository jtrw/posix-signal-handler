<?php

namespace Jtrw\PosixSignal\Tests;

use Jtrw\PosixSignal\SignalHandler;

class TestScript
{
    private const DEFAULT_ITERATIONS = 1000;
    
    private SignalHandler $signalHandler;
    private int $iterations;
    
    public function __construct(int $iterations = self::DEFAULT_ITERATIONS)
    {
        $this->signalHandler = new SignalHandler();
        $this->iterations = $iterations;
    }
    public function run()
    {
        $k = 0;
        while ($k < $this->iterations) {
            echo $k."\n";
            $k++;
            $this->doSomeBusinessLogic();
            $this->signalHandler->terminate();
        }
    }
    
    public function doSomeBusinessLogic(): void
    {
        sleep(1);
    }
}

