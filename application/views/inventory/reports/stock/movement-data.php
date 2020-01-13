<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="stkbal" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="stkmov" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="movement-data">
<thead>
<tr>
<th style="text-align:center">Sr</th>
<th style="text-align:center">Code</th>
<th style="text-align:center">Name</th>
<th style="text-align:center">Unit</th>
<th style="text-align:center">Opening Qty</th>
<th style="text-align:center">This Period Qty</th>
<th style="text-align:center">Closing Qty</th>
</tr>
</thead>
<tbody>
<?php 
$total['inqty']=array();	
$total['qty']=array();	
$total['outqty']=array();	

if(count($data[0])){
$sr=1;	
foreach($data[0] as $a):
?>
<tr>
<td style="text-align:center"><?= $sr;?></td>
<td style="text-align:center"><?= $a['PCODE'];?></td>
<td style="text-align:left"><?= $a['PNAME'];?></td>
<td style="text-align:center"><?= $a['UNIT'];?></td>
<td style="text-align:right"><?= number_format($a['INQT'],2);?></td>
<td style="text-align:right"><?= number_format($a['OUTQT'],2);?></td>
<td style="text-align:right"><?= number_format($a['QTY'],2);?></td>

<?php 
array_push($total['inqty'],$a['INQT']);
array_push($total['qty'],$a['QTY']);
array_push($total['outqty'],$a['OUTQT']);

?>
</tr>
<?php
$sr++;
endforeach;
}
$inqty=$total['inqty'];
$qty=$total['qty'];
$outqty=$total['outqty'];

?>
</tbody>
<tfoot>
<tr>
<th colspan="4">Total</th>
<th class="th-right"><?= array_sum($inqty);?></th>
<th class="th-right"><?= array_sum($outqty);?></th>
<th class="th-right"><?= array_sum($qty);?></th>

</tr>
</tfoot>
</table>
<script>
$('#movement-data').dataTable({
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
                pageLength: -1,
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