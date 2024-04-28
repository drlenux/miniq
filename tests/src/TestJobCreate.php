<?php

namespace tests\src;

use olbie\MiniQ\Task;

class TestJobCreate extends Task
{
	public function __construct(
		private readonly string $path
	)
	{
	}

	public function run(): bool
	{
		if (file_exists($this->path)) return false;
		return touch($this->path);
	}

	public function isAllowRestart(): bool
	{
		return false;
	}
}