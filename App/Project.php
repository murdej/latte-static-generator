<?php

namespace Murdej\LatteStaticGenerator;

use Murdej\LatteStaticGenerator\Plugins\IPlugin;
use Nette\SmartObject;

class Project
{
	use SmartObject;

	public TaskConfig $defaults;

	/** @var TaskConfig[] */
	public array $tasks = [];
	
	public IPlugin|null $plugins = null;
}