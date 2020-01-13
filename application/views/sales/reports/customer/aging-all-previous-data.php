<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="custageall" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="custageall" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-previous-data">
<thead class="theme-bg">
<tr>
<th>Code</th>
<th>Name</th>
<th>C. Days</th>
<th>1-30</th>
<th>31-45</th>
<th>46-60</th>
<th>61-90</th>
<th>Abv 90</th>
<th>Bal</th>
<th>Chq Bal</th>
<th>Rem Bal</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$bal15=$bal30=$bal45=$bal60=$bal90=$bal120=$chqbal=$remBal=$bal=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):

?>
<tr>
<td><a href="javascript:void(0);" onclick="ledger('<?= $a['ACODE'];?>');"><?= $a['ACODE'];?></a></td>
<td><a href="javascript:void(0);" onclick="chqdetail('<?= $a['ACODE'];?>');"><?= $a['ANAME'];?></a></td>
<td class="th-right"><?= number_format($a['CDAYS']);?></td>
<td class="th-right"><a href="javascript:void(0);" onclick="balanceComparison('<?= $a['ACODE'];?>');"><?= number_format($a['BAL30']);?></a></td>
<td class="th-right"><?= number_format($a['BAL45']);?></td>
<td class="th-right"><?= number_format($a['BAL60']);?></td>
<td class="th-right" ><?= number_format($a['BAL90']);?></td>
<td class="th-right" ><?= number_format($a['BAL120']);?></td>
<td class="th-right"><a href="javascript:void(0);" onclick="aging('<?= $a['ACODE'];?>');"><?= number_format($a['BAL']);?></a></td>
<td class="th-right"><?= number_format($a['BAL2']);?></td>
<td class="th-right"><?= number_format($a['BAL']-$a['BAL2']);?></td>
</tr>
<?php
$sr++;
$bal+=$a['BAL'];
$bal30+=$a['BAL30'];
$bal45+=$a['BAL45'];
$bal60+=$a['BAL60'];
$bal90+=$a['BAL90'];
$bal120+=$a['BAL120'];
$chqbal+=$a['BAL2'];
$remBal+=$a['BAL']-$a['BAL2'];
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
<th class="th-right"><?= number_format($bal);?></th>
<th class="th-right"><?= number_format($chqbal);?></th>
<th class="th-right"><?= number_format($remBal);?></th>
</tr>
</tfoot>
</table>

<script>
var agingAllPreviousData=$('#aging-all-previous-data').dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ records",
                    infoEmpty: "No records found",
                    infoFiltered: "(filtered from _MAX_ total records)",
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
ledgerDate="31/12/2016 - <?= $vdate?>";
chqdetailDate="31/12/2016 - <?= $vdate?>";
agingDate="<?= $vdate?>";
</script>