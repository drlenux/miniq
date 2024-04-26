<?php

namespace olbie\MiniQ;

use React\EventLoop\Loop;
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

	public function send(string $message, callable $callback = null): void
	{
		$this->connector->connect($this->socketPath)->then(function (ConnectionInterface $connection) use ($message, $callback) {
			$connection->write($message);
			$connection->on('data', function ($data) use ($connection, $callback) {
				if ($callback) $callback($data);
				$connection->end();
			});
		});
	}

	public function set(Task $task): void
	{
		$this->send(serialize($task));
	}

	public function get(callable $callback): void
	{
		$this->send(SocketServer::TXT_FOR_READ_DATA, $callback);
	}
}
