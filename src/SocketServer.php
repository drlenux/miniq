<?php

namespace olbie\MiniQ;

use React\EventLoop\Loop;
use React\Socket\ConnectionInterface;
use React\Socket\UnixServer;

class SocketServer implements ServerInterface
{
	private array $queue = [];
	private UnixServer $server;
	public const TXT_FOR_READ_DATA = 'GET';
	public const TXT_FOR_NONE_DATA = 'NONE';

	public function __construct($socketPath)
	{
		if (file_exists($socketPath)) {
			unlink($socketPath);
		}
		$this->server = new UnixServer($socketPath, Loop::get());
		$this->initialize();
	}

	private function initialize() {
		$this->server->on('connection', function (ConnectionInterface $connection) {
			$connection->on('data', function (string $data) use ($connection) {
				$data = trim($data);
				if ($data === self::TXT_FOR_READ_DATA) {
					$task = array_shift($this->queue);
					$connection->write($task ?? self::TXT_FOR_NONE_DATA);
				} else {
					$this->queue[] = $data;
					$connection->write("Task added: $data");
				}
			});
		});
	}

	public function start(): void
	{
		Loop::run();
	}
}
