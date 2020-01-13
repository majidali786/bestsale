<table class="table table-striped table-bordered table-hover order-column" id="pending-purchase-invoices">
<thead>
<tr>
<th>Inv#</th>
<th>Date</th>
<th>Amount</th>
<th>Action</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
foreach($data as $row):
?>
<tr row-id="<?= $row['INVNO'];?>">
	<td><span><?= $row['INVNO'];?></span></td>
	<td><span><?= date("d/m/Y",strtotime($row['VDATE']));?></span></td>
	<td><span><?= number_format($row['DIF']);?></span></td>
    <td class="theme-bg theme-border text-align-center" ><button type="button" class="btn green"><i class="icon-check"></i> Select</button></td>
</tr>
<?php 
endforeach;
?>
</tbody>
</table>
<script>

$(document).find("#pending-purchase-invoices").on("click",".green",function(){
var val=$(this).parents("[row-id]").attr("row-id");	
$(document).find("[name=invno]").val(val);
$(this).parents(".modal").modal("hide");
});
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
</script>