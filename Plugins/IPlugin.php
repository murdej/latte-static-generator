<?php declare(strict_types = 1);

namespace Murdej\LatteStaticGenerator\Plugins;

interface IPlugin
{
	function handlePre(PluginEvent $event): void;

	function handlePost(PluginEvent $event): void;

	function setNextHandler(IPlugin $nextPlugin);

}
