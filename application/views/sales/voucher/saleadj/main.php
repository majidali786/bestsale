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
<div class="modal fade modal-edit-row" id="basic"  role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title"><?= $heading?></h4>
</div>
<div class="modal-body">
<table class="table table-bordered table-striped table-condensed">
<thead class="theme-bg">
<tr>
<th style="width:550px;text-align:center">Description</th>
<th style="width:150px;text-align:center">Amount</th>

</tr>
</thead>
<tbody>
<tr>
<td><input type="text" class="form-control th-left" name="desc_e" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero class="form-control th-right" name="total_e" data-dmas="gstper_e-add,total_e-percent-gst_e,net_e-clear,total_e-add,gst_e-add,net_e-result" placeholder="GST%"  placeholder="Total"></td>

</tr>
</tr>
</tbody>
</table>


<div class="form-actions">
<button type="button" class="btn green update-row">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade bookno-serial" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Closed Serials</h4>
</div>
<div class="modal-body"></div>
</div>
</div>
</div>
<script>
$(window).on("load",function(){
baseUrl="<?= base_url("sales/sale-adjustment")?>";	
<?php 
if(!empty($bissueError)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $bissueError?>",buttons:{close:{label:'Ok',className:"red",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
<?php 	
}
?>	
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
dataSum();	
},'json');
});
$(document).on("change","[name=pname]",function(){
var val=$(this).val();	
if(val!=""){
$.get("<?= base_url('data/current-stock');?>",{pcode:val},function(response){
if(response.success=='true'){
$('.current-stock').html(response.bal);	
}
},"json");	
}
});

$(document).on("click","#dcsale",function(){
if($('#dcsale').is(":checked"))	
{
$('[load-lcinfo]').html('');
$("input[name=qty]").prop("readonly", true);
$("input[name=rate]").prop("readonly", true);
}	else {
$('[load-lcinfo]').html('');
$("input[name=qty]").prop("readonly", false);
$("input[name=rate]").prop("readonly", false);	
}
});
</script>