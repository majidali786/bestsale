<h3><i class="icon-user theme-color"></i><i class="icon-calendar theme-color"></i><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="list">
<thead class="theme-bg">
<tr>
<th>Code</th>
<th>Name</th>
<th>1-30 Days</th>
<th>31-45 Days</th>
<th>46-60 Days</th>
<th>61-90 Days</th>
<th>91-120 Days</th>
<th>Above 120 Days</th>
<th>Balance</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","DUBIA HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE"); 
$bal30=$bal45=$bal60=$bal90=$bal120=$bal121=$bal=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):

?>
<tr>
<td><?= $a['ACODE'];?></td>
<td><?= $a['ANAME'];?></td>
<td class="th-right"><?= number_format($a['BAL30'],2);?></td>
<td class="th-right"><?= number_format($a['BAL45'],2);?></td>
<td class="th-right"><?= number_format($a['BAL60'],2);?></td>
<td class="th-right"><?= number_format($a['BAL90'],2);?></td>
<td class="th-right"><?= number_format($a['BAL120'],2);?></td>
<td class="th-right"><?= number_format($a['BAL121'],2);?></td>
<td class="th-right"><?= number_format($a['BAL'],2);?></td>
</tr>
<?php
$sr++;
$bal+=$a['BAL'];
$bal30+=$a['BAL30'];
$bal45+=$a['BAL45'];
$bal60+=$a['BAL60'];
$bal90+=$a['BAL90'];
$bal120+=$a['BAL120'];
$bal121+=$a['BAL121'];
endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<th colspan="2">Total</th>
<th class="th-right"><?= number_format($bal30,2);?></th>
<th class="th-right"><?= number_format($bal45,2);?></th>
<th class="th-right"><?= number_format($bal60,2);?></th>
<th class="th-right"><?= number_format($bal90,2);?></th>
<th class="th-right"><?= number_format($bal120,2);?></th>
<th class="th-right"><?= number_format($bal121,2);?></th>
<th class="th-right"><?= number_format($bal,2);?></th>
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