[![Build Status](https://travis-ci.org/jaroslavtyc/drd-dice-roll.svg?branch=master)](https://travis-ci.org/jaroslavtyc/drd-dice-roll)

[Let's roll!](#lets-roll)

[Custom dices & rolls](#custom-dices--rolls)

[Install](#install)

## Let's roll!

```php
<?php
use Drd\DiceRoll\Templates\Rolls\Roll1d6;

$roller1d6 = new Roller1d6();
$rolledValue = $roller1d6->roll();
if ($rolledValue === 6) {
    echo 'Hurray! You win!';
} else {
    echo 'Try harder';
}

$roller2d6DrdPlus = new Roller2d6DrdPlus();
while ($roller2d6DrdPlus->roll() <= 12) {
    echo 'Still no bonus :( ...';
}
echo 'There it is! Bonus roll comes, with final value of '
. $roller2d6DrdPlus->getValue() . '
Rolls were quite dramatic, consider by yourself: ';
foreach ($roller2d6DrdPlus->getDiceRolls() as $diceRoll) {
    echo 'Rolled number ' . $diceRoll->getRolledNumber() . ', evaluated as value ' . $diceRoll->getValue(); 
}
```
There are plenty of predefined templates of dices and rolls as 1d4, 1d6, 1d10.
You can mix them and any other you create in Dices class.

Just think about your needs and check templates. Your requirements may be already satisfied by them.


## Custom dices & rolls
There can be situations, where you need crazy combinations. Let's say one roll with 1d5 dice and three rolls with 1d74 dice.

It is easy. The hard part is only to find the way:
```php
<?php
use Drd\DiceRoll\CustomDice;
use Granam\Strict\Integer\IntegerObject;

$1d5 = new CustomDice(new IntegerObject(1) /* minimum of the dice */, new IntegerObject(5) /* maximum of the dice */);
$1d74 = new CustomDice(new IntegerObject(1) /* minimum of the dice */, new IntegerObject(74) /* maximum of the dice */);
$diceCombo = new Dices([$1d5, $1d74, $1d74, $1d74]);

$roller = new Roller(
    $diceCombo,
    new IntegerObject(1) /* roll with them all once */,
    new OneToOneEvaluator() /* "what you roll is what you get" */),
    new NoRollOn() /* no bonus roll at all */,
    new NoRollOn() /* no malus roll at all */
);

// here it is!
$roller->roll();

```

## Install
Order composer to add new requirement
```
composer.phar require drd/dice-roll
```

- or add it manually by editing your project composer.json
```json
"require": {
    "drd/dice-roll": "~3.0"
}
```

And run update of that package

```
composer.phar update drd/dice-roll
```
