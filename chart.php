<?php
require_once("db/db.php");
require_once("class/graph.php");
require_once("class/graphhub.php");

$db = new DB();
$graphHub = new GraphHub();

$dbname = $db->query("SELECT DISTINCT * FROM dbs");

foreach($dbname as $ws){

    $graph = new Graph($ws["country"] . " - " . $ws["esp_name"] . " - " . $ws["db_name"]);
    //$values = $db->query("SELECT * FROM de_ws WHERE dbname like '".$ws["dbname"]."' LIMIT 50");
    $values = $db->query("SELECT * FROM response WHERE id='" . $ws['id'] . "' AND timestamp > '2015-11-17 00:00:00' ORDER BY timestamp");
 	
    foreach($values as $entry){
       $graph->addYAxisValue($entry["timestamp"]);
        $graph->addData($entry["response_time"]);
    }

    $graphHub->addGraph($graph);

}

?>

<!doctype html>
<html>
    <head>
        <title>Sheldon - Be noisy</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <script src="js/chart.min.js"></script>
    </head>
    <body>
        <div class="main">
			<div class="head">
				<header>
                    <img src="img/logo.png" alt="Logo">
					<h1>WS Monitoring</h1>
					<ul>
                        <li><a href="index.php">Check</a></li>
                        <li><a href="chart.html">Graph</a></li>
					</ul>
					<span><?php echo date("G:i:s m.d.y");?></span>
				</header>
			</div>
			<div class="content">
                <?php
                    foreach($graphHub->returnHub() as $graph){
                        $graph->draw();
                    }
                ?>
            </div>
        </div>
    </body>
</html>
