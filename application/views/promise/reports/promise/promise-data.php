<?php 
$party=array_column($data['data1'],"ANAME","ACODE");
ksort($party); 
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$vstatus=array("","UN POSTED","POSTED","APPROVED"); 
foreach($party as $a=>$b){
$pdata=array();
foreach($data['data1'] as $c){
if($c['ACODE']==$a){
array_push($pdata,$c);	
}	
}
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-user"></i> <?= $a." ".$b;?></b></h2>
</div>
<?php 
$fstatus=array("Closed","Pending");
$fsclass=array("danger","primary");
foreach($pdata as $f){	
?>
<div class="note note-warning margin-bottom-10 cursor-pointer" promise-no="<?=$f['NO']?>">
<table class="table" style="margin:0;">
<tr>
<th colspan="3" style="text-align:center"><h3 style="margin:0;padding:0"><span class="label label-<?= $fsclass[$f['STATUS']]?>"><b><?= $fstatus[$f['STATUS']]?></b></span></h3></th>
</tr>
<tr>
<th><h3><b>Promise No :</b> <?=$f['NO']?></h3></th>
<th><h3><b>Voucher Date :</b> <?= date("d/m/Y",strtotime($f['VDATE']));?></h3></th>
<th><h3><b>Description :</b> <?=$f['DESCR']?></h3></th>
</tr>
<tr>
<th><h3><b>Promise Date :</b> <?= date("d/m/Y",strtotime($f['PDATE']));?></h3></th>
<th><h3><b>Promise Amount :</b> <?= lakhseparater($f['AMOUNT'])?></h3></th>
<th><h3><b>Promise Make Date :</b> <?= date("d/m/Y",strtotime($f['PMDATE']));?></h3></th>
</tr>
</table>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Date</th>
<th>Paid Amount</th>
<th>Description</th>
<th>Expected Date</th>
<th>Expected Amount</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php
$sr=1;
foreach($data['data2'][$f['NO']."-".$f['B_ID']] as $g){		
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($g['VDATE']));?></td>
<td><?= lakhseparater($g['PAMOUNT'],2);?></td>
<td><?= $g['DESCR'];?></td>
<td><?php if($g['STATUS']==1){ echo date("d/m/Y",strtotime($g['EDATE'])); } ?></td>
<td><?php if($g['STATUS']==1){ echo lakhseparater($g['EAMOUNT'],2); } ?></td>
<td><?= $fstatus[$g['STATUS']]?></td>
</tr>	
<?php 	
$sr++;
}
?>
</tbody>
</table>
<?php
}
} 		
?>
<style>
.cursor-pointer{
cursor:pointer;	
}
</style>
<script>
singlePromiseUrl="<?= base_url("load-promise")?>";
</script>