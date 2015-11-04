<?php
require_once("db/db.php");
$db = new DB();

$dbname = $db->query("SELECT DISTINCT dbname FROM de_ws");
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
                foreach($dbname as $ws){
                    $labels = $data = array();
                    $values = $db->query("SELECT * FROM de_ws WHERE dbname like '".$ws["dbname"]."'");
                  
                    foreach($values as $entry){
                        array_push($labels, $entry["tstamp"]);
                        array_push($data, $entry["time"]);
                    }

                    $canvasID = strtolower($ws["dbname"]);
                    $canvasID = str_replace(" ", "", $canvasID);
                    $canvasID = str_replace("-", "", $canvasID);
                    $canvasID = str_replace("_", "", $canvasID);

                    echo "<h3>".$ws["dbname"]."</h3>";
                    echo "<canvas id='".$canvasID."' height='300' width='1000'></canvas>";
                    echo "<script>";
                    echo "var lineChartData".$canvasID." = { labels: ".json_encode($labels).",datasets: [{label: 'DatabaseName',fillColor: 'rgba(156,39,176,0.2)',strokeColor: 'rgba(156,39,176,1)',pointColor: 'rgba(156,39,176,1)',pointStrokeColor: '#E0E0E0',pointHighlightFill: '#E0E0E0',pointHighlightStroke: 'rgba(156,39,176,1)',data: ".json_encode($data)."}]};";
                    echo "Chart.defaults.global.scaleLineColor = 'rgba(224,224,224,.4)';";
                    echo "Chart.defaults.global.scaleFontColor = '#E0E0E0';";
                    echo "(function() {";
                    echo "var ".$canvasID." = document.getElementById('".$canvasID."').getContext('2d');";
                    echo "window.myLine = new Chart(".$canvasID.").Line(lineChartData".$canvasID.", { responsive: true });";
                    echo "})()</script>";
                }
                ?>
            </div>
        </div>
    </body>
</html>
