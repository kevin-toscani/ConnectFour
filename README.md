# ConnectFour
A PHP CLI Connect Four simulator.

## Start
To start a game vs computer:
`php play.php`

To autoplay a simulated game of Connect Four:
`php play.php ai ai`

To play against another player locally:
`php play.php player player`

## How to play
When it's your turn, choose a column (1-7) and press Enter. Your piece will drop down the selected column. The first player to connect four pieces in a row (horizontally, vertically or diagonally) is the winner.

## To do
I still want to add a little bit of intelligence to the AI. Right now, the AI selects a column 100% randomly.
