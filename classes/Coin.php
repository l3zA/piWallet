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
			$coin->id = $obj->id;
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
	
	function addCoin($coin){
		if($coin->id != null && $coin->id != ""){
			$sql = "UPDATE coins SET fullName='" . $coin->fullName . "', name='" . $coin->name . "', port=" . $coin->port . ", lastestBlockAPI='" . $coin->blockapiurl . "' WHERE id=" . $coin->id;
			$result = $this->mysqli->query($sql);
			if ($result > 0) {
				return "Update coin successfully";
			} else {
				return "Error: " . $sql . "<br>" . $this->mysqli->error;
			}
		}
		
		$check = $this->mysqli->query("SELECT * FROM coins where port = " . $coin->port);
		$row = mysqli_fetch_row($check);
		$num = $row[0];
		if($num > 0){
			return "Port Dupplicate!";
		}else{
			$sql = "INSERT INTO coins (fullName, name, port, lastestBlockAPI) VALUES ('" . $coin->fullName . "', '" . $coin->name . "', " . $coin->port . ",'" . $coin->blockapiurl . "')";
			$result = $this->mysqli->query($sql);
			if ($result > 0) {
				return "Add coin successfully";
			} else {
				return "Error: " . $sql . "<br>" . $this->mysqli->error;
			}
		}
		
	}
	
	function getAllBalance(){
		$result = $this->mysqli->query("SELECT * FROM coins");
		$coins = array();
		while ($obj = $result->fetch_object()) {
			$coin = (object)[];
			$coin->id = $obj->id;
			$coin->fullName = $obj->fullName;
			$coin->name = $obj->name;
			$coin->port = $obj->port;
			$client = new Client('localhost', $coin->port, 'rpc', 'pass');
			$coin->balance = $client->getBalance(null);
			$coin->lastestBlockAPI = $obj->lastestBlockAPI;
			$coin->syncedBlock = $client->getSyncedBlock();
			$coin->diff = $client->getDiff();
			array_push($coins, $coin);
		}
		return $coins;
	}
}

?>
