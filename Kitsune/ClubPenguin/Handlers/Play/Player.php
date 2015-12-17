<?php

namespace Kitsune\ClubPenguin\Handlers\Play;

use Kitsune\ClubPenguin\Packets\Packet;

trait Player {

	// TODO: Add backyard location
	protected function handleGetPlayerLocationById($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[2];

		if(($buddy = $this->getPlayerById($playerId)) !== null) {
			$roomId = $buddy->room->externalId;
			if($roomId == ($buddy->id + 1000)) {
				$penguin->send("%xt%bf%{$penguin->room->internalId}%{$buddy->room->externalId}%igloo%{$buddy->id}%");
			} else {
				$penguin->send("%xt%bf%{$penguin->room->internalId}%{$buddy->room->externalId}%invalid%{$buddy->id}%");
			}
		} else {
			$penguin->send("%xt%bf%-1%-1%invalid%-1%");
		}
	}

	protected function handleLoadPlayerObject($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[2];

		if($penguin->database->playerIdExists($playerId)) {
			$playerArray = $penguin->database->getColumnsById($playerId, array("Username", "Color", "Head", "Face", "Neck", "Body", "Hand", "Feet", "Flag", "Photo"));

			array_splice($playerArray, 1, 0, array(45));

			$playerString = implode("|", $playerArray);
			$penguin->send("%xt%gp%{$penguin->room->internalId}%$playerId|$playerString%");
		}
	}

	protected function handleGetPlayerInfoByName($socket) {
		$penguin = $this->penguins[$socket];
		$playerName = Packet::$Data[2];

		if($penguin->database->usernameExists($playerName)) {
			$playerArray = $penguin->database->getColumnsByName($playerName, array("SWID", "ID", "Username"));
			$penguin->send("%xt%pbn%{$penguin->room->internalId}%{$playerArray["SWID"]}%{$playerArray["ID"]}%{$playerArray["Username"]}%");
		}
	}

	protected function handleGetLastRevision($socket) {
		$this->penguins[$socket]->send("%xt%glr%-1%10915%");
	}
	
	protected function handleGetPlayerInfoById($socket) {
		$penguin = $this->penguins[$socket];
		$penguinId = Packet::$Data[2];
		
		if($penguin->database->playerIdExists($penguinId)) {
			$playerArray = $penguin->database->getColumnsById($penguinId, array("Username", "SWID"));
			$penguin->send("%xt%pbi%{$penguin->room->internalId}%{$playerArray["SWID"]}%$penguinId%{$playerArray["Username"]}%");
		}	
	}
	
	protected function handleSendPlayerMove($socket) {
		$penguin = $this->penguins[$socket];
		
		$penguin->x = Packet::$Data[2];
		$penguin->y = Packet::$Data[3];
		$penguin->room->send("%xt%sp%{$penguin->room->internalId}%{$penguin->id}%{$penguin->x}%{$penguin->y}%"); 
	}
	
	protected function handleSendPlayerFrame($socket) {
		$penguin = $this->penguins[$socket];
		
		$penguin->frame = Packet::$Data[2];
		$penguin->room->send("%xt%sf%{$penguin->room->internalId}%{$penguin->id}%{$penguin->frame}%");
	}
	
	protected function handleSendHeartbeat($socket) {
		$penguin = $this->penguins[$socket];
		
		$penguin->send("%xt%h%{$penguin->room->internalId}%");
	}
	
	protected function handleUpdatePlayerAction($socket) {
		$penguin = $this->penguins[$socket];
		$actionId = Packet::$Data[2];
		
		$penguin->room->send("%xt%sa%{$penguin->room->internalId}%{$penguin->id}%{$actionId}%");
	}
	
	protected function handleGetABTestData($socket) {
		
	}
	
	protected function handleSendEmote($socket) {
		$penguin = $this->penguins[$socket];
		$emoteId = Packet::$Data[2];
		
		$penguin->room->send("%xt%se%{$penguin->room->internalId}%{$penguin->id}%$emoteId%");
	}
	
	protected function handlePlayerThrowBall($socket) {
		$penguin = $this->penguins[$socket];
		
		$x = Packet::$Data[2];
		$y = Packet::$Data[3];
		
		$penguin->room->send("%xt%sb%{$penguin->room->internalId}%{$penguin->id}%$x%$y%");
	}
	
	protected function handleGetBestFriendsList($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%gbffl%{$penguin->room->internalId}%");
	}
	
	protected function handlePlayerBySwidUsername($socket) {
		$penguin = $this->penguins[$socket];
		$swidList = Packet::$Data[2];
		
		$usernameList = $penguin->database->getUsernamesBySwid($swidList);
		$penguin->send("%xt%pbsu%{$penguin->room->internalId}%$usernameList%");
	}
	
	protected function handleSafeMessage($socket) {
		$penguin = $this->penguins[$socket];
		$messageId = Packet::$Data[2];
		
		if(is_numeric($messageId)) {
			$penguin->room->send("%xt%ss%{$penguin->room->internalId}%{$penguin->id}%$messageId%");
		}
	}
	
}

?>