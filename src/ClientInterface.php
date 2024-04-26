<?php

namespace olbie\MiniQ;

interface ClientInterface
{
	public function send(string $message, callable $callback = null): void;
	public function set(Task $task): void;
	public function get(callable $callback): void;
}