<?php 
if(!empty($data)){
?>
<h3>(<?= $date1?> <i class="icon-calendar theme-color"></i> <?= $date2?>) <button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="bls" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="bls" ><i class="icon-printer"></i> Excel</button>
</h3>
<?php 
}
?>
<table class="table table-striped table-bordered table-hover order-column" id="trial">
<thead>
<tr>
<th>Sr</th>
<th>Code</th>
<th>Name</th>
<th>Debit</th>
<th>Credit</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","DUBIA HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE"); 
$optdebit=$optcredit=$tdebit=$tcredit=$ctdebit=$ctcredit=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
$opdebit=$opcredit=$debit=$credit=$cdebit=$ccredit=0;
if($a['BAL']>0){
$opdebit=$a['BAL'];	
}
else{
$opcredit=abs($a['BAL']);	
}
if($a['BAL3']>0){
$debit=$a['BAL3'];	
}
else{
$credit=abs($a['BAL3']);	
}
if($a['BAL2']>0){
$cdebit=$a['BAL2'];	
}
else{
$ccredit=abs($a['BAL2']);	
}
?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['ACODE'];?></td>
<td><?= $a['ANAME'];?></td>
<td class="th-right"><?= number_format($debit,2);?></td>
<td class="th-right"><?= number_format($credit,2);?></td>
</tr>
<?php
$sr++;
$tdebit+=$debit;
$tcredit+=$credit;

endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="3">Total</th>
<td class="th-right"><?= number_format($tdebit,2);?></td>
<td class="th-right"><?= number_format($tcredit,2);?></td>
</tr>
</tfoot>
</table>
<script>
$('#trial').dataTable({
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