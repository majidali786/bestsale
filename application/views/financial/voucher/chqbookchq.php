<div class="tabbable tabbable-tabdrop">
<ul class="nav nav-tabs">
<li <?php if(!empty($data)){ echo 'class="active"'; }?>>
<a href="#chqs-available" data-toggle="tab">Available</a>
</li>
<li <?php if(empty($data)){ echo 'class="active"'; }?>>
<a href="#chqs-canceled" data-toggle="tab">Canceled</a>
</li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="chqs-available">
<?php if(!empty($data)){
?>
<table class="table table-striped table-bordered table-hover order-column" id="pending-chqs">
<thead>
<tr>
<th>Sr</th>
<th>Bank</th>
<th>Book No</th>
<th>Available Cheques</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$sr=1;	
foreach($data as $a):
?>
<tr row-id="<?= $a['BNO']."-".$a['CHQNO'];?>">
<td><?= $sr;?></td>
<td><?= $a['BNAME'];?></td>
<td><?= $a['BNO'];?></td>
<td><?= $a['CHQNO'];?></td>
<td>
<button type="button" class="btn green"><i class="icon-check"></i> Select</button>
<button type="button" class="btn red"><i class="icon-close"></i> Cancel</button>
</td>
</tr>
<?php
$sr++;
endforeach;
?>
</tbody>
</table>
<script>
$('#pending-chqs').dataTable({
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
$(document).find("#pending-chqs").on("click",".green",function(){
var val=$(this).parents("[row-id]").attr("row-id");	
if($('.modal-edit-row').is(':visible')){	
$(document).find("[name=chqNo_e]").val(val);	
}
else{
$(document).find("[name=chqNo]").val(val);	
}
$(this).parents(".modal").modal("hide");
$(document).find("[name=descrip]").focus();
});
$(document).find("#pending-chqs").on("click",".red",function(){
var val=$(this).parents("[row-id]").attr("row-id");	
var data={
	bcno:val,
	bank:'<?= $data[0]['BCODE']?>'
}
var url='<?= base_url("data/chq-book-chqs-cancel")?>';
bootbox.dialog({
	message: "Are you sure you want to cancel this cheque?",
	title:notifications['cancel'],
	buttons: {
	danger:{
	label: "Cancel <i class='icon-close'></i>",
	className: "red",
	callback: function(){
	$.post(url,data,function(response){
	if(response.success=="true"){
	$(document).find("[name=bchqbook]").trigger("change");	
	bootbox.dialog({title:notifications['success'],message:"Successfully Closed",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){  }}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red"}}});	
	}
	},"json");
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
	});
});
</script>
<?php 
}
?>
</div>
<div class="tab-pane" id="chqs-canceled">
<?php 
if(!empty($data2)){
?>
<table class="table table-striped table-bordered table-hover order-column" id="cancel-chqs">
<thead>
<tr>
<th>Sr</th>
<th>Bank</th>
<th>Book No</th>
<th>Cancel Cheques</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$sr=1;	
foreach($data2 as $a):
?>
<tr row-id="<?= $a['BNO']."-".$a['CHQNO'];?>">
<td><?= $sr;?></td>
<td><?= $a['BNAME'];?></td>
<td><?= $a['BNO'];?></td>
<td><?= $a['CHQNO'];?></td>
<td>
<button type="button" class="btn green"><i class="icon-action-undo"></i> Re Use</button>
</td>
</tr>
<?php
$sr++;
endforeach;
?>
</tbody>
</table>
<script>
$('#cancel-chqs').dataTable({
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
$(document).find("#cancel-chqs").on("click",".green",function(){
var val=$(this).parents("[row-id]").attr("row-id");	
var data={
	bcno:val,
	bank:'<?= $data[0]['BCODE']?>'
}
var url='<?= base_url("data/chq-book-chqs-cancel-undo")?>';
bootbox.dialog({
	message: "Are you sure you want to Re Use this cheque?",
	title:notifications['reuse'],
	buttons: {
	danger:{
	label: "Re Use <i class='icon-action-undo'></i>",
	className: "green",
	callback: function(){
	$.post(url,data,function(response){
	if(response.success=="true"){
	$(document).find("[name=bchqbook]").trigger("change");	
	bootbox.dialog({title:notifications['success'],message:"Successfully Closed",buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"green",callback:function(){  }}}});
	}
	else{
	bootbox.dialog({title:notifications['error'],message:response.error,buttons:{close:{label:'<i class="icon-check"></i> Ok',className:"red"}}});	
	}
	},"json");
	}
	},
	main:{
	label: "Cancel",
	className: "default",
	}
	}
	});
});
</script>
<?php 
}
?>
</div>
</div>
</div>
