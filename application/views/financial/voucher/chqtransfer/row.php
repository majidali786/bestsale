<?php
$rowNumber=1; 
foreach($data as $row):
if(!empty($row['CHQDATE'])){
$row['CHQDATE']=date("d/m/Y",strtotime($row['CHQDATE']));	
}
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<?= $rowNumber;?>
	</td>
    <td><span><?= $row['ACODE']."-".$row['ANAME'];?></span>
        <input type="hidden" name="aname_<?= $rowNumber;?>" value="<?= $row['ACODE']."-".$row['ANAME'];?>" hidden-data="acode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="acode_<?= $rowNumber;?>" value="<?= $row['ACODE'];?>">
    </td>
	<td><span><?= $row['BNAME'];?></span>
        <input type="hidden" name="bank_<?= $rowNumber;?>" value="<?= $row['BNAME'];?>" hidden-data="bcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="bcode_<?= $rowNumber;?>" value="<?= $row['BCODE'];?>">
    </td>
    <td><span><?= $row['DESCR'];?></span>
        <input type="hidden" name="descrip_<?= $rowNumber;?>" value="<?= $row['DESCR'];?>" class="form-control">
    </td>
    <td><span><?= $row['CHQNO'];?></span>
        <input type="hidden" name="chqNo_<?= $rowNumber;?>" value="<?= $row['CHQNO'];?>" class="form-control">
    </td>
	<td><span><?= $row['CHQDATE'];?></span>
        <input type="hidden" name="chqDate_<?= $rowNumber;?>" value="<?= $row['CHQDATE'];?>" class="form-control">
    </td>
    <td><span><?= $row['DEBIT'];?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['DEBIT'];?>" class="form-control sum_amount">
    </td>
	<td>
	<div class="list-icon-container done">
	<div class="md-checkbox has-error">
	<input type="checkbox" id="incChq_<?= $rowNumber;?>" name="incChq_<?= $rowNumber;?>" value="1" class="md-check chqs-checks">
	<label for="incChq_<?= $rowNumber;?>">
	<span></span>
	<span class="check"></span>
	<span class="box"></span></label>
	</div>
	</div>
    </td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
<script>
reinitializeTable(<?= $rowNumber;?>);	
</script>