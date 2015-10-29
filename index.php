<?php 
$data = json_decode(file_get_contents("data.json"), true);
$param = "q%5B0%5D=9bd597d291349d24cfaaa1372ce061c9&q%5B1%5D=a78d43db809c1b816b1ece087ef176cd&q%5B2%5D=72ade56f8df948a55dce90878d65ed68&q%5B3%5D=9bacef70ee59f7b6ec0fe8f379b3ecf3&q%5B4%5D=a4aad8bdbde7573305b26d0e048339af&q%5B5%5D=73f3349731c05ea293ea0827a7d5dc4b&q%5B6%5D=1bdd0aacde59bbb69da2bc7ac1b08ae3&q%5B7%5D=6fa120615afa4b0cbb8de1be8d20756b&q%5B8%5D=497972b55aa390b4f4fff937a2e6d412&q%5B9%5D=772e5ef21cd037e1b3b3e77bf5cfb3dc";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sheldon - Be noisy</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="content">
			<header>
				<div class="logo">
					<h1>Sheldon</h1>
					<p>Be annoying</p>
				</div>
				<span><?php echo date("G:i:s m.d.y");?></span>
			</header>
			<?php
				foreach($data as $ws){
					$db = $ws["db"];
					$url = $ws["url"];

					$ch = curl_init(); 
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

					$response = json_decode(curl_exec($ch), true);


					if(!curl_errno($ch)){
					    $info = curl_getinfo($ch);
					    echo "<div class='row'><p>";
					    
					    if(empty($response)){
					    	echo "<img src='img/red.png' alt='status_img' >";
					    }elseif($info['total_time'] < 1){
					    	echo "<img src='img/green.png' alt='status_img' >";
					    }elseif($info['total_time'] < 5){
					    	echo "<img src='img/orange.png' alt='status_img' >";
					    }else{
					    	echo "<img src='img/red.png' alt='status_img' >";
					    }

					    echo "<b>Database:</b> ".$db."</p><p><b>Time:</b> ".$info['total_time']."s";
					    echo "</p>";

					    if($response[0]["md5"]){
					    	echo "<p>Status: <b>OK</b>";

					    	echo "<div class='example'>";
					    	echo "<h4>Example</h4>";
					    	echo "<p><b>MD5:</b> ".$response[0]["md5"]."</p>";
					    	echo "<p><b>Status:</b> ".$response[0]["status"]."</p>";
					    	echo "<p><b>Status:</b> ".$response[0]["status"]."</p>";
					    	echo "</div>";
					    }else{
					    	echo "<p>Status: <b>NOT OK</b>";
					    }
					    echo "</div>";
					}
				}
			?>
		</div>
	</body>
</html>