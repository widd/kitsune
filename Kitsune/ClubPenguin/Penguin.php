<?php

namespace Kitsune\ClubPenguin;

use Kitsune;
use Kitsune\Logging\Logger;

class Penguin {

	public $id;
	public $username;
	public $swid;

	public $identified;
	public $randomKey;
	
	public $color, $head, $face, $neck, $body, $hand, $feet, $photo, $flag;
	public $age;

	public $avatar;
	public $avatarAttributes;
	
	public $coins;
	
	public $careInventory = array();
	public $inventory = array();
	
	public $moderator;
	public $muted = false;
	
	public $membershipDays;
	
	public $activeIgloo;
	
	public $furniture = array();
	public $locations = array();
	public $floors = array();
	public $igloos = array();
	public $recentStamps = "";
	
	public $x = 0;
	public $y = 0;
	public $frame;
	
	public $tableId = null;

	public $waddleRoom = null; // Not an object!
	public $room;
	
	public $walkingPuffle = array();
	public $puffleQuest = array();
	
	public $socket;
	public $database;

	public $handshakeStep = null;
	public $ipAddress = null;
	
	public function __construct($socket) {
		$this->socket = $socket;
		socket_getpeername($socket, $this->ipAddress);
		// $this->database = new Kitsune\Database();
	}

	public function addCoins($coins) {
		$totalCoins = $this->coins + $coins;
		$this->setCoins($totalCoins);
		$this->send("%xt%zo%{$this->room->internalId}%$totalCoins%");
	}
	
	public function buyPuffleCareItem($itemId, $itemCost = 0, $howMany = null, $beSilent = false) {
		if(isset($this->careInventory[$itemId])) {
			$itemQuantity = $this->careInventory[$itemId] + $howMany;
		} else {
			$itemQuantity = $howMany;
		}
		
		if($itemCost !== 0) {
			$this->setCoins($this->coins - $itemCost);
		}
		
		$this->careInventory[$itemId] = $itemQuantity;
		
		$careInventory = implode('%', array_map(
			function($itemId, $itemQuantity) {
				return sprintf("%d|%d", $itemId, $itemQuantity);
			}, array_keys($this->careInventory), $this->careInventory
		));
		
		$this->database->updateColumnById($this->id, "CareInventory", $careInventory);
		
		if($beSilent !== true) {
			$this->send("%xt%papi%{$this->room->internalId}%{$this->coins}%$itemId%$itemQuantity%");
		}
	}
	
	public function setCoins($coinAmount) {
		$this->coins = $coinAmount;
		
		$this->database->updateColumnById($this->id, "Coins", $this->coins);
	}
	
	public function walkPuffle($puffleId, $walkBoolean) {
		if($walkBoolean != 0) {
			$this->walkingPuffle = $this->database->getPuffleColumns($puffleId, array("Type", "Subtype", "Hat"));
			$this->walkingPuffle = array_values($this->walkingPuffle);
			array_unshift($this->walkingPuffle, $puffleId);
		}
		
		list($id, $type, $subtype, $hat) = $this->walkingPuffle;
		
		if($walkBoolean == 0) {
			$this->walkingPuffle = array();
		}
		
		$this->room->send("%xt%pw%{$this->room->internalId}%{$this->id}%$id%$type%$subtype%$walkBoolean%$hat%");
	}
	
	public function buyIgloo($iglooId, $cost = 0) {
		$this->igloos[$iglooId] = time();
		
		$igloosString = implode(',', array_map(
			function($igloo, $purchaseDate) {
				return $igloo . '|' . $purchaseDate;
			}, array_keys($this->igloos), $this->igloos));
		
		$this->database->updateColumnById($this->id, "Igloos", $igloosString);
		
		if($cost !== 0) {
			$this->setCoins($this->coins - $cost);
		}
		
		$this->send("%xt%au%{$this->room->internalId}%$iglooId%{$this->coins}%");
	}
	
	public function buyFloor($floorId, $cost = 0) {
		$this->floors[$floorId] = time();
		
		$flooringString = implode(',', array_map(
			function($floor, $purchaseDate) {
				return $floor . '|' . $purchaseDate;
			}, array_keys($this->floors), $this->floors));
		
		$this->database->updateColumnById($this->id, "Floors", $flooringString);
		
		if($cost !== 0) {
			$this->setCoins($this->coins - $cost);
		}
		
		$this->send("%xt%ag%{$this->room->internalId}%$floorId%{$this->coins}%");
	}
	
	public function buyFurniture($furnitureId, $cost = 0) {
		$furnitureQuantity = 1;
		
		if(isset($this->furniture[$furnitureId])) {
			list($lastPurchaseDate, $furnitureQuantity) = $this->furniture[$furnitureId];
			
			$furnitureQuantity += 1;
		}
		
		$this->furniture[$furnitureId] = array(time(), $furnitureQuantity);
		
		$furnitureString = implode(',', array_map(
			function($furnitureId, $furnitureDetails) {
				list($purchaseDate, $furnitureQuantity) = $furnitureDetails;
				return $furnitureId . '|' . $purchaseDate . '|' . $furnitureQuantity;
			}, array_keys($this->furniture), $this->furniture));
		
		$this->database->updateColumnById($this->id, "Furniture", $furnitureString);
		
		if($cost !== 0) {
			$this->setCoins($this->coins - $cost);
		}
		
		$this->send("%xt%af%{$this->room->internalId}%$furnitureId%{$this->coins}%");
	}
	
	public function buyLocation($locationId, $cost = 0) {
		$this->locations[$locationId] = time();
		
		$locationsString = implode(',', array_map(
			function($location, $purchaseDate) {
				return $location . '|' . $purchaseDate;
			}, array_keys($this->locations), $this->locations));
		
		$this->database->updateColumnById($this->id, "Locations", $locationsString);
		
		if($cost !== 0) {
			$this->setCoins($this->coins - $cost);
		}
		
		$this->send("%xt%aloc%{$this->room->internalId}%$locationId%{$this->coins}%");
	}
	
	public function updateColor($itemId) {
		$this->color = $itemId;
		$this->database->updateColumnById($this->id, "Color", $itemId);
		$this->room->send("%xt%upc%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updateHead($itemId) {
		$this->head = $itemId;
		$this->database->updateColumnById($this->id, "Head", $itemId);
		$this->room->send("%xt%uph%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updateFace($itemId) {
		$this->face = $itemId;
		$this->database->updateColumnById($this->id, "Face", $itemId);
		$this->room->send("%xt%upf%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updateNeck($itemId) {
		$this->neck = $itemId;
		$this->database->updateColumnById($this->id, "Neck", $itemId);
		$this->room->send("%xt%upn%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updateBody($itemId) {
		$this->body = $itemId;
		$this->database->updateColumnById($this->id, "Body", $itemId);
		$this->room->send("%xt%upb%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updateHand($itemId) {
		$this->hand = $itemId;
		$this->database->updateColumnById($this->id, "Hand", $itemId);
		$this->room->send("%xt%upa%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updateFeet($itemId) {
		$this->feet = $itemId;
		$this->database->updateColumnById($this->id, "Feet", $itemId);
		$this->room->send("%xt%upe%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updatePhoto($itemId) {
		$this->photo = $itemId;
		$this->database->updateColumnById($this->id, "Photo", $itemId);
		$this->room->send("%xt%upp%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function updateFlag($itemId) {
		$this->flag = $itemId;
		$this->database->updateColumnById($this->id, "Flag", $itemId);
		$this->room->send("%xt%upl%{$this->room->internalId}%{$this->id}%$itemId%");
	}
	
	public function addItem($itemId, $cost) {
		array_push($this->inventory, $itemId);
		
		$this->database->updateColumnById($this->id, "Inventory", implode('%', $this->inventory));
		
		if($cost !== 0) {
			$this->setCoins($this->coins - $cost);
		}
		
		$this->send("%xt%ai%{$this->room->internalId}%$itemId%{$this->coins}%");
	}
	
	public function loadPlayer() {
		$this->randomKey = null;
		
		$clothing = array("Color", "Head", "Face", "Neck", "Body", "Hand", "Feet", "Photo", "Flag", "Walking");
		$player = array("Avatar", "AvatarAttributes", "RegistrationDate", "Moderator", "Inventory", "CareInventory", "Coins");
		$igloo = array("Furniture", "Floors", "Igloos", "Locations");
		
		$columns = array_merge($clothing, $player, $igloo);
		$playerArray = $this->database->getColumnsById($this->id, $columns);
			
		$furnitureArray = explode(',', $playerArray["Furniture"]);
		
		if(!empty($furnitureArray)) {
			list($firstFurniture) = $furnitureArray;
			list($furnitureId) = explode("|", $firstFurniture);

			if($furnitureId == "") {
				array_shift($furnitureArray);
				
				$furniture = implode(",", $furnitureArray);
				
				$this->database->updateColumnById($this->id, "Furniture", $furniture);
			}
			
			foreach($furnitureArray as $furniture) {
				$furnitureDetails = explode('|', $furniture);
				list($furnitureId, $purchaseDate, $quantity) = $furnitureDetails;
				
				$this->furniture[$furnitureId] = array($purchaseDate, $quantity);
			}
		}
		
		$flooringArray = explode(',', $playerArray["Floors"]);
		foreach($flooringArray as $flooring) {
			$flooringDetails = explode('|', $flooring);
			list($flooringId, $purchaseDate) = $flooringDetails;
			
			$this->floors[$flooringId] = $purchaseDate;
		}
		
		$igloosArray = explode(',', $playerArray["Igloos"]);
		foreach($igloosArray as $igloo) {
			$iglooDetails = explode('|', $igloo);
			list($iglooType, $purchaseDate) = $iglooDetails;
			
			$this->igloos[$iglooType] = $purchaseDate;
		}
		
		$locationArray = explode(',', $playerArray["Locations"]);
		foreach($locationArray as $location) {
			$locationDetails = explode('|', $location);
			list($locationId, $purchaseDate) = $locationDetails;
			
			$this->locations[$locationId] = $purchaseDate;
		}
				
		list($this->color, $this->head, $this->face, $this->neck, $this->body, $this->hand, $this->feet, $this->photo, $this->flag) = array_values($playerArray);
		
		$this->age = floor((strtotime("NOW") - $playerArray["RegistrationDate"]) / 86400); 
		$this->membershipDays = $this->age;
		
		$this->avatar = $playerArray["Avatar"];
		$this->avatarAttributes = $playerArray["AvatarAttributes"];
		
		$this->coins = $playerArray["Coins"];
		$this->moderator = (boolean)$playerArray["Moderator"];
		$this->inventory = explode('%', $playerArray["Inventory"]);
		
		$careInventory = explode('%', $playerArray["CareInventory"]);
		if(!empty($careInventory)) {
			foreach($careInventory as $puffleItem) {
				list($itemId, $quantity) = explode('|', $puffleItem);
				
				$this->careInventory[$itemId] = $quantity;
			}
		}
		
		if($playerArray["Walking"] != 0) {
			$puffle = $this->database->getPuffleColumns($playerArray["Walking"], array("Type", "Subtype", "Hat"));
			$this->walkingPuffle = array_values($puffle);
			array_unshift($this->walkingPuffle, $playerArray["Walking"]);
		}	
	}
	
	public function getPlayerString() {
		$player = array(
			$this->id,
			$this->username,
			45,
			$this->color,
			$this->head,
			$this->face,
			$this->neck,
			$this->body,
			$this->hand,
			$this->feet,
			$this->flag,
			$this->photo,
			$this->x,
			$this->y,
			$this->frame,
			1,
			$this->membershipDays,
			$this->avatar,
			0,
			$this->avatarAttributes
		);
		
		if(!empty($this->walkingPuffle)) {
			list($id, $type, $subtype, $hat) = $this->walkingPuffle;
			array_push($player, $id, $type, $subtype, $hat);
		}
		
		return implode('|', $player);
	}
	
	public function send($data) {
		Logger::Debug("Outgoing: $data");
		
		$data .= "\0";
		$bytesWritten = socket_send($this->socket, $data, strlen($data), 0);
		
		return $bytesWritten;
	}
	
}

?>
