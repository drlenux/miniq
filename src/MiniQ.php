<?php

namespace olbie\MiniQ;

class MiniQ
{
	private string $dirForSock;
	public const SOCK_FILE_NAME = 'miniq.sock';

	public function __construct(?string $dirForSock = null)
	{
		if (!$dirForSock) $dirForSock = sys_get_temp_dir();
		if (!is_dir($dirForSock) && !mkdir($dirForSock)) throw new \Exception('Bad path for socket');
		$this->dirForSock = $dirForSock;
	}

	public function createServer(): ServerInterface
	{
		return new SocketServer($this->dirForSock . '/' . self::SOCK_FILE_NAME);
	}

	public function createClient(): ClientInterface
	{
		return new SocketClient($this->dirForSock . '/' . self::SOCK_FILE_NAME);
	}

	public function createWorkerServer(float $delay = 0.1): WorkerServerInterface
	{
		return new WorkerServer($this->createClient(), $delay);
	}

	public function createBalancer(): BalancerInterface
	{
		return new Balancer($this->dirForSock);
	}
}