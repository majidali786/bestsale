<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['USERNAME']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Username</label>
<div class="col-md-9 show-error">
<h5><?= $data[0]['USERNAME']?></h5>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Password</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="password" value="<?= $data[0]['PASSWORD']?>" placeholder="Password">
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Type</label>
<div class="col-md-9 show-error">
<select name="type" id="type" class="form-control">
<option value="">Select Type</option>
<?php 
if(count($type)){
foreach($type as $g){
?>
<option value="<?= $g['ID']; ?>"><?= $g['TYPE']; ?></option>
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
$('[name=type]').val(<?= $data[0]['TYPE']?>);
$('[name=status]').val(<?= $data[0]['STATUS']?>);
</script>