<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	if(!$this->input->is_ajax_request() && $this->uri->segment(3))
	{
	$no=$this->uri->segment(3);	
	if(!is_numeric($no) || $this->uri->segment(4)){
	redirect(base_url($this->uri->segment(1)."/".$this->uri->segment(2)));	
	}
	}
	$this->reportPath="inventory/reports/stock/";
	$this->punchData['heading']="Inventory Reports";	
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable");
	}
		
	function stockTransfer(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	$mainTable="STRNF1";
	$mainTable2="STRNF2";
	$voucher_Jo="ST";	
	$stock="STOCK";		
	$this->load->model("stockTransferModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("fbranch","From Branch","required");
	$this->form_validation->set_rules("tbranch","To Branch","required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->stockTransferModel->insert($data);
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
	$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"TB_ID"=>$this->userData['B_ID']));	
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
	$branches=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$branche=$this->dataModel->getData("BRANCH",array("BCODE"=>$this->userData['B_ID']),"BCODE,BNAME","BNAME ASC");
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	//$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");

	$product=$this->dataModel->getData("STOCKTRANSFER",array("B_ID"=>$this->userData['B_ID']),"PCODE,PNAME,BNAME,QTY","PNAME ASC");
	
	
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['branches']=$branches;
	$this->punchData['branche']=$branche;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Stock Transfer Voucher";
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
	
	function openingStock(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	$mainTable="OPSTOCK1";
	$mainTable2="OPSTOCK2";
	$voucher_Jo="OS";	
	$stock="STOCK";		
	$this->load->model("openingStockModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	//$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->openingStockModel->insert($data);
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
	$branches=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['branches']=$branches;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Opening Stock Voucher";
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
	
	public function balance(){
	if($this->input->is_ajax_request()){
		$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("branch","Branch","required");	
    if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","Party","required");	
	}
	if($this->form_validation->run()){
				//$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$data['vdate']=$vdate;
				$this->load->model("inventoryReportsModel");
				$response=$this->inventoryReportsModel->balance($data);
				if($response){
				$responseData['data']=$response;
				$responseData['vdate']=$vdate;								
				$viewResponse=$this->load->view($this->reportPath."balance-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$design=$this->dataModel->getData("DESIGN","","ID,NAME","ID ASC");
	$this->punchData['branch']=$branch;	
	$this->punchData['design']=$design;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."balance";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
		
	public function amount(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("branch","Branch","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$data['vdate']=$vdate;
				$this->load->model("inventoryReportsModel");
				$response=$this->inventoryReportsModel->amount($data);
				if($response){
				$responseData['data']=$response;
				$responseData['vdate']=$vdate;								
				$viewResponse=$this->load->view($this->reportPath."amount-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
		
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."amount";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function movement(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("branch","Branch","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("inventoryReportsModel");
				$response=$this->inventoryReportsModel->movement($data);
				if($response){
				$responseData['data']=$response;
				$viewResponse=$this->load->view($this->reportPath."movement-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."movement";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	

	public function StockTransferlist(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
    $this->form_validation->set_rules("branch","Branch","required");
	

		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];	
				
				$this->load->model("inventoryReportsModel");
				$response=$this->inventoryReportsModel->StockTransferlist($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."stocktransfer-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	
	$this->punchData['branch']=$branch;	
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."stocktransfer";	
	$this->load->view("main",$this->punchData);		
	}
	}
	public function ledger(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
	$this->form_validation->set_rules("product","Product","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("inventoryReportsModel");
				$response=$this->inventoryReportsModel->ledger($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."ledger-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."ledger-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;		
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$this->punchData['product']=$product;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	
	
}
