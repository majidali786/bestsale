<div class="row">

<div class="page-content-inner col-sm-6">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Add Product</span>
</div>
</div>
<div class="portlet-body">
<form class="form-horizontal list-refresh" role="form">
<div class="form-body">

<div class="form-group" style="display: none;">
<label class="col-md-3 control-label">Code</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="code" readonly placeholder="Code">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" title="name" placeholder="Name">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Unit</label>
<div class="col-md-9 show-error">
<select name="unit" id="unit" class="form-control select2">
<option value="">Select Unit</option>
<?php 
if(count($unit)){
foreach($unit as $unit){
?>
<option value="<?= $unit['ID'];?>"><?= $unit['UNIT']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Purchase.Rate</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" id="prate" name="prate" title="Purchase Rate" placeholder="Purchase Rate"  >
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Sales.Rate</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" id="srate" name="srate" title="Sales Rate" placeholder="Sales Rate"  >
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Main Group</label>
<div class="col-md-9 show-error">
<select name="grp" id="grp" class="form-control select2">
<option value="">Select Main Group</option>
<?php 
if(count($mgroup)){
foreach($mgroup as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['MGROUP']; ?></option>
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
<select name="status" id="status" class="form-control select2">
<option value="">Select Status</option>
<option value="1">Active</option>
<option value="0">InActive</option>
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
<span class="caption-subject font-white bold uppercase">List Product</span>
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

<script type="text/javascript">
	$('#unit').change(function () 
	{
		var unit = this.value;
		if (unit == '1') 
		{
			$('#weight').val('1');
			$('#weight').attr('readonly', true);			
		}
		if (unit == '2') 
		{
			$('#weight').val('');
			$('#weight').attr('readonly', false);				
		}
	});

</script>
