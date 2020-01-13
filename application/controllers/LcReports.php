<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LcReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","barchart");
	$this->reportPath="lc/reports/lc/";
	$this->punchData['heading']="LC Reports";	
	}
	
	public function stockMovement(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");
	if($data['lctype']==1){
	$this->form_validation->set_rules("lcno[]","Lc No.","required");
	}	
		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("LcReportsModel");
				$response=$this->LcReportsModel->stockMovement($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."stock-movement-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."stock-movement-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$lcno=$this->dataModel->query("SELECT LCNO FROM LC1 GROUP BY LCNO ORDER BY LCNO ASC");
	$this->punchData['lcno']=$lcno;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."stock-movement";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function ledger(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
	$this->form_validation->set_rules("party","Party","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("LcReportsModel");
				$response=$this->LcReportsModel->ledger($data);
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
	$account=$this->dataModel->getAccounts();
	$lcno=$this->dataModel->query("SELECT LCNO FROM LC1 GROUP BY LCNO ORDER BY LCNO ASC");
	$this->punchData['lcno']=$lcno;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
}
