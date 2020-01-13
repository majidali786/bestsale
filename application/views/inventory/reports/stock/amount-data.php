<h3><button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" print-format="pdf"  print-name="stkamt" ><i class="icon-printer"></i> Pdf</button> <button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="stkamt" ><i class="icon-printer"></i> Excel</button>
</h3>
<?php 
$bid = array_column($data[1], 'B_ID');
$bid = array_unique($bid);
$bid = array_values($bid);
sort($bid);
?>
<table class="table table-striped table-bordered table-hover order-column" id="amount-data">
<thead>
<tr>
<th rowspan="2">Sr</th>
<th rowspan="2">Name</th>
<th rowspan="2">Unit</th>
<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 
for($b=0;$b<count($bid);$b++){
?>
<th style="text-align: center;" colspan="3"><?= $branch[$bid[$b]]?></th>
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
<th>Qty</th>
<th>Rate</th>
<th>Amount</th>
<?php 
$total[$bid[$b]]['qty']=array();	
$total[$bid[$b]]['amount']=array();	
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
<td><?= $sr;?></td>
<td><?= $a['PNAME'];?></td>
<td><?= $a['UNIT'];?></td>
<?php 
for($b=0;$b<count($bid);$b++){
$qty=$rate=$amount=0;
foreach($data[1] as $c){
if($bid[$b]==$c['B_ID'] && $a['PCODE']==$c['PCODE']){
$qty=$c['QTY']; 
$rate=$c['RATE']; 
$amount=$qty*$rate;
}	
}
array_push($total[$bid[$b]]['qty'],$qty);
array_push($total[$bid[$b]]['amount'],$amount);
?>
<td class="th-right"><?= number_format($qty,2);?></td>
<td class="th-right"><?= number_format($rate,2);?></td>
<td class="th-right"><?= number_format($amount,2);?></td>
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
<th colspan="3">Total</th>
<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

for($b=0;$b<count($bid);$b++){
$qty=$total[$bid[$b]]['qty'];
$amount=$total[$bid[$b]]['amount'];
?>
<th class="th-right"><?= array_sum($qty);?></th>
<th></th>
<th class="th-right"><?= array_sum($amount);?></th>
<?php 	
}
?>
</tr>
</tfoot>
</table>
<script>
$('#amount-data').dataTable({
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