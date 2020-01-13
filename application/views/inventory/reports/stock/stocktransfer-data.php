<h3><i class="icon-user theme-color"></i><i class="icon-calendar theme-color"></i><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="" ><i class="icon-printer"></i> Excel</button>
</h3>
<table class="table table-striped table-bordered table-hover order-column" id="list">
<thead class="theme-bg">
<tr>
<th>Vr.No</th>
<th>Date</th>
<th>From Branch</th>
<th>To.Branch</th>
<th>Product</th>
<th>Unit</th>

<th>Quantity</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 
$bal=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):

?>
<tr>
	
<td><?= $a['NO'];?></td>
<td style="text-align:center"><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td><?= $a['FBRANCH'];?></td>
<td><?= $a['TBRANCH'];?></td>
<td><?= $a['PNAME'];?></td>
<td><?= $a['UNIT'];?></td>

<td class="th-right"><?= number_format($a['QTY'],2);?></td>
 <td><a href="<?= base_url("inventory/stock-transfer/".$a['NO'])?>" target="blank" class="btn btn-sm blue"><i class="icon-link"></i></a>
</tr>
<?php
$sr++;
$bal+=$a['QTY'];


endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<tr>
<th colspan="6">Total</th>

<th class="th-right"><?= number_format($bal,2);?></th>
</tr>
</tfoot>
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