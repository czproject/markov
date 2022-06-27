<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class RandomNextStateChooser implements NextStateChooser
	{
		public function choose(array $nextStates): ?NextState
		{
			$nextStatesCount = count($nextStates);

			if ($nextStatesCount === 0) {
				return NULL;
			}

			if ($nextStatesCount === 1) {
				foreach ($nextStates as $nextState) {
					return $nextState;
				}
			}

			$total = 0;
			$chances = [];

			foreach ($nextStates as $nextState) {
				$nextStateRange = (int) round($nextStatesCount * $nextState->getProbability());
				$total += $nextStateRange;

				$chances[] = [
					'nextState' => $nextState,
					'top' => $total,
				];
			}

			$rand = mt_rand(0, $total);

			foreach ($chances as $chance) {
				if ($rand <= $chance['top']) {
					return $chance['nextState'];
				}
			}

			return NULL;
		}
	}
