<?php

namespace Kitsune\ClubPenguin;

use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Handlers;
use Kitsune\ClubPenguin\Packets\Packet;

final class World extends ClubPenguin {

	protected $worldHandlers = array(
		"s" => array(
			"j#js" => "handleJoinWorld",
			"j#jr" => "handleJoinRoom",
			"j#jp" => "handleJoinPlayerRoom",
			"j#grs" => "handleRefreshRoom",
			
			"i#gi" => "handleGetInventoryList",
			"i#ai" => "handleBuyInventory",
			"i#qpp" => "handleGetPlayerPins",
			"i#qpa" => "handleGetPlayerAwards",
			
			"u#glr" => "handleGetLastRevision",
			"u#pbi" => "handleGetPlayerInfoById",
			"u#sp" => "handleSendPlayerMove",
			"u#sf" => "handleSendPlayerFrame",
			"u#h" => "handleSendHeartbeat",
			"u#sa" => "handleUpdatePlayerAction",
			"u#gabcms" => "handleGetABTestData", // Currently has no method
			"u#se" => "handleSendEmote",
			"u#sb" => "handlePlayerThrowBall",
			"u#gbffl" => "handleGetBestFriendsList",
			"u#pbsu" => "handlePlayerBySwidUsername",
			"u#ss" => "handleSafeMessage",
			"u#followpath" => "handlePenguinOnSlideOrZipline",
			"u#pbn" => "handleGetPlayerInfoByName",
			"u#gp" => "handleLoadPlayerObject",
			"u#bf" => "handleGetPlayerLocationById",
			
			"l#mg" => "handleGetMail",
			"l#mst" => "handleStartMailEngine",
			"l#ms" => "handleSendMailItem",
			"l#mc" => "handleMailChecked",
			"l#md" => "handleDeleteMailItem",
			"l#mdp" => "handleDeleteMailFromUser",
			
			"s#upc" => "handleSendUpdatePlayerClothing",
			"s#uph" => "handleSendUpdatePlayerClothing",
			"s#upf" => "handleSendUpdatePlayerClothing",
			"s#upn" => "handleSendUpdatePlayerClothing",
			"s#upb" => "handleSendUpdatePlayerClothing",
			"s#upa" => "handleSendUpdatePlayerClothing",
			"s#upe" => "handleSendUpdatePlayerClothing",
			"s#upp" => "handleSendUpdatePlayerClothing",
			"s#upl" => "handleSendUpdatePlayerClothing",
			
			"g#gii" => "handleGetFurnitureInventory",
			"g#gm" => "handleGetActiveIgloo",
			"g#ggd" => "handleGetGameData",			
			"g#aloc" => "handleBuyIglooLocation",
			"g#gail" => "handleGetAllIglooLayouts",
			"g#uic" => "handleUpdateIglooConfiguration",
			"g#af" => "handleBuyFurniture",
			"g#ag" => "handleSendBuyIglooFloor",
			"g#au" => "handleSendBuyIglooType",
			"g#al" => "handleAddIglooLayout",
			"g#pio" => "handleLoadIsPlayerIglooOpen",
			"g#cli" => "handleCanLikeIgloo",
			"g#uiss" => "handleUpdateIglooSlotSummary",
			"g#gr" => "handleGetOpenIglooList",
			"g#gili" => "handleGetIglooLikeBy",
			"g#li" => "handleLikeIgloo",
			
			"m#sm" => "handleSendMessage",
			
			"o#k" => "handleKickPlayerById",
			"o#m" => "handleMutePlayerById",
			"o#initban" => "handleInitBan",
			"o#ban" => "handleModeratorBan",
			"o#moderatormessage" => "handleModeratorMessage",
			
			"st#sse" => "handleStampAdd",
			"st#gps" => "handleGetStamps",
			"st#gmres" => "handleGetRecentStamps",
			"st#gsbcd" => "handleGetBookCover",
			"st#ssbcd" => "handleUpdateBookCover",
			
			"p#pg" => "handleGetPufflesByPlayerId",
			"p#checkpufflename" => "handleCheckPuffleNameWithResponse",
			"p#pn" => "handleAdoptPuffle",
			"p#pgmps" => "handleGetMyPuffleStats",
			"p#pw" => "handleSendPuffleWalk",
			"p#pufflewalkswap" => "handlePuffleSwap",
			"p#puffletrick" => "handlePuffleTrick",
			"p#puffleswap" => "handleSendChangePuffleRoom",
			"p#pgpi" => "handleGetPuffleCareInventory",
			"p#papi" => "handleSendBuyPuffleCareItem",
			"p#phg" => "handleGetPuffleHanderStatus",
			"p#puphi" => "handleVisitorHatUpdate",
			"p#pp" => "handleSendPufflePlay",
			"p#puffledig" => "handlePuffleDig",
			"p#puffledigoncommand" => "handlePuffleDigOnCommand",
			"p#getdigcooldown" => "handlePuffleDigCooldown",
			"p#pcid" => "handlePuffleCareItemDelivered",
			"p#revealgoldpuffle" => "handleRevealGoldPuffle",
			"p#pcn" => "handlePuffleCheckName",
			"rpq#rpqd" => "handleRainbowCookieData",
			"rpq#rpqtc" => "handleRainbowTaskComplete",
			"rpq#rpqcc" => "handleRainbowCoinCollect",
			"rpq#rpqic" => "handleRainbowItemCollect",
			"rpq#rpqbc" => "handleRainbowBonusCollect",
			
			"t#at" => "handleOpenPlayerBook",
			"t#rt" => "handleClosePlayerBook",
			
			"bh#lnbhg" => "handleLeaveGame",
			
			"f#epfga"	=>	"handleGetAgentStatus",
			"f#epfsa"	=>	"handleSetAgentStatus",
			"f#epfgr"	=>	"handleGetAgentPoints",
			"f#epfai"	=>	"handleAddAgentItem",
			"f#epfgm"	=>	"handleGetComMessages",
			
			"pt#spts" => "handleAvatarTransformation",
			
			"w#jx" => "AddPlayerToWaddle",
			
			"a#gt" => "handleGetTablePopulation",
			"a#jt" => "handleJoinTable",
			"a#lt" => "handleLeaveTable",

			"musictrack#broadcastingmusictracks" => "handleBroadcastingTracks",
			"musictrack#getsharedmusictracks" => "handleGetSharedMusicTracks",
			"musictrack#getmymusictracks" => "handleGetMyMusicTracks",
			"musictrack#savemymusictrack" => "handleSaveMyMusicTrack",
			"musictrack#refreshmytracklikes" => "handleRefreshMyTrackLikes",
			"musictrack#loadmusictrack" => "handleLoadMusicTrack",
			"musictrack#sharemymusictrack" => "handleShareMyMusicTrack",
			"musictrack#deletetrack" => "handleDeleteMusicTrack",
			"musictrack#canliketrack" => "handleCanLikeMusicTrack",
			"musictrack#liketrack" => "handleLikeMusicTrack"
		),
		
		"z" => array(
			"gz" => "GetGame",
			//"m" => "handleGameMove",  // Added in Games
			//"zo" => "GameOver", // Added in Games
			
			"gw" => "GetWaddles",
			"jw" => "JoinPlayerWaddle",
			"lw" => "ReleasePlayerWaddle",
			"jz" => "JoinGame",
			"lz" => "LeaveGame",

			"uz" => "UpdateGame",
			
			"zm" => "SendMove",
		)
	);
	
	use Handlers\Play\Navigation;
	use Handlers\Play\Item;
	use Handlers\Play\Player;
	use Handlers\Play\Mail;
	use Handlers\Play\Setting;
	use Handlers\Play\Igloo;
	use Handlers\Play\Message;
	use Handlers\Play\Moderation;
	use Handlers\Play\Pet;
	use Handlers\Play\Toy;
	use Handlers\Play\Stampbook;
	use Handlers\Play\Blackhole;
	use Handlers\Play\EPF;
	use Handlers\Play\PlayerTransformation;
	use Handlers\Play\Music;
	
	use Handlers\Game\Games;
	use Handlers\Game\Four;
	use Handlers\Game\Mancala;
	
	public $items = array();
	public $pins = array();
	
	public $rooms = array();
	
	public $locations = array();
	public $furniture = array();
	public $floors = array();
	public $igloos = array();
	
	public $gameStamps = array();
	public $epfItems = array();
	
	public $spawnRooms = array();

	public $penguinsById = array();
	public $penguinsByName = array();
	
	public function __construct() {
		parent::__construct();
		
		if(is_dir("crumbs") === false) {
			mkdir("crumbs", 0777);
		}
		
		$downloadAndDecode = function($url) {
			$filename = basename($url, ".json");
			
			if(file_exists("crumbs/$filename.json")) {
				$jsonData = file_get_contents("crumbs/$filename.json");
			} else {
				$jsonData = file_get_contents($url);
				file_put_contents("crumbs/$filename.json", $jsonData);
			}
			
			$dataArray = json_decode($jsonData, true);
			return $dataArray;
		};
		
		$rooms = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/rooms.json");
		foreach($rooms as $room => $details) {
			$this->rooms[$room] = new Room($room, sizeof($this->rooms) + 1, ($details['room_key'] == '' ? true : false));
		}
		
		$stamps = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/stamps.json");
		foreach($stamps as $stampCat) {
			if($stampCat['parent_group_id'] == 8) {
				foreach($stampCat['stamps'] as $stamp) {
					foreach($rooms as $room){
						if(str_replace("Games : ", "", $stampCat['display']) == $room['display_name']) {
							$roomId = $room['room_id'];
						}
					}
					
					$this->gameStamps[$roomId][] = $stamp['stamp_id'];
				}
			}
		}

		unset($rooms);
		unset($stamps);
		
		$agentRooms = array(210, 212, 323, 803);
		$rockhoppersShip = array(422, 423);
		$ninjaRooms = array(320, 321, 324, 326);
		$hotelRooms = range(430, 434);
		
		$noSpawn = array_merge($agentRooms, $rockhoppersShip, $ninjaRooms, $hotelRooms);
		$this->spawnRooms = array_keys(
			array_filter($this->rooms, function($room) use ($noSpawn) {
				if(!in_array($room->externalId, $noSpawn) && $room->externalId <= 810) {
					return true;
				}
			})
		);
		
		$items = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/paper_items.json");
		foreach($items as $itemIndex => $item) {
			$itemId = $item["paper_item_id"];
			
			$this->items[$itemId] = $item["cost"];
			
			if($item["type"] == 8) {
				array_push($this->pins, $itemId);
			}
			
			if(isset($item['is_epf'])) {
				$this->epfItems[$item["paper_item_id"]] = $item["cost"];
			}
			
			unset($items[$itemIndex]);
		}
		
		$locations = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/igloo_locations.json");
		foreach($locations as $locationIndex => $location) {
			$locationId = $location["igloo_location_id"];
			$this->locations[$locationId] = $location["cost"];
			
			unset($locations[$locationIndex]);
		}
		
		$furnitureList = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/furniture_items.json");
		foreach($furnitureList as $furnitureIndex => $furniture) {
			$furnitureId = $furniture["furniture_item_id"];
			$this->furniture[$furnitureId] = $furniture["cost"];
			
			unset($furnitureList[$furnitureIndex]);
		}
		
		$floors = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/igloo_floors.json");
		foreach($floors as $floorIndex => $floor) {
			$floorId = $floor["igloo_floor_id"];
			$this->floors[$floorId] = $floor["cost"];
			
			unset($floors[$floorIndex]);
		}
		
		$igloos = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/igloos.json");
		foreach($igloos as $iglooId => $igloo) {
			$this->igloos[$iglooId] = $igloo["cost"];
			
			unset($igloos[$iglooId]);
		}
		
		$careItems = $downloadAndDecode("http://media1.clubpenguin.com/play/en/web_service/game_configs/puffle_items.json");
		foreach($careItems as $careId => $careItem) {
			$itemId = $careItem["puffle_item_id"];
			
			$this->careItems[$itemId] = array($careItem["cost"], $careItem["quantity"]);
			
			unset($careItems[$careId]);
		}

		$tableIds = range(200, 207);
		$emptyTable = array();

		$this->tablePopulationById = array_fill_keys($tableIds, $emptyTable);
		$this->playersByTableId = array_fill_keys($tableIds, $emptyTable);
		$this->gamesByTableId = array_fill_keys($tableIds, null);

		Logger::Fine("World server is online");
	}
	
	public function getPlayerById($playerId) {
		if(isset($this->penguinsById[$playerId])) {
			return $this->penguinsById[$playerId];
		}
		
		return null;
	}

	public function getPlayerByName($playerName) {
		$lcPlayerName = strtolower($playerName);

		foreach($this->penguinsByName as $penguinName => $penguinObject) {
			if(strtolower($penguinName) == $lcPlayerName) {
				return $penguinObject;
			}
		}
	}

	protected function handleLogin($socket) {
		$penguin = $this->penguins[$socket];

		$this->databaseManager->add($penguin);

		$rawPlayerString = Packet::$Data['body']['login']['nick'];
		$playerHashes = Packet::$Data['body']['login']['pword'];
		
		$playerArray = explode('|', $rawPlayerString);
		list($id, $swid, $username) = $playerArray;
		
		if(!$penguin->database->playerIdExists($id)) {
			return $this->removePenguin($penguin);
		}
		
		if(!$penguin->database->usernameExists($username)) {
			$penguin->send("%xt%e%-1%101%");
			return $this->removePenguin($penguin);
		}

		// Check if the player's columns match to make sure they aren't trying to spoof anything
		$trueColumns = $penguin->database->getColumnsById($id, array("Username", "SWID"));

		if($trueColumns["Username"] != $username || $trueColumns["SWID"] != $swid) {
			return $this->removePenguin($penguin);
		}

		$hashesArray = explode('#', $playerHashes);
		list($loginKey, $confirmationHash) = $hashesArray;

		// User is attempting to perform exploit
		// See https://github.com/Kitsune-/Kitsune/issues/28
		if($confirmationHash == "") {
			return $this->removePenguin($penguin);
		}
		
		$dbConfirmationHash = $penguin->database->getColumnById($id, "ConfirmationHash");
		if($dbConfirmationHash != $confirmationHash) {
			$penguin->send("%xt%e%-1%101%");
			return $this->removePenguin($penguin);
		} else {
			$penguin->database->updateColumnByid($id, "ConfirmationHash", ""); // Maybe the column should be cleared even when the login is unsuccessful
			$penguin->id = $id;
			$penguin->swid = $swid;
			$penguin->username = $username;
			$penguin->identified = true;
			$penguin->send("%xt%l%-1%");
		}
		
	}
	
	protected function removePenguin($penguin) {
		// Remove the penguin from igloo maps if included.
		if(isset($this->openIgloos[$penguin->id])) {
			unset($this->openIgloos[$penguin->id]);
		}
		
		$this->removeClient($penguin->socket);

		if($penguin->room !== null) {
			$penguin->room->remove($penguin);
		}
		
		if(isset($this->penguinsById[$penguin->id])) {
			if($penguin->waddleRoom !== null) {
				$this->leaveWaddle($penguin);
			} elseif($penguin->tableId !== null) {
				$this->leaveTable($penguin);
			}

			unset($this->penguinsById[$penguin->id]);
			unset($this->penguinsByName[$penguin->username]);
		}

		$this->databaseManager->remove($penguin);

		unset($this->penguins[$penguin->socket]);
	}

	protected function handleDisconnect($socket) {
		$penguin = $this->penguins[$socket];

		$this->removePenguin($penguin);

		Logger::Info("Player disconnected");
	}
	
}

?>
