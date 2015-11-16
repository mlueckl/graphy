<?php 
require_once("db/db.php");

$db = new DB();

$result = $db->query("SHOW TABLES LIKE 'esp'");
$exist = mysql_num_rows($result) > 0;

echo $exist;
?>