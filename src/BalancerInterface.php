<?php

namespace olbie\MiniQ;

interface BalancerInterface
{
	public function addServer(?string $path = null): BalancerInterface;
	public function run(): void;
}