<?php 
$branch=array("","DUBIA HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE");
$party=array_column($data,"ANAME","VCODE");
$party=array_unique($party);
asort($party);
$branches=array_column($data,"B_ID");
$branches=array_unique($branches);
sort($branches);
$product=array_column($data,"PNAME","PCODE");
$product=array_unique($product);
asort($product);
?>
<?php 
$tqty=$twght=$tfeet=$tamount=0;	
if($ortype==1){	
foreach($party as $a=>$akey){
$qty=$wght=$feet=$amount=0;		

$discount=$freight=$loading=$others=0;		
?>
<div class="note note-success margin-bottom-10">
<h3 class="margin-0"><b><i class="icon-user"></i> <?= $a." : ".$akey?></b></h3>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>
<th>No</th>
<th>Date</th>
<th>Bill.No</th>
<th>Product</th>
<th>Unit</th>
<th>Qty</th>
<th>Rate</th>
<th>Amount</th>
<th>Vat %</th>
<th>Vat.Amount</th>
<th>Net</th>

<th>Branch</th>
</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="8" width="50%"></th>

<th>Total Qty</th>
<th></th>
<th>Total Amount</th>
<th></th>
</tr>
</thead>
<?php 	
}
?>
<tbody>
<?php 
foreach($data as $b):
if($b['VCODE']==$a)
{
if($rtype==2){	
?>
<tr>
<td><?= $b['NO'];?></td>
<td ><?= date("d/m/Y",strtotime($b['VDATE']))?></td>
<td><?= $b['VNO'];?></td>
<td ><?= $b['PNAME'];?></td>
<td ><?= $b['UNIT'];?></td>
<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>
<td class="th-right"><?= number_format($b['GSTPER'],2);?></td>
<td class="th-right"><?= number_format($b['GST'],2);?></td>
<td class="th-right"><?= number_format($b['NET'],2);?></td>
<td><?= $branch[$b['B_ID']];?></td>
</tr>
<?php
}
$qty+=$b['QTY'];
$amount+=$b['AMOUNT'];
$tqty+=$b['QTY'];
$twght+=$b['GSTPER'];
$tamount+=$b['NET'];	
$discount+=$b['DISCOUNT'];		
$others+=$b['GST'];	
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="1">Total</th>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($others,2);?></td>
<td class="th-right"><?= number_format($tamount,2);?></td>

</tfoot>
</table>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Total Discount</th>
<th>Total Vat</th>
<th>AED Net</th>
</tr>
<tr>
<td class="th-right"><?= number_format($discount,2);?></td>
<td class="th-right"><?= number_format($others,2);?></td>
<td class="th-right"><?= number_format($tamount,2);?></td>
</tr>
</thead>
</table>
<?php 
}	
}
$tqty=$twght=$tfeet=$tamount=0;	
 if($ortype==2){
foreach($product as $a=>$akey){
$qty=$wght=$amount=0;	

$discount=$freight=$loading=$others=0;	
?>
<div class="note note-success margin-bottom-10">
<h3 class="margin-0"><b><i class="icon-basket"></i> <?= $akey?></b></h3>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>
<th>No</th>
<th>Date</th>
<th>Bill.No</th>
<th>Party</th>
<th>Unit</th>
<th>Qty</th>
<th>Rate</th>
<th>Amount</th>
<th>Vat %</th>
<th>Vat.Amount</th>
<th>Net</th>
<th>Branch</th>
</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="4" width="50%"></th>
<th></th>
<th>Total Qty</th>
<th></th>
<th>Total Amount</th>
<th></th>
</tr>
</thead>
<?php 	
}
?>
<tbody>
<?php 
foreach($data as $b):
if($b['PCODE']==$a)
{
if($rtype==2){
?>
<tr>
<td><?= $b['NO'];?></td>
<td ><?= date("d/m/Y",strtotime($b['VDATE']))?></td>
<td ><?= $b['VNO'];?></td>
<td ><?= $b['ANAME'];?></td>
<td ><?= $b['UNIT'];?></td>
<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>

<td class="th-right"><?= number_format($b['GSTPER'],2);?></td>
<td class="th-right"><?= number_format($b['GST'],2);?></td>
<td class="th-right"><?= number_format($b['NET'],2);?></td>

<td><?= $branch[$b['B_ID']];?></td>
</tr>
<?php
}
$qty+=$b['QTY'];
$amount+=$b['AMOUNT'];
$tqty+=$b['QTY'];
$twght+=$b['GSTPER'];
$tamount+=$b['NET'];	
$discount+=$b['DISCOUNT'];		
$others+=$b['GST'];		
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="1">Total</th>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($others,2);?></td>
<td class="th-right"><?= number_format($tamount,2);?></td>
<td class="th-right"></td>
</tfoot>
</table>
<?php 
}	
}
else if($ortype==3){
foreach($branches as $c):
$invoices = array_filter($data, function ($var) use ($c) {
    return ($var['B_ID'] == $c);
});
$invoice=array_column($invoices,"NO");
$invoice=array_unique($invoice);
asort($invoice);
?>
<div class="note note-danger margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-home"></i> <?= $branch[$c];?></b></h2>
</div>
<?php 
$tqty=$twght=$tfeet=$tamount=0;		
foreach($invoice as $a){
$qty=$wght=$feet=$amount=0;		
$discount=$freight=$loading=$others=0;	
?>
<div class="note note-success margin-bottom-10">
<h3 class="margin-0"><b><i class="icon-wallet"></i>Invoice # <?= $a?></b></h3>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>
<th>Date</th>
<th>Party</th>
<th>Bill.No</th>
<th>Product</th>
<th>Unit</th>
<th>Qty</th>
<th>Rate</th>
<th>Amount</th>
<th>Vat %</th>
<th>Vat.Amount</th>
<th>Net</th>
</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="4" width="50%"></th>
<th></th>
<th>Total Qty</th>
<th></th>
<th>Total Amount</th>
</tr>
</thead>
<?php 	
}
?>
<tbody>
<?php 
foreach($invoices as $b):
if($b['NO']==$a)
{
if($rtype==2){	
?>
<tr>
<td ><?= date("d/m/Y",strtotime($b['VDATE']))?></td>
<td ><?= $b['ANAME'];?></td>
<td ><?= $b['VNO'];?></td>
<td ><?= $b['PNAME'];?></td>
<td ><?= $b['UNIT'];?></td>
<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>
<td class="th-right"><?= number_format($b['GSTPER'],2);?></td>
<td class="th-right"><?= number_format($b['GST'],2);?></td>
<td class="th-right"><?= number_format($b['NET'],2);?></td>

</tr>
<?php
}
$qty+=$b['QTY'];
$amount+=$b['AMOUNT'];
$tqty+=$b['QTY'];
$twght+=$b['GSTPER'];
 $tamount+=$b['NET'];	
	
$discount+=$b['DISCOUNT'];		
$others+=$b['GST'];		

}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="1">Total</th>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($tamount,2);?></td>

</tfoot>
</table>
<table class="table table-striped table-bordered table-hover order-column">
<thead class="theme-bg">
<tr>
<th>Total Discount</th>
<th>Total Frieght</th>
<th>Total Loading</th>
<th>Total Others</th>
<th>Net</th>
</tr>
<tr>
<td class="th-right"><?= number_format($discount,2);?></td>
<td class="th-right"><?= number_format($freight,2);?></td>
<td class="th-right"><?= number_format($loading,2);?></td>
<td class="th-right"><?= number_format($others,2);?></td>
<td class="th-right"><?= number_format($amount-$discount+$freight+$loading+$others,2);?></td>
</tr>
</thead>
</table>

<?php 
}
endforeach;	
}
?>


<div class="dashboard-stat red col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>

</div>

<div class="dashboard-stat green col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Pcs. <?= number_format($tqty);?> </div>
<div class="desc"> Total Qty </div>
</div>
</div>
<div class="dashboard-stat purple col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
 
</div>

<div class="dashboard-stat blue col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> AED. <?= number_format($tamount);?> </div>
<div class="desc"> Total Amount </div>
</div>
</div>


</div>