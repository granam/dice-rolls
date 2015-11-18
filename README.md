[![Build Status](https://travis-ci.org/jaroslavtyc/drd-dice-roll.svg?branch=master)](https://travis-ci.org/jaroslavtyc/drd-dice-roll)

[Let's roll!](#lets-roll)

[Custom dices & rolls](#custom-dices--rolls)

[Install](#install)

## Let's roll!

```php
<?php
use Drd\DiceRoll\Templates\Rolls\Roll1d6;

$roll1d6 = new Roll1d6();
$rolledValue = $roll1d6->roll();
if ($rolledValue === 6) {
    echo 'Hurrey! You win!';
} else {
    echo 'Try harder';
}

$roll2d6DrdPlus = new Roll2d6DrdPlus();
while ($roll2d6DrdPlus->roll() <= 12) {
    echo 'Still no bonus :( ...';
}
echo 'There it is! Bonus roll comes, with final value of '
. $roll2d6DrdPlus->getLastRollSummary() . '
Rolls were quite dramatic, consider by yourself: ';
foreach ($roll2d6DrdPlus->getLastDiceRolls() as $diceRoll) {
    echo 'Rolled number ' . $diceRoll->getRolledNumber() . ', evaluated as value ' . $diceRoll->getEvaluatedValue(); 
}
```
There are plenty of predefined templates of dices and rolls as 1d4, 1d6, 1d10.
You can mix them and any one else u create by Dices class.

Just think about your needs and check templates. Your requirements may be already satisfied by them.


## Custom dices & rolls
There can be situations, where you need crazy combinations. Let's say one roll with 1d5 dice, three rolls with 1d74 dice.

It is easy. The hard part is only to find the way:
```php
<?php
use Drd\DiceRoll\Dice;
use Granam\Strict\Integer\StrictInteger;

$1d5 = new Dice(new StrictInteger(1) /* minimum of the dice */, new StrictInteger(5) /* maximum of the dice */);
$1d74 = new Dice(new StrictInteger(1) /* minimum of the dice */, new StrictInteger(74) /* maximum of the dice */);
$diceCombo = new Dices([$1d5, $1d74, $1d74, $1d74]);

$roll = new Roll(
    $diceCombo,
    new StrictInteger(1) /* roll once with them all */,
    new DiceRollBuilder(new OneToOneEvaluator() /* "what you roll is what you get" */),
    new NoRollOn() /* no bonus roll at all */,
    new NoRollOn() /* no malus roll at all */
);

// here it is!
$roll->roll();

```

## Install
In your composer.json add new requirement

```json
"require": {
    "drd/dice-roll": "~1.0"
}
```

And run update of that package

```
composer.phar update drd/dice-roll
```
