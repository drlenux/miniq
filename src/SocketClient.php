<?php

namespace olbie\MiniQ;

use React\EventLoop\Loop;
use React\Promise\PromiseInterface;
use React\Socket\Connection;
use React\Socket\ConnectionInterface;
use React\Socket\UnixConnector;

class SocketClient implements ClientInterface
{
	private UnixConnector $connector;

	public function __construct(
		private string $socketPath
	)
	{
		$this->connector = new UnixConnector(Loop::get());
	}

	public function send(string $message, callable $callback = null, bool $isLoopRunning = false): void
	{
		$this->connector->connect($this->socketPath)->then(function (ConnectionInterface $connection) use ($message, $callback) {
			$connection->write($message);
			if (!$callback) return $connection->end();
			$connection->on('data', function ($data) use ($connection, $callback) {
				if ($callback) $callback($data);
				$connection->end();
			});
		});
		if ($isLoopRunning) return;
		Loop::run();
	}

	public function set(Task $task, bool $isLoopRunning = false): void
	{
		$this->send(serialize($task), null, $isLoopRunning);
	}

	public function get(callable $callback, bool $isLoopRunning = false): void
	{
		$this->send(SocketServer::TXT_FOR_READ_DATA, $callback, $isLoopRunning);
	}
}
