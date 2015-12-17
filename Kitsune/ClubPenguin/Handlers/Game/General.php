<?php

namespace Kitsune\ClubPenguin\Handlers\Game;

use Kitsune\ClubPenguin\Packets\Packet;

trait General {

	protected function handleGameOver($socket) {
		$penguin = $this->penguins[$socket];
		
		$score = Packet::$Data[2];
		
		if($penguin->room->externalId < 900) {
			$penguin->send("%xt%zo%{$penguin->room->internalId}%{$penguin->coins}%%0%0%0%");

			return;
		}

		if(is_numeric($score)) {
			$coins = (strlen($score) > 1 ? round($score / 10) : (($score * strlen("Kitsune") * 250) % 84) * rand(9, 12));

			if($score < 99999) {
				$penguin->setCoins($penguin->coins + $coins);
			}
		}

		if(isset($this->gameStamps[$penguin->room->externalId])) {
			$myStamps = explode(",", $penguin->database->getColumnById($penguin->id, "Stamps"));
			$collectedStamps = "";
			$totalGameStamps = 0;

			foreach($myStamps as $stamp) {
				if(in_array($stamp, $this->gameStamps[$penguin->room->externalId])) {
					$collectedStamps .= $stamp."|";
				}

				foreach($this->gameStamps as $gameArray) {
					if(in_array($stamp, $gameArray)){
						$totalGameStamps += 1;
					}
				}
			}

			$totalStamps = count(explode("|", $collectedStamps)) - 1;
			$totalStampsGame = count($this->gameStamps[$penguin->room->externalId]);
			$collectedStamps = rtrim($collectedStamps, "|");

			$penguin->send("%xt%zo%{$penguin->room->internalId}%{$penguin->coins}%$collectedStamps%$totalStamps%$totalStampsGame%$totalGameStamps%");
		} else {	
			$penguin->send("%xt%zo%{$penguin->room->internalId}%{$penguin->coins}%%0%0%0%");
		}
	}
	
}

?>