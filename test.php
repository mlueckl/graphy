<?php 
require_once("db/db.php");

$db = new DB();

$data = json_decode(file_get_contents("data.json"));

foreach($data as $ws){
	print_r($ws);
	echo "<br>";

	$db->query("INSERT INTO dbs (esp_name, db_name, country, url)VALUE('" . $ws->esp . "', '$ws->db', '" . $ws->country . "', '$ws->url')");
}


/*
foreach($data as $ws){
	$esp = $db->query("SELECT id, country FROM esp WHERE name LIKE '$ws->esp' AND country = '$ws->country'");
	$db->query("INSERT INTO dbs (espID, name, country, url)VALUE('" . $esp[0]["id"] . "', '$ws->db', '" . $ws->country . "', '$ws->url')");
}
*/
?>