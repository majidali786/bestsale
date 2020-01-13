<?php 
$branch=array("","DUBAI HEAD OFFICE","AJMAN MY NIGHT","STAR NEW YORK","STAR ANTLIYA","BLACK AND WHITE","STAR BIRD LIFE"); 
if(!empty($data1)){
?>
<table class="table table-bordered">
<tr>
<th style="width:20%;" class="theme-bg"><b>Voucher No.</b></th><td><?= $data1[0]['NO']?></td>
<th style="width:20%;" class="theme-bg"><b>Voucher Date</b></th><td><?= date("d/m/Y",strtotime($data1[0]['VDATE']))?></td>
</tr>
<tr>
<th class="theme-bg"><b>Party</b></th><td colspan="2"><?= $data1[0]['VCODE']." - ".$data1[0]['VNAME']?></td>
<th class="theme-bg"><b>Sales Account</b></th><td colspan="2"><?= $data1[0]['SCODE']." - ".$data1[0]['SNAME']?></td>
</tr>
<tr>
<th class="theme-bg"><b>Address</b></th><td colspan="2"><?= $data1[0]['ADDR']?></td>
<th class="theme-bg"><b>Salesman</b></th><td colspan="2"><?= $data1[0]['DPNAME']?></td>
</tr>
<tr>
<th style="width:20%;" class="theme-bg"><b>Book No.</b></th><td><?= $data1[0]['VNO']?></td>
<th style="width:20%;" class="theme-bg"><b>Mobile</b></th><td><?= $data1[0]['SONO']?></td>
<th style="width:20%;" class="theme-bg"><b>E-Mail.</b></th><td><?= $data1[0]['DCNO']?></td>
</tr>
<tr>
<th class="theme-bg"><b>Remarks</b></th><td colspan="5"><?= $data1[0]['REMARKS']?></td>
</tr>
</table>
<table class="table table-bordered">
<tr class="theme-bg">
<th>#</th>
<th style="width:40%";>Product</th>
<th style="width:10%";>Unit</th>
<th style="width:10%";>Weight</th>
<th style="width:10%";>Qty</th>
<th style="width:10%";>Feet</th>
<th style="width:10%";>Rate</th>
<th style="width:10%";>Amount</th>
</tr>
<?php
$rowNumber=1;
$tqty=$tamount=0; 
foreach($data2 as $row):
?>
<tr>
<td><?= $rowNumber?></td>
<td><?= $row['PNAME']?></td>
<td><?= $row['UNIT']?></td>
<td class="th-right"><?= number_format($row['QTY'],1)?></td>
<td class="th-right"><?= number_format($row['RATE'],1)?></td>
<td class="th-right"><?= number_format($row['AMOUNT'])?></td>
</tr>
<?php 
$rowNumber++;
$tqty+=$row['QTY'];
$tamount+=$row['AMOUNT'];
endforeach;
?>
<tfoot>
<tr class="theme-bg">
<th colspan="4">Total</th>
<td class="th-right"><?= number_format($tqty,1)?></td>
<td colspan="2"></td>
<td class="th-right"><?= number_format($tamount)?></td>
</tr>
</tfoot>
</table>
<table class="table table-bordered">
<tr class="theme-bg">
<th><b>Kanta Weight</b></th>
<th><b>Discount</b></th>
<th><b>Freight</b></th>
<th><b>Loading</b></th>
<th><b>Others</b></th>
<th><b>Net</b></th>
</tr>
<tr>
<td class="th-right"><?= number_format($data1[0]['KWEIGHT'])?></td>
<td class="th-right"><?= number_format($data1[0]['DISCOUNT'])?></td>
<td class="th-right"><?= number_format($data1[0]['FREIGHT'])?></td>
<td class="th-right"><?= number_format($data1[0]['LOADING'])?></td>
<td class="th-right"><?= number_format($data1[0]['OTHERS'])?></td>
<td class="th-right"><?= number_format($data1[0]['NET'])?></td>
</tr>
<tr class="theme-bg">
<th><b>Bilty No</b></th>
<th><b>Bilty Date</b></th>
<th><b>Ship Via</b></th>
<th><b>Previous</b></th>
<th><b>Current</b></th>
<th><b>Total</b></th>
</tr>
<tr>
<td><?= $data1[0]['BNO']?></td>
<td class="th-right"><?= date("d/m/Y",strtotime($data1[0]['BDATE']))?></td>
<td><?= $data1[0]['TRANSPORT']?></td>
<td class="th-right"><?= number_format($data1[0]['PBAL'])?></td>
<td class="th-right"><?= number_format($data1[0]['NET'])?></td>
<td class="th-right"><?= number_format($data1[0]['TBAL'])?></td>
</tr>
</table>
<input type="hidden" name="tamount" value="<?= $data1[0]['NET']?>"/>

<table class="table table-bordered table-striped table-condensed flip-content">
<tr class="theme-bg">
<th>Discount</th>
<th>Freight</th>
<th>Loading</th>
<th>Others</th>
<th>Net</th>
</tr>
<tr>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-12" data-position="12" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result" name="discount"  placeholder="Discount"></td>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-13" data-position="13" name="freight" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result"  placeholder="Freight"></td>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-14" data-position="14" name="loading" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result" placeholder="Loading"></td>
<td  class="show-error"><input type="text" data-only-numbers class="form-control move-enter-up move-enter-15" data-position="15" name="others" data-dmas="tamount-add,discount-minus,freight-add,loading-add,others-add,net-result,current-result,previous-add,total-result"  placeholder="Others"></td>
<td><input type="text" class="form-control theme-bg" readonly name="net"  placeholder="Net"></td>
</tr>
</table>
<script>
reinitializeTable(1);
</script>
<?php 
}
?>
