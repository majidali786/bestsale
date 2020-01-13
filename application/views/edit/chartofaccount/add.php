<form class="form-horizontal action-url" level="<?= $level;?>" role="form" action="<?= base_url("chart-of-account-add-level/$level");?>" onsubmit="return false" >
<div class="form-body">
<div class="form-group">
<label class="col-md-3 control-label"><?= $levelName;?> Level Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" placeholder="<?= $levelName;?> Level Name" value="">
</div>
</div>
</div>
<div class="form-actions">
<button type="submit" class="btn green">Save</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</form>