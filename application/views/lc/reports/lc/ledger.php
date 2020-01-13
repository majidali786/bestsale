<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">LC Activity Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("lc-reports/activity/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
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
	<label class="control-label col-md-3">LC.NO <i class="icon-user theme-color"></i></label>
	<div class="col-md-9 show-error">
	<select name="party"  id="party" class="form-control select2">
	<option value="">Select LC.NO</option>
	<optgroup label="LC.NO">
	<?php 
	if(count($lcno)){
	foreach($lcno as $g){
	?>
	<option value="<?= $g['LCNO'];?>"><?= $g['LCNO']; ?></option>
	<?php
	}
	}
	?>
	</optgroup>
	</select>
	</div>
	</div>
	</div>
	<!--<div class="col-sm-4">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="rtype1" name="rtype" value="1" class="md-radiobtn">
	<label for="rtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Summary</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rtype2" name="rtype" checked="checked" value="2" class="md-radiobtn">
	<label for="rtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Detailed</b> </label>
	</div>
	</div>
	</div>-->
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