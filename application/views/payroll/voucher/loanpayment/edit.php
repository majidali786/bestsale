<form class="form-horizontal main-form edit-form" role="form" onsubmit="return false;">
<div class="form-body">

<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['EDIT']))
{
if($voucherrights[0]['EDIT']==1){
?>
<div class="col-sm-2">
<button type="submit" class="btn green">Update</button>
<button type="reset" class="btn default">Reset</button>
</div>
<?php 
}
}
?>
<div class="col-sm-3">
<div class="note note-danger ">
<p class="block">UnPosted By : <b><?php if(!empty($unposted)){ echo $unposted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-warning ">
<p class="block">Posted By : <b><?php if(!empty($posted)){ echo $posted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-success">
<p class="block">Approved By : <b><?php if(!empty($approved)){ echo $approved[0]['U_ID']; }?></b></p>
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
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>  Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher" style="text-align: center;"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Type<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="type" id="type" class="form-control select2 move-enter-up move-enter-3" data-position="3">
<option value="">Select Type</option>
<option value="1">Short Term Loan</option>
<option value="2">Long Term Loan</option>
<option value="3">Advance</option>
</select>

</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher" style="text-align: center;"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> To Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="acode" id="acode" class="form-control select2 move-enter-up move-enter-4" data-position="4">
<option value="">Select To Account</option>
<?php 
if(!empty($account)){
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
</div>

<div class="row margin-0">
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher" style="text-align: center;"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Employee<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" name="ecode" />
<select name="employee" id="employee" data-through-ajax="department-department,designation-designation,etype-etype"  class="form-control select2 move-enter-up move-enter-5" data-position="5">
<option value="">Select Employee</option>
<?php 
if(!empty($employee)){
foreach($employee as $g){
?>
<option value="<?= $g['ACODE']."-".$g['ATYPE'];?>" <?php if($g['ACODE']==$data[0]['ECODE']){ echo "selected"; } ?>><?= $g['ANAME']; ?></option>
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
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>  Department</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" name="department" value="" readonly placeholder="Department">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>  Designation</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" name="designation" value="" readonly placeholder="Designation">
</div>
</div>
</div>

<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>  Emp. Type</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control"  name="etype" value="" readonly placeholder="Emp. Type">
</div>
</div>
</div>
</div>

<div class="row margin-0">
<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i>  Loan / Advance Amount</label>
<div class="col-md-12 show-error">
<input type="text" int-numbers-only class="form-control move-enter-up move-enter-6" data-position="6" value="<?= $data[0]['LOAN']?>" name="amount"  placeholder="Loan / Advance Amount">
</div>
</div>
</div>

</div>
</div>
</div>
</form>
<script>
var abc=["Permanent","Temporary","Daily Wages","Contract"];
$("[name=type]").val(<?= $data[0]['TYPE']?>);
$("[name=acode]").val(<?= $data[0]['ACODE']?>);
var val=$(document).find("[name=employee]").val()
var status=["Permanent","Temporary","Daily Wages","Contract"];
if(val!=""){
var a=val.split("-");
typ = a[1];
cod = a[0];
}
$(document).find("[name=ecode]").val(cod);	
if(typ=='2')	{
var data={
	acode:cod
}	
var array="department-department,designation-designation,etype-etype";	
var output={}
var urlParam="";
$.each(array.split(","),function(i,tag){
var a=tag.split("-");
urlParam=urlParam+"/"+a[0];
output[a[0]]=a[1];
});
var url="<?= base_url("data/party-data");?>"+urlParam;
$.get(url,data,function(response){
$.each(output,function(i,tag){
	if(tag=='etype')
	{
	$(document).find("[name="+tag+"]").val(status[response[i]]);	
	}	else {
	$(document).find("[name="+tag+"]").val(response[i]);	
	}
});
},'json');
}	else {
	$(document).find("[name=department]").val('');	
	$(document).find("[name=designation]").val('');	
	$(document).find("[name=etype]").val('');	
}
</script>