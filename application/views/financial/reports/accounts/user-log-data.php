<?php 
$employee=array_column($data,"U_ID");
$employee=array_unique($employee);
sort($employee);
$employee=array_values($employee);
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

$vstatus=array("","UN POSTED","POSTED","APPROVED"); 
foreach($employee as $a){
$edata=array();
foreach($data as $b){
if($b['U_ID']==$a){
array_push($edata,$b);	
}	
}
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-user"></i><?= $a?> </b></h2>
</div>
<?php
if($rtype==2){ 
$branches=array_column($edata,"B_ID");
$branches=array_unique($branches);
sort($branches);
$branches=array_values($branches);
foreach($branches as $c){
$bdata=array();
foreach($edata as $d){
if($d['B_ID']==$c){
array_push($bdata,$d);	
}	
}
?>
<div class="note note-danger margin-bottom-10">
<h3 class="margin-0"><b><i class="icon-home"></i><?= $branch[$c];?> </b></h3>
</div>
<?php 
$vouchers=array_column($bdata,"JO","NO");
asort($vouchers);
foreach($vouchers as $f=>$g){
$vdata=array();
foreach($bdata as $h){
if($h['NO']==$f && $h['JO']==$g){
array_push($vdata,$h);	
}	
}
?>
<div class="note note-warning margin-bottom-10">
<h4 class="margin-0"><b><i class="icon-notebook"></i><?= $joInWords[$g];?> No : <?= $f?></b></h4>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Date</th>
<th>Voucher Status</th>
<th>Type</th>
</tr>
</thead>
<tbody>
<?php 
$sr=1;
foreach($vdata as $i){
$vtype="Edit";
if($i['ROWNO']==1){
$vtype="New";	
}	
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y h:i:s A",strtotime($i['VDATE']));?></td>
<td><?= $vstatus[$i['TYPE']];?></td>
<td><?= $vtype;?></td>
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
}
if($rtype==1){
?>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Branch</th>
<th>Voucher</th>
<th>No</th>
<th>Date</th>
<th>Voucher Status</th>
<th>Type</th>
</tr>
</thead>
<tbody>
<?php 
$sr=1;	
foreach($edata as $d){		
$vtype="Edit";
if($d['ROWNO']==1){
$vtype="New";	
}	
?>
<tr>
<td><?= $sr;?></td>
<td><?= $branch[$d['B_ID']];?></td>
<td><?= $joInWords[$d['JO']];?></td>
<td><?= $d['NO'];?></td>
<td><?= date("d/m/Y h:i:s A",strtotime($d['VDATE']));?></td>
<td><?= $vstatus[$d['TYPE']];?></td>
<td><?= $vtype;?></td>
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
