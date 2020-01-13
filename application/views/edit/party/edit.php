<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['VCODE']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" value="<?= $data[0]['VNAME']?>" placeholder="Username">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Address</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="addr" value="<?= $data[0]['ADDR']?>" placeholder="addr">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Mobile</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="mob" value="<?= $data[0]['MOBILE']?>" placeholder="mob">
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">City</label>
<div class="col-md-9 show-error">
<select name="city" id="city" class="form-control">
<option value="">Select City</option>
<?php 
if(count($city)){
foreach($city as $g){
?>
<option value="<?= $g['CCODE']; ?>"><?= $g['CNAME']; ?></option>
<?php
}
}
?>

</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Branch</label>
<div class="col-md-9 show-error">
<select name="branch" id="branch" class="form-control">
<option value="">Select Branch</option>
<?php 
if(count($branch)){
foreach($branch as $g){
?>
<option value="<?= $g['BCODE']; ?>"><?= $g['BNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Credit Limit</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" value="<?= $data[0]['CLIMIT']?>" name="limit" placeholder="limit">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Status</label>
<div class="col-md-9 show-error">
<select name="status" id="status" class="form-control">
<option value="">Select Status</option>
<option value="1">Active</option>
<option value="0">Deactive</option>
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
$('[name=branch]').val(<?= $data[0]['B_ID']?>);
$('[name=city]').val(<?= $data[0]['CID']?>);
$('[name=status]').val(<?= $data[0]['STATUS']?>);
</script>