<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class WordAnalyzer
	{
		/** @var array<string, array<string, int>> */
		private $table = [];

		/** @var array<string, int> */
		private $initWords = [];


		/**
		 * @param  string[] $words
		 */
		public function analyze(array $words): void
		{
			$isFirst = TRUE;
			$word = NULL;

			foreach ($words as $nextWord) {
				if ($isFirst) {
					if (!isset($this->initWords[$nextWord])) {
						$this->initWords[$nextWord] = 0;
					}

					$this->initWords[$nextWord]++;
					$isFirst = FALSE;
				}

				if (!isset($this->table[$nextWord])) {
					$this->table[$nextWord] = [];
				}

				if ($word !== NULL) {
					if (!isset($this->table[$word][$nextWord])) {
						$this->table[$word][$nextWord] = 0;
					}

					$this->table[$word][$nextWord]++;
				}

				$word = $nextWord;
			}
		}


		/**
		 * @return State[]
		 */
		public function getStates(): array
		{
			if (count($this->table) === 0) {
				return [];
			}

			$initialSum = array_sum($this->initWords);
			$result = [];

			foreach ($this->table as $stateId => $nextStates) {
				$totalSum = array_sum($nextStates);
				$nexts = [];

				foreach ($nextStates as $nextStateId => $nextStateCount) {
					$nexts[] = new NextState($nextStateId, $nextStateCount / $totalSum);
				}

				$initialProbability = (isset($this->initWords[$stateId]) ? $this->initWords[$stateId] : 0) / $initialSum;
				$result[] = new State($stateId, $initialProbability, $nexts);
			}

			return $result;
		}
	}
