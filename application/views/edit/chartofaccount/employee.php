<style>
label > a {
	text-decoration: none !important;
}
.col-sm-1 > i{
	margin-top:6px;
	cursor:pointer;
}			

   
.image-preview {
  width: 100px;
  height: 100px;
  position: relative;
  overflow: hidden;
  background-color: #ffffff;
  color: #ecf0f1;
  border:1px solid #ccc;
  border-radius:10px;
  -webkit-box-shadow:1px 1px 6px 2px #ccc; 
  -moz-box-shadow:1px 1px 6px 2px #ccc;  
   box-shadow:1px 1px 6px 2px #ccc; 
}
.image-preview input {
  line-height: 50px;
  font-size: 50px;
  position: absolute;
  opacity: 0;
  z-index: 10;
}
.image-preview label {
  position: absolute;
    z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    background-color: #bdc3c7;
    width: 50px;
    height: 48px;
    font-size: 23px;
    padding-top: 12px;
    text-transform: uppercase;
    top: 0px;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    text-align: center;
    border-radius: 30px;
}
.image-preview >image-label>i:before{
cursor: pointer;	
}
.image-remove{
	z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    background-color: #bdc3c7;
    width: 20px;
    height: 20px;
    font-size: 19px;
    border-radius: 30px;
    right: 2px;
    position: absolute;
    top: 3px;
    padding-left: 2px;	
}
.image-edit{
	z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    background-color: #bdc3c7;
    width: 20px;
    height: 20px;
    font-size: 15px;
    border-radius: 30px;
    left: 2px;
    position: absolute;
    top: 3px;
    padding-left: 3px;	
    padding-top: 1px;	
}
.brokerage{
padding-left:0px;
padding-top:15px;	
}
</style>

<form class="form-horizontal action-url-extra edit-form" role="form" action="<?= base_url("chart-of-account-details/employee");?>" onsubmit="return false" >
<input type="hidden" name="id" value="<?= $id;?>" />

<div class="form-body">
<div class="form-group">
<div class="col-md-12">
<div class="note note-success">
<h3 style="margin:0;text-align:center"><b><i class="icon-badge"></i> <?= $name[0]['ANAME']?></b></h3>
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">



<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Full Name</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="e_fullname" placeholder="Full Name" name="e_fullname" >
</div>
</div> 

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Address</label>
<div class="col-md-9 show-error">
<textarea type="text" class="form-control" id="e_addr" placeholder="Address" name="e_addr"	style="resize:none;"></textarea>
</div>
</div>



<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Mobile</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control" id="e_mnum" placeholder="Mobile" name="e_mnum" >
</div>

<label for="field-1" class="col-md-3 control-label" style="color:black;">Mobile 2</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control" id="e_mnum2" placeholder="Mobile 2" name="e_mnum2" >
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Visa Date</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control date-picker" id="e_vdate" placeholder="dd/mm/yyyy" name="e_vdate" >
</div>
<label for="field-1" class="col-md-3 control-label" style="color:black;">Visa Expiry</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control date-picker" id="e_vedate" placeholder="dd/mm/yyyy" name="e_vedate" >
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Emergency No.</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="e_emergency" placeholder="Emergency" name="e_emergency" >
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Email</label>

<div class="col-md-9 show-error">
<input type="Email" class="form-control" id="e_mail" placeholder="Email" name="e_mail" >
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Cnic</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="e_cnic" placeholder="Cnic" name="e_cnic" >
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">City</label>

<div class="col-md-9 show-error">
<select name="e_city"  id="e_city" class="form-control select2">
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
<label for="field-1" class="col-md-3 control-label" style="color:black;">Branch</label>

<div class="col-md-9 show-error">
<select name="e_branch"  id="e_branch" class="form-control select2">
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




</div>

<div class="col-md-6">

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Father Name</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="e_father" placeholder="Father Name" name="e_father" >
</div>
</div> 

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Blood Group</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="e_bgroup" placeholder="Blood Group" name="e_bgroup" >
</div>
</div> 


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Reference</label>

<div class="col-md-9 show-error">
<input type="text" class="form-control" id="e_ref" placeholder="Reference" name="e_ref" >
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">DOB</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control date-picker" id="e_dob" placeholder="dd/mm/yyyy" name="e_dob" >
</div>
<label for="field-1" class="col-md-3 control-label" style="color:black;">Joing Date</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control date-picker" id="e_jdate" placeholder="dd/mm/yyyy" name="e_jdate" >
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Passport Date</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control date-picker" id="e_pdate" placeholder="dd/mm/yyyy" name="e_pdate" >
</div>
<label for="field-1" class="col-md-3 control-label" style="color:black;">Expiry Date</label>

<div class="col-md-3 show-error">
<input type="text" class="form-control date-picker" id="e_edate" placeholder="dd/mm/yyyy" name="e_edate" >
</div>
</div>



<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Department</label>

<div class="col-md-9 show-error">
<select name="e_department"  id="e_department" class="form-control select2">
<option value="">Select Department</option>
<?php 
if(count($department)){
foreach($department as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['UDEPT']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Designation</label>

<div class="col-md-9 show-error">
<select name="e_designation"  id="e_designation" class="form-control select2">
<option value="">Select Designation</option>
<?php 
if(count($designation)){
foreach($designation as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['UDESIG']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>


<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Username</label>

<div class="col-md-9 show-error">
<select name="e_user"  id="e_user" class="form-control select2">
<option value="">Select Username</option>
<?php 
if(count($users)){
foreach($users as $g){
?>
<option value="<?= $g['USERNAME'];?>"><?= $g['USERNAME']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label for="field-1" class="col-md-3 control-label" style="color:black;">Status</label>

<div class="col-md-9 show-error">
<select name="e_status"  id="e_status" class="form-control select2">
<option value="">Select Status</option>
<option value="0">Permanent</option>
<option value="1">Temporary</option>
<option value="2">Daily Wages</option>
<option value="3">Contract</option>
</select>
</div>
</div>


<div class="form-group" style="display:none;">
		<label class="control-label col-sm-3">Image</label>
			<div class="col-sm-6  show-error">
				<div class="image-preview">
				     <input type="file" name="img" id="img" accept="image/*" class="image-input" />
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
<script src="<?php echo base_url("assets/global/scripts/jquery.uploadPreview.min.js")?>">
</script>
	<script>
	$('.image-preview').uploadPreview();
	</script>
<script>

$.fn.select2.defaults.set("theme", "bootstrap");
var thisFrom=$('.action-url-extra');
<?php 
if(!empty($employee)){
$dob="";
if($employee[0]['DOB']!=""){
$dob=date("d/m/Y",strtotime($employee[0]['DOB']));	
}
$jdate="";
if($employee[0]['DOB']!=""){
$jdate=date("d/m/Y",strtotime($employee[0]['JDATE']));	
}
if($employee[0]['DOB']!=""){
$psdate=date("d/m/Y",strtotime($employee[0]['PSDATE']));	
}
if($employee[0]['DOB']!=""){
$exdate=date("d/m/Y",strtotime($employee[0]['EXDATE']));	
}
if($employee[0]['DOB']!=""){
$vsdate=date("d/m/Y",strtotime($employee[0]['VSDATE']));	
}
if($employee[0]['DOB']!=""){
$vxdate=date("d/m/Y",strtotime($employee[0]['VXDATE']));	
}

if($dob=='01/01/1970'){
$dob="";	
}
if($jdate=='01/01/1970'){
$jdate="";	
}
if($psdate=='01/01/1970'){
$psdate="";	
}
if($exdate=='01/01/1970'){
$exdate="";	
}

if($vsdate=='01/01/1970'){
$vsdate="";	
}
if($vxdate=='01/01/1970'){
$vxdate="";	
}
	
?>


thisFrom.find('[name=e_fullname]').val('<?= $employee[0]['FULLNAME']?>');
thisFrom.find('[name=e_mnum2]').val('<?= $employee[0]['MOBILE2']?>');
thisFrom.find('[name=e_cnic]').val('<?= $employee[0]['CNIC']?>');
thisFrom.find('[name=e_city]').val('<?= $employee[0]['CID']?>');
thisFrom.find('[name=e_branch]').val('<?= $employee[0]['BID']?>');
thisFrom.find('[name=e_father]').val('<?= $employee[0]['FATHER']?>');
thisFrom.find('[name=e_bgroup]').val('<?= $employee[0]['BGROUP']?>');
thisFrom.find('[name=e_addr]').val('<?= $employee[0]['ADDR']?>');
thisFrom.find('[name=e_mnum]').val('<?= $employee[0]['MOBILE']?>');
thisFrom.find('[name=e_emergency]').val('<?= $employee[0]['EMERGENCY']?>');
thisFrom.find('[name=e_mail]').val('<?= $employee[0]['EMAIL']?>');
thisFrom.find('[name=e_ref]').val('<?= $employee[0]['REFERENCE']?>');
thisFrom.find('[name=e_dob]').val('<?= $dob?>');
thisFrom.find('[name=e_jdate]').val('<?= $jdate?>');
thisFrom.find('[name=e_pdate]').val('<?= $psdate?>');
thisFrom.find('[name=e_edate]').val('<?= $exdate?>');
thisFrom.find('[name=e_vdate]').val('<?= $vsdate?>');
thisFrom.find('[name=e_vedate]').val('<?= $vxdate?>');
thisFrom.find('[name=e_department]').val('<?= $employee[0]['DPID']?>');
thisFrom.find('[name=e_designation]').val('<?= $employee[0]['DSID']?>');
thisFrom.find('[name=e_user]').val('<?= $employee[0]['USERNAME']?>');
thisFrom.find('[name=e_status]').val('<?= $employee[0]['STATUS']?>');
thisFrom.find('[name=img]').val('<?= $employee[0]['IMG']?>');
<?php 	
}
?>
thisFrom.find('.select2').select2({width:"100%"});
thisFrom.find(".date-picker").datepicker({rtl:App.isRTL(),orientation:"left",autoclose:!0,format:"dd/mm/yyyy",todayHighlight:true});
</script>