<table class="table table-striped table-bordered table-hover order-column" id="pending-purchase-invoices">
<thead>
<tr>
<th>Sr</th>
<th>No.</th>
<th>Date</th>
<th>Total</th>
<th>Cleared</th>
<th>Balance</th>
<th>Days</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
if(!empty($data)){
$sr=1;	
foreach($data as $a):
$a['DIF']=abs($a['DIF']);
?>
<tr row-id="<?= $a['NO'].",".$a['DIF'];?>">
<td><?= $sr;?></td>
<td><?= $a['NO'];?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= number_format($a['NET']);?></td>
<td><?= number_format($a['NET']-$a['DIF']);?></td>
<td><?= number_format($a['DIF']);?></td>
<td><?= $a['INVDAYS'];?></td>
<td><button type="button" class="btn green"><i class="icon-check"></i> Select</button></td>
</tr>
<?php
$sr++;

endforeach;
}
?>
</tbody>
</table>
<script>
$('#pending-purchase-invoices').dataTable({
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
$(document).find("#pending-purchase-invoices").on("click",".green",function(){
var val=$(this).parents("[row-id]").attr("row-id");	
$(document).find("[name=invoices]").val(val);
$(document).find("[name=invoices]").trigger("change");
$(this).parents(".modal").modal("hide");
});
</script>