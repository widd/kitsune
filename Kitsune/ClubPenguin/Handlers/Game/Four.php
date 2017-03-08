<?php
namespace Kitsune\ClubPenguin\Handlers\Game;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Packets\Packet;

use Kitsune\ClubPenguin\Handlers\Game\FindFour;

trait Four
{

	public $FourTableIds = array(205, 206, 207);
	public $FourTables = array(205 => array(null, null), 206 => array(null, null), 207 => array(null, null));
	public $FourSpectators = array(); // id => array(spectator);
	public $FourHandlers = array();

	public function initFourTables()
	{
		$this->on["after-remove"]["FourGame"] = "FourPlayerRemoved";
		$this->handlers["jz"]["FourGame"] = "JoinFourGame";
		$this->handlers["gz"]["FourGame"] = "GetFourGame";
		$this->handlers["zm"]["FourGame"] = "SendFourMove";
		$this->handlers["lz"]["FourGame"] = "LeaveFromFourGame";

		$this->FourHandlers = array(205 => new FindFour(), 206 => new FindFour(), 207 => new FindFour());
	}

	public function LeaveFromFourGame($peng)
	{
		$table = $peng->waddle;
		if (!in_array($table, $this->FourTableIds)) return;
		$seat = array_search($peng, $this->waddlingPenguins[$table]);
		if ($seat === false) return;

		$this->LeaveFourGame($peng);
		foreach ($this->waddlingPenguins[$table] as $index => $p) 
		{
			$p->send("%xt%cz%-1%{$peng->username}%");
			$this->LeaveFourGame($peng);
		}

	}

	public function SendFourMove($peng)
	{
		$gameOver = false;
		$table = $peng->waddle;
		$seat = array_search($peng, $this->waddlingPenguins[$table]);
		if ($seat === false) return $peng->send("%xt%e%-1%Move Hack%");

		$FindFour = $this->FourHandlers[$table];
		if ($FindFour->isCurrentPlayer($seat) && count(Packet::$Data) > 3)
		{
			$column = Packet::$Data[2];
			$row = Packet::$Data[3];

			if ($row > -1 && $row < 6 && $column > -1 && $column < 7)
			{
				$Move = $FindFour->placeChip($column, $row);
				$users = $this->waddlingPenguins[$table];

				if ($Move === FindFour::FoundFour)
				{	
					$points = $FindFour->currentPlayer == 1 ? $FindFour->player1_points : $FindFour->player2_points;
					$peng->addCoins(0.5 * $points + 8);
					
					$peng2 = $users[0] == $peng ? $users[1] : $users[1];
					$peng2->addCoins(0.5 * ($points == $FindFour->player1_points ? $FindFour->player2_points : $FindFour->player1_points) + 5);

					$peng->send("%xt%zo%-1%{$peng->coins}%");
					$peng2->send("%xt%zo%-1%{$peng2->coins}%");

					$gameOver = true;
				} elseif ($Move === FindFour::Tie)
				{
					foreach($users as $index => $p)
					{
						$p->addCoins(8);
						$p->send("%xt%zo%-1%{$p->coins}%");
					}

					$gameOver = true;
				}

				if ($Move === FindFour::InvalidChipPlacement)
				{
					// hacker found.
					return;
				}

				foreach(array_merge($this->waddlingPenguins[$table], $this->FourSpectators[$table]) as $i => $p)
				{
					$p->send("%xt%zm%{$peng->room->internalId}%{$seat}%{$column}%{$row}%");
				}
			} else 
			{
				foreach($this->waddlingPenguins[$table] as $i => $p)
				{
					$p->send("%xt%zm%{$peng->room->internalId}%-1%{$column}%{$row}%");
				}
			}
		}

		if ($gameOver)
		{
			$users = $this->waddlingPenguins[$table];
			foreach ($users as $key => $value) 
			{
				$this->LeaveFourGame($value);
			}
		}
	}

	public function GetFourGame($peng)
	{
		$table = $peng->waddle;
		$users = $this->waddlingPenguins[$table];
		if (count($users) < 1) return;
		$args = array($users[0]->username);
		$args[] = isset($users[1]) ? $users[1]->username : "";
		$args[] = $this->FourHandlers[$table]->convertToString();

		$args = implode("%", $args);
		$peng->send("%xt%gz%{$peng->room->internalId}%{$args}%");
		
	}

	public function JoinFourGame($peng)
	{
		$table = $peng->waddle;
		if (!in_array($table, $this->FourTableIds)) return $peng->send("%xt%e%-1%Table doesn't exist%");

		$seat = array_search($peng, $this->waddlingPenguins[$table]);
		if ($seat === false) return $peng->send("%xt%e%-1%You didn't join table%");

		$peng->send("%xt%jz%-1%{$seat}%");
		foreach($this->waddlingPenguins[$table] as $index => $p)
			$p->send("%xt%uz%{$peng->room->internalId}%{$seat}%{$peng->username}%");

		if (count($this->waddlingPenguins[$table]) == count($this->FourTables[$table]))
			foreach($this->waddlingPenguins[$table] as $index => $p) $p->send("%xt%sz%-1%");
	}

	public function GetFourTableString($peng, $table)
	{
		$usersIn = array();
		foreach($this->FourTables[$table] as $index => $p) if ($p != null)  $usersIn[] = $p;

		return implode("|", array($table, count($usersIn)));
	}

	public function LeaveFourGame($peng)
	{
		$table = $peng->waddle;
		if (!in_array($table, $this->FourTableIds)) return;

		$this->FourPlayerRemoved($peng);
		$index = array_search($peng, $this->waddlingPenguins[$table]);
		if ($index !== false) array_splice($this->waddlingPenguins[$table], $index, 1);
		$peng->send("%xt%ut%{$peng->room->internalId}%{$table}%".count($this->waddlingPenguins[$table])."%");
	}

	public function FourPlayerRemoved($peng)
	{
		if (($index = array_search($peng, $this->FourTables[$peng->waddle]))!== false) 
			$this->FourTables[$peng->waddle][$index] = null;

		if (($index = array_search($peng, $this->FourSpectators[$peng->waddle])) !== false)
			array_splice($this->FourSpectators[$peng->waddle], $index, 1);
		
		if (count($this->FourTables[$peng->waddle]) == 0) $this->FourHandlers[$table]->reset();

		foreach($this->waddlingPenguins[$peng->waddle] as $index => $p) 
			$p->send("%xt%ut%{$p->room->internalId}%{$peng->waddle}%".count($this->waddlingPenguins[$peng->waddle])."%");

		$peng->waddleId = null;
		$peng->waddle = null;


		// One player removed, remove others too.
	}

	public function JoinToFourTable($peng, $table)
	{
		if (!in_array($table, $this->FourTableIds))
			return $peng->send("%xt%e%-1%No Table Found%");

		$playing = 0;
		foreach ($this->FourTables[$table] as $key => $value) if ($value != null) $playing ++;
		if ($playing == 0) $this->FourHandlers[$table]->reset();
		if (!in_array($table, array_keys($this->FourSpectators))) $this->FourSpectators[$table] = array();

		if ($playing == count($this->FourTables[$table]))
		{
			// Spectating..
			$FourSpectators[$table][] = $peng;
		} elseif ($playing < count($this->FourTables[$table])) 
		{
			$available_seat = -1;
			foreach($this->FourTables[$table] as $index => $p) 
				if ($p == null) 
				{
					$available_seat = $index;
					break;
				}
			if ($available_seat < 0) return $peng->send("%xt%e%-1%Found to be cheating??%");
			$this->FourTables[$table][$available_seat] = $peng;
		}
		else return;

		$seat = $playing;
		$peng->waddle = $table;
		$peng->waddleId = "FourGame";

		if (!isset($this->waddlingPenguins[$peng->waddle])) $this->waddlingPenguins[$peng->waddle] = array();
		$this->waddlingPenguins[$peng->waddle][] = $peng;

		$peng->send("%xt%jt%{$peng->room->internalId}%{$table}%{$seat}%");
		foreach(array_merge($this->FourTables[$table], $this->FourSpectators[$table]) as $index => $p)
		{
			if ($p != null)
				$p->send("%xt%ut%{$peng->room->internalId}%{$table}%".($seat + 1)."%");
		}
	}
}

?>
