<?php

namespace Kitsune\ClubPenguin\Handlers\Game;

class MancalaGame 
{
	const INVALID_MOVE = -1;
	const STONE_PLACED = "d";
	const FREE_TURN = "f";
	const CAPTURE = "c";
	const PLACED = 91;
	const GAME_OVER = 10;

	public $MancalaBoard = array
	(
		4, 4, 4, 4, 4, 4, 0, 
		4, 4, 4, 4, 4, 4, 0
	);

	public $currentTurn = 0;
	public $points = array(0 => 0, 1 => 0); // Stones in bank.
	public $lastCup = -1;
	public $winner = -1;
	public $startCup = -1;

	public function reset()
	{
		$this->MancalaBoard = array
		(
			4, 4, 4, 4, 4, 4, 0, 
			4, 4, 4, 4, 4, 4, 0
		);

		$this->currentTurn = 0;
		$this->points = array(0 => 0, 1 => 0);
		$this->lastCup = -1;
		$this->winner = -1;
		$this->startCup = -1;
	}

	public function getBoardString()
	{
		return implode(",", $this->MancalaBoard);
	}

	public function isBank($index)
	{
		if ($index === (count($this->MancalaBoard) / 2) - 1 || $index === count($this->MancalaBoard) - 1)
			return True;

		return False;
	}

	public function isOpponentBank($index)
	{
		if ($this->isBank($index))
		{
			$player = $index == (count($this->MancalaBoard) / 2) - 1 ? 0 : 1;
			if ($player != $this->currentTurn)
			{
				return True;
			}
		}

		return False;
	}

	public function isCurrentTurn($index)
	{
		return $this->currentTurn == $index;
	}

	public function isValidCup($cup)
	{
		$board = $this->MancalaBoard;
		if ($cup > -1 && $cup < count($board))
		{
			$turn = $this->currentTurn;
			$player_board = $cup < (count($this->MancalaBoard) / 2) ? 0 : 1;

			if ($turn === $player_board && !$this->isBank($cup))
				return True;
		}

		return False;
	}

	public function playMancala($cup)
	{
		$initCup = $cup;
		$this->startCup = $initCup;
		$board = &$this->MancalaBoard;
		$stones = $board[$cup];
		$board[$cup] = 0;

		if ($stones < 1)
			return self::INVALID_MOVE;

		$stones_placed = 0;
		while ($stones_placed < $stones)
		{
			$cup ++;
			if ($cup == count($board))
				$cup = 0;

			if ($this->isOpponentBank($cup))
				continue;
			if ($this->isBank($cup) && !$this->isOpponentBank($cup))
				$this->points[$this->currentTurn]++;

			$board[$cup] ++;

			$stones_placed++;
		}
		$this->lastCup = $cup;

		return self::PLACED;
	}

	public function captureStones($cup)
	{
		$offset = $cup;
		$opponent = $this->currentTurn == 0 ? 1 : 0;
		$captureOffset = count($this->MancalaBoard) - $offset - 2;

		$this->points[$this->currentTurn] += $this->MancalaBoard[$captureOffset];
		$this->MancalaBoard[$offset] = 0;
		$this->MancalaBoard[$captureOffset] = 0;
		return $this->startCup;
	}

	public function checkForGameOver()
	{
		$opponent = $this->currentTurn == 0 ? 1 : 0;
		$currentOffset = (count($this->MancalaBoard) / 2) - $opponent * (count($this->MancalaBoard) / 2);

		$mBoard = $this->MancalaBoard;
		$current_board = array_splice($mBoard, $currentOffset, 6);
		$stones = array_sum($current_board);
		
		if ($stones === 0)
		{
			$this->points[$opponent] += array_sum($mBoard);
			if ($this->points[$this->currentTurn] > $this->points[$opponent])
				$this->winner = $this->currentTurn;
			elseif ($this->points[$this->currentTurn] < $this->points[$opponent])
				$this->winner = $opponent;
			
			return self::GAME_OVER;
		}
		return False;
	}

	public function judgeGame()
	{
		# # # # # # 0 # # # # # # 0
		$opponent = $this->currentTurn == 0 ? 1 : 0;
		$currentOffset = (count($this->MancalaBoard) / 2) - $opponent * (count($this->MancalaBoard) / 2);

		$board = $this->MancalaBoard;
		$gO = $this->checkForGameOver();
		if ($gO === self::GAME_OVER)
			return $gO;
		
		if ($this->isValidCup($this->lastCup))
		{
			if ($board[$this->lastCup] == 1)
			{
				$capture = $this->captureStones($this->lastCup);
				$gameOver = $this->checkForGameOver();
				if ($gameOver === self::GAME_OVER)
					return $gameOver;

				return array(self::CAPTURE, $capture);
			}
		}

		if ($this->isBank($this->lastCup) && !$this->isOpponentBank($this->lastCup))
		{
			return array(self::FREE_TURN, $this->startCup);
		}

		return array(self::STONE_PLACED, $this->startCup);
	}

	public function placeCup($cup)
	{
		if (!$this->isValidCup($cup))
			return self::INVALID_MOVE;

		$placed = $this->playMancala($cup);
		if ($placed == self::INVALID_MOVE)
			return self::INVALID_MOVE;

		$judge = $this->judgeGame();

		if ($judge === self::GAME_OVER)
			return self::GAME_OVER;

		if (!in_array(self::FREE_TURN, $judge))
		{
			$this->currentTurn = $this->currentTurn == 1 ? 0 : 1;
		}

		return $judge;
	}

}

?>
