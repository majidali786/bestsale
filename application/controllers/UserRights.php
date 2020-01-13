<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRights extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("UserRightsModel");
	$this->punchData['libraries']=array("datatable","userRights");
	}
		
	function index(){
	$list=$this->UserRightsModel->getData("login",array("TYPE<>"=>0),"","USERNAME ASC");
	$branch=$this->UserRightsModel->getData("BRANCH","","","BNAME ASC");
	$type=$this->UserRightsModel->getData("UTYPE","","","TYPE ASC");
	$this->punchData['list']=$list;
	$this->punchData['list_branch']=$branch;
	$this->punchData['list_type']=$type;
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="User Rights";
	$this->punchData['view']="userrights/main";
	$this->load->view("main",$this->punchData);
	}
	
	function getMenuRights(){
	$dat=$this->input->get();
	if($this->uri->segment(3)){
	$level=$this->uri->segment(3);
	$data2=$this->UserRightsModel->query("SELECT MENU.NO FROM MENU INNER JOIN MENU_RIGHTS ON MENU.NO=MENU_RIGHTS.MENU WHERE MENU_RIGHTS.USR='".$dat['user']."' AND MENU.LEVL='$level' AND ( MENU_RIGHTS.B_ID='".$dat['branch']."' OR MENU.UNIVERSAL=0 )  GROUP BY MENU.NO ");
	$this->punchData['data2']=$data2;	
	if($level==1){
	$data=$this->UserRightsModel->getData("MENU",array("LEVL"=>1),"NO,NAME","SORT ASC");
	$this->punchData['data']=$data;	
	}
	else if($level==2){
	$data=$this->UserRightsModel->getData("MENU",array("LEVL"=>2,"LEVEL1"=>$dat['level']),"NO,NAME","SORT ASC");
	$this->punchData['data']=$data;	
	}
	else if($level==3){
	$data=$this->UserRightsModel->getData("MENU",array("LEVL"=>3,"LEVEL2"=>$dat['level']),"NO,NAME","SORT ASC");
	$this->punchData['data']=$data;	
	}
	$response=$this->load->view("userrights/level$level",$this->punchData,true);
	echo json_encode(array("success"=>"true","data"=>$response));	
	}
	else{
	$branch=$this->UserRightsModel->getData("BRANCH","","BCODE,BNAME","BCODE ASC");
	$this->punchData['branch']=$branch;
	$this->punchData['data']=$dat;
	$response=$this->load->view("userrights/loadbranch",$this->punchData,true);
	echo json_encode(array("success"=>"true","data"=>$response));	
	}
	}

	function saveMenuRights(){
	
	$this->form_validation->set_rules("user","User","required");
	$this->form_validation->set_rules("branch","Branch","required");
	if($this->form_validation->run()){
		$data = $this->input->post();
		if($this->UserRightsModel->saveMenuRights($data)){
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
	
	function saveVoucherRights(){
	
	$this->form_validation->set_rules("user","User","required");
	$this->form_validation->set_rules("branch","Branch","required");
	$this->form_validation->set_rules("menu","Menu","required");
	if($this->form_validation->run()){
		$data = $this->input->post();
		if($this->UserRightsModel->saveVoucherRights($data)){
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
	
	function getVoucherRights(){
	$dat=$this->input->get();
	if($this->uri->segment(3)){
	$type=$this->uri->segment(3);
	if($type=="vouchers"){
	$data=$this->UserRightsModel->query(" SELECT MENU.NO,MENU.NAME FROM MENU INNER JOIN MENU_RIGHTS ON MENU.NO=MENU_RIGHTS.MENU WHERE MENU_RIGHTS.USR='".$dat['user']."' AND MENU.VOUCHER='1' AND ( MENU_RIGHTS.B_ID='".$dat['branch']."' OR MENU.UNIVERSAL=0 )  GROUP BY MENU.NO,MENU.NAME ");
	$this->punchData['data']=$data;
	}
	else if($type=="rights"){
	$this->punchData['menu']=$dat['voucher'];
	$data1=$this->UserRightsModel->getData("VOUCHER_RIGHTS",array("USR"=>$dat['user'],"B_ID"=>$dat['branch'],"MENU"=>$dat['voucher']),"","");	
	$this->punchData['rights']=$data1;	
	}
	$response=$this->load->view("userrights/$type",$this->punchData,true);	
	
	echo json_encode(array("success"=>"true","data"=>$response));	
	}
	else{
	$branch=$this->UserRightsModel->getData("BRANCH","","BCODE,BNAME","BCODE ASC");
	$this->punchData['branch']=$branch;
	$this->punchData['data']=$dat;
	$response=$this->load->view("userrights/loadVoucherRights",$this->punchData,true);
	echo json_encode(array("success"=>"true","data"=>$response));	
	}
	}
	
	function saveOtherRights(){
	$data = $this->input->post();
	$this->form_validation->set_rules("user","User","required");
	if(!empty($data['aactivity'])){
	$this->form_validation->set_rules("actypes[]","Account Type Required","required");	
	}
	if($this->form_validation->run()){
		
		if($this->UserRightsModel->saveOtherRights($data)){
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
	
	function getOtherRights(){
	$dat=$this->input->get();
	$data1=$this->UserRightsModel->getData("OTHERRIGHTS",array("USR"=>$dat['user']),"","");
	$data2=$this->UserRightsModel->getData("ACCOUNT_TYPE",array(),"","");
	$this->punchData['data']=$dat;
	$this->punchData['data1']=$data1;
	$this->punchData['data2']=$data2;
	$response=$this->load->view("userrights/loadOtherRights",$this->punchData,true);
	echo json_encode(array("success"=>"true","data"=>$response));	
	}
}
