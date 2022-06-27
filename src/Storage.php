<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	interface Storage
	{
		/**
		 * @param  State[] $states
		 */
		function persistAll(array $states): void;


		function persist(State $state): void;


		/**
		 * @param  string|int $stateId
		 */
		function fetch($stateId): State;


		/**
		 * @return State[]
		 */
		function getInitialStates(): array;
	}
