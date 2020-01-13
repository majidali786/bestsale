<?php 
$bid = array_column($data, 'B_ID');
$bid = array_unique($bid);
$bid = array_values($bid);
sort($bid);
$invno = array_column($data, 'CDAYS');
$invno = array_unique($invno);
$invno = array_values($invno);
sort($invno); 
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
for($b=0;$b<count($bid);$b++){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> <?= $branch[$bid[$b]]?></b></h2>
</div>
<?php 
for($c=0;$c<count($invno);$c++){
?>
<table class="table table-striped table-bordered table-hover order-column">
<thead>
<tr>
<th>Sr</th>
<th>Date</th>
<th>Vr.Type</th>
<th>Vr.No</th>
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
if(!empty($data)){
$sr=1;
foreach($data as $a):
if($a['B_ID']==$bid[$b] && $a['CDAYS']==$invno[$c])
{
$bal+=$a['DEBIT'];
$bal-=$a['CREDIT'];
$tdebit+=$a['DEBIT'];
$tcredit+=$a['CREDIT'];
if($a['DEBIT']>0){
$class="bg-debit";
}
else{
$class="bg-credit";
}
$cdate=$a['VDATE'];
if($prevDate!=""){
$diff=date_diff(date_create($cdate),date_create($prevDate));
$days+=$diff->format("%a");	
}
$prevDate=$a['VDATE'];
?>
<tr class="<?= $class;?>">
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['JO'];?></td>
<td><?= $a['NO'];?></td>
<td><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['CREDIT'],2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td><?= $days;?></td>
<td><?= $branch[$a['B_ID']];?></td>
</tr>
<?php
$sr++;
}
endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="5">Total</th>
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