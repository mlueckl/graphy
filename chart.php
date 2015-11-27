<?php
require_once("db/db.php");
require_once("class/data.php");
require_once("class/graph.php");
require_once("class/graphhub.php");

$data = new Data();
$db = new DB();
$graphHub = new GraphHub();
$html = "";

function GenerateGraphs(){
    global $db;
    global $graphHub;
    global $databases;
    global $html;
    global $data;

    foreach($data->partner() as $ws){
        if(!empty($ws)){
            $graph = new Graph(strtoupper($ws["country"]) . " - " . strtoupper($ws["partner_name"]) . " - " . strtoupper($ws["db_name"]));
            $values = $db->query("SELECT * FROM response WHERE id='" . $ws['id'] . "' AND timestamp > '2015-11-27' ORDER BY timestamp");

            foreach($values as $entry){
                $graph->addData($entry["timestamp"], $entry["response_time"]);
            }

            $graphHub->addGraph($graph);
        }else{
            echo "<h2>No Data available</h2>";
        }
    }

    foreach($graphHub->returnHub() as $graph){
        $html .= $graph->draw();
    }
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
                <div class="filter">
                    <select>
                        <option selected="true" disabled>Select Partner</option>
                        <?php
                            foreach($data->partnerName() as $p){
                                echo "<option>" . $p . "</option>";
                            }
                        ?>
                    </select>
                 </div>  

                <?php
                    GenerateGraphs();
                    $graphHub::globalAverageGraph();
                ?>
            </div>
        </div>
    </body>
</html>
