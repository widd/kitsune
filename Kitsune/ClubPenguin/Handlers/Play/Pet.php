<?php

namespace Kitsune\ClubPenguin\Handlers\Play;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Packets\Packet;

trait Pet {

	protected function handleGetPufflesByPlayerId($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[2];
		$roomType = Packet::$Data[3];
		
		if($penguin->database->playerIdExists($playerId)) {
			$puffleData = $penguin->database->getPuffles($playerId, $roomType);
			$ownedPuffles = sizeof($puffleData);
			
			$walkingPuffle = null;
			if(!empty($penguin->walkingPuffle)) {
				list($walkingPuffle) = $penguin->walkingPuffle;
			}
			
			$playerPuffles = $this->joinPuffleData($puffleData, $walkingPuffle, true);
			
			$penguin->send("%xt%pg%{$penguin->room->internalId}%$ownedPuffles%$playerPuffles%");
		}
	}
	
	protected function handleCheckPuffleNameWithResponse($socket) {
		$penguin = $this->penguins[$socket];
		$puffleName = Packet::$Data[2];
		
		$checkName = str_replace(' ', '', $puffleName);
		$nameOkay = intval(ctype_alpha($checkName));
		
		$penguin->send("%xt%checkpufflename%{$penguin->room->internalId}%$puffleName%$nameOkay%");
	}
	
	// Check if they exceed puffle limit (?)
	// Also check if types are valid!
	protected function handleAdoptPuffle($socket) {
		$penguin = $this->penguins[$socket];
		$puffleType = Packet::$Data[2];
		$puffleName = ucfirst(Packet::$Data[3]);
		$puffleSubtype = Packet::$Data[4];
		
		if($puffleSubtype == 0) {
			$puffleCost = 400;
		} else {
			$puffleCost = 800;
		}
		
		if(is_numeric($puffleType) && is_numeric($puffleSubtype)) {
			$puffleId = $penguin->database->adoptPuffle($penguin->id, $puffleName, $puffleType, $puffleSubtype);
			$adoptionDate = time();
			
			if($puffleSubtype == 0) {
				$puffleSubtype = "";
			}
			
			$penguin->buyPuffleCareItem(3, 0, 5, true); // Puffle O's
			$penguin->buyPuffleCareItem(76, 0, 1, true); // Apple
			
			$postcardId = $penguin->database->sendMail($penguin->id, "sys", 0, $puffleName, $adoptionDate, 111);
			$penguin->send("%xt%mr%-1%sys%0%111%$puffleName%$adoptionDate%$postcardId%"); 
			
			$penguin->setCoins($penguin->coins - $puffleCost);
			$penguin->send("%xt%pn%{$penguin->room->internalId}%{$penguin->coins}%$puffleId|$puffleType|$puffleSubtype|$puffleName|$adoptionDate|100|100|100|100|0|0|0|1|%");
			
			$penguin->database->updateColumnById($penguin->id, "Walking", $puffleId);
			$penguin->walkingPuffle = $penguin->database->getPuffleColumns($puffleId, array("Type", "Subtype", "Hat") );
			$penguin->walkingPuffle = array_values($penguin->walkingPuffle);
			array_unshift($penguin->walkingPuffle, $puffleId);
		}
	}
	
	protected function handleGetMyPuffleStats($socket) {
		$penguin = $this->penguins[$socket];
		
		$puffleStats = $penguin->database->getPuffleStats($penguin->id);
		
		$penguin->send("%xt%pgmps%{$penguin->room->internalId}%$puffleStats%");
	}
	
	protected function handleSendPuffleWalk($socket) {
		$penguin = $this->penguins[$socket];
		$puffleId = Packet::$Data[2];
		$walkBoolean = Packet::$Data[3];
		
		if(is_numeric($puffleId) && $penguin->database->ownsPuffle($puffleId, $penguin->id)) {
			if($walkBoolean == 0 || $walkBoolean == 1) {
				$penguin->walkPuffle($puffleId, $walkBoolean);
			}
			
			if($walkBoolean == 0) {
				$penguin->database->updateColumnById($penguin->id, "Walking", 0);
			} else {
				$penguin->database->updateColumnById($penguin->id, "Walking", $puffleId);
			}
		}
	}
	
	protected function handlePuffleSwap($socket) {
		$penguin = $this->penguins[$socket];
		$puffleId = Packet::$Data[2];
		
		if(is_numeric($puffleId) && $penguin->database->ownsPuffle($puffleId, $penguin->id)) {
			$puffle = $penguin->database->getPuffleColumns($puffleId, array("Type", "Subtype", "Hat"));
			$penguin->room->send("%xt%pufflewalkswap%{$penguin->room->internalId}%{$penguin->id}%$puffleId%{$puffle["Type"]}%{$puffle["Subtype"]}%1%{$puffle["Hat"]}%");
			$penguin->database->updateColumnById($penguin->id, "Walking", $puffleId);
			$penguin->walkingPuffle = $penguin->database->getPuffleColumns($puffleId, array("Type", "Subtype", "Hat") );
			$penguin->walkingPuffle = array_values($penguin->walkingPuffle);
			array_unshift($penguin->walkingPuffle, $puffleId);
		}
	}
	
	protected function handlePuffleTrick($socket) {
		$penguin = $this->penguins[$socket];
		$puffleTrick = Packet::$Data[2];
		
		if(is_numeric($puffleTrick)) {
			$penguin->room->send("%xt%puffletrick%{$penguin->room->internalId}%{$penguin->id}%$puffleTrick%");
		}
	}
	
	protected function handleSendChangePuffleRoom($socket) {
		$penguin = $this->penguins[$socket];
		$puffleId = Packet::$Data[2];
		$roomType = Packet::$Data[3];
		
		if($roomType == "igloo" || $roomType == "backyard") {
			if($penguin->database->ownsPuffle($puffleId, $penguin->id)) {
				$toBackyard = intval($roomType == "backyard");
				$penguin->database->sendChangePuffleRoom($puffleId, $toBackyard);
				$penguin->send("%xt%puffleswap%{$penguin->room->internalId}%$puffleId%$roomType%");				
			}
		}
	}
	
	protected function handleGetPuffleCareInventory($socket) {
		$penguin = $this->penguins[$socket];
		
		$careInventory = "";
		
		if(!empty($penguin->careInventory)) {
			$careInventory = implode('%', array_map(
				function($itemId, $quantity) {
					return sprintf("%d|%d", $itemId, $quantity);
				}, array_keys($penguin->careInventory), $penguin->careInventory
			));
		}
		
		$penguin->send("%xt%pgpi%{$penguin->room->internalId}%$careInventory%");
	}
	
	protected function handleSendBuyPuffleCareItem($socket) {
		$penguin = $this->penguins[$socket];
		
		$itemId = Packet::$Data[2];
		
		if(!isset($this->careItems[$itemId])) {
			$penguin->send("%xt%e%-1%402%");
		} else {
			list($itemCost, $itemQuantity) = $this->careItems[$itemId];
			
			if($penguin->coins < $itemCost) {
				$penguin->send("%xt%e%-1%401%");
			} else {
				$penguin->buyPuffleCareItem($itemId, $itemCost, $itemQuantity);
			}
		}
	}
	
	protected function handleGetPuffleHanderStatus($socket) {
		$penguin = $this->penguins[$socket];
		
		$penguin->send("%xt%phg%{$penguin->room->internalId}%1%");
	}
	
	protected function handleVisitorHatUpdate($socket) {
		$penguin = $this->penguins[$socket];
		
		$puffleId = Packet::$Data[2];
		$hatId = Packet::$Data[3];

		if($penguin->database->ownsPuffle($puffleId, $penguin->id) && isset($this->careItems[$hatId])) {
			$penguin->database->updatePuffleColumn($puffleId, "Hat", $hatId);
			
			$penguin->room->send("%xt%puphi%{$penguin->room->internalId}%$puffleId%$hatId%");
		}
	}
	
	protected function handleSendPufflePlay($socket) {
		Logger::Warn("Need to log packets");
	}
	
	protected function handlePenguinOnSlideOrZipline($socket) {
		$penguin = $this->penguins[$socket];
		
		$penguin->room->send("%xt%followpath%{$penguin->room->internalId}%{$penguin->id}%" .  Packet::$Data[2] ."%");
	}
	
	protected function joinPuffleData(array $puffleData, $walkingPuffleId = null, $iglooAppend = false) {
		$puffles = implode('%', array_map(
			function($puffle) use($walkingPuffleId, $iglooAppend) {
				if($puffle["ID"] != $walkingPuffleId) {
					if($puffle["Subtype"] == 0) {
						$puffle["Subtype"] = "";
					}
					
					$playerPuffle = implode('|', $puffle);
					
					if($iglooAppend !== false) {
						$playerPuffle .= "|0|0|0|0";
					}
					
					return $playerPuffle;
				}
			}, $puffleData
		));	
		
		return $puffles;
	}
	
	protected function handlePuffleDig($socket) {
		$startTime = microtime(true);
		$penguin = $this->penguins[$socket];
		if($penguin->puffleQuest['canDigGold']) {
			$chances = array('gold' => array(0, 10), 'coins' => array(10, 20), 'clothing' => array(20, 40), 'gold' => array(40, 100));
		} else {
			$chances = array('nodig' => array(0, 5), 'food' => array(5, 15), 'coins' => array(15, 50), 'clothing' => array(50, 80), 'furniture' => array(80, 100));
		}
		$chance = mt_rand(0, 100);
		$treasure = "coins";
		if(isset($penguin->walkingPuffle[0])) {
			$puffleId = $penguin->walkingPuffle[0];
		} else {
			return; //Player is not walking a puffle. badpenguin.
		}
		if((time() - $penguin->puffleQuest['lastDig'])  < 40) {
			return; //Player is digging too quickly. badpenguin.
		}
		foreach($chances as $name => $action) {
			if($chance >= $action[0] && $chance <= $action[1]) {
				$treasure = $name;
			}
		}
		if($treasure == 'coins') {
			$coins = mt_rand(10, 250);
			$penguin->setCoins($penguin->coins + $coins);
			$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%0%0%$coins%{$penguin->puffleQuest['firstDig']}%false%");
			if($coins > 50) {
				$this->addStamp($penguin, 493);
			}
			if($penguin->puffleQuest['firstDig'] == 1){
				$penguin->puffleQuest['firstDig'] = 0;
				$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
				$this->addStamp($penguin, 489);
				foreach($penguin->room->penguins as $roomPeng) {
					if($roomPeng->id !== $penguin->id) {
						$this->addStamp($roomPeng, 490);
					}
				}
			}
		} elseif($treasure == 'clothing') {
			$this->handleDigClothing($penguin);
		} elseif($treasure == 'nodig') {
			$penguin->room->send("%xt%nodig%{$penguin->room->internalId}%{$penguin->id}%1%");//Sorry mi amigo no treasure for you.
		} elseif($treasure == 'furniture') {
			$this->handleDigFurniture($penguin);
		} elseif($treasure == 'food') {
			$food = array(110, 107, 109, 106, 108, 115, 105, 114, 113, 110, 112, 128);
			$randFood = $food[array_rand($food)];
			$penguin->buyPuffleCareItem($randFood, 0, 1, true);
			$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%1%0%$randFood%{$penguin->puffleQuest['firstDig']}%false%");
		} elseif($treasure == 'gold') {
			$this->handleDigGold($penguin);
		}
		if($treasure !== 'nodig') {
			$penguin->puffleQuest['amountOfDigsToday'] += 1;
			$penguin->puffleQuest['lastDig'] = time();
			if($penguin->puffleQuest['amountOfDigsToday'] > 4) {
				$this->addStamp($penguin, 492);
			}
		}
		$penguin->puffleQuest['lastDig'] = time();
	}
	
	protected function handlePuffleDigOnCommand($socket) {
		$startTime = microtime(true);
		$penguin = $this->penguins[$socket];
		if($penguin->puffleQuest['canDigGold']) {
			$chances = array('gold' => array(0, 10), 'coins' => array(10, 20), 'clothing' => array(20, 40), 'gold' => array(40, 100));
		} else {
			$chances = array('nodig' => array(0, 5), 'food' => array(5, 15), 'coins' => array(15, 50), 'clothing' => array(50, 80), 'furniture' => array(80, 100));
		}
		$chance = mt_rand(0, 100);
		$treasure = "coins";
		if(isset($penguin->walkingPuffle[0])) {
			$puffleId = $penguin->walkingPuffle[0];
		} else {
			return; //Player is not walking a puffle. badpenguin.
		}
		if((time() - $penguin->puffleQuest['lastDigOC'])  < 110) {
			return; //Player is digging too quickly. badpenguin.
		}
		foreach($chances as $name => $action) {
			if($chance >= $action[0] && $chance <= $action[1]) {
				$treasure = $name;
			}
		}
		if($treasure == 'coins') {
			$coins = mt_rand(10, 250);
			$penguin->setCoins($penguin->coins + $coins);
			$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%0%0%$coins%{$penguin->puffleQuest['firstDig']}%false%");
			if($coins > 50) {
				$this->addStamp($penguin, 493);
			}
			if($penguin->puffleQuest['firstDig'] == 1){
				$penguin->puffleQuest['firstDig'] = 0;
				$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
				$this->addStamp($penguin, 489);
				foreach($penguin->room->penguins as $roomPeng) {
					if($roomPeng->id !== $penguin->id) {
						$this->addStamp($roomPeng, 490);
					}
				}
			}
		} elseif($treasure == 'clothing') {
			$this->handleDigClothing($penguin);
		} elseif($treasure == 'furniture') {
			$this->handleDigFurniture($penguin);
		} elseif($treasure == 'food') {
			$food = array(110, 107, 109, 106, 108, 115, 105, 114, 113, 110, 112, 128);
			$favouriteFood = array();
			$randFood = $food[array_rand($food)];
			$penguin->buyPuffleCareItem($randFood, 0, 1, true);
			$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%1%0%$randFood%{$penguin->puffleQuest['firstDig']}%false%");
		} elseif($treasure == 'gold') {
			$this->handleDigGold($penguin);
		}
		if($treasure !== 'nodig') {
			$penguin->puffleQuest['amountOfDigsToday'] += 1;
			if($penguin->puffleQuest['amountOfDigsToday'] > 4) {
				$this->addStamp($penguin, 492);
			}
		}
		$penguin->puffleQuest['lastDigOC'] = time();
	}
	
	protected function handlePuffleDigCooldown($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%getdigcooldown%-1%120%");
	}
	
	protected function handleRevealGoldPuffle($socket) {
		$penguin = $this->penguins[$socket];
		
		if($penguin->puffleQuest['nuggets'] > 14) {
			$penguin->send("%xt%revealgoldpuffle%{$penguin->room->internalId}%{$penguin->id}%");
		}
	}
	
	protected function handleDigFurniture($penguin) {
		$puffleId = $penguin->walkingPuffle[0];
		$furniture = array(507, 305, 502, 150, 616, 369, 340, 506, 149, 313, 370, 504);
		$goldFurniture = array(2130, 2131, 2129, 2132);
		$furniture = ($penguin->walkingPuffle[1] == 11 ? array_merge($furniture, $goldFurniture) : $furniture);
		$unownedFurniture = array();
		foreach($furniture as $furnitureId) {
			if(!isset($penguin->furniture[$furnitureId])) {
				$unownedFurniture[] = $furnitureId;
				//Sadly, there was no other fix or the item was displayed as a null, also in CP you can redig the same furniture as many times as the system decides
			}
		}
		if($unownedFurniture) {
			$furnitureId = $unownedFurniture[array_rand($unownedFurniture)];
			$penguin->furniture[$furnitureId] = array(time(), 1);
			$this->furniture[$furnitureId] = array(time(), 1);
			$furnitureString = implode(',', array_map(
				function($furnitureId, $furnitureDetails) {
					list($purchaseDate, $furnitureQuantity) = $furnitureDetails;
					return $furnitureId . '|' . $purchaseDate . '|' . $furnitureQuantity;
				}, array_keys($penguin->furniture), $penguin->furniture));
				$penguin->database->updateColumnById($penguin->id, "Furniture", $furnitureString);
				$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%2%$furnitureId%1%{$penguin->puffleQuest['firstDig']}%false%");
		} else {
			$penguin->setCoins($penguin->coins + 150);
			$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%0%0%150%{$penguin->puffleQuest['firstDig']}%false%");
		}
		if($penguin->puffleQuest['firstDig'] == 1){
			$penguin->puffleQuest['firstDig'] = 0;
			$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
			$this->addStamp($penguin, 489);
			foreach($penguin->room->penguins as $roomPeng) {
				if($roomPeng->id !== $penguin->id) {
					$this->addStamp($roomPeng, 490);
				}
			}
		}
	}
	
	protected function handleDigClothing($penguin) {
		$puffleId = $penguin->walkingPuffle[0];
		$items = array(118, 469, 412, 184, 774, 122, 498, 374, 1159, 326, 5080, 3028, 232, 112, 105, 111, 1082, 366, 1056, 790, 4039, 14523, 11343, 4154, 4082, 4199, 6219, 3205, 1196, 3003, 3183, 5100,11456, 12076, 15149, 9061, 4990, 4261, 4370, 4883, 24083, 1160, 1304, 9094, 4420, );
		$goldItems = array(6209, 5386, 5385, 5384, 4994, 4993, 3187, 3186, 3185, 2139, 2138, 2137, 2136, 1735, 1734, 5434, 5382);
		$items = ($penguin->walkingPuffle[1] == 11 ? array_merge($items, $goldItems) : $items);
		$unownedItems = array();
		foreach($items as $item) {
			if(!in_array($item, $penguin->inventory)) {
				$unownedItems[] = $item;
			}
		}
		if($unownedItems) {
			$itemId = $unownedItems[array_rand($unownedItems)];
			array_push($penguin->inventory, $itemId);
			$penguin->database->updateColumnById($penguin->id, "Inventory", implode('%', $penguin->inventory));
			$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%3%$itemId%1%{$penguin->puffleQuest['firstDig']}%false%");
			$this->addStamp($penguin, 494);
		} else {
				$penguin->setCoins($penguin->coins + 150);
				$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%0%0%150%{$penguin->puffleQuest['firstDig']}%false%");
		}
		if($penguin->puffleQuest['firstDig'] == 1){
			$penguin->puffleQuest['firstDig'] = 0;
			$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
			$this->addStamp($penguin, 489);
			foreach($penguin->room->penguins as $roomPeng) {
				if($roomPeng->id !== $penguin->id) {
					$this->addStamp($roomPeng, 490);
				}
			}
		}
	}
	
	protected function handleDigGold($penguin) {
		$puffleId = $penguin->walkingPuffle[0];
		if($penguin->puffleQuest['nuggets'] < 15) {
			$nuggets = ($penguin->puffleQuest['nuggets'] < 13 ? mt_rand(1, 3) : 1);
			$penguin->puffleQuest['nuggets'] += $nuggets;
			$penguin->send("%xt%currencies%-1%1|{$penguin->puffleQuest['nuggets']}%");
			$penguin->room->send("%xt%puffledig%{$penguin->room->internalId}%{$penguin->id}%$puffleId%4%0%$nuggets%0%false%");
			$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
		}
	}
	
	protected function handlePuffleCareItemDelivered($socket) {
		$penguin = $this->penguins[$socket];
		$puffleId = $penguin->walkingPuffle[0];
		$careId = Packet::$Data[3];
		$penguin->room->send("%xt%pcid%{$penguin->room->internalId}%$puffleId%$careId%");//May be incorrect? I think it's meant to send puffle stats?
		if(Packet::$Data[3] == 126) {
			$penguin->room->send("%xt%oberry%{$penguin->room->internalId}%{$penguin->id}%$puffleId%");
			$penguin->room->send("%xt%currencies%-1%1|{$penguin->puffleQuest['nuggets']}%");
			$penguin->puffleQuest['canDigGold'] = true;
		}
	}
	
	protected function handlePuffleCheckName($socket) {
		$penguin = $this->penguins[$socket];
		$internalId = Packet::$Data[1];
		$puffleName = Packet::$Data[2];
		$penguin->send("%xt%pcn%{$penguin->room->internalId}%$puffleName%");
		if($internalId == 33) {
			$penguin->puffleQuest['rainbowQuest']['canAdopt'] = false;
			$penguin->puffleQuest['rainbowQuest']['timestamp'] = strtotime("+20 minutes");
			$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
		} else {
			$penguin->puffleQuest['canDigGold'] = false;
			$penguin->puffleQuest['nuggets'] = 0;
			$penguin->room->send("%xt%currencies%-1%1|0%");
			$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
		}
	}
	
	protected function handleRainbowCookieData($socket) {
		$penguin = $this->penguins[$socket];
		$currentTask = $penguin->puffleQuest['rainbowQuest']['currentTask'];
		$questsDone = $penguin->puffleQuest['rainbowQuest']['questsDone'];
		$tasks = array(false, false, false, false);
		$jsonArray['currTask'] = $currentTask;
		$jsonArray['questsDone'] = $questsDone;
		foreach($tasks as $key => $task) {
			if($currentTask > ($key)) {
				$tasks[$key] = true;
			}
			$jsonArray['tasks'][$key]['completed'] = $tasks[$key];
			if($penguin->puffleQuest['rainbowQuest']['coinsCollected'][$key] == true) {
				$jsonArray['tasks'][$key]['coin'] = 2;
			} else {
				$jsonArray['tasks'][$key]['coin'] = 1;
			}
			$jsonArray['tasks'][$key]['item'] = 1;
		}
		if($penguin->puffleQuest['rainbowQuest']['currentTask'] > 3) {
			$jsonArray['bonus'] = 1;
			$jsonArray['cannon'] = true;
			$time = (round(($penguin->puffleQuest['rainbowQuest']['timestamp'] - strtotime('now')) / 60) < 0 ? 0 : round(($penguin->puffleQuest['rainbowQuest']['timestamp'] - strtotime('now')) / 60));
			if($time < 1 && $penguin->puffleQuest['rainbowQuest']['canAdopt'] == false) {
				$penguin->puffleQuest['rainbowQuest']['currentTask'] = 0;
				$penguin->puffleQuest['rainbowQuest']['timestamp'] = strtotime('now');
				$jsonArray['cannon'] = false;
				$currentTask = 0;
			} else {
				$jsonArray['currTask'] -= 1;
				$jsonArray['cannon'] = true;
			}
		} else {
			$jsonArray['bonus'] = 0;
			$jsonArray['cannon'] = false;
		}
		$jsonArray['taskAvail'] = $penguin->puffleQuest['rainbowQuest']['timestamp'];
		$jsonArray['hoursRemaining'] = (round(($penguin->puffleQuest['rainbowQuest']['timestamp'] - strtotime('now')) / 3600) < 0 ? 0 : round(($penguin->puffleQuest['rainbowQuest']['timestamp'] - strtotime('now')) / 3600));
		$jsonArray['minutesRemaining'] = (round(($penguin->puffleQuest['rainbowQuest']['timestamp'] - strtotime('now')) / 60) < 0 ? 0 : round(($penguin->puffleQuest['rainbowQuest']['timestamp'] - strtotime('now')) / 60));
		$cookieData = json_encode($jsonArray);
		$penguin->send("%xt%rpqd%{$penguin->room->internalId}%$cookieData%");
		$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
	}
	
	protected function handleRainbowTaskComplete($socket) {
		$penguin = $this->penguins[$socket];
		if(Packet::$Data[2] !== 0) {
			$tasks = array(0 => array(215, 364), 1 => array(517, 192), 2 => array(148, 329), 3 => array(417, 153));
			$tasks2 = array(0 => array(88, 364), 1 => array(616, 192), 2 => array(183, 387), 3 => array(534, 153));
			$taskId = $penguin->puffleQuest['rainbowQuest']['currentTask'];
			$completedTask = false;
			if(isset($tasks[$taskId])) {
				if($penguin->x == $tasks[$taskId][0] && $penguin->y == $tasks[$taskId][1]) {
					$completedTask = true;
				} elseif($penguin->x == $tasks2[$taskId][0] && $penguin->y == $tasks2[$taskId][1]) {
					$completedTask = true;
				}
				if($completedTask) {
					$penguin->puffleQuest['rainbowQuest']['currentTask']++;
					if($penguin->puffleQuest['rainbowQuest']['currentTask'] > 3) {
						$penguin->puffleQuest['rainbowQuest']['canAdopt'] = true;
						$penguin->puffleQuest['rainbowQuest']['timestamp'] = strtotime("+20 minutes");
					}else{
						$penguin->puffleQuest['rainbowQuest']['timestamp'] = strtotime("+20 minutes");
					}
					$penguin->database->updateColumnById($penguin->id, "PuffleQuest", $penguin->puffleQuest['nuggets'].",".$penguin->puffleQuest['firstDig'].",|".$penguin->puffleQuest['rainbowQuest']['currentTask'].";".$penguin->puffleQuest['rainbowQuest']['questsDone'].";".$penguin->puffleQuest['rainbowQuest']['timestamp'].";");
				}
			}
		}
	}
	
	protected function handleRainbowCoinCollect($socket) {
		$penguin = $this->penguins[$socket];
		$taskId = Packet::$Data[2];
		if(is_numeric($taskId) && $taskId < 4) {
			if($penguin->puffleQuest['rainbowQuest']['coinsCollected'][$taskId] !== true) {
				$coins = ($taskId + 1) * 50;
				$penguin->setCoins($penguin->coins + $coins);
				$penguin->puffleQuest['rainbowQuest']['coinsCollected'][$taskId] = true;
				$penguin->send("%xt%rpqcc%{$penguin->room->internalId}%$taskId%2%{$penguin->coins}%");
			}
		}
	}
	
	protected function handleRainbowItemCollect($socket) {
		$penguin = $this->penguins[$socket];
		$taskId = Packet::$Data[2];
		$items = array(6158, 4809, 1560, 3159);
		if(is_numeric($taskId) && $taskId < 4) {
			$itemId = $items[$taskId];
			if(!in_array($itemId, $penguin->inventory)) {
				array_push($penguin->inventory, $itemId);
				$penguin->database->updateColumnById($penguin->id, "Inventory", implode('%', $penguin->inventory));
				$penguin->send("%xt%ai%{$penguin->room->internalId}%$itemId%{$penguin->coins}%");
			} else {
				$penguin->send("%xt%e%-1%400%");
			}
		}
	}
	
	protected function handleRainbowBonusCollect($socket) {
		$penguin = $this->penguins[$socket];
		if(!in_array(5220, $penguin->inventory)) {
			array_push($penguin->inventory, 5220);
			$penguin->database->updateColumnById($penguin->id, "Inventory", implode('%', $penguin->inventory));
			$penguin->send("%xt%ai%{$penguin->room->internalId}%5220%{$penguin->coins}%");
		} else {
			$penguin->send("%xt%e%-1%400%");
		}
	}
	
	protected function handlePuffleCurrencies($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%currencies%-1%1|{$penguin->puffleQuest['nuggets']}%");
	}

}

?>
