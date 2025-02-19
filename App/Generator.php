<?php declare(strict_types=1);

namespace Murdej\LatteStaticGenerator;

use Murdej\LatteStaticGenerator\Plugins\IPlugin;
use Murdej\LatteStaticGenerator\Plugins\PluginEvent;
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
	
	public function processTask(TaskConfig $taskConfig, null|IPlugin $plugin)
	{
		// $this->latte->
		// print_r($taskConfig);
		$pluginEvent = new PluginEvent();
		$pluginEvent->task = $taskConfig;
		if ($plugin) $plugin->handlePre($pluginEvent);
		// print_r($taskConfig);
		$pluginEvent->output = $this->latte->renderToString(
			$taskConfig->sourceFile,
			array_merge(
				$taskConfig->data,
				['task' => $taskConfig]
			) 
		);
		if ($plugin) $plugin->handlePost($pluginEvent);
		$destination = Strings::endsWith($taskConfig->destination, '/')
			? $taskConfig->destination .= $taskConfig->sourceNameNoExt . '.html'
			: $taskConfig->destination;

		echo "DEST: $destination\n";
		file_put_contents($destination, $pluginEvent->output);
	}

	public function processProject(Project $project)
	{
		foreach($project->tasks as $task) {
			$nTask = clone $project->defaults;
			$nTask->update($task);
	
			$this->processTask($nTask, $project->plugins);
		}
	}
}
