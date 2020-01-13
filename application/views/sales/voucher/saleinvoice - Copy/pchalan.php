<table class="table table-bordered table-striped table-condensed flip-content" id="chalan-data">
<thead class="flip-content theme-color border-theme">
<tr>
<th style="text-align:center">#</th>
<th style="text-align:center">Challan#</th>
<th style="text-align:center">Date</th>
<th style="text-align:center">Party</th>
<th style="text-align:center">Remarks</th>
<th style="text-align:center">Total</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
foreach($data as $row):
?>
<tr>
   
	<td><span><?= $rowNumber;?></span></td>
	
	 <td class="text-align-center" ><a href="javascript:void(0);" style="color:black" onclick="send_no('<?= $row['NO'];?>','input[name=dcno]','<?= $row['VCODE'];?>','<?= $row['VNAME'];?>','<?= date("d/m/Y",strtotime($row['VDATE']));?>');$('[name=vdate]').val('<?= date("d/m/Y",strtotime($row['VDATE']))?>');$('[name=address]').val('<?= $row['ADDR']; ?>');$('[name=ntn]').val('<?= $row['NTN']; ?>');$('[name=saletax]').val('<?= $row['STAX']; ?>')"><?= $row['NO'];?></button></td>
	 
	
	<td><span><?= date("d/m/Y",strtotime($row['VDATE']));?></span></td>
	<td><span><?= $row['VNAME'];?></span></td>
	<td><span><?= $row['REMARKS'];?></span></td>
    <td><span><?= $row['TOTAL'];?></span></td>
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