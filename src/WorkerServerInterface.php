<?php

namespace olbie\MiniQ;

interface WorkerServerInterface
{
	public function run(): void;
}