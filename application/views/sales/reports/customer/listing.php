<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Customer Listing Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("customer-reports/listing/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body">
	<input type="hidden" id="check1" name="check1" value="1">
	<div class="form-group">
	<div class="row">
	
	<div class="col-sm-4">
	<label class="control-label col-md-4">Branch <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="branch[]"  id="branch" class="form-control select2" data-allow-clear="true" data-placeholder="Select Branch" multiple>
	<?php 
	if(count($branch)){
	foreach($branch as $a){
	?>
	<option value="<?= $a['BCODE'];?>"><?= $a['BNAME'] ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	
	<div class="col-sm-2" disable-enable="branch" disable-at="0" enable-at="1">
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
	
	<div class="col-sm-4">
	<label class="control-label col-md-4">Salesman <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="salesman[]"  id="salesman" class="form-control select2" data-allow-clear="true" data-placeholder="Select Salesman" multiple>
	<?php 
	if(count($salesman)){
	foreach($salesman as $a){
	?>
	<option value="<?= $a['BCODE'];?>"><?= $a['BNAME'] ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	
	<div class="col-sm-2" disable-enable="salesman" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="stype1" name="stype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="stype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="stype2" name="stype"  value="1" class="md-radiobtn disable-enable">
	<label for="stype2">
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
	<label class="control-label col-md-4">City <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="city[]"  id="city" class="form-control select2" data-allow-clear="true" data-placeholder="Select City" multiple>
	<?php 
	if(count($city)){
	foreach($city as $a){
	?>
	<option value="<?= $a['CCODE'];?>"><?= $a['CNAME'] ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	
	<div class="col-sm-2" disable-enable="city" disable-at="0" enable-at="1">
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