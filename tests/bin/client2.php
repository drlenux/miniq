<?php

ini_set('memory_limit', '4G');

use olbie\MiniQ\MiniQ;
use tests\src\TestJobCreate;
use tests\src\TestJobWrite;

require_once __DIR__ . '/../../vendor/autoload.php';

$totalTask = 1000;
$start = $totalTask * 10;

$miniQ = new MiniQ(__DIR__ . '/../socket');
$client = $miniQ->createClient();

for ($i = $start; $i < $start + $totalTask; $i++) {
	$path = __DIR__ . '/../runtime/' . $i . '.txt';
	$client->set(new TestJobCreate($path));
}
