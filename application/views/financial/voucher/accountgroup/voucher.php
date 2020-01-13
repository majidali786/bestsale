<form class="form-horizontal main-form" role="form" onsubmit="return false;">
<div class="form-body">


<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['AD']))
{
if($voucherrights[0]['AD']==1){
?>
<div class="col-sm-3">
<button type="submit" class="btn green">Save</button>
<button type="reset" class="btn default">Reset</button>
</div>
<?php 
}
}
?>
</div>



<div class="row">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label" ><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text"  class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Acc. Group Code<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input style="text-align:center;" type="text" class="form-control" name="agrp" readonly placeholder="Account Group Code">
</div>
</div>
</div>




<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher" style="text-align: center;"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Acc. Group Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="agroup" id="agroup" change-assign-value="agrp" class="form-control select2 move-enter-up move-to-row move-enter-3" data-position="3">
<option value="">Select Account Group Name</option>
<?php 
if(count($group)){
foreach($group as $g){
?>
<option value="<?= $g['PGRP'];?>"><?= $g['PGNAME']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>


<?php 
$this->load->view($loadRow);
?>

<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th  style="width:20px;">#</th>
<th>Party/Account</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
</table>
</div>
</div>
</div>
</form>
<script>
<?php 
if(!empty($dataType)){
?>
reinitializeTable(1);
<?php 	
}
?>
</script>