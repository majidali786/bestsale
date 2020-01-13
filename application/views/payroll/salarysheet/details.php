<style>
.salary-sheet th,.salary-sheet td{
text-align:center;
vertical-align:middle !important;	
}
.calculated-row{
background:#c0edf1;	
}
</style>
<?php 
$totalDays=cal_days_in_month(CAL_GREGORIAN, date("n",strtotime($date)), date("Y",strtotime($date)));
?>
<div class="note note-success margin-bottom-10 col-sm-12">
<h3 class="margin-0"><b><i class="icon-trophy"></i> Emplopyee Salary Sheet Of Month <i class="icon-calendar"></i> ( <?= date("F",strtotime($date))?>, Total Days:<?= $totalDays?>)</b></h3>
</div>
<input type="hidden" value="30" name="tdays"/>
<table class="table table-bordered table-condensed table-responsive salary-sheet">
<thead class="theme-bg">
<tr>
<th rowspan="3">Sr#</th>
<th colspan="3">Employee Information</th>
<th>Overtime</th>
<th colspan="3">Deductions</th>
<th colspan="3">Action</th>
</tr>
<tr>
<th colspan="2">Name</th>
<th>Pay/Month</th>
<th>Hours</th>
<th>Total L.Term Loan</th>
<th>Total S.Term Loan</th>
<th>Total Advance</th>
<th>Calculation</th>
<th style="width:10%;">Gross</th>
<th rowspan="2" style="width:10%;">Total Pay</th>
</tr>
<tr>
<th>Department</th>
<th>Designation</th>
<th>W/Days</th>
<th>Amount</th>
<th>L.Term Loan Ded.</th>
<th>S.Term Loan Ded.</th>
<th>Advance Ded.</th>
<th>Clear</th>
<th>Net Pay</th>
</tr>
</thead>

<tbody>
<?php
$rowNo=1; 
 echo $mdate=date("Y-m-d",strtotime($date));
foreach($data as $row):
$shortLoan=$longLoan=$tadvance=$stloan2=0;
$whours=$row['WHOURS'];



if($whours=="" || $whours==0){
$whours=8;	
}
$days=0;

foreach($sloan as $a){
if($a['ACODE']==$row['ID']){
$shortLoan=$a['AMT'];	
$cmdate=date("Y-m-d");
	$hdate=30;	
$sdate=60;
$STYPE=$a['STYPE'];	
echo $vdate=date("Y-m-d",strtotime($a['VDATE']));
 $vdate1=date("Y-m-d",strtotime("+1 month",strtotime($vdate)));
 $vdate2=date("Y-m-d",strtotime("+2 month",strtotime($vdate)));

$arr = array($vdate);
foreach ($arr as &$diff) {
   $diff=date_diff(date_create($mdate),date_create($vdate));
echo    $days+=$diff->format("%a");
}

if ($STYPE==1 & $days>=$sdate)
{
 $stloan2=round($shortLoan/3);
}


elseif ($STYPE==2 & $days>=$hdate)
{
 
 
 $stloan2=round($shortLoan/3);

 
}
else
{
	$stloan2=0;
}


}	
}

foreach($lloan as $b){
if($b['ACODE']==$row['ID']){
$longLoan=$b['AMT'];	
}	
}

foreach($advance as $c){
if($c['ACODE']==$row['ID']){
$tadvance=$c['AMT'];	
}	
}
$class="";
$wdays=$hours=$ltloan=$stloan=$dadvance=0;	
foreach($data2 as $d){
if($d['ECODE']==$row['ID']){
$wdays=$d['WDAYS'];	
$hours=$d['OHOURS'];	
$ltloan=$d['LTLOAN'];	
$stloan1=$d['STLOAN'];	


$dadvance=$d['ADVANCE'];	
$class="calculated-row";
}	
}

?>
<tr rowno="<?= $rowNo;?>" class="<?= $class?>">
<td rowspan="2" class="theme-bg" style="border-bottom:3px solid black;"><?= $rowNo;?></td>
<td colspan="2"><?= $row['NAME']?><input type="hidden" value="<?= $whours;?>" name="whours_<?= $rowNo;?>"/><input type="hidden" value="<?= $row['ID'];?>" name="id_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Basic Per Month Salary"><?= lakhseparater($row['BASIC'])?><input type="hidden" value="<?= $row['BASIC'];?>" name="basic_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Overtime Hours"><input type="text" class="form-control input-format thours" salary-sheet Placeholder="Overtime Hours" value="<?= $hours ?>" name="hours_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Total Long Term Loan"><span class="tltl_<?= $rowNo;?>"><?= lakhseparater($longLoan+$ltloan);?></span><input type="hidden" value="<?= $longLoan+$ltloan;?>" class="tltloan" name="tltl_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Total Short Term Loan">
<span class="tstl_<?= $rowNo;?>"><?= lakhseparater($shortLoan+$stloan);?></span><input type="hidden" value="<?= $shortLoan+$stloan;?>"
 class="tstloan" name="tstl_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Total Advance"><span class="tadvance_<?= $rowNo;?>"><?= lakhseparater($tadvance+$dadvance);?></span><input type="hidden" value="<?= $tadvance+$dadvance;?>"  class="tadvance" name="tadvance_<?= $rowNo;?>"/></td>
<td>
<button type="button" salary-sheet-done class="btn green">Calculate</button></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Gross Pay"><span class="gpay_<?= $rowNo;?>">0</span><input type="hidden" class="tgapy" value="0" name="gpay_<?= $rowNo;?>"/></td>
<td style="border-bottom:3px solid black;" rowspan="2" class="tooltips" data-container="body" data-placement="top" data-original-title="Total Pay"><span class="tpay_<?= $rowNo;?>">0</span><input type="hidden" value="0" class="ttpay" name="tpay_<?= $rowNo;?>"/></td>
</tr>
<tr style="border-bottom:3px solid black;" class="<?= $class?>" rowno="<?= $rowNo;?>">
<td><?= $row['DEPARTMENT']?></td>
<td><?= $row['DESIGNATION']?></td>
<td class="tooltips" data-container="body"  data-placement="top" data-original-title="Working Days"><input type="text" class="form-control input-format" salary-sheet Placeholder="W/Days" salary-sheet-calculate value="<?= $wdays ?>" name="wdays_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Overtime Amount"><span class="oamount_<?= $rowNo;?>">0</span><input type="hidden" value="0" class="totamount" name="oamount_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Long Term Loan Deduction">
<input salary-sheet type="text"  value="<?= $ltloan ?>" class="form-control input-format tdltloan" Placeholder="L.term Loan Ded." 
name="ltermded_<?= $rowNo;?>"/></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Short Term Loan Deduction">
<input salary-sheet type="text"  value="<?= $stloan2 ?>" class="form-control input-format tdstloan" 
Placeholder="S.term Loan Ded." name="stermded_<?= $rowNo;?>"/></td>

<td class="tooltips" data-container="body" data-placement="top" data-original-title="Advance Deduction">
<input salary-sheet type="text"  value="<?= $dadvance ?>" class="form-control input-format tdavance" Placeholder="Advance Ded." 
name="advanceded_<?= $rowNo;?>"/></td>
<td style="border-bottom:3px solid black;">
<button type="button" salary-sheet-clear class="btn red">Clear</button></td>
<td class="tooltips" data-container="body" data-placement="top" data-original-title="Net Pay"><span class="npay_<?= $rowNo;?>">0</span><input type="hidden" value="0" class="tnpay" name="npay_<?= $rowNo;?>"/></td>
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
<th>OverTime Hours</th>
<th>Total L.Term Loan</th>
<th>Total S.Term Loan</th>
<th>Total Advance</th>
<th>Total Gross</th>
<th rowspan="2" style="vertical-align:middle">Total Pay</th>
</tr>
<tr>
<td class="th-right">
<input type="hidden" name="thours" data-sum ><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tltloan" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tstloan" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tadvance" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tgapy" data-sum><span></span>
</td>
</tr>
<tr class="theme-bg">
<th>Total Overtime Amount</th>
<th>Total Deduction L.Term</th>
<th>Total Deduction S.Term</th>
<th>Total Deduction Advance</th>
<th>Total Net Pay</th>
<td class="th-right" rowspan="2" style="vertical-align:middle">
<input type="hidden" name="ttpay" data-sum><span></span>
</td>
</tr>
<tr>
<td class="th-right">
<input type="hidden" name="totamount" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tdltloan" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tdstloan" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tdavance" data-sum><span></span>
</td>
<td class="th-right">
<input type="hidden" name="tnpay" data-sum><span></span>
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