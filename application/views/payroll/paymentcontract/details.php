<style>
.salary-sheet th,.salary-sheet td{
text-align:center;
vertical-align:middle !important;	
}
.calculated-row{
background:#c0edf1;	
}
</style>
<input type="hidden" name="date1" value="<?= $date1 ?>">
<input type="hidden" name="date2" value="<?= $date2 ?>">
<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-trophy"></i>Payment Summary for Contract</br> From Date<i class="icon-calendar"></i> <?= date("D d/m/Y",strtotime($date1))?> To Date<i class="icon-calendar"></i> <?= date("D d/m/Y",strtotime($date2))?></b></h3>
</div>
<table class="table table-bordered table-condensed table-responsive salary-sheet">
<thead class="theme-bg">
<tr>
<th>Department</th>
<th>Total Pipe Production</th>
<th rowspan="2">Set Change</th>
<th rowspan="2">Amount</th>
<th>Short Term Balance</th>
<th>Long Term Balance</th>
<th>Advance Balance</th>
<th rowspan="2">Adjustment</th>
<th rowspan="2">Cause</th>
<th>Calculation</th>
<th rowspan="2">Total</th>
</tr>
<tr>
<th>Operator</th>
<th>Pipe Production 20</th>
<th>Short Term Deduction</th>
<th>Long Term Deduction</th>
<th>Advance Deduction</th>
<th>Clear</th>
</tr>
</thead>

<tbody>
<?php
$rowNo=1; 	
foreach($data as $row):
$class="";
$setchang=$tadvnc=$tsloan=$tlloan=$adj=$advance=$sloan=$lloan=$tot=0;	
$cause="";

foreach($loan as $b){
if($b['ACODE']==$row['ACODE']){
$sloan=$b['sloan'];	
$lloan=$b['lloan'];	
$advance=$b['advance'];	
}	
}
foreach($data2 as $d){
if($d['ACODE']==$row['ACODE']){
$setchang=$d['SETCHANGE'];	
$cause=$d['CAUSE'];	
$tadvnc=$d['TADVANCE'];	
$tsloan=$d['TSLOAN'];	
$tlloan=$d['TLLOAN'];	
$adj=$d['ADJUSTMENT'];	
$tot=$d['TTOTAL'];	
$class="calculated-row";
}	
}
?>
<tr rowno="<?= $rowNo;?>" class="<?= $class?>">
<td><?= $row['ANAME'];?>
<input type="hidden" value="<?= $row['ACODE'];?>" name="acode_<?= $rowNo;?>"/></td>
<td  class="tooltips" data-container="body" data-placement="top" data-original-title="Total Pipe Production"><?= lakhseparater($row['totalpipeproduct'])?><input type="hidden" value="<?= $row['totalpipeproduct'];?>" payment class="tpipepro" name="totalpipeproduct_<?= $rowNo;?>"/></td>
<td rowspan="2" style="border-bottom:3px solid black;" class="tooltips" data-container="body" data-placement="top" Placeholder="Set Change">
<input type="text" Placeholder="Set Change" value="<?= $setchang; ?>" payment class="form-control setchange" name="change_<?= $rowNo;?>"/></td>
<td rowspan="2" style="border-bottom:3px solid black;" class="tooltips" data-container="body" data-placement="top" data-original-title="Amount"><span class="amount_<?= $rowNo;?>"><?= lakhseparater($row['amount']);?></span><input type="hidden" payment class="amount" value="<?= $row['amount'];?>" name="amount_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Short Term Balance"><span><?= lakhseparater($sloan);?></span><input type="hidden" class="sloan" value="<?= $sloan;?>" name="sloan_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Long Term Balance"><span><?= lakhseparater($lloan);?></span><input type="hidden" class="lloan" value="<?= $lloan;?>" name="lloan_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Advance Balance"><span><?= lakhseparater($advance);?></span><input type="hidden" class="advance" value="<?= $advance;?>" name="advance_<?= $rowNo;?>"/></td>
<td rowspan="2" style="border-bottom:3px solid black;" class="tooltips" data-container="body" data-placement="top" data-original-title="Adjustment"><input type="text" payment class="form-control tadj" Placeholder="Adjustment"  value="<?= $adj; ?>" name="adjustment_<?= $rowNo;?>"/></td>
<td rowspan="2" style="border-bottom:3px solid black;" class="tooltips" data-container="body" data-placement="top" data-original-title="Cause"><input type="text" class="form-control" Placeholder="Cause" value="<?= $cause; ?>" name="cause_<?= $rowNo;?>"/></td>
<td>
<button type="button" salary-sheet-done class="btn green">Calculate</button></td>
<td  rowspan="2" style="border-bottom:3px solid black;"class="tooltips" data-container="body" data-placement="top" data-original-title="Gross Pay"><span class="ttot_<?= $rowNo;?>"><?= lakhseparater($tot);?></span><input type="hidden" payment class="tgtot" value="<?= $tot;?>" name="ttot_<?= $rowNo;?>"/></td>
</tr><tr rowno="<?= $rowNo;?>" class="<?= $class?>">
<td style="border-bottom:3px solid black;"><input type="hidden" value="" name="operator_<?= $rowNo;?>"/></td>
<td  style="border-bottom:3px solid black;"class="tooltips" data-container="body" data-placement="top" data-original-title="Pipe Production 20"><?= lakhseparater($row['pipeproduct20'])?><input type="hidden" value="<?= $row['pipeproduct20']; ?>" payment class="tpipepro20" name="pipeproduct20_<?= $rowNo;?>"/></td>
<td  style="border-bottom:3px solid black;"class="tooltips" data-container="body" data-placement="top" data-original-title="Short Term Deduction"><input type="text" class="form-control sloan" payment Placeholder="Deduction"  value="<?= $tsloan; ?>" name="tsloan_<?= $rowNo;?>"/></td>
<td  style="border-bottom:3px solid black;"class="tooltips" data-container="body" data-placement="top" data-original-title="Long Term Deduction"><input type="text" class="form-control lloan" payment Placeholder="Deduction"  value="<?= $tlloan; ?>" name="tlloan_<?= $rowNo;?>"/></td>
<td  style="border-bottom:3px solid black;"class="tooltips" data-container="body" data-placement="top" data-original-title="Advance Deduction"><input type="text" class="form-control advance" payment Placeholder="Deduction"  value="<?= $tadvnc; ?>" name="tadvance_<?= $rowNo;?>"/></td>
<td style="border-bottom:3px solid black;">
<button type="button" salary-sheet-clear class="btn red">Clear</button></td>
</tr>
<?php 
$rowNo++;
endforeach;
?>
</tbody>
</table>
<script>
$(".tooltips").tooltip();
</script>
<input type="hidden" value="<?= $rowNo;?>" name="trows" />
<table class="table table-bordered table-condensed table-responsive">
<tbody>
<tr class="theme-bg">
<th>Pipe Production</th>
<th>Pipe Production 20</th>
<th>Total Adjustment</th>
<th>Grand Total</th>
</tr>
<tr>
<td class="th-right">
<input type="hidden" name="tpipepro" data-sum ><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tpipepro20" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tadj" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tgtot" data-sum><span></span>
</td>
</tr>
</tbody>
</table>

<div class="form-actions right1">
<button type="submit" class="btn green">Save</button>
<button type="reset" class="btn default">Reset</button>
</div>
<script>
$(".input-format").each(function(){
var cleave = new Cleave($(this), {
    numeral: true,
    numeralThousandsGroupStyle: 'lakh',
	numeralDecimalScale:4
});	
});
</script>