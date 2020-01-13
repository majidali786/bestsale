<form class="form-horizontal menu-rights-form" role="form" onsubmit="return false;">
<input type="hidden" name="user" value="<?= $data['user']?>" />
<div class="row form-actions">
<div class="col-sm-4">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
<div class="col-sm-4">
<h4>User : <?= $data['user']?></h4>
</div>
<div class="col-sm-4 show-error">
<select name="branch" id="branch" class="form-control select2">
<?php 
if(count($branch)){
foreach($branch as $g){
?>
<option value="<?= $g['BCODE']; ?>"><?= $g['BNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<div class="form-body">
<div class="row">
<div class="col-sm-4 level-1"></div>
<div class="col-sm-4 level-2"></div>
<div class="col-sm-4 level-3"></div>
</div>
</div>
</form>
<script>
$('.menu-rights-form').find('[name=branch]').select2({width:"100%"});
var form=$('.menu-rights-form');	
var user=form.find("[name=user]").val();		
$('.menu-rights-form').on("change","[name=branch]",function(){
var branch=form.find("[name=branch]").val();	
var url=baseUrl+"/menu-rights/1";	
var target=form.find(".level-1");
target.customPreloader("show");
$.get(url,{user:user,branch:branch},function(response){
if(response.success=="true"){
target.html(response.data);	
form.find(".level-2").html("");	
form.find(".level-3").html("");	
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
});
$('.menu-rights-form').on("click","[load-level-2]",function(){
var branch=form.find("[name=branch]").val();	
var level=$(this).parents(".mt-list-item").attr("data-id");	
var url=baseUrl+"/menu-rights/2";	
var target=form.find(".level-2");
target.customPreloader("show");
$.get(url,{user:user,branch:branch,level:level},function(response){
if(response.success=="true"){
target.html(response.data);		
form.find(".level-3").html("");
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
});
$('.menu-rights-form').on("click","[load-level-3]",function(){
var branch=form.find("[name=branch]").val();	
var level=$(this).parents(".mt-list-item").attr("data-id");	
var url=baseUrl+"/menu-rights/3";	
var target=form.find(".level-3");
target.customPreloader("show");
$.get(url,{user:user,branch:branch,level:level},function(response){
if(response.success=="true"){
target.html(response.data);	
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
});
$('.menu-rights-form').find('[name=branch]').trigger("change");
form.submit(function(){
var data=form.serializeArray();
var data2=[];
$.each(form.find("[type=checkbox]"),function(i,tag){
if(!$(this).is(":checked")){
	var uvalue=tag.value;
	data2.push(uvalue);
}	
});
data.push({name:'notchecked',value:data2});
form.customPreloader("show");
var url=baseUrl+"/menu-rights";
$.post(url,data,function(response){
form.customPreloader("hide");	
if(response.success=="true"){
bootbox.dialog({title:notifications['success'],message:"Successfully Updated",buttons:{close:{label:'Ok',className:"green"}}});	
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
event.preventDefault();	
});
</script>