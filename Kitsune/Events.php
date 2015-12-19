<?php

namespace Kitsune;

final class Events {

	/* Values are callables
	Keys are event names
	*/
	private static $events = array();

	/* Values are arrays
	Arrays consist of three elements:
	Callback, interval, and the last time it was called
	*/
	private static $timedEvents = array();

	public static function GetTimedEvents() {
		return self::$timedEvents;
	}

	public static function GetEvents() {
		return self::$events;
	}

	public static function GetEvent($event) {
		if(array_key_exists($event, self::$events)) {
			return self::$events[$event];
		}
	}

	public static function RemoveInterval($callbackIndex) {
		if(array_key_exists(self::$timedEvents, $callbackIndex)) {
			unset(self::$timedEvents[$callbackIndex]);

			return true;
		} else {
			return false;
		}
	}

	// Interval in seconds
	public static function AppendInterval($callback, $interval) {
		array_push(self::$timedEvents, [$callback, $interval, null]);

		$callbackIndex = array_search($callback, self::$timedEvents);
		return $callbackIndex;
	}

	// Adds event and/or event callback
	public static function Append($event, $callback) {
		if(array_key_exists($event, self::$events)) {
			array_push(self::$events, $callback);
		} else {
			self::$events = array($callback);
		}

		$callbackIndex = array_search($callback, self::$events);

		return $callbackIndex;
	}

	// Removes event, or event callback (by index)
	public static function Remove($event, $callbackIndex = null) {
		if(array_key_exists($event, self::$events)) {
			if($callbackIndex === null) {
				unset(self::$events[$event]);
			} else {
				if(array_key_exists($callbackIndex, self::$events[$event])){
					unset(self::$events[$event][$callbackIndex]);
				} else {
					return false;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public static function Fire($event, $data = null) {
		foreach(self::$events as $eventCallback) {
			call_user_func($eventCallback, $data);
		}
	}

	// Clears the entire event array
	public static function Flush($event) {
		if(array_key_exists($event, self::$events)) {
			self::$events = array();
		}
	}

}

?>