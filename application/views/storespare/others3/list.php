<table class="table table-striped table-bordered table-hover order-column" id="list">
<thead>
<tr>
<th> Others3 </th>
<th style="width:20%;"> Actions </th>
</tr>
</thead>
<tbody>
<?php 
if(count($list)){
foreach($list as $a):
?>
<tr>
<td><?= $a['NAME'];?></td>
<td>
<a href="javascript:" class="btn btn-sm blue edit" data-id="<?= $a['ID'];?>"><i class="icon-pencil"></i></a>
<a href="javascript:" class="btn btn-sm red delete" data-id="<?= $a['ID'];?>"><i class="icon-trash"></i></a>
</td>
</tr>
<?php
endforeach;
}
?>
</tbody>
</table>
<script>
$('#list').dataTable({
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