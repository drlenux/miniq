<?php

use olbie\MiniQ\MiniQ;
use React\EventLoop\Loop;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Job.php';

$miniQ = new MiniQ(__DIR__);
$worker = $miniQ->createWorkerServer();

$worker->run();
