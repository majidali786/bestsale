<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="custage" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="custage" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="aging-data">
<thead>
<tr>
<th>Sr</th>
<th>Vr.Type</th>
<th>No</th>
<th>Date</th>
<th>Amount</th>
<th>Balance</th>
<th>Inv. Days</th>
<th>Branch</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM"); 
$tdebit=$tcredit=$bal=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):

?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['NO'];?></td>
<td><a href="javascript:void(0);" onclick="vdetail('<?= $a['NO'];?>','<?= $a['JO'];?>','<?= $a['B_ID'];?>','<?= $a['VDATE'];?>');"><?= $a['NO'];?></a></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['BAL'],2);?></td>
<td><?= $a['INVDAYS'];?></td>
<td><?= $branch[$a['B_ID']];?></td>
</tr>
<?php
$sr++;
$bal=$a['BAL'];
endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="5">Total</th>
<td class="th-right"><?= number_format($bal,2);?></td>
<td></td>
<td></td>
</tr>
</tfoot>
</table>
<?php 
if(!empty($data)){
?>
<table class="table table-bordered">
<tr class="theme-bg">
<th class="th-center">First 15 days</th>
<th class="th-center">16 to 30 days</th>
<th class="th-center">31 to 45 days</th>
<th class="th-center">46 to 60 days</th>
</tr>
<tr>
<td class="th-green"><?= number_format($data[0]['BAL15'])?></td>
<td class="th-yellow"><?= number_format($data[0]['BAL30'])?></td>
<td class="th-red"><?= number_format($data[0]['BAL45'])?></td>
<td class="th-red"><?= number_format($data[0]['BAL60'])?></td>
</tr>
<tr class="theme-bg">
<th class="th-center">61 to 75 days</th>
<th class="th-center">76 to 90 days</th>
<th class="th-center">91 to 120 days</th>
<th class="th-center">Above 120 Days</th>
</tr>
<tr class="th-red">
<td><?= number_format($data[0]['BAL75'])?></td>
<td><?= number_format($data[0]['BAL90'])?></td>
<td><?= number_format($data[0]['BAL105']+$data[0]['BAL120'])?></td>
<td><?= number_format($data[0]['BAL121'])?></td>
</tr>
</table>
<?php 
}
?>
<script>
$('#aging-data').dataTable({
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