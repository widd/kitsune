<?php

namespace Kitsune\ClubPenguin;
use Kitsune\BindException;

date_default_timezone_set("America/Los_Angeles");

error_reporting(E_ALL ^ E_STRICT);

spl_autoload_register(function ($path) {
	$realPath = str_replace("\\", "/", $path) . ".php";
	$includeSuccess = include_once $realPath;
	
	if(!$includeSuccess) {
		echo "Unable to load $realPath\n";
	}
});

$cp = new Login();

// A simple example of binding to multiple ports and/or addresses

/*
try {
	$cp->listen(["127.0.0.1", "192.168.1.159"], [6112, 7432]);
} catch(BindException $exception) {
	echo $exception->getMessage(), "\n";
}
*/

$cp->listen(0, 6112);

while(true) {
	$cp->acceptClients();
}

?>