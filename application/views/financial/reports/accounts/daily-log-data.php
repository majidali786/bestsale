<?php 
$branches=array_column($data,"B_ID");
$branches=array_unique($branches);
sort($branches);
$branches=array_values($branches);
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$vstatus=array("","UN POSTED","POSTED","APPROVED"); 
foreach($branches as $a){
$bdata=array();
foreach($data as $b){
if($b['B_ID']==$a){
array_push($bdata,$b);	
}	
}
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-home"></i><?= $branch[$a];?></b></h2>
</div>
<?php 
$jos=array_column($bdata,"Jo");
$jos=array_unique($jos);
asort($jos);
$jos=array_values($jos);
foreach($jos as $f){
$jdata=array();
foreach($bdata as $h){
if($h['Jo']==$f){
array_push($jdata,$h);	
}	
}
?>
<div class="note note-warning margin-bottom-10">
<h4 class="margin-0"><b><i class="icon-notebook"></i><?= $joInWords[$f];?></b></h4>
</div>
<?php
$nos=array_column($jdata,"VDate","No");
ksort($nos); 
foreach($nos as $g=>$k){
$ndata=array();
foreach($jdata as $i){
if($i['No']==$g){
array_push($ndata,$i);	
}
}		
?>
<h3>Voucher No <span class="label label-primary"><?= $g?></span>  Voucher Date <span class="label label-info"><?= date("d/m/Y",strtotime($k));?></span></h3>
<div class="row">
<div class="col-sm-4">
<div class="note note-danger ">
<p class="block">UnPosted By : <b><?= $ndata[0]['UNPOSTED']?></b></p>
</div> 
</div> 
<div class="col-sm-4">
<div class="note note-warning ">
<p class="block">Posted By : <b><?= $ndata[0]['POSTED']?></b></p>
</div> 
</div> 
<div class="col-sm-4">
<div class="note note-success">
<p class="block">Approved By : <b><?= $ndata[0]['APPROVED']?></b></p>
</div>
</div>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Code</th>
<th>Name</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
</tr>
</thead>
<tbody>
<?php 
$sr=1;
$Debit=$Credit=0;
foreach($ndata as $j){
$Debit+=$j['Debit'];	
$Credit+=$j['Credit'];	
?>
<tr>
<td><?= $sr;?></td>
<td><?= $j['ACode'];?></td>
<td><?= $j['ANAME'];?></td>
<td><?= $j['Descr'];?></td>
<td><?= lakhseparater($j['Debit'],2);?></td>
<td><?= lakhseparater($j['Credit'],2);?></td>
</tr>	
<?php 	
$sr++;
}
?>
<tfoot class="theme-bg">
<td colspan="4">Total</td>
<td><?= lakhseparater($Debit,2);?></td>
<td><?= lakhseparater($Credit,2);?></td>
</tfoot>
</tbody>
</table>
<?php
}
} 	
}	
?>
