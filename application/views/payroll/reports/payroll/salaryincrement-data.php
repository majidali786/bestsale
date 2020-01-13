<?php 
$employee=array_column($data,"NAME");
$employee=array_unique($employee);
$employee=array_values($employee);
foreach($employee as $e){
$employeeData=array();
foreach($data as $a){
if($a['NAME']==$e){
array_push($employeeData,$a);	
}
}
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-user"></i><?= $e?> </b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data">
<thead class="theme-bg">
<tr>
<th>No</th>
<th>Date</th>
<th>Current Salary</th>
<th>Incremented Salary</th>
<th>Increment</th>
</tr>
</thead>
<tbody>
<?php
$bal=0;
foreach($employeeData as $b){
$bal-=$b['CSALARY'];	
$bal+=$b['ISALARY'];	
?>
<tr>
<td><?= $b['NO'];?></td>
<td><?= date("d/m/Y",strtotime($b['VDATE']));?></td>
<td class="th-right"><?= number_format($b['CSALARY']);?></td>
<td class="th-right"><?= number_format($b['ISALARY']);?></td>
<td class="th-right"><?= number_format($b['ISALARY']-$b['CSALARY']);?></td>
</tr>
<?php
}
?>
</tbody>
<tfoot>
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($bal);?></td>
</tfoot>
</table>
<?php 
} 
?>