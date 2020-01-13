<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="stkbal" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="stkmov" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="movement-data">
<thead>
<tr>
<th >Sr</th>
<th >Name</th>
<th >Unit</th>
<th >Opening Qty</th>
<th >Opening Weight</th>
<th >Interval Qty</th>
<th >Interval Weight</th>
<th >Closing Qty</th>
<th >Closing Weight</th>
</tr>
</thead>
<tbody>
<?php 
$total['inqty']=array();	
$total['qty']=array();	
$total['outqty']=array();	
$total['inwght']=array();	
$total['weight']=array();	
$total['outwght']=array();	
if(count($data[0])){
$sr=1;	
foreach($data[0] as $a):
?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['PNAME'];?></td>
<td><?= $a['UNIT'];?></td>
<td><?= number_format($a['INQT'],2);?></td>
<td><?= number_format($a['INWGHT'],2);?></td>
<td><?= number_format($a['QTY'],2);?></td>
<td><?= number_format($a['WEIGHT'],2);?></td>
<td><?= number_format($a['OUTQT'],2);?></td>
<td><?= number_format($a['OUTWGHT'],2);?></td>
<?php 
array_push($total['inqty'],$a['INQT']);
array_push($total['qty'],$a['QTY']);
array_push($total['outqty'],$a['OUTQT']);
array_push($total['inwght'],$a['INWGHT']);
array_push($total['weight'],$a['WEIGHT']);
array_push($total['outwght'],$a['OUTWGHT']);
?>
</tr>
<?php
$sr++;
endforeach;
}
$inqty=$total['inqty'];
$qty=$total['qty'];
$outqty=$total['outqty'];
$inwght=$total['inwght'];
$weight=$total['weight'];
$outwght=$total['outwght'];
?>
</tbody>
<tfoot>
<tr>
<th colspan="3">Total</th>
<th class="th-right"><?= array_sum($inqty);?></th>
<th class="th-right"><?= array_sum($inwght);?></th>
<th class="th-right"><?= array_sum($qty);?></th>
<th class="th-right"><?= array_sum($weight);?></th>
<th class="th-right"><?= array_sum($outqty);?></th>
<th class="th-right"><?= array_sum($outwght);?></th>
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