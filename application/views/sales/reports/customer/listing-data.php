<table class="table table-striped table-bordered table-hover order-column" id="listing-data">
<thead>
<tr>
<th>Sr</th>
<th>Code</th>
<th>Name</th>
<th>Address</th>
<th>Phone</th>
<th>Mobile</th>
<th>Climit</th>
<th>Credit Days</th>
<th>City</th>
<th>Salesman</th>
<th>Type</th>
<th>Status</th>
<th>Branch</th>
</tr>
</thead>
<tbody>
<?php 
if(count($data)){
$sr=1;	
$branch=array("","HEAD OFFICE","GJW OUTLET","KAROL GUDAM","CHINA SCHEME GUDAM");
$type=array("Cash","Credit");
$status=array("Deactive","Active");
foreach($data as $a):
if($a['PTYPE']==''){
$a['PTYPE']=1;	
}
if($a['STATUS']==''){
$a['STATUS']=1;	
}
?>
<tr>
<td><?= $sr;?></td>
<td><?= $a['VCODE'];?></td>
<td><?= $a['VNAME'];?></td>
<td><?= $a['ADDR'];?></td>
<td><?= $a['PHONE'];?></td>
<td><?= $a['MOBILE'];?></td>
<td><?= $a['CLIMIT'];?></td>
<td><?= $a['CDAYS'];?></td>
<td><?= $a['CITY'];?></td>
<td><?= $a['SPERSON'];?></td>
<td><?= $type[$a['PTYPE']];?></td>
<td><?= $status[$a['STATUS']];?></td>
<td><?= $branch[$a['B_ID']];?></td>
</tr>
<?php
$sr++;
endforeach;
}
?>
</tbody>
</table>
<script>
$('#listing-data').dataTable({
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