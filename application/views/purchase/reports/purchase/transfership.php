<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Transfer Shipment Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("purchase-reports/transfership-report/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
	<div class="form-body">
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-4">As On <i class="icon-calendar theme-color"></i></label>
	<div class="col-md-8 show-error">
	<input class="form-control date-range-picker" size="16" type="text"  name="date" value="<?= "01/07/2019 - ".date("d/m/Y")?>" />
	</div>
	</div>
	</div>
	<div class="col-sm-6">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="rtype1" name="rtype" value="1" class="md-radiobtn">
	<label for="rtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Summary</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rtype2" name="rtype"  checked="checked" value="2" class="md-radiobtn">
	<label for="rtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Detailed</b> </label>
	</div>
	</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-4">Order By <i class="icon-menu theme-color"></i></label>
	<div class="col-md-8 show-error"> 
	<div class="md-radio-inline">
	<div class="md-radio has-error">
	<input type="radio" id="ortype1" name="ortype" checked="checked" value="1" class="md-radiobtn">
	<label for="ortype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Supplier</b> </label>
	</div>
	<div class="md-radio has-error">
	<input type="radio" id="ortype2" name="ortype"  value="2" class="md-radiobtn">
	<label for="ortype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Design</b> </label>
	</div>
	
	</div>
	</div>
	</div>
	</div>
	</div>
	
	<div class="row" style="display:none">
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
	<label class="control-label col-md-4">Supplier <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="party[]"  id="party" class="form-control select2" data-allow-clear="true" data-placeholder="Select Supplier" multiple>
	<?php 
	if(count($party)){
	foreach($party as $g){
	?>
	<option value="<?= $g['VCODE'];?>"><?= $g['VCODE']."-".$g['VNAME']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	</div>
	</div>
	
	<div class="col-sm-4" disable-enable="party" disable-at="0" enable-at="1">
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
	
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="control-label col-md-4">Design <i class="icon-basket theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="product[]"  id="product" class="form-control select2" data-allow-clear="true" data-placeholder="Select Design" multiple>
	<?php 
	if(count($product)){
	foreach($product as $g){
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
	
	<div class="col-sm-6" disable-enable="product" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="prtype1" name="prtype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="prtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="prtype2" name="prtype"  value="1" class="md-radiobtn disable-enable">
	<label for="prtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	<div class="md-radio has-info" style="display: none;">
	<a class="btn" data-toggle="collapse" data-parent="#more-products" href="#more_products">More Product Options <i class="icon-arrow-down-circle"></i></a>
	</div>
	</div>
	</div>
	</div>
	
   <div class="row">
	<div class="col-sm-6">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="rty1" name="rty" value="0" checked="checked" class="md-radiobtn">
	<label for="rty1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Pending</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="rty2" name="rty"   value="1" class="md-radiobtn">
	<label for="rty2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Complete</b> </label>
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
<script>
$(window).on("load",function(){	
});
</script>