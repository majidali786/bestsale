<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Employee Salary Increment Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("payroll-reports/salary-increment/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body">
	<div class="row">
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-4">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-8 show-error">
	<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/01/2017 - ".date("d/m/Y")?>" />
	</div>
	</div>
	</div>
	<div class="col-sm-2"></div>
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-4">Employee <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="employee[]"  id="employee" class="form-control select2" data-allow-clear="true" data-placeholder="Select Employee" multiple>
	<?php 
	if(count($employee)){
	foreach($employee as $g){
	?>
	<option value="<?= $g['ID'];?>"><?= $g['NAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	<div class="col-sm-2" disable-enable="employee" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="etype1" name="etype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="etype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="etype2" name="etype"  value="1" class="md-radiobtn disable-enable">
	<label for="etype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>
	<div class="row">	
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-4">Department <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="department[]"  id="department" class="form-control select2" data-allow-clear="true" data-placeholder="Select Department" multiple>
	<?php 
	if(count($department)){
	foreach($department as $g){
	?>
	<option value="<?= $g['ID'];?>"><?= $g['UDEPT']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	<div class="col-sm-2" disable-enable="department" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="dptype1" name="dptype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="dptype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="dptype2" name="dptype"  value="1" class="md-radiobtn disable-enable">
	<label for="dptype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
		
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-4">Designation <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="designation[]"  id="designation" class="form-control select2" data-allow-clear="true" data-placeholder="Select Designation" multiple>
	<?php 
	if(count($designation)){
	foreach($designation as $g){
	?>
	<option value="<?= $g['ID'];?>"><?= $g['UDESIG']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	<div class="col-sm-2" disable-enable="designation" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="dstype1" name="dstype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="dstype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="dstype2" name="dstype"  value="1" class="md-radiobtn disable-enable">
	<label for="dstype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
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