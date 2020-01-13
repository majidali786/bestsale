<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['PCODE']?>" />
<div class="form-body">


<div class="form-group">
<label class="col-md-3 control-label">Main Group</label>
<div class="col-md-9 show-error">
<select name="mgroup" id="mgroup" class="form-control select2">
<?php 
if(count($mgroup)){
foreach($mgroup as $g){
?>
<option value="<?= $g['ID']."--".$g['SSMGROUP'];?>"><?= $g['SSMGROUP']; ?></option>
<?php
}
}
?>
</select>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Item Name</label>
<div class="col-md-6 show-error">
<select name="itemname" id="itemname" class="form-control select2">
<?php 
if(count($itemname)){
foreach($itemname as $g){
?>
<option value="<?= $g['ID']."--".$g['SSINAME']; ?>"><?= $g['SSINAME']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_ITEMNAME']==1){ echo "checked"; } ?> name="inc_itemname">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Size</label>
<div class="col-md-6 show-error">
<select name="size" id="size" class="form-control select2">
<?php 
if(count($size)){
foreach($size as $g){
?>
<option value="<?= $g['ID']."--".$g['SSSIZE']; ?>"><?= $g['SSSIZE']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_SIZE']==1){ echo "checked"; } ?> name="inc_size">
<span></span>
</label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label">Nature</label>
<div class="col-md-6 show-error">
<select name="nature" id="nature" class="form-control select2">
<?php 
if(count($nature)){
foreach($nature as $g){
?>
<option value="<?= $g['ID']."--".$g['SSNATURE']; ?>"><?= $g['SSNATURE']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_NATURE']==1){ echo "checked"; } ?> name="inc_nature">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Feet</label>
<div class="col-md-6 show-error">
<select name="feet" id="feet" class="form-control select2">
<?php 
if(count($feet)){
foreach($feet as $g){
?>
<option value="<?= $g['ID']."--".$g['SSFEET']; ?>"><?= $g['SSFEET']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_FEET']==1){ echo "checked"; } ?> name="inc_feet">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Unit</label>
<div class="col-md-6 show-error">
<select name="unit" id="unit" class="form-control select2">
<?php 
if(count($unit)){
foreach($unit as $g){
?>
<option value="<?= $g['ID']."--".$g['SSUNIT']; ?>"><?= $g['SSUNIT']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_UNIT']==1){ echo "checked"; } ?> name="inc_unit">
<span></span>
</label>
</div>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Weight</label>
<div class="col-md-6 show-error">
<select name="weight" id="weight" class="form-control select2">
<?php 
if(count($weight)){
foreach($weight as $g){
?>
<option value="<?= $g['ID']."--".$g['SSWEIGHT']; ?>"><?= $g['SSWEIGHT']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_WEIGHT']==1){ echo "checked"; } ?> name="inc_weight">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Others1</label>
<div class="col-md-6 show-error">
<select name="others1" id="others1" class="form-control select2">
<?php 
if(count($others1)){
foreach($others1 as $g){
?>
<option value="<?= $g['ID']."--".$g['SSOTHERS1']; ?>"><?= $g['SSOTHERS1']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_OTHERS1']==1){ echo "checked"; } ?> name="inc_others1">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Others2</label>
<div class="col-md-6 show-error">
<select name="others2" id="others2" class="form-control select2">
<?php 
if(count($others2)){
foreach($others2 as $g){
?>
<option value="<?= $g['ID']."--".$g['SSOTHERS2']; ?>"><?= $g['SSOTHERS2']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_OTHERS2']==1){ echo "checked"; } ?> name="inc_others2">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Others3</label>
<div class="col-md-6 show-error">
<select name="others3" id="others3" class="form-control select2">
<?php 
if(count($others3)){
foreach($others3 as $g){
?>
<option value="<?= $g['ID']."--".$g['SSOTHERS3']; ?>"><?= $g['SSOTHERS3']; ?></option>
<?php
}
}
else{
echo '<option value="0">None</option>';	
}
?>
</select>
</div>
<div class="col-md-3">
<div class="mt-checkbox-list">
<label class="mt-checkbox mt-checkbox-outline"> Include
<input type="checkbox" value="1" <?php if($data[0]['INC_OTHERS3']==1){ echo "checked"; } ?> name="inc_others3">
<span></span>
</label>
</div>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" title="<?= $data[0]['PNAME']?>" readonly placeholder="Name" value="<?= $data[0]['PNAME']?>">
</div>
</div>

</div>
<div class="form-actions">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</form>