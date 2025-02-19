<?php declare(strict_types = 1);

namespace Murdej\LatteStaticGenerator\Plugins;

class MarkdownPandoc extends BasePlugin
{
	public function __construct(
		public string $template = __DIR__ . '/MarkdownPandoc.template.latte',
		public string $variable = 'content',
		public string $cmd = 'pandoc',
		public bool $createToc = true,
	)
	{ }

	public function handlePre(PluginEvent $event): void
	{
		if (strtolower($event->task->sourceExt) === 'md') {

			// $descriptorspec = ;
			// var_dump([$this->cmd, $descriptorspec, $pipes]);
			$cmdParams = [];
			if ($this->createToc) $cmdParams[] = '--toc';
			$pipes = [];
			$process = proc_open(
				$this->cmd . ' ' . implode(' ', $cmdParams),
				[
					0 => [ "pipe", "r" ],  // stdin is a pipe that the child will read from
					1 => [ "pipe", "w" ],  // stdout is a pipe that the child will write to
					// 2 => null,
				], 
				$pipes
			);

			fwrite($pipes[0], file_get_contents($event->task->sourceFile));
			fclose($pipes[0]);

			$event->task->data[$this->variable] = stream_get_contents($pipes[1]);
			fclose($pipes[1]);

			$event->task->sourceFile = $this->template;
			$this->nextPlugin?->handlePre($event);
		}
	}

	public function handlePost(PluginEvent $event): void { }

}