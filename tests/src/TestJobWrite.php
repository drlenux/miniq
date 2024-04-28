<?php

namespace tests\src;

use olbie\MiniQ\Task;

class TestJobWrite extends Task
{
	public function __construct(
		private readonly string $path
	)
	{
	}

	public function run(): bool
	{
		if (!file_exists($this->path)) return false;

		$f = fopen($this->path, 'w');

		if (!flock($f, LOCK_EX)) return false;
		ftruncate($f, 0);
		fwrite($f, getmypid());
		fflush($f);
		flock($f, LOCK_UN);
		fclose($f);
		return true;
	}

	public function isAllowRestart(): bool
	{
		return true;
	}
}