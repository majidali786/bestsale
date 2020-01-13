<?php 
$actypes=array();
?>
<form class="form-horizontal other-rights-form" role="form" onsubmit="return false;">
<input type="hidden" name="user" value="<?= $data['user']?>" />
<div class="row form-actions">
<div class="col-sm-4">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
<div class="col-sm-4">
<h4>User : <?= $data['user']?></h4>
</div>
</div>
<div class="form-body">
<div class="row">
<div class="col-sm-12">
<div class="mt-element-list">
<div class="mt-list-head list-simple font-white bg-red">
<div class="list-head-title-container">
<h3 class="list-title">Other Rights</h3>
</div>
</div>
<div class="mt-list-container list-simple">
<ul>
<li class="mt-list-item"> 
<div class="list-icon-container done">
<i class="icon-list"></i>
</div>
<div class="list-item-content">
<h3 class="uppercase">Promises On Dashboard 
<div class="md-checkbox has-error pull-right">
<input type="checkbox" <?php if(!empty($data1[0]['PROMISES'])){ if($data1[0]['PROMISES']==1){ echo "checked"; }} ?> id="apromise" name="apromise" value="1" class="md-check">
<label for="apromise">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Allow</b></label>
</div></h3>
</div>
</li>
<li class="mt-list-item"> 
<div class="list-icon-container done">
<i class="icon-list"></i>
</div>
<div class="list-item-content">
<h3 class="uppercase">Account Acitivity
<div class="md-checkbox has-error pull-right">
<input type="checkbox" <?php if(!empty($data1[0]['ACCOUNTACTIVITY'])){ if($data1[0]['ACCOUNTACTIVITY']==1){ echo "checked"; 
$actypes=explode(",",$data1[0]['ACCOUNTACTIVITYDATA']);
}} ?> id="aactivity" name="aactivity" value="1" class="md-check">
<label for="aactivity">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Allow</b></label>
</div></h3>
</div>
<div class="row aactivity">
<div class="col-sm-6 show-error" style="padding-top:10px;">
<select name="actypes[]" id="actypes" class="form-control select2" multiple data-allow-clear="true" data-placeholder="Select Account Types">
<?php 
if(!empty($data2)){
foreach($data2 as $g){
?>
<option value="<?= $g['ATYPE']; ?>"><?= $g['ATPNAME']; ?></option>
<?php
}
}
?>

</select>
</div>
</div>
</li>

<li class="mt-list-item"> 
<div class="list-icon-container done">
<i class="icon-list"></i>
</div>
<div class="list-item-content">
<h3 class="uppercase">Reports On Dashboard 
<div class="md-checkbox has-error pull-right">
<input type="checkbox" <?php if(!empty($data1[0]['DASHBOARD'])){ if($data1[0]['DASHBOARD']==1){ echo "checked"; }} ?> id="dashboard" name="dashboard" value="1" class="md-check">
<label for="dashboard">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Allow</b></label>
</div></h3>
</div>
</li>

<li class="mt-list-item"> 
<div class="list-icon-container done">
<i class="icon-list"></i>
</div>
<div class="list-item-content">
<h3 class="uppercase">Pending DC Aprroval 
<div class="md-checkbox has-error pull-right">
<input type="checkbox" <?php if(!empty($data1[0]['PENDINGDC'])){ if($data1[0]['PENDINGDC']==1){ echo "checked"; }} ?> id="pendingdc" name="pendingdc" value="1" class="md-check">
<label for="pendingdc">
<span></span>
<span class="check"></span>
<span class="box"></span> <b>Allow</b></label>
</div></h3>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</form>
<script>
var form=$('.other-rights-form');	
form.find('#actypes').val(<?= json_encode($actypes);?>).select2({width:"100%"});
form.find('.aactivity').hide();
var user=form.find("[name=user]").val();	
form.find('[name=aactivity]').on("change",function(){
form.find('.aactivity').hide();	
if($(this).is(":checked")){
form.find('.aactivity').show();	
}	
});	
form.find('[name=aactivity]').trigger("change");
form.submit(function(){
var data=form.serializeArray();
var data2=[];
$.each(form.find("[type=checkbox]"),function(i,tag){
if(!$(this).is(":checked")){
	var uvalue=tag.name;
	data2.push(uvalue);
}	
});
data.push({name:'notchecked',value:data2});
form.customPreloader("show");
var url=baseUrl+"/other-rights";
$.post(url,data,function(response){
form.customPreloader("hide");
form.find('.text-danger').remove();	
if(response.success=="true"){
bootbox.dialog({title:notifications['success'],message:"Successfully Updated",buttons:{close:{label:'Ok',className:"green"}}});	
}
else if(response.success=="false"){
$.each(response.error,function(index,value){
var abc=form.find('[name='+index+']').parents(".show-error");
abc.append('<div class="text-danger">* '+value+'</div>');
$('#'+index+'').focus();
});	
bootbox.dialog({title:notifications['error'],message:"Error",buttons:{close:{label:'Ok',className:"red"}}});
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
event.preventDefault();	
});
</script>