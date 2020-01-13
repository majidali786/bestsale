<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemoReports extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","barchart");
	$this->reportPath="memo/reports/memo/";
	$this->punchData['heading']="Memo Reports";	
	}
	
	public function invoiceDetail(){
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
				$this->load->model("memoReportsModel");
				$response=$this->memoReportsModel->invoiceDetail($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."invoice-detail-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."invoice-detail-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$account=$this->dataModel->getAccounts();
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$this->punchData['account']=$account;	
	$this->punchData['party']=$party;	
	$this->punchData['supplier']=$supplier;		
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."invoice-detail";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
		
	
}
