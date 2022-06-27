<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class MemoryStorage implements Storage
	{
		/** @var array<string|int, State> */
		private $states = [];


		public function persistAll(array $states): void
		{
			foreach ($states as $state) {
				$this->persist($state);
			}
		}


		public function persist(State $state): void
		{
			$stateId = $state->getId();

			if (isset($this->states[$stateId])) {
				throw new InvalidArgumentException('State with ID ' . $stateId . ' is persisted already.');
			}

			$this->states[$stateId] = $state;
		}


		public function fetch($stateId): State
		{
			if (!isset($this->states[$stateId])) {
				throw new InvalidStateException('State ' . $stateId . ' not found.');
			}

			return $this->states[$stateId];
		}


		public function getInitialStates(): array
		{
			$result = [];

			foreach ($this->states as $state) {
				if ($state->isInitial()) {
					$result[] = $state;
				}
			}

			return $result;
		}
	}
