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
<label class="col-md-3 control-label">Main Group</label>
<div class="col-md-9 show-error">
<select name="mgroup" id="mgroup" class="form-control select2">
<option value="">Select Main Group</option>
<?php 
if(count($mgroup)){
foreach($mgroup as $g){
?>
<option value="<?= $g['ID']."--".$g['SSMGROUP'];?>"><?= $g['SSMGROUP']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Item Name</label>
<div class="col-md-6 show-error">
<select name="itemname" id="itemname" class="form-control select2">
<option value="">Select Item Name</option>
<option value="0">None</option>
<?php 
if(count($itemname)){
foreach($itemname as $g){
?>
<option value="<?= $g['ID']."--".$g['SSINAME']; ?>"><?= $g['SSINAME']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_itemname">
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
<option value="<?= $g['ID']."--".$g['SSSIZE']; ?>"><?= $g['SSSIZE']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_size">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Nature</label>
<div class="col-md-6 show-error">
<select name="nature" id="nature" class="form-control select2">
<option value="">Select Nature</option>
<option value="0">None</option>
<?php 
if(count($nature)){
foreach($nature as $g){
?>
<option value="<?= $g['ID']."--".$g['SSNATURE']; ?>"><?= $g['SSNATURE']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_nature">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Feet</label>
<div class="col-md-6 show-error">
<select name="feet" id="feet" class="form-control select2">
<option value="">Select Feet</option>
<option value="0">None</option>
<?php 
if(count($feet)){
foreach($feet as $g){
?>
<option value="<?= $g['ID']."--".$g['SSFEET']; ?>"><?= $g['SSFEET']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_feet">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Unit</label>
<div class="col-md-6 show-error">
<select name="unit" id="unit" class="form-control select2">
<option value="">Select Unit</option>
<option value="0">None</option>
<?php 
if(count($unit)){
foreach($unit as $g){
?>
<option value="<?= $g['ID']."--".$g['SSUNIT']; ?>"><?= $g['SSUNIT']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_unit">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Weight</label>
<div class="col-md-6 show-error">
<select name="weight" id="weight" class="form-control select2">
<option value="">Select Weight</option>
<option value="0">None</option>
<?php 
if(count($weight)){
foreach($weight as $g){
?>
<option value="<?= $g['ID']."--".$g['SSWEIGHT']; ?>"><?= $g['SSWEIGHT']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_weight">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Others1</label>
<div class="col-md-6 show-error">
<select name="others1" id="others1" class="form-control select2">
<option value="">Select Others1</option>
<option value="0">None</option>
<?php 
if(count($others1)){
foreach($others1 as $g){
?>
<option value="<?= $g['ID']."--".$g['SSOTHERS1']; ?>"><?= $g['SSOTHERS1']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_others1">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Others2</label>
<div class="col-md-6 show-error">
<select name="others2" id="others2" class="form-control select2">
<option value="">Select Others2</option>
<option value="0">None</option>
<?php 
if(count($others2)){
foreach($others2 as $g){
?>
<option value="<?= $g['ID']."--".$g['SSOTHERS2']; ?>"><?= $g['SSOTHERS2']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_others2">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Others3</label>
<div class="col-md-6 show-error">
<select name="others3" id="others3" class="form-control select2">
<option value="">Select Others3</option>
<option value="0">None</option>
<?php 
if(count($others3)){
foreach($others3 as $g){
?>
<option value="<?= $g['ID']."--".$g['SSOTHERS3']; ?>"><?= $g['SSOTHERS3']; ?></option>
<?php
}
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" checked name="inc_others3">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Code</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="code" readonly placeholder="Code">
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" title="asdasd" readonly placeholder="Name">
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
$(document).on("change",'[name=mgroup],[name=itemname],[name=size],[name=nature],[name=feet],[name=unit],[name=weight],[name=others1],[name=others2],[name=others3],[name=inc_itemname],[name=inc_size],[name=inc_nature],[name=inc_feet],[name=inc_unit],[name=inc_weight],[name=inc_others1],[name=inc_others2],[name=inc_others3]',function(){
var obj=$(this);
if(obj.val()!="" || obj.is("checkbox"))
{	
var form=obj.parents("form");
var data=form.serializeArray();	
$.ajax({
method:'post',
url:"<?= base_url("store-and-spare/product/get-code-name")?>",
data:data,
dataType:"json"	
}).done(function(response){
form.find("[name=name]").val(response.name);	
form.find("[name=name]").attr("title",response.name);	
form.find("[name=code]").val(response.code);	
});
}
});
</script>