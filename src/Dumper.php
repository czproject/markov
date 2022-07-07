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


		/**
		 * @param  State[] $states
		 */
		public static function dumpStats(array $states): string
		{
			$min = NULL;
			$max = NULL;
			$sum = 0;
			$statesCount = count($states);

			foreach ($states as $state) {
				$nextStatesCount = count($state->getNextStates());

				if ($min === NULL || $nextStatesCount < $min) {
					$min = $nextStatesCount;
				}

				if ($max === NULL || $nextStatesCount > $max) {
					$max = $nextStatesCount;
				}

				$sum += $nextStatesCount;
			}

			$minStates = [];
			$maxStates = [];

			foreach ($states as $state) {
				$nextStatesCount = count($state->getNextStates());

				if ($nextStatesCount === $min) {
					$minStates[] = $state->getId();
				}

				if ($nextStatesCount === $max) {
					$maxStates[] = $state->getId();
				}
			}

			return 'States: ' . $statesCount
				. "\nNext states [MIN]: " . ($min !== NULL ? $min : 'N') . (count($minStates) > 0 ? (' (' . implode("; ", $minStates) . ')') : '')
				. "\nNext states [MEAN]: " . ($statesCount > 0 ? round($sum / $statesCount, 2) : 'N')
				. "\nNext states [MAX]: " . ($max !== NULL ? $max : 'N') . (count($maxStates) > 0 ? (' (' . implode("; ", $maxStates) . ')') : '')
				. "\n";
		}
	}
