<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Chqs In Hand Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("financial-reports/chqs-in-hand/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
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
	<input type="radio" id="dtype1"  checked="checked" name="dtype" value="1" class="md-radiobtn">
	<label for="dtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Entry Date</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="dtype3" name="dtype" value="3" class="md-radiobtn">
	<label for="dtype3">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Clearing Date</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="dtype2" name="dtype" value="2" class="md-radiobtn">
	<label for="dtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Delivery Date</b></label>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="form-group">
	<div class="row">
		
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
	<span class="box"></span><b>Cleared</b></label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rtype4" name="rtype"  value="3" class="md-radiobtn">
	<label for="rtype4">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Not Assigned</b></label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rtype5" name="rtype"  value="4" class="md-radiobtn">
	<label for="rtype5">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Un Posted</b></label>
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
	<select name="party[]"  id="party" class="form-control select2"  data-allow-clear="true" data-placeholder="Select Party" multiple>
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
	<div class="form-group">
	<div class="row">
	<div class="col-sm-6">
	<label class="control-label col-md-4">Agents <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="agents[]"  id="agents" class="form-control select2"  data-allow-clear="true" data-placeholder="Select Agents" multiple>
	<optgroup label="Accounts">
	<?php 
	if(count($account)){
	foreach($account as $g){
	?>
	<option value="<?= $g['ACODE'];?>"><?= $g['ACODE']." - ".$g['ANAME']; ?></option>
	<?php
	}
	}
	?>
	</optgroup>
	</select>
	</div>
	</div>
	
	<div class="col-sm-6" disable-enable="agents" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="agtype1" name="agtype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="agtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="agtype2" name="agtype"  value="1" class="md-radiobtn disable-enable">
	<label for="agtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-sm-6">
	<label class="control-label col-md-4">Bank <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="bank[]"  id="bank" class="form-control select2"  data-allow-clear="true" data-placeholder="Select Banks" multiple>
	<optgroup label="Banks">
	<?php 
	if(count($bank)){
	foreach($bank as $g){
	?>
	<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
	<?php
	}
	}
	?>
	</optgroup>
	</select>
	</div>
	</div>
	
	<div class="col-sm-6" disable-enable="bank" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="btype1" name="btype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="btype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="btype2" name="btype"  value="1" class="md-radiobtn disable-enable">
	<label for="btype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<div class="row">
	<div class="col-sm-6">
	<label class="control-label col-md-4">Cheque No <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="chqno[]"  id="chqno" class="form-control select2"  data-allow-clear="true" data-placeholder="Select Cheque Nos" multiple>
	<optgroup label="Cheque No">
	<?php 
	if(count($chqno)){
	foreach($chqno as $g){
	?>
	<option value="<?= $g['CHQNO'];?>"><?= $g['CHQNO']; ?></option>
	<?php
	}
	}
	?>
	</optgroup>
	</select>
	</div>
	</div>
	
	<div class="col-sm-6" disable-enable="chqno" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="ctype1" name="ctype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="ctype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="ctype2" name="ctype"  value="1" class="md-radiobtn disable-enable">
	<label for="ctype2">
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