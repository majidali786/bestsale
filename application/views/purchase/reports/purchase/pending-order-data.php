<h3>(<?= $date1?> <i class="icon-calendar theme-color"></i> <?= $date2?>) <button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="pendingorder" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="pendingorder" ><i class="icon-printer"></i> Excel</button>
</h3>

<table class="table table-striped table-bordered table-hover order-column" id="pending-order-data">
<thead>
<tr>
<th style="text-align:center">Sr.No</th>
<th style="text-align:center">Date</th>
<th style="text-align:center">Order.No</th>
<th style="text-align:center">Party Name</th>
<th style="text-align:center">Design</th>
<th style="text-align:center">Image</th>
<th style="text-align:center">Color</th>
<th style="text-align:center">Balance</th>
<th style="text-align:center">Pending.Days</th>

<th style="width:10%">Action</th>

</tr>
</thead>

<tbody>
<?php
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE"); 
$toqty=$tdqty=$tpqty=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):



?>
<tr>
<td style="text-align:center"><?= $sr;?></td>
<td style="text-align:center"><?= date("d/m/Y",strtotime($a['VDATE']));?></td>
<td style="text-align:center"><?= $a['NO'];?></td>
<td><?= $a['VNAME'];?></td>
<td><?= $a['PNAME'];?></td>
<td> <img src="<?= base_url("product/category/thumb_".$a['IMG']);?>" /></td>
<td style="text-align:center"><?= $a['COLOR'];?></td>
<td style="text-align:center"><?= $a['QTY'];?></td>
<td style="text-align:center"><?= $a['PDAYS'];?></td>
<td style="text-align:center"><?= $a['STATUS'];?></td>

<!-- <td>
<select name="action" class="form-control" onchange="changeOrderStatus(this.value,'<?= $a['NO'];?>','<?= $a['PCODE'];?>');" >
<option value="Open" <?php if($a['STATUS']!='Close') { ?> selected <?php } ?> >Open</option>
<option value="Close" <?php if($a['STATUS']=='Close') { ?> selected <?php } ?> >Close</option>
</select>
</td> -->

<?php
$sr++;
$toqty+=$a['QTY'];

endforeach;
}
?>
</tbody>
<tfoot class="theme-bg">
<th colspan="7">Total</th>

<td style="text-align:center"><?= number_format($toqty,2);?></td>
<td class="th-right"></td>

</tfoot>
</table>
<script>
$('#pending-order-data').dataTable({
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