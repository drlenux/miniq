<?php

namespace olbie\MiniQ;

use Throwable;

abstract class Task
{
	protected $errors = [];

	abstract public function run(): bool;
	abstract public function isAllowRestart(): bool;

	public function execute(): bool
	{
		try {
			$status = $this->run();
		} catch (Throwable $e) {
			$status = false;
			$this->errors[] = [
				'type' => $e::class,
				'file' => $e->getFile(),
				'line' => $e->getLine(),
				'message' => $e->getMessage(),
			];
		}

		return $status;
	}
}