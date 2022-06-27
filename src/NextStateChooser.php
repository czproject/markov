<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	interface NextStateChooser
	{
		/**
		 * @param  NextState[] $nextStates
		 */
		function choose(array $nextStates): ?NextState;
	}
