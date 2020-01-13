<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE");
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Loan Advance Voucher : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<th style="width:10%;"><b>Voucher No.</b></th><td><?= $data1[0]['NO']?></td>
<th style="width:10%;"><b>Voucher Date</b></th><td><?= date("d/m/Y",strtotime($data1[0]['VDATE']))?></td>
<th style="width:20%;"><b>From Account</b></th><td><?= $data1[0]['ACODE']."-".$data1[0]['ANAME']?></td>
</tr>
<tr>
<th><b>Type</b></th><td><?= $data1[0]['TYPE']?></td>
<th><b>Employee</b></th><td colspan="3"><?= $data1[0]['ECODE']."-".$data1[0]['EMPLOYEE']?></td>
</tr>
<tr>
<th><b>Loan/Advance Amount</b></th><td><?= $data1[0]['LOAN']?></td>
<th><b>No. Of Installments</b></th><td ><?= $data1[0]['NINSTALL']."-".$data1[0]['EMPLOYEE']?></td>
<th><b>Per Month Installments</b></th><td ><?= $data1[0]['PMINSTALL']."-".$data1[0]['EMPLOYEE']?></td>
</tr>
</table>
<?php 
}
?>
