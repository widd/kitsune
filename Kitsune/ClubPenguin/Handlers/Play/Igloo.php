<?php

namespace Kitsune\ClubPenguin\Handlers\Play;

use Kitsune\ClubPenguin\Packets\Packet;

trait Igloo {

	private $openIgloos = array();

	protected function handleGetFurnitureInventory($socket) {
		$penguin = $this->penguins[$socket];
		
		$furnitureInventory = implode(',', array_map(
			function($furnitureId, $furnitureDetails) {
				list($purchaseDate, $furnitureQuantity) = $furnitureDetails;
				
				return sprintf("%d|%d|%d", $furnitureId, $purchaseDate, $furnitureQuantity);
			}, array_keys($penguin->furniture), $penguin->furniture
		));
		
		$floorInventory = implode(',', array_map(
			function($floorId, $purchaseDate) {
				return sprintf("%d|%d", $floorId, $purchaseDate);
			}, array_keys($penguin->floors), $penguin->floors
		));
		
		$iglooInventory = implode(',', array_map(
			function($iglooType, $purchaseDate) {
				return sprintf("%d|%d", $iglooType, $purchaseDate);
			}, array_keys($penguin->igloos), $penguin->igloos
		));
		
		$locationInventory = implode(',', array_map(
			function($locationId, $purchaseDate) {
				return sprintf("%d|%d", $locationId, $purchaseDate);
			}, array_keys($penguin->locations), $penguin->locations
		));
		
		$penguin->send("%xt%gii%{$penguin->room->internalId}%$furnitureInventory%$floorInventory%$iglooInventory%$locationInventory%");
	}
	
	protected function handleGetActiveIgloo($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[2];
		
		if($penguin->database->playerIdExists($playerId)) {
			$activeIgloo = $penguin->database->getColumnById($playerId, "Igloo");
			
			if($playerId == $penguin->id) {
				$penguin->activeIgloo = $activeIgloo;
			}
			
			$iglooDetails = $penguin->database->getIglooDetails($activeIgloo);
			$penguin->send("%xt%gm%{$penguin->room->internalId}%$playerId%$iglooDetails%");
		}
	}
	
	protected function handleGetGameData($socket) {
		$penguin = $this->penguins[$socket];
		$penguin->send("%xt%ggd%{$penguin->room->internalId}%Kitsune%");
	}
	
	protected function handleBuyIglooLocation($socket) {
		$penguin = $this->penguins[$socket];
		$locationId = Packet::$Data[2];
		
		if(!isset($this->locations[$locationId])) {
			return $penguin->send("%xt%e%-1%402%");
		} elseif(isset($penguin->locations[$locationId])) {
			return $penguin->send("%xt%e%-1%400%");
		}
		
		$cost = $this->locations[$locationId];
		if($penguin->coins < $cost) {
			return $penguin->send("%xt%e%-1%401%");
		} else {
			$penguin->buyLocation($locationId, $cost);
		}
	}
	
	// Should use $penguin->id instead of Packet::$Data[2].. ?
	protected function handleGetAllIglooLayouts($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[2];
		
		if($penguin->database->playerIdExists($playerId)) {
			$iglooLayouts = $penguin->database->getAllIglooLayouts($playerId);
			$activeIgloo = $penguin->database->getColumnById($playerId, "Igloo");
			$totalLikes = $penguin->database->getTotalIglooLikes($playerId);
			
			$penguin->send("%xt%gail%{$penguin->room->internalId}%$playerId%$activeIgloo%$iglooLayouts%");
			$penguin->send("%xt%gaili%{$penguin->room->internalId}%$totalLikes%%");
			
		}
	}
	
	protected function handleUpdateIglooConfiguration($socket) {
		$penguin = $this->penguins[$socket];
		
		$activeIgloo = Packet::$Data[2];
		
		if(is_numeric($activeIgloo) && $penguin->database->ownsIgloo($activeIgloo, $penguin->id)) {
			$iglooType = Packet::$Data[3];
			$floor = Packet::$Data[4];
			$location = Packet::$Data[5];
			$music = Packet::$Data[6];
			$furniture = Packet::$Data[7];
			
			if(is_numeric($iglooType) && is_numeric($floor) && is_numeric($location) && is_numeric($music)) {
				$penguin->activeIgloo = $activeIgloo;
				$penguin->database->updateColumnById($penguin->id, "Igloo", $penguin->activeIgloo);
				$penguin->database->updateIglooColumn($penguin->activeIgloo, "Type", $iglooType);
				$penguin->database->updateIglooColumn($penguin->activeIgloo, "Floor", $floor);
				$penguin->database->updateIglooColumn($penguin->activeIgloo, "Location", $location);
				$penguin->database->updateIglooColumn($penguin->activeIgloo, "Music", $music);
				$penguin->database->updateIglooColumn($penguin->activeIgloo, "Furniture", $furniture);
				
				$penguin->send("%xt%uic%{$penguin->room->internalId}%{$penguin->id}%{$penguin->activeIgloo}%$iglooType:$floor:$location:$music:$furniture%");
				
				$iglooDetails = $penguin->database->getIglooDetails($activeIgloo);
				$penguin->room->send("%xt%uvi%{$penguin->room->internalId}%$activeIgloo%$iglooDetails%");
			}
		}
	}
	
	protected function handleBuyFurniture($socket) {
		$penguin = $this->penguins[$socket];
		$furnitureId = Packet::$Data[2];
		
		if(!isset($this->furniture[$furnitureId])) {
			return $penguin->send("%xt%e%-1%402%");
		}
		
		$cost = $this->furniture[$furnitureId];
		if($penguin->coins < $cost) {
			return $penguin->send("%xt%e%-1%401%");
		} else {
			$penguin->buyFurniture($furnitureId, $cost);
		}
	}
	
	protected function handleSendBuyIglooFloor($socket) {
		$penguin = $this->penguins[$socket];
		$floorId = Packet::$Data[2];
		
		if(!isset($this->floors[$floorId])) {
			return $penguin->send("%xt%e%-1%402%");
		} elseif(isset($penguin->floors[$floorId])) {
			return $penguin->send("%xt%e%-1%400%");
		}
		
		$cost = $this->floors[$floorId];
		if($penguin->coins < $cost) {
			return $penguin->send("%xt%e%-1%401%");
		} else {
			$penguin->buyFloor($floorId, $cost);
		}
		
	}
	
	protected function handleSendBuyIglooType($socket) {
		$penguin = $this->penguins[$socket];
		$iglooId = Packet::$Data[2];
		
		if(!isset($this->igloos[$iglooId])) {
			return $penguin->send("%xt%e%-1%402%");
		} elseif(isset($penguin->igloos[$iglooId])) { // May not be right lol?
			return $penguin->send("%xt%e%-1%500%");
		}
		
		$cost = $this->igloos[$iglooId];
		if($penguin->coins < $cost) {
			return $penguin->send("%xt%e%-1%401%");
		} else {
			$penguin->buyIgloo($iglooId, $cost);
		}
	}
	
	protected function handleAddIglooLayout($socket) {
		$penguin = $this->penguins[$socket];
		
		$layoutCount = $penguin->database->getLayoutCount($penguin->id);
		
		if($layoutCount < 3) {
			$iglooId = $penguin->database->addIglooLayout($penguin->id);
			$penguin->activeIgloo = $iglooId;
			$iglooDetails = $penguin->database->getIglooDetails($iglooId, ++$layoutCount);
			$penguin->send("%xt%al%{$penguin->room->internalId}%{$penguin->id}%$iglooDetails%");
		}
		
	}
	
	protected function handleLoadIsPlayerIglooOpen($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[2];
		
		$open = intval(isset($this->openIgloos[$playerId]));
		
		$penguin->send("%xt%pio%{$penguin->room->internalId}%$open%");
	}
	
	protected function handleCanLikeIgloo($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[1];
		
		if($penguin->database->playerIdExists($playerId)) {
			$activeIgloo = $penguin->database->getColumnById($playerId, "Igloo");
			$likes = $penguin->database->getIglooLikes($activeIgloo);
			
			if(!empty($likes)) {
				foreach($likes as $like) {
					if($like["id"] == $penguin->swid) {
						$likeTime = $like["time"];
						
						if($likeTime < strtotime("-1 day")) {
							$canLike = array(
								"canLike" => true,
								"periodicity" => "ScheduleDaily",
								"nextLike_msecs" => 0
							);
						} else {
							$timeRemaining = (time() - $likeTime) * 1000;
							
							$canLike = array(
								"canLike" => false,
								"periodicity" => "ScheduleDaily",
								"nextLike_msecs" => $timeRemaining
							);
						}
						
						$canLike = json_encode($canLike);
						$penguin->send("%xt%cli%{$penguin->room->internalId}%$activeIgloo%200%$canLike%");
						
						break;
					}
				}
			}
		}
	}
	
	protected function handleUpdateIglooSlotSummary($socket) {
		$penguin = $this->penguins[$socket];
		$activeIgloo = Packet::$Data[2];
		
		if(is_numeric($activeIgloo) && $penguin->database->ownsIgloo($activeIgloo, $penguin->id)) {
			$penguin->activeIgloo = $activeIgloo;
			$penguin->database->updateColumnById($penguin->id, "Igloo", $activeIgloo);
			
			$rawSlotSummary = Packet::$Data[3];
			$slotSummary = explode(',', $rawSlotSummary);
			
			foreach($slotSummary as $summary) {
				list($iglooId, $locked) = explode('|', $summary);
				if(is_numeric($iglooId) && is_numeric($locked)) {
					if($penguin->database->iglooExists($iglooId)) {
						$penguin->database->updateIglooColumn($iglooId, "Locked", $locked);
						
						if($locked == 0 && $penguin->activeIgloo == $iglooId) {
							$this->openIgloos[$penguin->id] = $penguin->username;
						} elseif($locked == 1 && $penguin->activeIgloo == $iglooId) {
							unset($this->openIgloos[$penguin->id]);
						}
					}
				}
			}
			
			$iglooDetails = $penguin->database->getIglooDetails($activeIgloo);
			$penguin->room->send("%xt%uvi%{$penguin->room->internalId}%$activeIgloo%$iglooDetails%");
		}
	}
	
	protected function handleGetOpenIglooList($socket) {
		$penguin = $this->penguins[$socket];
		$totalLikes = $penguin->database->getTotalIglooLikes($penguin->id);
		
		$openIgloos = implode('%', array_map(
			function($playerId, $username) use ($penguin, $totalLikes) {
				if($playerId == $penguin->id) {
					$likes = $totalLikes;
				} else {
					$likes = $penguin->database->getTotalIglooLikes($playerId);
				}
			
				return $playerId . '|' . $username . '|' . $likes . '|0|0';
			}, array_keys($this->openIgloos), $this->openIgloos));
		
		$penguin->send("%xt%gr%{$penguin->room->internalId}%$totalLikes%0%$openIgloos%");
	}
	
	protected function handleGetIglooLikeBy($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[1];
		
		if($penguin->database->playerIdExists($playerId)) {
			$iglooId = $penguin->database->getColumnById($playerId, "Igloo");
			$iglooLikes = $penguin->database->getIglooLikes($iglooId);
			$totalLikes = $penguin->database->getTotalIglooLikes($playerId);
			
			$likes = array(
				"likedby" => array(
					"counts" => array(
						"count" => $totalLikes,
						"maxCount" => $totalLikes,
						"accumCount" => $totalLikes
					),
					"IDs" => $iglooLikes
				)
			);
			
			$likesJson = json_encode($likes);
			$penguin->send("%xt%gili%{$penguin->room->internalId}%{$iglooId}%200%$likesJson%");
		}
	}
	
	protected function handleLikeIgloo($socket) {
		$penguin = $this->penguins[$socket];
		$playerId = Packet::$Data[1];
		
		if($penguin->database->playerIdExists($playerId)) {
			$activeIgloo = $penguin->database->getColumnById($playerId, "Igloo");
			$iglooLikes = $penguin->database->getIglooLikes($activeIgloo);
			$swids = array_column($iglooLikes, "id");
			
			if(in_array($penguin->swid, $swids)) {
				foreach($iglooLikes as $likeIndex => $like) {
					if($like["id"] == $penguin->swid) {
						$like["count"] == ++$like["count"];
						$like["time"] = time();
						$iglooLikes[$likeIndex] = $like;
						
						break;
					}
				}
			} else {
				$like = array(
					"id" => $penguin->swid,
					"time" => time(),
					"count" => 1,
					"isFriend" => false // TODO: Implement buddies
				);
				
				array_push($iglooLikes, $like);
			}
			
			$iglooLikes = json_encode($iglooLikes);
			$penguin->database->updateIglooColumn($activeIgloo, "Likes", $iglooLikes);
		}
	}

}

?>