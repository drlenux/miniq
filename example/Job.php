<?php

class Job extends \olbie\MiniQ\Task
{
	public function __construct(
		private int $needStep,
		private int $currentStep = 0
	)
	{
	}


	public function run(): bool
	{
		$this->currentStep++;
		if ($this->currentStep < $this->needStep)
			throw new Exception("{$this->currentStep} < {$this->needStep}");

		var_dump($this->errors);
		return true;
	}

	public function isAllowRestart(): bool
	{
		return true;
	}
}
