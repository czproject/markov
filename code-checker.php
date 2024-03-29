<?php

return function (JP\CodeChecker\CheckerConfig $config) {
	$config->setPhpVersion(new JP\CodeChecker\Version('7.2.0'));
	$config->addPath('./src');
	$config->addPath('./tests');
	JP\CodeChecker\Sets\CzProjectMinimum::configure($config);
};
