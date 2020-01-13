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
<div class="modal fade modal-edit-row" id="basic" role="basic" aria-hidden="true">
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
<th>Employee</th>
<th>Current Salary</th>
<th>Incremented Salary</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="acode_e" class="hidden-data" />
<select name="aname_e" id="aname_e" data-ajax-request="invoices_e,refChqNo_e" change-assign-value="acode_e" data-name-array="aname_array" data-required hidden-data="acode_e" class="form-control select2"  >
<option value="">Employee</option>
<?php 
if(count($employee)){
foreach($employee as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['ID']."-".$g['NAME']; ?></option>
<?php
}
}
?>
</select>
</td>
<td><input type="text" class="form-control" data-required name="current_e" readonly placeholder="Current Salary"></td>

<td><input type="text" data-required data-only-numbers class="form-control" name="increment_e" placeholder="Incremented Salary"></td>
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
<script>
$(window).on("load",function(){
baseUrl="<?= base_url("pay-roll/salary-increment")?>";	
});
var salary=<?= json_encode($employee);?>;
$(document).on("change","[name=aname]",function(){
var val=$(this).val();	
$.each(salary,function(i,tag){
if(tag['ID']==val){
$("[name=current]").val(tag['BASIC']);	
}
});
});
$(document).on("change","[name=aname_e]",function(){
var val=$(this).val();
$.each(salary,function(i,tag){
if(tag['ID']==val){
$("[name=current_e]").val(tag['BASIC']);	
}
});
});
</script>