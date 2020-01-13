
<?php
$rowNumber=1; 
foreach($dcdata as $row):
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<a class="btn btn-sm theme-bg" style="padding: 0px 5px;"><?= $rowNumber;?></a>
	</td>
    <td><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['QTY'])?>"><span><?= lakhseparater($row['QTY'],2);?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= lakhseparater($row['QTY'],2);?>" class="form-control sum_qty">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['RATE'])?>"><span><?= lakhseparater($row['RATE'],2);?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= lakhseparater($row['RATE'],2);?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['AMOUNT'])?>"><span><?= lakhseparater($row['AMOUNT']);?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= lakhseparater($row['AMOUNT'],2);?>" class="form-control sum_amount">
    </td>
    <td>
        <input type="text" name="discountper_<?= $rowNumber;?>" value="<?= $row['DISCOUNT'];?>" class="form-control"data-dmas="discountper_<?= $rowNumber;?>-add,amount_<?= $rowNumber;?>-percent-discount_<?= $rowNumber;?>,total_<?= $rowNumber;?>-clear,amount_<?= $rowNumber;?>-add,discount_<?= $rowNumber;?>-minus,total_<?= $rowNumber;?>-result,qty_<?= $rowNumber;?>-clear,gstper_<?= $rowNumber;?>-add,total_<?= $rowNumber;?>-percent-gst_<?= $rowNumber;?>,net_<?= $rowNumber;?>-clear,total_<?= $rowNumber;?>-add,gst_<?= $rowNumber;?>-add,net_<?= $rowNumber;?>-result">
    </td>
    <td>
        <input type="text" name="discount_<?= $rowNumber;?>" value="" class="form-control sum_discount" data-dmas="discountper_<?= $rowNumber;?>-add,amount_<?= $rowNumber;?>-percent-discount_<?= $rowNumber;?>,total_<?= $rowNumber;?>-clear,amount_<?= $rowNumber;?>-add,discount_<?= $rowNumber;?>-minus,total_<?= $rowNumber;?>-result,qty_<?= $rowNumber;?>-clear,gstper_<?= $rowNumber;?>-add,total_<?= $rowNumber;?>-percent-gst_<?= $rowNumber;?>,net_<?= $rowNumber;?>-clear,total_<?= $rowNumber;?>-add,gst_<?= $rowNumber;?>-add,net_<?= $rowNumber;?>-result">
    </td>
    <td>
        <input type="text" name="total_<?= $rowNumber;?>" value="" class="form-control sum_total" readonly >
    </td>
    <td>
        <input type="text" name="gstper_<?= $rowNumber;?>" value="17" class="form-control" data-dmas="discountper_<?= $rowNumber;?>-add,amount_<?= $rowNumber;?>-percent-discount_<?= $rowNumber;?>,total_<?= $rowNumber;?>-clear,amount_<?= $rowNumber;?>-add,discount_<?= $rowNumber;?>-minus,total_<?= $rowNumber;?>-result,qty_<?= $rowNumber;?>-clear,gstper_<?= $rowNumber;?>-add,total_<?= $rowNumber;?>-percent-gst_<?= $rowNumber;?>,net_<?= $rowNumber;?>-clear,total_<?= $rowNumber;?>-add,gst_<?= $rowNumber;?>-add,net_<?= $rowNumber;?>-result">
    </td>
    <td>
        <input type="text" name="gst_<?= $rowNumber;?>" value="" class="form-control sum_gst" readonly >
    </td>
    <td>
        <input type="text" name="net_<?= $rowNumber;?>" value="" class="form-control sum_net" readonly >
    </td>
    
</tr>
<script>
$(document).on("change","[name=discountper_<?= $rowNumber;?>],[name=discount_<?= $rowNumber;?>]",function(){
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