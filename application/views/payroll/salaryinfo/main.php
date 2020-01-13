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
<form class="form-horizontal list-refresh" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-sm-2 control-label">Employee</label>
<div class="col-sm-3 show-error">

<select name="employee" id="employee" class="form-control select2">
<option value="">Select Employee</option>
<?php 
if(count($employee)){
foreach($employee as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>

<div class="row">
<div class="col-sm-12" load-employee-data>

</div>
</div>

</form>
</div>
</div>
</div>

</div>
<script>
$(document).on("change","[name=employee]",function(){
var target=$("[load-employee-data]");
if($(this).val()!=""){
target.customPreloader("show");	
$.post("<?= base_url("pay-roll/salary-information/details");?>",{id:$(this).val()},function(response){
target.html(response);		
});
}
});
$('body').on("click","[type=reset]",function(){
setTimeout(function(){
$("[load-employee-data]").empty();	
},101);	
});
</script>