<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable");
	$this->reportPath="purchase/reports/supplier/";
	$this->punchData['heading']="Supplier Reports";	
	}
	public function balance(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("branch","Branch","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$vdate2=date("Y-m-d",strtotime("-1 month",strtotime($vdate)));
				$vdate3=date("Y-m-d",strtotime("-2 month",strtotime($vdate)));
				$data['vdate']=$vdate;
				$data['vdate2']=$vdate2;
				$data['vdate3']=$vdate3;
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->balance($data);
				if($response){
				$responseData['data']=$response;
				$responseData['vdate']=$vdate;				
				$responseData['vdate2']=$vdate2;				
				$responseData['vdate3']=$vdate3;				
				$viewResponse=$this->load->view($this->reportPath."balance-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['vdate']=$vdate;				
				$responseData['vdate2']=$vdate2;				
				$responseData['vdate3']=$vdate3;				
				$viewResponse=$this->load->view($this->reportPath."balance-data",$responseData,TRUE);		
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
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."balance";	
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
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->ledger($data);
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
	$party=$this->dataModel->getSuppliers();
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function sbalance(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("branch","Branch","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$vdate2=date("Y-m-d",strtotime("-1 month",strtotime($vdate)));
				$vdate3=date("Y-m-d",strtotime("-2 month",strtotime($vdate)));
				$data['vdate']=$vdate;
				$data['vdate2']=$vdate2;
				$data['vdate3']=$vdate3;
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->sbalance($data);
				if($response){
				$responseData['data']=$response;
				$responseData['vdate']=$vdate;				
				$responseData['vdate2']=$vdate2;				
				$responseData['vdate3']=$vdate3;				
				$viewResponse=$this->load->view($this->reportPath."sbalance-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['vdate']=$vdate;				
				$responseData['vdate2']=$vdate2;				
				$responseData['vdate3']=$vdate3;				
				$viewResponse=$this->load->view($this->reportPath."sbalance-data",$responseData,TRUE);		
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
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."sbalance";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function sledger(){
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
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->sledger($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."sledger-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."sledger-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getSuppliers();
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."sledger";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	public function aging(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("party","Party","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$vdate2=date("Y-m-d",strtotime("-1 month",strtotime($vdate)));
				$vdate3=date("Y-m-d",strtotime("-2 month",strtotime($vdate)));
				$data['vdate']=$vdate;
				$responseData['vdate']=$vdate;		
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->aging($data);
				if($response){
				$responseData['data']=$response;					
				$viewResponse=$this->load->view($this->reportPath."aging-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."aging-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getSuppliers();
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."aging";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function agingAll(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$vdate2=date("Y-m-d",strtotime("-1 month",strtotime($vdate)));
				$vdate3=date("Y-m-d",strtotime("-2 month",strtotime($vdate)));
				$data['vdate']=$vdate;
				$responseData['vdate']=$vdate;		
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->agingAll($data);
				if($response){
				$responseData['data']=$response;					
				$viewResponse=$this->load->view($this->reportPath."aging-all-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."aging-all-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$party=$this->dataModel->getSuppliers();
	$this->punchData['branch']=$branch;	
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."aging-all";	
	$this->load->view("main",$this->punchData);		
	}
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
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->invoiceDetail($data);
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
	$party=$this->dataModel->getParties(5);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."invoice-detail";	
	$this->load->view("main",$this->punchData);		
	}
	}
		
	public function invoiceSummary(){
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
				$this->load->model("supplierReportsModel");
				$response=$this->supplierReportsModel->invoiceDetail($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."invoice-summary-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."invoice-summary-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(5);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."invoice-summary";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	

}
