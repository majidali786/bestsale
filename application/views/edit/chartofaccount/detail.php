<input type="hidden" name="id" value="<?= $data[0]['ACODE']?>" />
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
else if($data[0]['ATYPE']==2){
?>
<div class="form-group">
<div class="col-md-12">
<div class="note note-success">
<p>Click Button to Edit Employee Details <button type="button" class="btn edit-employee"><i class="icon-pencil"></i></button></p>
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
<h4><?= $data[0]['ANAME']?></h4>
</div>
</div>
</div>
