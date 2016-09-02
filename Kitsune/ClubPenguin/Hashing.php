<?php

namespace Kitsune\ClubPenguin;

final class Hashing {

	private static $characterSet = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789`~@#$()_+-={}|[]:,.";
	
	public static function generateRandomInt($min, $max) {
		if(function_exists('random_int')) { //PHP7
			return random_int($min, $max);
		} else {
			return mt_rand($min, $max);
		}
	}
	
	public static function generateRandomKey() {
		$keyLength = self::generateRandomInt(7, 10);
		$randomKey = "";
		
		foreach(range(0, $keyLength) as $currentLength) {
			$randomKey .= substr(self::$characterSet, self::generateRandomInt(0, strlen(self::$characterSet)), 1);
		}
		
		return $randomKey;
	}
	
	public static function encryptPassword($password, $md5 = true) {
		if($md5 !== false) {
			$password = md5($password);
		}
		
		$hash = substr($password, 16, 16) . substr($password, 0, 16);
		return $hash;
	}

	public static function getLoginHash($password, $randomKey) {		
		$hash = self::encryptPassword($password, false);
		$hash .= $randomKey;
		$hash .= "a1ebe00441f5aecb185d0ec178ca2305Y(02.>'H}t\":E1_root";
		$hash = self::encryptPassword($hash);
		
		return $hash;
	}
	
}

?>
