<?php

namespace Kitsune\ClubPenguin;
use Kitsune\BindException;

date_default_timezone_set("America/Los_Angeles");

error_reporting(E_ALL ^ E_STRICT);

require_once 'vendor/autoload.php';

spl_autoload_register(function ($path) {
	$realPath = str_replace("\\", "/", $path) . ".php";
	$includeSuccess = include_once $realPath;
	
	if(!$includeSuccess) {
		echo "Unable to load $realPath\n";
	}
});

$cp = new Login();

$cp->listen(0, 6112);

while(true) {
	$cp->acceptClients();
}

?>