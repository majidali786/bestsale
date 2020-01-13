<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StoreSpareReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","barchart");
	$this->reportPath="storespare/reports/storespare/";
	$this->punchData['heading']="Store And Spare Reports";	
	}
	
	public function stockTransfer(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	if($data['brtype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}	
	if($data['fdptype']==1){
	$this->form_validation->set_rules("fdepartment[]","From Deparmtent","required");	
	}	
	if($data['tdptype']==1){
	$this->form_validation->set_rules("tdepartment[]","To Deparmtent","required");	
	}
	if($data['prtype']==1){
	$this->form_validation->set_rules("product[]","Product","required");	
	}
	if($data['mtype']==1){
	$this->form_validation->set_rules("mgroup[]","Main Group","required");	
	}
	if($data['stype']==1){
	$this->form_validation->set_rules("size[]","Size","required");	
	}
	if($data['ottype']==1){
	$this->form_validation->set_rules("outerdia[]","Outer Dia","required");	
	}
	if($data['ctype']==1){
	$this->form_validation->set_rules("coil[]","Coil","required");	
	}
	if($data['gatype']==1){
	$this->form_validation->set_rules("gauge[]","Gauge","required");	
	}
	if($data['utype']==1){
	$this->form_validation->set_rules("unit[]","Unit","required");	
	}
	if($data['wtype']==1){
	$this->form_validation->set_rules("weight[]","Weight","required");	
	}
	if($data['intype']==1){
	$this->form_validation->set_rules("innerdia[]","Inner Dia","required");	
	}
	if($data['otype']==1){
	$this->form_validation->set_rules("others[]","Others","required");	
	}
	if($data['ftype']==1){
	$this->form_validation->set_rules("feet[]","Feet","required");	
	}
	if($data['ntype']==1){
	$this->form_validation->set_rules("nature[]","Nature","required");	
	}
	if($data['htype']==1){
	$this->form_validation->set_rules("hrtype[]","Cr/HR Type","required");	
	}	
		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("storeSpareReportsModel");
				$response=$this->storeSpareReportsModel->stockTransfer($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."stock-transfer-data",$responseData,TRUE);	
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
	$department=$this->dataModel->getData("DEPT","","DPCode,DPName","DPName ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","","PNAME ASC");
	$this->punchData['product']=$product;
	$mgroup=$this->dataModel->getData("MGROUP","","","MGROUP ASC");
	$this->punchData['mgroup']=$mgroup;
	$size=$this->dataModel->getData("SIZE","","","SIZE ASC");
	$this->punchData['size']=$size;
	$outerdia=$this->dataModel->getData("OUTERDIA","","","OUTERDIA ASC");
	$this->punchData['outerdia']=$outerdia;
	$innerdia=$this->dataModel->getData("INNERDIA","","","INNERDIA ASC");
	$this->punchData['innerdia']=$innerdia;
	$coil=$this->dataModel->getData("COIL","","","COIL ASC");
	$this->punchData['coil']=$coil;
	$others=$this->dataModel->getData("OTHERS","","","OTHERS ASC");
	$this->punchData['others']=$others;
	$gauge=$this->dataModel->getData("GAUGE","","","GAUGE ASC");
	$this->punchData['gauge']=$gauge;
	$feet=$this->dataModel->getData("FEET","","","FEET ASC");
	$this->punchData['feet']=$feet;
	$unit=$this->dataModel->getData("UNIT","","","UNIT ASC");
	$this->punchData['unit']=$unit;
	$nature=$this->dataModel->getData("NATURE","","","NATURE ASC");
	$this->punchData['nature']=$nature;
	$weight=$this->dataModel->getData("WEIGHT","","","WEIGHT ASC");
	$this->punchData['weight']=$weight;
	$hrtype=$this->dataModel->getData("HRTYPE","","","HRTYPE ASC");
	$this->punchData['hrtype']=$hrtype;
	$this->punchData['department']=$department;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."stock-transfer";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	public function balance(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	if($data['brtype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}	
	if($data['dptype']==1){
	$this->form_validation->set_rules("department[]","Deparmtent","required");	
	}	
	if($data['prtype']==1){
	$this->form_validation->set_rules("product[]","Product","required");	
	}
	if($data['mtype']==1){
	$this->form_validation->set_rules("mgroup[]","Main Group","required");	
	}
	if($data['stype']==1){
	$this->form_validation->set_rules("size[]","Size","required");	
	}
	if($data['ottype']==1){
	$this->form_validation->set_rules("outerdia[]","Outer Dia","required");	
	}
	if($data['ctype']==1){
	$this->form_validation->set_rules("coil[]","Coil","required");	
	}
	if($data['gatype']==1){
	$this->form_validation->set_rules("gauge[]","Gauge","required");	
	}
	if($data['utype']==1){
	$this->form_validation->set_rules("unit[]","Unit","required");	
	}
	if($data['wtype']==1){
	$this->form_validation->set_rules("weight[]","Weight","required");	
	}
	if($data['intype']==1){
	$this->form_validation->set_rules("innerdia[]","Inner Dia","required");	
	}
	if($data['otype']==1){
	$this->form_validation->set_rules("others[]","Others","required");	
	}
	if($data['ftype']==1){
	$this->form_validation->set_rules("feet[]","Feet","required");	
	}
	if($data['ntype']==1){
	$this->form_validation->set_rules("nature[]","Nature","required");	
	}
	if($data['htype']==1){
	$this->form_validation->set_rules("hrtype[]","Cr/HR Type","required");	
	}	
		if($this->form_validation->run()){
				$vdate=$this->dataModel->dateFormat($data['date']);
				$data['vdate']=$vdate;		
				$this->load->model("storeSpareReportsModel");
				$response=$this->storeSpareReportsModel->balance($data);
				if($response){
				$responseData['data']=$response;			
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
	$department=$this->dataModel->getData("DEPT","","DPCode,DPName","DPName ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","","PNAME ASC");
	$this->punchData['product']=$product;
	$mgroup=$this->dataModel->getData("MGROUP","","","MGROUP ASC");
	$this->punchData['mgroup']=$mgroup;
	$size=$this->dataModel->getData("SIZE","","","SIZE ASC");
	$this->punchData['size']=$size;
	$outerdia=$this->dataModel->getData("OUTERDIA","","","OUTERDIA ASC");
	$this->punchData['outerdia']=$outerdia;
	$innerdia=$this->dataModel->getData("INNERDIA","","","INNERDIA ASC");
	$this->punchData['innerdia']=$innerdia;
	$coil=$this->dataModel->getData("COIL","","","COIL ASC");
	$this->punchData['coil']=$coil;
	$others=$this->dataModel->getData("OTHERS","","","OTHERS ASC");
	$this->punchData['others']=$others;
	$gauge=$this->dataModel->getData("GAUGE","","","GAUGE ASC");
	$this->punchData['gauge']=$gauge;
	$feet=$this->dataModel->getData("FEET","","","FEET ASC");
	$this->punchData['feet']=$feet;
	$unit=$this->dataModel->getData("UNIT","","","UNIT ASC");
	$this->punchData['unit']=$unit;
	$nature=$this->dataModel->getData("NATURE","","","NATURE ASC");
	$this->punchData['nature']=$nature;
	$weight=$this->dataModel->getData("WEIGHT","","","WEIGHT ASC");
	$this->punchData['weight']=$weight;
	$hrtype=$this->dataModel->getData("HRTYPE","","","HRTYPE ASC");
	$this->punchData['hrtype']=$hrtype;
	$this->punchData['department']=$department;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."balance";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	public function ledger(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");	
	if($data['brtype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}	
	if($data['dptype']==1){
	$this->form_validation->set_rules("department[]","Deparmtent","required");	
	}
	if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("storeSpareReportsModel");
				$response=$this->storeSpareReportsModel->ledger($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."ledger-data",$responseData,TRUE);	
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
	$department=$this->dataModel->getData("DEPT","","DPCode,DPName","DPName ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","","PNAME ASC");
	$this->punchData['product']=$product;
	$this->punchData['department']=$department;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger";	
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
				$this->load->model("storeSpareReportsModel");
				$response=$this->storeSpareReportsModel->movement($data);
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
	
	
	
	
}
