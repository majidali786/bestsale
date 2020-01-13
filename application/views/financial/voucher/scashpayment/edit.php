<form class="form-horizontal main-form edit-form" role="form" onsubmit="return false;">
<div class="form-body">

<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['EDIT']))
{
if(($voucherrights[0]['EDIT']==1 && $voucherrights[0]['UNPOSTED']==1 && empty($posted) && empty($approved)) || ($voucherrights[0]['EDIT']==1 && $voucherrights[0]['POSTED']==1 && empty($approved)) || ($voucherrights[0]['EDIT']==1 && $voucherrights[0]['APPROVED']==1)){
?>
<div class="col-sm-2">
<button type="submit" class="btn green">Update</button>
<button type="reset" class="btn default">Reset</button>
</div>
<?php 
}
}
?>
<div class="col-sm-3">
<div class="note note-danger ">
<p class="block">UnPosted By : <b><?php if(!empty($unposted)){ echo $unposted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-warning ">
<p class="block">Posted By : <b><?php if(!empty($posted)){ echo $posted[0]['U_ID']; }?></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-success">
<p class="block">Approved By : <b><?php if(!empty($approved)){ echo $approved[0]['U_ID']; }?></b></p>
</div>
</div>

</div>


<div class="row">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" style="text-align:center;" int-numbers-only name="no" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-2" data-position="2" input-mask-date  style="text-align:center;"name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Cash Acc.Code<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control" value="<?= $data[0]['CACODE']?>" name="cacode" readonly placeholder="Cash Account Code">
</div>
</div>
</div>




<div class="col-sm-4">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Cash/Bank Acc.Name<span class="required">*</span></label>
<div class="col-md-12 show-error">
<select name="caname" id="caname" change-assign-value="cacode" class="form-control select2 move-enter-up move-to-row move-enter-3" data-position="3">
<option value="">Select Cash/Bank Account Name</option>
<?php 
if(count($accountp)){
foreach($accountp as $g){
?>
<option value="<?= $g['ACODE'];?>"><?= $g['ANAME']; ?></option>
<?php
}
}
?>
</select>

</div>
</div>
</div>

<?php 
$this->load->view($loadRow);
?>

<div class="col-sm-12 data-rows flip-scroll">
<table class="table table-bordered table-striped table-condensed flip-content">
<thead class="flip-content theme-color border-theme">
<tr>
<th style="width:5px;text-align:center;">Sr#</th>
<th style="width:40px;text-align:center;">Party/Account</th>
<th style="width:10px;text-align:center;">Balance.Amount</th>
<th style="width:35px;text-align:center;">Description</th>
<th style="width:10px;text-align:center;">Amount</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data as $row):
?>
<tr data-id="<?= $rowNumber;?>">
    <td class="theme-bg theme-border text-align-center" >
	<div class="btn-group">
	<a class="btn btn-sm theme-bg" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" style="padding: 0px 5px;" data-close-others="true" ><?= $rowNumber;?></a>
	<ul class="dropdown-menu pull-right">
	<li>
	<a href="javascript:;" edit-row><i class="icon-pencil text-warning"></i> Edit </a>
	</li>
	<li>
	<a href="javascript:;" delete-row><i class="icon-trash text-danger"></i> Delete </a>
	</li>
	</ul>
	</div>
	</td>
    <td><span><?= $row['ACODE']."-".$row['ANAME'];?></span>
        <input type="hidden" name="aname_<?= $rowNumber;?>" value="<?= $row['ACODE']."-".$row['ANAME'];?>" hidden-data="acode_<?= $rowNumber;?>" class="form-control">
        <input type="hidden" name="acode_<?= $rowNumber;?>" value="<?= $row['ACODE'];?>">
    </td>
  <!--  <td>
	<?php 
	if(!empty($row['INVNO']))
	{	
	?>
	<span><?= $row['INVNO'].",".$row['INVAMT'];?></span>
        <input type="hidden" name="invoices_<?= $rowNumber;?>" value="<?= $row['INVNO'].",".$row['INVAMT'];?>" ajax-data class="form-control">
		<input type="hidden" name="select2val_invoices_<?= $rowNumber;?>" value="<?= $row['INVNO'].",".$row['INVAMT'];?>">
		<input type="hidden" name="select2show_invoices_<?= $rowNumber;?>" value="<?= $row['INVNO']." => ".$row['INVAMT'];?>">
	<?php 
	}
	else{
	?>
	<span></span>
    <input type="hidden" name="invoices_<?= $rowNumber;?>" value="" ajax-data class="form-control">
	<input type="hidden" name="select2val_invoices_<?= $rowNumber;?>" value="">
	<input type="hidden" name="select2show_invoices_<?= $rowNumber;?>" value="">
	<?php 
	}
	?>
    </td>-->
    <td><span><?= $row['INVAMT'];?></span>
        <input type="hidden" name="invAmt_<?= $rowNumber;?>" style="text-align:center;" value="<?= $row['INVAMT'];?>" class="form-control">
    </td>
    <td><span><?= $row['DESCR'];?></span>
        <input type="hidden" name="descrip_<?= $rowNumber;?>" value="<?= $row['DESCR'];?>" class="form-control">
    </td>
    <td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= numbertowords($row['DEBIT'])?>"><span><?= lakhseparater($row['DEBIT']);?></span>
        <input type="hidden" name="amount_<?= $rowNumber;?>" value="<?= lakhseparater($row['DEBIT'],2);?>" class="form-control sum_amount">
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
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>



</div>


</div>
</div>
</form>
<script>
$("[name=caname]").val(<?= $data[0]['CACODE']?>);
$(window).on("load",function(){	
reinitializeTable(<?= $rowNumber;?>);	
});
<?php 
if(!empty($dataType)){
?>
reinitializeTable(<?= $rowNumber;?>);
<?php 	
}
?>

</script>