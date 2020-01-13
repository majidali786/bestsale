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
baseUrl="<?= base_url("memo/memo-voucher")?>";	
<?php 
if(!empty($bissueError)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $bissueError?>",buttons:{close:{label:'Ok',className:"red",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
<?php 	
}
?>	
});	
$(document).on("change","[name=type]",function(){	
var val=$(this).val();
setTimeout(function(){
$(document).find("[name=department]").select2("close");
},100);
var target=$("[load-by-type]");
var target2=$(".modal-edit-row").find(".modal-body");
if(val!=''){
target.customPreloader("show");	
target2.customPreloader("show");	
 $.ajax({
 url:"<?= base_url("memo/memo-voucher-type");?>",
 method:"post",
 data:{type:val},
 dataType:"json"	
 }).done(function(response){
 target.html(response.data1);	
 target2.html(response.data2);
 reinitializeTable(1); 
 setTimeout(function(){
 $(document).find("[name=department]").focus();	 
 },100);
 });
}	
});
$(document).on("change","[name=unit]",function(){
var val=$(this).val();
if(val=="feet"){
$(document).find("[name=weight]").removeAttr("data-dmas");
$(document).find("[name=qty]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=feet]").attr("data-dmas","feet-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","feet-add,rate-multiply,amount-result");	
$(document).find("[name=feet]").trigger("keyup");
}
else if(val=="kg"){
$(document).find("[name=feet]").removeAttr("data-dmas");
$(document).find("[name=qty]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=weight]").attr("data-dmas","weight-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","weight-add,rate-multiply,amount-result");
$(document).find("[name=weight]").trigger("keyup");	
}
else if(val=="pcs"){
$(document).find("[name=feet]").removeAttr("data-dmas");
$(document).find("[name=weight]").removeAttr("data-dmas");
$(document).find("[name=rate]").removeAttr("data-dmas");	
$(document).find("[name=qty]").attr("data-dmas","qty-add,rate-multiply,amount-result");	
$(document).find("[name=rate]").attr("data-dmas","qty-add,rate-multiply,amount-result");
$(document).find("[name=qty]").trigger("keyup");	
}
});
$(document).on("change","[name=unit_e]",function(){
var val=$(this).val();
if(val=="feet"){
$(document).find("[name=weight_e]").removeAttr("data-dmas");
$(document).find("[name=qty_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=feet_e]").attr("data-dmas","feet_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","feet_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=feet_e]").trigger("keyup");
}
else if(val=="kg"){
$(document).find("[name=feet_e]").removeAttr("data-dmas");
$(document).find("[name=qty_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=weight_e]").attr("data-dmas","weight_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","weight_e-add,rate_e-multiply,amount_e-result");
$(document).find("[name=weight_e]").trigger("keyup");	
}
else if(val=="pcs"){
$(document).find("[name=feet_e]").removeAttr("data-dmas");
$(document).find("[name=weight_e]").removeAttr("data-dmas");
$(document).find("[name=rate_e]").removeAttr("data-dmas");	
$(document).find("[name=qty_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");	
$(document).find("[name=rate_e]").attr("data-dmas","qty_e-add,rate_e-multiply,amount_e-result");
$(document).find("[name=qty_e]").trigger("keyup");	
}
});
function loadVoucheredit(vtype){
var target2=$(".modal-edit-row").find(".modal-body");
target2.customPreloader("show");	
 $.ajax({
 url:"<?= base_url("memo/memo-voucher-edit-type");?>",
 method:"post",
 data:{type:vtype},
 dataType:"json"	
 }).done(function(response){	
 target2.html(response.data2);
 });		
}
$(document).on("click",".clear-bno",function(){
	var val=$(document).find("[name=vno]").val();
	var no=$(document).find("[name=no]").val();
	var abc=val.split("-");
	bno=abc[0];
	val=abc[1];
	
	bootbox.dialog({
	message: "Are you sure you want to clear this Book No ?",
	title:"Clear <i class='icon-close text-danger'></i>",
	buttons: {
	danger:{
	label: "Clear <i class='icon-close'></i>",
	className: "red",
	callback: function() {
	$('body').customPreloader("show");
	$.post("<?= base_url("data/clear-book-no-memo")?>",{no:val,bno:bno,sno:no},function(response){
	$('body').customPreloader("hide");
	if(response.success=="true"){
	$(document).find("[name=vno]").val(response.data);	
	bootbox.dialog({title:notifications['success'],message:"Successfully cleared",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green"}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red",callback:function(){ location.href=baseUrl; }}}});	
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
});
$(document).on("click",".bookno-closed",function(){
var status='<?= $voucherrights[0]['APPROVED']?>';
if(status==1){
$(document).find(".bookno-serial").modal();	
$(document).find(".bookno-serial").find(".modal-dialog").css("width","50%");	
$(document).find(".bookno-serial").find(".modal-body").customPreloader("show");
var url="<?= base_url("data/bookno-memo-closed");?>";
$.get(url,function(response){
$(document).find(".bookno-serial").find(".modal-body").customPreloader("hide");
$(document).find(".bookno-serial").find(".modal-body").html(response.data);			
},'json');	
}	
});
</script>