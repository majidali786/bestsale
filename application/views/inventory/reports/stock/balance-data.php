<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" 
print-format="pdf"  print-name="stkbal" ><i class="icon-printer"></i> Pdf</button>
 <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  
 print-name="stkbal" ><i class="icon-printer"></i> Excel</button>
</h3>
<?php 
$bid = array_column($data[1], 'B_ID');
$bid = array_unique($bid);
$bid = array_values($bid);
sort($bid);
?>
<table class="table table-striped table-bordered table-hover order-column" id="balance-data">
<thead>
<tr>
<!--<th rowspan="2" style="text-align:center">Sr</th>
<th rowspan="2" style="text-align:center">Code</th> <td><?= $sr;?></td>
<td style="text-align:center"><?= $a['PCODE'];?></td>-->
<th rowspan="2" style="text-align:center">Image</th>
<th rowspan="2" style="text-align:center">Product Name</th>
<th rowspan="2" style="text-align:center">Color</th>
<th rowspan="2" style="text-align:center">Size</th>

<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

for($b=0;$b<count($bid);$b++){
?>
<th colspan="1" style="text-align:center"><?= $branch[$bid[$b]]?></th>
<?php 	
}
?>
</tr>
<tr>
<?php 
$total=array();
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

for($b=0;$b<count($bid);$b++){
?>
<th style="text-align:center">Quantity</th>

<?php 
$total[$bid[$b]]['qty']=array();	

}
?>
</tr>
</thead>
<tbody>
<?php 
if(count($data[0])){
$sr=1;	
foreach($data[0] as $a):
?>
<tr>


<td> <img src="<?= base_url("product/category/thumb_".$a['IMG']);?>" /></td>
<td><?= $a['PNAME'];?></td>
<td ><?= $a['COLOR'];?></td>
<td style="text-align:center"><?= $a['SIZE'];?></td>
<?php 
for($b=0;$b<count($bid);$b++){
$qty=$weight=0;
foreach($data[1] as $c){
if($bid[$b]==$c['B_ID'] && $a['PCODE']==$c['PCODE']){
$qty=$c['QTY'];	
	
}	
}
array_push($total[$bid[$b]]['qty'],$qty);

?>

<td class="th-right"><?= number_format($qty,2);?></td>

<?php 
}
?>
</tr>
<?php
$sr++;
endforeach;
}
?>
</tbody>
<tfoot>
<tr>
<th colspan="4">Total</th>
<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

for($b=0;$b<count($bid);$b++){
$qty=$total[$bid[$b]]['qty'];

?>
<th class="th-right"><?= array_sum($qty);?></th>

<?php 	
}
?>
</tr>
</tfoot>
</table>
<script>
$('#balance-data').dataTable({
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