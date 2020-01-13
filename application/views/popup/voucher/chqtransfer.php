<?php 
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Cheque Transfer Voucher : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<th style="width:10%;"><b>No.</b></th><td style="width:20%;"><?= $data1[0]['NO']?></td>
<th style="width:10%;"><b>Date</b></th><td style="width:20%;"><?= date("d/m/Y",strtotime($data1[0]['VDATE']))?></td>
<th style="width:10%;"><b style="width:30%;">From Account</b></th><td><?= $data1[0]['FACODE']." - ".$data1[0]['FANAME']?></td>
</tr>
<tr>
<th style="width:10%;"><b>To Account</b></th><td colspan="5"><?= $data1[0]['TACODE']." - ".$data1[0]['TANAME']?></td>
</tr>
</table>
<table class="table table-bordered">
<tr>
<th>#</th>
<th>Party/Account</th>
<th>Bank</th>
<th>Description</th>
<th>Cheque No.</th>
<th>Cheque Date</th>
<th>Amount</th>
</tr>
<?php
$rowNumber=1;
$tamount=0; 
foreach($data1 as $row):
?>
<tr>
<td><?= $rowNumber?></td>
<td><?= $row['ACODE']."-".$row['ANAME']?></td>
<td><?= $row['BNAME']?></td>
<td><?= $row['DESCR']?></td>
<td><?= $row['CHQNO']?></td>
<td><?= $row['CHQDATE']?></td>
<td><?= number_format($row['DEBIT'])?></td>
</tr>
<?php 
$rowNumber++;
$tamount+=$row['DEBIT'];
endforeach;
?>
<tfoot>
<th colspan="6">Total</th>
<td><?= number_format($tamount)?></td>
</tfoot>

<?php 
}
?>
