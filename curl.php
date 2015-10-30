<?php 
header("Content-Type: application/json");

if(!empty($_POST["url"]) && !empty($_POST["param"]) && !empty($_POST["db"])){
	$url = $_POST["url"];
	$param = $_POST["param"];
	$db = $_POST["db"];

	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	if(!curl_errno($ch)){
		$response = [curl_exec($ch)];
		$info = curl_getinfo($ch);
		$time = [$info['total_time']];
		$data = array_merge($db, $response, $time);
		echo json_encode($data);
	}else{
		echo json_encode(["error"]);
	}


	curl_close($ch);
}	

?>