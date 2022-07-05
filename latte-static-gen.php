#!/usr/bin/env php
<?php declare(strict_types=1);

use Murdej\LatteStaticGenerator\Generator;
use Murdej\LatteStaticGenerator\ProjectParser;

function showError(string $message, Exception|null $ex = null, bool $fullError = false)
{
	echo $message . "\n";
	if ($ex) echo ($fullError ? $ex->__toString() : $ex->getMessage()) . "\n";
	exit(1);
}

if (isset($_composer_autoload_path)) require $_composer_autoload_path;
else if (file_exists($fn = __DIR__ . '/../../autoload.php')) require $fn;
else if (file_exists($fn = __DIR__ . '/vendor/autoload.php')) require $fn;
else {
	showError("Install composer first https://getcomposer.org/download/.");
}


try {
	$src = $_SERVER['argv'][1]; // $flags->getArg(0);
	$project = (new ProjectParser())->parseNeonFile($src);
	$generator = new Generator(__DIR__ . '/temp');
	$generator->processProject($project);
} 
catch(Nette\Neon\Exception $ex) 
{
	showError("Error in configration", $ex);
}
catch(Latte\CompileException $ex)
{
	showError("Latte compilation error", $ex);
}
catch(Throwable $ex) {
	showError("Unexcepted error", $ex, true);
}