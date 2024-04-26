<?php

require_once __DIR__ . '/../vendor/autoload.php';

use olbie\MiniQ\MiniQ;

$miniQ = new MiniQ(__DIR__);
$server = $miniQ->createServer();
$server->start();
