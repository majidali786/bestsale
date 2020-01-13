<form class="form-horizontal main-form" role="form" onsubmit="return false;">
<div class="form-body">


<div class="form-actions right1 row">
<?php 
if(!empty($voucherrights[0]['AD']))
{
if($voucherrights[0]['AD']==1){
?>
<div class="col-sm-2">
<button type="submit" class="btn green">Save</button>
<button type="reset" class="btn default">Reset</button>
</div>
<?php 
}
}
?>
<div class="col-sm-3">
<div class="note note-danger ">
<p class="block">UnPosted By : <b></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-warning ">
<p class="block">Posted By : <b></b></p>
</div> 
</div> 
<div class="col-sm-3">
<div class="note note-success">
<p class="block">Approved By : <b></b></p>
</div>
</div>
</div>


<div class="row">
<div class="row margin-0">
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher No.<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-start move-enter-1" data-position="1" int-numbers-only name="no" style="text-align:center" value="<?= $max;?>" placeholder="Voucher No.">
</div>
</div>
</div>
<div class="col-sm-2">
<div class="form-group">
<label class="col-md-12 control-label"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Voucher Date<span class="required">*</span></label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-enter-2" style="text-align:center" data-position="2" input-mask-date name="vdate" value="<?= $vdate?>" placeholder="dd/mm/yyyy">
</div>
</div>
</div>

<div class="col-sm-8">
<div class="form-group">
<label class="col-md-12 control-label lable-voucher"><i class="fa fa-caret-right theme-color" aria-hidden="true"></i> Remarks.</label>
<div class="col-md-12 show-error">
<input type="text" class="form-control move-enter-up move-to-row move-enter-3" data-position="3" name="remarks"  placeholder="Remarks">
</div>
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
<th>Sr#</th>
<th style="width:45%;text-align:center";>Product Description</th>
<th style="width:10%;text-align:center;">Unit</th>
<th style="width:15%;text-align:center">Qty</th>
<th style="width:15%;text-align:center">Rate</th>
<th style="width:15%;text-align:center";>Amount</th>
</tr>
</thead>
<tbody class="theme-border">

</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="3">Total</th>
<td class="theme-bg th-right"><input type="text" name="tqty" /></td>
<td></td>
<td class="theme-bg th-right"><input type="text" name="tamount" /></td>
</tr>
</tfoot>
</table>
</div>


</div>
</div>
</form>
<script>
<?php 
if(!empty($dataType)){
?>
reinitializeTable(1);
<?php 
if(!empty($bissueError)){
?>
bootbox.dialog({title:notifications['error'],message:"<?= $bissueError?>",buttons:{close:{label:'Ok',className:"red",callback:function(){ location.href="<?= base_url("home")?>"; }}}});
<?php 	
}
?>	
<?php 	
}
?>
</script>