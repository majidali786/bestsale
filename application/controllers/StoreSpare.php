<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StoreSpare extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	if(!$this->input->is_ajax_request() && $this->uri->segment(3))
	{
	$no=$this->uri->segment(3);	
	if(!is_numeric($no) || $this->uri->segment(4)){
	redirect(base_url($this->uri->segment(1)."/".$this->uri->segment(2)));	
	}
	}
	}
	
	
	
	function DemandOrder(){
	$mainTable="SSDO1";
	$mainTable2="SSDO2";
	$voucher_Jo="DS";		
	$stock="STOCK_SS";		
	$this->load->model("storeSpareDemandOrderModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("dpname","Department","required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->storeSpareDemandOrderModel->insert($data);
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
	$department=$this->dataModel->getData("DEPT","","DPCode,DPName","DPName ASC");
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['department']=$department;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Store & Spare Demand Order";
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
	
		
	function goodReceiptNote(){
	$mainTable="SSGRN1";
	$mainTable2="SSGRN2";
	$voucher_Jo="SG";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK_SS";		
	$this->load->model("storeSparegoodReceiptNoteModel");
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
	$this->form_validation->set_rules("department","Department","required");
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
		$response=$this->storeSparegoodReceiptNoteModel->insert($data);
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
	$account=$this->dataModel->getAccounts();
	$party=$this->dataModel->getParties(5);
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['party']=$party;
	$this->punchData['account']=$account;
	$this->punchData['unit']=$unit;
	$this->punchData['department']=$department;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Store & Spare Goods Receipt Note";
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
	
		
	function stockTransfer(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	$mainTable="SSSTRNF1";
	$mainTable2="SSSTRNF2";
	$voucher_Jo="TS";	
	$stock="STOCK_SS";		
	$this->load->model("storeSparestockTransferModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("fdepartment","From Department","required|differs[tdepartment]");
	$this->form_validation->set_rules("tdepartment","To Department","required|differs[fdepartment]");
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
		$response=$this->storeSparestockTransferModel->insert($data);
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
	$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['department']=$department;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Store & Spare Stock Transfer Voucher";
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
		
	function stockReturnNote(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	$mainTable="SSSRN1";
	$mainTable2="SSSRN2";
	$voucher_Jo="SN";	
	$stock="STOCK_SS";		
	$this->load->model("storeSparestockReturnModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("department","From Department","required");
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
		$response=$this->storeSparestockReturnModel->insert($data);
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
	$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['department']=$department;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Store & Spare Stock Return Voucher";
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
	
	
	function stockConsumption(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	$mainTable="SSSCN1";
	$mainTable2="SSSCN2";
	$voucher_Jo="SC";	
	$stock="STOCK_SS";		
	$this->load->model("storeSparestockConsumptionModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("department","From Department","required");
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
		$response=$this->storeSparestockConsumptionModel->insert($data);
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
	$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['department']=$department;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Store & Spare Consumption Voucher";
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
	
	
		function product(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSPRODUCT","","","PNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Name","required|is_unique[SSPRODUCT.PNAME]");
		$this->form_validation->set_rules("code","Code","required|is_unique[SSPRODUCT.PCODE]");
		$this->form_validation->set_rules("mgroup","Main Group","required");
		$this->form_validation->set_rules("itemname","Item Name","required");
		$this->form_validation->set_rules("size","Size","required");
		$this->form_validation->set_rules("nature","Nature","required");
		$this->form_validation->set_rules("feet","Feet","required");
		$this->form_validation->set_rules("unit","Unit","required");
		$this->form_validation->set_rules("weight","Weight","required");
		$this->form_validation->set_rules("others1","Others 1","required");
		$this->form_validation->set_rules("others2","Others 2","required");
		$this->form_validation->set_rules("others3","Others 3","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertProduct($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSPRODUCT",array("PCODE"=>$this->input->post("id")),"","");	
		$this->punchData['data']=$data;
		$mgroup=$this->dataModel->getData("SSMGROUP",array("ID"=>$data[0]['MGID']),"","SSMGROUP ASC");
		$this->punchData['mgroup']=$mgroup;
		$itemname=$this->dataModel->getData("SSINAME",array("ID"=>$data[0]['INID']),"","SSINAME ASC");
		$this->punchData['itemname']=$itemname;
		$size=$this->dataModel->getData("SSSIZE",array("ID"=>$data[0]['SID']),"","SSSIZE ASC");
		$this->punchData['size']=$size;
		$nature=$this->dataModel->getData("SSNATURE",array("ID"=>$data[0]['NID']),"","SSNATURE ASC");
		$this->punchData['nature']=$nature;
		$feet=$this->dataModel->getData("SSFEET",array("ID"=>$data[0]['FID']),"","SSFEET ASC");
		$this->punchData['feet']=$feet;
		$unit=$this->dataModel->getData("SSUNIT",array("ID"=>$data[0]['UID']),"","SSUNIT ASC");
		$this->punchData['unit']=$unit;
		$weight=$this->dataModel->getData("SSWEIGHT",array("ID"=>$data[0]['WID']),"","SSWEIGHT ASC");
		$this->punchData['weight']=$weight;
		$others1=$this->dataModel->getData("SSOTHERS1",array("ID"=>$data[0]['O1ID']),"","SSOTHERS1 ASC");
		$this->punchData['others1']=$others1;
		$others2=$this->dataModel->getData("SSOTHERS2",array("ID"=>$data[0]['O2ID']),"","SSOTHERS2 ASC");
		$this->punchData['others2']=$others2;
		$others3=$this->dataModel->getData("SSOTHERS3",array("ID"=>$data[0]['O3ID']),"","SSOTHERS3 ASC");
		$this->punchData['others3']=$others3;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSPRODUCT",array("PCODE"=>$this->input->post("id")),"","");	
		if($match[0]['PNAME']!=$this->input->post("name")){
		$unique="|is_unique[SSPRODUCT.PNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Product Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateProduct($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSPRODUCT",array("PCODE"=>$this->input->post("id")));
		return true;	
		}
		if($segment=="get-code-name")
		{
		$code=$name="";	
		$data=$this->input->post();	
		if($data['mgroup']!='' && $data['mgroup']!='0')
		{
		$a=explode("--",$data['mgroup']);	
		$code=$code.$a[0];		
		}
		else{
		$code=$code."0";	
		}
		if($data['itemname']!='' && $data['itemname']!='0')
		{
		$a=explode("--",$data['itemname']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_itemname']))
		{
		$name=$name."".$a[1];
		}	
		}
		else{
		$code=$code."0";	
		}
		if($data['size']!='' && $data['size']!='0')
		{
		$a=explode("--",$data['size']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_size']))
		{
		$name=$name." ".$a[1];
		}		
		}
		else{
		$code=$code."0";	
		}
		if($data['nature']!='' && $data['nature']!='0')
		{
		$a=explode("--",$data['nature']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_nature']))
		{
		$name=$name." ".$a[1];	
		}
		}
		else{
		$code=$code."0";	
		}
		if($data['feet']!='' && $data['feet']!='0')
		{
		$a=explode("--",$data['feet']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_feet']))
		{
		$name=$name." , ".$a[1];
		}	
		}
		else{
		$code=$code."0";	
		}
		if($data['unit']!='' && $data['unit']!='0')
		{
		$a=explode("--",$data['unit']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_unit']))
		{
		$name=$name." ".$a[1];	
		}
		}
		else{
		$code=$code."0";	
		}
		
		if($data['weight']!='' && $data['weight']!='0')
		{
		$a=explode("--",$data['weight']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_weight']))
		{
		$name=$name." ".$a[1]." Kg";	
		}		
		}
		else{
		$code=$code."0";	
		}
		
		if($data['others1']!='' && $data['others1']!='0')
		{
		$a=explode("--",$data['others1']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_others1']))
		{
		$name=$name." ".$a[1];
		}		
		}
		else{
		$code=$code."0";	
		}
		if($data['others2']!='' && $data['others2']!='0')
		{
		$a=explode("--",$data['others2']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_others2']))
		{
		$name=$name." ".$a[1];
		}		
		}
		else{
		$code=$code."0";	
		}
		if($data['others3']!='' && $data['others3']!='0')
		{
		$a=explode("--",$data['others3']);	
		$code=$code.$a[0];	
		if(!empty($data['inc_others3']))
		{
		$name=$name." ".$a[1];
		}		
		}
		else{
		$code=$code."0";	
		}
		echo json_encode(array("code"=>$code,"name"=>$name));
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Product Information";
		$mgroup=$this->dataModel->getData("SSMGROUP","","","SSMGROUP ASC");
		$this->punchData['mgroup']=$mgroup;
		$size=$this->dataModel->getData("SSSIZE","","","SSSIZE ASC");
		$this->punchData['size']=$size;
		$itemname=$this->dataModel->getData("SSINAME","","","SSINAME ASC");
		$this->punchData['itemname']=$itemname;
		$others1=$this->dataModel->getData("SSOTHERS1","","","SSOTHERS1 ASC");
		$this->punchData['others1']=$others1;
		$others2=$this->dataModel->getData("SSOTHERS2","","","SSOTHERS2 ASC");
		$this->punchData['others2']=$others2;
		$others3=$this->dataModel->getData("SSOTHERS3","","","SSOTHERS3 ASC");
		$this->punchData['others3']=$others3;
		$feet=$this->dataModel->getData("SSFEET","","","SSFEET ASC");
		$this->punchData['feet']=$feet;
		$unit=$this->dataModel->getData("SSUNIT","","","SSUNIT ASC");
		$this->punchData['unit']=$unit;
		$nature=$this->dataModel->getData("SSNATURE","","","SSNATURE ASC");
		$this->punchData['nature']=$nature;
		$weight=$this->dataModel->getData("SSWEIGHT","","","SSWEIGHT ASC");
		$this->punchData['weight']=$weight;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
		function mainGroup(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSMGROUP","","SSMGROUP AS NAME,ID AS ID","SSMGROUP ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Main Group","required|is_unique[SSMGROUP.SSMGROUP]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertMainGroup($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSMGROUP",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSMGROUP",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSMGROUP']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSMGROUP.SSMGROUP]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Main Group","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateMainGroup($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSMGROUP",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Main Group";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
		
		function itemName(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSINAME","","SSINAME AS NAME,ID AS ID","SSINAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Item Name","required|is_unique[SSINAME.SSINAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertItemName($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSINAME",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSINAME",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSINAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSINAME.SSINAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Item Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateItemName($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSINAME",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Item Name";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function size(){
		$this->punchData['libraries']=array("datatable","formJs");
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSSIZE","","SSSIZE AS NAME,ID AS ID","SSSIZE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Size","required|is_unique[SSSIZE.SSSIZE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertSize($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSSIZE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSSIZE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSSIZE']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSSIZE.SSSIZE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Size","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateSize($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSSIZE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Size";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function feet(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSFEET","","SSFEET AS NAME,ID AS ID","SSFEET ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Feet","required|is_unique[SSFEET.SSFEET]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertFeet($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSFEET",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSFEET",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSFEET']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSFEET.SSFEET]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Feet","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateFeet($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSFEET",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Feet";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function unit(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSUNIT","","SSUNIT AS NAME,ID AS ID","SSUNIT ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Unit","required|is_unique[SSUNIT.SSUNIT]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertUnit($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSUNIT",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSUNIT",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSUNIT']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSUNIT.SSUNIT]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Unit","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateUnit($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSUNIT",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Unit";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function nature(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSNATURE","","SSNATURE AS NAME,ID AS ID","SSNATURE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Nature","required|is_unique[SSNATURE.SSNATURE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertNature($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSNATURE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSNATURE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSNATURE']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSNATURE.SSNATURE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Nature","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateNature($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSNATURE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Nature";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function weight(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSWEIGHT","","SSWEIGHT AS NAME,ID AS ID","SSWEIGHT ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Weight","required|is_unique[SSWEIGHT.SSWEIGHT]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertWeight($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSWEIGHT",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSWEIGHT",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSWEIGHT']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSWEIGHT.SSWEIGHT]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Weight","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateWeight($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSWEIGHT",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Weight";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function others1(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSOTHERS1","","SSOTHERS1 AS NAME,ID AS ID","SSOTHERS1 ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Others 1","required|is_unique[SSOTHERS1.SSOTHERS1]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertOthers1($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSOTHERS1",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSOTHERS1",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSOTHERS1']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSOTHERS1.SSOTHERS1]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Others 1","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateOthers1($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSOTHERS1",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Others 1";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
		function others2(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSOTHERS2","","SSOTHERS2 AS NAME,ID AS ID","SSOTHERS2 ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Others 2","required|is_unique[SSOTHERS2.SSOTHERS2]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertOthers2($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSOTHERS2",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSOTHERS2",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSOTHERS2']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSOTHERS2.SSOTHERS2]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Others 2","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateOthers2($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSOTHERS2",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Others 2";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function others3(){
		$this->punchData['libraries']=array("datatable","formJs");	
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SSOTHERS3","","SSOTHERS3 AS NAME,ID AS ID","SSOTHERS3 ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Others 3","required|is_unique[SSOTHERS3.SSOTHERS3]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->insertOthers3($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="edit")
		{
		$data=$this->dataModel->getData("SSOTHERS3",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SSOTHERS3",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SSOTHERS3']!=$this->input->post("name"))
		{
		$unique="|is_unique[SSOTHERS3.SSOTHERS3]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Others 3","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				$this->load->model("storeSpareModel");
				if($this->storeSpareModel->updateOthers3($data)){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		if($segment=="delete")
		{
		$data=$this->dataModel->deleteData("SSOTHERS3",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Store & Spare Others 3";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function openingStock(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	$mainTable="SSOPSTOCK1";
	$mainTable2="SSOPSTOCK2";
	$voucher_Jo="OR";	
	$stock="STOCK_SS";		
	$this->load->model("storeSpareOpeningStockModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("department","Department","required");
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
		$response=$this->storeSpareOpeningStockModel->insert($data);
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
	$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","TNO"=>$no,"TB_ID"=>$this->userData['B_ID']));	
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
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$this->punchData['department']=$department;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Store & Spare Opening Stock Voucher";
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
	
		
		
		
	

}
