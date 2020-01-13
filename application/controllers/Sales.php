<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MY_Controller{

function __construct(){
parent::__construct();
$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs","datatable");
if(!$this->input->is_ajax_request() && $this->uri->segment(3))
{
$no=$this->uri->segment(3);	
if(!is_numeric($no) || $this->uri->segment(4)){
redirect(base_url($this->uri->segment(1)."/".$this->uri->segment(2)));	
}
}
}

function saleVoucher(){
$mainTable="SALE1";
$mainTable2="SALE2";
$voucher_Jo="SL";
$gnrllgr="Gnrllgr";		
$stock="STOCK";		
$this->load->model("saleVoucherModel");
$type=$this->uri->segment(3);
$type2=$this->uri->segment(4);
$segment1=$this->router->class;
$segment2=$this->router->method;
$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
if($this->input->post() && $type2!="delete"){
$this->form_validation->set_rules("no","Voucher No.","required|numeric");
$this->form_validation->set_rules("vdate","Voucher Date","required");
$this->form_validation->set_rules("vcode","Party","required");
$this->form_validation->set_rules("sacode","Sales Account","required");
$this->form_validation->set_rules("stype","Sales Type","required");
$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
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
$response=$this->saleVoucherModel->insert($data);
if($response===true){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>$response));
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
$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));

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

$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));

$this->punchData['account']=$account;
$this->punchData['party']=$party;
$this->punchData['unit']=$unit;
$this->punchData['product']=$product;
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Sales Voucher";
$this->punchData['view']="$segment1/voucher/$segment2/main";
$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
if($this->uri->segment(3) && is_numeric($type)){
$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
if(!empty($data)){
$this->punchData['max']=$data[0]['NO'];
$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
$this->punchData['bdate']=date("d/m/Y",strtotime($data[0]['BDATE']));
$this->punchData['data']=$data;	
$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
$this->punchData['data2']=$data2;	
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

/// SALES TAX INVOICE
	function saleInvoice(){
	$mainTable="SALE1";
	$mainTable2="SALE2";
	$voucher_Jo="SL";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";		
	$this->load->model("saleInvoiceModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vcode","Party","required");
	$this->form_validation->set_rules("sacode","Sales Account","required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$this->form_validation->set_rules("tnet","Net Amount","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->saleInvoiceModel->insert($data);
		if($response===true){
				echo json_encode(array("error"=>"","success"=>"true"));
			}
			else{
				echo json_encode(array("error"=>$response));
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
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
    $party=$this->dataModel->getParties(1);
	$account=$this->dataModel->getAccount();
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['product']=$product;
	$this->punchData['unit']=$unit;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['podate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Sale Invoice";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['podate']=date("d/m/Y",strtotime($data[0]['PODATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
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
/// RUNUNIG SALES 
	function sale(){
	$mainTable="SALE1";
	$mainTable2="SALE2";
	$voucher_Jo="SV";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";		
	$this->load->model("saleModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vno","Bill No","required");
	$this->form_validation->set_rules("vcode","Party","required");
	$this->form_validation->set_rules("sacode","Sales Account","required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$this->form_validation->set_rules("net","Net Amount","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->saleModel->insert($data);
		if($response===true){
				echo json_encode(array("error"=>"","success"=>"true"));
			}
			else{
				echo json_encode(array("error"=>$response));
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
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
	elseif($this->userData['B_ID']==6){
	$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('10101017','10101018') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}
	
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$product1=$this->dataModel->getData("PRODUCT","","PCODE,PNAME,SRATE","PCODE ASC");
	$salesman=$this->dataModel->getData("SALESMAN",array("B_ID"=>$this->userData['B_ID']),"ID,NAME","ID ASC");
	//$product=$this->dataModel->getData("SALESSTOCK","",array("B_ID"=>$this->userData['B_ID']),"PNAME ASC");
	$product=$this->dataModel->getData("STOCKTRANSFER",array("B_ID"=>$this->userData['B_ID']),"PCODE,PNAME,BNAME,QTY","PNAME ASC");

	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));	
	//$this->punchData['account']=$account;
	//$this->punchData['party']=$party;
	$this->punchData['product']=$product;
	$this->punchData['product1']=$product1;
	$this->punchData['salesman']=$salesman;
	$this->punchData['unit']=$unit;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['podate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Sale Invoice";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['podate']=date("d/m/Y",strtotime($data[0]['PODATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
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
	
function saleReturn(){
$mainTable="SRET1";
$mainTable2="SRET2";
$voucher_Jo="SR";
$gnrllgr="Gnrllgr";		
$stock="STOCK";		
$this->load->model("saleReturnModel");
$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vno","Bill No","required");
	$this->form_validation->set_rules("vcode","Party","required");
	$this->form_validation->set_rules("sacode","Sales Account","required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
	$this->form_validation->set_rules("tamount","Total Amount","greater_than[0]|required");
	$this->form_validation->set_rules("net","Net Amount","greater_than[0]|required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->saleReturnModel->insert($data);
		if($response===true){
				echo json_encode(array("error"=>"","success"=>"true"));
			}
			else{
				echo json_encode(array("error"=>$response));
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
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
	
	
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$salesman=$this->dataModel->getData("SALESMAN",array("B_ID"=>$this->userData['B_ID']),"ID,NAME","ID ASC");
	//$product=$this->dataModel->getData("SALESSTOCK","",array("B_ID"=>$this->userData['B_ID']),"PNAME ASC");

	//$product=$this->dataModel->getData("STOCKTRANSFER",array("B_ID"=>$this->userData['B_ID']),"PCODE,PNAME,BNAME,QTY","PNAME ASC");
    $product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PCODE ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));	
	//$this->punchData['account']=$account;
	//$this->punchData['party']=$party;
	$this->punchData['product']=$product;
	$this->punchData['salesman']=$salesman;
	$this->punchData['unit']=$unit;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['podate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Sale Return Invoice";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['podate']=date("d/m/Y",strtotime($data[0]['PODATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
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

function bookIssueNote(){
$mainTable="BISSUE1";
$mainTable2="BISSUE2";	
$voucher_Jo="BI";
$this->load->model("bookIssueNoteModel");
$type=$this->uri->segment(3);
$type2=$this->uri->segment(4);
$segment1=$this->router->class;
$segment2=$this->router->method;
$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
if($this->input->post() && $type2!="delete"){	
$this->form_validation->set_rules("no","Voucher No.","required|numeric");
$this->form_validation->set_rules("vdate","Voucher Date","required");
$this->form_validation->set_rules("starting","Starting No.","required");
$this->form_validation->set_rules("ending","Ending No.","required");
if($this->form_validation->run()){
$data=$this->input->post();
$data['action']="save";
if($this->uri->segment(3) && is_numeric($type))
{
$data['no']=$this->uri->segment(3);	
$data['action']=$this->uri->segment(4);	
}	
$data['rights']=$this->punchData['voucherrights'][0];
if($this->bookIssueNoteModel->insert($data)){
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
$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Book Issue Note";
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

function customerDemandOrder(){
$mainTable="DO1";
$mainTable2="DO2";
$voucher_Jo="DO";		
$stock="STOCK_DO";		
$this->load->model("customerDemandOrderModel");
$type=$this->uri->segment(3);
$type2=$this->uri->segment(4);
$segment1=$this->router->class;
$segment2=$this->router->method;
$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
if($this->input->post() && $type2!="delete"){	
$this->form_validation->set_rules("no","Voucher No.","required|numeric");
$this->form_validation->set_rules("vdate","Voucher Date","required");
$this->form_validation->set_rules("vname","Party","required");
if($this->form_validation->run()){
$data=$this->input->post();
$data['action']="save";
if($this->uri->segment(3) && is_numeric($type))
{
$data['no']=$this->uri->segment(3);	
$data['action']=$this->uri->segment(4);	
}	
$data['rights']=$this->punchData['voucherrights'][0];
$response=$this->customerDemandOrderModel->insert($data);
if($response===true){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>$response));
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
$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
$party=$this->dataModel->getParties(4);
$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
$this->punchData['party']=$party;
$this->punchData['unit']=$unit;
$this->punchData['product']=$product;
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Customer Demand Order";
$this->punchData['view']="$segment1/voucher/$segment2/main";
$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
if($this->uri->segment(3) && is_numeric($type)){
$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
if(!empty($data)){
$this->punchData['max']=$data[0]['NO'];
$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
$this->punchData['data']=$data;	
$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
$this->punchData['data2']=$data2;	
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

function saleOrder(){
$mainTable="SORDR1";
$mainTable2="SORDR2";
$voucher_Jo="SO";		
$stock="STOCK_SORDR";		
$this->load->model("saleOrderModel");
$type=$this->uri->segment(3);
$type2=$this->uri->segment(4);
$segment1=$this->router->class;
$segment2=$this->router->method;
$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
if($this->input->post() && $type2!="delete"){	
$this->form_validation->set_rules("no","Voucher No.","required|numeric");
$this->form_validation->set_rules("vdate","Voucher Date","required");
$this->form_validation->set_rules("vname","Party","required");
if($this->form_validation->run()){
$data=$this->input->post();
$data['action']="save";
if($this->uri->segment(3) && is_numeric($type))
{
$data['no']=$this->uri->segment(3);	
$data['action']=$this->uri->segment(4);	
}	
$data['rights']=$this->punchData['voucherrights'][0];
$check=$this->dataModel->getData("DC2",array("SONO"=>$data['no'],"B_ID"=>$this->userData['B_ID']),"","");
if(empty($check)){
$response=$this->saleOrderModel->insert($data);
if($response===true){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>$response));
}
}	else {
echo json_encode(array("error"=>"Challan is Present against this Order"));
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
$check=$this->dataModel->getData("DC2",array("SONO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
if(empty($check)){
$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$venterDate=date("Y-m-d H:i:s");
$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
echo json_encode(array("success"=>"true"));
}	else {
echo json_encode(array("error"=>"Challan is Present against this Order"));
}		}
else{
echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
}
}
}
else{
$party=$this->dataModel->getParties(4);
$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
$this->punchData['party']=$party;
$this->punchData['unit']=$unit;
$this->punchData['product']=$product;
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Purchase Order";
$this->punchData['view']="$segment1/voucher/$segment2/main";
$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
if($this->uri->segment(3) && is_numeric($type)){
$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
if(!empty($data)){
$this->punchData['max']=$data[0]['NO'];
$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
$this->punchData['data']=$data;	
$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
$this->punchData['data2']=$data2;	
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

function limitAdjustment(){
$mainTable="LIMITADJ";
$mainTable2="";
$voucher_Jo="LAD";		
$stock="";		
$this->load->model("limitAdjustmentModel");
$type=$this->uri->segment(3);
$type2=$this->uri->segment(4);
$segment1=$this->router->class;
$segment2=$this->router->method;
$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
if($this->input->post() && $type2!="delete"){	
$this->form_validation->set_rules("no","Voucher No.","required|numeric");
$this->form_validation->set_rules("vdate","Voucher Date","required");
$this->form_validation->set_rules("vname","Party","required");
if($this->form_validation->run()){
$data=$this->input->post();
$data['action']="save";
if($this->uri->segment(3) && is_numeric($type))
{
$data['no']=$this->uri->segment(3);	
$data['action']=$this->uri->segment(4);	
}	
$data['rights']=$this->punchData['voucherrights'][0];

$response=$this->limitAdjustmentModel->insert($data);
if($response===true){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>$response));
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
$party=$this->dataModel->getParties(4);
$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
$this->punchData['party']=$party;
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Limit Adjustment";
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

function deliveryChallan(){
$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");	
$mainTable="DC1";
$mainTable2="DC2";	
$stock="STOCK_SORDR";	
$voucher_Jo="DC";
$this->load->model("deliveryChallanModel");
$type=$this->uri->segment(3);
$type2=$this->uri->segment(4);
$segment1=$this->router->class;
$segment2=$this->router->method;
$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
if($this->input->post() && $type2!="delete" && $type!="loadso"){	
$this->form_validation->set_rules("no","Voucher No.","required|numeric");
$this->form_validation->set_rules("vdate","Voucher Date","required");
$this->form_validation->set_rules("vcode","Party","required");
$this->form_validation->set_rules("vehicle","Vehicle Name","required");
$this->form_validation->set_rules("vehicleno","Vehicle#","required");
$this->form_validation->set_rules("driver","Driver Name","required");
$this->form_validation->set_rules("tamount","Total Amount","required");
if($this->form_validation->run()){
$data=$this->input->post();
$data['action']="save";
if($this->uri->segment(3) && is_numeric($type))
{
$data['no']=$this->uri->segment(3);	
$data['action']=$this->uri->segment(4);	
}	
$data['rights']=$this->punchData['voucherrights'][0];
$limit = $data['limit'];
$limit = str_replace(',','',$limit);
$total = $data['total'];
$total = str_replace(',','',$total);
$check=$this->dataModel->getData("SALE1",array("DCNO"=>$data['no'],"B_ID"=>$this->userData['B_ID']),"","");
if(empty($check)){
if($total<=$limit){
$response=$this->deliveryChallanModel->insert($data);

if($response===true){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>$response));
}
}	else {
echo json_encode(array("error"=>"یہ چالان پارٹی کی رقم سے تجاوز کردی گئی ہے، لہذا چالان منسوخ کردی گئی ہے"));
}	
}	else {
echo json_encode(array("error"=>"Invoice is Present against this Challan"));
}	}
else{
echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
}	
}
else if($this->uri->segment(3) && is_numeric($type) && $this->uri->segment(4) && $type2=="delete"){
if(!empty($this->punchData['voucherrights'][0]['DEL'])){
if($this->punchData['voucherrights'][0]['DEL']==1){	
$no=$this->uri->segment(3);
$check=$this->dataModel->getData("SALE1",array("DCNO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
if(empty($check)){
$data=$this->db->query("UPDATE SORDR2 set STATUS='Pending' from SORDR2 inner join DC2 on SORDR2.NO = DC2.SONO and DC2.PCODE = SORDR2.PCODE and DC2.VCODE = SORDR2.VCODE and DC2.NO='$no'");
$data=$this->dataModel->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
$data=$this->dataModel->deleteData("$stock",array("NO"=>$no,"B_ID"=>$this->userData['B_ID'],"JO"=>$voucher_Jo));
$venterDate=date("Y-m-d H:i:s");
$this->db->query("INSERT INTO VDLOG(VDATE,U_ID,B_ID,NO,JO) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo')");
$this->db->query("INSERT INTO VDLOG2(VDATE,U_ID,B_ID,NO,JO,TYPE) SELECT * FROM VLOG WHERE NO='$no' AND JO='$voucher_Jo' AND B_ID='".$this->userData['B_ID']."'");
$data=$this->dataModel->deleteData("VLOG",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
echo json_encode(array("success"=>"true"));
}	else {
echo json_encode(array("error"=>"Invoice is Present against this Challan"));
}	}
else{
echo json_encode(array("success"=>"false","error"=>"Not Authorized"));	
}
}
}
else if($this->uri->segment(3) && $type=="loadso"){
$vcode=$this->input->post("vcode");	
$data=$this->dataModel->query("select '' as pro_bal,'' as pro_wght,a1.PCODE,a1.PNAME,a1.UNIT,a1.PONO,a1.RATE,a1.MAXQTY,a1.MAXWGHT,a1.MAXFT,a2.NO,a2.VDATE from
(SELECT PRODUCT.PCODE,PRODUCT.PNAME,STOCK_SORDR.UNIT,STOCK_SORDR.PONO,STOCK_SORDR.RATE
,SUM(STOCK_SORDR.INQT-STOCK_SORDR.OUTQT) AS MAXQTY
,SUM(STOCK_SORDR.INWGHT-STOCK_SORDR.OUTWGHT) AS MAXWGHT
,SUM(STOCK_SORDR.INFT-STOCK_SORDR.OUTFT) AS MAXFT 
FROM STOCK_SORDR
LEFT JOIN PRODUCT ON STOCK_SORDR.PCODE=PRODUCT.PCODE 
WHERE STOCK_SORDR.VCODE='$vcode' AND STOCK_SORDR.B_ID='".$this->userData['B_ID']."'
GROUP BY PRODUCT.PCODE,PRODUCT.PNAME,STOCK_SORDR.UNIT,STOCK_SORDR.PONO,STOCK_SORDR.RATE
HAVING (SUM(STOCK_SORDR.INWGHT-STOCK_SORDR.OUTWGHT)<>0 OR 
SUM(STOCK_SORDR.INQT-STOCK_SORDR.OUTQT)<>0 OR 
SUM(STOCK_SORDR.INFT-STOCK_SORDR.OUTFT)<>0)) a1
inner join 
(SELECT PCODE,PNAME,a1.NO,a1.VDATE,RATE,PONO,UNIT from SORDR2 a2 inner join SORDR1 a1 on a1.NO=a2.NO and 
a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.VCODE='$vcode' and a1.B_ID='".$this->userData['B_ID']."' 
and a2.STATUS='Pending') a2 
on a1.pcode = a2.pcode and a1.rate = a2.rate and a1.pono = a2.pono
");	
if(!empty($data)){	
foreach($data as $a){	
$stk=$this->dataModel->query("select SUM(INQT-OUTQT) as bal,sum(INWGHT-OUTWGHT) as wght from STOCK where PCODE='".$a['PCODE']."' and B_ID='".$this->userData['B_ID']."' ");
if(!empty($stk)){
foreach($stk as $b){
$records[]=array(array("id"=>$a['PCODE'],"bal"=>$b['bal'],"wght"=>$b['wght']));
}	}
}	}
if(!empty($data)){
echo $this->load->view("$segment1/voucher/$segment2/loadso",["data"=>$data,"records"=>$records],true);	
}
else{
echo "<h2>Sorry No Sale Order Found !</h2>";
}
}
else{
$party=$this->dataModel->getParties(4);
$this->punchData['party']=$party;
$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Delivery Challan";
$this->punchData['view']="$segment1/voucher/$segment2/main";
$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
if($this->uri->segment(3) && is_numeric($type)){
$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
if(!empty($data)){
$this->punchData['max']=$data[0]['NO'];
$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
$clmt=$this->dataModel->getData("PARTY",array("VCODE"=>$data[0]['VCODE']),"","");
$ordr=$this->dataModel->query("select SUM(INQT-OUTQT) as pro_bal,sum(INWGHT-OUTWGHT) as pro_wght, a12.PCODE,a12.PNAME,a12.UNIT,a12.PONO,a12.RATE,a12.MAXQTY,a12.MAXWGHT,a12.MAXFT,a12.NO,a12.VDATE from stock a11 inner join 
(select a1.PCODE,a1.PNAME,a1.UNIT,a1.PONO,a1.RATE,a1.MAXQTY,a1.MAXWGHT,a1.MAXFT,a2.NO,a2.VDATE from
(SELECT PRODUCT.PCODE,PRODUCT.PNAME,STOCK_SORDR.UNIT,STOCK_SORDR.PONO,STOCK_SORDR.RATE
,SUM(STOCK_SORDR.INQT-STOCK_SORDR.OUTQT) AS MAXQTY
,SUM(STOCK_SORDR.INWGHT-STOCK_SORDR.OUTWGHT) AS MAXWGHT
,SUM(STOCK_SORDR.INFT-STOCK_SORDR.OUTFT) AS MAXFT 
FROM STOCK_SORDR
LEFT JOIN PRODUCT ON STOCK_SORDR.PCODE=PRODUCT.PCODE 
WHERE STOCK_SORDR.VCODE='".$data[0]['VCODE']."' AND STOCK_SORDR.B_ID='".$this->userData['B_ID']."'
GROUP BY PRODUCT.PCODE,PRODUCT.PNAME,STOCK_SORDR.UNIT,STOCK_SORDR.PONO,STOCK_SORDR.RATE
HAVING (SUM(STOCK_SORDR.INWGHT-STOCK_SORDR.OUTWGHT)<>0 OR 
SUM(STOCK_SORDR.INQT-STOCK_SORDR.OUTQT)<>0 OR 
SUM(STOCK_SORDR.INFT-STOCK_SORDR.OUTFT)<>0)) a1
inner join 
(SELECT PCODE,PNAME,a1.NO,a1.VDATE,RATE,PONO,UNIT from SORDR2 a2 inner join SORDR1 a1 on a1.NO=a2.NO and 
a1.B_ID=a2.B_ID and a1.VCODE=a2.VCODE and a1.VCODE='".$data[0]['VCODE']."' and a1.B_ID='".$this->userData['B_ID']."' 
and a2.STATUS='Pending') a2 
on a1.pcode = a2.pcode and a1.rate = a2.rate and a1.pono = a2.pono) a12
on a11.PCODE = a12.PCODE and a11.B_ID='".$this->userData['B_ID']."'
group by a12.PCODE,a12.PNAME,a12.UNIT,a12.PONO,a12.RATE,a12.MAXQTY,a12.MAXWGHT,a12.MAXFT,a12.NO,a12.VDATE
");	
$this->punchData['clmt']=$clmt;	
$this->punchData['ordr']=$ordr;	
$this->punchData['data']=$data;	
$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
$this->punchData['data2']=$data2;
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

function discount(){
$mainTable="DISCOUNT";
$voucher_Jo="DV";
$gnrllgr="Gnrllgr";	
$this->load->model("discountModel");
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
if($this->discountModel->insert($data)){
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
$account=$this->dataModel->getAccounts();
$party=$this->dataModel->getParties(4);
$supplier=$this->dataModel->getParties(5);
$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
$this->punchData['account']=$account;
$this->punchData['party']=$party;
$this->punchData['supplier']=$supplier;
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Discount Voucher";
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

function amendment(){
$mainTable="AMENDMENT";
$voucher_Jo="AM";
$gnrllgr="Gnrllgr";	
$this->load->model("amendmentModel");
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
if($this->amendmentModel->insert($data)){
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
$account=$this->dataModel->getAccounts();
$party=$this->dataModel->getParties(4);
$supplier=$this->dataModel->getParties(5);
$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
$this->punchData['account']=$account;
$this->punchData['party']=$party;
$this->punchData['supplier']=$supplier;
$this->punchData['max']=$max;
$this->punchData['vdate']=date("d/m/Y");
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Amendment Voucher";
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


	function saleadj(){
		
	$mainTable="SALEA1";
	$mainTable2="SALEA2";
	$voucher_Jo="SA";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK";		
	$this->load->model("saleAdjModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("ono","Bill No","required");
	$this->form_validation->set_rules("vcode","Party","required");

		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->saleAdjModel->insert($data);
		if($response===true){
				echo json_encode(array("error"=>"","success"=>"true"));
			}
			else{
				echo json_encode(array("error"=>$response));
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
	$data=$this->dataModel->deleteData("$mainTable2",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	$data=$this->dataModel->deleteData("$stock",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
	$account=$this->dataModel->getData("ACCOUNT","ACODE IN ('30101003','10101009') ","ACODE,ANAME","ACODE ASC");
		$party=$this->dataModel->getData("PARTY","VCODE='10102001'","VCODE,VNAME","VCODE ASC");
			$this->punchData['account']=$account;
			$this->punchData['party']=$party;
	}
	
	
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$salesman=$this->dataModel->getData("SALESMAN",array("B_ID"=>$this->userData['B_ID']),"ID,NAME","ID ASC");
	//$product=$this->dataModel->getData("SALESSTOCK","",array("B_ID"=>$this->userData['B_ID']),"PNAME ASC");
	$product=$this->dataModel->getData("STOCKTRANSFER",array("B_ID"=>$this->userData['B_ID']),"PCODE,PNAME,BNAME,QTY","PNAME ASC");

	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));	
	//$this->punchData['account']=$account;
	//$this->punchData['party']=$party;
	$this->punchData['product']=$product;
	$this->punchData['salesman']=$salesman;
	$this->punchData['unit']=$unit;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['podate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Sale Adjustment";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['podate']=date("d/m/Y",strtotime($data[0]['PODATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;	
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
