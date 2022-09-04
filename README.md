# Posix Signal Handler

First of all it is necessary for some scripts that work like php process in the background our system.
For example queue or workers that run through cron, and working in operation memory full time like demons.
Sometimes you need to terminate some php process like this `kill -9 pid`
because you should restart scripts now, and you can have some problem.
If you terminate process now, you don't know place where you program break off.
Special for this you can use soft kill `kill -SIGTERM pid`
In your code yous should integrate this library
For Example:

```php
declare(ticks = 1);

require_once __DIR__."/../vendor/autoload.php";
$signal = new \Jtrw\PosixSignal\SignalHandler();

while (true) {
    $this->doSomething(); //Your Business logic
    $signal->terminate();
}
```

When our code get signal like `SIGTERM` it process code to end and soft finish our script
