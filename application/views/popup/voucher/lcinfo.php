<?php 
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> LC Information : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<th style="width:20%;"><b>Lc No.</b></th><td><?= $data1[0]['LCNO']?></td>
</tr>
<tr>
<th><b>Party</b></th><td colspan="2"><?= $data1[0]['VCODE']." - ".$data1[0]['VNAME']?></td>
<th><b>LC Account</b></th><td colspan="2"><?= $data1[0]['LCCODE']." - ".$data1[0]['LCNAME']?></td>
</tr>
<tr>
<th style="width:20%;"><b>LC Code</b></th><td><?= $data1[0]['LCODE']?></td>
<th style="width:20%;"><b>LC Date</b></th><td><?= $data1[0]['LCDATE']?></td>
<th style="width:20%;"><b>LC Type</b></th><td><?= $data1[0]['LCTYPE']?></td>
</tr>
<tr>
<th style="width:20%;"><b>Indentor</b></th><td><?= $data1[0]['INDENTOR']?></td>
<th style="width:20%;"><b>Bond</b></th><td><?= $data1[0]['LCBOND']?></td>
<th style="width:20%;"><b>Bank</b></th><td><?= $data1[0]['BNAME']?></td>
</tr>
<tr>
<th style="width:20%;"><b>ETD</b></th><td><?= $data1[0]['ETD']?></td>
<th style="width:20%;"><b>ETA</b></th><td><?= $data1[0]['ETA']?></td>
<th style="width:20%;"><b>Maturity Date</b></th><td><?= $data1[0]['MDATE']?></td>
</tr>
<tr>
<th style="width:20%;"><b>Tracking No.</b></th><td><?= $data1[0]['TRACKING']?></td>
<th style="width:20%;"><b>Destination</b></th><td><?= $data1[0]['DESTINATION']?></td>
<th style="width:20%;"><b>Origin</b></th><td><?= $data1[0]['ORIGIN']?></td>
</tr>
<tr>
<th style="width:20%;"><b>Currency</b></th><td><?= $data1[0]['CURRENCY']?></td>
<th style="width:20%;"><b>Conversion Rate</b></th><td><?= $data1[0]['CONVERSION']?></td>
<th style="width:20%;"><b></b></th><td></td>
</tr>

</table>
<table class="table table-bordered">
<tr>
<th>#</th>
<th style="width:20%";>Product</th>
<th style="width:10%";>Unit</th>
<th style="width:10%";>Coil</th>
<th style="width:10%";>Qty(MT)</th>
<th style="width:10%";>Weight(MT)</th>
<th style="width:10%";>FC Rate</th>
<th style="width:10%";>PKR Rate</th>
<th style="width:10%";>FC Amount</th>
<th style="width:10%";>PKR Amount</th>
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
<td><?= $row['COIL']?></td>
<td class="th-right"><?= number_format($row['QTY'],1)?></td>
<td class="th-right"><?= number_format($row['WEIGHT'],1)?></td>
<td class="th-right"><?= number_format($row['FCRATE'],1)?></td>
<td class="th-right"><?= number_format($row['RATE'],1)?></td>
<td class="th-right"><?= number_format($row['FCAMOUNT'])?></td>
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
<td colspan="3"></td>
<td class="th-right"><?= number_format($tamount)?></td>
</tfoot>
</table>
<?php 
}
?>
