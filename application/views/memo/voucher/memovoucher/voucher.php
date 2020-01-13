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
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Debit Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="dacode" readonly placeholder="Party Code">
<select name="daname" id="daname" change-assign-value="dacode" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Debit Account</option>
<optgroup label="Accounts">
<?php 
if(count($account)){
foreach($account as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ACODE']."-".$g['ANAME']; ?></option>
<?php
}
}
?>
</optgroup>
</select>

</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Credit Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" class="form-control" name="cacode" readonly placeholder="Party Code">
<select name="caname" id="caname" change-assign-value="cacode"  class="form-control select2 move-enter-up move-enter-4" data-position="4">
<option value="">Select Credit Account</option>
<optgroup label="Accounts">
<?php 
if(count($account)){
foreach($account as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ACODE']."-".$g['ANAME']; ?></option>
<?php
}
}
?>
</optgroup>
</select>

</div>
</div>
</div>
</div>

<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Type<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="type" id="type"  class="form-control select2 move-enter-up move-enter-5" data-position="5">
<option value="">Select Type</option>
<option value="1">Services</option>
<option value="2">Product</option>
</select>

</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Department</label>
<div class="col-md-12 show-error">
<select name="department" id="department" class="form-control select2 move-enter-up move-enter-6" data-position="6">
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
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Book No. <?php if($voucherrights[0]['APPROVED']==1){ ?> <a href="javascript:;" class="bookno-closed">(Closed)</a> <?php  }?></label>
<div class="col-md-8 show-error  padding-left-yes">
<input type="text" class="form-control move-enter-up move-enter-8" data-position="8" <?php if($voucherrights[0]['APPROVED']!=1){ echo "readonly"; } ?> name="vno" value="<?php if(!empty($maxBissue)){
echo $maxBissue;	
}?>"  placeholder="Book No.">
</div>
<div class="col-md-4 padding-0">
<button type="button" class="btn green clear-bno"><i class="icon-close"></i></button> 
</div>
</div>
</div>
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-7" data-position="7" name="remarks"  placeholder="Remarks">
</div>
</div>
</div>


</div>

<div load-by-type >

</div>

</div>
</div>
</form>