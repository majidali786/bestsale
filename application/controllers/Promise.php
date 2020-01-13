<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promise extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("PromiseModel");
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	}
		
		
	function promiseVoucher(){	
	$mainTable="PROMISE";
	$mainTable2="PROMISECOMMENT";
	$voucher_Jo="PM";
	$gnrllgr="Gnrllgr_promise";		
	$this->load->model("promiseVoucherModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("acode","Party Code","required");
	$this->form_validation->set_rules("aname","Party","required");
	$this->form_validation->set_rules("descrip","Description","required");
	$this->form_validation->set_rules("pdate","Promise Date","required");
	$this->form_validation->set_rules("pmdate","Promise Make Date","required");
	$this->form_validation->set_rules("amount","Amount","required|greater_than[0]");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->promiseVoucherModel->insert($data);
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
	$data=$this->dataModel->deleteData("$gnrllgr",array("PNO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$mainTable2",array("PNO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
	$party=$this->dataModel->getParties(4);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['party']=$party;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Promise Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['pmdate']=date("d/m/Y",strtotime($data[0]['PMDATE']));
	$this->punchData['pdate']=date("d/m/Y",strtotime($data[0]['PDATE']));
	$this->punchData['data']=$data;		
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
	
	public function loadPromises(){
	if($this->input->is_ajax_request()){
	$result=$this->dataModel->query("SELECT * FROM TPROMISE WHERE B_ID='".$this->userData['B_ID']."' ORDER BY PDATE");	
	echo json_encode($result);
	}	
	}
	
	public function loadPromise(){
	if($this->input->is_ajax_request()){
	$data=$this->input->get();	
	$data1=$this->dataModel->query("SELECT * FROM PROMISE WHERE NO='".$data['pno']."' AND B_ID='".$this->userData['B_ID']."'");
	$data2=$this->dataModel->query("SELECT * FROM PROMISECOMMENT WHERE PNO='".$data['pno']."' AND B_ID='".$this->userData['B_ID']."'");
	$response=$this->load->view("promise/single-promise",["data"=>$data1,"data2"=>$data2],true);
	echo $response;	
	}	
	}
	
	
	function comment(){
		$this->punchData['libraries']=array("promiseJs");
		$segment=$this->uri->segment(4);
		$pno=$this->uri->segment(3);	
		if($this->input->is_ajax_request() && is_numeric($pno))
		{
		if($segment=="save")
		{
		$this->form_validation->set_rules("pamount","Amount Paid","required|numeric");
		$this->form_validation->set_rules("cstatus","Status","required");
		$this->form_validation->set_rules("description","Description","required");
		if($this->input->post("cstatus")==1){
		$this->form_validation->set_rules("eamount","Expected Amount","required|numeric");
		$this->form_validation->set_rules("edate","Expected Date","required");
		}
		if($this->form_validation->run()){
			$data=$this->input->post();
			$data['pno']=$pno;
			if($this->PromiseModel->insertComment($data)){
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
		$data=$this->PromiseModel->getData("PROMISECOMMENT",array("PNO"=>$pno,"NO"=>$this->input->get("no"),"B_ID"=>$this->userData['B_ID']),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("promise/edit-promise-comment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$this->form_validation->set_rules("pamount","Amount Paid","required|numeric");
		$this->form_validation->set_rules("cstatus_e","Status","required");
		$this->form_validation->set_rules("description","Description","required");
		if($this->input->post("cstatus_e")==1){
		$this->form_validation->set_rules("eamount","Expected Amount","required|numeric");
		$this->form_validation->set_rules("edate","Expected Date","required");
		}
		if($this->form_validation->run()){
				$data=$this->input->post();
				$data['pno']=$pno;
				if($this->PromiseModel->updateComment($data)){
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
		$data=$this->PromiseModel->getData("PROMISECOMMENT",array("PNO"=>$pno,"NO"=>$this->input->post("no"),"B_ID"=>$this->userData['B_ID']),"","");	
		$data1=$this->PromiseModel->deleteData("PROMISECOMMENT",array("PNO"=>$pno,"NO"=>$this->input->post("no"),"B_ID"=>$this->userData['B_ID']));
		if($data[0]['STATUS']==0){
		$this->db->query("UPDATE PROMISE SET STATUS=1 WHERE NO='$pno' AND B_ID='".$this->userData['B_ID']."'");	
		}
		echo json_encode(array("success"=>"true"));
		}
		if($segment=="close")
		{
		$this->db->query("UPDATE PROMISE SET STATUS=0 WHERE NO='$pno' AND B_ID='".$this->userData['B_ID']."'");	
		echo json_encode(array("success"=>"true"));
		}
		if($segment=="open")
		{
		$this->db->query("UPDATE PROMISE SET STATUS=1 WHERE NO='$pno' AND B_ID='".$this->userData['B_ID']."'");	
		echo json_encode(array("success"=>"true"));
		}
		}	
		}
	
	
	
		
		
		
	
}
