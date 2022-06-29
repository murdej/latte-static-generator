<?php

use Toolkit\PFlag\Flags;

class CliParserFactory 
{
	public function __construct(
		protected array $args,
	) { }

	function createCliParser(): Flags 
	{
		$flags = $this->args;
		$scriptFile = array_shift($flags);
		$fs = Flags::new();
		$fs->setScriptFile($scriptFile);
		/** @see Flags::$settings */
		$fs->setSettings([
			'descNlOnOptLen' => 26
		]);
		$fs->addOpt('dest', 'd', 'Destination file or folder', 'string', false, './');
		$fs->addOpt('data', 'a', 'Data for template (json)', 'string');
		$fs->addArg('source', 'Source file or project file', 'string', true);

		return $fs;
	}
}
