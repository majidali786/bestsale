<?php 
$bid = array_column($data, 'B_ID');
$bid = array_unique($bid);
$bid = array_values($bid);
sort($bid);
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
foreach($bid as $b){
$bdata=array();
foreach($data as $a){
if($a['B_ID']==$b){
array_push($bdata,$a);	
}	
}
$invno = array_column($bdata, 'CDAYS');
$invno = array_unique($invno);
$invno = array_values($invno);
sort($invno);
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> <?= $branch[$b]?></b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead>
<tr>
<th>Sr</th>
<th>Date</th>
<th>Vr.No</th>
<th>Total</th>
<th>Paid</th>
<th>Remaning</th>
<th>Age</th>
</tr>
</thead>
<tbody>
<?php 
$todebit=$tocredit=$tbal=0;
$sr=1;
foreach($invno as $c){
$indata=array();
foreach($bdata as $d){
if($d['CDAYS']==$c){
array_push($indata,$d);	
}	
}
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$tdebit=$tcredit=$bal=$days=0;
$prevDate="";
if(!empty($indata)){
foreach($indata as $a):
$bal-=$a['DEBIT'];
$bal+=$a['CREDIT'];
$tdebit+=$a['DEBIT'];
$tcredit+=$a['CREDIT'];
$tbal-=$a['DEBIT'];
$tbal+=$a['CREDIT'];
$todebit+=$a['DEBIT'];
$tocredit+=$a['CREDIT'];
if($a['DEBIT']>0){
$class="bg-debit";
}
else{
$class="bg-credit";
}
$cdate=$a['VDATE'];
if($prevDate!=""){
$diff=date_diff(date_create($cdate),date_create($prevDate));
$days+=$diff->format("%r%a");	
}
$prevDate=$a['VDATE'];
endforeach;
}
$diff=date_diff(date_create($a['VDATE']),date_create(date("Y-m-d")));
$days=$diff->format("%r%a");	
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><a href="javascript:void(0);" onclick="vdetail('<?= $a['NO'];?>','<?= $a['JO'];?>','<?= $a['B_ID'];?>','<?= $a['VDATE'];?>');"><?= $a['NO'];?></a></td>
<td class="th-right"><?= number_format($tcredit,2);?></td>
<td class="th-right"><?= number_format($tdebit,2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td class="th-right"><?= number_format($days);?></td>
</tr>
<?php
$sr++; 
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($tocredit,2);?></td>
<td class="th-right"><?= number_format($todebit,2);?></td>
<td class="th-right"><?= number_format($tbal,2);?></td>
<td class="th-right"></td>
</tr>
</tfoot>
</table>
<div class="row">

<div class="dashboard-stat red col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($todebit);?> </div>
<div class="desc"> Total Debit </div>
</div>
</div>

<div class="dashboard-stat green col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($tocredit);?> </div>
<div class="desc"> Total Credit </div>
</div>
</div>
<div class="dashboard-stat purple col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($tbal);?> </div>
<div class="desc"> Total Balance </div>
</div>
</div>

</div>

<?php 
}
?>
<style>
.bg-debit{
background:#b39ddb !important;
}
.bg-credit{
background:#90caf9 !important;
}
</style>