<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Stock Ledger Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("store-and-spare-reports/ledger/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body">
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-4">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-8 show-error">
	<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/01/2017 - ".date("d/m/Y")?>" />
	</div>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-4">Branch <i class="icon-home theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="branch[]"  id="branch" class="form-control select2" data-allow-clear="true" data-placeholder="Select Branch" multiple>
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
	
	<div class="col-sm-4" disable-enable="branch" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="brtype1" name="brtype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="brtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="brtype2" name="brtype"  value="1" class="md-radiobtn disable-enable">
	<label for="brtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-4">Department <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="department[]"  id="department" class="form-control select2" data-allow-clear="true" data-placeholder="Select Department" multiple>
	<?php 
	if(count($department)){
	foreach($department as $g){
	?>
	<option value="<?= $g['DPCode'];?>"><?= $g['DPName']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	<div class="col-sm-4" disable-enable="department" disable-at="0" enable-at="1">
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
	</div>
	
	
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-4">Product <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="product"  id="product" class="form-control select2">
	<option value="">Select Product</option>
	<?php 
	if(count($product)){
	foreach($product as $g){
	?>
	<option value="<?= $g['PCODE'];?>"><?= $g['PNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
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
<script>
$(window).on("load",function(){	
});
</script>