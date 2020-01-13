<form class="form-horizontal main-form" role="form" onsubmit="return false;">
<div class="form-body">


<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['AD']))
{
if($voucherrights[0]['AD']==1){
?>
<div class="col-sm-2">
<button type="submit" class="btn green">Save</button>
<button type="reset" class="btn default">Reset</button>
</div>
<?php 
}
}
?>
<div class="col-sm-3">
<div class="note note-danger ">
<p class="block">UnPosted By : <b></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-warning ">
<p class="block">Posted By : <b></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-success">
<p class="block">Approved By : <b></b></p>
</div>
</div>
</div>

<div class="row">
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Department<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="department" id="department" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Department</option>
<?php 
if(count($department)){
foreach($department as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['DEPT']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Contractor<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="contractor" id="contractor" class="form-control select2 move-enter-up move-enter-4" data-position="4">
<option value="">Select Contractor</option>
<?php 
if(count($contractor)){
foreach($contractor as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ANAME']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>

</div>





<?php 
$this->load->view($loadRow);
?>


<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th style="width:40%">Product</th>
<th style="width:8%">Unit</th>
<th style="width:8%">Weight</th>
<th style="width:8%">Qty</th>
<th style="width:8%">Feet</th>
<th style="width:8%">Total Weight</th>
<th style="width:8%">Rate</th>
<th style="width:8%">Amount</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="3">Total</th>
<td class="theme-bg"><input type="text" name="twght" /></td>
<td class="theme-bg"><input type="text" name="tqty" /></td>
<td></td>
<td class="theme-bg"><input type="text" name="totwght" /></td>
<td></td>
<td class="theme-bg"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>

<?php 
$this->load->view($loadProRow);
?>

<div class="col-sm-12 data-prorows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th style="width:30%">Product</th>
<th style="width:8%">Unit</th>
<th style="width:8%">Coil</th>
<th style="width:8%">Weight</th>
<th style="width:8%">Qty</th>
<th style="width:8%">MM Wastage</th>
<th style="width:8%">Total Weight</th>
<th style="width:8%">Waste</th>
<th style="width:8%">Manual Waste</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="4">Total</th>
<td class="theme-bg"><input type="text" name="protwght" /></td>
<td class="theme-bg"><input type="text" name="protqty" /></td>
<td class="theme-bg"><input type="text" name="protmmwaste" /></td>
<td class="theme-bg"><input type="text" name="prototwght" /></td>
<td class="theme-bg"><input type="text" name="protwaste" /></td>
<td class="theme-bg"><input type="text" name="protmwaste" /></td>
</tr>
</tfoot>
</table>
</div>

</div>
</div>
</form>
<script>
<?php 
if(!empty($dataType)){
?>
reinitializeTable(1);
reinitializeProTable(1);
<?php 	
}
?>
</script>