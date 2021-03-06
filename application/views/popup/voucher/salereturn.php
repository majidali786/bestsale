<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE");
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Sale Return Voucher : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<th style="width:20%;"><b>Sale Return Type</b></th><td><?= $data1[0]['STNAME']?></td>
</tr>
<tr>
<th><b>Party</b></th><td colspan="2"><?= $data1[0]['VCODE']." - ".$data1[0]['VNAME']?></td>
<th><b>Sales Account</b></th><td colspan="2"><?= $data1[0]['SCODE']." - ".$data1[0]['SNAME']?></td>
</tr>
<tr>
<th><b>Address</b></th><td colspan="2"><?= $data1[0]['ADDR']?></td>
<th><b>Department</b></th><td colspan="2"><?= $data1[0]['DPNAME']?></td>
</tr>
<tr>
<th style="width:20%;"><b>Book No.</b></th><td><?= $data1[0]['VNO']?></td>
<th style="width:20%;"><b>Sale Order</b></th><td><?= $data1[0]['SONO']?></td>
<th style="width:20%;"><b>Dc No.</b></th><td><?= $data1[0]['DCNO']?></td>
</tr>
<tr>
<th><b>Remarks</b></th><td colspan="5"><?= $data1[0]['REMARKS']?></td>
</tr>
</table>
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
<td><?= number_format($row['WEIGHT'],1)?></td>
<td><?= number_format($row['QTY'],1)?></td>
<td><?= number_format($row['FEET'],1)?></td>
<td><?= number_format($row['RATE'],1)?></td>
<td><?= number_format($row['AMOUNT'])?></td>
</tr>
<?php 
$rowNumber++;
$tqty+=$row['QTY'];
$tamount+=$row['AMOUNT'];
endforeach;
?>
<tfoot>
<th colspan="4">Total</th>
<td><?= number_format($tqty,1)?></td>
<td colspan="2"></td>
<td><?= number_format($tamount)?></td>
</tfoot>
</table>
<table class="table table-bordered">
<tr>
<th></th>
<th><b>Discount</b></th>
<th><b>Freight</b></th>
<th><b>Loading</b></th>
<th><b>Others</b></th>
<th><b>Net</b></th>
</tr>
<tr>
<td></td>
<td><?= number_format($data1[0]['DISCOUNT'])?></td>
<td><?= number_format($data1[0]['FREIGHT'])?></td>
<td><?= number_format($data1[0]['LOADING'])?></td>
<td><?= number_format($data1[0]['OTHERS'])?></td>
<td><?= number_format($data1[0]['NET'])?></td>
</tr>
<tr>
<th><b>Bilty No</b></th>
<th><b>Bilty Date</b></th>
<th><b>Ship Via</b></th>
<th><b>Previous</b></th>
<th><b>Current</b></th>
<th><b>Total</b></th>
</tr>
<tr>
<td><?= $data1[0]['BNO']?></td>
<td><?= date("d/m/Y",strtotime($data1[0]['BDATE']))?></td>
<td><?= $data1[0]['TRANSPORT']?></td>
<td><?= number_format($data1[0]['PBAL'])?></td>
<td><?= number_format($data1[0]['NET'])?></td>
<td><?= number_format($data1[0]['TBAL'])?></td>
</tr>
</table>
<?php 
}
?>
