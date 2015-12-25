<?php

namespace Kitsune\ClubPenguin\Plugins\Commands;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Packets\Packet;
use Kitsune\ClubPenguin\Plugins\Base\Plugin;

final class Commands extends Plugin {
	
	public $dependencies = array("PatchedItems" => "loadPatchedItems");
	
	public $worldHandlers = array(
		"s" => array(
			"m#sm" => array("handlePlayerMessage", self::Both)
		)
	);
	
	public $xmlHandlers = array(null);
	
	private $commandPrefixes = array("!", "/", "~");
	
	private $commands = array(
		"AI" => "buyItem",
		"JR" => "joinRoom",
		"AC" => "addCoins",
		"KICK" => "kickPlayer"
	);
	
	private $mutedPenguins = array();
	
	private $patchedItems;
	
	public function __construct($server) {
		$this->server = $server;
	}
	
	public function onReady() {
		parent::__construct(__CLASS__);
	}
	
	public function loadPatchedItems() {
		$this->patchedItems = $this->server->loadedPlugins["PatchedItems"];
	}
	
	public function buyItem($penguin, $arguments) {
		list($itemId) = $arguments;
		
		$this->patchedItems->handleBuyInventory($penguin, $itemId);
	}
	
	private function joinRoom($penguin, $arguments) {
		list($roomId) = $arguments;
		
		$this->server->joinRoom($penguin, $roomId);
	}
	
	private function addCoins($penguin, $arguments) {
		list($coinAmt) = $arguments;
		
		if(is_numeric($coinAmt)) {
			if($coinAmt >= 0 && $coinAmt <= 10000) {
				$penguin->addCoins($coinAmt);
			}
		}
	}
	
	private function kickPlayer($penguin, $arguments) {
		if($penguin->moderator) {
			$targetUsername = implode(" ", $arguments);
			$targetPlayer = $this->server->getPlayerByName($targetUsername);
			
			if($targetPlayer !== null) {
				if($targetPlayer->moderator) {
					return;
				}
				
				$targetPlayer->send("%xt%moderatormessage%-1%3%");
				$this->server->removePenguin($targetPlayer);
			}
		}
	}
	
	protected function handlePlayerMessage($penguin) {
		$message = Packet::$Data[3];
		
		$firstCharacter = substr($message, 0, 1);
		if(in_array($firstCharacter, $this->commandPrefixes)) {
			$messageParts = explode(" ", $message);
			
			$command = $messageParts[0];
			$command = substr($command, 1);
			$command = strtoupper($command);
			
			$arguments = array_splice($messageParts, 1);
			
			if(isset($this->commands[$command])) {
				if(in_array($penguin, $this->mutedPenguins)) {
					$penguin->muted = false;
					$penguinKey = array_search($penguin, $this->mutedPenguins);
					unset($this->mutedPenguins[$penguinKey]);
				} else {
					$penguin->muted = true;
					array_push($this->mutedPenguins, $penguin);
					call_user_func(array($this, $this->commands[$command]), $penguin, $arguments);
				}
			}
		}
	}
	
}

?>
