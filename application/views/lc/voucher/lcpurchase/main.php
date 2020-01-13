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
baseUrl="<?= base_url("lc/lc-purchase")?>";		
});
$(document).on("change","[name=lcno]",function(){
if($(this).val()!=""){
var target=$('[load-lcinfo]');	
target.customPreloader("show");
$.post(baseUrl+"/loadlc",{lcno:$(this).val()},function(response){
target.html(response);	
});
}	
});
</script>