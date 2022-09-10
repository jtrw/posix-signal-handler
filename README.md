# Posix Signal Handler

[![Phpunit](https://github.com/jtrw/posix-signal-handler/workflows/Phpunit/badge.svg)](https://github.com/jtrw/posix-signal-handler/actions)
[![codecov](https://codecov.io/gh/jtrw/posix-signal-handler/branch/master/graph/badge.svg?token=P4BT6K8IXF)](https://codecov.io/gh/jtrw/posix-signal-handler)
[![Latest Stable Version](http://poser.pugx.org/jtrw/posix-signal-handler/v)](https://packagist.org/packages/jtrw/posix-signal-handler)
[![Total Downloads](http://poser.pugx.org/jtrw/posix-signal-handler/downloads)](https://packagist.org/packages/jtrw/posix-signal-handler)
[![Latest Unstable Version](http://poser.pugx.org/jtrw/posix-signal-handler/v/unstable)](https://packagist.org/packages/jtrw/posix-signal-handler)
[![License](http://poser.pugx.org/jtrw/posix-signal-handler/license)](https://packagist.org/packages/jtrw/posix-signal-handler)
[![PHP Version Require](http://poser.pugx.org/jtrw/posix-signal-handler/require/php)](https://packagist.org/packages/jtrw/posix-signal-handler)

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

When our code get signal like `SIGTERM`, `SIGINT`, `SIGTSTP`, `SIGTERM`, `SIGHUP`, `SIGILL`
it process your code to logic end, and soft finish your script.
