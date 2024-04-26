# MiniQ

MiniQ is a minimalist PHP library designed for queue management, utilizing sockets for inter-process communication. It offers a simple way to manage task queues and process them with workers. MiniQ is built on ReactPHP components, making it suitable for asynchronous PHP applications.

## Features

- Simple and lightweight queue management.
- Uses Unix sockets for communication.
- Easily integrates with the ReactPHP event loop.
- Supports asynchronous task handling.

## Translate

- [russian](./docs/ru/index.md)
- Ukraine (in progress)

## Installation

You can install MiniQ using Composer. Run the following command in your project directory:

```bash
composer require olbie/miniq
```

## Requirements

- **PHP 8.1** or newer
- **Composer** for dependency management

## Usage

### Server Setup

Create a server to manage your tasks:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use olbie\MiniQ\MiniQ;

$miniQ = new MiniQ(__DIR__);
$server = $miniQ->createServer();
$server->start();
```

### Worker Setup

Set up a worker to process tasks:

```php
<?php

use olbie\MiniQ\MiniQ;
use React\EventLoop\Loop;

require_once __DIR__ . '/vendor/autoload.php';

$miniQ = new MiniQ(__DIR__);
$worker = $miniQ->createWorkerServer();
$worker->run();
```

### Client Usage
Add tasks to the queue using a client:

```php
<?php

use olbie\MiniQ\MiniQ;
use olbie\MiniQ\Job;

require_once __DIR__ . '/vendor/autoload.php';

$totalTask = 25;
$miniQ = new MiniQ(__DIR__);
$client = the miniQ->createClient();

for ($i = 0; $i < $totalTask; $i++) {
    $client->set(new Job(rand(1, 10)));
}
```

## License

GPL-3.0-or-later. See the [LICENSE](./LICENSE.TXT) file for more details.

## Contributing

Contributions are welcome!

## Contact

For questions or feedback, please contact Oleksii Bielokudrenko at oleksii.bielokudrenko@gmail.com.
