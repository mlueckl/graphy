<?php
require_once("db/db.php");
$db = new DB();

class Data{
	protected $partner;

	function __construct(){
		global $db;

		$this->partner = $db->query("SELECT DISTINCT * FROM dbs");
	}

	function partner(){
		return $this->partner;
	}

	function partnerName(){
		$a = array();

		foreach($this->partner as $p){
			$name = strtoupper($p["country"]) . " - " . $p["partner_name"];
			array_push($a, $name);
		}

		sort($a);

		return array_unique($a);
	}
}
?>