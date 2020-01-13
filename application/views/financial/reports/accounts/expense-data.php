<?php 
$chqsData=$data['data2'];
$data=$data['data1'];
if(!empty($data)){
?>
<h3><i class="icon-user theme-color"></i> : <?= $data[0]['ANAME'];?> (<?= $date1?> <i class="icon-calendar theme-color"></i> <?= $date2?>) 
<button type="button" class="btn green pull-right" style="margin-left:5px;" print print-type="report" 
print-format="pdf"  print-name="expense" ><i class="icon-printer"></i> Pdf</button> 
<button type="button" class="btn green pull-right" print print-type="report" print-format="xls"  print-name="expense" >
<i class="icon-printer"></i> Excel</button>
</h3>
<?php 
}
?>
<table class="table table-striped table-bordered table-hover order-column" id="expense-data">
<thead>
<tr>
<th>Sr</th>
<th>Code</th>
<th>Account Name</th>
<th>Debit</th>
<th>Credit</th>
<th>Balance</th>
<th>Branch</th>
</tr>
</thead>
<tbody>


<?php
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 

$tdebit=$tcredit=$bal=0;
if(!empty($data)){
$sr=1;	
foreach($data as $a):
$bal+=$a['DEBIT'];
$bal-=$a['CREDIT'];
$tdebit+=$a['DEBIT'];
$tcredit+=$a['CREDIT'];
if($a['JO']=='OP')
{
	$style= "background-color:#ff6e6e";
}
else {
	$style= "";
}
?>
<tr style="<?= $style; ?>">
<td><?= $sr;?></td>
<td><?= $a['ACODE'];?></td>
<td><?= $a['ANAME'];?></td>
<td class="th-right"><?= number_format($a['DEBIT'],2);?></td>
<td class="th-right"><?= number_format($a['CREDIT'],2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td><?= $a['BNAME'];?></td>
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
<td class="th-right"><?= number_format($tdebit,2);?></td>
<td class="th-right"><?= number_format($tcredit,2);?></td>
<td class="th-right"><?= number_format($bal,2);?></td>
<td></td>
</tr>
</tfoot>
</table>
<?php 
if(!empty($chqsData)){
?>
<div class="note note-success margin-bottom-10">
<h2 class="margin-0"><b><i class="icon-layers"></i> Chqs In Hand</b></h2>
</div>
<table class="table table-bordered table-striped table-condensed" id="chqs-data">
<thead class="flip-content theme-color border-theme">
<tr>
<th>#</th>
<th>Party/Account</th>
<th>Bank</th>
<th>Description</th>
<th>Cheque No.</th>
<th>Chq. Date</th>
<th>Amount</th>
</tr>
</thead>
<tbody class="theme-border">
<?php
$rowNumber=1; 
$debit=0;
foreach($chqsData as $row):
if(!empty($row['CHQDATE'])){
$row['CHQDATE']=date("d/m/Y",strtotime($row['CHQDATE']));	
}
$debit+=$row['DEBIT'];
?>
<tr>
    <td>
	<?= $rowNumber;?>
	</td>
    <td><?= $row['ACODE']."-".$row['ANAME'];?>
    </td>
	<td><?= $row['BNAME'];?></td>
    <td><?= $row['DESCR'];?></td>
    <td><?= $row['CHQNO'];?></td>
	<td><?= $row['CHQDATE'];?></td>
    <td class="th-right"><?= lakhseparater($row['DEBIT']);?></td>
</tr>
<?php 
$rowNumber ++;
endforeach;
?>
</tbody>
<tfoot class="border-theme">
<tr>
<th colspan="6">Total</th>
<td class="theme-bg th-right"><?= lakhseparater($debit);?></td>
</tr>
</tfoot>
</table>

<?php 	
}
?>
<script>
$('#expense-data,#chqs-data').dataTable({
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