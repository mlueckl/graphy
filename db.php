<?php 
require_once("db_config.php");

class DB{
	function __construct(){
		$conn = new mysqli(URL, USER, PASSWORD, DB);

		if($conn->connect_error){
		    die("Connection failed: " . $conn->connect_error);
		}

		$this->conn = $conn;
	}

	function query(){
		$conn = $this->conn;
		$result = $conn->query("SELECT * FROM user");
		$data = array();
		
		print_r($result);

		/*
		while($row = $result->fetch_assoc()){
			array_push($data, $row);
		}
		*/

		//return $result;
	}
}
?>