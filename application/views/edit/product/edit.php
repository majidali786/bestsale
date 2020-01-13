<form class="form-horizontal list-refresh edit-form" role="form">
<input type="hidden" name="id" value="<?= $data[0]['PCODE']?>" />
<div class="form-body">

<div class="form-group">
<label class="col-md-3 control-label">Code</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="id" readonly placeholder="Code" title="<?= $data[0]['PCODE']?>"  value="<?= $data[0]['PCODE']?>">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="name" title="<?= $data[0]['PNAME']?>" placeholder="Name" value="<?= $data[0]['PNAME']?>">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Unit</label>
<div class="col-md-9 show-error">
<select name="unit" id="unit_e" class="form-control select2">
<option value="">Select Unit</option>
<?php 
if(count($unit)){
foreach($unit as $g){
if ($data[0]['UNIT'] == $g['UNIT']) 
{
?>
<option value="<?= $g['ID'];?>" selected><?= $g['UNIT']; ?></option>
<?php
}else{
?>
<option value="<?= $g['ID'];?>"><?= $g['UNIT']; ?></option>
<?php	
}
}
}
?>
</select>
</div>
</div>



<div class="form-group">
<label class="col-md-3 control-label">Purchase.Rate</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control"  name="prate" title="<?= $data[0]['PRATE']?>" placeholder="Purchase.Rate"   value="<?= $data[0]['PRATE']?>">
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label">Sales.Rate</label>
<div class="col-md-9 show-error">
<input type="text" class="form-control" name="srate" title="<?= $data[0]['SRATE']?>" value="<?= $data[0]['SRATE']?>" placeholder="Sales.Rate"  >
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label">Main Group</label>
<div class="col-md-9 show-error">
<select name="grp" id="grp" class="form-control select2">
<option value="">Select Main Group</option>
<?php 
if(count($mgroup)){
foreach($mgroup as $g){
if ($data[0]['GRP'] == $g['ID']) 
{
?>
<option value="<?= $g['ID'];?>" selected><?= $g['MGROUP'];?></option>
<?php
}else
{
?>
<option value="<?= $g['ID'];?>"><?= $g['MGROUP']; ?></option>
<?php
}
}
}
?>
</select>
</div>
</div>



<div class="form-group">
<label class="col-md-3 control-label">Status</label>
<div class="col-md-9 show-error">
<select name="status" id="status" class="form-control select2">
<option value="">Select Status</option>
<option value="1" <?php if($data[0]['STATUS']==1) { ?>	selected	<?php } ?> >Active</option>
<option value="0" <?php if($data[0]['STATUS']==0) { ?>	selected	<?php } ?> >InActive</option>
</select>
</div>
</div>

</div>







<div class="form-actions">
<button type="submit" class="btn green">Update</button>
<button type="button" class="btn default" data-dismiss="modal" >Close</button>
</div>
</form>
<script type="text/javascript">

</script>
