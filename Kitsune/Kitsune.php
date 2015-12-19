<?php

namespace Kitsune;

use Kitsune\Events;
use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Penguin;
use Kitsune\ClubPenguin\Packets\Packet;

abstract class Kitsune extends Spirit {

	public $penguins = array();
	
	protected function handleAccept($socket) {
		Events::Fire("accept", $socket);

		$newPenguin = new Penguin($socket);
		$this->penguins[$socket] = $newPenguin;

		Events::Fire("accepted", $newPenguin);
	}
	
	protected function handleDisconnect($socket) {
		unset($this->penguins[$socket]);
		Logger::Notice("Player disconnected");
	}
	
	protected function handleReceive($socket, $data) {
		Events::Fire("receive", [$socket, $data]);

		$chunkedArray = explode("\0", $data);
		array_pop($chunkedArray);
				
		foreach($chunkedArray as $rawData) {
			Logger::Debug("Received $rawData");

			$packet = Packet::Parse($rawData);
					
			if(Packet::$IsXML) {
				$this->handleXmlPacket($socket);
			} else {
				$this->handleWorldPacket($socket);
			}
		}

		Events::Fire("received", [$socket, $data]);
	}
	
	protected function removePenguin($penguin) {
		$this->removeClient($penguin->socket);
		unset($this->penguins[$penguin->socket]);
	}
	
	abstract protected function handleXmlPacket($socket);
	abstract protected function handleWorldPacket($socket);
	
}

?>

 _   ___ _                        
| | / (_) |                       
| |/ / _| |_ ___ _   _ _ __   ___ 
|    \| | __/ __| | | | '_ \ / _ \
| |\  \ | |_\__ \ |_| | | | |  __/
\_| \_/_|\__|___/\__,_|_| |_|\___|
