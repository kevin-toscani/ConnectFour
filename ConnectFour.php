<?php

/**
 *  Connect Four Simulator
 */

namespace KevinToscani;

class ConnectFour {
	
	private $ar_gameboard;
	private $ar_ai;
	private $ar_lastmove;
	private $player = 1;

	public function __construct($ai1 = false, $ai2 = true) {
		$this->ar_gameboard = array_fill(0, 6, array_fill(0, 7, 0));
		$this->ar_ai = [1=>$ai1, 2=>$ai2];
		echo $this;
		$this->placeWhere();
	}

	private function placeWhere() {
		if($this->ar_ai[$this->player]) {
			echo "AUTOPLAY, choose a column to drop your piece: ";
			$row = end($this->ar_gameboard);
			$ar_option = [];
			foreach($row as $option=>$value) {
				if(!$value) {
					$ar_option[] = $option;
				}
			}
			shuffle($ar_option);
			$column = reset($ar_option);
			echo (1+$column) . "\r\n";
		}

		else {
			do {
				echo "Player {$this->player}, choose a column to drop your piece: ";
				$handle = fopen('php://stdin', 'r');
				$column = 1 * trim(fgets($handle));
				echo "\r\n";
			} while(!is_int($column) || $column < 1 || $column > 7);
			$column -= 1;
		}
		$this->placeAt($column);
	}

	private function placeAt($column) {
		foreach($this->ar_gameboard as $row => $ar_row) {
			if($ar_row[$column] == 0) {
				$this->ar_gameboard[$row][$column] = $this->player;
				echo $this;
				$this->ar_lastmove = [$row,$column];
				$this->checkWinner();
				$this->checkBoardFull();
				$this->switchPlayer();
				$this->placeWhere();
			}
		}

		echo "That column is already full. ";
		$this->placeWhere();
	}

	private function checkWinner() {

		list($row,$column) = $this->ar_lastmove;

		// Horizontal check
		for($i = $column-3; $i <= $column; $i++) {
			$check = 1;
			for($j=0; $j<=3; $j++) {
				if(!isset($this->ar_gameboard[$row][$i+$j])) continue 2;
				$check *= $this->ar_gameboard[$row][$i+$j];
			}
			if($check == pow($this->player, 4)) {
				exit("Player {$this->player} wins!");
			}
		}

		// Vertical check
		for($i = $row-3; $i <= $row; $i++) {
			$check = 1;
			for($j=0; $j<=3; $j++) {
				if(!isset($this->ar_gameboard[$i+$j][$column])) continue 2;
				$check *= $this->ar_gameboard[$i+$j][$column];
			}
			if($check == pow($this->player, 4)) {
				exit("Player {$this->player} wins");
			}
		}

		for($i = 0; $i <= 3; $i++) {
			$check = 1;
			for($j = 0; $j <= 3; $j++) {
				if(!isset($this->ar_gameboard[$row-$i+$j][$column-$i+$j])) continue 2;
				$check *= $this->ar_gameboard[$row-$i+$j][$column-$i+$j];
			}
			if($check == pow($this->player, 4)) {
				exit("Player {$this->player} wins");
			}
		}

		for($i = 0; $i <= 3; $i++) {
			$check = 1;
			for($j = 0; $j <= 3; $j++) {
				if(!isset($this->ar_gameboard[$row-$i+$j][$column+$i-$j])) continue 2;
				$check *= $this->ar_gameboard[$row-$i+$j][$column+$i-$j];
			}
			if($check == pow($this->player, 4)) {
				exit("Player {$this->player} wins");
			}
		}

		return;
	}

	private function checkBoardFull() {
		if(array_product(end($this->ar_gameboard))) {
			exit("It's a draw");
		}
	}

	private function switchPlayer() {
		$this->player = (3 - $this->player);
	}

	public function __toString() {
		$tmp = [];
		foreach($this->ar_gameboard as $ar_row) {
			$tmp[] = implode(' ', $ar_row);
		}
		$tmp = array_reverse($tmp);
		$tmp = str_replace([0,1,2], ['.','O','X'], $tmp);
		return implode("\r\n", $tmp) . "\r\n1 2 3 4 5 6 7\r\n";
	}


}
