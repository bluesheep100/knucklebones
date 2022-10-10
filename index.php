<?php

require_once(__DIR__ . '/src/KnuckleBones.php');

$kb = new KnuckleBones();

$kb->printBoard();
while (!$kb->boardIsFull()) {
    $roll = $kb->rollDice();

    echo "{$kb->getPlayer()} rolled $roll. Place where?\n";

    $input = trim(fgets(STDIN));
    while (!is_numeric($input) || !in_array($input, [1, 2, 3])) {
        echo 'Invalid input' . PHP_EOL;
        $input = trim(fgets(STDIN));
    }

    if (!$kb->placeDice($input - 1, $roll))
        continue;

    $kb->printBoard();
    $kb->changeTurn();
}

$score = $kb->getScore();
$p1 = $score['p1'];
$p2 = $score['p2'];
echo "Score:\nPlayer1: $p1\nPlayer2: $p2\n";

if ($p1 > $p2)
    echo 'Player1 wins!';
elseif ($p1 < $p2)
    echo 'Player2 wins!';
else
    echo 'Tie!';
