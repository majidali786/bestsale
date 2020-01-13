<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","barchart");
	$this->reportPath="sales/reports/sales/";
	$this->punchData['heading']="Sales Reports";	
	}
	//sales list report
	public function SaleList(){
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
				
				$this->load->model("salesReportsModel");
				$response=$this->salesReportsModel->SaleList($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."saleslist-data",$responseData,TRUE);	
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
	$this->punchData['view']=$this->reportPath."saleslist";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	// sales adjustment report
	
		public function SaleAdj(){
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
				
				$this->load->model("salesReportsModel");
				$response=$this->salesReportsModel->SaleAdj($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."salesadj-data",$responseData,TRUE);	
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
	$this->punchData['view']=$this->reportPath."salesadj";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function sales(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	if($data['brtype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}	
	$this->form_validation->set_rules("rtype","Report Type","required");	
	$this->form_validation->set_rules("ortype","Order By","required");
	if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","Party","required");	
	}
	if($data['prtype']==1){
	$this->form_validation->set_rules("product[]","Product","required");	
	}

		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];	
				$responseData['rtype']=$data['rtype'];	
				$responseData['ortype']=$data['ortype'];	
				$this->load->model("salesReportsModel");
				$response=$this->salesReportsModel->sales($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."sales-data",$responseData,TRUE);	
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
	$product=$this->dataModel->getData("PRODUCT","","","PNAME ASC");
	$this->punchData['product']=$product;


	$this->punchData['branch']=$branch;	
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."sales";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function saleReturn(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	if($data['brtype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}	
	$this->form_validation->set_rules("rtype","Report Type","required");	
	$this->form_validation->set_rules("ortype","Order By","required");
	if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","Party","required");	
	}
	if($data['prtype']==1){
	$this->form_validation->set_rules("product[]","Product","required");	
	}

		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];	
				$responseData['rtype']=$data['rtype'];	
				$responseData['ortype']=$data['ortype'];	
				$this->load->model("salesReportsModel");
				$response=$this->salesReportsModel->saleReturn($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."sales-return-data",$responseData,TRUE);	
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
	$product=$this->dataModel->getData("PRODUCT","","","PNAME ASC");
	$this->punchData['product']=$product;


	$this->punchData['branch']=$branch;	
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."sales-return";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
}
