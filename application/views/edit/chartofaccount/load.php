<select name="level_<?= $level?>" load-level="<?= $loadLevel?>" id="level_<?= $level?>" class="form-control select2">
<option value="">Select <?= $levelName?> Level</option>
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
<script>
$('[name=level_<?= $level?>]').select2();
</script>