<?php

use KevinToscani\ConnectFour;

include('ConnectFour.php');
$ai1 = isset($argv[1]) ? $argv[1] : 'player';
$ai2 = isset($argv[2]) ? $argv[2] : 'ai';

$ob_game = new ConnectFour($ai1 == 'ai', $ai2 == 'ai');
