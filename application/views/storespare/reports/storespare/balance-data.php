<table class="table table-striped table-bordered table-hover order-column" id="ss-stock-balance">
<thead>
<tr>
<th>Sr</th>
<th>Product</th>
<th>Department</th>
<th>Unit</th>
<th>Weight</th>
<th>Qty</th>
<th>Feet</th>
<th>Branch</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$twght=$tqty=$tfeet=$tamount=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
$tqty+=$a['TQT'];
$twght+=$a['TWGHT'];
$tfeet+=$a['TFT'];
?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['PNAME'];?></td>
<td><?= $a['UNIT'];?></td>
<td><?= $a['DPName'];?></td>
<td class="th-right"><?= number_format($a['TQT'],2);?></td>
<td class="th-right"><?= number_format($a['TWGHT'],2);?></td>
<td class="th-right"><?= number_format($a['TFT'],2);?></td>
<td class="th-right"><?= $branch[$a['B_ID']];?></td>
</tr>
<?php
$sr++;

endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($twght,2);?></td>
<td class="th-right"><?= number_format($tqty,2);?></td>
<td class="th-right"><?= number_format($tfeet,2);?></td>
<td></td>
</tr>
</tfoot>
</table>
<script>
$('#ss-stock-balance').dataTable({
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