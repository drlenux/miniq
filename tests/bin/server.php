<?php

ini_set('memory_limit', '4G');

require_once __DIR__ . '/../../vendor/autoload.php';

use olbie\MiniQ\MiniQ;

$miniQ = new MiniQ(__DIR__ . '/../socket');
$server = $miniQ->createServer();
$server->start();
