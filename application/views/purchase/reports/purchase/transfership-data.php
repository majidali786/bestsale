<h3>(<?= $date1?> <i class="icon-calendar theme-color"></i> <?= $date2?>) <button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="chinatransfer" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="chinatransfer" ><i class="icon-printer"></i> Excel</button>
</h3>
<?php 
$branch=array("","HEAD OFFICE"); 
$party=array_column($data,"VNAME","VCODE");
$party=array_unique($party);
asort($party);
$branches=array_column($data,"B_ID");
$branches=array_unique($branches);
sort($branches);
$product=array_column($data,"NAME","ID");
$product=array_unique($product);
asort($product);

$cargo=array_column($data,"CARGO","CID");
$cargo=array_unique($cargo);
asort($cargo);
?>
<?php 
$tqty=$twght=$tfeet=$tamount=0;	
if($ortype==1){	
foreach($party as $a=>$akey){
$qty=$wght=$feet=$amount=0;		
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
<th style="text-align:center">No</th>
<th style="text-align:center">Date</th>
<th style="text-align:center">Order #.</th>
<th style="text-align:center">Cargo</th>
<th style="text-align:center">Design / Style</th>
<th style="text-align:center">Image</th>
<th style="text-align:center">Color</th>
<th style="text-align:center">Qty</th>
<th style="text-align:center">Rate</th>
<th style="text-align:center">Amount</th>
<th style="text-align:center">Pen.Days</th>

</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="6" width="50%"></th>

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
<td ><?= $b['PONO'];?></td>
<td ><?= $b['CARGO'];?></td>
<td ><?= $b['NAME'];?></td>
<td> <img src="<?= base_url("product/category/thumb_".$b['IMG']);?>" /></td>
<td class="th-right"><?= $b['UNIT'];?></td>

<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>
<td style="text-align:center"><?= $b['PDAYS']?></td>
</tr>
<?php
}
$qty+=$b['QTY'];
$amount+=$b['AMOUNT'];
$tqty+=$b['QTY'];
$tamount+=$b['AMOUNT'];	
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="7">Total</th>

<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>

</tfoot>
</table>
<?php 
}	
}
else if($ortype==2){
foreach($product as $a=>$akey){
$qty=$wght=$amount=0;		
?>
<div class="note note-success margin-bottom-10">
<h3 class="margin-0"><b><i class="icon-basket"></i> <?= $akey?><b>
<i class=""></i></h3>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>

<th style="text-align:center">No</th>
<th style="text-align:center">Date</th>
<th style="text-align:center">Order #.</th>
<th style="text-align:center">Cargo</th>
<th style="text-align:center">Party</th>
<th style="text-align:center">image</th>
<th style="text-align:center">Color</th>
<th style="text-align:center">Qty</th>
<th style="text-align:center">Rate</th>
<th style="text-align:center">Amount</th>


</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="6" width="50%"></th>
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
<td ><?= $b['PONO'];?></td>
<td ><?= $b['CARGO'];?></td>
<td ><?= $b['VNAME'];?></td>
<td> <img src="<?= base_url("product/category/thumb_".$b['IMG']);?>" /></td>
<td class="th-right"><?= $b['UNIT'];?></td>
<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>
<td style="text-align:center"><?= $b['PDAYS']?></td>
</tr>
<?php
}
$qty+=$b['QTY'];

$amount+=$b['AMOUNT'];
$tqty+=$b['QTY'];
$tamount+=$b['AMOUNT'];	
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="7">Total</th>

<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>

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
foreach($invoice as $a){

$qty=$wght=$amount=0;		
?>
<div class="note note-success margin-bottom-10">
<h3 class="margin-0"><b><i class="icon-wallet"></i>Transfer # <?= $a?> </b></h3>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>


<th style="text-align:center">Date</th>
<th style="text-align:center">Cargo</th>
<th style="text-align:center">Design</th>
<th style="text-align:center">Image</th>
<th style="text-align:center">Color</th>
<th style="text-align:center">Qty</th>
<th style="text-align:center">Rate</th>
<th style="text-align:center">Amount</th>

</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="5" width="50%"></th>

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
<td ><?= $b['CARGO'];?></td>
<td ><?= $b['NAME'];?></td>
<td> <img src="<?= base_url("product/category/thumb_".$b['IMG']);?>" /></td>
<td ><?= $b['UNIT'];?></td>
<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>
</tr>
<?php
}
$qty+=$b['QTY'];

$amount+=$b['AMOUNT'];
$tqty+=$b['QTY'];

$tamount+=$b['AMOUNT'];	
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="5">Total</th>

<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>
</tfoot>
</table>
<?php 
}
endforeach;	
}
?>
<div class="row" style="">



<div class="dashboard-stat green col-sm-6">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Pcs. <?= number_format($tqty);?> </div>
<div class="desc"> Total Qty </div>
</div>
</div>


<div class="dashboard-stat blue col-sm-6">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($tamount);?> </div>
<div class="desc"> Total Amount </div>
</div>
</div>


</div>


