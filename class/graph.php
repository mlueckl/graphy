<?php
class Graph{
    protected $id; // Generated ID from Name
    protected $name; // Name of the Graph/DB
    protected $yaxis = array(); // Labels for the Graph
    protected $data = array(); // Data to show in Graph

    // Initialise Graph with Name and generate ID
    function __construct($name){
        $this->id = $this->generateID($name);
        $this->name = $name;
    }

    // Generate ID based on name
    function generateID($name){
        $id = strtolower($name);
        $id = str_replace(" ", "", $id);
        $id = str_replace("-", "", $id);
        $id = str_replace("_", "", $id);

        return $id;
    }

    // Add y-axis value to y-axis array
    function addYAxisValue($value){
        array_push($this->yaxis, $value);
    }

    // Add data value to data array
    function addData($value){
        array_push($this->data, $value);
    }

    // Draw Graph to page
    function draw(){
        $html = "";

        $html .= "<h3>$this->name</h3>";
        $html .= "<canvas id='$this->id' height='300' width='1000'></canvas>";
        $html .= "<script>";
        $html .= "var lineChartData$this->id = { labels: ".json_encode($this->data).",datasets: [{label: 'DatabaseName',fillColor: 'rgba(156,39,176,0.2)',strokeColor: 'rgba(156,39,176,1)',pointColor: 'rgba(156,39,176,1)',pointStrokeColor: '#E0E0E0',pointHighlightFill: '#E0E0E0',pointHighlightStroke: 'rgba(156,39,176,1)',data: ".json_encode($this->data)."}]};";
        $html .= "Chart.defaults.global.scaleLineColor = 'rgba(224,224,224,.4)';";
        $html .= "Chart.defaults.global.scaleFontColor = '#E0E0E0';";
        $html .= "(function() {";
        $html .= "var $this->id = document.getElementById('$this->id').getContext('2d');";
        $html .= "window.myLine = new Chart($this->id).Line(lineChartData$this->id, { responsive: true });";
        $html .= "})()</script>";

        echo $html;
    }
}
?>
