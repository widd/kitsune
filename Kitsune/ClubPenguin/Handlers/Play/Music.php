<?php

namespace Kitsune\ClubPenguin\Handlers\Play;

use Kitsune\Events;
use Kitsune\Logging\Logger;
use Kitsune\ClubPenguin\Packets\Packet;

// TODO: Use $penguin->room->send
trait Music {

	public $lastPlayed = null; // Track string
	public $broadcastingTracks = array();
	public $broadcastingEventIndex = null;

	public $cachedMusicTracks = array();
	public $cachedTrackPatterns = array();

	/* 
	TODO: Check whether the track exists and actually belongs to the player and
	TODO: Check whether the values are even right
	%xt%s%musictrack#sharemymusictrack%76%11596298%1%
	%xt%sharemymusictrack%-1%1%
	*/
	protected function handleShareMyMusicTrack($socket) {
		$penguin = $this->penguins[$socket];

		$trackId = Packet::$Data[2];
		$doShare = Packet::$Data[3];

		if($penguin->database->trackExists($trackId) && in_array($doShare, range(0, 1))) {
			$penguin->database->updateTrackSharing($trackId, $doShare);
			$penguin->send("%xt%sharemymusictrack%-1%1%");

			$this->broadcastNextTrack();
		} else {
			Logger::Warn("Player sent invalid track id and/or sharing value. Track id $trackId, Sharing $doShare");
		}
	}

	/* TODO: Check if player id and track even exist
	%xt%s%musictrack#loadmusictrack%6%313662467%11596298%
	%xt%loadmusictrack%-1%11596298%Hello world%1%pattern%51b4b593efdbce53ed3feeff74e12f9a%0%
	*/
	protected function handleLoadMusicTrack($socket) {
		$penguin = $this->penguins[$socket];

		$playerId = Packet::$Data[2];
		$trackId = Packet::$Data[3];

		if($penguin->database->playerIdExists($playerId) && $penguin->database->trackExists($trackId)) {
			if(array_key_exists($trackId, $this->cachedMusicTracks)) {
				$musicTrack = $this->cachedMusicTracks[$trackId];
			} else {
				// ID, Name, Sharing, Pattern, Hash, Likes
				$musicTrack = $penguin->database->getMusicTrack($trackId);
				$this->cachedMusicTracks[$trackId] = $musicTrack;
			}
			
			$trackData = implode("%", $musicTrack);
			
			$penguin->send("%xt%loadmusictrack%-1%$trackData%");
		}		
	}

	/* Sends each of the player's tracks (include their player id and track id)
	%xt%s%musictrack#refreshmytracklikes%76%
	%xt%getlikecountfortrack%-1%313662467%11596298%0%
	1/0 = on/off ?
	%xt%s%musictrack#sharemymusictrack%76%11596298%1%
	%xt%sharemymusictrack%-1%1%
	*/
	protected function handleRefreshMyTrackLikes($socket) {
		$penguin = $this->penguins[$socket];

		$myMusicTracks = $penguin->database->getMyMusicTracks($penguin->id);

		if(!empty($myMusicTracks)) { // ID, Name, Sharing, Likes
			foreach($myMusicTracks as $myMusicTrack) {
				$trackId = $myMusicTrack[0];
				$trackLikes = $myMusicTrack[3];

				$penguin->send("%xt%getlikecountfortrack%-1%{$penguin->id}%$trackId%$trackLikes%");
			}
		}
	}

	// savePlayerTrack
	// %xt%s%musictrack#savemymusictrack%76%Hello world%Pattern%51b4b593efdbce53ed3feeff74e12f9a%
	// %xt%savemymusictrack%-1%11596298%
	protected function handleSaveMyMusicTrack($socket) {
		$penguin = $this->penguins[$socket];

		list($trackName, $trackPattern, $trackHash) = array_slice(Packet::$Data, 2);

		Logger::Info("Attempting to insert $trackName..");

		$encodedPattern = $this->encodeMusicTrack($trackPattern);

		if($encodedPattern == $trackHash) {
			$trackId = $penguin->database->savePlayerTrack($penguin->id, $trackName, $trackPattern, $trackHash);

			$penguin->send("%xt%savemymusictrack%-1%$trackId%");
		} else {
			Logger::Warn("Track hashes don't match! $trackHash and $encodedPattern");

			$this->removePenguin($penguin);
		}
	}

	/*
	%xt%s%musictrack#getmymusictracks%76%
	1 = number of tracks
	0 = sharing
	-1 = likes
	%xt%getmymusictracks%-1%1%11596298|Hello world|0|-1%
	%xt%getmymusictracks%-1%0%% = None
	*/
	protected function handleGetMyMusicTracks($socket) {
		$penguin = $this->penguins[$socket];

		$myMusicTracks = $penguin->database->getMyMusicTracks($penguin->id);
		$trackCount = count($myMusicTracks);

		if($trackCount > 0) {
			$myTracks = array();

			foreach($myMusicTracks as $myMusicTrack) {
				list($trackId, $trackName, $isSharing, $trackLikes) = $myMusicTrack;
				$trackLikes = $trackLikes > 0 ? $trackLikes : -1;

				array_push($myTracks, sprintf("%d|%s|%d|%d", $trackId, $trackName, $isSharing, $trackLikes));
			}

			$musicTracks = implode(",", $myTracks);

			$penguin->send("%xt%getmymusictracks%-1%$trackCount%$musicTracks%");
		} else {
			$penguin->send("%xt%getmymusictracks%-1%0%%");
		}
	}

	/*
	Check if anyone in the room is currently sharing a track, then broadcast it
	Query this (owner = player id and sharing = 1)
	Returns a list of all the tracks that can be broadcasted in the room (array with string elements)
	Broadcasting string separated by commas

	Broadcasting packet contains number of shared tracks (array length), and the track to broadcast (according to its index in the array)
	*/
	// No one = %xt%broadcastingmusictracks%-1%0%-1%%
	// %xt%broadcastingmusictracks%-1%2%1%313662467|P313662467|{b0c2c7c5-2083-40cb-933b-914f79697507}|11596298|0,244799927|Heavy Sky|{bc4fbd24-cf68-46b6-aff5-6effdb2221ec}|11594120|2,%
	// 
	protected function handleBroadcastingTracks($socket) {
		$penguin = $this->penguins[$socket];

		$this->refreshTrackBroadcasting();

		$sharedTracksCount = count($this->broadcastingTracks);

		if($sharedTracksCount < 1) {
			$penguin->send("%xt%broadcastingmusictracks%-1%0%-1%%");
		} else {
			if($this->broadcastingEventIndex == null) {
				$this->broadcastNextTrack();
			} else {
				$sharedPlayerTracks = implode(",", $this->broadcastingTracks);
				$playlistPosition = $this->getPlaylistPosition($penguin);

				$penguin->send("%xt%broadcastingmusictracks%-1%$sharedTracksCount%$playlistPosition%$sharedPlayerTracks%");
			}
		}
	}

	/*
	Get the ids of everyone on the server, and retrieve all of the tracks
	that they're sharing. */

	// %xt%getsharedmusictracks%-1%numberOfSharedTracks%playerId|Username|trackId|trackLikes,etc%
	protected function handleGetSharedMusicTracks($socket) {
		$penguin = $this->penguins[$socket];

		$sharedTracks = array();
		$sharedTracksCount = 0;

		foreach($this->penguins as $onlinePenguin) {
			$sharedPlayerTracks = $penguin->database->getSharedTracks($onlinePenguin->id);

			if(!empty($sharedPlayerTracks)) {
				$sharedPlayerTracksCount = count($sharedPlayerTracks);
				$sharedTracksCount += $sharedPlayerTracksCount;

				foreach($sharedPlayerTracks as $sharedPlayerTrack) {
					array_push($sharedTracks, sprintf("%d|%s|%d|%d",
						$onlinePenguin->id, $onlinePenguin->username,
						$sharedPlayerTrack["ID"], $sharedPlayerTrack["Likes"]));
				}
			}
		}

		if($sharedTracksCount > 0) {
			$sharedTracksData = implode(",", $sharedTracks);
			$penguin->send("%xt%getsharedmusictracks%-1%$sharedTracksCount%$sharedTracksData%");
		} else {
			// None are currently being shared
			$penguin->send("%xt%getsharedmusictracks%-1%0%%");
		}
	}

	private function determineSongLength($songData) {
		$songDataSplit = explode(",", $songData);
		$endData = $songDataSplit[count($songDataSplit) - 1];

		if(explode("|", $endData)[0] == "FFFF") {
			return intval(explode("|", $endData)[1], 16);
		}

		return -1;
	}

	private function encodeMusicTrack($songData) {
		$songHash = strrev($songData);
		$songHash = md5($songHash);

		return substr($songHash, -16) . substr($songHash, 0, 16);
	}

	/* Solely for updating the arrays, destroying the event-loop, and updating the currently-playing property.
	Check whether anyone in the room is still sharing their music, if not, destroy the event.
	Check whether anyone in the room has stopped sharing their music, if so, stop broadcasting their music.
	Check whether anyone in the room has started sharing their music, if so, broadcast their music.
	*/
	private function refreshTrackBroadcasting() {
		$dancingPenguins = $this->rooms["120"]->penguins;
		$sharedTracks = array();

		foreach($dancingPenguins as $dancingPenguin) {
			$sharedPlayerTracks = $dancingPenguin->database->getSharedTracks($dancingPenguin->id);

			if(count($sharedPlayerTracks) > 0) {
				foreach($sharedPlayerTracks as $sharedPlayerTrack) {
					$trackData = sprintf("%d|%s|%s|%d|%d", $dancingPenguin->id, $dancingPenguin->username,
						$dancingPenguin->swid, $sharedPlayerTrack["ID"], $sharedPlayerTrack["Likes"]);

					array_push($sharedTracks, $trackData);
				}
			}
		}

		$this->broadcastingTracks = $sharedTracks;
	}

	private function getPlaylistPosition($penguin) {
		foreach($this->broadcastingTracks as $broadcastingIndex => $broadcastingTrack) {
			list($playerId) = explode("|", $broadcastingTrack);

			if($penguin->id == $playerId) {
				return $broadcastingIndex + 1;
			}
		}

		return -1;
	}

	// Also checks whether anyone is still in the room, if not, destroy the event.
	public function broadcastNextTrack() {
		// Check to see whether players are still in the room and broadcasting/sharing
		// Increment track and broadcast ifso, etc
		$dancingPenguins = $this->rooms["120"]->penguins;

		if(empty($dancingPenguins)) { // Everyone's gone~!
			Logger::Debug("Everyone's gone!");

			$this->stopBroadcasting();

			return false;
		}

		$this->refreshTrackBroadcasting();

		$sharedTracksCount = count($this->broadcastingTracks);

		if($sharedTracksCount > 0) {
			list($trackData) = $this->broadcastingTracks;

			if($trackData == $this->lastPlayed) {
				$lastPlayed = array_shift($this->broadcastingTracks);
				array_push($this->broadcastingTracks, $lastPlayed);
			}

			$sharedPlayerTracks = implode(",", $this->broadcastingTracks);

			Logger::Debug("There are $sharedTracksCount tracks being shared");

			$this->stopBroadcasting();

			foreach($dancingPenguins as $dancingPenguin) {
				$playlistPosition = $this->getPlaylistPosition($dancingPenguin);

				$dancingPenguin->send("%xt%broadcastingmusictracks%-1%$sharedTracksCount%$playlistPosition%$sharedPlayerTracks%");
			}

			list($trackData) = $this->broadcastingTracks;
			var_dump($trackData);
			var_dump($this->broadcastingTracks);

			$trackId = explode("|", $trackData)[3];

			echo "THE TRACK ID ", $trackId, "\n";

			if(array_key_exists($trackId, $this->cachedTrackPatterns)) {
				$trackPattern = $this->cachedTrackPatterns[$trackId];
			} else {
				list($trackPattern) = end($this->penguins)->database->getTrackPattern($trackId);
				echo "Oi, track pattern ", var_dump($trackPattern), "\n";

				$this->cachedTrackPatterns[$trackId] = $trackPattern;
			}
			
			$songLength = ceil($this->determineSongLength($trackPattern) / 1000);

			Logger::Debug("Song length: $songLength seconds");

			$eventIndex = Events::AppendInterval($songLength, array($this, "broadcastNextTrack"));
			$this->broadcastingEventIndex = $eventIndex;

			Logger::Info("Assigned new event index $eventIndex");
			$this->lastPlayed = $trackData;
		} else {
			Logger::Debug("No shared tracks!");
			$this->stopBroadcasting();

			return false;
		}	
	}

	public function stopBroadcasting() {
		Logger::Debug("Stopping the broadcast");
		
		if($this->broadcastingEventIndex !== null) {
			Events::RemoveInterval($this->broadcastingEventIndex);
			$this->broadcastingEventIndex = null;
		}
	}

}

?>