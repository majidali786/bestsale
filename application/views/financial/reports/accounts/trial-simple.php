<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Trail Balance Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("financial-reports/trial-simple/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-3">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-9 show-error">
	<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/01/2017 - ".date("d/m/Y")?>" />
	</div>
	</div>
	</div>
	
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-3">Branch <i class="icon-user theme-color"></i></label>
	<div class="col-md-9 show-error">
	<select name="branch"  id="branch" class="form-control select2">
	<option value="0">Accumulated</option>
	<?php 
	if(count($branch)){
	foreach($branch as $g){
	?>
	<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-3">From Account <i class="icon-user theme-color"></i></label>
	<div class="col-md-9 show-error">
	<select name="faccount"  id="faccount" class="form-control select2">
	<option value="">Select Account</option>
	<?php 
	if(count($account)){
	foreach($account as $g){
	?>
	<option value="<?= $g['VCODE'];?>"><?= $g['VCODE'];?>-<?= $g['VNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-3">To Account <i class="icon-user theme-color"></i></label>
	<div class="col-md-9 show-error">
	<select name="taccount"  id="taccount" class="form-control select2">
	<option value="">Select Account</option>
	<?php 
	if(count($account)){
	foreach($account as $g){
	?>
	<option value="<?= $g['VCODE'];?>"><?= $g['VCODE'];?>-<?= $g['VNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	
	
	
	</div>
	<div class="form-actions right1">
	<button type="submit" class="btn green">Load Report</button>
	<button type="reset" class="btn default">Reset</button>
	</div>
	</form>

</div>
</div>
</div>
<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-list font-white"></i>
<span class="caption-subject font-white bold uppercase">Report</span>
</div>
<div class="actions">
 <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" data-load-report>

</div>
</div>
</div>

</div>