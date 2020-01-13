<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE");
if(!empty($data1)){	
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Salary Sheet Daily : <?= $branch[$data1[0]['B_ID']]?></b></h2>
</div>
<div class="row" style="padding-bottom:10px;">
<div class="col-sm-4">
<div class="note note-danger ">
<p class="block">UnPosted By : <b><?php if(!empty($unposted)){ echo $unposted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-4">
<div class="note note-warning ">
<p class="block">Posted By : <b><?php if(!empty($posted)){ echo $posted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-4">
<div class="note note-success">
<p class="block">Approved By : <b><?php if(!empty($approved)){ echo $approved[0]['U_ID']; }?></b></p>
</div>
</div>
</div>
<?php 
$date1=$data1[0]['VDATE'];
$date2=date('Y-m-d', strtotime('+6 day', strtotime($data1[0]['VDATE'])));
?>
<div class="note note-warning margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-trophy"></i> Emplopyee Salary Sheet Of Days </br> From Date<i class="icon-calendar"></i> <?= date("D d/m/Y",strtotime($date1))?> To Date<i class="icon-calendar"></i> <?= date("D d/m/Y",strtotime($date2))?></b></h3>
</div>
<table class="table table-bordered table-condensed table-responsive salary-sheet">
<thead class="theme-bg">
<tr>
<th rowspan="3">Sr#</th>
<th colspan="3">Employee Information</th>
<th>Overtime</th>
<th colspan="3">Deductions</th>
<th colspan="2">Action</th>
</tr>
<tr>
<th colspan="2" rowspan="2">Name</th>
<th>Pay/Month</th>
<th>Hours</th>
<th>Total L.Term Loan</th>
<th>Total S.Term Loan</th>
<th>Total Advance</th>
<th style="width:10%;">Gross</th>
<th rowspan="2" style="width:10%;">Total Pay</th>
</tr>
<tr>
<th>W/Days</th>
<th>Amount</th>
<th>L.Term Loan Ded.</th>
<th>S.Term Loan Ded.</th>
<th>Advance Ded.</th>
<th>Net Pay</th>
</tr>
</thead>
<tbody>
<?php
$bg=array("success","danger");
$sr=1; 
$ohours=$oamount=$tltloan=$tstloan=$tadvance=$ltloan=$stloan=$advance=$gross=$net=$total=0;
foreach($data1 as $row){
?>
<tr class="<?= $bg[$sr%2]?>">
<th rowspan="2"><?= $sr ?></th>
<th colspan="2" rowspan="2"><?= $row['EMPLOYEE']?></th>
<td class="th-right"><?= lakhseparater($row['BASIC'])?></td>
<td class="th-right"><?= lakhseparater($row['OHOURS'])?></td>
<td class="th-right"><?= lakhseparater($row['TLTLOAN'])?></td>
<td class="th-right"><?= lakhseparater($row['TSTLOAN'])?></td>
<td class="th-right"><?= lakhseparater($row['TADVANCE'])?></td>
<td style="width:10%;" class="th-right"><?= lakhseparater($row['GROSS'])?></td>
<td rowspan="2" class="th-right" style="width:10%;"><?= lakhseparater($row['TOTAL'])?></td>
</tr>
<tr class="<?= $bg[$sr%2]?>">
<td class="th-right"><?= lakhseparater($row['WDAYS'])?></td>
<td class="th-right"><?= lakhseparater($row['OAMOUNT'])?></td>
<td class="th-right"><?= lakhseparater($row['LTLOAN'])?></td>
<td class="th-right"><?= lakhseparater($row['STLOAN'])?></td>
<td class="th-right"><?= lakhseparater($row['ADVANCE'])?></td>
<td class="th-right"><?= lakhseparater($row['NET'])?></td>
</tr>
<?php
$sr++;
$ohours+=$row['OHOURS'];	
$oamount+=$row['OAMOUNT'];	
$tltloan+=$row['TLTLOAN'];	
$tstloan+=$row['TSTLOAN'];	
$tadvance+=$row['TADVANCE'];	
$ltloan+=$row['LTLOAN'];	
$stloan+=$row['STLOAN'];	
$advance+=$row['ADVANCE'];	
$gross+=$row['GROSS'];	
$net+=$row['NET'];	
$total+=$row['TOTAL'];	 	
}
?>
</tbody>
</table>
<table class="table table-bordered table-condensed table-responsive">
<tbody>
<tr class="theme-bg">
<th>OverTime Hours</th>
<th>Total L.Term Loan</th>
<th>Total S.Term Loan</th>
<th>Total Advance</th>
<th>Total Gross</th>
<th rowspan="2" style="vertical-align:middle">Total Pay</th>
</tr>
<tr>
<td class="th-right"><?= lakhseparater($ohours);?></td>
<td class="th-right"><?= lakhseparater($tltloan);?></td>
<td class="th-right"><?= lakhseparater($tstloan);?></td>
<td class="th-right"><?= lakhseparater($tadvance);?></td>
<td class="th-right"><?= lakhseparater($gross);?></td>
</tr>
<tr class="theme-bg">
<th>Total Overtime Amount</th>
<th>Total Deduction L.Term</th>
<th>Total Deduction S.Term</th>
<th>Total Deduction Advance</th>
<th>Total Net Pay</th>
<td class="th-right" rowspan="2" style="vertical-align:middle"><?= lakhseparater($total);?></td>
</tr>
<tr>
<td class="th-right"><?= lakhseparater($oamount);?></td>
<td class="th-right"><?= lakhseparater($ltloan);?></td>
<td class="th-right"><?= lakhseparater($stloan);?></td>
<td class="th-right"><?= lakhseparater($advance);?></td>
<td class="th-right"><?= lakhseparater($net);?></td>
</tr>
</tbody>
</table>

<?php 
}
?>
