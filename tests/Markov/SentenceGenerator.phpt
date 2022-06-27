<?php

declare(strict_types=1);

use CzProject\Markov\MaxNextStateChooser;
use CzProject\Markov\MemoryStorage;
use CzProject\Markov\SentenceGenerator;
use CzProject\Markov\WordAnalyzer;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('Basic', function () {
	$analyzer = new WordAnalyzer;
	$analyzer->analyze(['Hello', 'world', 'and', 'everyone']);

	$storage = new MemoryStorage;
	$storage->persistAll($analyzer->getStates());

	$generator = new SentenceGenerator($storage, new MaxNextStateChooser);
	Assert::same('Hello world and everyone', $generator->generateRandom());
});
