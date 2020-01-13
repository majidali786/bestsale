<label class="col-md-3 control-label"><?= $name?></label>
<div class="col-md-9 show-error">
<select name="accounts" id="accounts" class="form-control select2">
<option value="">Select <?= $name?></option>
<?php 
if(count($data)){
foreach($data as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ANAME']; ?></option>
<?php
}
}
?>
</select>
</div>
<script>
$('[name=accounts]').select2();
</script>