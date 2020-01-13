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
baseUrl="<?= base_url("promise/promise-voucher")?>";	
});
</script>