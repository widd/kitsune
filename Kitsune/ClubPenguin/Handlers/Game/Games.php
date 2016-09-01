<?php
namespace Kitsune\ClubPenguin\Handlers\Game;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Room;
use Kitsune\ClubPenguin\Packets\Packet;

trait Games
{
	//Probably find another good method??
	public $rinkPos = array(0, 0, 0, 0); // x, y, x-speed, y-speed

	public $waddles = array(103 => array(null, null), 102=>array(null, null), 
		101 => array(null, null, null), 100 => array(null, null, null, null)); // string, list(penguin)
	public $WaddleIds = array(103, 102, 101, 100);

	public $waddleRoomId = array(103=>999, 102=>999, 101=>999, 100=>999); // string, string
	public $waddlingPenguins = array(); // string, list(penguin)

	public $on = array();
	public $handlers = array(
		"w#jx" => array(103 => "JoinSled", 102 => "JoinSled", 101 => "JoinSled", 100 => "JoinSled"), 
		"gz" => array(205 => "GetFourGame", 206 => "GetFourGame", 207 => "GetFourGame"), 
		"jz" => array(103 => "handleSledJoin", 102 => "handleSledJoin", 101 => "handleSledJoin", 100 => "handleSledJoin"), 
		"zm" => array(103 => "handleSledMove", 102 => "handleSledMove", 101 => "handleSledMove", 100 => "handleSledMove"),
		"uz" => array(),
		"lz" => array();

	public function JoinSled($peng)
	{
		$peng->send("%xt%jx%{$peng->room->internalId}%999%");
	}

	public function handleSledJoin($peng)
	{
		$waddleId = $peng->waddle;
		$users = $this->waddlingPenguins[$waddleId];

		$seat = array_search($peng, $users);
		if ($seat === false) return;

		$string = [];
		foreach ($users as $key => $p) 
		{
			$string[] = $p->username . "|" . $p->color . "|0|" . strtolower($p->username);
		}

		$string = implode("%", $string);
		$peng->send("%xt%uz%-1%" . count($users) . "%" . $string . "%");
	}

	public function handleSledMove($peng)
	{
		$waddleId = $peng->waddle;
		$users = $this->waddlingPenguins[$waddleId];

		$seat = array_search($peng, $users);
		if ($seat === false)
			return;

		if (count(Packet::$Data < 5)) return;
		$s = Packet::$Data[3];
		$y = Packet::$Data[4];
		$gameTime = Packet::$Data[5];

		foreach ($users as $key => $p) 
		{
			$p->send("%xt%zm%-1%{$seat}%{$s}%{$y}%{$t}%");
		}
	}

	public function initGames()
	{
		//$this->on["waddle"]["FourGame"] = "UpdateFourTable";

		$this->worldHandlers["s"]["a#jt"] = "JoinToTable";
		$this->worldHandlers["s"]["a#gt"] = "GetTableString";
		$this->worldHandlers["s"]["a#lt"] = "LeaveTable";
		
		$this->handlers["a#jt"][205] = "JoinToFourTable";
		$this->handlers["a#jt"][206] = "JoinToFourTable";
		$this->handlers["a#jt"][207] = "JoinToFourTable";

		$this->handlers["a#gt"][205] = "GetFourTableString";
		$this->handlers["a#gt"][206] = "GetFourTableString";
		$this->handlers["a#gt"][207] = "GetFourTableString";

		$this->handlers["a#lt"][205] = "LeaveFourGame";
		$this->handlers["a#lt"][206] = "LeaveFourGame";
		$this->handlers["a#lt"][207] = "LeaveFourGame";

		$this->initFourTables();
		$this->initMancalaTables();

		$this->worldHandlers["z"]["zo"] = "GameOver";
		$this->worldHandlers["z"]["m"] = "SoccerMove";
	}

	public function SoccerMove($socket)
	{
		$peng = $this->penguins[$socket];
		$playerId = Packet::$Data[2];

		$this->rinkPos = array_slice(Packet::$Data, 3);
		$peng->room->send("%xt%zm%-1%{$playerId}%" . implode("%", $this->rinkPos) . "%");
	}

	public function LeaveTable($socket)
	{
		$peng = $this->penguins[$socket];
		$table = $peng->waddle;

		if (isset($this->handlers["a#lt"][$table]))
		{
			call_user_func(array($this, $this->handlers["a#lt"][$table]), $peng);
		}	
	}

	public function GetTableString($socket)
	{
		$peng = $this->penguins[$socket];
		$tables = array_splice(Packet::$Data, 2);

		$args = array();
		foreach ($tables as $index => $table) 
		{
			if (isset($this->handlers["a#gt"][$table]))
				$args[] = call_user_func(array($this, $this->handlers["a#gt"][$table]), $peng, $table);
			else $args[] = "";
		}

		$args = implode("%", $args);
		$peng->send("%xt%gt%{$peng->room->internalId}%{$args}%");
	}

	public function JoinToTable($socket)
	{
		$peng = $this->penguins[$socket];
		$table = Packet::$Data[2];

		if (isset($this->handlers["a#jt"][$table]))
		{
			call_user_func(array($this, $this->handlers["a#jt"][$table]), $peng, $table);
		}
	}

	public function GameOver($socket)
	{
		$peng = $this->penguins[$socket];
		$score = Packet::$Data[2];

		$peng->addCoins(0.5*$score + 1.5);

		if (isset($this->gameStamps[$peng->room->externalId]))
		{
			$Stamps = explode(",", $peng->database->getColumnById($peng->id, "Stamps"));
			$Collected = array_intersect($Stamps, $this->gameStamps[$peng->room->externalId]);
			$CollectedStamps = implode("|", $Collected);

			$GameStamps = array_merge(...array_values($this->gameStamps));

			$peng->send("%xt%zo%-1%{$peng->coins}%{$CollectedStamps}%" . count($Collected) . "%" . count($this->gameStamps[$peng->room->externalId]) . "%" . count($Stamps) . "%");
		} else 
		{
			$peng->send("%xt%zo%-1%{$peng->coins}%%%%%");
		}
	}

	public function SendMove($socket)
	{
		$peng = $this->penguins[$socket];

		if (isset($this->handlers["zm"][$peng->waddleId]))
		{
			call_user_func(array($this, $this->handlers["zm"][$peng->waddleId]), $peng);
		}
	}

	public function JoinGame($socket)
	{
		$peng = $this->penguins[$socket];
		Logger::Info($peng->username. " join game: ". $peng->waddleId);

		if (isset($this->handlers["jz"][$peng->waddleId]))
		{
			call_user_func(array($this, $this->handlers["jz"][$peng->waddleId]), $peng);
		}
	}

	public function LeaveGame($socket)
	{
		$peng = $this->penguins[$socket];
		Logger::Info($peng->username. " Levaing game: ". $peng->waddleId);

		if (isset($this->handlers["lz"][$peng->waddleId]))
		{
			call_user_func(array($this, $this->handlers["lz"][$peng->waddleId]), $peng);
		}
	}

	public function GetGame($socket)
	{
		$peng = $this->penguins[$socket];

		// Find other good method for this??
		if ($peng->room->externalId == 802)
			return $peng->send("%xt%gz%-1%" . implode("%", $this->rinkPos) . "%");
		
		Logger::Info($peng->username. " get game: ". $peng->waddleId);

		if (isset($this->handlers["gz"][$peng->waddleId]))
		{
			call_user_func(array($this, $this->handlers["gz"][$peng->waddleId]), $peng);
		}
	}

	public function AddPlayerToWaddle($socket)
	{
		$peng = $this->penguins[$socket];
		Logger::Info($peng->username. ", adding to waddle: ". $peng->waddleId);

		$roomId = $peng->waddle;
		echo "extid - " . $peng->room->externalId;
		$extId = $this->waddleRoomId[$peng->waddleId];

		$peng->intid = $this->rooms[$extId]->internalId;
		if (!isset($this->waddlingPenguins[$roomId]))
		{
			return;
		}

		$this->waddlingPenguins[$roomId][] = $peng;

		if (isset($this->handlers["w#jx"][$peng->waddleId]))
		{
			call_user_func(array($this, $this->handlers["w#jx"][$peng->waddleId]), $peng);
		}
	}

	public function GetWaddles($socket)
	{

		$peng = $this->penguins[$socket];
		Logger::Info($peng->username. " getting waddle: ". $peng->waddleId);

		$waddleIds = array_slice(Packet::$Data, 2);
		$waddles = array();

		foreach ($waddleIds as $index => $id) 
		{
			if (in_array($id, $this->WaddleIds))
			{
				$waddling = array();
				foreach ($this->waddles[$id] as $key => $p) 
				{
					$waddling[] = $p->username;
				}

				$waddles[] = implode("|", array($id, implode(",", $waddling)));
			} else 
			{
				$waddles[] = implode("|", array($id, ""));
			}
		}

		$WADDLES = implode("%", $waddles);
		$peng->send("%xt%gw%{$peng->room->internalId}%{$WADDLES}%");
	}

	public function ReleasePlayerWaddle($socket)
	{

		$peng = $this->penguins[$socket];
		Logger::Info($peng->username. " removing waddle: ". $peng->waddleId);
		$wid = $peng->waddleId;

		foreach ($this->waddles as $id => $ps) 
		{
			if (in_array($peng, $ps))
			{
				$seat = array_search($peng, $ps);
				$this->waddles[$id][$seat] = null;

				$args = array("uw", $id, $seat);
				$peng->room->send("%xt%uw%-1%{$id}%{$seat}%");	

				if (isset($this->waddles[$peng->waddleId]))
				{
					if (in_array($peng, $this->waddles[$peng->waddleId]))
					{
						$index = array_search($peng, $this->waddles[$peng->waddleId]);
						$this->waddles[$peng->waddleId][$index] = null;
					}
				}

				foreach ($ps as $index => $p) 
				{
					if ($p != null) $p->send("%xt%uw%-1%{$id}%{$seat}%");
				}
			}
		}

		if (isset($this->on["after"][$wid]))
		{
			call_user_func(array($this, $this->on["after"][$wid]), $peng);
		}

		$peng->intid = "";
	}

	public function JoinPlayerWaddle($socket)
	{
		$peng = $this->penguins[$socket];

		$id = Packet::$Data[2];
		Logger::Info($peng->username. " join waddle: ". $id);
		$this->ReleasePlayerWaddle($peng->socket);

		if (!in_array($id, $this->WaddleIds))
		{
			$peng->send("%xt%e%-1%%");
			return;
		}

		$index = -1;
		foreach ($this->waddles[$id] as $ind => $p) 
		{
			if ($p == null)
			{
				$index = $ind;
				break;
			}
		}

		if ($index == -1)
		{
			// Event it later??
			//$this->JoinPlayerWaddle($penguin->socket);
			return;
		}

		$this->waddles[$id][$index] = $peng;
		$seat = $index;//sizeof($this->waddles);
		$peng->waddleId = $id;
		$peng->send("%xt%jw%-1%{$seat}%");
		$usersInWaddle = array();
		foreach ($this->waddles[$id] as $index => $p) 
		{
			if ($p != null) array_push($usersInWaddle, $p);
		}

		if (isset($this->on["waddle"][$id]))
		{
			call_user_func(array($this, $this->on["waddle"][$id]), $peng);
		}

		if (count($usersInWaddle) === count($this->waddles[$id]))
		{
			$this->StartPlayerWaddle($id, $peng);
		}

		$peng->room->send("%xt%uw%-1%{$id}%{$seat}%{$peng->username}%{$peng->id}%");

	}

	public function StartPlayerWaddle($id, $peng)
	{
		Logger::Info($peng->username. " start waddle: ". $peng->waddleId);
		if (isset($this->on["after"][$id]))
		{
			call_user_func(array($this, $this->on["after"][$id]), $peng);
		}

		$extId = $this->waddleRoomId[$id];
		$intId = $this->rooms[$extId]->internalId;

		$waddleroomid = "-".$intId;
		$roomIndex = sizeof($this->waddlingPenguins);

		$this->waddlingPenguins[$roomIndex] = array();
		foreach ($this->waddles[$id] as $i => $p) 
		{
			$p->waddle = $roomIndex;
			$p->waddleId = $id;

			$count = sizeof($this->waddles[$id]);
			
			$p->room->remove($p);
			$this->rooms[$this->waddleRoomId[$id]]->add($p);

			$p->send("%xt%sw%{$intId}%{$extId}%{$waddleroomid}%{$count}%");
		}

		if (isset($this->on["after-start"][$id])) call_user_func(array($this, $this->on["after-start"][$id]), $peng);
		foreach ($this->waddles[$id] as $index => $p) 
		{
			$this->waddles[$id][$index] = null;
		}

		if (isset($this->on["after"][$id])) call_user_func(array($this, $this->on["after"][$id]), $peng);
	}

	public function UpdateGame($socket)
	{
		$peng = $this->penguins[$socket];

		if (isset($this->handlers["uz"][$peng->waddleId]))
		{
			call_user_func(array($this, $this->handlers["uz"][$peng->waddleId]), $peng);
		}
	}

	public function RemovePenguinFromWaddle($peng)
	{
		$roomIndex = $peng->waddle;
		$i = null;
		if (isset($this->waddlingPenguins[$roomIndex]))
		{
			$penguins = $this->waddlingPenguins[$roomIndex];
			$i = array_search($peng, $penguins);
			foreach ($this->waddlingPenguins[$roomIndex] as $index => $p) 
			{
				$p->send("%xt%rp%-1%{$peng->id}%");
			}
			if (isset($this->waddleRoomId[$peng->waddleId]))
				$this->rooms[$this->waddleRoomId[$peng->waddleId]]->remove($peng);

			if ($i !== false) 
			{
				array_splice($this->waddlingPenguins[$roomIndex], $i, 1);
			}
			if (isset($this->on["after-remove"][$peng->waddleId]))
			{
				call_user_func(array($this, $this->on["after-remove"][$peng->waddleId]), $peng);
			}

			if (count($this->waddlingPenguins[$roomIndex]) == 0) array_splice($this->waddlingPenguins, $roomIndex, 1);
		}
		$peng->waddle = "";
	}
}

?>
