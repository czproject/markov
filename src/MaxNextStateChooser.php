<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class MaxNextStateChooser implements NextStateChooser
	{
		public function choose(array $nextStates): ?NextState
		{
			$result = NULL;

			foreach ($nextStates as $nextState) {
				if ($result === NULL || $nextState->getProbability() > $result->getProbability()) {
					$result = $nextState;
				}
			}

			return $result;
		}
	}
