<?php declare(strict_types = 1);

namespace Murdej\LatteStaticGenerator;

use Murdej\LatteStaticGenerator\Plugins\IPlugin;
use Nette\Neon\Neon;

class ProjectParser
{
	public function parseNeonFile(string $filename): Project
	{
		$project = new Project();
		$neonConfig = Neon::decodeFile($filename);

		foreach($neonConfig as $key => $section) {
			switch($key) {
				case 'defaults':
					$project->defaults = TaskConfig::parse($section);
					break;
				case 'plugins':
					$this->parsePlugin($section, $project);
					break;
				default:
					$project->tasks[] = TaskConfig::parse($section);
					break;
			}
		}

		return $project;
	}

	public function parsePlugin(array $src, Project $project)
	{
		$className = null;
		$constructorParams = [];
		$props = [];
		/** @var IPlugin */
		$plugin = null;
		foreach($src as $k => $nPlugin) {
			if (is_string($k)) {
				$className = $k;
			} else {
				if ($nPlugin instanceof \Nette\Neon\Entity)
				{
					$className = $nPlugin->value;
					$constructorParams = $nPlugin->attributes;
				} 
				else if (is_string($nPlugin)) 
				{
					$className = $nPlugin;
				}
				else foreach($nPlugin as $pk => $pv) 
				{
					if (is_int($pk)) $constructorParams[] = $pv;
					else $props[$pk] = $pv;
				}
			}
			$newPlugin = new $className(...$constructorParams);
			foreach($props as $propK => $propV)
				$newPlugin->$propK = $propV;

			
			if ($plugin) $plugin->setNextHandler($newPlugin);
			else $project->plugins = $newPlugin;
			$plugin = $newPlugin;
		}

	}
}
