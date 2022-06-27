<?php

declare(strict_types=1);

use CzProject\Markov\NextState;
use CzProject\Markov\State;
use CzProject\Markov\WordAnalyzer;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('Basic', function () {
	$analyzer = new WordAnalyzer;
	$analyzer->analyze(['Hello', 'world']);
	Assert::equal([
		new State('Hello', 1, [
			new NextState('world', 1),
		]),
		new State('world', 0, []),
	], $analyzer->getStates());

	$analyzer->analyze(['Hello', 'man']);
	Assert::equal([
		new State('Hello', 1, [
			new NextState('world', 0.5),
			new NextState('man', 0.5),
		]),
		new State('world', 0, []),
		new State('man', 0, []),
	], $analyzer->getStates());
});
