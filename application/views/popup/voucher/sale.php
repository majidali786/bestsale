<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Sale Voucher : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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

</tr>
<tr>
<th><b>Party</b></th><td colspan="2"><?= $data1[0]['VCODE']." - ".$data1[0]['VNAME']?></td>
<th><b>Sales Account</b></th><td colspan="2"><?= $data1[0]['SCODE']." - ".$data1[0]['SNAME']?></td>
</tr>
<tr>
<th><b>Address</b></th><td colspan="2"><?= $data1[0]['ADDR']?></td>
<th style="width:20%;"><b>Book No.</b></th><td><?= $data1[0]['VNO']?></td>
</tr>

<tr>
<th><b>Remarks</b></th><td colspan="5"><?= $data1[0]['REMARKS']?></td>
</tr>
</table>
<table class="table table-bordered">
<tr>
<th>Sr#</th>
<th style="width:15%;text-align:center";>Product</th>
<th style="width:5%;text-align:center";>Unit</th>
<th style="width:8%;text-align:center";>Qty</th>
<th style="width:8%;text-align:center";>Rate درهم</th>
<th style="width:10%;text-align:center";>Amount درهم</th>

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

<td class="th-right"><?= number_format($row['QTY'],1)?></td>

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
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($tqty,1)?></td>
<td colspan="1"></td>
<td class="th-right"><?= number_format($tamount)?></td>
</tfoot>
</table>
<table class="table table-bordered">
<tr>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b>Received Amount</b></th>
</tr>
<tr>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($data1[0]['RAMOUNT'])?></td>

</tr>
<tr>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b>Total</b></th>
</tr>
<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>

<td class="th-right"><?= number_format($data1[0]['NET'])?></td>
</tr>
</table>
<?php 
}
?>
