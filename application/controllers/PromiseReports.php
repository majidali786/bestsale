<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PromiseReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","numberJs","promiseJs");
	$this->reportPath="promise/reports/promise/";
	$this->punchData['heading']="Promise Reports";	
	}
	
	
	public function promises(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");
	$this->form_validation->set_rules("rtype","Promise Type","required");	
	$this->form_validation->set_rules("dtype","Date Type","required");	
	$this->form_validation->set_rules("branch","Branch","required");
	if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","Party","required");
	}	
	if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];	
				$this->load->model("PromiseReportsModel");
				$response=$this->PromiseReportsModel->promises($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."promise-data",$responseData,TRUE);	
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
	$this->punchData['view']=$this->reportPath."promise";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	
}
