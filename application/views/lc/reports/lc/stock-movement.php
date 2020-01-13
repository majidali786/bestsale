<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Stock Movement Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("lc-reports/stock-movement/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body row">
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-4">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-8 show-error">
	<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/01/2017 - ".date("d/m/Y")?>" />
	</div>
	</div>
	</div>
	
	<div class="col-sm-4">
	<div class="form-group">
	<label class="control-label col-md-4">LC No <i class="icon-home theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="lcno[]"  id="lcno" class="form-control select2" data-allow-clear="true" data-placeholder="Select LC No." multiple>
	<?php 
	if(count($lcno)){
	foreach($lcno as $g){
	?>
	<option value="<?= $g['LCNO'];?>"><?= $g['LCNO']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	<div class="col-sm-4" disable-enable="lcno" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="lctype1" name="lctype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="lctype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="lctype2" name="lctype"  value="1" class="md-radiobtn disable-enable">
	<label for="lctype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
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