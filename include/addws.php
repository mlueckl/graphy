<?php 
session_start();

if(!empty($_POST)){
	if(!empty($_POST["country"]) && !empty($_POST["partnername"]) && !empty($_POST["dbname"]) && !empty($_POST["wsurl"]) && !empty($_POST["wsversion"])){
		include_once("../db/db.php");
		$db = new DB();

		$country = $_POST["country"];
		$partnername = $_POST["partnername"];
		$dbname = $_POST["dbname"];
		$wsurl = $_POST["wsurl"];
		$wsversion = $_POST["wsversion"];

		$_SESSION["response"] = $db->query("INSERT INTO dbs (partner_name, db_name, country, url, ws_version)VALUE('$partnername', '$dbname', '$country', '$wsurl', '$wsversion')");
		
		unset($_POST);
	}else{
		$_SESSION["response"] = "missing";
		unset($_POST);
	}
}

$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
exit();
?>