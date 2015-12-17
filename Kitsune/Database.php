<?php

namespace Kitsune;

use Kitsune\Logging\Logger;

class Database extends \PDO {

	private $configFile = "Database.xml";
	
	public function __construct() {
		$dbConfig = simplexml_load_file($this->configFile);
		
		$connectionString = sprintf("mysql:dbname=%s;host=%s", $dbConfig->name, $dbConfig->address);

		try {
			parent::__construct($connectionString, $dbConfig->username, $dbConfig->password);
			parent::setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch(\PDOException $pdoException) {
			Logger::Fatal($pdoException->getMessage());
		}
	}
	
	public function getNumberOfBans($penguinId) {
		try {
			$getNumberOfBans = $this->prepare("SELECT ID FROM `bans` WHERE Player = :Player");
			
			$getNumberOfBans->bindValue(":Player", $penguinId);
			$getNumberOfBans->execute();
			
			$numberOfBans = $getNumberOfBans->rowCount();
			
			$getNumberOfBans->closeCursor();
			
			return $numberOfBans;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function addBan($penguinId, $moderatorName, $comment, $expiration, $type) {
		try {
			$addBan = $this->prepare("INSERT INTO `bans` (`ID`, `Moderator`, `Player`, `Comment`, `Expiration`, `Time`, `Type`) VALUES (NULL,  :Moderator, :Player, :Comment, :Expiration, :Time, :Type)");
			
			$addBan->bindValue(":Moderator", $moderatorName);
			$addBan->bindValue(":Player", $penguinId);
			$addBan->bindValue(":Comment", $comment);
			$addBan->bindValue(":Expiration", $expiration);
			$addBan->bindValue(":Time", time());
			$addBan->bindValue(":Type", $type);
			
			$addBan->execute();
			
			$addBan->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getPuffleStats($penguinId) {
		try {
			$getPuffleStats = $this->prepare("SELECT ID, Food, Play, Rest, Clean FROM `puffles` WHERE Owner = :Penguin AND Backyard = '0'");
			$getPuffleStats->bindValue(":Penguin", $penguinId);
			$getPuffleStats->execute();
			
			$puffleStats = $getPuffleStats->fetchAll(\PDO::FETCH_NUM);
			
			$getPuffleStats->closeCursor();
			
			$puffleStats = implode(',', array_map(
				function($puffleStatistics) {					
					return implode('|', $puffleStatistics);
				}, $puffleStats
			));
						
			return $puffleStats;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function deleteMailFromUser($recipientId, $senderId) {
		try {	
			$deleteMail = $this->prepare("DELETE FROM `postcards` WHERE `Recipient` = :Recipient AND `SenderID` = :Sender");
			
			$deleteMail->bindValue(":Recipient", $recipientId);
			$deleteMail->bindValue(":Sender", $senderId);
			
			$deleteMail->execute();
			$deleteMail->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function ownsPostcard($postcardId, $penguinId) {
		try {
			$ownsPostcard = $this->prepare("SELECT Recipient FROM `postcards` WHERE ID = :Postcard");
			$ownsPostcard->bindValue(":Postcard", $postcardId);
			$ownsPostcard->execute();
			
			list($recipientId) = $ownsPostcard->fetch(\PDO::FETCH_NUM);
			
			$ownsPostcard->closeCursor();
			
			return $penguinId == $recipientId;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
			
	
	public function deleteMail($postcardId) {
		try {
			$deleteMail = $this->prepare("DELETE FROM `postcards` WHERE `ID` = :Postcard");
			$deleteMail->bindValue(":Postcard", $postcardId);
			$deleteMail->execute();
			$deleteMail->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function mailChecked($penguinId) {
		try {
			$mailChecked = $this->prepare("UPDATE `postcards` SET HasRead = '1' WHERE Recipient = :Penguin");
			$mailChecked->bindValue(":Penguin", $penguinId);
			$mailChecked->execute();
			$mailChecked->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function sendMail($recipientId, $senderName, $senderId, $postcardDetails, $sentDate, $postcardType) {
		try {
			$sendMail = $this->prepare("INSERT INTO `postcards` (`ID`, `Recipient`, `SenderName`, `SenderID`, `Details`, `Date`, `Type`) VALUES (NULL, :Recipient, :SenderName, :SenderID, :Details, :Date, :Type)");
			$sendMail->bindValue(":Recipient", $recipientId);
			$sendMail->bindValue(":SenderName", $senderName);
			$sendMail->bindValue(":SenderID", $senderId);
			$sendMail->bindValue(":Details", $postcardDetails);
			$sendMail->bindValue(":Date", $sentDate);
			$sendMail->bindValue(":Type", $postcardType);
			$sendMail->execute();
			$sendMail->closeCursor();
			
			$postcardId = $this->lastInsertId();
			
			return $postcardId;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getUnreadPostcardCount($penguinId) {
		try {
			$getPostcards = $this->prepare("SELECT HasRead FROM `postcards` WHERE Recipient = :Penguin");
			$getPostcards->bindValue(":Penguin", $penguinId);
			$getPostcards->execute();
			
			$penguinPostcards = $getPostcards->fetchAll(\PDO::FETCH_NUM);
			$getPostcards->closeCursor();
			
			$unreadCount = 0;
			foreach($penguinPostcards as $hasRead) {
				list($hasRead) = $hasRead;
				
				$unreadCount = $hasRead == 0 ? ++$unreadCount : $unreadCount;
			}
			
			return $unreadCount;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getPostcardCount($penguinId) {
		try {
			$getPostcards = $this->prepare("SELECT Recipient FROM `postcards` WHERE Recipient = :Penguin");
			$getPostcards->bindValue(":Penguin", $penguinId);
			$getPostcards->execute();
			
			$postcardCount = $getPostcards->rowCount();
			$getPostcards->closeCursor();
			
			return $postcardCount;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getPostcardsById($penguinId) {
		try {
			$getPostcards = $this->prepare("SELECT SenderName, SenderID, Type, Details, Date, ID FROM `postcards` WHERE Recipient = :Penguin");
			$getPostcards->bindValue(":Penguin", $penguinId);
			$getPostcards->execute();
			
			$receivedPostcards = $getPostcards->fetchAll(\PDO::FETCH_NUM);
			$getPostcards->closeCursor();
			
			return $receivedPostcards;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function sendChangePuffleRoom($puffleId, $toBackground) {
		try {
			$changePuffleRoom = $this->prepare("UPDATE `puffles` SET `Backyard` = :Backyard WHERE `ID` = :Puffle");
			$changePuffleRoom->bindValue(":Backyard", $toBackground);
			$changePuffleRoom->bindValue(":Puffle", $puffleId);
			$changePuffleRoom->execute();
			$changePuffleRoom->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function ownsIgloo($iglooId, $ownerId) {
		try {
			$ownsIgloo = $this->prepare("SELECT Owner FROM `igloos` WHERE ID = :Igloo");
			$ownsIgloo->bindValue(":Igloo", $iglooId);
			$ownsIgloo->execute();
			
			$rowCount = $ownsIgloo->rowCount();
			if($rowCount == 0) {
				$ownsIgloo->closeCursor();
				
				return false;
			}
			
			list($iglooOwner) = $ownsIgloo->fetch(\PDO::FETCH_NUM);
			$ownsIgloo->closeCursor();
			
			return $iglooOwner == $ownerId;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function ownsPuffle($puffleId, $ownerId) {
		try {
			$ownsPuffle = $this->prepare("SELECT Owner FROM `puffles` WHERE ID = :Puffle");
			$ownsPuffle->bindValue(":Puffle", $puffleId);
			$ownsPuffle->execute();
			
			$rowCount = $ownsPuffle->rowCount();
			if($rowCount == 0) {
				$ownsPuffle->closeCursor();
				
				return false;
			}
			
			list($puffleOwner) = $ownsPuffle->fetch(\PDO::FETCH_NUM);
			$ownsPuffle->closeCursor();
			
			return $puffleOwner == $ownerId;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function updatePuffleColumn($puffleId, $column, $value) {
		try {
			$updatePuffleColumn = $this->prepare("UPDATE `puffles` SET $column = :Value WHERE ID = :ID");
			$updatePuffleColumn->bindValue(":Value", $value);
			$updatePuffleColumn->bindValue(":ID", $puffleId);
			$updatePuffleColumn->execute();
			$updatePuffleColumn->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function puffleExists($puffleId) {
		try {
			$puffleExistsStatement = $this->prepare("SELECT ID FROM `puffles` WHERE ID = :ID");
			$puffleExistsStatement->bindValue(":ID", $puffleId);
			$puffleExistsStatement->execute();
			
			$rowCount = $puffleExistsStatement->rowCount();
			$puffleExistsStatement->closeCursor();
			
			return $rowCount > 0;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getPuffles($playerId, $roomType) {
		try {
			$isBackyard = intval($roomType == "backyard");
			
			$getPuffles = $this->prepare("SELECT ID, Type, Subtype, Name, AdoptionDate, Food, Play, Rest, Clean, Hat FROM `puffles` WHERE Owner = :Owner AND Backyard = :Backyard");
			$getPuffles->bindValue(":Owner", $playerId);
			$getPuffles->bindValue(":Backyard", $isBackyard);
			$getPuffles->execute();
			
			$playerPuffles = $getPuffles->fetchAll(\PDO::FETCH_ASSOC);
			$getPuffles->closeCursor();
			
			return $playerPuffles;			
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}

	public function getPlayerPuffles($playerId) {
		try {
			$getPlayerPuffles = $this->prepare("SELECT ID, Type, Subtype, Name, AdoptionDate, Food, Play, Rest, Clean, Hat FROM `puffles` WHERE Owner = :Player");
			$getPlayerPuffles->bindValue(":Player", $playerId);
			$getPlayerPuffles->execute();
			
			$playerPuffles = $getPlayerPuffles->fetchAll(\PDO::FETCH_ASSOC);
			$getPlayerPuffles->closeCursor();
			
			return $playerPuffles;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getPuffleColumns($puffleId, array $columns) {
		try {
			$columns = implode(', ', $columns);
			$getPuffleStatement = $this->prepare("SELECT $columns FROM `puffles` WHERE ID = :Puffle");
			$getPuffleStatement->bindValue(":Puffle", $puffleId);
			$getPuffleStatement->execute();
			$columns = $getPuffleStatement->fetch(\PDO::FETCH_ASSOC);
			$getPuffleStatement->closeCursor();
			
			return $columns;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
		
	public function getPuffleColumn($puffleId, $column) {
		try {
			$getPuffleStatement = $this->prepare("SELECT $column FROM `puffles` WHERE ID = :Puffle");
			$getPuffleStatement->bindValue(":Puffle", $puffleId);
			$getPuffleStatement->execute();
			$getPuffleStatement->bindColumn($column, $value);
			$getPuffleStatement->fetch(\PDO::FETCH_BOUND);
			$getPuffleStatement->closeCursor();
			
			return $value;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function adoptPuffle($ownerId, $puffleName, $puffleType, $puffleSubtype) {
		try {
			$adoptPuffleStatement = $this->prepare("INSERT INTO `puffles` (`ID`, `Owner`, `Name`, `AdoptionDate`, `Type`, `Subtype`, `Hat`, `Food`, `Play`, `Rest`, `Clean`) VALUES (NULL, :Owner, :Name, UNIX_TIMESTAMP(), :Type, :Subtype, '0', '100', '100', '100', '100');");
			$adoptPuffleStatement->bindValue(":Owner", $ownerId);
			$adoptPuffleStatement->bindValue(":Name", $puffleName);
			$adoptPuffleStatement->bindValue(":Type", $puffleType);
			$adoptPuffleStatement->bindValue(":Subtype", $puffleSubtype);
			$adoptPuffleStatement->execute();
			$adoptPuffleStatement->closeCursor();
			
			$puffleId = $this->lastInsertId();
			return $puffleId;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getTotalIglooLikes($ownerId) {
		try {			
			$totalLikesStatement = $this->prepare("SELECT Likes FROM `igloos` WHERE Owner = :Owner");
			$totalLikesStatement->bindValue(":Owner", $ownerId);
			$totalLikesStatement->execute();
			
			$likes = $totalLikesStatement->fetchAll(\PDO::FETCH_ASSOC);
			$totalLikesStatement->closeCursor();
			
			$likes = array_column($likes, "Likes");
			
			$totalLikes = 0;
			
			foreach($likes as $likesJson) {
				$iglooLikes = json_decode($likesJson, true);
				
				if(!empty($iglooLikes)) {
					foreach($iglooLikes as $like) {
						$totalLikes += $like["count"];
					}
				}
			}
			
			return $totalLikes;
			
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
			
	
	public function getUsernamesBySwid($swidList) {
		try {
			$swids = explode(',', $swidList);
			$usernames = array();
			
			foreach($swids as $swid) {
				$swidUsernameStatement = $this->prepare("SELECT Username FROM `penguins` WHERE SWID = :Swid");
				$swidUsernameStatement->bindValue(":Swid", $swid);
				$swidUsernameStatement->execute();
				
				$rowCount = $swidUsernameStatement->rowCount();
				if($rowCount !== 0) {
					$swidUsernameStatement->bindColumn("Username", $username);
					$swidUsernameStatement->fetch(\PDO::FETCH_BOUND);
				
					array_push($usernames, $username);
				}
				
				$swidUsernameStatement->closeCursor();
			}
			
			return implode(',', $usernames);
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}				
	
	public function getIglooLikes($iglooId) {
		try {
			$iglooLikesStatement = $this->prepare("SELECT Likes FROM `igloos` WHERE ID = :Igloo");
			$iglooLikesStatement->bindValue(":Igloo", $iglooId);
			$iglooLikesStatement->execute();
			$iglooLikesStatement->bindColumn("Likes", $likesJson);
			$iglooLikesStatement->fetch(\PDO::FETCH_BOUND);
			$iglooLikesStatement->closeCursor();
			
			$likes = json_decode($likesJson, true);
			
			return $likes;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function iglooExists($iglooId) {
		try {
			$iglooExistsStatement = $this->prepare("SELECT ID FROM `igloos` WHERE ID = :Igloo");
			$iglooExistsStatement->bindValue(":Igloo", $iglooId);
			$iglooExistsStatement->execute();
			$rowCount = $iglooExistsStatement->rowCount();
			$iglooExistsStatement->closeCursor();
			
			return $rowCount > 0;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function addIglooLayout($playerId) {
		try {
			$addIglooStatement = $this->prepare("INSERT INTO `igloos` (`ID`, `Owner`, `Type`, `Floor`, `Music`, `Furniture`, `Location`, `Likes`, `Locked`) VALUES (NULL, :Owner, '1', '0', '0', '', '1', '[]', '1');");
			$addIglooStatement->bindValue(":Owner", $playerId);
			$addIglooStatement->execute();
			$addIglooStatement->closeCursor();
			
			$iglooId = $this->lastInsertId();
			
			$this->updateColumnById($playerId, "Igloo", $iglooId);
			
			return $iglooId;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getLayoutCount($playerId) {
		try {
			$layoutCountStatement = $this->prepare("SELECT ID FROM `igloos` WHERE Owner = :Owner");
			$layoutCountStatement->bindValue(":Owner", $playerId);
			$layoutCountStatement->execute();
			
			$layoutCount = $layoutCountStatement->rowCount();
			$layoutCountStatement->closeCursor();
			
			return $layoutCount;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function updateIglooColumn($iglooId, $column, $value) {
		try {
			$updateIglooStatement = $this->prepare("UPDATE `igloos` SET $column = :Value WHERE ID = :Igloo");
			$updateIglooStatement->bindValue(":Value", $value);
			$updateIglooStatement->bindValue(":Igloo", $iglooId);
			$updateIglooStatement->execute();
			$updateIglooStatement->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getIglooColumn($iglooId, $column) {
		try {
			$getIglooStatement = $this->prepare("SELECT $column FROM `igloos` WHERE ID = :Igloo");
			$getIglooStatement->bindValue(":Igloo", $iglooId);
			$getIglooStatement->execute();
			$getIglooStatement->bindColumn($column, $value);
			$getIglooStatement->fetch(\PDO::FETCH_BOUND);
			$getIglooStatement->closeCursor();
			
			return $value;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
			
	
	public function getAllIglooLayouts($playerId) {
		try {			
			$igloosStatement = $this->prepare("SELECT ID FROM `igloos` WHERE Owner = :Owner");
			$igloosStatement->bindValue(":Owner", $playerId);
			$igloosStatement->execute();
			
			$ownedIgloos = $igloosStatement->fetchAll(\PDO::FETCH_ASSOC);
			$igloosStatement->closeCursor();
			
			$ownedIgloos = array_column($ownedIgloos, "ID");
			
			$slotNumber = 0;
			$iglooLayouts = array();
			
			foreach($ownedIgloos as $ownedIgloo) {
				array_push($iglooLayouts, $this->getIglooDetails($ownedIgloo, ++$slotNumber));
			}
			
			$iglooLayouts = implode('%', $iglooLayouts);
			
			return $iglooLayouts;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getIglooDetails($iglooId, $slotNumber = 1) {
		try {
			$iglooStatement = $this->prepare("SELECT Type, Floor, Music, Location, Likes, Locked, Furniture FROM `igloos` WHERE ID = :Igloo");
			$iglooStatement->bindValue(":Igloo", $iglooId);
			$iglooStatement->execute();
			$iglooArray = $iglooStatement->fetch(\PDO::FETCH_ASSOC);
			$iglooStatement->closeCursor();
			
			$likeCount = 0;
			$likes = json_decode($iglooArray["Likes"], true);
			
			if(!empty($likes)) {
				foreach($likes as $like) {
					$likeCount += $like["count"];
				}
			}
			
			$iglooDetails = $iglooId;
			$iglooDetails .= ':' . $slotNumber;
			$iglooDetails .= ':0';
			$iglooDetails .= ':' . $iglooArray["Locked"];
			$iglooDetails .= ':' . $iglooArray["Music"];
			$iglooDetails .= ':' . $iglooArray["Floor"];
			$iglooDetails .= ':' . $iglooArray["Location"];
			$iglooDetails .= ':' . $iglooArray["Type"];
			$iglooDetails .= ':' . $likeCount;
			$iglooDetails .= ':' . $iglooArray["Furniture"];
			
			return $iglooDetails;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function playerIdExists($id) {
		try {
			$existsStatement = $this->prepare("SELECT ID FROM `penguins` WHERE ID = :ID");
			$existsStatement->bindValue(":ID", $id);
			$existsStatement->execute();
			$rowCount = $existsStatement->rowCount();
			$existsStatement->closeCursor();
			
			return $rowCount > 0;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function usernameExists($username) {
		try {
			$existsStatement = $this->prepare("SELECT ID FROM `penguins` WHERE Username = :Username");
			$existsStatement->bindValue(":Username", $username);
			$existsStatement->execute();
			$rowCount = $existsStatement->rowCount();
			$existsStatement->closeCursor();
			
			return $rowCount > 0;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getColumnsByName($username, array $columns) {
		try {
			$columnsString = implode(', ', $columns);
			$columnsStatement = $this->prepare("SELECT $columnsString FROM `penguins` WHERE Username = :Username");
			$columnsStatement->bindValue(":Username", $username);
			$columnsStatement->execute();
			$penguinColumns = $columnsStatement->fetch(\PDO::FETCH_ASSOC);
			$columnsStatement->closeCursor();
			
			return $penguinColumns;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getColumnsById($id, array $columns) {
		try {
			$columnsString = implode(', ', $columns);
			$columnsStatement = $this->prepare("SELECT $columnsString FROM `penguins` WHERE ID = :ID");
			$columnsStatement->bindValue(":ID", $id);
			$columnsStatement->execute();
			$penguinColumns = $columnsStatement->fetch(\PDO::FETCH_ASSOC);
			$columnsStatement->closeCursor();
			
			return $penguinColumns;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function updateColumnById($id, $column, $value) {
		try {
			$updateStatement = $this->prepare("UPDATE `penguins` SET $column = :Value WHERE ID = :ID");
			$updateStatement->bindValue(":Value", $value);
			$updateStatement->bindValue(":ID", $id);
			$updateStatement->execute();
			$updateStatement->closeCursor();
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
	public function getColumnById($id, $column) {
		try {
			$getStatement = $this->prepare("SELECT $column FROM `penguins` WHERE ID = :ID");
			$getStatement->bindValue(":ID", $id);
			$getStatement->execute();
			$getStatement->bindColumn($column, $value);
			$getStatement->fetch(\PDO::FETCH_BOUND);
			$getStatement->closeCursor();
			
			return $value;
		} catch(\PDOException $pdoException) {
			Logger::Warn($pdoException->getMessage());
		}
	}
	
}

?>