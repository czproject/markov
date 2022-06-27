<?php

	declare(strict_types=1);

	namespace CzProject\Markov;


	class NextState
	{
		/** @var string|int */
		private $id;

		/** @var float */
		private $probability;


		/**
		 * @param string|int $id
		 * @param float $probability
		 */
		public function __construct($id, $probability)
		{
			if ($probability < 0 || $probability > 1) {
				throw new InvalidArgumentException('Probability is out of range 0..1');
			}

			$this->id = $id;
			$this->probability = $probability;
		}


		/**
		 * @return string|int
		 */
		public function getId()
		{
			return $this->id;
		}


		/**
		 * @return float
		 */
		public function getProbability()
		{
			return $this->probability;
		}
	}
