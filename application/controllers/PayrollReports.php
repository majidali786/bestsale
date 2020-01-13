<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","barchart");
	$this->reportPath="payroll/reports/payroll/";
	$this->punchData['heading']="Payroll Reports";	
	}
	
	public function loanAdvance(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");$data = $this->input->post();		
	if($data['etype']==1){
	$this->form_validation->set_rules("employee[]","Employee","required");	
	}
	if($data['dptype']==1){
	$this->form_validation->set_rules("department[]","Department","required");	
	}
	if($data['dstype']==1){
	$this->form_validation->set_rules("designation[]","Designation","required");	
	}
		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("PayrollReportsModel");
				$response=$this->PayrollReportsModel->loanAdvance($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."loanadvance-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."loanadvance-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$employee=$this->dataModel->getData("EMPLOYEE","","ID,NAME,DEPARTMENT,DESIGNATION,STATUS","NAME ASC");
	$department=$this->dataModel->getData("UDEPT","","ID,UDEPT","UDEPT ASC");
	$designation=$this->dataModel->getData("UDESIG","","ID,UDESIG","UDESIG ASC");
	$this->punchData['employee']=$employee;	
	$this->punchData['department']=$department;	
	$this->punchData['designation']=$designation;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."loanadvance";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function salaryIncrement(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");$data = $this->input->post();		
	if($data['etype']==1){
	$this->form_validation->set_rules("employee[]","Employee","required");	
	}
	if($data['dptype']==1){
	$this->form_validation->set_rules("department[]","Department","required");	
	}
	if($data['dstype']==1){
	$this->form_validation->set_rules("designation[]","Designation","required");	
	}
		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("PayrollReportsModel");
				$response=$this->PayrollReportsModel->salaryIncrement($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."salaryincrement-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."salaryincrement-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$employee=$this->dataModel->getData("EMPLOYEE","","ID,NAME,DEPARTMENT,DESIGNATION,STATUS","NAME ASC");
	$department=$this->dataModel->getData("UDEPT","","ID,UDEPT","UDEPT ASC");
	$designation=$this->dataModel->getData("UDESIG","","ID,UDESIG","UDESIG ASC");
	$this->punchData['employee']=$employee;	
	$this->punchData['department']=$department;	
	$this->punchData['designation']=$designation;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."salaryincrement";	
	$this->load->view("main",$this->punchData);		
	}
	}
	

	
	}
