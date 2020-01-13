<?php 
$jo=array_column($data,"JO");
$jo=array_unique($jo);
?>
<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="custageall" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="custageall" ><i class="icon-printer"></i> Excel</button>
</h3>

<?php 
$tot_sale=$tot_rec=$tot_sale2=$tot_rec2=0;
foreach($jo as $typ):
if($typ=='XY')	{ ?>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data">
<thead class="theme-bg">
<tr>
<th>Code</th>
<th>Name</th>
<th>C.Days</th>
<th>1-15</th>
<th>16-30</th>
<th>31-45</th>
<th>46-60</th>
<th>61-90</th>
<th>Abv 90</th>
<th>Com Bal</th>
<th>Bal</th>
<th>Chq Bal</th>
<th>Rem Bal</th>
<th>Cash Sale</th>
<th>Party Type</th>
<th>Total Sale</th>
<th>Total Recovery</th>
</tr>
</thead>
<tbody>
<?php
$gud_cus=0;
$gud2_cus=0;
$nrml_cus=0;
$bad_cus=0;
$tgud_cus_sale=0;
$tgud2_cus_sale=0;
$tnrml_cus_sale=0;
$tbad_cus_sale=0;
$tgud_cus_rec=0;
$tgud2_cus_rec=0;
$tnrml_cus_rec=0;
$tbad_cus_rec=0;
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

$bal15=$bal30=$bal45=$bal60=$bal90=$bal120=$duebal=$chqbal=$bal=$remBal=$tot_sale=$tot_rec=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
if($a['JO']=='XY')	{
if(!empty($promis))
{
foreach($promis as $b):
if($a['ACODE']==$b['ACODE'])
{
	$desc = $b['desc2'];
	if(!empty($desc)){
	$desc = $b['desc1'];
	}
	$no = $b['NO'];
break;
}	else {
	$no = 0;
	$desc = '';
}
endforeach;
}	else {
	$no = 0;
	$desc = '';
}
$invdays = $a['INVDAYS'];
$cdays = $a['CDAYS'];
$nrml = $cdays+8;
$extend = $cdays+15;
$dif = $a['T_SALE']-$a['T_REC'];
if ($a['T_SALE']>0)
{
	$prcnt = ($a['T_REC']/$a['T_SALE'])*100;
}
else
{
	$prcnt =0;
}
if($invdays<$cdays)
{
	$gud_cus++;
	$tgud_cus_sale=$tgud_cus_sale+$a['T_SALE'];
	$tgud_cus_rec=$tgud_cus_rec+$a['T_REC'];
	$style = "style='background-color: aquamarine;'";
}
else if($invdays>=$cdays && $invdays<$nrml)
{
	$gud2_cus++;
	$tgud2_cus_sale=$tgud2_cus_sale+$a['T_SALE'];
	$tgud2_cus_rec=$tgud2_cus_rec+$a['T_REC'];
	$style = "style='background-color: #ffff6c;'";
}
else if(($invdays>=$nrml && $invdays<$extend) || ($prcnt>95 && $dif<3001))
{
	$nrml_cus++;
	$tnrml_cus_sale=$tnrml_cus_sale+$a['T_SALE'];
	$tnrml_cus_rec=$tnrml_cus_rec+$a['T_REC'];
	$style = "style='background-color: pink'";
}
else if($invdays>=$extend)
{
	$bad_cus++;
	$tbad_cus_sale=$tbad_cus_sale+$a['T_SALE'];
	$tbad_cus_rec=$tbad_cus_rec+$a['T_REC'];
	$style = "style='background-color:#ff4040'";
}
else
{
	$style = "";
}
?>
<tr>
<td><a href="javascript:void(0);" onclick="ledger('<?= $a['ACODE'];?>');"><?= $a['ACODE'];?></a></td>
<td><a href="javascript:void(0);" onclick="chqdetail('<?= $a['ACODE'];?>');"><?= $a['ANAME'];?></a></td>
<td  <?= $style; ?> ><?= number_format($a['CDAYS']);?></td>
<td class="th-right"><a href="javascript:void(0);" onclick="balanceComparison('<?= $a['ACODE'];?>');"><?= number_format($a['BAL15']);?></a></td>
<td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= $desc; ?>"><a <?php if($no!=0) { ?> onmouseover="mouseover(<?= $no ?>);" <?php } ?> ><?= number_format($a['BAL30']);?></a></td>
<td class="th-right"><?= number_format($a['BAL45']);?></td>
<td class="th-right"><?= number_format($a['BAL60']);?></td>
<td class="th-right"><?= number_format($a['BAL90']);?></td>
<td class="th-right"><?= number_format($a['BAL120']);?></td>
<td class="th-right"><?= number_format($a['BAL105']);?></td>
<td class="th-right"><a href="javascript:void(0);" onclick="aging('<?= $a['ACODE'];?>');"><?= number_format($a['BAL']);?></a></td>
<td class="th-right"><?= number_format($a['BAL2']);?></td>
<td class="th-right"><?= number_format($a['BAL']-$a['BAL2']);?></td>
<td class="th-right"><?= number_format($a['BAL121']);?></td>
<td class="th-right"><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['T_SALE']);?></td>
<td class="th-right"><?= number_format($a['T_REC']);?></td>
</tr>
<?php
$sr++;
$bal+=$a['BAL'];
$bal30+=$a['BAL30'];
$bal45+=$a['BAL45'];
$bal60+=$a['BAL60'];
$bal90+=$a['BAL90'];
$duebal+=$a['BAL105'];
$bal120+=$a['BAL120'];
$chqbal+=$a['BAL2'];
$tot_sale+=$a['T_SALE'];
$tot_rec+=$a['T_REC'];
$remBal+=$a['BAL']-$a['BAL2'];
}
endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<th colspan="3">Total</th>
<th class="th-right"><?= number_format($bal30);?></th>
<th class="th-right"><?= number_format($bal45);?></th>
<th class="th-right"><?= number_format($bal60);?></th>
<th class="th-right"><?= number_format($bal90);?></th>
<th class="th-right"><?= number_format($bal120);?></th>
<th class="th-right"><?= number_format($duebal);?></th>
<th class="th-right"><?= number_format($bal);?></th>
<th class="th-right"><?= number_format($chqbal);?></th>
<th class="th-right"><?= number_format($remBal);?></th>
<th class="th-right"></th>
<th class="th-right"></th>
<th class="th-right"><?= number_format($tot_sale);?></th>
<th class="th-right"><?= number_format($tot_rec);?></th>
</tr>
</tfoot>
</table>

<?php	} if($typ=='ZZ')	{ ?>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data3">
<thead class="theme-bg">
<tr>
<th>Code</th>
<th>Name</th>
<th>C.Days</th>
<th>1-15</th>
<th>16-30</th>
<th>31-45</th>
<th>46-60</th>
<th>61-90</th>
<th>Abv 90</th>
<th>Com Bal</th>
<th>Bal</th>
<th>Chq Bal</th>
<th>Rem Bal</th>
<th>Cash Sale</th>
<th>Party Type</th>
<th>Total Sale</th>
<th>Total Recovery</th>
</tr>
</thead>
<tbody>
<?php
$gud_cus=0;
$gud2_cus=0;
$nrml_cus=0;
$bad_cus=0;
$tgud_cus_sale=0;
$tgud2_cus_sale=0;
$tnrml_cus_sale=0;
$tbad_cus_sale=0;
$tgud_cus_rec=0;
$tgud2_cus_rec=0;
$tnrml_cus_rec=0;
$tbad_cus_rec=0;
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

$bal15=$bal30=$bal45=$bal60=$bal90=$bal120=$duebal=$chqbal=$bal=$remBal=$tot_sale2=$tot_rec2=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
if($a['JO']=='ZZ')	{
if(!empty($promis))
{
foreach($promis as $b):
if($a['ACODE']==$b['ACODE'])
{
	$desc = $b['desc2'];
	if(!empty($desc)){
	$desc = $b['desc1'];
	}
	$no = $b['NO'];
break;
}	else {
	$no = 0;
	$desc = '';
}
endforeach;
}	else {
	$no = 0;
	$desc = '';
}
$invdays = $a['INVDAYS'];
$cdays = $a['CDAYS'];
$nrml = $cdays+8;
$extend = $cdays+15;
$dif = $a['T_SALE']-$a['T_REC'];
if ($a['T_SALE']>0)
{
	$prcnt = ($a['T_REC']/$a['T_SALE'])*100;
}
else
{
	$prcnt =0;
}
if($invdays<$cdays)
{
	$gud_cus++;
	$tgud_cus_sale=$tgud_cus_sale+$a['T_SALE'];
	$tgud_cus_rec=$tgud_cus_rec+$a['T_REC'];
	$style = "style='background-color: aquamarine;'";
}
else if($invdays>=$cdays && $invdays<$nrml)
{
	$gud2_cus++;
	$tgud2_cus_sale=$tgud2_cus_sale+$a['T_SALE'];
	$tgud2_cus_rec=$tgud2_cus_rec+$a['T_REC'];
	$style = "style='background-color: #ffff6c;'";
}
else if(($invdays>=$nrml && $invdays<$extend) || ($prcnt>95 && $dif<3001))
{
	$nrml_cus++;
	$tnrml_cus_sale=$tnrml_cus_sale+$a['T_SALE'];
	$tnrml_cus_rec=$tnrml_cus_rec+$a['T_REC'];
	$style = "style='background-color: pink'";
}
else if($invdays>=$extend)
{
	$bad_cus++;
	$tbad_cus_sale=$tbad_cus_sale+$a['T_SALE'];
	$tbad_cus_rec=$tbad_cus_rec+$a['T_REC'];
	$style = "style='background-color:#ff4040'";
}
else
{
	$style = "";
}
?>
<tr>
<td><a href="javascript:void(0);" onclick="ledger('<?= $a['ACODE'];?>');"><?= $a['ACODE'];?></a></td>
<td><a href="javascript:void(0);" onclick="chqdetail('<?= $a['ACODE'];?>');"><?= $a['ANAME'];?></a></td>
<td  <?= $style; ?> ><?= number_format($a['CDAYS']);?></td>
<td class="th-right"><a href="javascript:void(0);" onclick="balanceComparison('<?= $a['ACODE'];?>');"><?= number_format($a['BAL15']);?></a></td>
<td class="th-right popovers" data-container="body" data-trigger="hover" data-placement="bottom" data-content="<?= $desc; ?>"><a <?php if($no!=0) { ?> onmouseover="mouseover(<?= $no ?>);" <?php } ?> ><?= number_format($a['BAL30']);?></a></td>
<td class="th-right"><?= number_format($a['BAL45']);?></td>
<td class="th-right"><?= number_format($a['BAL60']);?></td>
<td class="th-right"><?= number_format($a['BAL90']);?></td>
<td class="th-right"><?= number_format($a['BAL120']);?></td>
<td class="th-right"><?= number_format($a['BAL105']);?></td>
<td class="th-right"><a href="javascript:void(0);" onclick="aging('<?= $a['ACODE'];?>');"><?= number_format($a['BAL']);?></a></td>
<td class="th-right"><?= number_format($a['BAL2']);?></td>
<td class="th-right"><?= number_format($a['BAL']-$a['BAL2']);?></td>
<td class="th-right"><?= number_format($a['BAL121']);?></td>
<td class="th-right"><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['T_SALE']);?></td>
<td class="th-right"><?= number_format($a['T_REC']);?></td>
</tr>
<?php
$sr++;
$bal+=$a['BAL'];
$bal15+=$a['BAL15'];
$bal30+=$a['BAL30'];
$bal45+=$a['BAL45'];
$bal60+=$a['BAL60'];
$bal90+=$a['BAL90'];
$bal120+=$a['BAL120'];
$duebal+=$a['BAL105'];
$chqbal+=$a['BAL2'];
$tot_sale2+=$a['T_SALE'];
$tot_rec2+=$a['T_REC'];
$remBal+=$a['BAL']-$a['BAL2'];
}
endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<th colspan="3">Total</th>
<th class="th-right"><?= number_format($bal15);?></th>
<th class="th-right"><?= number_format($bal30);?></th>
<th class="th-right"><?= number_format($bal45);?></th>
<th class="th-right"><?= number_format($bal60);?></th>
<th class="th-right"><?= number_format($bal90);?></th>
<th class="th-right"><?= number_format($bal120);?></th>
<th class="th-right"><?= number_format($duebal);?></th>
<th class="th-right"><?= number_format($bal);?></th>
<th class="th-right"><?= number_format($chqbal);?></th>
<th class="th-right"><?= number_format($remBal);?></th>
<th class="th-right"></th>
<th class="th-right"></th>
<th class="th-right"><?= number_format($tot_sale2);?></th>
<th class="th-right"><?= number_format($tot_rec2);?></th>
</tr>
</tfoot>
</table>

<?php	}
endforeach;
 ?>
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-4">
<div class="portlet box blue">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-gift"></i>Very Good Customer Summary</div>
<div class="tools">
<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" style="display: block;">
<p class="text-success" style="text-align: center;font-size: 20px;">Total Customer  : <?= $gud_cus; ?> </p>
<p class="text-success" style="text-align: center;font-size: 20px;">Total Sale : <?= number_format($tgud_cus_sale,1); ?>   </p>
<p class="text-success" style="text-align: center;font-size: 20px;">Total Recovery : <?= number_format($tgud_cus_rec,1); ?></p>
</div>
</div>
</div>
<div class="col-sm-4">
<div class="portlet box blue">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-gift"></i>Good Customer Summary</div>
<div class="tools">
<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" style="display: block;">
<p class="text-warning" style="text-align: center;font-size: 20px;">Total Customer : <?= $gud2_cus; ?> </p>
<p class="text-warning" style="text-align: center;font-size: 20px;">Total Sale : <?= number_format($tgud2_cus_sale); ?>   </p>
<p class="text-warning" style="text-align: center;font-size: 20px;">Total Recovery : <?= number_format($tgud2_cus_rec); ?></p>
</div>
</div>
</div>
<div class="col-sm-2"></div>
</div>
<div class="row">
<div class="col-sm-2"></div>
<div class="col-sm-4">
<div class="portlet box blue">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-gift"></i>Normal Customer Summary</div>
<div class="tools">
<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" style="display: block;">
<p class="text-warning" style="text-align: center;font-size: 20px;">Total Customer : <?= $nrml_cus; ?> </p>
<p class="text-warning" style="text-align: center;font-size: 20px;">Total Sale : <?= number_format($tnrml_cus_sale); ?>   </p>
<p class="text-warning" style="text-align: center;font-size: 20px;">Total Recovery : <?= number_format($tnrml_cus_rec); ?></p>
</div>
</div>
</div>
<div class="col-sm-4">
<div class="portlet box blue">
<div class="portlet-title">
<div class="caption">
<i class="fa fa-gift"></i>Bad Customer Summary</div>
<div class="tools">
<a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
</div>
</div>
<div class="portlet-body" style="display: block;">
<p class="text-danger " style="text-align: center;font-size: 20px;">Total Customer : <?= $bad_cus; ?> </p>
<p class="text-danger " style="text-align: center;font-size: 20px;">Total Sale : <?= number_format($tbad_cus_sale); ?>   </p>
<p class="text-danger " style="text-align: center;font-size: 20px;">Total Recovery : <?= number_format($tbad_cus_rec); ?></p>
</div>
</div>
</div>
<div class="col-sm-2"></div></div>
	
<div class="row">
<h3 style="background-color: antiquewhite;color: forestgreen;text-align:center">Salesman Wise Summary</h3>
<?php 
$cnt=1;
$date = $a['DATE1'];
$vdate1=date("Y-m-d",strtotime("-1 month",strtotime($date)));
$vdate2=date("Y-m-d",strtotime("-2 month",strtotime($date)));
$vdate3=date("Y-m-d",strtotime("-3 month",strtotime($date)));
$d1 = date('M/Y', strtotime($vdate1));
$d2 = date('M/Y', strtotime($vdate2));
$d3 = date('M/Y', strtotime($vdate3));

 ?>
 
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data2">
<thead class="theme-bg">
<tr>
<th>Salesman</th>
<th><?= $d3; ?></th>
<th><?= $d2; ?></th>
<th><?= $d1; ?></th>
<th>Total Sales</th>
<th><?= $d3; ?></th>
<th><?= $d2; ?></th>
<th><?= $d1; ?></th>
<th>Total Recovery</th>
<th>Sale</th>
<th>Recovery</th>
</thead>
</tr>
<tbody>
<?php
$tt_sale=$tot_sale+$tot_sale2;
$tt_rec=$tot_rec+$tot_rec2;
foreach($tot as $total):
$sale = $total['tsale'];
$rec = $total['trec'];
$per_sale = ($sale/$tt_sale)*100;
$per_rec = ($rec/$tt_rec)*100;
?>
<tr>
<td style="background-color: antiquewhite;color: forestgreen;"><?= $total['SNAME'] ?></td>
<td><?= number_format($total['sale1']) ?></td>
<td><?= number_format($total['sale2']) ?></td>
<td><?= number_format($total['sale3']) ?></td>
<td><?= number_format($total['tsale']) ?></td>
<td><?= number_format($total['rec1']) ?></td>
<td><?= number_format($total['rec2']) ?></td>
<td><?= number_format($total['rec3']) ?></td>
<td><?= number_format($total['trec']) ?></td>
<td><?= number_format($per_sale,2) ?> %</td>
<td><?= number_format($per_rec,2) ?> %</td>
</tr>
<?php
endforeach;
?>
</tbody>
	
</table>
		</div>									
<script>
var agingAllData=$('#aging-all-data').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered1 from _MAX_ total records)",
                    lengthMenu: "Show _MENU_",
                    search: "Search:",
                    zeroRecords: "No matching records found",
                    paginate:false
                },
                bStateSave: false,
				"paging":false,
				scrollY:500,
				bSort:false
            });	
var agingAllData=$('#aging-all-data2').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered1 from _MAX_ total records)",
                    lengthMenu: "Show _MENU_",
                    search: "Search:",
                    zeroRecords: "No matching records found",
                    paginate:false
                },
                bStateSave: false,
				"paging":false,
				bSort:false
            });		
var agingAllData=$('#aging-all-data3').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered1 from _MAX_ total records)",
                    lengthMenu: "Show _MENU_",
                    search: "Search:",
                    zeroRecords: "No matching records found",
                    paginate:false
                },
                bStateSave: false,
				"paging":false,
				bSort:false
            });		
ledgerDate="31/12/2016 - <?= $vdate?>";
chqdetailDate="31/12/2016 - <?= $vdate?>";
agingDate="<?= $vdate?>";
</script>