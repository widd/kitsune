<?php

namespace Kitsune;
use Kitsune\Database;
use Kitsune\Logging\Logger;

class DatabaseManager {

	private $penguins = array();
	private $databaseConnection = null;

	public function __construct() {
		// Check connection - if it fails the server will automatically stop
		$tempDatabase = new Database();
		unset($tempDatabase);
	}

	public function add($penguin) {
		Logger::Debug('Attributing database to Penguin object');

		if($this->databaseConnection === null) {
			$this->databaseConnection = new Database();
			Logger::Debug('Database connection established');
		}

		$penguin->database = $this->databaseConnection;
		$this->penguins[] = $penguin;
	}

	public function remove($penguin) {
		Logger::Debug('Nullifying Penguin object\'s database property');

		$penguin->database = null;

		$penguinKey = array_search($penguin, $this->penguins);
		unset($this->penguins[$penguinKey]);

		if(count($this->penguins) === 0) {
			$this->databaseConnection = null;
		}
	}

}

?>