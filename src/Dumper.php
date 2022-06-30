<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class Dumper
	{
		/**
		 * @param  State[] $states
		 */
		public static function dump(array $states): string
		{
			$res = '';

			foreach ($states as $state) {
				$res .= $state->getId() . ' [' . $state->getInitialProbability() . "]:\n";

				foreach ($state->getNextStates() as $nextState) {
					$res .= "\t=> " . $nextState->getId() . ' (' . $nextState->getProbability() . ")\n";
				}

				$res .= "\n";
			}

			return rtrim($res) . "\n";
		}
	}
