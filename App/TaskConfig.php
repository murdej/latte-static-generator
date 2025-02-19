<?php declare(strict_types=1);

namespace Murdej\LatteStaticGenerator;

use Nette\Utils\Strings;

class TaskConfig 
{
	public ?string $sourceFile = null;

	public ?string $destination = null;

	public string $sourcePath = '';

	public string $sourceNameWithExt = '';

	public string $sourceExt = '';

	public string $sourceNameNoExt = '';

	public array $data = [];

	public function update(TaskConfig $taskConfig)
	{
		if ($taskConfig->sourceFile) $this->sourceFile = $taskConfig->sourceFile;
		if ($taskConfig->destination) $this->destination = $taskConfig->destination;
		if ($taskConfig->sourcePath) $this->sourcePath = $taskConfig->sourcePath;
		if ($taskConfig->sourceNameWithExt) $this->sourceNameWithExt = $taskConfig->sourceNameWithExt;
		if ($taskConfig->sourceExt) $this->sourceExt = $taskConfig->sourceExt;
		if ($taskConfig->sourceNameNoExt) $this->sourceNameNoExt = $taskConfig->sourceNameNoExt;

		foreach($taskConfig->data as $k => $v) $this->data[$k] = $v;
	}

	public static function parse(array|string $src): TaskConfig
	{
		$task = new TaskConfig();
		if (is_string($src))
		{
			$task->sourceFile = $src;
		}
		else
		{
			foreach($src as $k => $v) {
				if ($k === 'data') $v = $v ?: [];
				$task->$k = $v;
			}
		}
		if ($task->sourceFile) {
			$pi = pathinfo($task->sourceFile);
			
			$task->sourcePath = $pi['dirname'];
			$task->sourceNameWithExt = $pi['basename'];
			$task->sourceExt = $pi['extension'] ?? '';
			$task->sourceNameNoExt = $pi['filename'];
		}

		/* $bname = Strings::endsWith($task->destination, '/')
			? basename($task->sourceFile)
			: basename($task->destination);
		$p = strrpos($task->sourceFile, '.');
		$task->sourceExt = ;
		$task->sourceBaseName = ;
		$task
		$task->destinationFileName = Strings::endsWith($task->destination, '/')
			? basename($task->sourceFile, '.latte') . '.html'
			: ''; */


		return $task;
	}
}
