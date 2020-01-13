<?php 
$employee=array_column($data,"ANAME");
$employee=array_unique($employee);
$employee=array_values($employee);
foreach($employee as $e){
$employeeData=array();
foreach($data as $a){
if($a['ANAME']==$e){
array_push($employeeData,$a);	
}
}
$ltype=array_column($employeeData,"LTYPE");
$ltype=array_unique($ltype);
$ltype=array_values($ltype);

$tdebit=$tcredit=$tbal=$debit1=$credit1=$bal1=$debit2=$credit2=$bal2=$debit3=$credit3=$bal3=0;
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-user"></i><?= $e?> </b></h2>
</div>
<?php 
if(in_array("1",$ltype)){
?>
<h3 class="margin-0"><b>Short Term Loan</b></h3>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data">
<thead class="theme-bg">
<tr>
<th>No</th>
<th>Date</th>
<th>Jo</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
<th>Balannce</th>
</tr>
</thead>
<tbody>
<?php
$debit=$credit=$bal=0;
foreach($employeeData as $b){
if($b['LTYPE']==1){
$debit+=$b['Debit'];	
$credit+=$b['Credit'];	
$bal+=$b['Debit'];	
$bal-=$b['Credit'];	
?>
<tr>
<td><?= $b['No'];?></td>
<td><?= date("d/m/Y",strtotime($b['VDate']));?></td>
<td><?= $b['Jo'];?></td>
<td><?= $b['Descr'];?></td>
<td class="th-right"><?= number_format($b['Debit']);?></td>
<td class="th-right"><?= number_format($b['Credit']);?></td>
<td class="th-right"><?= number_format($bal);?></td>
</tr>
<?php
}
}
$debit1=$debit;
$credit1=$credit;
$bal1=$bal;
$tdebit+=$debit;
$tcredit+=$credit;
$tbal+=$bal;
?>
</tbody>
<tfoot>
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($debit);?></td>
<td class="th-right"><?= number_format($credit);?></td>
<td class="th-right"><?= number_format($bal);?></td>
</tfoot>
</table>
<?php 
}
if(in_array("2",$ltype)){
?>
<h3 class="margin-0"><b>Long Term Loan</b></h3>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data">
<thead class="theme-bg">
<tr>
<th>No</th>
<th>Date</th>
<th>Jo</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
<th>Balannce</th>
</tr>
</thead>
<tbody>
<?php
$debit=$credit=$bal=0;
foreach($employeeData as $b){
if($b['LTYPE']==2){
$debit+=$b['Debit'];	
$credit+=$b['Credit'];	
$bal+=$b['Debit'];	
$bal-=$b['Credit'];	
?>
<tr>
<td><?= $b['No'];?></td>
<td><?= date("d/m/Y",strtotime($b['VDate']));?></td>
<td><?= $b['Jo'];?></td>
<td><?= $b['Descr'];?></td>
<td class="th-right"><?= number_format($b['Debit']);?></td>
<td class="th-right"><?= number_format($b['Credit']);?></td>
<td class="th-right"><?= number_format($bal);?></td>
</tr>
<?php
}
}
$debit2=$debit;
$credit2=$credit;
$bal2=$bal;
$tdebit+=$debit;
$tcredit+=$credit;
$tbal+=$bal;
?>
</tbody>
<tfoot>
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($debit);?></td>
<td class="th-right"><?= number_format($credit);?></td>
<td class="th-right"><?= number_format($bal);?></td>
</tfoot>
</table>
<?php 
}
if(in_array("3",$ltype)){
?>
<h3 class="margin-0"><b>Advance</b></h3>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data">
<thead class="theme-bg">
<tr>
<th>No</th>
<th>Date</th>
<th>Jo</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
<th>Balannce</th>
</tr>
</thead>
<tbody>
<?php
$debit=$credit=$bal=0;
foreach($employeeData as $b){
if($b['LTYPE']==3){
$debit+=$b['Debit'];	
$credit+=$b['Credit'];	
$bal+=$b['Debit'];	
$bal-=$b['Credit'];	
?>
<tr>
<td><?= $b['No'];?></td>
<td><?= date("d/m/Y",strtotime($b['VDate']));?></td>
<td><?= $b['Jo'];?></td>
<td><?= $b['Descr'];?></td>
<td class="th-right"><?= number_format($b['Debit']);?></td>
<td class="th-right"><?= number_format($b['Credit']);?></td>
<td class="th-right"><?= number_format($bal);?></td>
</tr>
<?php
}
}
$debit3=$debit;
$credit3=$credit;
$bal3=$bal;
$tdebit+=$debit;
$tcredit+=$credit;
$tbal+=$bal;
?>
</tbody>
<tfoot>
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($debit);?></td>
<td class="th-right"><?= number_format($credit);?></td>
<td class="th-right"><?= number_format($bal);?></td>
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
<div class="number"> Rs. <?= number_format($debit1);?> </div>
<div class="desc"> Short Term Loan </div>
</div>
</div>

<div class="dashboard-stat green col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($credit1);?> </div>
<div class="desc"> Paid Short Term Loan </div>
</div>
</div>

<div class="dashboard-stat purple col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($debit2);?> </div>
<div class="desc"> Long Term Loan </div>
</div>
</div>

<div class="dashboard-stat blue col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($credit2);?> </div>
<div class="desc"> Paid Long Term Loan </div>
</div>
</div>

<div class="dashboard-stat green col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($debit3);?> </div>
<div class="desc"> Advance </div>
</div>
</div>

<div class="dashboard-stat red col-sm-2">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($credit3);?> </div>
<div class="desc"> Paid Advance </div>
</div>
</div>


<div class="dashboard-stat yellow col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($tdebit);?> </div>
<div class="desc"> Loan/Advance </div>
</div>
</div>
<div class="dashboard-stat green col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($tcredit);?> </div>
<div class="desc">  Paid Loan/Advance </div>
</div>
</div>

<div class="dashboard-stat yellow col-sm-4">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($tbal);?> </div>
<div class="desc">  Remaining Loan/Advance </div>
</div>
</div>

</div>

<?php 
} 

?>