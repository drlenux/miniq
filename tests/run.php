<?php

ini_set('memory_limit', '4G');

require_once __DIR__ . '/../vendor/autoload.php';

@mkdir(__DIR__ . '/runtime');
@mkdir(__DIR__ . '/socket');

function runScript($script) {
	$pid = pcntl_fork();
	if ($pid == -1) {
		die('Не удалось создать процесс');
	} elseif ($pid) {
		return $pid;
	} else {
		pcntl_exec('/opt/homebrew/bin/php', [$script]);
		exit;
	}
}

//runScript(__DIR__ . '/bin/server.php');
//sleep(1);

for ($i = 0; $i < 10; $i++) {
	runScript(__DIR__ . '/bin/client1.php');
	runScript(__DIR__ . '/bin/client2.php');
}

for ($i = 0; $i < 10; $i++) {
	runScript(__DIR__ . '/bin/worker.php');
}

$miniQ = new \olbie\MiniQ\MiniQ(__DIR__ . '/socket');
$client = $miniQ->createClient();

\React\EventLoop\Loop::addPeriodicTimer(1, function () use ($client) {
	$client->send(\olbie\MiniQ\SocketServer::TXT_FOR_GET_COUNT_IN_QUEUE, function ($res) {
		echo PHP_EOL . $res . PHP_EOL;
	}, true);
});

\React\EventLoop\Loop::run();
// Ждём завершения всех дочерних процессов
while (pcntl_waitpid(0, $status) != -1) {
	$exitStatus = pcntl_wexitstatus($status);
	echo "Процесс завершился со статусом $exitStatus\n";
}

