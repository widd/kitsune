<?php

namespace Kitsune\ClubPenguin;

date_default_timezone_set("America/Los_Angeles");

error_reporting(E_ALL ^ E_STRICT);

spl_autoload_register(function ($path) {
	$realPath = str_replace("\\", "/", $path) . ".php";
	$includeSuccess = include_once $realPath;
	
	if(!$includeSuccess) {
		echo "Unable to load $realPath\n";
	}
});

$cp = new World();
$cp->listen(0, 9875);
while(true) {
	$cp->acceptClients();
}

?>