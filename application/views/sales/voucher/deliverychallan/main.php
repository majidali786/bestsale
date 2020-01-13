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
baseUrl="<?= base_url("sales/delivery-challan")?>";		
});
$(document).on("change","[name=vname]",function(){
if($(this).val()!=""){
var target=$('[load-lcinfo]');	
target.customPreloader("show");
$.post(baseUrl+"/loadso",{vcode:$(this).val()},function(response){
target.html(response);	
});
}	
});

$(document).on("change","[name=vname]",function(){
var data={
	acode:$(this).val()
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
$(document).find("[name="+tag+"]").val(response[i]);	
});
},'json');
dataSum();	
});

$(document).on("click","#ladj",function(){
if($('#ladj').is(":checked"))	
{
var url="<?= base_url("data/party-limitadj");?>";
$.get(url,{acode:$("input[name=vcode]").val(),chk:'1'},function(response){
$(document).find("[name=limit]").val(response['climit']);	
},'json');
}	else {
var url="<?= base_url("data/party-limitadj");?>";
$.get(url,{acode:$("input[name=vcode]").val(),chk:'0'},function(response){
$(document).find("[name=limit]").val(response['climit']);	
},'json');
}
});

function amt(val,row) {
var a = $("input[name=rate_"+row+"]").val();
var b = parseFloat(a)*parseFloat(val);
$("input[name=amount_"+row+"]").val(b);
dataSum();	
}
</script>