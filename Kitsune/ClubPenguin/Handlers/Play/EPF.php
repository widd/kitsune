<?php

namespace Kitsune\ClubPenguin\Handlers\Play;

use Kitsune\ClubPenguin\Packets\Packet;

trait EPF {

	protected function handleGetAgentStatus($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%epfga%-1%{$penguin->EPF['status']}%");
	}
	
	protected function handleSetAgentStatus($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%epfsa%-1%1%");
		$penguin->EPF['status'] = 1;
		$penguin->database->updateColumnById($penguin->id, "EPF", implode(",", $penguin->EPF));
	}

	protected function handleGetAgentPoints($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%epfgr%-1%{$penguin->EPF['career']}%{$penguin->EPF['points']}%");
	}
	
	protected function handleAddAgentItem($socket) {
		$penguin = $this->penguins[$socket];
		$itemId = Packet::$Data[2];
		if(isset($this->epfItems[$itemId])) {
			if($penguin->EPF['points'] >= $this->epfItems[$itemId]) {
				if(!isset($penguin->inventory[$itemId])) {
					$penguin->EPF['points'] -= $this->epfItems[$itemId];
					$penguin->database->updateColumnById($penguin->id, "EPF", implode(",", $penguin->EPF));
					$penguin->send("%xt%epfai%-1%{$penguin->EPF['points']}%");
					array_push($penguin->inventory, $itemId);
					$penguin->database->updateColumnById($penguin->id, "Inventory", implode('%', $penguin->inventory));
				} else {
					$penguin->send("%xt%e%-1%400%");
				}
			} else {
				$penguin->send("%xt%e%-1%405%");
			}
		} else {
			$penguin->send("%xt%e%-1%402%");
		}
	}
	
	protected function handleGetComMessages($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%epfgm%-1%0%This CPPS is powered by Kitsune!|".time()."|10%");
	}
	
	protected function handleGetRandomGames($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%zr%{$penguin->room->internalId}%" . rand(1, 10) . "," . rand(1, 10) . "," . rand(1, 10) . "%" . rand(1, 5) . "%");
	}
	
	protected function handleGameComplete($socket) {
		$penguin = $this->penguins[$socket];
		$points = Packet::$Data[2];
		$internalId = Packet::$Data[1];
		if($points < 6 && $internalId == $penguin->room->internalId) {
			$penguin->EPF['points'] += $points;
			$penguin->EPF['career'] += $points;
			$penguin->database->updateColumnById($penguin->id, "EPF", implode(",", $penguin->EPF));
			$penguin->send("%xt%zc%{$penguin->room->internalId}%%0%0%0%");
		}
	}
	
}

?>