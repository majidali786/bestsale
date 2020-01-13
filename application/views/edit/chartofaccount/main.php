<div class="row">

<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title tabbable-line">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Add Account</span>
</div>
<ul class="nav nav-tabs">
<li class="active">
<a href="#portlet_tab1" data-toggle="tab"> Accounts </a>
</li>
<li>
<a href="#portlet_tab2" data-toggle="tab"> Profile </a>
</li>
</ul>
</div>
<div class="portlet-body">
<div class="tab-content">
<div class="tab-pane active" id="portlet_tab1">
<form class="form-horizontal list-refresh main-form" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Account Group</label>
<div class="col-md-9 show-error">
<select name="agroup" id="agroup" class="form-control select2">
<option value="">Select Account Group</option>
    <option value="0">Assets</option>
    <option value="1">Capital</option>
    <option value="2">liabilty</option>
    <option value="3">Income</option>
    <option value="4">Expense</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">
<div class="btn-group">
<a class="btn theme-haze btn-outline btn-circle btn-sm level-1" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;" data-close-others="true" level="1"><i class="fa fa-angle-down"></i>
</a>
<ul class="dropdown-menu pull-right">
<li>
<a href="javascript:;" add-level ><i class="icon-plus theme-color"></i> Add </a>
</li>
<li>
<a href="javascript:;" edit-level><i class="icon-pencil text-warning"></i> Edit </a>
</li>
<li>
<a href="javascript:;" delete-level><i class="icon-trash text-danger"></i> Delete </a>
</li>
<li>
<a href="javascript:;" reload-level><i class="icon-reload theme-color"></i> Refresh </a>
</li>
</ul>
</div> 1st Level
</label>
<div class="col-md-9 show-error level_1">
<select name="level_1" id="level_1" load-level="2" class="form-control select2">
<option value="">Select 1st Level</option>
<?php 
if(count($level1)){
foreach($level1 as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ANAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label"><div class="btn-group">
<a class="btn theme-haze btn-outline btn-circle btn-sm level-2" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" level="2" style="padding: 0px 5px;" data-close-others="true"><i class="fa fa-angle-down"></i>
</a>
<ul class="dropdown-menu pull-right">
<li>
<a href="javascript:;" add-level ><i class="icon-plus theme-color"></i> Add </a>
</li>
<li>
<a href="javascript:;" edit-level><i class="icon-pencil text-warning"></i> Edit </a>
</li>
<li>
<a href="javascript:;" delete-level><i class="icon-trash text-danger"></i> Delete </a>
</li>
<li>
<a href="javascript:;" reload-level><i class="icon-reload theme-color"></i> Refresh </a>
</li>
</ul>
</div>
 2nd Level</label>
<div class="col-md-9 show-error level_2">
<select name="level_2" id="level_2" class="form-control select2">
<option value="">Select 2nd Level</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label"> 
<div class="btn-group">
<a class="btn theme-haze btn-outline btn-circle btn-sm level-3" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" level="3" style="padding: 0px 5px;" data-close-others="true"><i class="fa fa-angle-down"></i>
</a>
<ul class="dropdown-menu pull-right">
<li>
<a href="javascript:;" add-level ><i class="icon-plus theme-color"></i> Add </a>
</li>
<li>
<a href="javascript:;" edit-level><i class="icon-pencil text-warning"></i> Edit </a>
</li>
<li>
<a href="javascript:;" delete-level><i class="icon-trash text-danger"></i> Delete </a>
</li>
<li>
<a href="javascript:;" reload-level><i class="icon-reload theme-color"></i> Refresh </a>
</li>
</ul>
</div>
3rd Level</label>
<div class="col-md-9 show-error level_3">
<select name="level_3" id="level_3" class="form-control select2">
<option value="">Select 3rd Level</option>
</select>
</div>
</div>




<div class="form-group">
<label class="col-md-3 control-label">4th Level Code</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="acode" readonly placeholder="Code">
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">4th Level Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="aname"  placeholder="Name">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Account Type</label>
<div class="col-md-9 show-error">
<select name="atype" id="atype" class="form-control select2">
<option value="">Select Account Type</option>
<?php 
if(count($atype)){
foreach($atype as $g){
?>
<option value="<?= $g['ATYPE'];?>"><?= $g['ATPNAME']; ?></option>
<?php
}
}
?>
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
<div class="tab-pane" id="portlet_tab2">
<form class="form-horizontal list-refresh main-form" role="form">

<div class="form-group">
<label class="col-md-3 control-label">Account Type</label>
<div class="col-md-9 show-error">
<select name="atype_p" id="atype_p" class="form-control select2">
<option value="">Select Account Type</option>
<?php 
if(count($atype)){
foreach($atype as $g){
?>
<option value="<?= $g['ATYPE'];?>"><?= $g['ATPNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group" load-accounts>

</div>

<div load-accounts-detail>

</div>

</form>
</div>
</div>
</div>



</div>


</div>
<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-list font-white"></i>
<span class="caption-subject font-white bold uppercase">List Accounts</span>
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
var levelName=["","1st","2nd","3rd"];
var error=[];
$(document).on("click","[reload-level]",function(){
var val=$(this).parents(".btn-group").children("[level]").attr("level");
if(val==2 || val==3){
if(!$('[name=level_1]').val()>0){
error.push("1st Level is Required");	
}	
}
if(val==3){
if(!$('[name=level_2]').val()>0){
error.push("2nd Level is Required");	
}	
}
if(error.length==0){	
var target=$('.level_'+val+'');
var data=$('.main-form').serializeArray();
target.html("Loading...");
$.get("<?= base_url("chart-of-account-load-level/");?>"+val+"",data,function(response){
target.html(response);	
});	
}
else{
if(resetLink==1){		
bootbox.dialog({title:notifications['error'],message:error.toString(),buttons:{close:{label:'Ok',className:"red"}}});
}	
error=[];
}		
});
$(document).on("click","[add-level]",function(){
var val=$(this).parents(".btn-group").children("[level]").attr("level");
if(val==2 || val==3){
if(!$('[name=level_1]').val()>0){
error.push("1st Level is Required");	
}	
}
if(val==3){
if(!$('[name=level_2]').val()>0){
error.push("2nd Level is Required");	
}	
}
if(error.length==0){	
var modal=$(document).find('.modal-edit');
var modalBody=modal.find(".modal-body");
var modalTitle=modal.find(".modal-title");
modal.modal("show");
modalTitle.html("Add Level "+val+"");
modalBody.customPreloader("show");
$.get("<?= base_url("chart-of-account-add-level/");?>"+val+"",function(response){
modalBody.html(response);	
});	
}
else{
bootbox.dialog({title:notifications['error'],message:error.toString(),buttons:{close:{label:'Ok',className:"red"}}});	
error=[];
}	
});
$(document).on("click","[edit-level]",function(){
var val=$(this).parents(".btn-group").children("[level]").attr("level");
if(val==2 || val==3 || val==1){
if(!$('[name=level_1]').val()>0){
error.push("1st Level is Required");	
}	
}
if(val==2 || val==3){
if(!$('[name=level_2]').val()>0){
error.push("2nd Level is Required");	
}	
}
if(val==3){
if(!$('[name=level_3]').val()>0){
error.push("3rd Level is Required");	
}	
}
if(error.length==0){	
var modal=$(document).find('.modal-edit');
var modalBody=modal.find(".modal-body");
var modalTitle=modal.find(".modal-title");
modal.modal("show");
var data=$('.main-form').serializeArray();
modalTitle.html("Edit Level "+val+"");
modalBody.customPreloader("show");
$.get("<?= base_url("chart-of-account-edit-level/");?>"+val+"",data,function(response){
modalBody.html(response);	
});	
}
else{
bootbox.dialog({title:notifications['error'],message:error.toString(),buttons:{close:{label:'Ok',className:"red"}}});	
error=[];
}		
});
$(document).on("click","[delete-level]",function(){
var val=$(this).parents(".btn-group").children("[level]").attr("level");
if(val==2 || val==3 || val==1){
if(!$('[name=level_1]').val()>0){
error.push("1st Level is Required");	
}	
}
if(val==2 || val==3){
if(!$('[name=level_2]').val()>0){
error.push("2nd Level is Required");	
}	
}
if(val==3){
if(!$('[name=level_3]').val()>0){
error.push("3rd Level is Required");	
}	
}
if(error.length==0){	
var data=$('.main-form').serializeArray();
var url="<?= base_url("chart-of-account-delete-level/");?>"+val+""	
	bootbox.dialog({
	message: "Are you sure you want to delete Level "+val+" ?",
	title:notifications['del'],
	buttons: {
	danger:{
	label: "Delete <i class='icon-trash'></i>",
	className: "red",
	callback: function() {
	$.post(url,data,function(response){
	if(response.success=="true"){		
	$(".level-"+val+"").parents(".btn-group").find("[reload-level]").trigger("click");	
	bootbox.dialog({title:notifications['success'],message:"Successfully Deleted",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red"}}});	
	}
	},"json");
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
});		
}
else{
bootbox.dialog({title:notifications['error'],message:error.toString(),buttons:{close:{label:'Ok',className:"red"}}});	
error=[];
}		
});
$(document).on("change","[load-level]",function(){
var target=$(this).attr("load-level");
if(target!="code&name"){	
$(".level-"+target+"").parents(".btn-group").find("[reload-level]").trigger("click");	
}
else{
if(!$('[name=level_1]').val()>0){
error.push("1st Level is Required");
}		
if(!$('[name=level_2]').val()>0){
error.push("2nd Level is Required");	
}
if(!$('[name=level_3]').val()>0){
error.push("3rd Level is Required");	
}
if(error.length==0){	
var data=$('.main-form').serializeArray();
$.get("<?= base_url("chart-of-account-get-code/");?>",data,function(response){
$(".main-form").find("[name=acode]").val(response)
},"json");	
}
else{	
if(resetLink==1){	
bootbox.dialog({title:notifications['error'],message:error.toString(),buttons:{close:{label:'Ok',className:"red"}}});	
}
error=[];
}
}		
});

$(document).on("click",".edit-party",function(){
var val=$(this).parents("form").find("[name=id]").val();	
var modal=$(document).find('.modal-edit-extra');
var modalBody=modal.find(".modal-body");
var modalTitle=modal.find(".modal-title");
modal.modal("show");
modal.find(".modal-dialog").css("width","90%")
modalTitle.html("Party Details");
modalBody.customPreloader("show");
$.get("<?= base_url("chart-of-account-details/party");?>",{id:val},function(response){
modalBody.html(response);	
});		
});
$(document).on("click",".edit-employee",function(){
var val=$(this).parents("form").find("[name=id]").val();	
var modal=$(document).find('.modal-edit-extra');
var modalBody=modal.find(".modal-body");
var modalTitle=modal.find(".modal-title");
modal.modal("show");
modal.find(".modal-dialog").css("width","90%")
modalTitle.html("Employee Details");
modalBody.customPreloader("show");
$.get("<?= base_url("chart-of-account-details/employee");?>",{id:val},function(response){
modalBody.html(response);	
});		
});
$(document).on("change","[name=atype_p]",function(){	
if($(this).val()!=""){
$('[load-accounts]').customPreloader("show");	
$.get("<?= base_url("chart-of-account-details/atype/");?>",{atype:$(this).val()},function(response){
$('[load-accounts]').html(response);	
});
}		
});
$(document).on("change","[name=accounts]",function(){	
if($(this).val()!=""){
$('[load-accounts-detail]').customPreloader("show");	
$.get("<?= base_url("chart-of-account-details/account");?>",{acode:$(this).val()},function(response){
$('[load-accounts-detail]').html(response);	
});
}		
});

</script>