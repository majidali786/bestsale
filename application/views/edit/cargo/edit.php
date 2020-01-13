<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['CODE']?>" />
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
<label class="col-md-3 control-label">E-mail</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="email" value="<?= $data[0]['EMAIL']?>" placeholder="E-mail">
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