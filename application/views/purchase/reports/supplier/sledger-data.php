<?php 
if(!empty($data)){
?>
<h3><i class="icon-user theme-color"></i> : <?= $data[0]['ACODE']."-".$data[0]['ANAME'];?> (<?= $date1?> <i class="icon-calendar theme-color"></i> <?= $date2?>)</h3>
<?php 
}
?>
<h3><i class="icon-user theme-color"></i><i class="icon-calendar theme-color"></i><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="sledger" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="sledger-data">
<thead>
<tr>
<th Style="text-align:center">Sr#</th>
<th Style="text-align:center">Date</th>
<th Style="text-align:center">Vr.Type</th>
<th Style="text-align:center">Vr.No</th>
<th Style="text-align:center">Description</th>
<th Style="text-align:center">Debit</th>
<th Style="text-align:center">Credit</th>
<th Style="text-align:center">Balance درهم</th>

</tr>
</thead>
<tbody>
<?php
$branch=array("","DUBIA HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE"); 
$tdebit=$tcredit=$bal=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
$bal+=$a['DEBIT'];
$bal-=$a['CREDIT'];
$tdebit+=$a['DEBIT'];
$tcredit+=$a['CREDIT'];
if($a['B_ID']==""){
$a['B_ID']=1;	
}
?>
<tr>
<td Style="text-align:center"><?= $sr;?></td>
<td Style="text-align:center"><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td Style="text-align:center"><?= $a['JO'];?></td>
<td Style="text-align:center"><a href="javascript:void(0);" onclick="vdetail('<?= $a['NO'];?>','<?= $a['JO'];?>','<?= $a['B_ID'];?>','<?= $a['VDATE'];?>');"><?= $a['NO'];?></a></td>
<td><?= $a['DESCR'];?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['CREDIT'],2);?></td>
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
<th colspan="5">Total</th>
<td class="th-right"><?= number_format($tdebit,2);?></td>
<td class="th-right"><?= number_format($tcredit,2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td></td>
</tr>
</tfoot>
</table>
<script>
$('#sledger-data').dataTable({
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