<?php 
session_start();
?>

<!doctype html>
<html>
    <head>
        <title>Settings - WSMon</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <script src="js/chart.min.js"></script>
    </head>
    <body>
        <div class="main">
			<?php include_once("include/nav.html"); ?>
			<div class="content">
				<form method="POST" action="include/addws.php">
					<h2>Add WS</h2>
					<label for="country">Country</label>
					<select id="country" name="country">
						<option value="at">AT</option>
						<option value="de">DE</option>
					</select>
					<label for="espname">ESP name</label>
					<input type="text" id="espname" name="espname"/>

					<label for="dbname">Database name</label>
					<input type="text" id="dbname" name="dbname"/>

					<label for="wsurl">WS URL</label>
					<input type="text" id="wsurl" name="wsurl"/>

					<label for="wsversion">Connector Version</label>
					<select id="wsversion" name="wsversion">
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
					<input type="submit" value="Insert" />
				</form>

				<?php 
					if(isset($_SESSION["response"])){
						if($_SESSION["response"]){
							echo "<h4 style='color:#4CAF50'>Successful</h4>";
						}else{
							echo "<h4 style='color: #F44336'>Failed</h4>";
						}
					}		

					unset($_SESSION["response"]);
				?>
            </div>
        </div>
    </body>
</html>
