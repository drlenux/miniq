<?php

use olbie\MiniQ\MiniQ;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Job.php';

$totalTask = 25;

$miniQ = new MiniQ(__DIR__);
$client = $miniQ->createClient();

for ($i = 0; $i < $totalTask; $i++)
	$client->set(new Job(rand(1, 10)));
