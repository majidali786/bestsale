<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("PayrollModel");
	$this->punchData['libraries']=array("datatable","formJs","datePicker","numberJs","dateRangePicker");
	}

	function department(){
	$segment=$this->uri->segment(3);
	$segment1=$this->router->class;
	$segment2=$this->router->method;		
	if($this->input->is_ajax_request())
	{
	if($segment=="list")
	{
	$list=$this->dataModel->getData("UDEPT","","ID,UDEPT AS NAME","UDEPT ASC");
	$data['list']=$list;
	echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
	}
	if($segment=="save")
	{
	$this->form_validation->set_rules("name","Department","required|is_unique[UDEPT.UDEPT]");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->insertDepartment($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	if($segment=="edit")
	{
	$data=$this->dataModel->getData("UDEPT",array("ID"=>$this->input->post("id")),"","");
	$this->punchData['data']=$data;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
	}
	if($segment=="update")
	{
	$match=$this->dataModel->getData("UDEPT",array("ID"=>$this->input->post("id")),"","");	
	if($match[0]['UDEPT']!=$this->input->post("name"))
	{
	$unique="|is_unique[UDEPT.UDEPT]";	
	}
	else{
	$unique="";	
	}
	$this->form_validation->set_rules("name","Department","required".$unique."");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->updateDepartment($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	if($segment=="delete")
	{
	$data=$this->dataModel->deleteData("UDEPT",array("ID"=>$this->input->post("id")));
	return true;	
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Employee Department";
	$this->punchData['view']="$segment1/$segment2/main";
	$this->load->view("main",$this->punchData);		
	}	
	}

	function designation(){
	$segment=$this->uri->segment(3);
	$segment1=$this->router->class;
	$segment2=$this->router->method;		
	if($this->input->is_ajax_request())
	{
	if($segment=="list")
	{
	$list=$this->dataModel->getData("UDESIG","","ID,UDESIG AS NAME","UDESIG ASC");
	$data['list']=$list;
	echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
	}
	if($segment=="save")
	{
	$this->form_validation->set_rules("name","Designation","required|is_unique[UDESIG.UDESIG]");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->insertDesignation($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	if($segment=="edit")
	{
	$data=$this->dataModel->getData("UDESIG",array("ID"=>$this->input->post("id")),"","");
	$this->punchData['data']=$data;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
	}
	if($segment=="update")
	{
	$match=$this->dataModel->getData("UDESIG",array("ID"=>$this->input->post("id")),"","");	
	if($match[0]['UDESIG']!=$this->input->post("name"))
	{
	$unique="|is_unique[UDESIG.UDESIG]";	
	}
	else{
	$unique="";	
	}
	$this->form_validation->set_rules("name","Designation","required".$unique."");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->updateDesignation($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	if($segment=="delete")
	{
	$data=$this->dataModel->deleteData("UDESIG",array("ID"=>$this->input->post("id")));
	return true;	
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Employee Designation";
	$this->punchData['view']="$segment1/$segment2/main";
	$this->load->view("main",$this->punchData);		
	}	
	}

	function salaryInfo(){
	$segment=$this->uri->segment(3);
	$segment1=$this->router->class;
	$segment2=$this->router->method;		
	if($this->input->is_ajax_request())
	{
	if($segment=="save")
	{
	$this->form_validation->set_rules("employee","Employee","required");
	$this->form_validation->set_rules("whours","Working Hours Of A Day","required");
	$this->form_validation->set_rules("basic","Basic Pay","required");
	$this->form_validation->set_rules("gpay","Gross Pay","required|greater_than[0]");
	$this->form_validation->set_rules("npay","Net Pay","required|greater_than[0]");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->insertSalaryInfo($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($segment=="edit")
	{
	$data=$this->dataModel->getData("UDESIG",array("ID"=>$this->input->post("id")),"","");
	$this->punchData['data']=$data;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
	}
	else if($segment=="details")
	{
	$data=$this->dataModel->getData("EMPLOYEE",array("ID"=>$this->input->post("id")),"","");
	$data2=$this->dataModel->getData("SALARYINFO",array("ID"=>$this->input->post("id")),"","");
	$this->punchData['datae']=$data;
	$this->punchData['data']=$data2;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
	$employee=$this->dataModel->getData("EMPLOYEE","","","NAME ASC");
	$this->punchData['employee']=$employee;
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Employee Salary Information";
	$this->punchData['view']="$segment1/$segment2/main";
	$this->load->view("main",$this->punchData);		
	}	
	}

	function loan(){
	unset($this->punchData['libraries'][1]);	
	array_push($this->punchData['libraries'],"voucherJs","inputMask");	
	$mainTable="LOAN";
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="LN";
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("type","Type","required");
	$this->form_validation->set_rules("atype","Type","required");
	$this->form_validation->set_rules("acode","From Account","required");
	$this->form_validation->set_rules("employee","Employee","required");
	$this->form_validation->set_rules("ecode","Ecode","required");
	$this->form_validation->set_rules("amount","Loan/Advance","required|numeric|greater_than[0]");
	if($this->input->post("type")!=3){
	$this->form_validation->set_rules("ninstall","No. Of Installments","required|numeric|greater_than[0]");
	$this->form_validation->set_rules("pminstall","Per Month Installment","required|numeric|greater_than[0]");
	}
	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}	
	$data['rights']=$this->punchData['voucherrights'][0];
	if($this->PayrollModel->insertLoan($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgrloan",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$account=$this->dataModel->getAccount();
	//$employee=$this->dataModel->getData("EMPLOYEE","","ID,NAME,DEPARTMENT,DESIGNATION,STATUS","NAME ASC");
	$employee=$this->dataModel->getData("ACCOUNT","ATYPE IN (2,11) AND LEVL=4","ACODE,ANAME,ATYPE","ANAME ASC");
	$this->punchData['account']=$account;	
	$this->punchData['employee']=$employee;	
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Loan/Advance Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$this->punchData['data']=$data;
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}	

	function loanPayment(){
	unset($this->punchData['libraries'][1]);	
	array_push($this->punchData['libraries'],"voucherJs","inputMask");	
	$mainTable="LOANPAYMENT";
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="LP";
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("type","Type","required");
	$this->form_validation->set_rules("acode","From Account","required");
	$this->form_validation->set_rules("employee","Employee","required");
	$this->form_validation->set_rules("ecode","Ecode","required");
	$this->form_validation->set_rules("amount","Loan/Advance","required|numeric|greater_than[0]");
	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}	
	$data['rights']=$this->punchData['voucherrights'][0];
	if($this->PayrollModel->insertLoanPayment($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){	
	$no=$this->uri->segment(3);
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgrloan",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$account=$this->dataModel->getAccount();
	//$employee=$this->dataModel->getData("EMPLOYEE","","ID,NAME,DEPARTMENT,DESIGNATION,STATUS","NAME ASC");
	$employee=$this->dataModel->getData("ACCOUNT","ATYPE IN (2,11) AND LEVL=4","ACODE,ANAME,ATYPE","ANAME ASC");
	$this->punchData['account']=$account;	
	$this->punchData['employee']=$employee;	
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Loan/Advance Payment Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$this->punchData['data']=$data;
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}

	function salarySheet(){
	array_push($this->punchData['libraries'],"salaryJs");
	$segment=$this->uri->segment(3);
	$segment1=$this->router->class;
	$segment2=$this->router->method;		
	if($this->input->is_ajax_request())
	{
	if($segment=="save")
	{
	$this->form_validation->set_rules("date","Date","required");
	$this->form_validation->set_rules("trows","Total Employee","required");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->insertSalarySheet($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($segment=="edit")
	{

	}
	else if($segment=="details")
	{
	$date=$this->dataModel->dateFormat($this->input->post("date"));	  
    $vdate1=date("Y-m-d",strtotime("+1 month",strtotime($date)));
    $vdate2=date("Y-m-d",strtotime("+2 month",strtotime($date)));
	
	$data=$this->dataModel->query("SELECT T1.ID,T1.NAME,T1.BASIC,T1.CALLOWANCE,T1.CONVEYANCE,T1.UTILITY,T1.OVERTIME,T1.LOAN
	,T1.ADVANCE,T1.INCOMETAX,T1.LEAVE,T1.EOBI,T1.TALLOWANCE,T1.GPAY,T1.TDEDUCTION,T1.NPAY,T1.YLEAVE,
	T1.WHOURS,T2.DEPARTMENT,T2.DESIGNATION FROM SALARYINFO AS T1 LEFT JOIN EMPLOYEE AS T2 ON T1.ID=T2.ID 
	 ORDER BY T1.NAME ASC");
	$data2=$this->dataModel->query("SELECT * FROM SALARYSHEET WHERE DATEPART(MONTH,VDATE)='".date("m",strtotime($date))."' 
	and DATEPART(YEAR,VDATE)='".date("Y",strtotime($date))."'");
	$sloan=$this->dataModel->query("SELECT VDATE,ACODE,LTYPE,STYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan   GROUP BY VDATE,ACODE,LTYPE,STYPE");
	
	
	$lloan=$this->dataModel->query("SELECT ACODE,LTYPE,STYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan  GROUP BY ACODE,LTYPE,STYPE");
	$advance=$this->dataModel->query("SELECT ACODE,LTYPE,STYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan  GROUP BY ACODE,LTYPE,STYPE");

	$this->punchData['sloan']=$sloan;
	$this->punchData['lloan']=$lloan;
	$this->punchData['advance']=$advance;
	$this->punchData['date']=$date;
	$this->punchData['data']=$data;
	$this->punchData['data2']=$data2;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Employee Monthly Salary Information";
	$this->punchData['view']="$segment1/$segment2/main";
	$this->load->view("main",$this->punchData);		
	}	
	}

	function paymentContract(){
	array_push($this->punchData['libraries'],"salaryJs");
	$segment=$this->uri->segment(3);
	$segment1=$this->router->class;
	$segment2=$this->router->method;		
	if($this->input->is_ajax_request())
	{
	if($segment=="save")
	{
	$this->form_validation->set_rules("date","Date","required");
	$this->form_validation->set_rules("trows","Total Employee","required");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->insertPaymentContract($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($segment=="edit")
	{

	}
	else if($segment=="details")
	{
	$date = $this->input->post();
	$dt=explode(" - ",$date['date']);
	$date1=$this->dataModel->dateFormat($dt[0]);
	$date2=$this->dataModel->dateFormat($dt[1]);
	$data=$this->dataModel->query("SELECT A1.ACODE,ANAME,SUM(CASE WHEN Jo='PD' AND VDate>='$date1' AND VDate<='$date2' THEN A2.QTY ELSE 0 END) as totalpipeproduct,
	SUM(CASE WHEN Jo='PD' AND VDate>='$date1' AND VDate<='$date2' THEN convert(float,A2.REMARKS) ELSE 0 END) as pipeproduct20,
	SUM(CASE WHEN Jo='PD' AND VDate>='$date1' AND VDate<='$date2' THEN A2.Credit ELSE 0 END) as amount
	FROM ACCOUNT A1 
	LEFT JOIN Gnrllgr A2 on A1.ACode=A2.ACode AND A2.B_ID='".$this->userData['B_ID']."' and Jo IN ('PD')
	WHERE ATYPE=11
	GROUP BY A1.ACODE,ANAME");
	$loan=$this->dataModel->query("select A1.ACODE,
	SUM(CASE WHEN A2.Jo IN ('LN','LP','PC') and LTYPE=1 THEN A2.Debit-A2.Credit ELSE 0 END) as sloan,
	SUM(CASE WHEN A2.Jo IN ('LN','LP','PC') and LTYPE=2 THEN A2.Debit-A2.Credit ELSE 0 END) as lloan,
	SUM(CASE WHEN A2.Jo IN ('LN','LP','PC') and LTYPE=3 THEN A2.Debit-A2.Credit ELSE 0 END) as advance
	FROM ACCOUNT A1 
	LEFT JOIN Gnrllgr_loan A2  on A1.ACode=A2.ACode AND A2.B_ID='".$this->userData['B_ID']."'
	WHERE ATYPE=11
	GROUP BY A1.ACODE");
	$data2=$this->dataModel->query("SELECT * FROM PAYMENTCONTRACT WHERE SDATE='$date1' AND B_ID='".$this->userData['B_ID']."'");
	$this->punchData['date1']=$date1;
	$this->punchData['date2']=$date2;
	$this->punchData['data']=$data;
	$this->punchData['data2']=$data2;
	$this->punchData['loan']=$loan;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Payment Summary for Contract";
	$this->punchData['view']="$segment1/$segment2/main";
	$this->load->view("main",$this->punchData);		
	}	
	}

	function salarySheetDaily(){
	array_push($this->punchData['libraries'],"salaryDailyJs");
	$segment=$this->uri->segment(3);
	$segment1=$this->router->class;
	$segment2=$this->router->method;		
	if($this->input->is_ajax_request())
	{
	if($segment=="save")
	{
	$this->form_validation->set_rules("date","Date","required");
	//$this->form_validation->set_rules("trows","Total Employee","required");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->insertsalarySheetDaily($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($segment=="edit")
	{

	}
	else if($segment=="details")
	{
	$date=$this->input->post("date");	
	$dt=explode(" - ",$date);
	$date1=$this->dataModel->dateFormat($dt[0]);
	$date2=$this->dataModel->dateFormat($dt[1]);

	$data=$this->dataModel->query("SELECT T1.ID,T1.NAME,T1.BASIC,T1.CALLOWANCE,T1.CONVEYANCE,T1.UTILITY,T1.OVERTIME,T1.LOAN
	,T1.ADVANCE,T1.INCOMETAX,T1.LEAVE,T1.EOBI,T1.TALLOWANCE,T1.GPAY,T1.TDEDUCTION,T1.NPAY,T1.YLEAVE
	,T1.WHOURS,T2.DEPARTMENT,T2.DESIGNATION FROM SALARYINFO AS T1 INNER JOIN EMPLOYEE AS T2 
	ON T1.ID=T2.ID WHERE T2.STATUS=2 AND T2.WSTATUS=0 AND T2.BID='".$this->userData['B_ID']."' ORDER BY T1.NAME ASC");
	$data2=$this->dataModel->query("SELECT * FROM SALARYSHEETDAILY WHERE VDATE='$date1'");
	$sloan=$this->dataModel->query("SELECT ACODE,LTYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan WHERE LTYPE=1 GROUP BY ACODE,LTYPE");
	$lloan=$this->dataModel->query("SELECT ACODE,LTYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan WHERE LTYPE=2 GROUP BY ACODE,LTYPE");
	$advance=$this->dataModel->query("SELECT ACODE,LTYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan WHERE LTYPE=3 GROUP BY ACODE,LTYPE");
	$this->punchData['sloan']=$sloan;
	$this->punchData['lloan']=$lloan;
	$this->punchData['advance']=$advance;
	$this->punchData['date']=$date;
	$this->punchData['date1']=$date1;
	$this->punchData['date2']=$date2;
	$this->punchData['data']=$data;
	$this->punchData['data2']=$data2;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Employee Daily Wages Salary Information";
	$this->punchData['view']="$segment1/$segment2/main";
	$this->load->view("main",$this->punchData);		
	}	
	}

	function salarySheetOvertime(){
	array_push($this->punchData['libraries'],"salaryDailyJs");
	$segment=$this->uri->segment(3);
	$segment1=$this->router->class;
	$segment2=$this->router->method;		
	if($this->input->is_ajax_request())
	{
	if($segment=="save")
	{
	$this->form_validation->set_rules("date","Date","required");
	//$this->form_validation->set_rules("trows","Total Employee","required");
	if($this->form_validation->run()){
	$data = $this->input->post();
	if($this->PayrollModel->insertsalarySheetOvertime($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($segment=="edit")
	{

	}
	else if($segment=="details")
	{
	$date=$this->input->post("date");	
	$dt=explode(" - ",$date);
	$date1=$this->dataModel->dateFormat($dt[0]);
	$date2=$this->dataModel->dateFormat($dt[1]);

	$data=$this->dataModel->query("SELECT T1.ID,T1.NAME,T1.BASIC,T1.CALLOWANCE,T1.CONVEYANCE,T1.UTILITY,T1.OVERTIME,T1.LOAN,T1.ADVANCE,T1.INCOMETAX,T1.LEAVE,T1.EOBI,T1.TALLOWANCE,T1.GPAY,T1.TDEDUCTION,T1.NPAY,T1.YLEAVE,T1.WHOURS,T2.DEPARTMENT,T2.DESIGNATION FROM SALARYINFO AS T1 INNER JOIN EMPLOYEE AS T2 ON T1.ID=T2.ID WHERE T2.STATUS<>2 AND T2.WSTATUS=0 AND T2.BID='".$this->userData['B_ID']."' ORDER BY T1.NAME ASC");
	$data2=$this->dataModel->query("SELECT * FROM SALARYSHEETOVERTIME WHERE VDATE='$date1'");
	$sloan=$this->dataModel->query("SELECT ACODE,LTYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan WHERE LTYPE=1 GROUP BY ACODE,LTYPE");
	$lloan=$this->dataModel->query("SELECT ACODE,LTYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan WHERE LTYPE=2 GROUP BY ACODE,LTYPE");
	$advance=$this->dataModel->query("SELECT ACODE,LTYPE,SUM(DEBIT-CREDIT) AS AMT FROM Gnrllgr_loan WHERE LTYPE=3 GROUP BY ACODE,LTYPE");
	$this->punchData['sloan']=$sloan;
	$this->punchData['lloan']=$lloan;
	$this->punchData['advance']=$advance;
	$this->punchData['date']=$date;
	$this->punchData['date1']=$date1;
	$this->punchData['date2']=$date2;
	$this->punchData['data']=$data;
	$this->punchData['data2']=$data2;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Employee Daily Wages Salary Information";
	$this->punchData['view']="$segment1/$segment2/main";
	$this->load->view("main",$this->punchData);		
	}	
	}

	function salaryIncrement(){
	unset($this->punchData['libraries'][1]);	
	array_push($this->punchData['libraries'],"voucherJs","inputMask");	
	$mainTable="SALARYINC";
	$voucher_Jo="SI";
	$this->load->model("PayrollModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	if($this->form_validation->run()){
	$data=$this->input->post();
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}	
	$data['rights']=$this->punchData['voucherrights'][0];
	if($this->PayrollModel->salaryIncrement($data)){
	echo json_encode(array("error"=>"","success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
	}

	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}	
	}
	else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
	if(!empty($this->punchData['voucherrights'][0]['DEL'])){
	if($this->punchData['voucherrights'][0]['DEL']==1){
	$no=$this->uri->segment(3);
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
	$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
	$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	echo json_encode(array("success"=>"true"));
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$employee=$this->dataModel->query("SELECT T1.ID,T1.NAME,T1.BASIC,T1.CALLOWANCE,T1.CONVEYANCE,T1.UTILITY,T1.OVERTIME,T1.LOAN,T1.ADVANCE,T1.INCOMETAX,T1.LEAVE,T1.EOBI,T1.TALLOWANCE,T1.GPAY,T1.TDEDUCTION,T1.NPAY,T1.YLEAVE,T1.WHOURS,T2.DEPARTMENT,T2.DESIGNATION FROM SALARYINFO AS T1 LEFT JOIN EMPLOYEE AS T2 ON T1.ID=T2.ID WHERE T2.STATUS<>2 ORDER BY T1.NAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['employee']=$employee;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Salary Increment Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['data']=$data;	
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$this->punchData['unposted']=$unposted;
	$this->punchData['posted']=$posted;
	$this->punchData['approved']=$approved;
	}
	if(is_numeric($type)){
	$this->punchData['max']=$this->uri->segment(3);	
	}
	}
	if($this->input->is_ajax_request()){
	$this->punchData['dataType']="ajax";	
	echo $this->load->view($this->punchData['loadVoucher'],$this->punchData,true);	
	}
	else{
	$this->load->view("main",$this->punchData);			
	}
	}
	}	
	
}
