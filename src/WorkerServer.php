<?php

namespace olbie\MiniQ;

use React\EventLoop\Loop;

class WorkerServer implements WorkerServerInterface
{

	public function __construct(
		private readonly ClientInterface $client,
		private readonly float $delay = 0.1,
	)
	{
	}

	public function run(): void
	{
		Loop::addPeriodicTimer($this->delay, function () {
			$this->client->get(function (string $jobStr) {
				/** @var Task $job */
				if ($jobStr === SocketServer::TXT_FOR_NONE_DATA) return;
				$job = unserialize($jobStr);
				if ($job && !$job->execute() && $job->isAllowRestart()) {
					$this->client->set($job, true);
				}

			}, true);
		});
		Loop::run();
	}
}