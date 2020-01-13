<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Memo extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("MemoModel");
	$this->punchData['libraries']=array("datatable","formJs");
	}
	
	function services(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("SERVICES","","ID,SERVICES AS NAME","SERVICES ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Services","required|is_unique[SERVICES.SERVICES]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->MemoModel->insertServices($data)){
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
		$data=$this->dataModel->getData("SERVICES",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("SERVICES",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SERVICES']!=$this->input->post("name"))
		{
		$unique="|is_unique[SERVICES.SERVICES]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Services","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->MemoModel->updateServices($data)){
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
		$data=$this->dataModel->deleteData("SERVICES",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Memo Services";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
		
	function memoVoucher(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs","datatable");	
	$mainTable="MEMO1";
	$mainTable2="MEMO2";
	$voucher_Jo="MO";
	$gnrllgr="Gnrllgr";	
	$stock="STOCK_SS";	
	$this->load->model("memoVoucherModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("daname","Debit Account","required");
	$this->form_validation->set_rules("caname","Credit Account","required");
	$this->form_validation->set_rules("type","Type","required");
	$this->form_validation->set_rules("tamount","Total Amount","required|greater_than[0]");
	if($this->input->post("type")==2){
	$this->form_validation->set_rules("department","Department","required");	
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
		$response=$this->memoVoucherModel->insert($data);
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
	$data=$this->dataModel->deleteData("$stock",array("JO"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));
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
	$account=$this->dataModel->getData("ACCOUNT",array("LEVL"=>4),"ACODE,ANAME","ANAME ASC");
	$services=$this->dataModel->getData("SERVICES","","ID,SERVICES","SERVICES ASC");
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUEMEMO1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	if(!empty($Bissue1)){
	$maxFBissue=$this->dataModel->getMax("BISSUEMEMO2","NO",array("B_ID"=>$this->userData['B_ID'],"BNO"=>$Bissue1[0]['NO']));
	if($maxFBissue<=$Bissue1[0]['ENDAT']){
	if($maxFBissue==1){
	$maxFBissue=$Bissue1[0]['STARTAT'];	
	}	
	$maxBissue=$Bissue1[0]['BNO']."-".$maxFBissue;	
	$this->punchData['maxBissue']=$maxBissue;
	}
	else{
	$this->punchData['bissueError']="Old Book is full issue New Book";	
	}
	}
	else{
	$this->punchData['bissueError']="No Book Found ! Issue Book";
	}
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$this->punchData['account']=$account;
	$this->punchData['department']=$department;
	$this->punchData['services']=$services;
	$this->punchData['product']=$product;
	$this->punchData['unit']=$unit;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Memo(Cash/Credit) Voucher";
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
	
	
	
	function cashPayment(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs","datatable");	
	$mainTable="CASHPYMMEMO";
	$voucher_Jo="CM";
	$gnrllgr="Gnrllgr";			
	$this->load->model("cashPaymentMemoModel");
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
			if($this->cashPaymentMemoModel->insert($data)){
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
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Memo Cash&Bank Payment Voucher";
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
	
	public function memoVoucherType(){
	if($this->input->is_ajax_request()){
	$type=$this->input->post("type");
	if($type==2){
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");	
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$data['product']=$product;	
	$data['unit']=$unit;	
	}
	else if($type==1){
	$services=$this->dataModel->getData("SERVICES","","ID,SERVICES","SERVICES ASC");
	$data['services']=$services;	
	}
	$data['dataType']="ajax";
	$data1a=$this->load->view("memo/voucher/memovoucher/row".$type."",$data,true);
	$data1b=$this->load->view("memo/voucher/memovoucher/row".$type."lower",$data,true);
	$data1=$data1a.$data1b;
	$data2=$this->load->view("memo/voucher/memovoucher/rowedit".$type."",$data,true);
	
	echo json_encode(array("data1"=>$data1,"data2"=>$data2));
	}	
	}
	public function memoVoucherEditType(){
	if($this->input->is_ajax_request()){
	$type=$this->input->post("type");
	if($type==2){
	$product=$this->dataModel->getData("SSPRODUCT","","PCODE,PNAME","PNAME ASC");	
	$unit=$this->dataModel->getData("SSUNIT","","ID,SSUNIT","SSUNIT ASC");
	$data['product']=$product;	
	$data['unit']=$unit;	
	}
	else if($type==1){
	$services=$this->dataModel->getData("SERVICES","","ID,SERVICES","SERVICES ASC");
	$data['services']=$services;	
	}
	$data2=$this->load->view("memo/voucher/memovoucher/rowedit".$type."",$data,true);
	
	echo json_encode(array("data2"=>$data2));
	}	
	}
	
	function bookIssueNote(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs","datatable");	
	$mainTable="BISSUEMEMO1";
	$mainTable2="BISSUEMEMO2";	
	$voucher_Jo="BM";
	$this->load->model("bookIssueNoteMemoModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("bno","Book No.","required");
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
			if($this->bookIssueNoteMemoModel->insert($data)){
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
	$this->punchData['heading']="Book Issue Note Memo";
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
	
		
		
		
	
}
