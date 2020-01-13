<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['ACODE']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Account</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" value="<?= $data[0]['ANAME']?>"  placeholder="Account">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">A/C Type</label>
<div class="col-md-9 show-error">
<select name="atype" id="atype" class="form-control select2">
<option value="">Select A/C Type</option>
<?php 
if(count($atype)){
foreach($atype as $g){
?>
<option value="<?= $g['TCODE']; ?>"><?= $g['TYPE']; ?></option>
<?php
}
}
?>
</select>
</div>
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
$('.edit-form').find('[name=atype]').val(<?= $data[0]['ATYPE']?>)
$('.edit-form').find('[name=atype]').select2({width:"100%"});
</script>