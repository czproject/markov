<?php

	declare(strict_types=1);

	namespace CzProject\Markov;

	use Nette\Utils\Strings;


	class SentenceGenerator
	{
		/** @var Storage */
		private $storage;

		/** @var NextStateChooser */
		private $nextStateChooser;


		public function __construct(
			Storage $storage,
			NextStateChooser $nextStateChooser
		)
		{
			$this->storage = $storage;
			$this->nextStateChooser = $nextStateChooser;
		}


		public function generateRandom(): ?string
		{
			$initStates = $this->storage->getInitialStates();

			if (count($initStates) === 0) {
				return NULL;
			}

			$state = $initStates[array_rand($initStates)];
			$result = Strings::firstUpper((string) $state->getId());

			while (!$state->isFinal()) {
				$nextState = $this->nextStateChooser->choose($state->getNextStates());

				if ($nextState === NULL) {
					break;
				}

				$state = $this->storage->fetch($nextState->getId());
				$result .= ' ' . $state->getId();
			}

			return $result;
		}
	}
