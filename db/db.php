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

	function query($query){
		$conn = $this->conn;
		$result = $conn->query($query);
		$data = array();

		if(isset($result->num_rows)){
			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					array_push($data, $row);
				}
			}
		}else{
			return $result;
		}

		return $data;
	}
}
?>
