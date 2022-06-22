<?php declare(strict_types=1);

namespace Murdej\LatteStaticGenerator;

use Nette\Utils\Strings;

class Generator 
{

	protected \Latte\Engine $latte;

	public function __construct(
		protected $tempDir
	)
	{
		$this->latte = new \Latte\Engine;
		$this->latte->setTempDirectory($this->tempDir);
	}
	
	public function processTask(TaskConfig $taskConfig)
	{
		$output = $this->latte->renderToString($taskConfig->sourceFile, $taskConfig->data);
		$destinationFile = Strings::endsWith($taskConfig->destination, '/')
			? $taskConfig->destination . basename($taskConfig->sourceFile, '.latte') . '.html'
			: $taskConfig->destination;
		file_put_contents($destinationFile, $output);
	}

	public function process($tasks)
	{
		
	}
}
