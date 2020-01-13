<div class="row">
<div class="col-sm-12">
 <button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="price_list" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="price_list" ><i class="icon-printer"></i> Excel</button>   
</div>
</div>

<style type="text/css">
.rates{
        text-align: right;
 }
</style>
<form class="form-horizontal list-refresh" role="form">
<table class="table table-striped table-bordered table-hover order-column" id="list">
<thead>
<tr>
<th style="width:10%;"> Code </th>
<th style="width:30%;"> Name </th>
<th style="width:10%;"> Unit </th>
<th style="width:10%;"> Purchase Price </th>
<th style="width:10%"> Profit Margin % </th>
<th style="width:15%"> Min Sale Price </th>
<th style="width:15%"> Sale Price </th>


</tr>
</thead>
<tbody>
<?php 
if(count($list)){
$rowNumber = 1;
foreach($list as $a):
?>
<tr>
<td>
<input type="hidden" readonly class="form-control " name="pcode<?= $rowNumber;?>" id="pcode" value="<?= $a['PCODE'];?>" >    <?= $a['PCODE'];?>
</td>
<td>
<input type="hidden" readonly class="form-control " name="pname<?= $rowNumber;?>" id="pname" value="<?= $a['PNAME'];?>" >    <?= $a['PNAME'];?>
</td>
<td>
<input type="hidden" readonly class="form-control " name="unit<?= $rowNumber;?>" id="unit" value="<?= $a['UNIT'];?>" >    <?= $a['UNIT'];?>
</td>
<td>
<input type="text" class="form-control rates" id="prate<?= $rowNumber;?>" name="prate<?= $rowNumber;?>" value="<?= $a['PRATE'];?>" >    
</td>
<td>
<input type="text" class="form-control " onkeyup="cal_sale(<?= $rowNumber;?>)" name="pmargin<?= $rowNumber;?>" id="pmargin<?= $rowNumber;?>" value="<?= $a['PMARGIN'];?>" >   
</td>
<td>
<input type="text" class="form-control "id="pamount<?= $rowNumber;?>" name="pamount<?= $rowNumber;?>" value="<?= $a['PAMOUNT'];?>"  readonly >   
</td>
<td>
<input type="text" class="form-control" onfocusout="check(<?= $rowNumber;?>)"  id="srate<?= $rowNumber;?>" name="srate<?= $rowNumber;?>" value="<?= $a['SRATE'];?>" >   
</td>

</tr>
<?php
$rowNumber++;
endforeach;
}
?>
</tbody>
</table>
<input type="hidden" name="nrows" value="<?= $rowNumber;?>" >

<div class="form-actions right1">
<button type="submit" class="btn green">Submit</button>
<button type="reset" class="btn default">Reset</button>
</div>
</form>
<script>

function cal_sale(row) 
{
var pmargin = $('#pmargin'+row).val();
var prate = $('#prate'+row).val();
if (pmargin!==undefined  || prate!==undefined) {
var percentage = Math.round10((pmargin/100)*prate);
}
var result = parseFloat(prate)+parseFloat(percentage);
    $('#pamount'+row).val(result);
    $('#srate'+row).val(result);
}

function check(row) 
{
var srate = parseFloat($('#srate'+row).val());
var pamount = parseFloat($('#pamount'+row).val());

if (srate!==undefined  || pamount!==undefined) {

    if (srate<pamount) 
    {
        $('#srate'+row).val(pamount);
    }else{     
        $('#srate'+row).val(srate);
    }
}
}

$('#list').dataTable();
</script>