<?php

namespace Kitsune;

class BindException extends \Exception {}

abstract class Spirit {

	protected $sockets = array();
	protected $port;
	protected $masterSocket;

	private function accept() {
		$clientSocket = socket_accept($this->masterSocket);
		socket_set_option($clientSocket, SOL_SOCKET, SO_REUSEADDR, 1);
		socket_set_nonblock($clientSocket);
		$this->sockets[] = $clientSocket;
		
		return $clientSocket;
	}

	protected function handleAccept($socket) {
		echo "Client accepted\n";
	}

	protected function handleDisconnect($socket) {
		echo "Client disconnected\n";
	}

	protected function handleReceive($socket, $data) {
		echo "Received data: $data\n";
	}

	protected function removeClient($socket) {
		$client = array_search($socket, $this->sockets);
		unset($this->sockets[$client]);

		if(is_resource($socket)) {
			socket_close($socket);
		}
	}

	public function listen($address, $port, $backlog = 5, $throwException = false) {
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

		socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
		socket_set_nonblock($socket);

		// Binding to a single port
		if(!is_array($address) && !is_array($port)) {
			$success = socket_bind($socket, $address, $port);
		} else {
			// Binding to multiple addresses/ports

			if(is_array($address)) {
				foreach($address as $_address) {
					if(is_array($port)) {
						/*
						We also need to bind to multiple ports so lets
						also get that out of the way.
						*/

						foreach($port as $_port) {
							$success = socket_bind($socket, $_address, $_port);

							/* 
							We failed to bind to a port, so we're exiting
							in order to throw an exception.
							*/
							if($success !== true) {
								break 2;
							}
						}

					} else {
						$success = socket_bind($socket, $_address, $port);

						if($success !== true) {
							break;
						}
					}
				}
			} else {
				/* 
				We're not binding to multiple addresses, but we are
				binding to multiple ports.
				*/

				foreach($port as $_port) {
					$success = socket_bind($socket, $address, $_port);

					if($success !== true) {
						break;
					}
				}
			}

		}

		if($success === false) {
			// I know this is ugly, but I didn't want to make the lines too long
			
			if($throwException !== false){
				throw new BindException(
					"Error binding to port $port: " .
					socket_strerror(socket_last_error($socket))
				);
			} else {
				return false;
			}
		}

		socket_listen($socket, $backlog);

		$this->masterSocket = $socket;
		$this->port = $port;
	}

	public function acceptClients() {
		$sockets = array_merge(array($this->masterSocket), $this->sockets);
		$changedSockets = socket_select($sockets, $write, $except, 5);
		
		if($changedSockets === 0) {
			return false;
		} else {
			if(in_array($this->masterSocket, $sockets)) {
				$clientSocket = $this->accept();
				$this->handleAccept($clientSocket);
				unset($sockets[0]);
			}
			
			foreach($sockets as $socket) {
				$mixedStatus = socket_recv($socket, $buffer, 8192, 0);
				if($mixedStatus == null) {
					$this->handleDisconnect($socket);
					$this->removeClient($socket);
					continue;
				} else {
					$this->handleReceive($socket, $buffer);
				}
			}
		}
	}

}

ob_implicit_flush();

?>	