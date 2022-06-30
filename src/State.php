<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class State
	{
		/** @var string|int */
		private $id;

		/** @var float */
		private $initialProbability;

		/** @var NextState[] */
		private $nextStates;


		/**
		 * @param string|int $id
		 * @param float $initialProbability
		 * @param NextState[] $nextStates
		 */
		public function __construct(
			$id,
			$initialProbability,
			array $nextStates
		)
		{
			if ($initialProbability < 0 || $initialProbability > 1) {
				throw new InvalidArgumentException('Probability is out of range 0..1');
			}

			$tmp = [];

			foreach ($nextStates as $nextState) {
				$nextStateId = $nextState->getId();

				if (isset($tmp[$nextStateId])) {
					throw new InvalidArgumentException('Duplicated next state ID: ' . $nextStateId);
				}

				$tmp[$nextStateId] = TRUE;
			}

			$this->id = $id;
			$this->initialProbability = $initialProbability;
			$this->nextStates = $nextStates;
		}


		/**
		 * @return string|int
		 */
		public function getId()
		{
			return $this->id;
		}


		/**
		 * @return NextState[]
		 */
		public function getNextStates(): array
		{
			return $this->nextStates;
		}


		public function isInitial(): bool
		{
			return $this->initialProbability > 0;
		}


		public function isFinal(): bool
		{
			return count($this->nextStates) === 0;
		}


		public function getInitialProbability(): float
		{
			return $this->initialProbability;
		}
	}
