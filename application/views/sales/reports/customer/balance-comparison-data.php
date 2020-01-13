<?php
if(!empty($data)){
$data1=$data['data1']; 	
$data2=$data['data2']; 	
$data3=$data['data3']; 	
}
if(!empty($data1)){
?>
<h3><i class="icon-user theme-color"></i> : <?= $data1[0]['ANAME'];?>  <i class="icon-calendar theme-color"></i> As On(<?= $vdate?>)</h3></h3>
<?php 
}
?>
<h3><i class="icon-user theme-color"></i><i class="icon-calendar theme-color"></i><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-bordered order-column">
<thead class="theme-bg">
<tr>
<th>Balance As On</th>
<th>Age(Since)</th>
<th>Cr.Limit</th>
<th rowspan="2" style="vertical-align:middle">Avg. Sales</th>
<th rowspan="2" style="vertical-align:middle">Avg. Recovery</th>
<th rowspan="2" style="vertical-align:middle">Avg. Balance</th>
<th rowspan="2" style="vertical-align:middle">Est. Limit</th>
<th rowspan="2" style="vertical-align:middle">Rem. Limit</th>
</tr>
<tr>
<th>Balance Due</th>
<th>Avg. Bal. Days</th>
<th>Cr. Days</th>
</tr>
</thead>
<?php 
if(!empty($data1)){
?>
<tbody>
<tr>
<td class="th-right"><b><?= number_format($data1[0]['BAL'])?></b></td>
<td class="th-right"><b><?= $data3[0]['BAL15']?></td>
<td class="th-right"><b><?= number_format($data1[0]['CLIMIT'])?></b></td>
<td rowspan="2" style="vertical-align:middle;text-align:right"><b><?= number_format($data1[0]['BAL15'])?></b></td>
<td rowspan="2" style="vertical-align:middle;text-align:right"><b><?= number_format($data1[0]['BAL30'])?></b></td>
<td rowspan="2" style="vertical-align:middle;text-align:right"><b><?= number_format($data1[0]['BAL45'])?></b></td>
<td rowspan="2" style="vertical-align:middle;text-align:right"><b><?= number_format($data1[0]['BAL60'])?></b></td>
<td rowspan="2" style="vertical-align:middle;text-align:right"><b><?= number_format($data1[0]['BAL75'])?></b></td>
</tr>
<tr>
<td style="vertical-align:middle;text-align:right"><b><?= number_format($data3[0]['BAL'])?></b></td>
<td class="th-right"><b><?= $data3[0]['INVDAYS']?></b></td>
<td class="th-right"><b><?= $data1[0]['CDAYS']?></b></td>
</tr>
</tbody>
<?php 
}
?>
</table>
<table class="table table-bordered table-striped order-column">
<thead class="theme-bg">
<tr>
<th><h4><i class="icon-calendar"></i> Month</h4></th>
<th><h4><i class="icon-basket"></i> Sales</h4></th>
<th><h4><i class="icon-trophy"></i> Recovery</h4></th>
<th><h4><i class="icon-calculator"></i> Balance</h4></th>
</tr>
</thead>
<tbody>
<?php 
for($a=0;$a<count($dates);$a++){
$sales=$recovery=$bal=0;	
foreach($data2 as $d){	
if(date("Y-m-d",strtotime($d['VDATE']))==date("Y-m-01",strtotime($dates[$a]))){
$sales=$d['DEBIT'];	
$recovery=$d['CREDIT'];	
$bal=$d['BAL'];		
}
}	
?>
<tr>
<td class="theme-bg"><h4><?= date("M/Y",strtotime($dates[$a]))?></h4></td>
<td style="vertical-align:middle;text-align:right"><h4><?= number_format($sales)?></h4></td>
<td style="vertical-align:middle;text-align:right"><h4><?= number_format($recovery)?></h4></td>
<td style="vertical-align:middle;text-align:right"><h4><?= number_format($bal)?></h4></td>
</tr>
<?php 	
}
?>
</tbody>
</table>
