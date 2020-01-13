<div class="row margin-0">


<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> LC Account<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" value="<?= $data1[0]['LCCODE']?>" name="lccode">
<input type="text" value="<?= $data1[0]['LCNAME']?>" readonly class="form-control" name="lcname" placeholder="LC Account">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Party<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="hidden" value="<?= $data1[0]['VCODE']?>" name="vcode">
<input type="text" value="<?= $data1[0]['VNAME']?>" readonly class="form-control" name="vname" placeholder="Party">
</div>
</div>
</div>

<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Bond</label>
<div class="col-md-12 show-error">
<select name="lcbond" id="lcbond" class="form-control select2 move-enter-up move-enter-16" data-position="16">
<option value="">Select Bond</option>
<?php 
if(count($lcbond)){
foreach($lcbond as $g){
?>
<option value="<?= $g['ID'];?>"><?= $g['LCBOND']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>

</div>

<input type="hidden" name="qty" data-sum="tqty" />
<input type="hidden" name="weight" data-sum="tweight" />
<input type="hidden" name="amount" data-sum="tamount" />
<input type="hidden" name="overhead" data-sum="toverhead" />
<input type="hidden" name="total" data-sum="net" />

<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th style="width:20%";>Product</th>
<th style="width:10%";>Unit</th>
<th style="width:10%";>Coil</th>
<th style="width:10%";>Qty(MT)</th>
<th style="width:10%";>Weight(MT)</th>
<th style="width:10%";>PKR Rate(MT)</th>
<th style="width:10%";>PKR Amount(MT)</th>
<th style="width:10%";>Overhead</th>
<th style="width:10%";>Total</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data2 as $row):
if($expense[0]['EXPE']==""){
$expenses=0;	
}
else{
$expenses=$expense[0]['EXPE'];	
}
if($expense[0]['TWT']=="" || $expense[0]['TWT']==0){
$expense[0]['TWT']=1;	
}
$titemexp=round($expenses/$expense[0]['TWT'],2);
$ohead=round($titemexp * $row['WEIGHT'],2);
$total=$ohead+$row['AMOUNT'];
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" ><?= $rowNumber;?></td>
    <td><span><?= $row['PNAME'];?></span>
        <input type="hidden" name="pname_<?= $rowNumber;?>" value="<?= $row['PNAME'];?>" hidden-data="pcode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="pcode_<?= $rowNumber;?>" value="<?= $row['PCODE'];?>">
    </td>
    <td><span><?= $row['UNIT'];?></span>
        <input type="hidden" name="unit_<?= $rowNumber;?>" value="<?= $row['UNIT'];?>" class="form-control">
    </td>
	 <td><span><?= $row['COIL'];?></span>
        <input type="hidden" name="coil_<?= $rowNumber;?>" value="<?= $row['COIL'];?>" class="form-control">
    </td>
	 <td><span><?= $row['QTY'];?></span>
        <input type="hidden" name="qty_<?= $rowNumber;?>" value="<?= $row['QTY'];?>" class="form-control sum_qty">
    </td>
    <td><span><?= $row['WEIGHT'];?></span>
        <input type="hidden" name="weight_<?= $rowNumber;?>" value="<?= $row['WEIGHT'];?>" class="form-control sum_weight">
    </td>
    <td><span><?= $row['RATE'];?></span>
        <input type="hidden" name="rate_<?= $rowNumber;?>" value="<?= $row['RATE'];?>" class="form-control">
    </td>
    <td><span><?= $row['AMOUNT'];?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= $row['AMOUNT'];?>" class="form-control sum_amount">
    </td>
    <td><span><?= $ohead;?></span>
        <input type="hidden" name="overhead_<?= $rowNumber;?>" value="<?= $ohead;?>" class="form-control sum_overhead">
    </td>
    <td><span><?= $total;?></span>
        <input type="hidden" name="total_<?= $rowNumber;?>" value="<?= $total;?>" class="form-control sum_total">
    </td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="4">Total</th>
<td class="theme-bg"><input type="text" name="tqty" /></td>
<td class="theme-bg"><input type="text" name="tweight" /></td>
<td colspan="1"></td>
<td class="theme-bg"><input type="text" name="tamount" /></td>
<td class="theme-bg"><input type="text" name="toverhead" /></td>
<td class="theme-bg"><input type="text" name="net" /></td>
</tr>
</tfoot>
</table>
</div>
<script>
reinitializeTable(<?= $rowNumber;?>);
$(document).find("[name=lcbond]").val(<?= $data1[0]['BNID']?>);
$(document).find("[name=lcbond]").select2();
</script>