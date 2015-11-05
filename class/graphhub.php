<?php
class GraphHub{
    protected $hub = array();
    protected $count = 0;

    // Add a new Graph to the Hub
    function addGraph($graph){
        array_push($this->hub, $graph);
        $this->count++;
    }

    // Return Graph's inside the Hub
    function returnHub(){
        return $this->hub;
    }

    // Return number of Graph's in Hub
    function countHub(){
        return $this->count;
    }
}
?>
