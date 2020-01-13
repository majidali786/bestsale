<?php 
$branch=array("","DUBIA HEAD OFFICE"); 
$party=array_column($data,"VNAME","VCODE");
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
?>


<h3>(<?= $date1?> <i class="icon-calendar theme-color"></i> <?= $date2?>) <button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="cashbook" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="cashbook" ><i class="icon-printer"></i> Excel</button>
</h3>

<table class="table table-striped table-bordered table-hover order-column" id="purchase-data">
<div class="note note-success margin-bottom-10">
<h3 class="margin-0"><b><i class="icon-user"></i> <?= $a." : ".$akey?></b></h3>
</div>
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>
<th style="text-align:center;">No</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Product</th>
<th style="text-align:center;">Unit</th>
<th style="text-align:center;">Qty</th>
<th style="text-align:center;">F.C Rate </th>
<th style="text-align:center;">F.C Amount </th>
<th style="text-align:center;">درهمRate</th>
<th style="text-align:center;">درهم Amount</th>

</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="4" width="50%"></th>
<th>Total AMOUNT</th>
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
<td ><?= $b['PNAME'];?></td>
<td ><?= $b['UNIT'];?></td>
<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['FRATE'],2);?></td>
<td class="th-right"><?= number_format($b['FAMOUNT'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>

</tr>
<?php
}
$qty+=$b['QTY'];
$wght+=$b['AMOUNT'];
$amount+=$b['FAMOUNT'];
$tqty+=$b['QTY'];
$twght+=$b['AMOUNT'];
$tamount+=$b['FAMOUNT'];	
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="4">Total</th>
<td class="th-right"></td>
<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>
<td class="th-right"><?= number_format($wght,2);?></td>
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
<h3 class="margin-0"><b><i class="icon-basket"></i> <?= $akey?></b></h3>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>
<th style="text-align:center;">No</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Party</th>
<th style="text-align:center;">Unit</th>

<th style="text-align:center;">Qty</th>
<th style="text-align:center;">F.C Rate </th>
<th style="text-align:center;">F.C Amount </th>
<th style="text-align:center;">درهمRate</th>
<th style="text-align:center;">درهم Amount</th>
</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="4" width="50%"></th>
<th>Total Weight</th>
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
<td ><?= $b['VNAME'];?></td>
<td ><?= $b['UNIT'];?></td>

<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['FRATE'],2);?></td>
<td class="th-right"><?= number_format($b['FAMOUNT'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>

</tr>
<?php
}
$qty+=$b['QTY'];
$wght+=$b['AMOUNT'];
$amount+=$b['FAMOUNT'];
$tqty+=$b['QTY'];
$twght+=$b['AMOUNT'];
$tamount+=$b['FAMOUNT'];	
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="4">Total</th>
<td class="th-right"></td>
<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>
<td class="th-right"><?= number_format($wght,2);?></td>
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
<h3 class="margin-0"><b><i class="icon-wallet"></i>Invoice # <?= $a?></b></h3>
</div>
<table class="table table-striped table-bordered table-hover order-column">
<?php 
if($rtype==2){
?>
<thead class="theme-bg">
<tr>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Party</th>
<th style="text-align:center;">Product</th>
<th style="text-align:center;">Unit</th>

<th style="text-align:center;">Qty</th>
<th style="text-align:center;">F.C Rate </th>
<th style="text-align:center;">F.C Amount </th>
<th style="text-align:center;">درهمRate</th>
<th style="text-align:center;">درهم Amount</th>
</tr>
</thead>
<?php 
}
else{
?>
<thead class="theme-bg">
<tr>
<th colspan="4" width="50%"></th>
<th>Total Weight</th>
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
<td ><?= $b['VNAME'];?></td>
<td ><?= $b['PNAME'];?></td>
<td ><?= $b['UNIT'];?></td>

<td class="th-right"><?= number_format($b['QTY'],2);?></td>
<td class="th-right"><?= number_format($b['FRATE'],2);?></td>
<td class="th-right"><?= number_format($b['FAMOUNT'],2);?></td>
<td class="th-right"><?= number_format($b['RATE'],2);?></td>
<td class="th-right"><?= number_format($b['AMOUNT'],2);?></td>
</tr>
<?php
}
$qty+=$b['QTY'];
$wght+=$b['AMOUNT'];
$amount+=$b['FAMOUNT'];
$tqty+=$b['QTY'];
$twght+=$b['AMOUNT'];
$tamount+=$b['FAMOUNT'];	
}
endforeach;	
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="4">Total</th>
<td class="th-right"></td>
<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"></td>
<td class="th-right"><?= number_format($amount,2);?></td>
<td class="th-right"><?= number_format($wght,2);?></td>
</tfoot>
</table>
<?php 
}
endforeach;	
}
?>
<div class="row" >

<div class="dashboard-stat green col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Pcs. <?= number_format($tqty);?> </div>
<div class="desc"> Total Qty </div>
</div>
</div>



<div class="dashboard-stat blue col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> F.C. <?= number_format($tamount);?> </div>
<div class="desc"> Total Amount </div>
</div>
</div>

<div class="dashboard-stat red col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> درهم. <?= number_format($twght);?> </div>
<div class="desc"> Total درهم </div>
</div>
</div>


</div>


<script>
$('#purchase-data').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered1 from _MAX_ total records)",
                    lengthMenu: "Show _MENU_",
                    search: "Search:",
                    zeroRecords: "No matching records found",
                    paginate: {
                        previous: "Prev",
                        next: "Next",
                        last: "Last",
                        first: "First"
                    }
                },
                bStateSave: false,
                lengthMenu: [
                    [6, 15, 20, -1],
                    [6, 15, 20, "All"]
                ],
                pageLength:-1,
                columnDefs: [{
                    targets: [0]
                }, {
                    searchable: !1,
                    targets: [0]
                }],
                order: [
                    [0, "asc"]
                ]
            });
</script>