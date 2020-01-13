<div class="row">

<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Add Product</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal list-refresh" role="form">
<div class="form-body">


<div class="form-group">
<label class="col-md-3 control-label">Design</label>
<div class="col-md-9 show-error">
<select name="pgrp" id="pgrp" class="form-control select2">
<option value="">Select Design</option>
<option value="0">None</option>
<?php 
if(count($pgrp)){
foreach($pgrp as $g){
?>
<option value="<?= $g['ID']."-".$g['NAME']; ?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3" style="display:none">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_pgrp">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Color</label>
<div class="col-md-9 show-error">
<select name="sgrp" id="sgrp" class="form-control select2">
<option value="">Select Color</option>
<option value="0">None</option>
<?php 
if(count($sgrp)){
foreach($sgrp as $g){
?>
<option value="<?= $g['ID']."-".$g['NAME']; ?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3" style="display:none">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_sgrp">
<span></span>
</label>
</div>
</div>
</div>



<div class="form-group">
<label class="col-md-3 control-label">Size</label>
<div class="col-md-6 show-error">
<select name="size" id="size" class="form-control select2">
<option value="">Select Size</option>
<option value="0">None</option>
<?php 
if(count($size)){
foreach($size as $g){
?>
<option value="<?= $g['ID']."-".$g['SIZE']; ?>"><?= $g['SIZE']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3" style="display:none">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_size">
<span></span>
</label>
</div>
</div>
</div>








<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" title="asdasd" readonly placeholder="Name">
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Unit</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control"  name="unit" id="unit" title="unit" placeholder="Unit"   value="PCS">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Purchase.Rate</label>
<div class="col-md-3 show-error">
<input type="text" class="form-control" name="prate" id="prate" title="Purchase.Rate"  placeholder="Purch.Rate" autocomplete="off">
</div>
<label class="col-md-3 control-label">Profit Margin %</label>
<div class="col-md-3 show-error">
<input type="text" class="form-control" name="pmargin"  id="pmargin" value = "10" title="Profit Margin" placeholder="Profit Margin" autocomplete="off" >
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Min Sale Price</label>
<div class="col-md-3 show-error">
<input type="text" class="form-control" name="pamount" id="pamount" title="Profit Amount" placeholder="Sale Price" autocomplete="off" readonly>
</div>
<label class="col-md-3 control-label">Sales.Rate</label>
<div class="col-md-3 show-error">
<input type="text" class="form-control" name="srate" title="Sales.Rate" id="srate"  autocomplete="off" placeholder="Sales.Rate">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Status</label>
<div class="col-md-6 show-error">
<select name="status" id="status" class="form-control select2">
<option value="">Select Status</option>
<option value="1">Active</option>
<option value="0">InActive</option>
</select>
</div>
</div>

</div>
<div class="form-actions right1">
<button type="submit" class="btn green">Submit</button>
<button type="reset" class="btn default">Reset</button>
</div>
</form>
</div>
</div>
</div>
<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-list font-white"></i>
<span class="caption-subject font-white bold uppercase">List Product</span>
</div>
<div class="actions">
<a class="btn btn-circle btn-icon-only btn-default loadlist" href="javascript:;">
<i class="icon-refresh"></i>
</a>
<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" data-list-load>

</div>
</div>
</div>

</div>
<script>
$(document).on("change",'[name=pgrp],[name=sgrp],[name=size],[name=inc_pgrp],[name=inc_sgrp],[name=inc_size]',function(){
var obj=$(this);
if(obj.val()!="" || obj.is("checkbox"))
{	
var form=obj.parents("form");
var data=form.serializeArray();	
$.ajax({
method:'post',
url:"<?= base_url("edit/pprofile/get-name")?>",
data:data,
dataType:"json"	
}).done(function(response){
form.find("[name=name]").val(response.name);	
form.find("[name=name]").attr("title",response.name);	
//form.find("[name=code]").val(response.code);	
});
}
});
//for main page
$(document).on("keyup","#prate,#pmargin",function(){
var prate = $('#prate').val();
var pmargin = $('#pmargin').val();

if (prate =='') {
	prate = 0;
}
if (pmargin =='') {
	pmargin = 0;
}

var percentage = (pmargin/100)*prate;


var result = parseFloat(prate)+parseFloat(percentage);

	$('#pamount').val(result);
	$('#srate').val(result);
});

$(document).on("focusout","#srate",function (){
var srate = parseFloat(this.value);
var pamount = parseFloat($('#pamount').val());
if (srate =='') {
	srate = 0;
}
if (pamount =='') {
	pamount = 0;
}
if (srate!==undefined  || pamount!==undefined) {
	if (srate<pamount) 
	{
		$('#srate').val(pamount);		
	}else{
		$('#srate').val(srate);		
	}
}

});

//for edit page
$(document).on("keyup","#prate_e,#pmargin_e",function(){
var prate = $('#prate_e').val();
var pmargin = $('#pmargin_e').val();
if (prate =='') {
	prate = 0;
}
if (pmargin =='') {
	pmargin = 0;
}
if (pmargin!==undefined  || prate!==undefined) {
var percentage = Math.round10((pmargin/100)*prate);
}
var result = parseFloat(prate)+parseFloat(percentage);
	$('#pamount_e').val(result);
	$('#srate_e').val(result);

});

$(document).on("focusout","#srate_e",function (){
var srate = parseFloat(this.value);
var pamount = parseFloat($('#pamount_e').val());
if (srate =='') {
	srate = 0;
}
if (pamount =='') {
	pamount = 0;
}
if (srate!==undefined  || pamount!==undefined) {
	if (srate<pamount) 
	{
		$('#srate_e').val(pamount);		
	}else{
		$('#srate_e').val(srate);		
	}
}

});



</script>