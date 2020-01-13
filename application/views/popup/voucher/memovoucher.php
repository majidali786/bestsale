<?php 
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Memo Voucher : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<table class="table table-bordered">
<tr>
<th style="width:20%;"><b>Voucher No.</b></th><td><?= $data1[0]['NO']?></td>
<th style="width:20%;"><b>Voucher Date</b></th><td><?= date("d/m/Y",strtotime($data1[0]['VDATE']))?></td>
<th style="width:20%;"><b>Type</b></th><td><?= $data1[0]['TYPE']?></td>
</tr>
<tr>
<th><b>Debit Account</b></th><td colspan="2"><?= $data1[0]['DACODE']." - ".$data1[0]['DANAME']?></td>
<th><b>Credit Account</b></th><td colspan="2"><?= $data1[0]['CACODE']." - ".$data1[0]['CANAME']?></td>
</tr>
<tr>
<th><b>Department</b></th><td colspan="2"><?= $data1[0]['DEPARTMENT']?></td>
<th><b>Remarks</b></th><td colspan="2"><?= $data1[0]['REMARKS']?></td>
</tr>
</table>
<?php 
if($data1[0]['TYPE']==2){
?>
<table class="table table-bordered">
<tr>
<th>#</th>
<th style="width:40%";>Product</th>
<th style="width:10%";>Unit</th>
<th style="width:10%";>Weight</th>
<th style="width:10%";>Qty</th>
<th style="width:10%";>Feet</th>
<th style="width:10%";>Rate</th>
<th style="width:10%";>Amount</th>
</tr>
<?php
$rowNumber=1;
$tqty=$tamount=0; 
foreach($data2 as $row):
?>
<tr>
<td><?= $rowNumber?></td>
<td><?= $row['PNAME']?></td>
<td><?= $row['UNIT']?></td>
<td class="th-right"><?= number_format($row['WEIGHT'],1)?></td>
<td class="th-right"><?= number_format($row['QTY'],1)?></td>
<td class="th-right"><?= number_format($row['FEET'],1)?></td>
<td class="th-right"><?= number_format($row['RATE'],1)?></td>
<td class="th-right"><?= number_format($row['AMOUNT'])?></td>
</tr>
<?php 
$rowNumber++;
$tqty+=$row['QTY'];
$tamount+=$row['AMOUNT'];
endforeach;
?>
<tfoot>
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($tqty,1)?></td>
<td colspan="2"></td>
<td class="th-right"><?= number_format($tamount)?></td>
</tfoot>
</table>
<?php 
}
else if($data1[0]['TYPE']==1){
?>
<table class="table table-bordered">
<tr>
<th>#</th>
<th style="width:40%";>Service</th>
<th style="width:40%";>Description</th>
<th style="width:10%";>Amount</th>
</tr>
<?php
$rowNumber=1;
$tqty=$tamount=0; 
foreach($data2 as $row):
?>
<tr>
<td><?= $rowNumber?></td>
<td><?= $row['PNAME']?></td>
<td><?= $row['DESCR']?></td>
<td class="th-right"><?= number_format($row['AMOUNT'])?></td>
</tr>
<?php 
$rowNumber++;
$tamount+=$row['AMOUNT'];
endforeach;
?>
<tfoot>
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($tamount)?></td>
</tfoot>
</table>
<?php 
}
}
?>
