<?php

declare(strict_types=1);

use CzProject\Markov\Dumper;
use CzProject\Markov\WordAnalyzer;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('Basic', function () {
	$analyzer = new WordAnalyzer;
	$analyzer->analyze(['Hello', 'world']);
	Assert::same(Tests::unindent("
		Hello [1]:
			=> world (1)

		world [0]:
	"), Dumper::dump($analyzer->getStates()));

	$analyzer->analyze(['Hello', 'man']);
	Assert::same(Tests::unindent("
		Hello [1]:
			=> world (0.5)
			=> man (0.5)

		world [0]:

		man [0]:
	"), Dumper::dump($analyzer->getStates()));
});
