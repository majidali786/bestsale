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
<th>Expense Type</th>
<th>Lc.No</th>
<th>Description</th>
<th>Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td>
<input type="hidden" name="lcid_e" class="hidden-data" />
<select name="lcaccount_e" id="lcaccount_e" change-assign-value="lcid_e" data-required hidden-data="lcid_e" data-name-array="aname_name" class="form-control select2" >
<option value="">Select Expense Type</option>
<?php 
if(count($lcaccount)){
foreach($lcaccount as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['LCACCOUNT']; ?></option>
<?php
}
}
?>
</select>
</td>
<td>
<input type="hidden" name="acode_e" class="hidden-data" />
<select name="aname_e" id="aname_e" change-assign-value="acode_e" data-required hidden-data="acode_e" class="form-control select2"  >
<option value="">Select LC NO</option>
<optgroup label="Accounts">
<?php 
if(count($lcno)){
foreach($lcno as $g){
?>
<option value="<?= $g['LCNO'];?>"><?= $g['LCNO']; ?></option>
<?php
}
}
?>
</optgroup>
</select>
</td>
<td><input type="text" class="form-control" data-required  name="descrip_e" placeholder="Description"></td>
<td><input type="text" data-required data-only-numbers greater-then-zero  class="form-control" name="amount_e" placeholder="Amount"></td>
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
baseUrl="<?= base_url("lc/lc-expense")?>";	
});
</script>