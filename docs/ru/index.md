# MiniQ

MiniQ — это минималистичная библиотека PHP, предназначенная для управления очередями, использующая сокеты для межпроцессного взаимодействия. Она предоставляет простой способ управления очередями задач и их обработки с помощью рабочих процессов. MiniQ построена на компонентах ReactPHP, что делает её подходящей для асинхронных приложений PHP.

## Особенности

- Простое и легковесное управление очередями.
- Использование Unix сокетов для связи.
- Легкая интеграция с циклом событий ReactPHP.
- Поддержка асинхронной обработки задач.

## Установка

Вы можете установить MiniQ с помощью Composer. Выполните следующую команду в директории вашего проекта:

```bash
composer require olbie/miniq
```

## Требования

- PHP 8.1 или новее
- Composer для управления зависимостями

## Использование

### Настройка сервера

Создайте сервер для управления вашими задачами:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use olbie\MiniQ\MiniQ;

$miniQ = new MiniQ(__DIR__);
$server = $miniQ->createServer();
$server->start();
```

### Настройка рабочего процесса

Настройте рабочий процесс для обработки задач:

```php
<?php

use olbie\MiniQ\MiniQ;
use React\EventLoop\Loop;

require_once __DIR__ . '/vendor/autoload.php';

$miniQ = new MiniQ(__DIR__);
$worker = $miniQ->createWorkerServer();
$worker->run();
```

### Использование клиента

Добавьте задачи в очередь с помощью клиента:

```php
<?php

use olbie\MiniQ\MiniQ;
use src\Job;

require_once __DIR__ . '/vendor/autoload.php';

$totalTask = 25;
$miniQ = new MiniQ(__DIR__);
$client = $miniQ->createClient();

for ($i = 0; $i < $totalTask; $i++) {
    $client->set(new Job(rand(1, 10)));
}
```

## Лицензия

GPL-3.0-or-later. Смотрите файл LICENSE для получения дополнительной информации.

## Участие

Вклад приветствуется! 

## Контакты

По вопросам или отзывам, пожалуйста, свяжитесь с Олексием Белокудренко по адресу oleksii.bielokudrenko@gmail.com.