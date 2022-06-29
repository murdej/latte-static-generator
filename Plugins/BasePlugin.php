<?php declare(strict_types = 1);

namespace Murdej\LatteStaticGenerator\Plugins;

abstract class BasePlugin implements IPlugin
{
	protected ?IPlugin $nextPlugin = null;

	public abstract function handlePre(PluginEvent $event): void;
	
	public abstract function handlePost(PluginEvent $event): void;

	function setNextHandler(IPlugin $nextPlugin)
	{
		$this->nextPlugin = $nextPlugin;
	}

}
