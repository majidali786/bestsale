<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['PCODE']?>" />
<div class="form-body">


<div class="form-group">
<label class="col-md-3 control-label">Design</label>
<div class="col-md-9 show-error">
<select name="pgrp" id="pgrp" class="form-control select2">
<?php 
if(count($pgrp)){
foreach($pgrp as $g){
?>
<option value="<?= $g['ID']; ?>"><?= $g['NAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Color</label>
<div class="col-md-6 show-error">
<select name="sgrp" id="sgrp" class="form-control select2">
<?php 
if(count($sgrp)){
foreach($sgrp as $g){
?>
<option value="<?= $g['ID']; ?>"><?= $g['NAME']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3" style="display:none">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_SGRP']==1){ echo "checked"; } ?> name="inc_sgrp">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Size</label>
<div class="col-md-6 show-error">
<select name="size" id="size" class="form-control select2">
<?php 
if(count($size)){
foreach($size as $g){
?>

<option value="<?= $g['ID']; ?>"><?= $g['SIZE']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3" style="display:none">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_SIZE']==1){ echo "checked"; } ?> name="inc_size">
<span></span>
</label>
</div>
</div>
</div>







<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" title="<?= $data[0]['PNAME']?>" readonly placeholder="Name" value="<?= $data[0]['PNAME']?>">
</div>
</div>



<div class="form-group">
<label class="col-md-3 control-label">Unit</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control"  name="unit" id="unit" title="<?= $data[0]['UNIT']?>" placeholder="Unit"   value="<?= $data[0]['UNIT']?>">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Purchase Rate</label>
<div class="col-md-4 show-error">
<input type="text" class="form-control" name="prate"  id="prate_e" title="<?= $data[0]['PRATE']?>" readonly placeholder="Purchase Rate" value="<?= $data[0]['PRATE']?>">
</div>
<label class="col-md-3 control-label">Profit Margin %</label>
<div class="col-md-4 show-error">
<input type="text" class="form-control" name="pmargin" id="pmargin_e" title="Profit Margin" placeholder="Profit Margin" autocomplete="off"  value="<?= $data[0]['PMARGIN']?>">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Min Sale Price</label>
<div class="col-md-4 show-error">
<input type="text" class="form-control" name="pamount" id="pamount_e" title="Profit Amount" placeholder="Profit Margin" autocomplete="off" readonly  value="<?= $data[0]['PAMOUNT']?>">
</div>
<label class="col-md-3 control-label">Sales Rate</label>
<div class="col-md-4 show-error">
<input type="text" class="form-control" name="srate" id="srate_e" title="<?= $data[0]['SRATE']?>" readonly placeholder="Sales Rate" value="<?= $data[0]['SRATE']?>">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Status</label>
<div class="col-md-6 show-error">
<select name="status" id="status" class="form-control select2">
<option value="">Select Status</option>
<option value="1" <?php if($data[0]['STATUS']==1) { ?>	selected	<?php } ?> >Active</option>
<option value="0" <?php if($data[0]['STATUS']==0) { ?>	selected	<?php } ?> >InActive</option>
</select>
</div>
</div>


</div>
<div class="form-actions">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</form>
<script>
$('[name=pgrp]').val(<?= $data[0]['DID']?>);
$('[name=sgrp]').val(<?= $data[0]['CID']?>);
$('[name=size]').val(<?= $data[0]['SID']?>);

$('[name=status]').val(<?= $data[0]['STATUS']?>);
</script>