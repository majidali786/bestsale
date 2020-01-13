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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Purchase Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="paccount" id="paccount" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Purchase Account</option>
<?php 
if(count($account)){
foreach($account as $g){
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
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC. No<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="lcno" id="lcno"  data-through-ajax="address-address,balance-previous" class="form-control select2 move-enter-up move-enter-4" data-position="4">
<option value="">Select LC. No</option>
<?php 
if(!empty($lcno)){
foreach($lcno as $g){
?>
<option value="<?= $g['LCNO'];?>"><?= $g['LCNO']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
</div>


</div>

<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> GRN No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up  move-enter-5" data-position="5" name="grno" placeholder="GRN No">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> GRN Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-6" data-position="6" input-mask-date name="grndate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-8">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-7" data-position="7" name="remarks" placeholder="Remarks">
</div>
</div>
</div>

</div>

<div load-lcinfo><div>


</div>
</div>
</form>
<script>
<?php 
if(!empty($dataType)){
?>
reinitializeTable(1);
<?php 
if(!empty($bissueError)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $bissueError?>",buttons:{close:{label:'Ok',className:"red",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
<?php 	
}
?>	
<?php 	
}
?>
</script>