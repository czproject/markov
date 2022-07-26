<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class ChunkedWordAnalyzer
	{
		/** @var int */
		private $chunkSize;

		/** @var string */
		private $delimiter;

		/** @var array<string, array<string, int>> */
		private $table = [];

		/** @var array<string, int> */
		private $initWords = [];


		public function __construct(int $chunkSize, string $delimiter = "\0")
		{
			if ($chunkSize < 2) {
				throw new InvalidArgumentException('ChunkSize must be 2 or greater.');
			}

			$this->chunkSize = $chunkSize;
			$this->delimiter = $delimiter;
		}


		/**
		 * @param  string[] $words
		 */
		public function analyze(array $words): void
		{
			if (count($words) <= $this->chunkSize) {
				$nextWord = $this->formatChunks($words);
				$this->addInitWord($nextWord);
				$this->addNextWord(NULL, $nextWord);
				return;
			}

			$chunkEnd = count($words) - $this->chunkSize;
			$isFirst = TRUE;
			$word = NULL;

			for ($i = 0; $i <= $chunkEnd; $i++) {
				$nextWords = array_slice($words, $i, $this->chunkSize, FALSE);
				$nextWord = $this->formatChunks($nextWords);

				if ($isFirst) {
					$this->addInitWord($nextWord);
					$isFirst = FALSE;
				}

				$this->addNextWord($word, $nextWord);
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


		private function addInitWord(string $word): void
		{
			if (!isset($this->initWords[$word])) {
				$this->initWords[$word] = 0;
			}

			$this->initWords[$word]++;
		}


		private function addNextWord(?string $word, string $nextWord): void
		{
			if (!isset($this->table[$nextWord])) {
				$this->table[$nextWord] = [];
			}

			if ($word !== NULL) {
				if (!isset($this->table[$word][$nextWord])) {
					$this->table[$word][$nextWord] = 0;
				}

				$this->table[$word][$nextWord]++;
			}
		}


		/**
		 * @param  string[] $chunks
		 */
		private function formatChunks(array $chunks): string
		{
			return implode($this->delimiter, $chunks);
		}
	}
