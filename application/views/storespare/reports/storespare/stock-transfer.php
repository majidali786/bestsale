<div class="row">

<div class="page-content-inner col-sm-12">
<div class="portlet light portlet-fit ">
<div class="portlet-title">
<div class="caption">
<i class="icon-plus font-white"></i>
<span class="caption-subject font-white bold uppercase">Stock Transfer Report</span>
</div>
</div>
<div class="portlet-body">
<form action="<?= base_url("store-and-spare-reports/stock-transfer/data")?>" class="form-horizontal form-bordered action-url" data-target="[data-load-report]">
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
	<label class="control-label col-md-4">From Department <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="fdepartment[]"  id="fdepartment" class="form-control select2" data-allow-clear="true" data-placeholder="Select From Department" multiple>
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
	
	<div class="col-sm-4" disable-enable="fdepartment" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="fdptype1" name="fdptype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="fdptype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="fdptype2" name="fdptype"  value="1" class="md-radiobtn disable-enable">
	<label for="fdptype2">
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
	<label class="control-label col-md-4">To Department <i class="icon-user theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="tdepartment[]"  id="tdepartment" class="form-control select2" data-allow-clear="true" data-placeholder="Select From Department" multiple>
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
	
	<div class="col-sm-4" disable-enable="tdepartment" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="tdptype1" name="tdptype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="tdptype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="tdptype2" name="tdptype"  value="1" class="md-radiobtn disable-enable">
	<label for="tdptype2">
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
	<label class="control-label col-md-4">Product <i class="icon-basket theme-color"></i></label>
	<div class="col-md-8 show-error">
	<select name="product[]"  id="product" class="form-control select2" data-allow-clear="true" data-placeholder="Select Product" multiple>
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
	<div class="md-radio has-info">
	<a class="btn" data-toggle="collapse" data-parent="#more-products" href="#more_products">More Product Options <i class="icon-arrow-down-circle"></i></a>
	</div>
	</div>
	</div>
	
	<div class="col-sm-12">
	<div class="panel-group accordion" id="more-products">
	<div class="panel">
	<div id="more_products" class="panel-collapse collapse">
	<div class="panel-body">
	<div class="row">
	<div class="col-sm-6">
	<div class="form-group">
	<label class="col-sm-12 control-label">Main Group</label>
	<div class="col-md-6">
	<select name="mgroup[]" id="mgroup" class="form-control select2" multiple data-allow-clear="true" data-placeholder="Select Main Group">
	<?php 
	if(count($mgroup)){
	foreach($mgroup as $g){
	?>
	<option value="<?= $g['ID'];?>"><?= $g['MGROUP']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="mgroup" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="mtype1" name="mtype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="mtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="mtype2" name="mtype"  value="1" class="md-radiobtn disable-enable">
	<label for="mtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>	

	
	<div class="form-group">
	<label class="col-md-12 control-label">Outer Dia</label>
	<div class="col-md-6 show-error">
	<select name="outerdia[]" id="outerdia" data-allow-clear="true" data-placeholder="Select Outer Dia" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($outerdia)){
	foreach($outerdia as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['OUTERDIA']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="outerdia" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="ottype1"  name="ottype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="ottype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="ottype2" name="ottype"  value="1" class="md-radiobtn disable-enable">
	<label for="ottype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	
	</div>

	
	<div class="form-group">
	<label class="col-md-12 control-label">Coil</label>
	<div class="col-md-6 show-error">
	<select name="coil[]" id="coil" data-allow-clear="true" data-placeholder="Select Coil" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($coil)){
	foreach($coil as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['COIL']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="coil" disable-at="0" enable-at="1">
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

	<div class="form-group">
	<label class="col-md-12 control-label">Gauge</label>
	<div class="col-md-6 show-error">
	<select name="gauge" id="gauge" data-allow-clear="true" data-placeholder="Select Gauge" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($gauge)){
	foreach($gauge as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['GAUGE']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="gauge" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="gatype1" name="gatype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="gatype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="gatype2" name="gatype"  value="1" class="md-radiobtn disable-enable">
	<label for="gatype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	
	</div>

	
	<div class="form-group">
	<label class="col-md-12 control-label">Unit</label>
	<div class="col-md-6 show-error">
	<select name="unit[]" id="unit" data-allow-clear="true" data-placeholder="Select Unit" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($unit)){
	foreach($unit as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['UNIT']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="unit" disable-at="0" enable-at="1">
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

	</div>

	<div class="form-group">
	<label class="col-md-12 control-label">Weight</label>
	<div class="col-md-6 show-error">
	<select name="weight[]" id="weight" data-allow-clear="true" data-placeholder="Select Weight" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($weight)){
	foreach($weight as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['WEIGHT']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="weight" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="wtype1" name="wtype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="wtype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="wtype2" name="wtype"  value="1" class="md-radiobtn disable-enable">
	<label for="wtype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>

	</div>
	<div class="col-sm-6">
	<div class="form-group">
	<label class="col-md-12 control-label">Size</label>
	<div class="col-md-6 show-error">
	<select name="size[]" id="size" data-allow-clear="true" data-placeholder="Select Size" class="form-control select2" multiple>
	<option value="">Select Size</option>
	<option value="0">None</option>
	<?php 
	if(count($size)){
	foreach($size as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['SIZE']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="size" disable-at="0" enable-at="1">
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

	<div class="form-group">
	<label class="col-md-12 control-label">Inner Dia</label>
	<div class="col-md-6 show-error">
	<select name="innerdia[]" id="innerdia" data-allow-clear="true" data-placeholder="Select Inner Dia" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($innerdia)){
	foreach($innerdia as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['INNERDIA']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="innerdia" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="intype1" name="intype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="intype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="intype2" name="intype"  value="1" class="md-radiobtn disable-enable">
	<label for="intype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<label class="col-md-12 control-label">Others</label>
	<div class="col-md-6 show-error">
	<select name="others[]" id="others" data-allow-clear="true" data-placeholder="Select Others" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($others)){
	foreach($others as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['OTHERS']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="others" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="otype1" name="otype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="otype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="otype2" name="otype"  value="1" class="md-radiobtn disable-enable">
	<label for="otype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>
	<div class="form-group">
	<label class="col-md-12 control-label">Feet</label>
	<div class="col-md-6 show-error">
	<select name="feet[]" id="feet" data-allow-clear="true" data-placeholder="Select Feet" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($feet)){
	foreach($feet as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['FEET']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="feet" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="ftype1" name="ftype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="ftype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="ftype2" name="ftype"  value="1" class="md-radiobtn disable-enable">
	<label for="ftype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>
	
	<div class="form-group">
	<label class="col-md-12 control-label">Nature</label>
	<div class="col-md-6 show-error">
	<select name="nature[]" id="nature" data-allow-clear="true" data-placeholder="Select Nature" class="form-control select2" multiple>
	<option value="0">None</option>
	<?php 
	if(count($nature)){
	foreach($nature as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['NATURE']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="nature" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="ntype1" name="ntype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="ntype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="ntype2" name="ntype"  value="1" class="md-radiobtn disable-enable">
	<label for="ntype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>

	<div class="form-group">
	<label class="col-md-12 control-label">Cr/HR Type</label>
	<div class="col-md-6 show-error">
	<select name="hrtype[]" id="hrtype" data-allow-clear="true" data-placeholder="Select Cr/HR Type" class="form-control select2" multiple>
	<option value="">Select Cr/HR Type</option>
	<option value="0">None</option>
	<?php 
	if(count($hrtype)){
	foreach($hrtype as $g){
	?>
	<option value="<?= $g['ID']; ?>"><?= $g['HRTYPE']; ?></option>
	<?php
	}
	}
	?>
	</select>
	</div>
	<div class="col-sm-6" disable-enable="hrtype" disable-at="0" enable-at="1">
	<div class="md-radio-inline">
	<div class="md-radio has-info">
	<input type="radio" id="htype1" name="htype" checked="checked" value="0" class="md-radiobtn disable-enable">
	<label for="htype1">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>All</b> </label>
	</div>
	<div class="md-radio has-info">
	<input type="radio" id="htype2" name="htype"  value="1" class="md-radiobtn disable-enable">
	<label for="htype2">
	<span class="inc"></span>
	<span class="check"></span>
	<span class="box"></span> <b>Multi</b> </label>
	</div>
	</div>
	</div>
	</div>

	</div>

	
	
	</div>
	
	
	</div>
	
	
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