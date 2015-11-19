<?php 
session_start();

if(!empty($_POST)){
	if(!empty($_POST["country"]) && !empty($_POST["espname"]) && !empty($_POST["dbname"]) && !empty($_POST["wsurl"]) && !empty($_POST["wsversion"])){
		include_once("../db/db.php");
		$db = new DB();

		$country = $_POST["country"];
		$espname = $_POST["espname"];
		$dbname = $_POST["dbname"];
		$wsurl = $_POST["wsurl"];
		$wsversion = $_POST["wsversion"];

		$_SESSION["response"] = $db->query("INSERT INTO dbs (esp_name, db_name, country, url, ws_version)VALUE('$espname', '$dbname', '$country', '$wsurl', '$wsversion')");
		
		unset($_POST);
	}else{
		unset($_POST);
	}
}

$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
exit();
?>