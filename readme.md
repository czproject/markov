
# CzProject\Markov

[![Tests Status](https://github.com/czproject/markov/workflows/Build/badge.svg)](https://github.com/czproject/markov/actions)

Simple "Markov chains" implementation

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


## Installation

[Download a latest package](https://github.com/czproject/markov/releases) or use [Composer](http://getcomposer.org/):

```
composer require czproject/markov
```

CzProject\Markov requires PHP 7.2.0 or later.


## Usage

``` php
use CzProject\Markov\WordAnalyzer;
use CzProject\Markov\MemoryStorage;
use CzProject\Markov\SentenceGenerator;
use CzProject\Markov\RandomNextStateChooser;

$analyzer = new WordAnalyzer;
$analyzer->analyze(['Hello', 'world', 'and', 'everyone']);
$analyzer->analyze(['I', 'love', 'you']);

$storage = new MemoryStorage;
$storage->persistAll($analyzer->getStates());

$generator = new SentenceGenerator($storage, new RandomNextStateChooser);
echo $generator->generateRandom();
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
