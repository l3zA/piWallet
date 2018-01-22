<?php if (!defined("IN_WALLET")) { die("Auth Error!"); } ?>

<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');
class Coin {

	private $mysqli;
	function __construct($mysqli)
	{
		$this->mysqli = $mysqli;
	}

	function getCoins(){
		$result = $this->mysqli->query("SELECT * FROM coins");
		$coins = array();
		while ($obj = $result->fetch_object()) {
			$coin = (object)[];
			$coin->fullName = $obj->fullName;
			$coin->name = $obj->name;
			$coin->port = $obj->port;
			$user_session = $_SESSION['user_session'];
			$client = new Client('localhost', $coin->port, 'rpc', 'pass');
			$coin->balance = $client->getBalance($user_session);
			$coin->address = $client->getAddress($user_session);
			array_push($coins, $coin);
		}
		return $coins;
	}
}

?>