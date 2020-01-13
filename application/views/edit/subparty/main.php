<div class="row">

<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Add Sub Party</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal list-refresh" role="form">
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" placeholder="Username">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Address</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="addr" placeholder="addr">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Mobile</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="mob" placeholder="mob">
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Customer</label>
<div class="col-md-9 show-error">
<select name="customer" id="customer" class="form-control">
<option value="">Select Customer</option>
<?php 
if(count($customer)){
foreach($customer as $g){
?>
<option value="<?= $g['VCODE']; ?>"><?= $g['VNAME']; ?></option>
<?php
}
}
?>

</select>
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
<label class="col-md-3 control-label">Credit Limit</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="limit" placeholder="limit">
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