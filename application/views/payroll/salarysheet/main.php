<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Salary</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-sm-2 control-label">Select Month</label>
<div class="col-sm-3 show-error">

<input class="form-control date-picker" size="16" type="text" placeholder="dd/mm/yyyy" name="date" value="<?= $vdate ?>">

</div>
<button type="button" class="btn green" load-salary-sheet>Load Salary Sheet</button>
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
$.post("<?= base_url("pay-roll/salary-sheet/details");?>",{date:$('[name=date]').val()},function(response){
target.html(response);
$(document).find('[salary-sheet-calculate]').trigger("keyup");		
});
}
});
$('body').on("click","[type=reset]",function(){
setTimeout(function(){
$("[salary-sheet]").empty();	
},101);	
});
</script>