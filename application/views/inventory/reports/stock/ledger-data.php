<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="stklgr" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="stklgr" ><i class="icon-printer"></i> Excel</button>
</h3>
<?php 
$bid = array_column($data, 'B_ID');
$bid = array_unique($bid);
$bid = array_values($bid);
sort($bid); 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

for($b=0;$b<count($bid);$b++){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> <?= $branch[$bid[$b]]?></b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column" id="ledger-data<?= $b?>">
<thead>
<tr>
<th style="text-align:center">Sr</th>
<th style="text-align:center">Date</th>
<th style="text-align:center">Vr.Type</th>
<th style="text-align:center">Vr.No</th>
<th style="text-align:center">Description</th>
<th style="text-align:center">In Qty</th>
<th style="text-align:center">Out Qty</th>
<th style="text-align:center">Bal Qty</th>

</tr>
</thead>
<tbody>
<?php
$tinqt=$toutqt=$tinwt=$toutwt=$tinft=$toutft=$bal1=$bal2=$bal3=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
if($a['B_ID']==$bid[$b])
{
$bal1+=$a['INQT'];
$bal1-=$a['OUTQT'];


$tinqt+=$a['INQT'];
$toutqt+=$a['OUTQT'];

?>
<tr>
<td style="text-align:center"><?= $sr;?></td>
<td style="text-align:center"><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td style="text-align:center"><?= $a['JO'];?></td>
<td style="text-align:center"><a href="javascript:void(0);" onclick="vdetail('<?= $a['NO'];?>','<?= $a['JO'];?>','<?= $a['B_ID'];?>','<?= $a['VDATE'];?>');"><?= $a['NO'];?></a></td>
<td><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['INQT'],2);?></td>
<td class="th-right"><?= number_format($a['OUTQT'],2);?></td>
<td class="th-right"><?= number_format($bal1,2);?></td>

</tr>
<?php
$sr++;
}
endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="5">Total</th>
<td class="th-right"><?= number_format($tinqt,2);?></td>
<td class="th-right"><?= number_format($toutqt,2);?></td>
<td class="th-right"><?= number_format($bal1,2);?></td>

</tr>
</tfoot>
</table>
<script>
$('#ledger-data<?= $b?>').dataTable({
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
                    paginate: {
                        previous: "Prev",
                        next: "Next",
                        last: "Last",
                        first: "First"
                    }
                },
                bStateSave: false,
                lengthMenu: [
                    [6, 15, 20, -1],
                    [6, 15, 20, "All"]
                ],
                pageLength:-1,
                columnDefs: [{
                    targets: [0]
                }, {
                    searchable: !1,
                    targets: [0]
                }],
                order: [
                    [0, "asc"]
                ]
            });
</script>
<?php 
}
?>