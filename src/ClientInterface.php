<?php

namespace olbie\MiniQ;

interface ClientInterface
{
	public function send(string $message, callable $callback = null, bool $isLoopRunning = false): void;
	public function set(Task $task, bool $isLoopRunning = false): void;
	public function get(callable $callback, bool $isLoopRunning = false): void;
}