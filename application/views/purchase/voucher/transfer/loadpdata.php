
<?php
$rowNumber=1; 
foreach($dcdata as $row):
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<div class="btn-group">
	<a class="btn btn-sm theme-bg" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;" data-close-others="true" ><?= $rowNumber;?></a>
	</div>
	</td>
    <td style="width:40%"><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value='<?= $row['PNAME'];?>' hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td style="width:10%"><span><?= $row['COLOR'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['COLOR'];?>" class="form-control">
    </td>
    <td class="th-right"><span><?= $row['QTY'];?></span>
        <input type="hidden" name="orderqty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>">
    </td>
    <td class="th-right">
        <input type="text" name="qty_<?= $rowNumber;?>" onkeyup="chk_qty(<?= $rowNumber;?>)" 
		value="<?= $row['QTY'];?>" data-dmas="qty_<?= $rowNumber;?>-add,rate_<?= $rowNumber;?>-multiply,amount_<?= $rowNumber;?>-result" class="form-control th-right sum_qty">
    </td>
    <td class="th-right"><span><?= $row['STOCK'];?></span>
        <input type="hidden" name="stock_<?= $rowNumber;?>" value="<?= $row['STOCK'];?>" class="form-control">
    </td>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['RATE'] ?>">
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['AMOUNT'] ?>">
</tr>
<script>
$(document).on("change","[name=qty_<?= $rowNumber;?>]",function(){
dataSum();
});
</script>
<?php 
$rowNumber ++;
endforeach;
?>


<script>
reinitializeTable(<?= $rowNumber;?>);
</script>