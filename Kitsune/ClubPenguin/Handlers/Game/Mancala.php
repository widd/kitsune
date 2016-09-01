<?php
namespace Kitsune\ClubPenguin\Handlers\Game;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Packets\Packet;

use Kitsune\ClubPenguin\Handlers\Game\MancalaGame;

trait Mancala
{

	public $MancalaTableIds = array(100, 101, 103, 104);
	public $MancalaTables = array(100 => array(null, null), 101 => array(null, null), 103 => array(null, null), 104 => array(null, null));
	public $MancalaSpectators = array();
	public $MancalaHandlers = array();

	public function initMancalaTables()
	{
		$this->MancalaHandlers = array(100 => new MancalaGame(), 101 => new MancalaGame(), 103 => new MancalaGame(), 104 => new MancalaGame());

		$this->on["after-remove"]["MancalaGame"] = "MancalaPlayerRemoved";
		$this->handlers["jz"]["MancalaGame"] = "JoinMancalaGame";
		$this->handlers["gz"]["MancalaGame"] = "GetMancalaGame";
		$this->handlers["zm"]["MancalaGame"] = "SendMancalaMove";
		$this->handlers["lz"]["MancalaGame"] = "LeaveFromMancalaGame";

		$this->handlers["a#jt"][100] = "JoinToMancalaTable";
		$this->handlers["a#jt"][101] = "JoinToMancalaTable";
		$this->handlers["a#jt"][103] = "JoinToMancalaTable";
		$this->handlers["a#jt"][104] = "JoinToMancalaTable";

		$this->handlers["a#gt"][100] = "GetMancalaTableString";
		$this->handlers["a#gt"][101] = "GetMancalaTableString";
		$this->handlers["a#gt"][103] = "GetMancalaTableString";
		$this->handlers["a#gt"][104] = "GetMancalaTableString";

		$this->handlers["a#lt"][100] = "LeaveMancalaGame";
		$this->handlers["a#lt"][101] = "LeaveMancalaGame";
		$this->handlers["a#lt"][103] = "LeaveMancalaGame";
		$this->handlers["a#lt"][104] = "LeaveMancalaGame";
	}

	public function LeaveFromMancalaGame($peng)
	{
		$table = $peng->waddle;
		if (!in_array($table, $this->MancalaTableIds)) return;
		$seat = array_search($peng, $this->waddlingPenguins[$table]);
		if ($seat === false) return;

		$this->LeaveMancalaGame($peng);
		foreach ($this->waddlingPenguins[$table] as $index => $p) 
		{
			$p->send("%xt%cz%-1%{$peng->username}%");
			$this->LeaveMancalaGame($peng);
		}

	}

	public function SendMancalaMove($peng)
	{
		$gameOver = false;
		$table = $peng->waddle;
		$seat = array_search($peng, $this->waddlingPenguins[$table]);
		if ($seat === false) return $peng->send("%xt%e%-1%Move Hack%");

		$Mancala = $this->MancalaHandlers[$table];
		if ($Mancala->isCurrentTurn($seat))
		{
			$cup = Packet::$Data[2];

			$tryMove = $Mancala->placeCup($cup);
			if ($tryMove == MancalaGame::INVALID_MOVE)
				return $peng->send("%xt%invalid%-1%Invalid Move%");

			if ($tryMove == MancalaGame::GAME_OVER)
			{
				$gameOver = true;
				$winner = $Mancala->winner;
				if ($winner == -1)
				{
					$peng->addCoins(10);
					$this->waddlingPenguins[$table][$opponent]->addCoins(10);
					
					$peng->send("%xt%zo%-1%{$peng->coins}%");
					$this->waddlingPenguins[$table][$opponent]->send("%xt%zo%-1%{$this->waddlingPenguins[$table][$opponent]->coins}%");
				} else 				
				{
					$me = $this->waddlingPenguins[$table][$winner] === $peng ? true : false;
					$opponent = $Mancala->winner === 1 ? 0 : 1;
					if ($me) 
					{
						$peng->addCoins($Mancala->points[$winner] * 0.5 + 8);
						$this->waddlingPenguins[$table][$opponent]->addCoins($Mancala->points[$opponent] * 0.5 + 5);
					} else 
					{
						$peng->addCoins($Mancala->points[$winner] * 0.5 + 5);
						$this->waddlingPenguins[$table][$opponent]->addCoins($Mancala->points[$opponent] * 0.5 + 8);
					}

					$peng->send("%xt%zo%-1%{$peng->coins}%");
					$this->waddlingPenguins[$table][$opponent]->send("%xt%zo%-1%{$this->waddlingPenguins[$table][$opponent]->coins}%");
				}
			}
			foreach ($this->waddlingPenguins[$table] as $i => $p) 
			{
				if ($tryMove !== MancalaGame::GAME_OVER)
				{
					list($move, $cupPos) = $tryMove;
					$p->send("%xt%zm%-1%{$seat}%{$cupPos}%{$move}%");
				} else 
					$p->send("%xt%zm%-1%{$seat}%{$cup}%d%");
			}
		}

		if ($gameOver)
		{
			$users = $this->waddlingPenguins[$table];
			foreach ($users as $key => $value) 
			{
				$this->LeaveMancalaGame($value);
			}
		}
	}

	public function GetMancalaGame($peng)
	{
		$table = $peng->waddle;
		$users = $this->waddlingPenguins[$table];
		if (count($users) < 1) return;
		$args = array($users[0]->username);
		$args[] = isset($users[1]) ? $users[1]->username : "";
		$args[] = $this->MancalaHandlers[$table]->getBoardString();

		$args = implode("%", $args);
		$peng->send("%xt%gz%{$peng->room->internalId}%{$args}%");
		
	}

	public function JoinMancalaGame($peng)
	{
		$table = $peng->waddle;
		if (!in_array($table, $this->MancalaTableIds)) return $peng->send("%xt%e%-1%Table doesn't exist%");

		$seat = array_search($peng, $this->waddlingPenguins[$table]);
		if ($seat === false) return $peng->send("%xt%e%-1%You didn't join table%");

		$peng->send("%xt%jz%-1%{$seat}%");
		foreach($this->waddlingPenguins[$table] as $index => $p)
			$p->send("%xt%uz%{$peng->room->internalId}%{$seat}%{$peng->username}%");

		if (count($this->waddlingPenguins[$table]) == count($this->MancalaTables[$table]))
			foreach($this->waddlingPenguins[$table] as $index => $p) $p->send("%xt%sz%-1%0%");
	}

	public function GetMancalaTableString($peng, $table)
	{
		$usersIn = array();
		foreach($this->MancalaTables[$table] as $index => $p) if ($p != null)  $usersIn[] = $p;

		return implode("|", array($table, count($usersIn)));
	}

	public function LeaveMancalaGame($peng)
	{
		$table = $peng->waddle;
		if (!in_array($table, $this->MancalaTableIds)) return;

		$this->MancalaPlayerRemoved($peng);
		$index = array_search($peng, $this->waddlingPenguins[$table]);
		if ($index !== false) array_splice($this->waddlingPenguins[$table], $index, 1);
		$peng->send("%xt%ut%{$peng->room->internalId}%{$table}%".count($this->waddlingPenguins[$table])."%");
	}

	public function MancalaPlayerRemoved($peng)
	{
		if (($index = array_search($peng, $this->MancalaTables[$peng->waddle]))!== false) 
			$this->MancalaTables[$peng->waddle][$index] = null;

		if (($index = array_search($peng, $this->MancalaSpectators[$peng->waddle])) !== false)
			array_splice($this->MancalaSpectators[$peng->waddle], $index, 1);
		
		if (count($this->MancalaTables[$peng->waddle]) == 0) $this->MancalaHandlers[$table]->reset();

		foreach($this->waddlingPenguins[$peng->waddle] as $index => $p) 
			$p->send("%xt%ut%{$p->room->internalId}%{$peng->waddle}%".count($this->waddlingPenguins[$peng->waddle])."%");

		$peng->waddleId = null;
		$peng->waddle = null;


		// One player removed, remove others too.
	}

	public function JoinToMancalaTable($peng, $table)
	{
		if (!in_array($table, $this->MancalaTableIds))
			return $peng->send("%xt%e%-1%No Table Found%");

		$playing = 0;
		foreach ($this->MancalaTables[$table] as $key => $value) if ($value != null) $playing ++;
		if ($playing == 0) $this->MancalaHandlers[$table]->reset();
		if (!in_array($table, array_keys($this->MancalaSpectators))) $this->MancalaSpectators[$table] = array();

		if ($playing == count($this->MancalaTables[$table]))
		{
			// Spectating..
			$FourSpectators[$table][] = $peng;
		} elseif ($playing < count($this->MancalaTables[$table])) 
		{
			$available_seat = -1;
			foreach($this->MancalaTables[$table] as $index => $p) 
				if ($p == null) 
				{
					$available_seat = $index;
					break;
				}
			if ($available_seat < 0) return $peng->send("%xt%e%-1%Found to be cheating??%");
			$this->MancalaTables[$table][$available_seat] = $peng;
		}
		else return;

		$seat = $playing;
		$peng->waddle = $table;
		$peng->waddleId = "MancalaGame";

		if (!isset($this->waddlingPenguins[$peng->waddle])) $this->waddlingPenguins[$peng->waddle] = array();
		$this->waddlingPenguins[$peng->waddle][] = $peng;

		$peng->send("%xt%jt%{$peng->room->internalId}%{$table}%{$seat}%");
		foreach(array_merge($this->MancalaTables[$table], $this->MancalaSpectators[$table]) as $index => $p)
		{
			if ($p != null)
				$p->send("%xt%ut%{$peng->room->internalId}%{$table}%".($seat + 1)."%");
		}
	}

}

?>
