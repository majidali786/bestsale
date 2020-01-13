<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class purchaseReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","barchart");
	$this->reportPath="purchase/reports/purchase/";
	$this->punchData['heading']="Purchase Reports";	
	}
	public function purchase(){
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
	if($data['mtype']==1){
	$this->form_validation->set_rules("mgroup[]","Main Group","required");	
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
				$this->load->model("purchaseReportsModel");
				$response=$this->purchaseReportsModel->purchase($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."purchase-data",$responseData,TRUE);	
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
	$mgroup=$this->dataModel->getData("DESIGN","","","NAME ASC");
	$this->punchData['mgroup']=$mgroup;

	$this->punchData['branch']=$branch;	
	$party=$this->dataModel->getParties(5);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."purchase";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
//purchase order


   public function Purchaseorders(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	if($data['brtype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}	
	$this->form_validation->set_rules("rtype","Report Type","required");	
	$this->form_validation->set_rules("ortype","Order By","required");
	
    if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","Supplier","required");	
	}
	if($data['prtype']==1){
	$this->form_validation->set_rules("product[]","Design","required");	
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
				$this->load->model("purchaseReportsModel");
				$response=$this->purchaseReportsModel->Purchaseorders($data);

				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."purchaseorder-data",$responseData,TRUE);	
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
    $party=$this->dataModel->getData("PARTY","ATYPE=1","","VNAME ASC");
	$this->punchData['party']=$party;
	$product=$this->dataModel->getData("DESIGN","","","NAME ASC");
	$this->punchData['product']=$product;
	
	
		
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."purchase-order";	
	$this->load->view("main",$this->punchData);		
	}
	}



//pending order 
	public function Pendingorders(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	

    if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","City","required");	
	}
		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];	

				$this->load->model("purchaseReportsModel");
				$response=$this->purchaseReportsModel->Pendingorders($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."pending-order-data",$responseData,TRUE);	
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
	$party=$this->dataModel->getData("PARTY","ATYPE=1","","VNAME ASC");
	
	$this->punchData['branch']=$branch;	
	$this->punchData['party']=$party;	
	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."pending-order";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	
	
	
	/// Transfer shipment 
	
	public function transfership(){
		
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	if($data['brtype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}	
	$this->form_validation->set_rules("rtype","Report Type","required");	
	$this->form_validation->set_rules("ortype","Order By","required");
	
    if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","Supplier","required");	
	}
	if($data['prtype']==1){
	$this->form_validation->set_rules("product[]","Design","required");	
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
					
				$this->load->model("purchaseReportsModel");
				$response=$this->purchaseReportsModel->transfership($data);

				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."transfership-data",$responseData,TRUE);	
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
    $party=$this->dataModel->getData("PARTY","ATYPE=1","","VNAME ASC");
	$this->punchData['party']=$party;
	$product=$this->dataModel->getData("DESIGN","","","NAME ASC");
	$this->punchData['product']=$product;
	

	
		
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."transfership";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	
	
	
	
public function purchaseReturn(){
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
	if($data['mtype']==1){
	$this->form_validation->set_rules("mgroup[]","Main Group","required");	
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
				$this->load->model("purchaseReportsModel");
				$response=$this->purchaseReportsModel->purchaseReturn($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."purchase-return-data",$responseData,TRUE);	
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
	$mgroup=$this->dataModel->getData("DESIGN","","","NAME ASC");
	$this->punchData['mgroup']=$mgroup;

	$this->punchData['branch']=$branch;	
	$party=$this->dataModel->getParties(5);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."purchase-return";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
}
