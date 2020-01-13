<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<?php $this->load->view("head");?>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-menu-fixed">
<div class="page-wrapper">

<?php $this->load->view("nav")?>

<div class="page-wrapper-row full-height">
<div class="page-wrapper-middle">
<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
<!-- BEGIN CONTENT BODY -->
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
<div class="container">
<!-- BEGIN PAGE TITLE -->
<div class="page-title">
<h1><?= $heading?></h1>
</div>
</div>
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE CONTENT BODY -->
<div class="page-content">
<div class="container">

<!-- BEGIN PAGE CONTENT INNER -->
<?php $this->load->view($view);?>
<!-- END PAGE CONTENT INNER -->
</div>
</div>
<!-- END PAGE CONTENT BODY -->
<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- BEGIN QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
</div>
</div>
<div class="page-wrapper-row">
<?php $this->load->view("footer");?>
</div>
</div>
<!-- BEGIN QUICK NAV -->

<?php 
if(in_array('quiknav',$libraries)){	
$his->load->view("quicknav");
}
?>
<!-- END QUICK NAV -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<script src="assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
<!-- Modal -->

<div class="modal fade modal-edit" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Modal Title</h4>
</div>
<div class="modal-body"> Modal body goes here </div>
</div>
</div>
</div>
<div class="modal fade modal-edit-extra" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Modal Title</h4>
</div>
<div class="modal-body"> Modal body goes here </div>
</div>
</div>
</div>
<div class="modal fade modal-voucher-details" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Modal Title</h4>
</div>
<div class="modal-body"> Modal body goes here </div>
</div>
</div>
</div>
<div class="modal fade modal-print" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header modal-header-custom">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
<h4 class="modal-title">Modal Title</h4>
</div>
<div class="modal-body"> Modal body goes here </div>
</div>
</div>
</div>
<!-- end modal -->
<!-- BEGIN CORE PLUGINS -->
<script src="<?= base_url("assets/global/plugins/bootstrap/js/bootstrap.min.js");?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/js.cookie.min.js");?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js");?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/optiscroll/js/jquery.optiscroll.min.js");?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/jquery.blockui.min.js");?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?= base_url("assets/global/scripts/app.min.js");?>" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?= base_url("assets/layouts/layout3/scripts/layout.min.js");?>" type="text/javascript"></script>
<?php 
if(in_array('quiknav',$libraries)){	
?>
<script src="<?= base_url("assets/layouts/global/scripts/quick-nav.min.js");?>" type="text/javascript"></script>
<?php 
}
?>
<?php 
if(in_array('datatable',$libraries)){	
?>
<script src="<?= base_url("assets/global/plugins/datatables/datatables.min.js")?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")?>" type="text/javascript"></script>
<?php 
}
if(in_array('datePicker',$libraries)){	
?>
<link href="<?= base_url("assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css");?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js")?>" type="text/javascript"></script>
<script>
$(".date-picker").datepicker({rtl:App.isRTL(),orientation:"left",autoclose:!0,format:"dd/mm/yyyy",todayHighlight:true});
</script>
<?php 
}
if(in_array('dateRangePicker',$libraries)){	
?>
<link href="<?= base_url("assets/global/plugins/daterange-picker-master/css/daterangepicker.min.css");?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/global/plugins/moment.min.js")?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/daterange-picker-master/js/knockout-3.4.2.js")?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/daterange-picker-master/js/daterangepicker.min.js")?>" type="text/javascript"></script>
<script>
$(".date-range-picker").daterangepicker({
  minDate: moment().subtract(2, 'years'),
  callback: function (startDate, endDate, period) {
    $(this).val(startDate.format('DD/MM/YYYY') + ' - ' + endDate.format('DD/MM/YYYY'));
  },
  startDate:'2017-01-01',
  endDate:'<?= date("Y-m-d");?>',
  maxDate:moment().add(1, 'years')
});
</script>
<?php 
}

?>

<script src="<?= base_url("assets/global/plugins/select2/js/select2.full.min.js")?>" type="text/javascript"></script>
<script>
$.fn.select2.defaults.set("theme", "bootstrap");
$(".select2, .select2-multiple").select2({width:"100%"});
</script>
<script src="<?= base_url("assets/global/plugins/bootbox/bootbox.min.js")?>" type="text/javascript"></script>
<?php
if(in_array('numberJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/number.js");?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/cleave/cleave.min.js");?>" type="text/javascript"></script>
<?php 
} 
if(in_array('formJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/form.js?2");?>" type="text/javascript"></script>
<?php 
}
if(in_array('promiseJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/promise.js?1");?>" type="text/javascript"></script>
<?php 
}
if(in_array('salaryJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/salarysheet.js?18");?>" type="text/javascript"></script>
<?php 
}
if(in_array('salaryDailyJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/salarysheetDaily.js?1");?>" type="text/javascript"></script>
<?php 
}
if(in_array('userRights',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/user-rights.js?1");?>" type="text/javascript"></script>
<?php 
}
if(in_array('voucherJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/voucher.js?23");?>" type="text/javascript"></script>
<?php 
}
if(in_array('inputMask',$libraries)){	
?>
<script src="<?= base_url("assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js");?>" type="text/javascript"></script>
<script>
$("[input-mask-date]").inputmask("mask",{mask:"99/99/9999"});
</script>
<?php 
}
if(in_array('slimscroll',$libraries)){	
?>
<script>
$('.for-scroll').optiscroll();
</script>
<?php 
}
if(in_array('chartOfAccountJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/chartofaccount.js");?>" type="text/javascript"></script>
<?php 
}
if(in_array('reportsJs',$libraries)){	
?>
<script src="<?= base_url("assets/global/scripts/reports.js?7");?>" type="text/javascript"></script>
<script>
voucherDetailsUrl="<?= base_url("data/voucher-details");?>";
</script>
<?php 
}
if(in_array('barchart',$libraries)){	
?>
<link href="<?= base_url("assets/global/plugins/morris/morris.css")?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/global/plugins/morris/morris.min.js")?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/plugins/morris/raphael-min.js")?>" type="text/javascript"></script>
<?php 
}
?>
<script src="<?= base_url("assets/pages/scripts/preloader.js")?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/scripts/notification.js?2");?>" type="text/javascript"></script>
<script src="<?= base_url("assets/global/scripts/print.js?2");?>" type="text/javascript"></script>
<script>
printUrl="<?= base_url("data/print");?>";
$(document).on("change","[name=changebranch]",function(){
var branch=$(this).val();
$('body').customPreloader("show");
$.post("<?= base_url("data/branch-change")?>",{branch:branch},function(response){
if(response.success=="true"){
$('body').customPreloader("hide");	
bootbox.dialog({title:notifications['success'],message:response.response,buttons:{close:{label:'Ok',className:"green",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
}
else{
bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'Ok',className:"red"}}});		
}	
},"json");	
});
<?php 
if(!empty($aunthorized)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $aunthorized;?>",buttons:{close:{label:'Ok',className:"red"}}});	
<?php 	
}
?>
var currentBranch='<?= $user['B_ID']?>';
setInterval(function(){
$.post("<?= base_url("data/check-branch")?>",{branch:currentBranch},function(response){
if(response!='true'){
location.href='<?= base_url("home")?>';	
}	
},"json");
},5000);
<?php 
if($user['U_TYPE']==3)
{ 
?>
setInterval(function(){
$.get("<?= base_url("notification/pending-voucher/list")?>",function(response){
if(response['btot']>0){	
if($("#header_notification_bar").find(".dropdown-toggle").find(".badge").length==0){
$("#header_notification_bar").find(".dropdown-toggle").append('<span class="badge badge-default">'+response['btot']+'</span>');
}
else{
$("#header_notification_bar").find(".dropdown-toggle").find(".badge").html(response['btot']);	
}
$("#header_notification_bar").find(".external").find("strong").html(""+response['btot']+" Pending");	
$("#header_notification_bar").find("[notif-list]").html(response['data']); 
}	
},"json");	
},3000);
<?php 
}
?>
</script>
</body>
</html>