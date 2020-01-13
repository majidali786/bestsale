
<?php
$rowNumber=1; 
foreach($dcdata as $row):
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<a class="btn btn-sm theme-bg" style="padding: 0px 5px;"><?= $rowNumber;?></a>
	</td>
    <td style="width:40%"><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td style="width:10%"><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
    <td style="width:10%" class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['WEIGHT'])?>"><span><?= lakhseparater($row['WEIGHT'],2);?></span>
        <input type="hidden" name="weight_<?= $rowNumber;?>" value="<?= lakhseparater($row['WEIGHT'],2);?>" class="form-control sum_weight">
    </td>
    <td style="width:10%" class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['QTY'])?>"><span><?= lakhseparater($row['QTY'],2);?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= lakhseparater($row['QTY'],2);?>" class="form-control sum_qty">
    </td>

    <td style="width:10%" class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['RATE'])?>"><span><?= lakhseparater($row['RATE'],2);?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= lakhseparater($row['RATE'],2);?>" class="form-control">
    </td>
    <td style="width:10%" class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['AMOUNT'])?>"><span><?= lakhseparater($row['AMOUNT']);?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= lakhseparater($row['AMOUNT'],2);?>" class="form-control sum_amount">
    </td>
</tr>
<script>
</script>
<?php 
$rowNumber ++;
endforeach;
?>


<script>
reinitializeTable(<?= $rowNumber;?>);
</script>