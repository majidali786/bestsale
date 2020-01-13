<form class="form-horizontal voucher-rights-form" role="form" onsubmit="return false;">
<input type="hidden" name="user" value="<?= $data['user']?>" />
<div class="row form-actions">
<div class="col-sm-4">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
<div class="col-sm-4">
<h4>User : <?= $data['user']?></h4>
</div>
<div class="col-sm-4">
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
<div class="col-sm-4 vouchers"></div>
<div class="col-sm-8 voucher-rights"></div>
</div>
</div>
</form>
<script>
$('.voucher-rights-form').find('[name=branch]').select2({width:"100%"});
var form=$('.voucher-rights-form');	
var user=form.find("[name=user]").val();		
$('.voucher-rights-form').on("change","[name=branch]",function(){
var branch=form.find("[name=branch]").val();	
var url=baseUrl+"/voucher-rights/vouchers";	
var target=form.find(".vouchers");
target.customPreloader("show");
$.get(url,{user:user,branch:branch},function(response){
if(response.success=="true"){
target.html(response.data);	
form.find(".voucher-rights").html("");	
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
});
form.find('[name=branch]').trigger("change");
$('.voucher-rights-form').on("click","[load-voucher-rights]",function(){
var branch=form.find("[name=branch]").val();	
var level=$(this).parents(".mt-list-item").attr("data-id");	
var url=baseUrl+"/voucher-rights/rights";	
var target=form.find(".voucher-rights");
target.customPreloader("show");
$.get(url,{user:user,branch:branch,voucher:level},function(response){
if(response.success=="true"){
target.html(response.data);		
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
});
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
var url=baseUrl+"/voucher-rights";
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