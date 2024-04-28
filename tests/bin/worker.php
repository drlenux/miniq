<?php

ini_set('memory_limit', '4G');

use olbie\MiniQ\MiniQ;

require_once __DIR__ . '/../../vendor/autoload.php';

$miniQ = new MiniQ(__DIR__ . '/../socket');
$worker = $miniQ->createWorkerServer(0.02);

$worker->run();
