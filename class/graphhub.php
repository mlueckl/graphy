<?php
require_once("graph.php");

class GraphHub{
    protected static $hub = array();
    protected static $count = 0;

    // Add a new Graph to the Hub
    function addGraph($graph){
        array_push(self::$hub, $graph);
        self::$count++;
    }

    // Return Graph's inside the Hub
    function returnHub(){
        return self::$hub;
    }

    // Return number of Graph's in Hub
    static function countHub(){
        return self::$count;
    }

    /* TODO: Calc average time for each WS in total
    static function globalAverageGraph(){
        $graph = new Graph("Average Graph");

        //var_dump(self::$hub);

        foreach(self::$hub as $graph){
            foreach($graph->time() as $name => $day){
                $data = explode(";", $day);
                $average = array_sum($data) / count($day);



                $averagePerDB .= "<tr><td>$graph->name</td><td>" . $average . "s</td></tr>";
            }

            echo "<div class='average_per_db'><table>$averagePerDB</table></div>";
        }
    }
    */
}
?>
