<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FinancialReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable");
	$this->reportPath="financial/reports/accounts/";
	$this->punchData['heading']="Financial Reports";	
	}
	
	//account activty
	public function ledger(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");$this->form_validation->set_rules("party","Party","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->ledger($data);
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
	$atype='';	
	if($this->userData['U_TYPE']!=0){
	$usrright=$this->dataModel->query("SELECT * FROM OTHERRIGHTS WHERE USR='".$this->userData['U_ID']."'");
	if(!empty($usrright[0]['ACCOUNTACTIVITY'])){
	if($usrright[0]['ACCOUNTACTIVITY']==1 && !empty($usrright[0]['ACCOUNTACTIVITYDATA'])){	
	$atype="AND ATYPE IN(".$usrright[0]['ACCOUNTACTIVITYDATA'].")";	
	}
	}
	}
	

if ($this->userData['B_ID']==1)
	{	
	$account=$this->dataModel->query("SELECT ACODE,ANAME,ATYPE FROM ACCOUNT WHERE ACODE<>'' AND Levl=4  ORDER BY ATYPE,ANAME ASC");
	$party=$this->dataModel->query("SELECT VCODE,VNAME FROM PARTY WHERE VCODE<>''  ORDER BY VCODE,VNAME ASC");

	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	}
	elseif($this->userData['B_ID']==2){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101013','10101014') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
			$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;
	}
	elseif($this->userData['B_ID']==3){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101006','10101005') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
			$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;
	}
	elseif($this->userData['B_ID']==4){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101011','10101012') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
			$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;
	}
	
	elseif($this->userData['B_ID']==5){
	$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101015','10101009') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
			$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;
	}
	
	



	
	$actype=$this->dataModel->getData("ACCOUNT_TYPE","","ATYPE,ATPNAME","ATPNAME ASC");
	$this->punchData['account']=$account;	
	$this->punchData['party']=$party;	
	$this->punchData['actype']=$actype;	
		
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	
public function cashBank(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
	//$this->form_validation->set_rules("branch","Branch","required");		
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->cashBank($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."cashbank-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."cashbank-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	//$account=$this->dataModel->getParties(4);	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	//$this->punchData['account']=$account;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."cashbank";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
		
	//expense
	public function Expense(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->Expense($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."expense-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."expense-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	
	$account=$this->dataModel->query("SELECT ACODE,ANAME,ATYPE FROM ACCOUNT WHERE ACODE<>'' AND  (LEVL = 3) AND (AGROUP = 4) ORDER BY ATYPE,ANAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$actype=$this->dataModel->getData("ACCOUNT_TYPE","","ATYPE,ATPNAME","ATPNAME ASC");
	$this->punchData['account']=$account;	
		
	$this->punchData['actype']=$actype;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."expense";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	//employee
	public function Eledger(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");$this->form_validation->set_rules("party","Party","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->Eledger($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."employee-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."employee-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	
	$account=$this->dataModel->query("SELECT ACODE,ANAME,ATYPE FROM ACCOUNT WHERE ACODE<>'' AND Levl=4 AND ATYPE='2' ORDER BY ATYPE,ANAME ASC");
	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$actype=$this->dataModel->getData("ACCOUNT_TYPE","","ATYPE,ATPNAME","ATPNAME ASC");
	$this->punchData['account']=$account;	
		
	$this->punchData['actype']=$actype;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."employee";	
	$this->load->view("main",$this->punchData);		
	}
	}
	//cashBook
	public function cashBook(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->cashBook($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."cashbook-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."cashbook-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	//$account=$this->dataModel->getAccounts();
	$account=$this->dataModel->getData("ACCOUNT","","ACODE,ANAME","ANAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['account']=$account;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."cashbook";	
	$this->load->view("main",$this->punchData);		
	}
	}
		
		public function bls(){
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
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->bls($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."bls-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."bls-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$account=$this->dataModel->getAccount();	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	//$group=$this->dataModel->getData("PGROUP","","PGRP,PGNAME","PGNAME ASC");
	//$this->punchData['account']=$account;	
	$this->punchData['branch']=$branch;	
	//$this->punchData['group']=$group;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."bls";	
	$this->load->view("main",$this->punchData);		
	}
	}
		public function pls(){
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
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->pls($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."pls-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."pls-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$account=$this->dataModel->getAccount();	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	//$group=$this->dataModel->getData("PGROUP","","PGRP,PGNAME","PGNAME ASC");
	//$this->punchData['account']=$account;	
	$this->punchData['branch']=$branch;	
	//$this->punchData['group']=$group;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."pls";	
	$this->load->view("main",$this->punchData);		
	}
	}
		
	public function trialSimple(){
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
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->trialSimple($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."trial-simple-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."trial-simple-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$account=$this->dataModel->getParties(4);	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['account']=$account;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."trial-simple";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function trialGroup(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
	$this->form_validation->set_rules("branch","Branch","required");		
	$this->form_validation->set_rules("agroup","Account Group","required");		
		if($this->form_validation->run()){
				$data = $this->input->post();
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->trialGroup($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."trial-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."trial-group-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$group=$this->dataModel->getData("PGROUP","","PGRP,PGNAME","PGNAME ASC");
	$this->punchData['group']=$group;	
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."trial-group";	
	$this->load->view("main",$this->punchData);		
	}
	}
			
	public function trial(){
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
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->trial($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."trial-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."trial-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
		//$account=$this->dataModel->getAccounts();	
	$account=$this->dataModel->getData("ACCOUNT","","ACODE,ANAME","ANAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$group=$this->dataModel->getData("PGROUP","","PGRP,PGNAME","PGNAME ASC");
	$this->punchData['account']=$account;	
	$this->punchData['branch']=$branch;	
	$this->punchData['group']=$group;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."trial";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function userLog(){
	$joInWords=array("BI"=>"Book Issue Note Voucher","BP"=>"Bank Payment Voucher","BR"=>"Bank Receipt Voucher","CP"=>"Cash Payment Voucher"
	,"CR"=>"Cash Receipt Voucher","CT"=>"Cheque Transfer Voucher","FC"=>"Payment Order","JV"=>"Journal Voucher"
	,"LC"=>"LC Information Voucher","LE"=>"LC Expense Voucher","LJ"=>"LC Journal Model","LN"=>"Loan/Advance Voucher"
	,"LP"=>"Loan/Advance Payment Voucher","PO"=>"Purchase Order Voucher","OP"=>"Opening Journal Voucher","TS"=>"Transfer Shipment Voucher"
	,"PR"=>"Purchase Return Voucher","PU"=>"Purchase Voucher","RC"=>"Cheque Receipt Voucher","SL"=>"Sale Voucher"
	,"SO"=>"Sale Order Voucher","SR"=>"Sale Return Voucher","SS"=>"Salary Sheet Voucher"
	,"ST"=>"Stock Transfer Voucher","SG"=>"Store & Spare Goods Receipt Note"
	,"OR"=>"Store & Spare Opening Stock","TS"=>"Store & Spare Stock Transfer","SD"=>"Store & Spare Demand Order"
	,"TS"=>"Store & Spare Stock Transfer");	
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");
	$this->form_validation->set_rules("vno","Voucher No","numeric");
	if($data['utype']==1){
	$this->form_validation->set_rules("users[]","Users","required");	
	}
	if($data['vttype']==1){
	$this->form_validation->set_rules("vtype[]","Voucher Type","required");	
	}
		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->userLog($data);
				if($response){
				
				$responseData['joInWords']=$joInWords;
				$responseData['data']=$response;	
				$responseData['rtype']=$data['rtype'];	
				$viewResponse=$this->load->view($this->reportPath."user-log-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."user-log-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$ausers=$this->dataModel->query("SELECT USERNAME FROM login ORDER BY USERNAME ASC");
	$this->punchData['branch']=$branch;	
	$this->punchData['joInWords']=$joInWords;
	$this->punchData['ausers']=$ausers;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."user-log";	
	$this->load->view("main",$this->punchData);		
	}
	}
	public function dailyLog(){
	$joInWords=array("BI"=>"Book Issue Note Voucher","BP"=>"Bank Payment Voucher","BR"=>"Bank Receipt Voucher","CP"=>"Cash Payment Voucher","CR"=>"Cash Receipt Voucher","CT"=>"Cheque Transfer Voucher","DO"=>"Customer Demand Order","JV"=>"Journal Voucher","LC"=>"LC Information Voucher","LE"=>"LC Expense Voucher","LJ"=>"LC Journal Model","LN"=>"Loan/Advance Voucher","LP"=>"Loan/Advance Payment Voucher","LS"=>"LC Sale Voucher","OP"=>"Opening Journal Voucher","PL"=>"LC Purchase Voucher","PR"=>"Purchase Return Voucher","PU"=>"Purchase Voucher","RC"=>"Cheque Receipt Voucher","SL"=>"Sale Voucher","SO"=>"Sale Order Voucher","SR"=>"Sale Return Voucher","SS"=>"Salary Sheet Voucher","ST"=>"Stock Transfer Voucher","SG"=>"Store & Spare Goods Receipt Note","OR"=>"Store & Spare Opening Stock","TS"=>"Store & Spare Stock Transfer","SD"=>"Store & Spare Demand Order","TS"=>"Store & Spare Stock Transfer");	
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");
	$this->form_validation->set_rules("vno","Voucher No","numeric");
	if($data['vttype']==1){
	$this->form_validation->set_rules("vtype[]","Voucher Type","required");	
	}
		if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];		
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->dailyLog($data);
				if($response){
				$responseData['joInWords']=$joInWords;
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."daily-log-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."daily-log-data",$responseData,TRUE);	
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
	$this->punchData['joInWords']=$joInWords;
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");$this->punchData['view']=$this->reportPath."daily-log";	
	$this->load->view("main",$this->punchData);		
	}
	}	
	public function chqsInHand(){
	if($this->input->is_ajax_request()){
	$data = $this->input->post();	
	$this->form_validation->set_rules("date","Date","required");
	$this->form_validation->set_rules("rtype","Chqs Type","required");	
	$this->form_validation->set_rules("dtype","Date Type","required");	
	$this->form_validation->set_rules("branch","Branch","required");
	if($data['ptype']==1){
	$this->form_validation->set_rules("party[]","Party","required");
	}
	if($data['agtype']==1){
	$this->form_validation->set_rules("agents[]","Agents","required");
	}	
	if($data['btype']==1){
	$this->form_validation->set_rules("bank[]","Banks","required");
	}	
	if($data['ctype']==1){
	$this->form_validation->set_rules("chqno[]","Cheque No.","required");
	}	
	if($this->form_validation->run()){
				$dt=explode(" - ",$data['date']);
				$date1=$this->dataModel->dateFormat($dt[0]);
				$date2=$this->dataModel->dateFormat($dt[1]);
				$data['date1']=$date1;
				$data['date2']=$date2;
				$responseData['date1']=$dt[0];
				$responseData['date2']=$dt[1];	
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->chqsInHand($data);
				if($response){
				$responseData['data']=$response;			
				$viewResponse=$this->load->view($this->reportPath."chqs-in-hand-data",$responseData,TRUE);	
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
	$bank=$this->dataModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
	$chqno=$this->dataModel->query("SELECT DISTINCT(CHQNO) FROM CHQRECIEPT ORDER BY CHQNO ASC");
	$account=$this->dataModel->getAccounts();
	$this->punchData['account']=$account;	
	$this->punchData['chqno']=$chqno;	
	$this->punchData['branch']=$branch;	
	$this->punchData['bank']=$bank;	
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."chqs-in-hand";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
	public function cashflow(){
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
				$this->load->model("FinancialReportsModel");
				$response=$this->FinancialReportsModel->cashflow($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."cashflow-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."cashflow-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$account=$this->dataModel->getAccounts();	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	//$group=$this->dataModel->getData("PGROUP","","PGRP,PGNAME","PGNAME ASC");
	//$this->punchData['account']=$account;	
	$this->punchData['branch']=$branch;	
	//$this->punchData['group']=$group;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."cashflow";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	
}
