<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class=" icon-layers font-green"></i>
<span class="caption-subject font-green bold uppercase">Dash Board</span>
</div>
<div class="actions">
<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
<i class="icon-cloud-upload"></i>
</a>
<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
<i class="icon-wrench"></i>
</a>
<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
<i class="icon-trash"></i>
</a>
</div>
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load('visualization', '1', {packages: ['corechart']});
</script>
<?php
$date1 = date("Y-m-d");
$date2 = date('Y-m-d', strtotime("-2 months", strtotime($date1)));  // 1 month before
$date3 = date('Y-m-d', strtotime("-2 months", strtotime($date2)));   // 2 months bofore
$d1 = date('M-Y', strtotime($date1));	// current month
$d2= date("M-Y",mktime(0,0,0,date("m")-2,1,date("Y")));
$d3 = date('M-Y', strtotime($date3));	// 2 month

$mn1 = date('m', strtotime($date1));	// current month
$mn2= date("m",mktime(0,0,0,date("m")-2,1,date("Y")));
$y2= date('Y',strtotime($date1));
$mn3 = date('m', strtotime($date3));
?>
<div class="page-content-inner">
<div class="portlet light portlet-fit ">

<div class="portlet-body">
<div class="row">
<div class="col-sm-3">
<div class="panel panel-color panel-primary">
<div class="panel-heading" style="background-color:Blue">
<h3 class="panel-title" style="text-align:center;color:white;">Color<i class="ti-arrow-down" ></i><?php echo $d1;?></h3>
</div>
<div id="visualization" style="width: 250px; height: 300px;"></div>
<script type="text/javascript">
//google.setOnLoadCallback(drawVisualization);
function drawVisualization() {
// Create and populate the data table.
var data = google.visualization.arrayToDataTable([
['Group', 'Qty'],
<?php
foreach ($pie_chart['data1']->result_array() as $row) {
echo "['".$row['COLOR']."',".abs($row['CTQT'])."],";	
}
?>
]);
var options = {
title: '',
is3D: true,
};

var chart = new google.visualization.PieChart(document.getElementById('visualization'));
chart.draw(data, options);
}
drawVisualization();
</script>
</div>
</div>

<div class="col-sm-3">
<div class="panel panel-color panel-primary">
<div class="panel-heading" style="background-color:green">
<h3 class="panel-title" style="text-align:center;color:white;">Color<i class="ti-arrow-down" ></i><?php echo $d2;?></h3>
</div>
<div id="visualization2" style="width: 250px; height: 300px;"></div>
<script type="text/javascript">

//google.setOnLoadCallback(drawVisualization);
function drawVisualization2() {
// Create and populate the data table.
var data = google.visualization.arrayToDataTable([
['Group', 'Qty'],
<?php
foreach ($pie_chart['data1']->result_array() as $row) {
echo "['".$row['COLOR']."',".abs($row['TQT'])."],";	
}

?>
]);

var options = {
title: '',
is3D: true,
};

var chart = new google.visualization.PieChart(document.getElementById('visualization2'));
chart.draw(data, options);
}
drawVisualization2();

</script>



</div>
</div>



<div class="col-sm-3">
<div class="panel panel-color panel-primary">
<div class="panel-heading" style="background-color:Red">
<h3 class="panel-title" style="text-align:center;color:white;">Design<i class="ti-arrow-down" ></i><?php echo $d1;?></h3>
</div>
<div id="visualization3" style="width: 250px; height: 300px;"></div>
<script type="text/javascript">
//google.setOnLoadCallback(drawVisualization);
function drawVisualization3() {
// Create and populate the data table.
var data2 = google.visualization.arrayToDataTable([
['Group', 'Qty'],
<?php
foreach ($pie_chart['data2']->result_array() as $row) {
echo "['".$row['DESIGN']."',".abs($row['CTQT'])."],";	
}

?>
]);

var options = {
title: '',
is3D: true,
};

var chart = new google.visualization.PieChart(document.getElementById('visualization3'));
chart.draw(data2, options);
}
drawVisualization3();
</script>
</div>
</div>



<div class="col-sm-3">
<div class="panel panel-color panel-primary">
<div class="panel-heading" style="background-color:#006064">
<h3 class="panel-title" style="text-align:center;color:white;">Design<i class="ti-arrow-down" ></i><?php echo $d2;?></h3>
</div>
<div id="visualization4" style="width: 250px; height: 300px;"></div>
<script type="text/javascript">

//google.setOnLoadCallback(drawVisualization);
function drawVisualization4() {
// Create and populate the data table.
var data2 = google.visualization.arrayToDataTable([
['Group', 'Qty'],
<?php
foreach ($pie_chart['data2']->result_array() as $row) {
echo "['".$row['DESIGN']."',".abs($row['TQT'])."],";	
}

?>
]);

var options = {
title: '',
is3D: true,
};

var chart = new google.visualization.PieChart(document.getElementById('visualization4'));
chart.draw(data2, options);
}
drawVisualization4();

</script>



</div>
</div>

</div>
<div id="columnchart_material" style="width:100%; height: 900px;"></div>


</div>
</div>
</div>

<script type="text/javascript">

// google.charts.load('current', {'packages':['corechart']});
// google.charts.setOnLoadCallback(drawChart);

function drawChart3() {
var data = google.visualization.arrayToDataTable([

['Year', 'Customer Balance','Sales','Recovery','Expense'],
<?php 
$i=3;
$months = array(
'',
'January',
'February',
'March',
'April',
'May',
'June',
'July ',
'August',
'September',
'October',
'November',
'December',
);
foreach($graph->result() as $balace)
{
$credit+=$balace->totbal;
$tcredit=$balace->sale;
$trecovery=$balace->trecovery;
$expense=$balace->expense;
$month=$months[$balace->MONTH]. " ".$balace->YEAR;


echo "['$month',$credit,$tcredit,$trecovery,$expense],";
}
?>

]);

var options = {
chart: {
title: '',
subtitle: 'For Year: 2019 ',
},
orientation: 'horizontal'
};
var chart = new google.visualization.BarChart(document.getElementById('columnchart_material'));
chart.draw(data,options);
}
drawChart3();
</script>



 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<div id="myfirstchart" style="height: 50px;"></div>
<?php
 

$dataPoints = array( 
	/* array("label"=>"SALES", "symbol" => "O","y"=>46.6),
	array("label"=>"CUSTOMER", "symbol" => "Si","y"=>27.7),
	array("label"=>"Aluminium", "symbol" => "Al","y"=>13.9),
	array("label"=>"Iron", "symbol" => "Fe","y"=>5),
	array("label"=>"Calcium", "symbol" => "Ca","y"=>3.6),
	array("label"=>"Sodium", "symbol" => "Na","y"=>2.6),
	array("label"=>"Magnesium", "symbol" => "Mg","y"=>2.1),
	array("label"=>"Others", "symbol" => "Others","y"=>1.5), */
 
)
 
?>

<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: " "
	},
	data: [{
		type: "doughnut",
		indexLabel: "{symbol} - {y}",
		yValueFormatString: "#,##0.0\"%\"",
		showInLegend: true,
		legendText: "{label} : {y}",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>


