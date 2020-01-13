<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['CCODE']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">City</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" value="<?= $data[0]['CNAME']?>"  placeholder="City">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Province</label>
<div class="col-md-9 show-error">
<select name="province" id="province" data-live-search="true" class="form-control">
<option value="">Select Province</option>
<?php 
if(count($province)){
foreach($province as $g){
?>
<option value="<?= $g['PRCODE']; ?>"><?= $g['PRNAME']; ?></option>
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
$('[name=province]').val(<?= $data[0]['ATYPE']?>)
</script>