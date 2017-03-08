<?php

namespace Kitsune\ClubPenguin;

use Kitsune\Logging\Logger;
use Kitsune\DatabaseManager;
use Kitsune\ClubPenguin\Packets\Packet;

final class Login extends ClubPenguin {

	public function __construct() {	
		parent::__construct();
		
		Logger::Fine("Login server is online");
	}

	protected function handleLogin($socket) {
		$penguin = $this->penguins[$socket];

		if($penguin->handshakeStep !== "randomKey") {
			return $this->removePenguin($penguin);
		}

		$this->databaseManager->add($penguin);

		$username = Packet::$Data['body']['login']['nick'];
		$password = Packet::$Data['body']['login']['pword'];
		
		if($penguin->database->usernameExists($username) === false) {
			password_verify('KitsuneTimingAttack', '$2y$12$5hf7vOtBjsNJf6oZSsnyXOlcLTRblTwSg550SR0ohxVUkItmXhMM6'); //Mitigate timing attacks
			$penguin->send("%xt%e%-1%101%");
			return $this->removePenguin($penguin);
		}
		
		$penguinData = $penguin->database->getColumnsByName($username, array("ID", "Username", "Password", "SWID", "Email", "Banned"));
		$encryptedPassword = Hashing::getLoginHash($penguinData["Password"], $penguin->randomKey);
		
		if(password_verify($password, $penguinData["Password"]) !== true) {
			$penguin->send("%xt%e%-1%101%");
			return $this->removePenguin($penguin);
		} elseif($penguinData["Banned"] > strtotime("now") || $penguinData["Banned"] == "perm") {
			if(is_numeric($penguinData["Banned"])) {
				$hours = round(($penguinData["Banned"] - strtotime("now")) / ( 60 * 60 ));
				$penguin->send("%xt%e%-1%601%$hours%");
				$this->removePenguin($penguin);
			} else {
				$penguin->send("%xt%e%-1%603%");
				$this->removePenguin($penguin);
			}
		} else {			
			$confirmationHash = md5($penguin->randomKey);
			$friendsKey = md5($penguinData["ID"]); // May need to change this later!
			$loginTime = time();
			
			$penguin->database->updateColumnById($penguinData["ID"], "ConfirmationHash", $confirmationHash);
			$penguin->database->updateColumnById($penguinData["ID"], "LoginKey", $encryptedPassword);

			$penguin->handshakeStep = "login";
			
			$penguin->send("%xt%l%-1%{$penguinData["ID"]}|{$penguinData["SWID"]}|{$penguinData["Username"]}|$encryptedPassword|1|45|2|false|true|$loginTime%$confirmationHash%$friendsKey%101,1%{$penguinData["Email"]}%");
		}
	}

	protected function handleDisconnect($socket) {
		$penguin = $this->penguins[$socket];
		$this->removePenguin($penguin);
	}

	public function removePenguin($penguin) {
		$this->removeClient($penguin->socket);

		$this->databaseManager->remove($penguin);

		unset($this->penguins[$penguin->socket]);

		Logger::Notice("Player disconnected");
	}
	
}

?>