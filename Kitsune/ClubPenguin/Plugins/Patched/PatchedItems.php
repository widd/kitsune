<?php

namespace Kitsune\ClubPenguin\Plugins\Patched;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Packets\Packet;
use Kitsune\ClubPenguin\Plugins\Base\Plugin;

final class PatchedItems extends Plugin {

	public $worldHandlers = array(
		"s" => array(
			"i#ai" => array("handleBuyInventory", self::Override)
		)
	);
	
	public $xmlHandlers = array(null);
	
	public $patchedItems = array(413); // List of patched items
	
	public function __construct($server) {
		$this->server = $server;
	}
	
	public function onReady() {
		parent::__construct(__CLASS__);
		
		Logger::Notice("The following items are unavailable: " . implode(", ", $this->patchedItems) . " (PatchedItems)");
	}
	
	public function handleBuyInventory($penguin, $itemId = null) {
		if($itemId === null) {
			$itemId = Packet::$Data[2];
		}
		
		if(!isset($this->server->items[$itemId])) {
			return $penguin->send("%xt%e%-1%402%"); // Item is unavailable
		} elseif(in_array($itemId, $penguin->inventory)) {
			return $penguin->send("%xt%e%-1%400%"); // Already owned item
		} elseif(in_array($itemId, $this->patchedItems)) {
			return $penguin->send("%xt%e%-1%402%"); // Item is unavailable
		}
		
		$cost = $this->server->items[$itemId];
		if($penguin->coins < $cost) {
			return $penguin->send("%xt%e%-1%401%"); // Not enough coins
		} else {
			$penguin->addItem($itemId, $cost);
		}
	}
	
}

?>
