<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Promise Details</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("customer-reports/promise-details/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body">
	<div class="form-group">
	<div class="row">
	<div class="col-sm-6">
	<label class="control-label col-md-4">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-8 show-error">
	<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/01/2017 - ".date("d/m/Y")?>" />
	</div>
	</div>
	
	<div class="col-sm-6">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="dtype1" name="dtype" value="1" class="md-radiobtn">
	<label for="dtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Voucher Date</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="dtype2"  checked="checked" name="dtype" value="2" class="md-radiobtn">
	<label for="dtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Promise Date</b></label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="dtype3" name="dtype" value="3" class="md-radiobtn">
	<label for="dtype3">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Promise Make Date</b></label>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="form-group">
	<div class="row">
	<?php 
	if($user['U_TYPE']==0 || $user['UB_ID']==1)
	{	
	?>	
	<div class="col-sm-6">
	<label class="control-label col-md-4">Branch <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
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
	<?php 
	}
	else{
	?>
	<input type="hidden" name="branch"  id="branch" value="<?= $user['B_ID']?>">
	<?php 
	}
	?>
	
	<div class="col-sm-6">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="rtype1" checked="checked" name="rtype" value="2" class="md-radiobtn">
	<label for="rtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rtype2" name="rtype"  value="1" class="md-radiobtn">
	<label for="rtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Pending</b></label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rtype3" name="rtype"  value="0" class="md-radiobtn">
	<label for="rtype3">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Closed</b></label>
	</div>
	</div>
	</div>
	
	</div>
	</div>
	<div class="form-group">
	<div class="row">
	<div class="col-sm-6">
	<label class="control-label col-md-4">Party <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="party[]"  id="party" class="form-control select2"  data-allow-clear="true" data-placeholder="Select Account" multiple>
	<optgroup label="Customers">
	<?php 
	if(count($party)){
	foreach($party as $g){
	?>
	<option value="<?= $g['VCODE'];?>"><?= $g['VCODE']." - ".$g['VNAME']; ?></option>
	<?php
	}
	}
	?>
	</optgroup>
	</select>
	</div>
	</div>
	
	<div class="col-sm-6" disable-enable="party" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="ptype1" name="ptype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="ptype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="ptype2" name="ptype"  value="1" class="md-radiobtn disable-enable">
	<label for="ptype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
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