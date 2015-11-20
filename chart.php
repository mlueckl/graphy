<?php
require_once("db/db.php");
require_once("class/graph.php");
require_once("class/graphhub.php");

$db = new DB();
$graphHub = new GraphHub();

$dbname = $db->query("SELECT DISTINCT * FROM dbs");

foreach($dbname as $ws){

    $graph = new Graph(strtoupper($ws["country"]) . " - " . strtoupper($ws["esp_name"]) . " - " . strtoupper($ws["db_name"]));
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
			<?php include_once("include/nav.html"); ?>

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
