<h3><i class="icon-user theme-color"></i><i class="icon-calendar theme-color"></i><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="list">
<thead>
<tr>
<th>Sr</th>
<th>Code</th>
<th>Name</th>
<th><?= date("M/y",strtotime($vdate))?></th>
<th><?= date("M/y",strtotime($vdate2))?></th>
<th><?= date("M/y",strtotime($vdate3))?></th>
</tr>
</thead>
<tbody>
<?php 
$total1=$total2=$total3=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['ACODE'];?></td>
<td><?= $a['ANAME'];?></td>
<td class="th-right"><?= number_format($a['BAL'],2);?></td>
<td class="th-right"><?= number_format($a['BAL2'],2);?></td>
<td class="th-right"><?= number_format($a['BAL3'],2);?></td>
</tr>
<?php
$sr++;
$total1+=$a['BAL'];
$total2+=$a['BAL2'];
$total3+=$a['BAL3'];
endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($total1,2);?></td>
<td class="th-right"><?= number_format($total2,2);?></td>
<td class="th-right"><?= number_format($total3,2);?></td>
</tr>
</tfoot>
</table>
<script>
$('#list').dataTable({
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