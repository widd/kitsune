<?php

namespace Kitsune\Logging;

class Logger implements ILogger {

	public static $logOnly = array();
	public static $noOutput = array();
	public static $logToFile = true;
	
	private static function LogToFile($writeData, $logLevel) {
		$logsDirectory = sprintf("%s/Logs/", __DIR__);
		
		if(!is_dir($logsDirectory)) mkdir($logsDirectory);
		
		$logFile = fopen(sprintf("%s%s.txt", $logsDirectory, $logLevel), "a");
		fwrite($logFile, sprintf("%s", $writeData));
		fclose($logFile);
	}
	
	private static function Log($message, $logLevel) {
		if(!empty(self::$logOnly) && !in_array($logLevel, self::$logOnly)) return;
		
		if(!in_array($logLevel, self::$noOutput)) {
			$writeData = sprintf("%s [%s] > %s%c", date(self::DateFormat), $logLevel, $message, 10);
			echo $writeData;
		}
		
		if(self::$logToFile) {
			self::LogToFile($writeData, $logLevel);
		}
	}
	
	public static function Info($message) {
		self::Log($message, self::Info);
	}
	
	public static function Fine($message) {
		self::Log($message, self::Fine);
	}
	
	public static function Notice($message) {
		self::Log($message, self::Notice);
	}
	
	public static function Debug($message) {
		self::Log($message, self::Debug);
	}
	
	public static function Warn($message) {
		self::Log($message, self::Warn);
	}
	
	public static function Error($message) {
		self::Log($message, self::Error);
	}
	
	public static function Fatal($message) {
		self::Log($message, self::Fatal);
		die();
	}

}

?>