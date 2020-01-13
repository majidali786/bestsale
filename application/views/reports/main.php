<table class="table table-bordered">
<tr>
<td><h2 style="text-align:center;"><?= $name?></h2></td>
</tr>
<?php 
if($type=="xls"){
?>
<tr>
<td align="center">*Click Download button <a href="<?=  $report?>" download>Download <?=  $type?></a></td>
</tr>
<?php 
}
?>
</table>
<?php 
if($type=="pdf"){
?>
<embed src="<?= $report?>" type='application/pdf' style="width:100%;min-height:500px;"></embed>
<?php 
}
?>