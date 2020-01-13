<?php 
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
if(!empty($data1)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> Book Issue Note : <?= $branch[$data1[0]['B_ID']]?></b></h2>
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
<th style="width:20%;"><b>Book No</b></th><td><?= $data1[0]['BNO']?></td>
</tr>
<tr>
<th><b>Starting No</b></th><td><?= $data1[0]['STARTAT']?></td>
<th><b>Ending No</b></th><td><?= $data1[0]['ENDAT']?></td>
<th><b>Status</b></th><td><?= $data1[0]['STATUS']?></td>
</tr>
</table>
<?php 
}
?>
