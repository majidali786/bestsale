<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerReports extends MY_Controller{
	public $reportPath;
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("datePicker","dateRangePicker","reportsJs","datatable","barchart","promiseJs");
	$this->reportPath="sales/reports/customer/";
	$this->punchData['heading']="Customer Reports";	
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->balance($data);
				if($response){
				$responseData['data']=$response;
				$responseData['vdate']=$vdate;				
				$responseData['vdate2']=$vdate2;				
				$responseData['vdate3']=$vdate3;				
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
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."balance";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function listing(){
	if($this->input->is_ajax_request()){
	$data=$this->input->post();	
	$this->form_validation->set_rules("check1","Check1","required");
	if($data['btype']==1){
	$this->form_validation->set_rules("branch[]","Branch","required");
	}
	if($data['ctype']==1){
	$this->form_validation->set_rules("city[]","City","required");
	}	
	if($data['stype']==1){
	$this->form_validation->set_rules("salesman[]","Salesman","required");
	}	
	if($this->form_validation->run()){
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->listing($data);
				if($response){
				$responseData['data']=$response;				
				$viewResponse=$this->load->view($this->reportPath."listing-data",$responseData,TRUE);	
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
	$city=$this->dataModel->getData("CITY","","CCODE,CNAME","CNAME ASC");
	$salesman=$this->dataModel->getData("SPERSON","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;	
	$this->punchData['city']=$city;	
	$this->punchData['salesman']=$salesman;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."listing";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function ledger(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("branch","Branch","required");	
	
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->ledger($data);
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
	if ($this->userData['B_ID']==1)
	{	
	$party=$this->dataModel->getData("PARTY","ATYPE='0'","VCODE,VNAME,MOBILE,EMAIL","VCODE ASC");
	$account=$this->dataModel->getAccount();
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	}
	elseif($this->userData['B_ID']==2){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101013','10101014') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}
	elseif($this->userData['B_ID']==3){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101006','10101005') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}
	elseif($this->userData['B_ID']==4){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101011','10101012') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}
	
	elseif($this->userData['B_ID']==5){
	$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101015','10101009') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}
	
		
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function ledgerChq(){
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->ledgerChq($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."ledger-chq-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."ledger-chq-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger-chq";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function ledgerAll(){
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->ledgerAll($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."ledger-all-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."ledger-all-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger-all";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function ledgerAllChqs(){
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->ledgerAllChqs($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."ledger-all-chq-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."ledger-all-chq-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."ledger-all-chq";	
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
				$responseData['vdate']=$data['date'];		
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->aging($data);
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
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."aging";	
	$this->load->view("main",$this->punchData);		
	}
	}

	public function agingPrevious(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("party","Party","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$vdate2=date("Y-m-d",strtotime("-1 month",strtotime($vdate)));
				$vdate3=date("Y-m-d",strtotime("-2 month",strtotime($vdate)));
				$data['vdate']=$vdate;
				$responseData['vdate']=$data['date'];		
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->agingPrevious($data);
				if($response){
				$responseData['data']=$response;					
				$viewResponse=$this->load->view($this->reportPath."aging-previous-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."aging-previous-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."aging-previous";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function agingAll(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$data['vdate']=$vdate;
				$responseData['vdate']=$data['date'];		
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->agingAll($data);
				if($response){
				$responseData['data']=$response;
				$promis=$this->dataModel->query("select a1.NO,a1.DESCR as desc1,a2.DESCR as desc2,a1.ACODE from PROMISE a1 left join 
				PROMISECOMMENT a2 on a1.NO=a2.PNO and a1.B_ID=a2.B_ID and a1.B_ID='".$this->userData['B_ID']."'");
				$responseData['promis']=$promis;	
				$tot=$this->dataModel->query("select SUM(T_SALE) as tsale,sum(T_REC) as trec,SUM(SALE1) as sale1,sum(SALE2) as sale2
				,SUM(SALE3) as sale3,sum(REC1) as rec1,SUM(REC2) as rec2,sum(REC3) as rec3,SNAME,SPERSON from Lgrrep_age 
				where U_ID='".$this->userData['U_ID']."' group by SNAME,SPERSON");
				
				$responseData['tot']=$tot;	
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
	$sperson=$this->dataModel->getData("SPERSON","","BCODE,BNAME","BNAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$party=$this->dataModel->getParties(4);
	$this->punchData['branch']=$branch;	
	$this->punchData['sperson']=$sperson;	
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."aging-all";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function salesmanAging(){
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
				if($data['sperson']==0){
				$sperson="";	
				}
				else{
				$sperson="AND a2.SID='".$data['sperson']."'";		
				}				
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->salesmanAging($data);
				if($response){
				$responseData['data']=$response;
				$data2=$this->dataModel->query("SELECT SUM(CASE when VDate<='$date1' then Debit-Credit else 0 end) as op,SUM(CASE when VDate>'$date1' and VDate<'$date2' and Jo in ('SL','SR','OP') then Debit-Credit else 0 end) as sale,SUM(CASE when VDate>'$date1' and VDate<'$date2' and Jo in ('CR','BR') then Credit else 0 end) as recovry,SID,SPERSON from gnrllgr a1 inner join PARTY a2 on a1.ACode=a2.VCODE and a2.ATYPE='4' $sperson group by SID,SPERSON");
				$responseData['data2']=$data2;
				$viewResponse=$this->load->view($this->reportPath."salesman-aging-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."salesman-aging-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$sperson=$this->dataModel->getData("SPERSON","","BCODE,BNAME","BNAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$party=$this->dataModel->getParties(4);
	$this->punchData['branch']=$branch;	
	$this->punchData['sperson']=$sperson;	
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."salesman-aging";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function spersonRecoveryChq(){
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->spersonRecoveryChq($data);
				if($response){
				$responseData['data']=$response;					
				$viewResponse=$this->load->view($this->reportPath."sperson-recovery-chq-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."sperson-recovery-chq-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$sperson=$this->dataModel->getData("SPERSON","","BCODE,BNAME","BNAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$party=$this->dataModel->getParties(4);
	$this->punchData['branch']=$branch;	
	$this->punchData['sperson']=$sperson;	
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."sperson-recovery-chq";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function spersonRecoveryChqGraph(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
		if($this->form_validation->run()){
				$data = $this->input->post();
				$fdate="2018-01-01";
				$vdate=$this->dataModel->dateFormat($data['date']);
				$diff=date_diff(date_create($vdate),date_create($fdate));
				$months=$diff->format("%m");
				$dateArray=array();
				for($a=0;$a<=$months;$a++){
				$date=date("Y-m-d",strtotime("-$a month",strtotime($vdate)));	
				array_push($dateArray,$date);
				}
				sort($dateArray);
				$data['vdate']=$vdate;
				$data['fdate']=$fdate;
				$data['dates']=$dateArray;
				$responseData['vdate']=$data['date'];
				$responseData['dates']=$dateArray;
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->spersonRecoveryChqGraph($data);
				if($response){
				$responseData['data']=$response;					
				$viewResponse=$this->load->view($this->reportPath."sperson-recovery-chq-graph-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."sperson-recovery-chq-graph-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$sperson=$this->dataModel->getData("SPERSON","","BCODE,BNAME","BNAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$party=$this->dataModel->getParties(4);
	$this->punchData['branch']=$branch;	
	$this->punchData['sperson']=$sperson;	
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."sperson-recovery-chq-graph";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function agingAllPrevious(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");		
		if($this->form_validation->run()){
				$data = $this->input->post();
				$vdate=$this->dataModel->dateFormat($data['date']);
				$vdate2=date("Y-m-d",strtotime("-1 month",strtotime($vdate)));
				$vdate3=date("Y-m-d",strtotime("-2 month",strtotime($vdate)));
				$data['vdate']=$vdate;
				$responseData['vdate']=$data['date'];		
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->agingAllPrevious($data);
				if($response){
				$responseData['data']=$response;					
				$viewResponse=$this->load->view($this->reportPath."aging-all-previous-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."aging-all-previous-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$sperson=$this->dataModel->getData("SPERSON","","BCODE,BNAME","BNAME ASC");
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$party=$this->dataModel->getParties(4);
	$this->punchData['branch']=$branch;	
	$this->punchData['sperson']=$sperson;	
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."aging-all-previous";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function chqDetail(){
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->chqDetail($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."cheque-detail-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."cheque-detail-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."cheque-detail";	
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->invoiceDetail($data);
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
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;
$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."invoice-detail";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function invoiceCashDetail(){
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->invoiceCashDetail($data);
				if($response){
				$responseData['data']=$response;	
				$viewResponse=$this->load->view($this->reportPath."invoice-cash-detail-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."invoice-cash-detail-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."invoice-cash-detail";	
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
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->invoiceDetail($data);
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
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$branch=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$this->punchData['branch']=$branch;
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."invoice-summary";	
	$this->load->view("main",$this->punchData);		
	}
	}
	
	public function balanceComparison(){
	if($this->input->is_ajax_request()){
	$this->form_validation->set_rules("date","Date","required");	
	$this->form_validation->set_rules("party","Party","required");	
		if($this->form_validation->run()){
				$data = $this->input->post();
				$fdate="2019-10-01";
				$vdate=$this->dataModel->dateFormat($data['date']);
				$diff=date_diff(date_create($vdate),date_create($fdate));
				$months=$diff->format("%m");
				$dateArray=array();
				for($a=0;$a<=$months;$a++){
				$date=date("Y-m-d",strtotime("-$a month",strtotime($vdate)));	
				array_push($dateArray,$date);
				}
				sort($dateArray);
				$data['vdate']=$vdate;
				$data['fdate']=$fdate;
				$data['dates']=$dateArray;
				$responseData['vdate']=$data['date'];
				$responseData['dates']=$dateArray;
				$this->load->model("customerReportsModel");
				$response=$this->customerReportsModel->balanceComparison($data);
				if($response){
				$responseData['data']=$response;					
				$viewResponse=$this->load->view($this->reportPath."balance-comparison-data",$responseData,TRUE);	
					echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
				else{
				$responseData['data']=array();	
				$viewResponse=$this->load->view($this->reportPath."balance-comparison-data",$responseData,TRUE);	
				echo json_encode(array("data"=>$viewResponse,"success"=>"true"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
	}
	else{
	$party=$this->dataModel->getParties(4);
	$this->punchData['party']=$party;	
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");		
	$this->punchData['view']=$this->reportPath."balance-comparison";	
	$this->load->view("main",$this->punchData);		
	}
	}

}
