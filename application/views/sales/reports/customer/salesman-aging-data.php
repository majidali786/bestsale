<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>

<table class="table table-striped table-bordered table-hover order-column" id="ledger-data">
<thead class="theme-bg">
<tr>
<th>Sr#</th>
<th>Customer</th>
<th>Opening</th>
<th>Net Sale</th>
<th>Gross</th>
<th>Recovery</th>
<th>Balance</th>
<th>% Recovery to Sale</th>
<th>% Balance to Sale</th>
</tr>
</thead>
<tbody>
<?php
$tot1 = 0;
$tot2 = 0;
$tot3 = 0;
$tot4 = 0;
$tdebit=$tcredit=$bal=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
$gross = $a['op']+$a['sale'];
$bal = $gross-$a['recovry'];
$sale = $a['sale'];
$recry = $a['recovry'];
if($sale==0)
{
$bal_sale = 0;
$per_bal = 0;
}	else {
$bal_sale = ($recry/$sale)*100;
$per_bal = ($bal/$sale)*100;
}

?>
<tr>
<td><?= $sr;?></td>
<td class="th-right"><?= $a['VNAME'];?></td>
<td class="th-right"><?= number_format($a['op']);?></td>
<td class="th-right"><?= number_format($a['sale']);?></td>
<td class="th-right"><?= number_format($gross);?></td>
<td class="th-right"><?= number_format($a['recovry']);?></td>
<td class="th-right"><?= number_format($bal,1);?></td>
<td class="th-right"><?= number_format($bal_sale,3);?> %</td>
<td class="th-right"><?= number_format($per_bal,3);?> %</td>
</tr>
<?php
$sr++;
$tot1 = $tot1 + $a['op'];
$tot2 = $tot2 + $a['sale'];
$tot3 = $tot3 + $gross;
$tot4 = $tot4 + $a['recovry'];
endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<td style="text-align:right" colspan="2">Total</td>
<td style="text-align:right"><?= number_format($tot1); ?></td>
<td style="text-align:right"><?= number_format($tot2); ?></td>
<td style="text-align:right"><?= number_format($tot3); ?></td>
<td style="text-align:right"><?= number_format($tot4); ?></td>
<td colspan="3"></td>
</tr>
</tfoot>
</table>

<table class="table table-striped table-bordered table-hover order-column" id="ledger-data2">
<thead class="theme-bg">
<tr>
<th>Sr#</th>
<th>Salesman</th>
<th>Opening</th>
<th>Net Sale</th>
<th>Gross</th>
<th>Recovery</th>
<th>Balance</th>
<th>% Recovery to Sale</th>
<th>% Balance to Sale</th>
</tr>
</thead>
<?php
$tot1 = 0;
$tot2 = 0;
$tot3 = 0;
$tot4 = 0;
$tdebit=$tcredit=$bal=0;
if(!empty($data2)){
$sr=1;	
foreach($data2 as $a):
$gross = $a['op']+$a['sale'];
$bal = $gross-$a['recovry'];
$sale = $a['sale'];
$recry = $a['recovry'];
if($sale==0)
{
$bal_sale = 0;
$per_bal = 0;
}	else {
$bal_sale = ($recry/$sale)*100;
$per_bal = ($bal/$sale)*100;
}

?>
<tr>
<td><?= $sr;?></td>
<td class="th-right"><?= $a['SPERSON'];?></td>
<td class="th-right"><?= number_format($a['op']);?></td>
<td class="th-right"><?= number_format($a['sale']);?></td>
<td class="th-right"><?= number_format($gross);?></td>
<td class="th-right"><?= number_format($a['recovry']);?></td>
<td class="th-right"><?= number_format($bal,1);?></td>
<td class="th-right"><?= number_format($bal_sale,3);?> %</td>
<td class="th-right"><?= number_format($per_bal,3);?> %</td>
</tr>
<?php
$sr++;
$tot1 = $tot1 + $a['op'];
$tot2 = $tot2 + $a['sale'];
$tot3 = $tot3 + $gross;
$tot4 = $tot4 + $a['recovry'];
endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<td style="text-align:right" colspan="2">Total</td>
<td style="text-align:right"><?= number_format($tot1); ?></td>
<td style="text-align:right"><?= number_format($tot2); ?></td>
<td style="text-align:right"><?= number_format($tot3); ?></td>
<td style="text-align:right"><?= number_format($tot4); ?></td>
<td colspan="3"></td>
</tr>
</tfoot>
</table>
<script>
$('#ledger-data').dataTable({
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
$('#ledger-data2').dataTable({
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