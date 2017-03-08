<?php

namespace Kitsune\ClubPenguin;

final class Hashing {
	
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
