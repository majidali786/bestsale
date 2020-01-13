<?php 
if(!empty($data)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> <?= $data[0]['PNAME']?></b></h2>
</div>
<?php 	
}
?>
<table class="table table-striped table-bordered table-hover order-column" id="ss-stock-transfer">
<thead class="theme-bg">
<tr>
<th rowspan="2" style="vertical-align:middle">Sr</th>
<th rowspan="2" style="vertical-align:middle">Vr.No</th>
<th rowspan="2" style="vertical-align:middle">Date</th>
<th rowspan="2" style="vertical-align:middle">Jo</th>
<th colspan="3" style="text-align:center">In</th>
<th colspan="3" style="text-align:center">Out</th>
<th colspan="3" style="text-align:center">Balance</th>
<th rowspan="2" style="vertical-align:middle">Department</th>
<th rowspan="2" style="vertical-align:middle">Branch</th>
</tr>
<tr>
<th>Weight</th>
<th>Qty</th>
<th>Feet</th>
<th>Weight</th>
<th>Qty</th>
<th>Feet</th>
<th>Weight</th>
<th>Qty</th>
<th>Feet</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$tinwght=$toutwght=$tinqty=$toutqty=$tinfeet=$toutfeet=$bwght=$bqty=$bfeet=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
$tinqty+=$a['INQT'];
$toutqty+=$a['OUTQT'];
$bqty+=$a['INQT'];
$bqty-=$a['OUTQT'];

$tinwght+=$a['INWGHT'];
$toutwght+=$a['OUTWGHT'];
$bwght+=$a['INWGHT'];
$bwght-=$a['OUTWGHT'];

$tinfeet+=$a['INFT'];
$toutfeet+=$a['OUTFT'];
$bfeet+=$a['INFT'];
$bfeet-=$a['OUTFT'];

?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['NO'];?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['JO'];?></td>
<td class="th-right"><?= number_format($a['INWGHT'],2);?></td>
<td class="th-right"><?= number_format($a['INQT'],2);?></td>
<td class="th-right"><?= number_format($a['INFT'],2);?></td>
<td class="th-right"><?= number_format($a['OUTWGHT'],2);?></td>
<td class="th-right"><?= number_format($a['OUTQT'],2);?></td>
<td class="th-right"><?= number_format($a['OUTFT'],2);?></td>
<td class="th-right"><?= number_format($bwght,2);?></td>
<td class="th-right"><?= number_format($bqty,2);?></td>
<td class="th-right"><?= number_format($bfeet,2);?></td>
<td><?= $a['DPName'];?></td>
<td><?= $branch[$a['B_ID']];?></td>
</tr>
<?php
$sr++;

endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($tinwght,2);?></td>
<td class="th-right"><?= number_format($tinqty,2);?></td>
<td class="th-right"><?= number_format($tinfeet,2);?></td>
<td class="th-right"><?= number_format($toutwght,2);?></td>
<td class="th-right"><?= number_format($toutqty,2);?></td>
<td class="th-right"><?= number_format($toutfeet,2);?></td>
<td class="th-right"><?= number_format($bwght,2);?></td>
<td class="th-right"><?= number_format($bqty,2);?></td>
<td class="th-right"><?= number_format($bfeet,2);?></td>
<td></td>
<td></td>
</tr>
</tfoot>
</table>
<div class="row">

<div class="dashboard-stat red col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($tinwght);?> Kg</div>
<div class="desc"> Total IN(Weight) </div>
</div>
</div>

<div class="dashboard-stat green col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($toutwght);?> Kg</div>
<div class="desc"> Total Out(Weight) </div>
</div>
</div>

<div class="dashboard-stat purple col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($tinqty);?> Pcs</div>
<div class="desc"> Total IN(Qty) </div>
</div>
</div>

<div class="dashboard-stat blue col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($toutqty);?> Pcs</div>
<div class="desc">  Total Out(Qty) </div>
</div>
</div>

<div class="dashboard-stat green col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($tinfeet);?> Ft</div>
<div class="desc"> Total IN(Feet)</div>
</div>
</div>

<div class="dashboard-stat red col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($toutfeet);?> Ft</div>
<div class="desc">Total Out(Feet)</div>
</div>
</div>


<div class="dashboard-stat yellow col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($bwght);?> Kg</div>
<div class="desc"> Balance Weight </div>
</div>
</div>
<div class="dashboard-stat green col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($bqty);?> Pcs</div>
<div class="desc">  Balance Qty </div>
</div>
</div>

<div class="dashboard-stat yellow col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"><?= number_format($bfeet);?> Ft</div>
<div class="desc">  Balance Feet </div>
</div>
</div>

</div>
