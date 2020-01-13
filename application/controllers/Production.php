<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	if(!$this->input->is_ajax_request() && $this->uri->segment(3))
	{
	$no=$this->uri->segment(3);	
	if(!is_numeric($no) || $this->uri->segment(4)){
	redirect(base_url($this->uri->segment(1)."/".$this->uri->segment(2)));	
	}
	}
	}
		
	function productionKarol(){
	
	$mainTable="PRODTNK1";
	$mainTable2="PRODTNK2";
	$voucher_Jo="PK";	
	$stock="STOCK";			
	$this->load->model("productionKarolModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("lotno","Lot No.","required");
	$this->form_validation->set_rules("rmaterial","Raw Material","required");
	$this->form_validation->set_rules("department","Department","required");
	$this->form_validation->set_rules("twght","Total Weight","less_than_equal_to[inhand]|greater_than[0]");
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
		$response=$this->productionKarolModel->insert($data);
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
	$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$lotno=$this->dataModel->query("SELECT LOTNO,SUM(T1.INWGHT-T1.OUTWGHT) AS BAL,SUM(T1.INWGHT) AS TOT,SUM(T1.OUTWGHT) AS USED
	FROM $stock AS T1 INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE
	WHERE T1.B_ID='3' AND T1.JO IN('ST','PK') AND T2.MGID=2 AND LOTNO IS NOT NULL
	GROUP BY LOTNO
	HAVING SUM(T1.INWGHT-T1.OUTWGHT) > 0");
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['department']=$department;
	$this->punchData['lotno']=$lotno;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Production Voucher (Karol)";
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
	$rawMaterial=$this->dataModel->query("SELECT T1.LOTNO,T1.PCODE,T2.PNAME,SUM(T1.INWGHT-T1.OUTWGHT) AS BAL,SUM(T1.INWGHT) AS TOT,SUM(T1.OUTWGHT) AS USED
	FROM STOCK AS T1 INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE
	WHERE T1.B_ID='3' AND T1.JO IN('ST','PK') AND T2.MGID=2 AND T1.LOTNO='".$data[0]['LOTNO']."' AND NO<>'".$data[0]['NO']."'
	GROUP BY T1.LOTNO,T1.PCODE,T2.PNAME
	HAVING SUM(T1.INWGHT-T1.OUTWGHT) > 0
	");
	$this->punchData['rawMaterial']=$rawMaterial;
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
		
	function production(){
	
	$mainTable="PRODTN1";
	$mainTable2="PRODTN2";
	$voucher_Jo="PD";	
	$stock="STOCK";			
	$this->load->model("productionModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	$this->punchData['loadProRow']="$segment1/voucher/$segment2/prorow";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("department","Department","required");
	//$this->form_validation->set_rules("contractor","Contractor","required");
	$this->form_validation->set_rules("prototwght","Total Weight","greater_than[0]|required");
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
		$response=$this->productionModel->insert($data);
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
	$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
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
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$contractor=$this->dataModel->getData("ACCOUNT",array("ATYPE"=>'11'),"ACODE,ANAME","ACODE ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['contractor']=$contractor;
	$this->punchData['department']=$department;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Production Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID'],"TYPE"=>'0'),"","");
	$this->punchData['data2']=$data2;		
	$data3=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID'],"TYPE"=>'1'),"","");
	$this->punchData['data3']=$data3;	
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
	
	public function KarolRaw(){
	if($this->input->is_ajax_request()){
	$lotno=$this->input->post("lotno");
	$result=$this->dataModel->query("SELECT T1.LOTNO,T1.PCODE,T2.PNAME,SUM(T1.INWGHT-T1.OUTWGHT) AS BAL,SUM(T1.INWGHT) AS TOT,SUM(T1.OUTWGHT) AS USED
	FROM STOCK AS T1 INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE
	WHERE T1.B_ID='3' AND T1.JO IN('ST','PK') AND T2.MGID=2 AND T1.LOTNO='$lotno'
	GROUP BY T1.LOTNO,T1.PCODE,T2.PNAME
	HAVING SUM(T1.INWGHT-T1.OUTWGHT) > 0
	");	
	echo json_encode($result);
	}
		
	}
	
	
	
}
