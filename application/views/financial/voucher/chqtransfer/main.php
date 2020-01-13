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

<script>
$(window).on("load",function(){
baseUrl="<?= base_url("financial/cheque-transfer")?>";	
});
$(document).on("click",".load-cheques",function(){
var target=$('.data-rows').find('tbody');
target.html("");
var form=$('.main-form');
if($('[name=faccount]').val()!=""){
var data=form.serializeArray();
target.customPreloader("show");	
$.post(baseUrl+"/1/cheque",data,function(response){	
target.html(response.data);	
},"json");
}
else{
bootbox.dialog({title:notifications['error'],message:"Select From Account First",buttons:{close:{label:'Ok',className:"red"}}});	
}
});
$(document).on("change","[name=selectChqAll]",function(){
if($(this).is(":checked")){
$(".chqs-checks").prop("checked",true);	
}	
else{
$(".chqs-checks").prop("checked",false);	
}
});
$(document).on("change",".chqs-checks",function(){
$("[name=selectChqAll]").prop("checked",false);	
});
</script>