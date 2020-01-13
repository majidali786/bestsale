<?php 
$lcno=array_column($data,"LCNO");
$lcno=array_unique($lcno);
$lcno=array_values($lcno);
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
foreach($lcno as $e){
$lcnoData=array();
foreach($data as $a){
if($a['LCNO']==$e){
array_push($lcnoData,$a);	
}
}
$ltype=array_column($lcnoData,"LTYPE");
$ltype=array_unique($ltype);
$ltype=array_values($ltype);

$tinwght=$toutwght=$tinqty=$toutqty=$trwght=$trqty=$slwght=$slqty=$inhandqt=$inhandwght=0;
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-user"></i><?= $e?> </b></h2>
</div>
<?php 
if(in_array("2",$ltype)){
?>
<h3 class="margin-0"><b>In Hand(Bond)</b></h3>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Coil</th>
<th>Product</th>
<th>Location</th>
<th>Qty</th>
<th>Weight(MT)</th>
<th>Rate</th>
<th>Branch</th>
</tr>
</thead>
<tbody>
<?php
$qty=$weight=0;
foreach($lcnoData as $b){
if($b['LTYPE']==2){
$qty+=$b['INQT'];	
$weight+=$b['INWGHT'];		
?>
<tr>
<td><?= $b['COIL'];?></td>
<td><?= $b['PNAME'];?></td>
<td><?= $b['TBRANCH'];?></td>
<td class="th-right"><?= number_format($b['INQT']);?></td>
<td class="th-right"><?= number_format($b['INWGHT'],2);?></td>
<td class="th-right"><?= number_format($b['INRATE'],2);?></td>
<td><?= $branch[$b['B_ID']];?></td>
</tr>
<?php
}
}
$tinwght+=$weight;
$tinqty+=$qty;
$inhandwght+=$weight;
$inhandqt+=$qty;
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($qty);?></td>
<td class="th-right"><?= number_format($weight,2);?></td>
<td></td>
<td></td>
</tfoot>
</table>
<?php 
}
if(in_array("1",$ltype)){
?>
<h3 class="margin-0"><b>Stock Transfer</b></h3>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data">
<thead class="theme-bg">
<tr>
<th rowspan="2" style="vertical-align:middle">Coil</th>
<th rowspan="2" style="vertical-align:middle">Product</th>
<th rowspan="2" style="vertical-align:middle">Location</th>
<th colspan="3" style="text-align:center">In</th>
<th colspan="3" style="text-align:center">Out</th>
<th rowspan="2" style="vertical-align:middle">Branch</th>
</tr>
<tr>
<th>Qty</th>
<th>Weight(MT)</th>
<th>Rate</th>
<th>Qty</th>
<th>Weight(MT)</th>
<th>Rate</th>
</tr>
</thead>
<tbody>
<?php
$qty=$weight=$qty1=$weight1=0;
foreach($lcnoData as $b){
if($b['LTYPE']==1){
$qty+=$b['INQT'];	
$weight+=$b['INWGHT'];
$qty1+=$b['OUTQT'];	
$weight1+=$b['OUTWGHT'];		
?>
<tr>
<td><?= $b['COIL'];?></td>
<td><?= $b['PNAME'];?></td>
<td><?= $b['TBRANCH'];?></td>
<td class="th-right"><?= number_format($b['INQT']);?></td>
<td class="th-right"><?= number_format($b['INWGHT'],2);?></td>
<td class="th-right"><?= number_format($b['INRATE'],2);?></td>
<td class="th-right"><?= number_format($b['OUTQT']);?></td>
<td class="th-right"><?= number_format($b['OUTWGHT'],2);?></td>
<td class="th-right"><?= number_format($b['OUTRATE'],2);?></td>
<td><?= $branch[$b['B_ID']];?></td>
</tr>
<?php
}
}
$tinwght+=$weight;
$tinqty+=$qty;
$toutwght+=$weight1;
$toutqty+=$qty1;
$trwght+=$weight1;
$trqty+=$qty1;
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($qty);?></td>
<td class="th-right"><?= number_format($weight,2);?></td>
<td></td>
<td class="th-right"><?= number_format($qty1);?></td>
<td class="th-right"><?= number_format($weight1,2);?></td>
<td></td>
<td></td>
</tfoot>
</table>
<?php 
}
if(in_array("3",$ltype)){
?>
<h3 class="margin-0"><b>Stock Sale</b></h3>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data">
<thead class="theme-bg">
<tr>
<th rowspan="2" style="vertical-align:middle">Coil</th>
<th rowspan="2" style="vertical-align:middle">Product</th>
<th rowspan="2" style="vertical-align:middle">Location</th>
<th colspan="3" style="text-align:center">In</th>
<th colspan="3" style="text-align:center">Out</th>
<th rowspan="2" style="vertical-align:middle">Branch</th>
</tr>
<tr>
<th>Qty</th>
<th>Weight(MT)</th>
<th>Rate</th>
<th>Qty</th>
<th>Weight(MT)</th>
<th>Rate</th>
</tr>
</thead>
<tbody>
<?php
$qty=$weight=$qty1=$weight1=0;
foreach($lcnoData as $b){
if($b['LTYPE']==3){
$qty+=$b['INQT'];	
$weight+=$b['INWGHT'];
$qty1+=$b['OUTQT'];	
$weight1+=$b['OUTWGHT'];		
?>
<tr>
<td><?= $b['COIL'];?></td>
<td><?= $b['PNAME'];?></td>
<td><?= $b['TBRANCH'];?></td>
<td class="th-right"><?= number_format($b['INQT']);?></td>
<td class="th-right"><?= number_format($b['INWGHT'],2);?></td>
<td class="th-right"><?= number_format($b['INRATE'],2);?></td>
<td class="th-right"><?= number_format($b['OUTQT']);?></td>
<td class="th-right"><?= number_format($b['OUTWGHT'],2);?></td>
<td class="th-right"><?= number_format($b['OUTRATE'],2);?></td>
<td><?= $branch[$b['B_ID']];?></td>
</tr>
<?php
}
}
$tinwght+=$weight;
$tinqty+=$qty;
$toutwght+=$weight1;
$toutqty+=$qty1;
$slwght+=$weight1;
$slqty+=$qty1;
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($qty);?></td>
<td class="th-right"><?= number_format($weight,2);?></td>
<td></td>
<td class="th-right"><?= number_format($qty1);?></td>
<td class="th-right"><?= number_format($weight1,2);?></td>
<td></td>
<td></td>
</tfoot>
</table>
<?php 
}
?>
<div class="row">

<div class="dashboard-stat red col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($tinqty);?> Pcs</div>
<div class="desc"> Total Qty </div>
</div>
</div>

<div class="dashboard-stat green col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($tinwght,2);?> (MT)</div>
<div class="desc"> Total Weight </div>
</div>
</div>

<div class="dashboard-stat purple col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($toutqty);?> Pcs</div>
<div class="desc"> Total Out Qty </div>
</div>
</div>

<div class="dashboard-stat blue col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($toutwght,2);?> (MT)</div>
<div class="desc"> Total Out Weight </div>
</div>
</div>

<div class="dashboard-stat green col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($inhandqt);?> Pcs</div>
<div class="desc"> Inhand Qty </div>
</div>
</div>

<div class="dashboard-stat red col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($inhandwght,2);?> (MT)</div>
<div class="desc"> Inhand Weight </div>
</div>
</div>


<div class="dashboard-stat yellow col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($trqty);?> Pcs</div>
<div class="desc"> Transfer Qty</div>
</div>
</div>

<div class="dashboard-stat green col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($trwght,2);?> (MT)</div>
<div class="desc">  Transfer Weight </div>
</div>
</div>

<div class="dashboard-stat yellow col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($slqty);?> Pcs</div>
<div class="desc"> Sold Qty</div>
</div>
</div>

<div class="dashboard-stat green col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($slwght,2);?> (MT)</div>
<div class="desc">  Sold Weight </div>
</div>
</div>

</div>

<?php 
} 

?>