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
<?php 
$todebit=$tocredit=$tbal=0;
foreach($invno as $c){
$indata=array();
foreach($bdata as $d){
if($d['CDAYS']==$c){
array_push($indata,$d);	
}	
}
?>
<table class="table table-striped table-bordered table-hover order-column">
<thead>
<tr>
<th>Sr</th>
<th>Date</th>
<th>Vr.Type</th>
<th>Vr.No</th>
<th>Chq.No</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
<th>Balance</th>
<th>Days</th>
<th>Branch</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$tdebit=$tcredit=$bal=$days=0;
$prevDate="";
if(!empty($indata)){
$sr=1;
foreach($indata as $a):
$bal+=$a['DEBIT'];
$bal-=$a['CREDIT'];
$tdebit+=$a['DEBIT'];
$tcredit+=$a['CREDIT'];
$tbal+=$a['DEBIT'];
$tbal-=$a['CREDIT'];
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
?>
<tr class="<?= $class;?>">
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><a href="javascript:void(0);" onclick="vdetail('<?= $a['NO'];?>','<?= $a['JO'];?>','<?= $a['B_ID'];?>','<?= $a['VDATE'];?>');"><?= $a['NO'];?></a></td>
<td><?= $a['NO'];?></td>
<td><?= $a['CHQNO'];?></td>
<td><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['CREDIT'],2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td><?= $days;?></td>
<td><?= $branch[$a['B_ID']];?></td>
</tr>
<?php
$sr++;
endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="6">Total</th>
<td class="th-right"><?= number_format($tdebit,2);?></td>
<td class="th-right"><?= number_format($tcredit,2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td class="th-right"><?= number_format($days);?></td>
<td></td>
</tr>
</tfoot>
</table>
<?php 
}
?>
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