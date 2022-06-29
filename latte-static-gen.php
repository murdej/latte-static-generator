<?php declare(strict_types=1);

use Murdej\LatteStaticGenerator\TaskConfig;
use Murdej\LatteStaticGenerator\Generator;
use Murdej\LatteStaticGenerator\ProjectParser;

require $_composer_autoload_path ?? __DIR__ . '/vendor/autoload.php';
// require __DIR__ . '/App/Generator.php';
// require __DIR__ . '/App/TaskConfig.php';
// require __DIR__ . '/App/CliParserFactory.php';
// require __DIR__ . '/App/ProjectParser.php';
// require __DIR__ . '/App/Project.php';
// require __DIR__ . '/Plugins/IPlugin.php';
// require __DIR__ . '/Plugins/PluginEvent.php';
// require __DIR__ . '/Plugins/BasePlugin.php';
// require __DIR__ . '/Plugins/MarkdownPandoc.php';

// $flags = (new CliParserFactory($_SERVER['argv']))->createCliParser();

// try {
	// if ($flags->parse()) {
		$src = $_SERVER['argv'][1]; // $flags->getArg(0);
		$project = (new ProjectParser())->parseNeonFile($src);

		$generator = new Generator(__DIR__ . '/temp');
		$generator->processProject($project);
	// } else $flags->displayHelp();
/* }
catch(Exception $e)
{
	$flags->displayHelp();
} */

/* $task = new TaskConfig();
$task->sourceFile = './samples/sources/homepage.latte';
$task->destination = './samples/dist/';
$task->data['name'] = 'Murdej';

$generator = new Generator('./temp');
$generator->processTask($task); */
