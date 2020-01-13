<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs","datatable");
	if(!$this->input->is_ajax_request() && $this->uri->segment(3)){
	$no=$this->uri->segment(3);	
	if(!is_numeric($no) || $this->uri->segment(4)){
	redirect(base_url($this->uri->segment(1)."/".$this->uri->segment(2)));	
	}
	}
	}
	//cash receipt 
	function cashr(){
	$mainTable="CASHRCP";
	$voucher_Jo="CR";
	$gnrllgr="Gnrllgr";		
	$this->load->model("cashRcpModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
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
			if($this->cashRcpModel->insert($data)){
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
	
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) 
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
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
	$account=$this->dataModel->getAccounts(0);
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getSuppliers(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Cash Reciept Voucher";
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
	
	
	
	//Running Cash Payemnt
	function cashcp(){
	$mainTable="CASHPYM";
	$voucher_Jo="CP";
	$gnrllgr="Gnrllgr";		
	$this->load->model("cashPymModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
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
			if($this->cashPymModel->insert($data)){
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
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) 
	
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
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
		
		if ($this->userData['B_ID']==1)
	{	
   	//$accountp=$this->dataModel->getAccountsp();
	//$account=$this->dataModel->getAccounts(0);
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$accountp=$this->dataModel->getData("ACCOUNT","ATYPE IN (0,1) AND Levl=4 OR ACODE='30101005'","ACODE,ANAME","ACODE ASC");
	$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
	$account=$this->dataModel->getAccount();
	$this->punchData['account']=$account;
	$this->punchData['accountp']=$accountp;
	
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['invoiceno']=$invoiceno;
	}
	elseif($this->userData['B_ID']==2){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101013','10101014') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
  //  $account=$this->dataModel->getAccount();
	$this->punchData['account']=$account;   
   $this->punchData['invoiceno']=$invoiceno;
	$this->punchData['accountp']=$accountp;	
	$this->punchData['party']=$party;
	
	}
	elseif($this->userData['B_ID']==3){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101006','10101005') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
    
		$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;
		
	   $this->punchData['invoiceno']=$invoiceno;
	
			$this->punchData['accountp']=$accountp;
			$this->punchData['party']=$party;
	}
	elseif($this->userData['B_ID']==4){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101011','10101012') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
//    $account=$this->dataModel->getAccount();
		$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;      
	  $this->punchData['invoiceno']=$invoiceno;
	
			$this->punchData['accountp']=$accountp;
			$this->punchData['party']=$party;
	}	
	elseif($this->userData['B_ID']==5){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101015','10101009') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
				$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;
			$this->punchData['accountp']=$accountp;
			$this->punchData['invoiceno']=$invoiceno;
			$this->punchData['party']=$party;
	}
		
		elseif($this->userData['B_ID']==6){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101017','10101018') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
				$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;
			$this->punchData['accountp']=$accountp;
			$this->punchData['invoiceno']=$invoiceno;
			$this->punchData['party']=$party;
	}
		
	
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	
	//$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Cash Payment Voucher";
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
	
	
	
	
	//Bank receipt
	function bankrc(){
	$mainTable="DEBIT";
	$voucher_Jo="BR";
	$gnrllgr="Gnrllgr";		
	$this->load->model("BankRcpModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Bank Account. Code","required");
	$this->form_validation->set_rules("caname","Bank Account. Name","required");
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
			if($this->BankRcpModel->insert($data)){
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

	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) 
	
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
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
	$account=$this->dataModel->getAccounts(1);
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getSuppliers(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Bank Reciept Voucher";
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
	
	
	
	//Bank Payment
	function bankcp(){
	$mainTable="CREDIT";
	$voucher_Jo="BP";
	$gnrllgr="Gnrllgr";		
	$this->load->model("BankPymModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Bank Account. Code","required");
	$this->form_validation->set_rules("caname","Bank Account. Name","required");
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
			if($this->BankPymModel->insert($data)){
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

	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) 
	
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
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
	$account=$this->dataModel->getAccounts(1);

	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getSuppliers(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Bank Payemnt Voucher";
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
	
	
	//running cash receipt
	function cashReciept(){
	$mainTable="CASHRCP";
	$voucher_Jo="CR";
	$gnrllgr="Gnrllgr";	
	$gnrllgrChq="Gnrllgr_chq";	
	$this->load->model("cashRecieptModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
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
			if($this->cashRecieptModel->insert($data)){
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
		
	if ($this->userData['B_ID']==1)
	{	
   	//$accountp=$this->dataModel->getAccountsp();
	$account=$this->dataModel->getAccounts(0);
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$accountp=$this->dataModel->getData("ACCOUNT","ATYPE IN (0,1) AND Levl=4 OR ACODE='30101005'","ACODE,ANAME","ACODE ASC");
	$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
	$this->punchData['account']=$accountp;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['invoiceno']=$invoiceno;
	}
	elseif($this->userData['B_ID']==2){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101013','10101014') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		//$accountp=$this->dataModel->getData("ACCOUNT","ATYPE IN (0,1) AND Levl=4 OR ACODE='30101005'","ACODE,ANAME","ACODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
    $this->punchData['invoiceno']=$invoiceno;
	
	$this->punchData['account']=$accountp;
	$this->punchData['party']=$party;
	
	}
	elseif($this->userData['B_ID']==3){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101006','10101005') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
        $this->punchData['invoiceno']=$invoiceno;
	
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}
	elseif($this->userData['B_ID']==4){
		$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101011','10101012') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
        $this->punchData['invoiceno']=$invoiceno;
	
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}	
	elseif($this->userData['B_ID']==5){
	$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101015','10101009') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}

elseif($this->userData['B_ID']==6){
	$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101018','10101017') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}	
	//$accountp=$this->dataModel->getAccountsp();
	$account=$this->dataModel->getAccounts(0);
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$accountp=$this->dataModel->getData("ACCOUNT","ATYPE IN (0,1) AND Levl=4 OR ACODE='30101005'","ACODE,ANAME","ACODE ASC");
	$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
 $this->punchData['invoiceno']=$invoiceno;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Payment Reciept Voucher";
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
	
	function cashPayment(){
	$mainTable="CASHPYM";
	$voucher_Jo="CP";
	$gnrllgr="Gnrllgr";			
	$this->load->model("cashPaymentModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
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
			if($this->cashPaymentModel->insert($data)){
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
	$accountp=$this->dataModel->getData("ACCOUNT","ATYPE IN (0,1) AND Levl=4 ","ACODE,ANAME","ACODE ASC");

	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getSuppliers(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['accountp']=$accountp;
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Cash Payment Voucher";
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
	
	function bankReciept(){
	$mainTable="DEBIT";
	$voucher_Jo="BR";
	$gnrllgr="Gnrllgr";		
	$gnrllgrChq="Gnrllgr_chq";		
	$this->load->model("bankRecieptModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
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
			if($this->bankRecieptModel->insert($data)){
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
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) 
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
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
	$account=$this->dataModel->getAccounts();
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$bank=$this->dataModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['bank']=$bank;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Bank Reciept Voucher";
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
	
	function bankPayment(){
	$mainTable="CREDIT";
	$voucher_Jo="BP";
	$gnrllgr="Gnrllgr";	
	$gnrllgr2="Gnrllgr_cb";	
	$this->load->model("bankPaymentModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
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
			if($this->bankPaymentModel->insert($data)){
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
	$data=$this->dataModel->deleteData("$gnrllgr2",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
	$account=$this->dataModel->getAccounts(1);
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getSuppliers(5);
	$bank=$this->dataModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['bank']=$bank;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Bank Payment Voucher";
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
	
	function opJournal(){
	$mainTable="OPJOURNAL";
	$voucher_Jo="OP";
	$gnrllgr="Gnrllgr";	
	$this->load->model("opJournalModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("tdebit","Total Debit Amount","greater_than[0]|required");
	$this->form_validation->set_rules("tcredit","Total Credit Amount","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($data['tdebit']==$data['tcredit']){
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
			if($this->opJournalModel->insert($data)){
				echo json_encode(array("error"=>"","success"=>"true"));
			}
			else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
			}
		}
		else{
		echo json_encode(array("error"=>array("debitCredit"=>"Debit And Credit Must Be Same"),"success"=>"false"));
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
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getSuppliers(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="OPening Journal Voucher";
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
		
	function journal(){
	$mainTable="JOURNAL";
	$voucher_Jo="JV";
	$gnrllgr="Gnrllgr";	
	$this->load->model("journalModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("tdebit","Total Debit Amount","greater_than[0]|required");
	$this->form_validation->set_rules("tcredit","Total Credit Amount","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($data['tdebit']==$data['tcredit']){
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
			if($this->journalModel->insert($data)){
				echo json_encode(array("error"=>"","success"=>"true"));
			}
			else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
			}
		}
		else{
		echo json_encode(array("error"=>array("debitCredit"=>"Debit And Credit Must Be Same"),"success"=>"false"));
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
		if ($this->userData['B_ID']==1)
	{	
   	//$accountp=$this->dataModel->getAccountsp();
	//$account=$this->dataModel->getAccounts(0);
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$accountp=$this->dataModel->getData("ACCOUNT","ATYPE IN (0,1) AND Levl=4 OR ACODE='30101005'","ACODE,ANAME","ACODE ASC");
	$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
	$account=$this->dataModel->getAccount();
	$this->punchData['account']=$account;
	$this->punchData['accountp']=$accountp;
	
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['invoiceno']=$invoiceno;
	}
	elseif($this->userData['B_ID']==2){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101013','10101014') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
  //  $account=$this->dataModel->getAccount();
	$this->punchData['account']=$account;   
   $this->punchData['invoiceno']=$invoiceno;
	$this->punchData['accountp']=$accountp;	
	$this->punchData['party']=$party;
	
	}
	elseif($this->userData['B_ID']==3){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101006','10101005') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
    
		$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;
		
	   $this->punchData['invoiceno']=$invoiceno;
	
			$this->punchData['accountp']=$accountp;
			$this->punchData['party']=$party;
	}
	elseif($this->userData['B_ID']==4){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101011','10101012') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
//    $account=$this->dataModel->getAccount();
		$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;      
	  $this->punchData['invoiceno']=$invoiceno;
	
			$this->punchData['accountp']=$accountp;
			$this->punchData['party']=$party;
	}	
	elseif($this->userData['B_ID']==5){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101015','10101009') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$invoiceno=$this->dataModel->getData("SALESPAY",array("B_ID"=>$this->userData['B_ID']),"INVNO,DIF,ACode,VNAME","INVNO ASC");
				$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4","ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;
			$this->punchData['accountp']=$accountp;
			$this->punchData['invoiceno']=$invoiceno;
			$this->punchData['party']=$party;
	}
		
		elseif($this->userData['B_ID']==6){
		$accountp=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101017','10101018') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
		$account=$this->dataModel->getData("ACCOUNT","ATYPE=9 AND Levl=4 AND ACODE NOT IN ('40204022','40204021','40204003','40204019','40204023') OR ACODE IN ('30101002')" ,"ACODE,ANAME","ACODE ASC");
        $this->punchData['account']=$account;
		$this->punchData['accountp']=$accountp;
		$this->punchData['party']=$party;
	}
		
	
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	//$this->punchData['account']=$account;
	//$this->punchData['party']=$party;
	//$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Journal Voucher";
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
	// CHINA OPENING BALANCE
	
	function cjournal(){
	$mainTable="CJOURNAL";
	$voucher_Jo="COP";
	$gnrllgr="SGnrllgr";	
	$this->load->model("cjournalModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("tdebit","Total Debit Amount","greater_than[0]|required");
	$this->form_validation->set_rules("tcredit","Total Credit Amount","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($data['tdebit']==$data['tcredit']){
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
			if($this->cjournalModel->insert($data)){
				echo json_encode(array("error"=>"","success"=>"true"));
			}
			else{
				echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
			}
		}
		else{
		echo json_encode(array("error"=>array("debitCredit"=>"Debit And Credit Must Be Same"),"success"=>"false"));
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
	$party=$this->dataModel->getParties(4);
	//$supplier=$this->dataModel->getParties(5);
	$supplier=$this->dataModel->getSuppliers(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="China Opening Voucher";
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
	
	function chqReciept(){
	$mainTable="CHQRECIEPT";
	$voucher_Jo="RC";
	$gnrllgr="Gnrllgr_chq";	
	$this->load->model("chqRecieptModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$data=$this->input->post();
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}
	if($data['action']=='save'){
	$nrows=$data['nrows'];
	$row=1;
	while($row<$nrows){
	if(!empty($data['acode_'.$row.''])){
	$this->form_validation->set_rules("chqNo_".$row."","Chq No ".$data['chqNo_'.$row.'']." in row Number $row ","is_unique[$mainTable.CHQNO]");
	}	
	$row++;	
	}
	}
		if($this->form_validation->run()){
		
		
		$data['rights']=$this->punchData['voucherrights'][0];
			if($this->chqRecieptModel->insert($data)){
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
	$account=$this->dataModel->getAccounts();
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$bank=$this->dataModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['bank']=$bank;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Cheque In Hand Voucher";
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
	
	function chqTransfer(){
	array_push($this->punchData['libraries'],"dateRangePicker");	
	$mainTable="CHQTRANSFER";
	$voucher_Jo="CT";
	$gnrllgr="Gnrllgr_chq";	
	$this->load->model("chqTransferModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete" && $type2!="cheque"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("faccount","From Account","required");
	$this->form_validation->set_rules("taccount","To Account","required");
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
			if($this->chqTransferModel->insert($data)){
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
	else if($this->uri->segment(3) && $this->uri->segment(4) && $type2=="cheque"){
	
	$data=$this->input->post();
	$faccount=$data['faccount'];
	$dt=explode(" - ",$data['date']);
	$date1=$this->dataModel->dateFormat($dt[0]);
	$date2=$this->dataModel->dateFormat($dt[1]);
	
	$response=$this->dataModel->query("SELECT 
	T1.ACODE,T1.ANAME,T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,T1.DEBIT,T1.DESCR
	FROM (SELECT CHQNO FROM $gnrllgr WHERE ACODE='$faccount' GROUP BY CHQNO HAVING SUM(DEBIT-CREDIT)<>0) AS T2 INNER JOIN CHQRECIEPT AS T1 ON T2.CHQNO=T1.CHQNO
	INNER JOIN $gnrllgr AS T3 ON T1.CHQNO=T3.CHQNO AND T1.ACODE=T3.ACODE
	WHERE T1.CHQDATE >= '$date1' AND T1.CHQDATE <= '$date2'
	GROUP BY T1.ACODE,T1.ANAME,T1.BCODE,T1.BNAME,T1.CHQNO,T1.CHQDATE,T1.DEBIT,T1.DESCR
	HAVING SUM(T3.DEBIT-T3.CREDIT)<>0
	ORDER BY T1.CHQDATE ASC
	");	
	$data=$this->load->view("$segment1/voucher/$segment2/row",array("data"=>$response),true);
	echo json_encode(array("data"=>$data));
	}
	else{
	$account=$this->dataModel->getAccounts();
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Cheque Transfer Voucher";
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
		
	function accountGroup(){
	$mainTable="ACGROUP";
	$this->load->model("accountGroupModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("agrp","Account Group","required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
			if($this->accountGroupModel->insert($data)){
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
	$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no));
	echo json_encode(array("success"=>"true"));
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
	}
	}
	}
	else{
	$account=$this->dataModel->getAccounts();
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$group=$this->dataModel->getData("PGROUP","","PGRP,PGNAME","PGNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO","");
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['account']=$account;
	$this->punchData['group']=$group;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Account Group Activity";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3)),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['data']=$data;	
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
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

	function chqBook(){
	$mainTable="CHQBOOK";
	$voucher_Jo="CB";
	$gnrllgr="Gnrllgr_cb";
	$this->load->model("chqBookModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("bank","Bank","required");
	$is_unique="|is_unique[CHQBOOK.BNO]";
	if($type2=='update'){
	$no=$this->uri->segment(3);	
	$bno=$this->dataModel->getData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']),"BNO","");
	$pbno=$this->input->post("bno");
	if($bno[0]['BNO']==$pbno){
	$is_unique="";	
	}
	}
	$this->form_validation->set_rules("bno","Book No.","required".$is_unique."");
	$ending=$this->input->post("ending");
	$starting=$this->input->post("starting");
	$starting+=200;
	$this->form_validation->set_rules("starting","Starting No.","required|greater_than[0]|less_than[$ending]");
	$this->form_validation->set_rules("ending","Ending No.","required|greater_than[0]|less_than[$starting]");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
			if($this->chqBookModel->insert($data)){
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
	$data=$this->dataModel->deleteData("$Gnrllgr_cb",array("NO"=>$no,"B_ID"=>$this->userData['B_ID'],"Jo"=>$voucher_Jo));
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
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$bank=$this->dataModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
	$this->punchData['max']=$max;
	$this->punchData['bank']=$bank;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Cheque Book Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$this->punchData['data']=$data;
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

	function chqReturn(){
	$mainTable="CHQRETURN";
	$voucher_Jo="CN";
	$gnrllgr="Gnrllgr_chq";	
	$this->load->model("chqReturnModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$data=$this->input->post();
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash Acc. Name","required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$data['action']="save";
	if($this->uri->segment(3) && is_numeric($type))
	{
	$data['no']=$this->uri->segment(3);	
	$data['action']=$this->uri->segment(4);	
	}
	if($data['action']=='save'){
	$nrows=$data['nrows'];
	$row=1;
	while($row<$nrows){
	if(!empty($data['acode_'.$row.''])){
	$this->form_validation->set_rules("chqNo_".$row."","Chq No ".$data['chqNo_'.$row.'']." in row Number $row ","is_unique[$mainTable.CHQNO]");
	}	
	$row++;	
	}
	}
		if($this->form_validation->run()){
		
		
		$data['rights']=$this->punchData['voucherrights'][0];
			if($this->chqRecieptModel->insert($data)){
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
	$account=$this->dataModel->getAccounts();
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$bank=$this->dataModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['bank']=$bank;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Cheque Return/Bounce Voucher";
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
	


function scashPayment(){
	$mainTable="SCASHPYM";
	$voucher_Jo="FCP";
	$gnrllgr="SGnrllgr";			
	$this->load->model("scashPaymentModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("cacode","Cash/Bank Acc. Code","required");
	$this->form_validation->set_rules("caname","Cash/Bank Acc. Name","required");
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
			if($this->scashPaymentModel->insert($data)){
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
	$accountp=$this->dataModel->getData("ACCOUNT","ATYPE IN (0,1) AND Levl=4 OR ACODE='30101005'","ACODE,ANAME","ACODE ASC");

	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getSuppliers(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['accountp']=$accountp;
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="China Payment Voucher";
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
