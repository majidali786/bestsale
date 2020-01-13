
<table class="table table-striped table-bordered table-hover order-column" id="chalan-data">
<thead>
<tr>
<th>Sr#</th>
<th>Order#</th>
<th>Date</th>
<th>Party</th>
<th>Delivery Days</th>
</tr>
</thead>

<tbody>
<?php
$rowNumber=1; 
foreach($data as $row):
?>
<tr>
    <td><span><?= $rowNumber;?></span></td>
    <td class="text-align-center" ><a href="javascript:void(0);" style="color:black;font-size:15px;" 
	onclick="send_no('<?= $row['NO'];?>','input[name=sordrno]','<?= $row['VCODE'];?>','<?= $row['VNAME'];?>','<?= date("d/m/Y",strtotime($row['VDATE']));?>')"><?=$row['NO'] ;?></button></td>
	
	<td><span><?= date("d/m/Y",strtotime($row['VDATE']));?></span></td>
	<td><span><?= $row['VNAME'];?></span></td>
	<td><span><?= $row['CRDAYS'];?></span></td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>


</table>

<script>
$('#chalan-data').dataTable({
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
                bStateSave: !0,
                lengthMenu: [
                    [6, 15, 20, -1],
                    [6, 15, 20, "All"]
                ],
                pageLength: 6,
                columnDefs: [{
                    targets: [0]
                }, {
                    searchable: !1,
                    targets: [0]
                }],
                order: [
                    [1, "asc"]
                ]
            });
</script>