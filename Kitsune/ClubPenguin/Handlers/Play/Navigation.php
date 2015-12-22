<?php

namespace Kitsune\ClubPenguin\Handlers\Play;

use Kitsune\ClubPenguin\Room;
use Kitsune\ClubPenguin\Packets\Packet;

trait Navigation {

	public function joinRoom($penguin, $roomId, $x = 0, $y = 0) {
		if(!isset($this->rooms[$roomId])) {
			return;
		} elseif(isset($penguin->room)) {
			$penguin->room->remove($penguin);
		}
		
		$this->leaveWaddle($penguin);
		
		$penguin->frame = 1;
		$penguin->x = $x;
		$penguin->y = $y;
		$this->rooms[$roomId]->add($penguin);
	}
	
	// Considering making this public
	protected function getOpenRoom() {
		$spawnRooms = $this->spawnRooms;
		shuffle($spawnRooms);
		
		foreach($spawnRooms as $roomId) {
			if(sizeof($this->rooms[$roomId]->penguins) < 75) {
				return $roomId;
			}
		}
		
		return 100;
	}
	
	protected function handleJoinWorld($socket) {
		$penguin = $this->penguins[$socket];
		
		if($penguin->id != Packet::$Data[2]) {
			return $this->removePenguin($penguin);
		}
		
		$loginKey = Packet::$Data[3];

		// User is attempting to perform exploit
		// See https://github.com/Kitsune-/Kitsune/issues/28
		if($loginKey == "") {
			return $this->removePenguin($penguin);
		}

		$dbLoginKey = $penguin->database->getColumnById($penguin->id, "LoginKey");
		
		if($dbLoginKey != $loginKey) {
			$penguin->send("%xt%e%-1%101%");
			$penguin->database->updateColumnByid($penguin->id, "LoginKey", "");
			return $this->removePenguin($penguin);
		}
		
		$penguin->database->updateColumnByid($penguin->id, "LoginKey", "");
		
		$penguin->loadPlayer();
		
		$this->penguinsById[$penguin->id] = $penguin;
		$this->penguinsByName[$penguin->username] = $penguin;
		
		$penguin->send("%xt%activefeatures%-1%");
		
		$isModerator = intval($penguin->moderator);
		
		list($penguin->EPF['status'], $penguin->EPF['points'], $penguin->EPF['career']) = explode(",", $penguin->database->getColumnById($penguin->id, "EPF"));
		$penguin->EPF = array_reverse($penguin->EPF);

		$penguin->send("%xt%js%-1%1%{$penguin->EPF['status']}%$isModerator%1%");
		
		$stamps = rtrim(str_replace(",", "|", $penguin->database->getColumnById($penguin->id, "Stamps")), "|");
		$penguin->send("%xt%gps%-1%{$penguin->id}%$stamps%");
		
		$puffleData = $penguin->database->getPlayerPuffles($penguin->id);
		$puffles = $this->joinPuffleData($puffleData);
		
		$penguin->send("%xt%pgu%-1%$puffles%");
		
		$playerString = $penguin->getPlayerString();
		$loginTime = time(); // ?
		
		$puffleQuestInfo = explode(",", $penguin->database->getColumnById($penguin->id, "PuffleQuest"));
		$penguin->puffleQuest['canDigGold'] = false;
		$penguin->puffleQuest['nuggets'] = $puffleQuestInfo[0];
		$penguin->puffleQuest['firstDig'] = $puffleQuestInfo[1];
		$penguin->puffleQuest['amountOfDigsToday'] = 0;
		$penguin->puffleQuest['lastDig'] = strtotime("-2 minutes");
		$penguin->puffleQuest['lastDigOC'] = strtotime("-2 minutes");
		$penguin->puffleQuest['rainbowQuest']['canAdopt'] = false;
		$penguin->puffleQuest['rainbowQuest']['coinsCollected'] = array(0 => false, 1 => false ,2 => false, 3 => false);
		$puffleQuest = explode(";", rtrim(trim(stristr($penguin->database->getColumnById($penguin->id, "PuffleQuest"), "|"), "|"), ","));
		$penguin->puffleQuest['rainbowQuest']['currentTask'] = $puffleQuest[0];
		$penguin->puffleQuest['rainbowQuest']['questsDone'] = $puffleQuest[1];
		$penguin->puffleQuest['rainbowQuest']['timestamp'] = $puffleQuest[2];
		$penguin->send("%xt%currencies%-1%1|{$penguin->puffleQuest['nuggets']}%");
		
		$loadPlayer = "$playerString|%{$penguin->coins}%0%1440%$loginTime%{$penguin->age}%0%7521%%7%1%0%211843";
		$penguin->send("%xt%lp%-1%$loadPlayer%");
		
		$openRoom = $this->getOpenRoom();
		$this->joinRoom($penguin, $openRoom, 0, 0);
	}
	
	protected function handleJoinRoom($socket) {
		$penguin = $this->penguins[$socket];
		
		$room = Packet::$Data[2];
		$x = Packet::$Data[3];
		$y = Packet::$Data[4];
		
		$this->joinRoom($penguin, $room, $x, $y);

		if($this->currentlyPlaying > -1) {
			$sharedPlayerTracks = implode(",", $this->broadcastingTracks);
			$sharedTracksCount = count($this->broadcastingTracks);
			
			$penguin->send("%xt%broadcastingmusictracks%-1%$sharedTracksCount%{$this->currentlyPlaying}%$sharedPlayerTracks%");
		}
	}
	
	protected function handleJoinPlayerRoom($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[2];
		$roomType = Packet::$Data[3];
		
		if($penguin->database->playerIdExists($playerId)) {
			$externalId = $playerId + 1000;
			
			if(!isset($this->rooms[$externalId])) {
				$this->rooms[$externalId] = new Room($externalId, $playerId, false);
			}
			
			$penguin->send("%xt%jp%$playerId%$playerId%$externalId%$roomType%");
			$this->joinRoom($penguin, $externalId);
		}
	}
	
	protected function handleRefreshRoom($socket) {
		$penguin = $this->penguins[$socket];
		
		$penguin->room->refreshRoom($penguin);
	}
	
}

?>
