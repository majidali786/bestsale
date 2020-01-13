<?php 
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Discount Voucher : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<th style="width:30%;"><b>No.</b></th><td style="width:20%;"><?= $data1[0]['NO']?></td>
<th style="width:30%;"><b>Date</b></th><td style="width:20%;"><?= date("d/m/Y",strtotime($data1[0]['VDATE']))?></td>
</tr>
</table>
<table class="table table-bordered">
<tr>
<th>#</th>
<th>Party/Account</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
</tr>
<?php
$rowNumber=1;
$tdebit=$tcredit=0; 
foreach($data1 as $row):
?>
<tr>
<td><?= $rowNumber?></td>
<td><?= $row['ACODE']."-".$row['ANAME']?></td>
<td><?= $row['DESCR']?></td>
<td><?= number_format($row['DEBIT'])?></td>
<td><?= number_format($row['CREDIT'])?></td>
</tr>
<?php 
$rowNumber++;
$tdebit+=$row['DEBIT'];
$tcredit+=$row['CREDIT'];
endforeach;
?>
<tfoot>
<th colspan="3">Total</th>
<td><?= number_format($tdebit)?></td>
<td><?= number_format($tcredit)?></td>
</tfoot>

<?php 
}
?>
