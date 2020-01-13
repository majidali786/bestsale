<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Purchase Voucher : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<th style="width:20%;"><b>Book No</b></th><td><?= $data1[0]['VNO']?></td>
</tr>
<tr>
<th><b>Party</b></th><td colspan="2"><?= $data1[0]['VCODE']." - ".$data1[0]['VNAME']?></td>
<th><b></b></th><td colspan="2"><?= $data1[0]['PCODE']." - ".$data1[0]['PNAME']?></td>
</tr>
<tr>
<th><b>Address</b></th><td colspan="2"><?= $data1[0]['ADDR']?></td>
<th><b></b></th><td colspan="2"><?= $data1[0]['DPNAME']?></td>
</tr>
<tr>
<th style="width:20%;"><b></b></th><td><?= $data1[0]['GRN']?></td>
<th><b>Remarks</b></th><td colspan="3"><?= $data1[0]['REMARKS']?></td>
</tr>
</table>
<table class="table table-bordered">
<tr>
<th>Sr#</th>
<th style="text-align:center;width:25%";>Product Description</th>
<th style="text-align:center;width:10%";>Unit</th>
<th style="text-align:center;width:10%";>Qty</th>
<th style="text-align:center;width:10%";>F.C Rate</th>
<th style="text-align:center;width:15%";>F.C Amount</th>
<th style="text-align:center;width:10%";>درهم Rate</th>
<th style="text-align:center;width:15%";>درهم Amount</th>
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
<td><?= number_format($row['QTY'],1)?></td>
<td><?= $row['FRATE']?></td>
<td><?= number_format($row['FAMOUNT'],1)?></td>
<td><?= number_format($row['RATE'],1)?></td>
<td><?= number_format($row['AMOUNT'],1)?></td>
</tr>
<?php 
$rowNumber++;
$tqty+=$row['QTY'];
$tamount+=$row['AMOUNT'];
endforeach;
?>
<tfoot>
<th colspan="4">Total</th>
<td><?= number_format($tqty)?></td>
<td colspan="2"></td>
<td><?= number_format($tamount)?></td>
</tfoot>
</table>
<table class="table table-bordered">
<tr>
<th></th>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
<th><b></b></th>
</tr>
<tr>
<td></td>
<td><?= number_format($data1[0]['DISCOUNT'],1)?></td>
<td><?= number_format($data1[0]['FREIGHT'],1)?></td>
<td><?= number_format($data1[0]['LOADING'],1)?></td>
<td><?= number_format($data1[0]['OTHERS'],1)?></td>
<td><?= number_format($data1[0]['NET'],1)?></td>
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
<td><?= $data1[0]['BNO']?></td>
<td></td>
<td><?= $data1[0]['TRANSPORT']?></td>
<td><?= number_format($data1[0]['PBAL'])?></td>
<td><?= number_format($data1[0]['NET'])?></td>
<td><?= number_format($data1[0]['TBAL'])?></td>
</tr>
</table>
<?php 
}
?>
