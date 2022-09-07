<?php
//declare(ticks = 1);

namespace Jtrw\PosixSignal;

class SignalHandler
{
    private const SIGNALS_TERMINATED = [
        SIGINT,
        SIGTSTP,
        SIGTERM,
        SIGHUP,
        SIGILL
    ];
    
    private const USER_SIGNALS = [
        SIGUSR1,
        SIGUSR2
    ];
    
    private const HANDLER_DEFAULT = "handle";
    
    private bool $isTerminate = false;
    
    public function __construct()
    {
        $this->registered();
    }
    
    public function terminate()
    {
        if ($this->isTerminate()) {
            $this->finish();
        }
    }
    
    protected function isTerminate(): bool
    {
        return $this->isTerminate;
    }
    
    private function finish(): void
    {
        $this->sendSignal(SIGKILL);
    }
    
    protected function sendSignal(int $signal)
    {
        posix_kill($this->getPid(), $signal);
    }
    
    private function registered()
    {
        pcntl_async_signals(true);
        
        $this->registeredTerminatedSignals();
        $this->registeredUserSignals();
    }
    
    private function registeredTerminatedSignals(): void
    {
        foreach (static::SIGNALS_TERMINATED as $signal) {
            pcntl_signal($signal, [$this, static::HANDLER_DEFAULT]);
        }
    }
    
    private function registeredUserSignals(): void
    {
        foreach (static::USER_SIGNALS as $signal) {
            pcntl_signal($signal, [$this, static::HANDLER_DEFAULT]);
        }
    }
    
    public function handle(int $sigNumber): void
    {
        if ($this->isTerminatedSignal($sigNumber)) {
            $this->isTerminate = true;
        }
    }
    
    private function isTerminatedSignal(int $signalNumber): bool
    {
        return in_array($signalNumber, static::SIGNALS_TERMINATED, true);
    }
    
    private function getPid(): int
    {
        return posix_getpid();
    }
}
