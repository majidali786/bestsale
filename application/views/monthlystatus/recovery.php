
        <div class="portlet box red">
    <div class="portlet-title" style="text-align:center;">
        <div style="margin-top:10px;">Top 5 Sales Invoices Recovery</div>
    </div>
    <div class="portlet-body" style="padding: 0px;">
        <div class="table-responsive">
         <table id="table2" class="table table-bordered" style="margin:0px">
<thead>
<tr>
<th style="text-align:center;">Vr. No</th>
<th style="text-align:center;">Date</th>
<th style="text-align:center;">Book No</th>
<th style="text-align:center;">Code</th>
<th style="text-align:center;">Name</th>
<th style="text-align:center;">Net Amount</th>
</tr>
</thead>
<tbody class="theme-border">
<?PHP
foreach ($data as $data)
{
?>
<tr>
    <td style="text-align:left;"><span><?= $data['NO'];?></span></td>
    <td style="text-align:left;"><span><?= date('m/d/Y',strtotime($data['VDATE']));?></span></td>
    <td style="text-align:left;"><span><?= $data['VNO'];?></span></td>
    <td style="text-align:left;"><span><?= $data['ACODE'];?></span></td>
    <td style="text-align:left;"><span><?= $data['ANAME'];?></span></td>
    <td style="text-align:right;"><span><?= number_format($data['CREDIT'],2);?></span></td>
</tr>
<?PHP
}
?>
</tbody>
</table>
</div>