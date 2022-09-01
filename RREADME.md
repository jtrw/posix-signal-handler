# Posix Signal Handler

First of all it is necessary for some scripts that work like php process in the background our system.
For example queue or workers that run through cron, and working in operation memory full time like demons.
Sometimes you need to terminate some php process like this `kill -9 pid`
because you should restart scripts now, and you can have some problem.
If you terminate process now, you don't know place where you program break off.

