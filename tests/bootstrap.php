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
		$prefix = \Nette\Utils\Strings::findPrefix(array_filter($lines, function ($value) {
			return $value !== '';
		}));
		$prefixLength = \Nette\Utils\Strings::length($prefix);

		foreach ($lines as &$line) {
			$line = \Nette\Utils\Strings::substring($line, $prefixLength);
		}

		return implode("\n", $lines) . "\n";
	}
}
