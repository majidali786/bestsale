<?php
$ttdebit=$ttcredit=$ttbal=$ttamount=$ttchq=$ttrem=0;
if(!empty($data)){
$sperson=array_column($data,"SPERSON");
$sperson=array_unique($sperson);
sort($sperson);
$sr=1;
for($b=0;$b<count($sperson);$b++){	
$tdebit=$tcredit=$tbal=$tamount=$tchq=$trem=0;	
?>
<h3><i class="icon-user theme-color"></i><i class="icon-calendar theme-color"></i><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-basket"></i> <?= $sperson[$b]?></b></h2>
</div>
<table class="table table-striped table-bordered table-hover order-column" id="aging-all-data-<?= $sr?>">
<thead class="theme-bg">
<tr>
<th>Name</th>
<th>Cr.Days</th>
<th>Cr.Limit</th>
<th>Debit</th>
<th>Credit</th>
<th>Amount</th>
<th>Chq & Slip</th>
<th>Remaining</th>
</tr>
</thead>
<tbody>
<?php 
foreach($data as $a):
if($a['SPERSON']==$sperson[$b])
{	
?>
<tr>
<td><?= $a['ANAME'];?></td>
<td class="th-right"><?= number_format($a['CDAYS']);?></td>
<td class="th-right"><?= number_format($a['CLIMIT']);?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['CREDIT'],2);?></td>
<td class="th-right"><?= number_format($a['BAL'],2);?></td>
<td class="th-right"><?= number_format($a['BAL2'],2);?></td>
<td class="th-right"><?= number_format($a['BAL3'],2);?></td>
</tr>
<?php
$tdebit+=$a['DEBIT'];
$tcredit+=$a['CREDIT'];
$tamount+=$a['BAL'];
$tchq+=$a['BAL2'];
$trem+=$a['BAL3'];
$ttdebit+=$a['DEBIT'];
$ttcredit+=$a['CREDIT'];
$ttamount+=$a['BAL'];
$ttchq+=$a['BAL2'];
$ttrem+=$a['BAL3'];
}
endforeach;
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<th colspan="3">Total</th>
<th class="th-right"><?= number_format($tdebit,2);?></th>
<th class="th-right"><?= number_format($tcredit,2);?></th>
<th class="th-right"><?= number_format($tamount,2);?></th>
<th class="th-right"><?= number_format($tchq,2);?></th>
<th class="th-right"><?= number_format($trem,2);?></th>
</tr>
</tfoot>
</table>
<script>
$('#aging-all-data-<?= $sr?>').dataTable({
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
<?php
$sr++; 
}
?>
<div class="row">

<div class="dashboard-stat red col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($ttdebit);?> </div>
<div class="desc"> Total Debit </div>
</div>
</div>

<div class="dashboard-stat green col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($ttcredit);?> </div>
<div class="desc"> Total Credit </div>
</div>
</div>
<div class="dashboard-stat purple col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($ttamount);?> </div>
<div class="desc"> Total Amount </div>
</div>
</div>

<div class="dashboard-stat blue col-sm-3">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($ttchq);?> </div>
<div class="desc"> Total Chq & Slip </div>
</div>
</div>

<div class="dashboard-stat yellow col-sm-12">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($ttrem);?> </div>
<div class="desc"> Total Remaining </div>
</div>
</div>

</div>

<?php 
}
?>