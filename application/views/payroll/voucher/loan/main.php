<?php 
$this->load->view($loadControls);
?>
<div class="page-content-inner">
<div class="portlet light portlet-fit ">
<div class="portlet-body all-data">
<?php 
$this->load->view($loadVoucher);
?>
</div>
</div>
</div>
<!------edit row portion--->
<script>
$(window).on("load",function(){
baseUrl="<?= base_url("pay-roll/loan-advance")?>";	
});
/* $(document).on("change","[name=employee]",function(){
var val=$(this).val();
var status=["Permanent","Temporary","Daily Wages","Contract"];
if(val!=""){
var a=val.split("-");
$(document).find("[name=ecode]").val(a[0]);	
$(document).find("[name=department]").val(a[1]);	
$(document).find("[name=designation]").val(a[2]);	
$(document).find("[name=etype]").val(status[a[3]]);	
}
else{
$(document).find("[name=ecode],[name=department],[name=designation],[name=etype]").val("");	
}	
}); */
$(document).on("change","[name=employee]",function(){
var val=$(this).val();
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
var array=$(this).attr("data-through-ajax");	
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
});
$(document).on("change","[name=type]",function(){
if($(this).val()==3){
$(document).find(".ninstall,.pminstall").hide();	
}
else{
$(document).find(".ninstall,.pminstall").show();	
}	
});
</script>