<?php  
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$pdata=array();
$cdata=array();
$ndata=array();
$udata=array();
foreach($data as $c){
if($c['STATUS']==0 && $c['TSTATUS']==1){
array_push($pdata,$c);	
}
else if($c['STATUS']==1 && $c['TSTATUS']!=3){
array_push($cdata,$c);	
}
else if($c['STATUS']==0 && $c['TSTATUS']==0){
array_push($ndata,$c);	
}
else if($c['TSTATUS']==3){	
array_push($udata,$c);	
}	
}
if(!empty($pdata)){
?>
<div class="note note-info margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-layers"></i> Pending Cheques</b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Entry Date</th>
<th>Customer Name</th>
<th>Type</th>
<th>Bank</th>
<th>Cheque No.</th>
<th>Clearing Date</th>
<th>Amount</th>
<th>Delivery Date</th>
<th>Agent</th>
</tr>
</thead>
<tbody>
<?php
$sr=1; 
foreach($pdata as $a){
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['ANAME'];?></td>
<td><?= $a['DESCR'];?></td>
<td><?= $a['BNAME'];?></td>
<td><?= $a['CHQNO'];?></td>
<td><?= date("d/m/Y",strtotime($a['CHQDATE']));?></td>
<td><?= lakhseparater($a['DEBIT'],2);?></td>
<td><?= date("d/m/Y",strtotime($a['DDATE']));?></td>
<td><?= $a['AGNAME'];?></td>
</tr>	
<?php 	
$sr++;	
}
?>
</tbody>
</table>
<?php
}
if(!empty($cdata)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-layers"></i> Cleared Cheques</b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Entry Date</th>
<th>Customer Name</th>
<th>Type</th>
<th>Bank</th>
<th>Cheque No.</th>
<th>Clearing Date</th>
<th>Amount</th>
<th>Delivery Date</th>
<th>Agent</th>
</tr>
</thead>
<tbody>
<?php
$sr=1; 
foreach($cdata as $a){
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['ANAME'];?></td>
<td><?= $a['DESCR'];?></td>
<td><?= $a['BNAME'];?></td>
<td><?= $a['CHQNO'];?></td>
<td><?= date("d/m/Y",strtotime($a['CHQDATE']));?></td>
<td><?= lakhseparater($a['DEBIT'],2);?></td>
<td><?= date("d/m/Y",strtotime($a['DDATE']));?></td>
<td><?= $a['AGNAME'];?></td>
</tr>
<?php 	
$sr++;	
}
?>
</tbody>
</table>
<?php
}
if(!empty($ndata)){
?>
<div class="note note-warning margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-layers"></i> Not Assigned Cheques</b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Entry Date</th>
<th>Customer Name</th>
<th>Type</th>
<th>Bank</th>
<th>Cheque No.</th>
<th>Clearing Date</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$sr=1; 
foreach($ndata as $a){
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['ANAME'];?></td>
<td><?= $a['DESCR'];?></td>
<td><?= $a['BNAME'];?></td>
<td><?= $a['CHQNO'];?></td>
<td><?= date("d/m/Y",strtotime($a['CHQDATE']));?></td>
<td><?= lakhseparater($a['DEBIT'],2);?></td>
</tr>
<?php 	
$sr++;	
}
?>
</tbody>
</table>
<?php
}
if(!empty($udata)){
?>
<div class="note note-danger margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-layers"></i> Un Posted Cheques</b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Sr</th>
<th>Entry Date</th>
<th>Customer Name</th>
<th>Type</th>
<th>Bank</th>
<th>Cheque No.</th>
<th>Clearing Date</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<?php
$sr=1; 
foreach($udata as $a){
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['ANAME'];?></td>
<td><?= $a['DESCR'];?></td>
<td><?= $a['BNAME'];?></td>
<td><?= $a['CHQNO'];?></td>
<td><?= date("d/m/Y",strtotime($a['CHQDATE']));?></td>
<td><?= lakhseparater($a['DEBIT'],2);?></td>
</tr>
<?php 	
$sr++;	
}
?>
</tbody>
</table>
<?php
}
?>
<div class="row">

<div class="dashboard-stat red col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= count($pdata);?> </div>
<div class="desc"> Total Pending </div>
</div>
</div>

<div class="dashboard-stat green col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= count($cdata);?> </div>
<div class="desc"> Total Cleared </div>
</div>
</div>
<div class="dashboard-stat purple col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= count($ndata);?> </div>
<div class="desc"> Total Not Assigned </div>
</div>
</div>

<div class="dashboard-stat blue col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= count($udata);?> </div>
<div class="desc"> Total Un Posted </div>
</div>
</div>
</div>

