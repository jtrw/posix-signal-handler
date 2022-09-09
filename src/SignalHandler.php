<?php

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
    
    /**
     *
     */
    public function __construct()
    {
        $this->registered();
    }
    
    /**
     * @return void
     */
    public function terminate()
    {
        if ($this->isTerminate()) {
            $this->finish();
        }
    }
    
    /**
     * @return bool
     */
    protected function isTerminate(): bool
    {
        return $this->isTerminate;
    }
    
    /**
     * @return void
     */
    private function finish(): void
    {
        $this->sendSignal(SIGKILL);
    }
    
    /**
     * @param  int $signal
     * @return void
     */
    protected function sendSignal(int $signal)
    {
        posix_kill($this->getPid(), $signal);
    }
    
    /**
     * @return void
     */
    private function registered()
    {
        pcntl_async_signals(true);
        
        $this->registeredTerminatedSignals();
        $this->registeredUserSignals();
    }
    
    /**
     * @return void
     */
    private function registeredTerminatedSignals(): void
    {
        foreach (static::SIGNALS_TERMINATED as $signal) {
            pcntl_signal($signal, [$this, static::HANDLER_DEFAULT]);
        }
    }
    
    /**
     * @return void
     */
    private function registeredUserSignals(): void
    {
        foreach (static::USER_SIGNALS as $signal) {
            pcntl_signal($signal, [$this, static::HANDLER_DEFAULT]);
        }
    }
    
    /**
     * @param  int $sigNumber
     * @return void
     */
    public function handle(int $sigNumber): void
    {
        if ($this->isTerminatedSignal($sigNumber)) {
            $this->isTerminate = true;
        }
    }
    
    /**
     * @param  int $signalNumber
     * @return bool
     */
    private function isTerminatedSignal(int $signalNumber): bool
    {
        return in_array($signalNumber, static::SIGNALS_TERMINATED, true);
    }
    
    /**
     * @return int
     */
    private function getPid(): int
    {
        return posix_getpid();
    }
}
