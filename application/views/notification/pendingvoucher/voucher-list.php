<div class="todo-tasks-container">
<div class="todo-head">
<h3>
<span class="todo-grey">Voucher :</span> <?= $joInWords[$data['jo']]?></h3>

</div>
<div class="todo-tasks-content" style="padding-top: 10px;">
<table class="table table-striped table-bordered table-hover order-column" id="voucher-list">
<thead>
<tr>
<th> Sr #</th>
<th> Voucher No. </th>
<th> Posted Date. </th>
<th> Posted By </th>
<th> Action </th>
</tr>
</thead>
<tbody>
<?php 
if(!empty($list)){
$sr=1;	
foreach($list as $a):
?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['NO'];?></td>
<td><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['U_ID'];?></td>
<td>
<a href="<?= base_url($JoLinks[$a['JO']]."/".$a['NO'])?>" target="blank" class="btn btn-sm blue"><i class="icon-link"></i></a>
</td>
</tr>
<?php
$sr++;
endforeach;
}
?>
</tbody>
</table>

</div>
<script>
$('#voucher-list').dataTable({
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
</div>
