# Process util

Process utility tools.

## Contents

 - `ProcessKillHandler` - Handles sending the signals (SIGTERM, SIGINT, SIGQUIT, SIGHUP) killing the process.
 - `MemoryUsageLimiter` - Limits memory peak usage of the running script to specified value.

## Installation

Add URL of the package to the `composer.json` file of your application

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/arturdoruch/process-util"
    }
]
```

and run the command

```sh
composer require arturdoruch/process-util
```
