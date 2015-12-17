<?php

namespace Kitsune\ClubPenguin\Handlers\Play;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Packets\Packet;

trait Moderation {

	public function mutePlayer($targetPlayer, $moderatorUsername) {
		if(!$targetPlayer->muted) {
			$targetPlayer->muted = true;
			$targetPlayer->send("%xt%moderatormessage%-1%2%");
			Logger::Info("$moderatorUsername has muted {$targetPlayer->username}");
		} else {
			$targetPlayer->muted = false;
			Logger::Info("$moderatorUsername has unmuted {$targetPlayer->username}");
		}
	}
	
	public function kickPlayer($targetPlayer, $moderatorUsername) {
		$targetPlayer->send("%xt%moderatormessage%-1%3%");
		$this->removePenguin($targetPlayer);
		
		Logger::Info("$moderatorUsername kicked {$targetPlayer->username}");
	}
	
	protected function handleKickPlayerById($socket) {
		$penguin = $this->penguins[$socket];
		
		if($penguin->moderator) {
			$playerId = Packet::$Data[2];
			
			if(is_numeric($playerId)) {
				$targetPlayer = $this->getPlayerById($playerId);
				if($targetPlayer !== null) {
					$this->kickPlayer($targetPlayer, $penguin->username);
				}
			}
		}
	}
	
	protected function handleMutePlayerById($socket) {
		$penguin = $this->penguins[$socket];
		
		if($penguin->moderator) {
			$playerId = Packet::$Data[2];
			
			if(is_numeric($playerId)) {
				$targetPlayer = $this->getPlayerById($playerId);
				if($targetPlayer !== null) {
					$this->mutePlayer($targetPlayer, $penguin->username);
				}
			}
		}
	}
	
	protected function handleInitBan($socket) {
		$penguin = $this->penguins[$socket];

		if($penguin->moderator) {
			$playerId = Packet::$Data[2];
			$phrase = Packet::$Data[3];

			if(is_numeric($playerId)) {
				$targetPlayer = $this->getPlayerById($playerId);
				
				if($targetPlayer !== null) {
					$numberOfBans = $penguin->database->getNumberOfBans($playerId);
					
					$penguin->send("%xt%initban%-1%{$playerId}%0%$numberOfBans%{$phrase}%{$targetPlayer->username}%");
				}
			}
		}
	}
	
	protected function handleModeratorBan($socket) {
		$penguin = $this->penguins[$socket];
		
		$player = Packet::$Data[2];
		$banType = Packet::$Data[3];
		$banReason = Packet::$Data[4];
		$banDuration = Packet::$Data[5];
		$penguinName = Packet::$Data[6];
		$banNotes = Packet::$Data[7];
		
		if($penguin->moderator) {
			if(is_numeric($player)) {
				$targetPlayer = $this->getPlayerById($player);
				if($targetPlayer !== null) {
					if($banDuration !== 0) {
						$targetPlayer->database->updateColumnById($targetPlayer->id, "Banned", strtotime("+".$banDuration." hours"));
					} else {
						$targetPlayer->database->updateColumnById($targetPlayer->id, "Banned", "perm");
					}
					
					$penguin->database->addBan($player, $penguin->username, $banNotes, $banDuration, $banType);
					
					$targetPlayer->send("%xt%ban%-1%$banType%$banReason%$banDuration%$banNotes%");
					
					$this->removePenguin($targetPlayer);
					
					Logger::Info("{$penguin->username} has banned {$targetPlayer->username} for $banDuration hours");
				}
			}
		}
	}
	
	protected function handleModeratorMessage($socket) {
		$penguin = $this->penguins[$socket];
		
		$type = Packet::$Data[1];
		$stype = Packet::$Data[2];
		$player = Packet::$Data[3];
		
		if($penguin->moderator) {
			if(is_numeric($player)) {
				$targetPlayer = $this->getPlayerById($player);
				
				if($targetPlayer !== null) {
					$targetPlayer->send("%xt%moderatormessage%-1%$stype%");
				}
			}
		}
	}
	
}

?>