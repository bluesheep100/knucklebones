# Knucklebones
## Rules outline
The game of Knucklebones consists of two grids 3x3 in size, belonging to player 1 and player 2. The players take turns rolling 6-sided dice, and placing them in the innermost empty space of a column in their grid. If the opponent's grid contains any dice with the same face in the same column, those dice are removed.


Points are counted by adding together the faces of each column in a player's grid. If dice with the same face share a column, those dice are instead multiplied by each other.
For example, this grid;
```
3 2 5
3 1 0
0 0 0
```
Would give a player `(3 * 3) + 2 + 1 + 5` points, totaling 17.

When a player fills the last space in their grid, the game ends, and the winner is the player with the most points.
