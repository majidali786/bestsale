<table class="table table-striped table-bordered table-hover order-column" id="bookno-closed">
<thead>
<tr>
<th>Sr</th>
<th>Book No</th>
<th>Serial</th>
<th>Type</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$type=array("","Canceled","Not Found");
if(!empty($data)){
$sr=1;	
foreach($data as $a):
?>
<tr row-id="<?= $a['NO'].",".trim($a['BNO']).",".$a['SNO'].",".$a['B_ID'];?>">
<td><?= $sr;?></td>
<td><?= $a['BOOKNO'];?></td>
<td><?= $a['NO'];?></td>
<td><?= $type[$a['TYPE']];?></td>
<td>
<button type="button" class="btn green"><i class="icon-action-undo"></i> Re Use</button>
</td>
</tr>
<?php
$sr++;
endforeach;
}
else{
?>
<?php 	
}
?>
</tbody>
</table>
<script>
$('#bookno-closed').dataTable({
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
$(document).find("#bookno-closed").on("click",".green",function(){
var val=$(this).parents("[row-id]").attr("row-id");	
var data={
	val:val
}
var url='<?= base_url("data/bookno-closed-undo")?>';
bootbox.dialog({
	message: "Are you sure you want to Re Use this Book No Serial?",
	title:notifications['reuse'],
	buttons: {
	danger:{
	label: "Re Use <i class='icon-action-undo'></i>",
	className: "green",
	callback: function(){
	$.post(url,data,function(response){
	if(response.success=="true"){
	$(document).find(".bookno-closed").trigger("click");	
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