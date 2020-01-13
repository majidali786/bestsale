<form class="form-horizontal action-url-extra edit-form" role="form" action="<?= base_url("chart-of-account-details/party");?>" onsubmit="return false" >
<input type="hidden" name="id" value="<?= $vcode;?>" />

<div class="form-body">
<div class="form-group">
<div class="col-md-12">
<div class="note note-success">
<h3 style="margin:0;text-align:center"><b><?= $vname[0]['ANAME']?></b></h3>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">
<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Personal Information</h3>
</div>
<div class="panel-body">

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Address</label>
<div class="col-md-9 show-error">
<textarea type="text" class="form-control" id="p_addr" placeholder="Address" name="p_addr"	style="resize:none;"></textarea>
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Phone</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_phone" placeholder="Phone" name="p_phone" >
</div>
</div> 


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Mobile</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_mnum" placeholder="Mobile" name="p_mnum" >
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Mobile 2</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_mnum2" placeholder="Mobile 2" name="p_mnum2" >
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Email</label>

<div class="col-md-9 show-error">
<input type="Email" class="form-control" id="p_mail" placeholder="Email" name="p_mail" >
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Credit Limit</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_climit" placeholder="Credit Limit" name="p_climit" >
</div>
</div>
<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Credit Days</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_cdays" placeholder="Credit Days" name="p_cdays" >
</div>
</div>
<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">City</label>

<div class="col-md-9 show-error">
<select name="party_city"  id="party_city" class="form-control select2">
<option value="">Select City</option>
<?php 
if(count($city)){
foreach($city as $g){
?>
<option value="<?= $g['CCODE'];?>"><?= $g['CNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Salesman</label>

<div class="col-md-9 show-error">
<select name="party_sman"  id="party_sman" class="form-control select2">
<option value="">Select Salesman</option>
<?php 
if(count($sperson)){
foreach($sperson as $g){
?>
<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Branch</label>

<div class="col-md-9 show-error">
<select name="party_branch"  id="party_branch" class="form-control select2">
<option value="">Select Branch</option>
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


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Party Type</label>

<div class="col-md-9 show-error">
<select name="party_type"  id="party_type" class="form-control select2">
<option value="">Select Party Type</option>
<option value="0">Cash</option>
<option value="1">Credit</option>
</select>
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Party Status</label>

<div class="col-md-9 show-error">
<select name="party_status"  id="party_status" class="form-control select2">
<option value="">Select Party Status</option>
<option value="1">Active</option>
<option value="0">Deactive</option>
</select>
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Cheque</label>

<div class="col-md-9 show-error">
<select name="cheque_type"  id="cheque_type" class="form-control select2">
<option value="">Select Cheque Type</option>
<option value="1">Yes</option>
<option value="0">No</option>
</select>
</div>
</div>

</div>
</div>
</div>

<div class="col-md-6">

<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Office Information</h3>
</div>
<div class="panel-body">


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Address</label>
<div class="col-md-9 show-error">
<textarea type="text" class="form-control" id="p_ofaddr" placeholder="Address" name="p_ofaddr"	style="resize:none;"></textarea>
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Phone</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_ofphone" placeholder="Phone" name="p_ofphone" >
</div>
</div> 


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Mobile</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_ofmnum" placeholder="Mobile" name="p_ofmnum" >
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Email</label>

<div class="col-md-9 show-error">
<input type="Email" class="form-control" id="p_ofmail" placeholder="Email" name="p_ofmail" >
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">City</label>

<div class="col-md-9 show-error">
<select name="party_offcity"  id="party_offcity" class="form-control select2">
<option value="0">Select City</option>
<?php 
if(count($city)){
foreach($city as $g){
?>
<option value="<?= $g['CCODE'];?>"><?= $g['CNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>


</div>
</div>

<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Contact Person</h3>
</div>
<div class="panel-body">

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Contact Person</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_cperson" placeholder="Contact Person" name="p_cperson" >
</div>
</div>
<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Designation</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_cdesig" placeholder="Designation" name="p_cdesig" >
</div>
</div>
<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Mobile</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_cmob" placeholder="Mobile" name="p_cmob" >
</div>
</div>

</div>
</div>

<div class="panel panel-primary">
<div class="panel-heading">
<h3 class="panel-title">Bank Information</h3>
</div>
<div class="panel-body">

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Bank</label>
<div class="col-md-9 show-error">
<select name="party_bank"  id="party_bank" class="form-control select2">
<option value="0">Select Bank</option>
<?php 
if(count($bank)){
foreach($bank as $g){
?>
<option value="<?= $g['BCODE'];?>"><?= $g['BNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>
<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Account No.</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" id="p_bacc" placeholder="Account No." name="p_bacc" >
</div>
</div>

</div>
</div>


</div>


</div>








</div>
<div class="form-actions">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</form>
<script>
$.fn.select2.defaults.set("theme", "bootstrap");
var thisFrom=$('.action-url-extra');
<?php 
if(!empty($party)){
?>
thisFrom.find('[name=p_addr]').val('<?= $party[0]['ADDR']?>');
thisFrom.find('[name=p_mnum]').val('<?= $party[0]['MOBILE']?>');
thisFrom.find('[name=p_phone]').val('<?= $party[0]['PHONE']?>');
thisFrom.find('[name=p_mail]').val('<?= $party[0]['EMAIL']?>');
thisFrom.find('[name=p_climit]').val('<?= $party[0]['CLIMIT']?>');
thisFrom.find('[name=party_city]').val(<?= $party[0]['CID']?>);
thisFrom.find('[name=party_branch]').val(<?= $party[0]['B_ID']?>);
thisFrom.find('[name=party_sman]').val(<?= $party[0]['SID']?>);
thisFrom.find('[name=p_mnum2]').val('<?= $party[0]['MOBILE2']?>');
thisFrom.find('[name=p_cdays]').val('<?= $party[0]['CDAYS']?>');
thisFrom.find('[name=party_type]').val(<?= $party[0]['PTYPE']?>);
thisFrom.find('[name=party_status]').val(<?= $party[0]['STATUS']?>);
thisFrom.find('[name=p_ofaddr]').val('<?= $party[0]['OFADDR']?>');
thisFrom.find('[name=p_ofmnum]').val('<?= $party[0]['OFMOBILE']?>');
thisFrom.find('[name=p_ofphone]').val('<?= $party[0]['OFPHONE']?>');
thisFrom.find('[name=p_ofmail]').val('<?= $party[0]['OFEMAIL']?>');
thisFrom.find('[name=party_offcity]').val(<?= $party[0]['OFCID']?>);
thisFrom.find('[name=p_cperson]').val('<?= $party[0]['CPERSON']?>');
thisFrom.find('[name=p_cmob]').val('<?= $party[0]['CMOBILE']?>');
thisFrom.find('[name=p_cdesig]').val('<?= $party[0]['DESIG']?>');
thisFrom.find('[name=party_bank]').val(<?= $party[0]['BID']?>);
thisFrom.find('[name=p_bacc]').val('<?= $party[0]['ACCNO']?>');
thisFrom.find('[name=cheque_type]').val('<?= $party[0]['CHEQUE']?>');
<?php 	
}
?>
thisFrom.find('.select2').select2({width:"100%"});
</script>