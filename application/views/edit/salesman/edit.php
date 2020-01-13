<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['BCODE']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Salesman</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" value="<?= $data[0]['BNAME']?>"  placeholder="Salesman">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">User</label>
<div class="col-md-9 show-error">
<select name="user" id="user" class="form-control select2">
<option value="">Select User</option>
<?php 
if(count($userName)){
foreach($userName as $g){
?>
<option value="<?= $g['USERNAME']; ?>"><?= $g['USERNAME']; ?></option>
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
$.fn.select2.defaults.set("theme", "bootstrap");
$('.edit-form').find('[name=user]').val('<?= $data[0]['USERNAME']?>')
$('.edit-form').find('[name=user]').select2({width:"100%"});
</script>