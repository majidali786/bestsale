<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">User Activity Report(Log Report)</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("financial-reports/user-log/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body">
	<div class="form-group">
	<div class="row">
	<div class="col-sm-4">
	<label class="control-label col-md-4">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-8 show-error">
	<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/01/2017 - ".date("d/m/Y")?>" />
	</div>
	</div>
		
	    <?php 
	if($user['U_TYPE']==0 || $user['UB_ID']==1)
	{	
	?>
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-4">Branch <i class="icon-home theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="branch"  id="branch" class="form-control select2">
		<option value="0">Accumulated (All)</option>
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
		<?php 
	}
	else{
	?>
	<input type="hidden" name="branch"  id="branch" value="<?= $user['B_ID']?>">
	<?php 
	}
	?>
	<div class="col-sm-4">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="rtype1" name="rtype" value="1" class="md-radiobtn">
	<label for="rtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Date</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rtype2" name="rtype" checked="checked" value="2" class="md-radiobtn">
	<label for="rtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span><b>Type</b></label>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="form-group">
	<div class="row">
	<div class="col-sm-4">
	<label class="control-label col-md-4">User <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="users[]"  id="users" class="form-control select2" data-allow-clear="true" data-placeholder="Select Employee" multiple>
	<?php 
	if(count($ausers)){
	foreach($ausers as $g){
	?>
	<option value="<?= $g['USERNAME'];?>"><?= $g['USERNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	<div class="col-sm-2" disable-enable="users" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="utype1" name="utype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="utype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="utype2" name="utype"  value="1" class="md-radiobtn disable-enable">
	<label for="utype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	
	<div class="col-sm-4">
	<label class="control-label col-md-4">V Type <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="vtype[]"  id="vtype" class="form-control select2" data-allow-clear="true" data-placeholder="Select V type" multiple>
	<?php 
	if(count($joInWords)){
	foreach($joInWords as $g=>$a){
	?>
	<option value="<?= $g;?>"><?= $a; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	
	<div class="col-sm-2" disable-enable="vtype" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="vttype1" name="vttype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="vttype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="vttype2" name="vttype"  value="1" class="md-radiobtn disable-enable">
	<label for="vttype2">
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
	<div class="col-sm-4">
	<label class="control-label col-md-4">V.No <i class="icon-magnifier theme-color"></i></label>
	<div class="col-md-8 show-error">
	<input class="form-control" type="text"  name="vno" Placeholder="Voucher No. For Search" />
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