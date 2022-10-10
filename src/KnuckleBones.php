<?php

class KnuckleBones
{
    protected string $player = 'p1';

    protected array $score = ['p1' => 0, 'p2' => 0];

    protected array $board = [
        'p1' => [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0],
        ],
        'p2' => [
            [0, 0, 0],
            [0, 0, 0],
            [0, 0, 0],
        ],
    ];

    public function getScore(): array
    {
        return $this->score;
    }

    public function getPlayer(): string
    {
        return $this->player === 'p1' ? 'Player 1' : 'Player 2';
    }

    public function rollDice(): int
    {
        return random_int(1, 6);
    }

    public function placeDice(int $column, int $value): bool
    {
        $playerBoard = $this->board[$this->player];
        $i = -1;
        foreach ($playerBoard as $key => $row) {
            if ($row[$column] === 0) {
                $i = $key;
                break;
            }
        }

        if ($i === -1)
            return false;

        $this->board[$this->player][$i][$column] = $value;

        $this->destroyDice($column, $value);

        $this->countScore();

        return true;
    }

    protected function destroyDice(int $column, int $value): void
    {
        $opponent = $this->player === 'p1' ?
            'p2' :
            'p1';

        $filtered = array_filter(
            array_column($this->board[$opponent], $column),
            function (int $dice) use ($value) {
                return $dice !== $value;
            }
        );
        $padded = array_pad($filtered, 3, 0);

        foreach ($this->board[$opponent] as $i => &$row) {
            $row[$column] = $padded[$i];
        }
    }

    public function changeTurn(): string
    {
        $this->player = $this->player === 'p1' ?
            'p2' :
            'p1';

        return $this->player;
    }

    public function boardIsFull(): bool
    {
        $a = !in_array(0, array_merge(...$this->board['p1']));
        $b = !in_array(0, array_merge(...$this->board['p2']));

        return $a || $b;
    }

    protected function countScore(): void
    {
        $sum = 0;

        foreach (['p1', 'p2'] as $player) {
            $board = $this->board[$player];
            foreach (range(0, 2) as $col)
                foreach (array_count_values(array_column($board, $col)) as $num => $count)
                    $sum += $num ** $count;

            $this->score[$player] = $sum;
            $sum = 0;
        }
    }

    public function printBoard(): void
    {
        $p1 = $this->board['p1'];
        $p2 = $this->board['p2'];

        $a = function ($x) {
            echo "|$x[0]|$x[1]|$x[2]|" . PHP_EOL;
        };

        foreach (array_reverse($p1) as $x)
            $a($x);

        unset($x);
        echo '———————' . PHP_EOL;

        foreach ($p2 as $x)
            $a($x);
    }
}
