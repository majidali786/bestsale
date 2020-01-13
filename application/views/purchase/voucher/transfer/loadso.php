<input type="hidden" name="qty" data-sum="tqty" />
<input type="hidden" name="feet" data-sum="tfeet" />
<input type="hidden" name="wght" data-sum="tweight" />
<input type="hidden" name="amount" data-sum="tamount" />
<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th>Sale Order#</th>
<th>Purchase Order#</th>
<th>Sale Order Date</th>
<th>Product</th>
<th>Unit</th>
<th>Max Weight</th>
<th>Weight</th>
<th>Max Qty</th>
<th>Qty</th>
<th>Max Feet</th>
<th>Feet</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rNumbr=0; 
$rowNumber=1; 
foreach($data as $row):

$bal=array_column($records[$rNumbr], 'bal', 'id');
$wght=array_column($records[$rNumbr], 'wght', 'id');



?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" ><?= $rowNumber;?></td>
	<td><span><?= $row['NO'];?></span>
        <input type="hidden" name="sordr_<?= $rowNumber;?>" value="<?= $row['NO'];?>" class="form-control">
    </td>
	<td><span><?= $row['PONO'];?></span>
        <input type="hidden" name="pono_<?= $rowNumber;?>" value="<?= $row['PONO'];?>" class="form-control">
    </td>
	<td><span><?= date("d/m/Y",strtotime($row['VDATE']));?></span>
        <input type="hidden" name="sodat_<?= $rowNumber;?>" value="<?= date("Y-m-d",strtotime($row['VDATE']));?>" class="form-control">
    </td>
    <td><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
	 <td><span><?= $row['MAXWGHT'];?></span><br><span style="color:red"><?= $wght[$row['PCODE']]; ?></span>
        <input type="hidden" name="maxwght_<?= $rowNumber;?>" value="<?= $row['MAXWGHT'];?>" class="form-control">
    </td>
	<td>
        <input type="text" name="wght_<?= $rowNumber;?>" <?php if($row['UNIT']=='kg') { ?> onkeyup="amt($(this).val(),<?= $rowNumber;?>);" <?php } ?> value="0" placeholder="Weight" class="form-control sum_wght">
    </td>
	
	<td><span><?= $row['MAXQTY'];?></span><br><span style="color:red"><?= $bal[$row['PCODE']]; ?></span>
        <input type="hidden" name="maxqty_<?= $rowNumber;?>" value="<?= $row['MAXQTY'];?>" class="form-control">
    </td>
	<td>
        <input type="text" name="qty_<?= $rowNumber;?>" <?php if($row['UNIT']=='pcs') { ?> onkeyup="amt($(this).val(),<?= $rowNumber;?>);" <?php } ?>  value="0" placeholder="Qty" class="form-control sum_qty">
    </td>
    <td><span><?= $row['MAXFT'];?></span>
        <input type="hidden" name="maxfeet_<?= $rowNumber;?>" value="<?= $row['MAXFT'];?>" class="form-control">
    </td>
	<td>
        <input type="text" name="feet_<?= $rowNumber;?>" <?php if($row['UNIT']=='feet') { ?> onkeyup="amt($(this).val(),<?= $rowNumber;?>);" <?php } ?>  value="0" placeholder="Feet" class="form-control sum_feet">
		<input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['RATE'];?>" class="form-control">
		<input type="hidden" name="amount_<?= $rowNumber;?>" value="" class="form-control sum_amount">
		<input type="hidden" name="lotno_<?= $rowNumber;?>" value="<?= $row['LOTNO'];?>" >
    </td>
	<!--onkeyup="amt($(this).val(),<?= $rowNumber;?>);"-->
</tr>
<script>
</script>
<?php 
$rowNumber ++;
$rNumbr ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="7">Total</th>
<td class="theme-bg"><input type="text" name="tweight" /></td>
<td colspan="1"></td>
<td class="theme-bg"><input type="text" name="tqty" /></td>
<td colspan="1"></td>

<input type="hidden" name="tamount" />
<input type="hidden" data-dmas="tamount-add,net-result,current-result,previous-add,total-result" readonly="" name="net" placeholder="Net">
<td class="theme-bg"><input type="text" name="tfeet" /></td>
</tr>
</tfoot>
</table>
</div>
<script>
reinitializeTable(<?= $rowNumber;?>);
$(document).find("[data-id]").on("keyup","input",function(){
var row=$(this).parents("[data-id]").attr("data-id");
var name=$(this).attr("name");
var a=name.split("_");	
if($(this).val()>parseFloat($('[name=max'+a[0]+'_'+row+'').val())){
$(this).val($('[name=max'+a[0]+'_'+row+'').val());	
}
dataSum();
});
</script>