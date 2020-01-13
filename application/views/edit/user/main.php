<div class="row">

<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Add User</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal list-refresh" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Username</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" placeholder="Username">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Password</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="password" placeholder="Password">
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
<div class="form-actions right1">
<button type="submit" class="btn green">Submit</button>
<button type="reset" class="btn default">Reset</button>
</div>
</form>
</div>
</div>
</div>
<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-list font-white"></i>
<span class="caption-subject font-white bold uppercase">List User</span>
</div>
<div class="actions">
<a class="btn btn-circle btn-icon-only btn-default loadlist" href="javascript:;">
<i class="icon-refresh"></i>
</a>
 <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" data-list-load>

</div>
</div>
</div>

</div>