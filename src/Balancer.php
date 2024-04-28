<?php

namespace olbie\MiniQ;

use Exception;
use React\EventLoop\Loop;
use React\Socket\ConnectionInterface;
use React\Socket\UnixConnector;
use React\Socket\UnixServer;
use React\Stream\DuplexStreamInterface;

class Balancer implements BalancerInterface
{
	/** @var ServerInterface[] */
	private array $servers = [];

	/** @var string[] */
	private array $socks = [];

	public function __construct(
		private readonly string $socketPath
	)
	{
	}

	public function addServer(?string $path = null): BalancerInterface
	{
		if (!$path) $path = $this->socketPath . '/server_' . count($this->servers) . '.sock';

		$this->servers[] = new SocketServer($path);
		$this->socks[] = $path;
		return $this;
	}

	public function run(): void
	{
		foreach ($this->servers as $server)
			$this->fork($server);

		$this->initialize();
	}

	private function fork(ServerInterface $server)
	{
		$pid = pcntl_fork();
		if ($pid == -1) {
			die('Не удалось создать процесс');
		} elseif ($pid) {
			return $pid;
		} else {
			$server->start();
			exit;
		}
	}

	private function initialize() {
		$path = $this->socketPath . '/balancer.sock';
		if (file_exists($path))
			unlink($path);

		$server = new UnixServer($path, Loop::get());

		$server->on('connection', function (DuplexStreamInterface $connection) use (&$currentBackend) {
			$backend_id = array_rand($this->socks);
			$backendPath = $this->socks[$backend_id];

			$connector = new UnixConnector(Loop::get());
			$connector->connect($backendPath)->then(function (DuplexStreamInterface $backendConnection) use ($connection) {
				// Перенаправление данных от клиента к серверу
				$connection->pipe($backendConnection)->on('data', function ($data) use ($backendConnection) {
					$backendConnection->write($data);
					echo '<';
				});

				// Перенаправление данных от сервера к клиенту
				$backendConnection->pipe($connection)->on('data', function ($data) use ($connection) {
					$connection->write($data);
					echo '>';
				});

				// Обработка закрытия соединений
				$connection->on('close', function () use ($backendConnection) {
					$backendConnection->close();
					echo '.';
				});
				$backendConnection->on('close', function () use ($connection) {
					$connection->close();
					echo ';';
				});

			}, function (Exception $e) {
				echo "Failed to connect to backend: " . $e->getMessage() . "\n";
			});
		});
		Loop::run();
	}
}