<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['BCODE']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Branch</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" value="<?= $data[0]['BNAME']?>"  placeholder="Branch">
</div>
</div>


</div>
<div class="form-actions">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</form>