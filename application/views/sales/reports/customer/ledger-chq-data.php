<h3><i class="icon-user theme-color"></i><i class="icon-calendar theme-color"></i><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="ledger-data">
<thead>
<tr>
<th>Sr</th>
<th>Date</th>
<th>Vr.Type</th>
<th>Vr.No</th>
<th>Chq.No</th>
<th>Description</th>
<th>Debit</th>
<th>Credit</th>
<th>Balance</th>
<th>Branch</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$tdebit=$tcredit=$bal=0;
if(!empty($data['data1'])){
$sr=1;	
foreach($data['data1'] as $a):
$bal+=$a['DEBIT'];
$bal-=$a['CREDIT'];
$tdebit+=$a['DEBIT'];
$tcredit+=$a['CREDIT'];
if($a['B_ID']==""){
$a['B_ID']=1;	
}
?>
<tr>
<td><?= $sr;?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['JO'];?></td>
<td><a href="javascript:void(0);" onclick="vdetail('<?= $a['NO'];?>','<?= $a['JO'];?>','<?= $a['B_ID'];?>','<?= $a['VDATE'];?>');"><?= $a['NO'];?></a></td>
<td><?= $a['CHQNO'];?></td>
<td><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['CREDIT'],2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td><?= $branch[$a['B_ID']];?></td>
</tr>
<?php
$sr++;

endforeach;
}
$legderBalance=$bal;
?>
</tbody>
<tfoot>
<tr>
<th colspan="6">Total</th>
<td class="th-right"><?= number_format($tdebit,2);?></td>
<td class="th-right"><?= number_format($tcredit,2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td></td>
</tr>
</tfoot>
</table>

<div class="row margin-bottom-10">

<div class="col-sm-12">
<div class="dashboard-stat blue">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($bal);?> </div>
<div class="desc"> Without Cheques Balance </div>
</div>
</div>
</div>

</div>

<table class="table table-striped table-bordered table-hover order-column" id="ledger-chqs">
<thead>
<tr>
<th>Vr.No</th>
<th>Chq.No</th>
<th>Chq Date</th>
<th>Description</th>
<th>Amount</th>
<th>Remaing</th>
<th>Balance</th>
</tr>
</thead>
<tbody>
<?php
$tdebit=$bal=0;
if(!empty($data['data2'])){
$sr=1;	
foreach($data['data2'] as $a):
$bal+=$a['BAL'];
$tdebit+=$a['DEBIT'];
?>
<tr>
<td><?= $a['NO'];?></td>
<td><?= $a['CHQNO'];?></td>
<td><?= date("d/m/Y",strtotime($a['CHQDATE']));?></td>
<td><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['BAL'],2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
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
<td class="th-right"><?= number_format($tdebit,2);?></td>
<th></th>
<td class="th-right"><?= number_format($bal,2);?></td>
</tr>
</tfoot>
</table>
<div class="row margin-bottom-10">

<div class="col-sm-12">
<div class="dashboard-stat red">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($bal);?> </div>
<div class="desc"> Post Dated Cheques Balance </div>
</div>
</div>
</div>

</div>

<div class="row margin-bottom-10">

<div class="col-sm-12">
<div class="dashboard-stat green">
<div class="visual">
<i class="fa fa-briefcase fa-icon-medium"></i>
</div>
<div class="details">
<div class="number"> Rs. <?= number_format($legderBalance-$bal);?> </div>
<div class="desc"> With Post Dated Cheques Balance </div>
</div>
</div>
</div>

</div>

<script>
$('#ledger-data,#ledger-chqs').dataTable({
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