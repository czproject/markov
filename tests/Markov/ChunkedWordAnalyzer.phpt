<?php

declare(strict_types=1);

use CzProject\Markov\Dumper;
use CzProject\Markov\ChunkedWordAnalyzer;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('Basic', function () {
	$analyzer = new ChunkedWordAnalyzer(3, '+');
	$analyzer->analyze(['Hello']);
	Assert::same(Tests::unindent("
		Hello [1]:
	"), Dumper::dump($analyzer->getStates()));

	$analyzer->analyze(['Hello', 'world']);
	Assert::same(Tests::unindent("
		Hello [0.5]:

		Hello+world [0.5]:
	"), Dumper::dump($analyzer->getStates()));

	$analyzer->analyze(['Hello', 'good', 'man']);
	Assert::same(Tests::unindent("
		Hello [0.33333333333333]:

		Hello+world [0.33333333333333]:

		Hello+good+man [0.33333333333333]:
	"), Dumper::dump($analyzer->getStates()));

	$analyzer->analyze(['Hello', 'good', 'man', 'lorem', 'ipsum', 'dolor', 'sit', 'amet']);
	Assert::same(Tests::unindent("
		Hello [0.25]:

		Hello+world [0.25]:

		Hello+good+man [0.5]:
			=> good+man+lorem (1)

		good+man+lorem [0]:
			=> man+lorem+ipsum (1)

		man+lorem+ipsum [0]:
			=> lorem+ipsum+dolor (1)

		lorem+ipsum+dolor [0]:
			=> ipsum+dolor+sit (1)

		ipsum+dolor+sit [0]:
			=> dolor+sit+amet (1)

		dolor+sit+amet [0]:
	"), Dumper::dump($analyzer->getStates()));
});
