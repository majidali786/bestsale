	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Purchase extends MY_Controller{

	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs","datatable","autocomplete");
	if(!$this->input->is_ajax_request() && $this->uri->segment(3))
	{
	$no=$this->uri->segment(3);	
	if(!is_numeric($no) || $this->uri->segment(4)){
	redirect(base_url($this->uri->segment(1)."/".$this->uri->segment(2)));	
	}
	}
	}
	public function DeleteImg($input,$id,$table){
	$this->db->set($input,"");
	$this->db->where($id);
	$this->db->update($table);
	return true;
	}
	function purchaseVoucher(){
	$mainTable="PURCH1";
	$mainTable2="PURCH2";
	$voucher_Jo="PU";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";		
	$this->load->model("purchaseVoucherModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vname","Party","required");
	$this->form_validation->set_rules("conversion","Purchase Account","required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");

	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}


	$data['rights']=$this->punchData['voucherrights'][0];
	$response=$this->purchaseVoucherModel->insert($data);
	if($response===true){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>$response));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$party=$this->dataModel->getSuppliers(4);
	$account=$this->dataModel->getAccounts(13);

	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Purchases Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['bdate']=date("d/m/Y",strtotime($data[0]['BDATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}

	function purchase(){
	$mainTable="PURCH1";
	$mainTable2="PURCH2";
	$voucher_Jo="PU";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";		
	$this->load->model("purchaseModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete" && $type!="designall"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vname","Party","required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");

	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}	

	if(!empty($_FILES['img']['design']))
	{
	$foldername="design";
	$uniquename = md5(microtime(true));	
	$path=$this->ImgUploadUrl()."order/".$foldername;
	$this->load->library('upload');
	if(!file_exists($path))
	{
	mkdir($path);	
	}
	$imageFullname=$uniquename."-".$data['design']."-".$data['no'];
	$rawname=$this->uploadImg($path,$imageFullname,"img");
	$data['img']=$rawname;	
	}
	else{
	$data['img']="";	
	}

	$data['rights']=$this->punchData['voucherrights'][0];
	$response=$this->purchaseModel->insert($data);
	if($response===true){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>$response));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}



	else if($this->uri->segment(3) && $type2!="delete" && $type=="designall"){
	$data=$this->input->post();	
	$design=$this->dataModel->query("SELECT TOP 15 NAME FROM DESIGN WHERE NAME LIKE '%".$data['query']."%'");
	if(!empty($design)){
	$response = $this->load->view("$segment1/voucher/$segment2/designall",["design"=>$design],true);	
	echo json_encode(array("success"=>"true","data"=>$response));
	}
	else{
	echo json_encode(array("error"=>"Not Found","success"=>"false"));	
	}
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$party=$this->dataModel->getParties(5);
	$account=$this->dataModel->getAccounts(13);



	$design=$this->dataModel->getData("DESIGN","","ID,NAME","NAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['design']=$design;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Purchases Order";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['bdate']=date("d/m/Y",strtotime($data[0]['BDATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	

	if(!empty($_FILES['img']['design']))
	{
	if($oldImage!="")
	{
	unlink($this->ImgUploadUrl()."order/design/".$oldImage);	
	unlink($this->ImgUploadUrl()."order/design/thumb_".$oldImage);	
	$this->purchaseModel->DeleteImg("IMG",array("ID"=>$this->input->post("id")),"");
	}		
	$foldername="design";
	$uniquename = md5(microtime(true));	
	$path=$this->ImgUploadUrl()."order/".$foldername;
	$this->load->library('upload');
	/* 					if(!file_exists($path))
	{
	mkdir($path);	
	}
	*/					$imageFullname=$uniquename."-".$data['design']."-".$data['id'];
	$rawname=$this->uploadImg($path,$imageFullname,"img");
	$data['img']=$rawname;	
	}
	else{
	$data['img']=$oldImage;	
	}





	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}



	function purchaseorder(){
	$mainTable="PORDR1";
	$mainTable2="PORDR2";
	$voucher_Jo="PO";		
	$gnrllgr="SGnrllgr";		
	$stock="STOCK_SORDR";		
	$this->load->model("purchaseOrderModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vname","Party","required");
	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}	
	$data['rights']=$this->punchData['voucherrights'][0];
	$check=$this->dataModel->getData("CGO2",array("SONO"=>$data['no'],"B_ID"=>$this->userData['B_ID']),"","");
	if(empty($check)){
	$response=$this->purchaseOrderModel->insert($data);
	if($response===true){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>$response));
	}
	}	else {
	echo json_encode(array("error"=>"Challan is Present against this Order"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$check=$this->dataModel->getData("CGO2",array("SONO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
	if(empty($check)){
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}	else {
	echo json_encode(array("error"=>"Challan is Present against this Order"));
	}		}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$party=$this->dataModel->getSuppliers(4);
	$design=$this->dataModel->getData("DESIGN","","ID,NAME","ID ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['party']=$party;
	$this->punchData['design']=$design;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['bdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="China Order";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['bdate']=date("d/m/Y",strtotime($data[0]['BDATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}


	function purchasedemand(){
	$mainTable="PORDR1";
	$mainTable2="PORDR2";
	$voucher_Jo="PO";		
	$stock="STOCK_SORDR";		
	$this->load->model("purchaseOrderModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vname","Party","required");
	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}	
	$data['rights']=$this->punchData['voucherrights'][0];
	$check=$this->dataModel->getData("CGO2",array("SONO"=>$data['no'],"B_ID"=>$this->userData['B_ID']),"","");
	if(empty($check)){
	$response=$this->purchaseOrderModel->insert($data);
	if($response===true){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>$response));
	}
	}	else {
	echo json_encode(array("error"=>"Challan is Present against this Order"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$check=$this->dataModel->getData("CGO2",array("SONO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
	if(empty($check)){
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}	else {
	echo json_encode(array("error"=>"Challan is Present against this Order"));
	}		}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$party=$this->dataModel->getSuppliers(4);
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$design=$this->dataModel->getData("DESIGN","","ID,NAME","NAME ASC");
	$size=$this->dataModel->getData("SIZE","","ID,SIZE","SIZE ASC");
	$color=$this->dataModel->getData("COLOR","","ID,NAME","NAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['party']=$party;
	$this->punchData['product']=$product;
	$this->punchData['design']=$design;
	$this->punchData['size']=$size;
	$this->punchData['color']=$color;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Demand Order";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}



	function purchaseReturn(){
	$mainTable="PRET1";
	$mainTable2="PRET2";
	$voucher_Jo="PR";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";		
	$this->load->model("purchaseReturnModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vname","Party","required");
	$this->form_validation->set_rules("conversion","Purchase Account","required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");

	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}


	$data['rights']=$this->punchData['voucherrights'][0];
	$response=$this->purchaseReturnModel->insert($data);
	if($response===true){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>$response));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$party=$this->dataModel->getSuppliers(4);
	$account=$this->dataModel->getAccounts(13);

	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Purchases Return Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['bdate']=date("d/m/Y",strtotime($data[0]['BDATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}	

	function transfer(){
	$mainTable="TRANS1";
	$mainTable2="TRANS2";	
	$stock2="STOCK_SORDR";	
	//$stock="STOCK";	
	$voucher_Jo="TS";
	$this->load->model("transferModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete" && $type!="porders" && $type!="loadpdata"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vcode","Party","required");
	$this->form_validation->set_rules("tqty","Total Qty","required");
	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}	
	$data['rights']=$this->punchData['voucherrights'][0];
	$check=$this->dataModel->getData("PURCH1",array("VNO"=>$data['no'],"B_ID"=>$this->userData['B_ID']),"","");
	
	if(empty($check)){
	$response=$this->transferModel->insert($data);

	if($response===true){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>$response));
	}	
	}	else {
	echo json_encode(array("error"=>"Transfer is Present against this Order"));
	}	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$check=$this->dataModel->getData("PURCH1",array("VNO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
	if(empty($check)){

		
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID'],"JO"=>$voucher_Jo));
	///$data=$this->dataModel->deleteData("$stock",array("NO"=>$no,"B_ID"=>$this->userData['B_ID'],"JO"=>$voucher_Jo));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}	else {
	echo json_encode(array("error"=>"Transfer is Present against this Order"));
	}	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else if($this->uri->segment(3) && $type=="porders" && $type!="loadpdata"){
	$vcode=$this->input->post("vcode");

	if(empty($vcode))	{
	$vcod1 = "";
	}	else	{
	$vcod1 = "where VCODE='$vcode'";
	}		
	$data=$this->dataModel->query("select t1.NO,VNAME,REMARKS,VCODE,VDATE,CRDAYS from(
(SELECT a1.NO,a1.B_ID from PORDR2 a1 left join TRANS2  a2 on a1.NO=a2.SONO and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
left join PORDR1 a3 on a1.VCODE=a3.VCODE and a1.NO=a3.NO
where a1.status!='Close'
group by a1.NO,a1.B_ID,a1.QTY,a1.PCODE
having a1.QTY<> SUM(a2.qty)) union all
(SELECT a1.NO,a1.B_ID from PORDR2 a1 left join DC2 a2 on a1.NO=a2.SONO and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
where a2.PCODE is null and a1.status!='Close'
group by a1.NO,a1.B_ID) )t1 left join PORDR1 t2 on t1.NO = t2.NO and t1.B_ID=t2.B_ID $vcod1
group by t1.no,VNAME,REMARKS,VDATE,CRDAYS,VCODE
order by t1.NO asc");
	
	if(!empty($data)){
	$response = $this->load->view("$segment1/voucher/$segment2/pchalan",["data"=>$data],true);	
	echo json_encode(array("success"=>"true","data"=>$response));
	}
	else{
	echo json_encode(array("error"=>"Not Found","success"=>"false"));	
	}
	}
	else if($this->uri->segment(3) && $type=="loadpdata" && $type!="porders"){
	$sono=$this->input->post("no");	
	$dcdata=$this->dataModel->query("select t1.NO,t1.PCODE,t1.PNAME,t1.bal as QTY,SUM(case when t2.INQT-t2.OUTQT IS not null then t2.INQT-t2.OUTQT else 0 end ) as STOCK,t1.COLOR,t1.RATE,t1.AMOUNT from (
(SELECT a1.NO,a1.PNAME,a1.PCODE,a1.QTY-SUM(a2.qty) as bal,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID from PORDR2 a1 left join TRANS2 a2 on a1.NO=a2.SONO 
and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
where a1.STATUS<>'Close'
group by a1.NO,a1.PNAME,a1.PCODE,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID,a1.QTY,a1.PCODE
having a1.QTY<> SUM(a2.qty)) union all
(SELECT a1.NO,a1.PNAME,a1.PCODE,a1.QTY,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID as bal from PORDR2 a1 left join TRANS2 a2 on a1.NO=a2.SONO and a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.PCODE=a2.PCODE
where a2.PCODE is null and a1.STATUS<>'Close'
group by a1.NO,a1.PNAME,a1.QTY,a1.PCODE,a1.COLOR,a1.RATE,a1.AMOUNT,a1.B_ID)) t1 left join STOCK t2 on t1.PCODE=t2.PCODE and t1.B_ID=t2.B_ID where t1.NO='$sono' and t1.B_ID='".$this->userData['B_ID']."'
group by t1.NO,t1.PCODE,t1.bal,t1.PNAME,t1.COLOR,t1.RATE,t1.AMOUNT
order by t1.NO asc");
	
	
	

	$this->punchData['dcdata']=$dcdata;
	if(!empty($dcdata)){
	echo $this->load->view("$segment1/voucher/$segment2/loadpdata",["dcdata"=>$dcdata],true);	
	}
	else{
	echo "<h2>Sorry No P.O Found !</h2>";
	}
	}
	else{
	$party=$this->dataModel->getSuppliers(4);
	$this->punchData['party']=$party;
	$cargo=$this->dataModel->getData("CARGO","","CODE,VNAME","VNAME ASC");
	$this->punchData['cargo']=$cargo;
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['odate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="China Transfer Shipment";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['odate']=date("d/m/Y",strtotime($data[0]['SODATE']));
	$clmt=$this->dataModel->getData("PARTY",array("VCODE"=>$data[0]['VCODE']),"","");
	$this->punchData['clmt']=$clmt;	
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}	

	}
