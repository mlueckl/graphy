<?php
require_once("db/db.php");
require_once("class/data.php");
require_once("class/graph.php");
require_once("class/graphhub.php");

if(!empty($_POST)){
    if (!empty($_POST["filter"])){
        $filter = $_POST["filter"];
    }

    if (!empty($_POST["date"])){
        $date = $_POST["date"];
    }

}else{
    $filter = null;
    $date = null;
}

$data = new Data();
$db = new DB();
$graphHub = new GraphHub();
$dateToday = date("Y-m-d");
$html = "";

function GenerateGraphs($filter){
    global $db;
    global $graphHub;
    global $databases;
    global $html;
    global $data;
    global $date;
    global $dateToday;

    if(!empty($filter)){
        $dbIds = $db->query("SELECT id FROM dbs WHERE partner_name='$filter'");

        if(count($dbIds) > 0){
            foreach($dbIds as $id){
                $partner = $db->query("SELECT * FROM dbs WHERE id='" . $id["id"] . "'");

                if(empty($date)){
                    $response = $db->query("SELECT * FROM response WHERE id='" . $id["id"] . "' AND timestamp > '$dateToday' ORDER BY timestamp");
                }else{
                    $response = $db->query("SELECT * FROM response WHERE id='" . $id["id"] . "' AND timestamp > '$date' ORDER BY timestamp");
                }

                $graph = new Graph(strtoupper($partner[0]["country"]) . " - " . strtoupper($partner[0]["partner_name"]) . " - " . strtoupper($partner[0]["db_name"]));

                foreach($response as $entry){
                    $graph->addData($entry["timestamp"], $entry["response_time"]);
                }

                $graphHub->addGraph($graph);
            }
        }

    }


    // foreach($data->partner() as $ws){
    //     if($ws["partner_name"] == $filter){
    //
    //         if(!empty($ws)){
    //             $graph = new Graph(strtoupper($ws["country"]) . " - " . strtoupper($ws["partner_name"]) . " - " . strtoupper($ws["db_name"]));
    //             $values = $db->query("SELECT * FROM response WHERE id='" . $ws['partner_name'] . "' AND timestamp > '2015-11-27' ORDER BY timestamp");
    //
    //             foreach($values as $entry){
    //                 $graph->addData($entry["timestamp"], $entry["response_time"]);
    //             }
    //
    //             $graphHub->addGraph($graph);
    //         }else{
    //             echo "<h2>No Data available</h2>";
    //         }
    //     }
    // }

    foreach($graphHub->returnHub() as $graph){
        $html .= $graph->draw();
    }
}

?>

<!doctype html>
<html>
    <head>
        <title>Sheldon - Be noisy</title>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" tpye="text/css" href="css/jquery-ui.min.css">
        <script src="js/chart.min.js"></script>
    </head>
    <body>
        <div class="main">
			<?php include_once("include/nav.html"); ?>

			<div class="content">
                <div class="filter">
                    <form method="post" >
                        <select onchange="this.form.submit()" name="filter">
                            <option selected="true" id="selectedpartner" disabled>Select Partner</option>
                            <?php
                                foreach($data->partnerName() as $p){

                                    if($filter == $p){
                                        echo "<option selected='true' value='$p'>" . $p . "</option>";
                                    }else{
                                        echo "<option value='$p'>" . $p . "</option>";
                                    }

                                }
                            ?>
                        </select>

                        <?php

                            if(!empty($date)){
                                echo "<input onchange='this.form.submit()' type='text' id='date' name='date' value='$date'>";
                            }else{
                                echo "<input onchange='this.form.submit()' type='text' id='date' name='date' value='$dateToday'>";
                            }
                        ?>
                    </form>
                 </div>

                <?php
                    if(!empty($filter)){
                        GenerateGraphs($filter);
                    }else{
                        //echo "Please select a Partner";
                    }
                ?>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script type="text/javascript">
            $("#date").datepicker({ dateFormat: "yy-mm-dd"});
        </script>
    </body>
</html>
