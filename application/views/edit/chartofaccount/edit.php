<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['ACODE']?>" />
<div class="form-body">
<?php 
if($data[0]['ATYPE']==4){
?>
<div class="form-group">
<div class="col-md-12">
<div class="note note-success">
<p>Click Button to Edit Customer Details <button type="button" class="btn edit-party"><i class="icon-pencil"></i></button></p>
</div>
</div>
</div>
<?php 
}
?>
<div class="form-group">
<label class="col-md-3 control-label">Level 1</label>
<div class="col-md-9 show-error">
<h4><?= $level1[0]['ANAME']?></h4>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Level 2</label>
<div class="col-md-9 show-error">
<h4><?= $level2[0]['ANAME']?></h4>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Level 3</label>
<div class="col-md-9 show-error">
<h4><?= $level3[0]['ANAME']?></h4>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="aname" value="<?= $data[0]['ANAME']?>"  placeholder="Name">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Account Type</label>
<div class="col-md-9 show-error">
<select name="atype" id="atype" class="form-control select2">
<option value="">Select Account Type</option>
<?php 
if(count($atype)){
foreach($atype as $g){
?>
<option value="<?= $g['ATYPE'];?>"><?= $g['ATPNAME']; ?></option>
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
$('.edit-form').find('[name=atype]').val(<?= $data[0]['ATYPE']?>)
$('.edit-form').find('[name=atype]').select2({width:"100%"});
</script>