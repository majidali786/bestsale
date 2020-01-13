<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Payment Contract</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-sm-2 control-label">Select Week</label>
<div class="col-sm-3 show-error">
<?php 
if(date('D')!='Sun')
{    
$staticstart = date('d/m/Y',strtotime('last Saturday')); 
}
else{
$staticstart = date('d/m/Y');   
}
if(date('D')!='Mon')
{
$staticfinish = date('d/m/Y',strtotime('next Friday'));
}
else{
$staticfinish = date('d/m/Y');
}
?>
<input class="form-control date-picker-weekly" size="16" type="text" placeholder="dd/mm/yyyy" name="date" value="<?= $staticstart." - ".$staticfinish ?>">

</div>
<button type="button" class="btn green" load-salary-sheet>Payment Summary For Contract</button>
</div>

<div class="row">
<div class="col-sm-12" salary-sheet>

</div>
</div>

</form>
</div>
</div>
</div>

</div>
<script>
$(document).on("click","[load-salary-sheet]",function(){
var target=$("[salary-sheet]");
if($('[name=date]').val()!=""){
target.customPreloader("show");	
$.post("<?= base_url("pay-roll/payment-contract/details");?>",{date:$('[name=date]').val()},function(response){
target.html(response);	
dataSum();
});
}
});
$('body').on("click","[type=reset]",function(){
setTimeout(function(){
$("[salary-sheet]").empty();	
},101);	
});
$(window).on("load",function(){
$(".date-picker-weekly").datepicker({
      format: 'dd/mm/yyyy',
	  autoclose:true,
	  endDate:"<?= $staticfinish?>"
  });
$('.date-picker-weekly').datepicker().on("hide", function(e){
  var value = $(".date-picker-weekly").val();
  var firstDate = moment(value, "DD/MM/YYYY").day(-1).format("DD/MM/YYYY");
  var lastDate =  moment(value, "DD/MM/YYYY").day(5).format("DD/MM/YYYY");
  $(".date-picker-weekly").val(firstDate + " - " + lastDate);
  });
});
</script>