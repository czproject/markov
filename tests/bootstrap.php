<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test(string $caption, $cb)
{
	$cb();
}


class Tests
{
	public static function unindent(string $s): string
	{
		$s = ltrim($s, "\n\r"); // remove empty lines
		$s = rtrim($s);
		$lines = explode("\n", $s);

		$linesToSearch = $lines;
		array_walk($linesToSearch, function (&$value) {
			$m = \Nette\Utils\Strings::match($value, '~^\s+~');
			$value = isset($m[0]) ? $m[0] : '';
		});
		$linesToSearch = array_filter($linesToSearch, function ($value) {
			return $value !== '';
		});

		$prefix = \Nette\Utils\Strings::findPrefix($linesToSearch);

		foreach ($lines as &$line) {
			$line = \Nette\Utils\Strings::after($line, $prefix);
		}

		return implode("\n", $lines) . "\n";
	}
}
