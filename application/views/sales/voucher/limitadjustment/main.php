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
baseUrl="<?= base_url("sales/limit-adjustment")?>";		
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
});	


</script>