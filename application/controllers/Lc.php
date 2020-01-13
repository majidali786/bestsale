<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lc extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("LcModel");
	$this->punchData['libraries']=array("datatable","formJs");
	}
	
	function account(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("LCACCOUNT","","ID,LCACCOUNT AS NAME","LCACCOUNT ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","LC Account","required|is_unique[LCACCOUNT.LCACCOUNT]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->insertLcAccount($data)){
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
		$data=$this->dataModel->getData("LCACCOUNT",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("LCACCOUNT",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['LCACCOUNT']!=$this->input->post("name"))
		{
		$unique="|is_unique[LCACCOUNT.LCACCOUNT]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","LC Account","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->updateLcAccount($data)){
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
		$data=$this->dataModel->deleteData("LCACCOUNT",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="LC Account";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function indentor(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("INDENTOR","","ID,INDENTOR AS NAME","INDENTOR ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Indentor","required|is_unique[INDENTOR.INDENTOR]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->insertIndentor($data)){
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
		$data=$this->dataModel->getData("INDENTOR",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("INDENTOR",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['INDENTOR']!=$this->input->post("name"))
		{
		$unique="|is_unique[INDENTOR.INDENTOR]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Indentor","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->updateIndentor($data)){
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
		$data=$this->dataModel->deleteData("INDENTOR",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Indentor";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function lcLocation(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("LCLOCATION","","ID,LCLOCATION AS NAME","LCLOCATION ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Lc Location","required|is_unique[LCLOCATION.LCLOCATION]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->insertLcLocation($data)){
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
		$data=$this->dataModel->getData("LCLOCATION",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("LCLOCATION",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['LCLOCATION']!=$this->input->post("name"))
		{
		$unique="|is_unique[LCLOCATION.LCLOCATION]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Lc Location","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->updateLcLocation($data)){
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
		$data=$this->dataModel->deleteData("LCLOCATION",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Lc Location";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function lcBond(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->dataModel->getData("LCBOND","","ID,LCBOND AS NAME","LCBOND ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Lc Bond","required|is_unique[LCBOND.LCBOND]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->insertLcBond($data)){
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
		$data=$this->dataModel->getData("LCBOND",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->dataModel->getData("LCBOND",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['LCBOND']!=$this->input->post("name"))
		{
		$unique="|is_unique[LCBOND.LCBOND]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Lc Bond","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->LcModel->updateLcBond($data)){
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
		$data=$this->dataModel->deleteData("LCBOND",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Lc Bond";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
					
	function lcInfo(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");	
	$mainTable="LC1";
	$mainTable2="LC2";	
	$voucher_Jo="LC";
	$this->load->model("lcInfoModel");
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
	$this->form_validation->set_rules("lccode","LC Account","required");
	$this->form_validation->set_rules("lcno","LC No.","required");
	$this->form_validation->set_rules("lcode","LC Code","required");
	$this->form_validation->set_rules("lcdate","LC Date","required");
	$this->form_validation->set_rules("lctype","LC Type","required");
	$this->form_validation->set_rules("indentor","Indentor","required");
	$this->form_validation->set_rules("destination","Destination","required");
	$this->form_validation->set_rules("origin","Origin","required");
	$this->form_validation->set_rules("currency","Currency","required");
	$this->form_validation->set_rules("conversion","Conversion","required");
	$this->form_validation->set_rules("bank","Bank","required");
	$this->form_validation->set_rules("tqty","Total Qty","required");
	$this->form_validation->set_rules("tweight","Total Weight","required");
	$this->form_validation->set_rules("fctamount","Total F.C Amount(MT)","required");
	$this->form_validation->set_rules("tamount","Total PKR Amount(MT)","required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->lcInfoModel->insert($data);
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
	$party=$this->dataModel->getParties(5);
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$lcbond=$this->dataModel->getData("LCBOND","","ID,LCBOND","LCBOND ASC");
	$indentor=$this->dataModel->getData("INDENTOR","","ID,INDENTOR","INDENTOR ASC");
	$bank=$this->dataModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['unit']=$unit;
	$this->punchData['indentor']=$indentor;
	$this->punchData['lcbond']=$lcbond;
	$this->punchData['bank']=$bank;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Lc Information Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['lcdate']=date("d/m/Y",strtotime($data[0]['LCDATE']));
	$this->punchData['etd']=date("d/m/Y",strtotime($data[0]['ETD']));
	$this->punchData['eta']=date("d/m/Y",strtotime($data[0]['ETA']));
	$this->punchData['mdate']=date("d/m/Y",strtotime($data[0]['MDATE']));
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

	function lcExpense(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");	
	$mainTable="LCEXPENSE";
	$voucher_Jo="LE";
	$gnrllgr="Gnrllgr";			
	$this->load->model("lcExpenseModel");
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
			if($this->lcExpenseModel->insert($data)){
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
	$lclocation=$this->dataModel->getData("LCLOCATION","","ID,LCLOCATION","LCLOCATION ASC");
	$lcno=$this->dataModel->query("SELECT LCNO FROM LC1 GROUP BY LCNO ORDER BY LCNO ASC");
	$lcaccount=$this->dataModel->getData("LCACCOUNT","","ID,LCACCOUNT","LCACCOUNT ASC");	
	$account=$this->dataModel->getAccounts();
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['lcno']=$lcno;
	$this->punchData['lclocation']=$lclocation;
	$this->punchData['lcaccount']=$lcaccount;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="LC Expense Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['tdate']=date("d/m/Y",strtotime($data[0]['TDATE']));
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
				
	function lcPurchase(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");	
	$mainTable="LCPURCH1";
	$mainTable2="LCPURCH2";	
	$voucher_Jo="PL";
	$this->load->model("lcPurchaseModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete" && $type!="loadlc"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("vname","Party","required");
	$this->form_validation->set_rules("paccount","Purchase Account","required");
	$this->form_validation->set_rules("lccode","LC Account","required");
	$this->form_validation->set_rules("lcno","LC No.","required");
	$this->form_validation->set_rules("lcbond","LC Bond","required");
	$this->form_validation->set_rules("tqty","Total Qty","required");
	$this->form_validation->set_rules("tweight","Total Weight","required");
	$this->form_validation->set_rules("net","Total Amount","required");
	$this->form_validation->set_rules("toverhead","Total Over Heads","required");
	$this->form_validation->set_rules("tamount","Total PKR Amount(MT)","required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$data['action']="save";
		if($this->uri->segment(3) && is_numeric($type))
		{
		$data['no']=$this->uri->segment(3);	
		$data['action']=$this->uri->segment(4);	
		}	
		$data['rights']=$this->punchData['voucherrights'][0];
		$response=$this->lcPurchaseModel->insert($data);
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
	else if($this->uri->segment(3) && $type=="loadlc"){
	$lcno=$this->input->post("lcno");	
	$data1=$this->dataModel->getData("LC1",array("LCNO"=>$lcno),"","");
	$data2=$this->dataModel->getData("LC2",array("LCNO"=>$lcno),"","");
	$lcbond=$this->dataModel->getData("LCBOND","","ID,LCBOND","LCBOND ASC");
	if(!empty($data1)){		
	$expense=$this->dataModel->query("SELECT SUM(T1.DEBIT) AS EXPE,SUM(T2.WEIGHT) AS TWT FROM LC2 AS T2 INNER JOIN  LCEXPENSE AS T1 ON T2.LCCODE=T1.ACODE AND T1.B_ID=T2.B_ID WHERE T2.LCCODE='".$data1[0]['LCCODE']."'");	
	}	
	echo $this->load->view("$segment1/voucher/$segment2/loadlc",["data1"=>$data1,"data2"=>$data2,"lcbond"=>$lcbond,"expense"=>$expense],true);
	}
	else{
	$account=$this->dataModel->getAccounts();
	$lcno=$this->dataModel->query("SELECT LCNO FROM LC1 WHERE LCNO NOT IN (SELECT LCNO FROM LCPURCH1) ORDER BY LCNO ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	
	$this->punchData['account']=$account;
	$this->punchData['lcno']=$lcno;

	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="Lc Purchase Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	if($this->uri->segment(3) && is_numeric($type)){
	$data=$this->dataModel->getData("$mainTable",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($data)){
	$this->punchData['max']=$data[0]['NO'];
	$this->punchData['vdate']=date("d/m/Y",strtotime($data[0]['VDATE']));
	$this->punchData['grndate']=date("d/m/Y",strtotime($data[0]['GRNDATE']));
	$this->punchData['data']=$data;	
	$data2=$this->dataModel->getData("$mainTable2",array("NO"=>$this->uri->segment(3),"B_ID"=>$this->userData['B_ID']),"","");
	$this->punchData['data2']=$data2;
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/edit";
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data[0]['NO'],"JO"=>$voucher_Jo,"B_ID"=>$this->userData['B_ID'],"TYPE"=>3),"","VDATE DESC");
	$lcbond=$this->dataModel->getData("LCBOND","","ID,LCBOND","LCBOND ASC");
	$this->punchData['lcbond']=$lcbond;
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
	
	function lcSale(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");		
	$mainTable="LCSALE1";
	$mainTable2="LCSALE2";
	$voucher_Jo="LS";
	$gnrllgr="Gnrllgr";		
	$stock="STOCK_LC";		
	$this->load->model("lcSaleModel");
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
	$this->form_validation->set_rules("sacode","Sales Account","required");
	$this->form_validation->set_rules("lcno","LC No.","required");
	$this->form_validation->set_rules("department","Department","required");
	$this->form_validation->set_rules("tqty","Total Qty","greater_than[0]|required");
	$this->form_validation->set_rules("lcbond","LC Bond","required");
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
		$response=$this->lcSaleModel->insert($data);
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
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$lcno=$this->dataModel->query("SELECT LCNO FROM LC1 ORDER BY LCNO ASC");
	$this->punchData['lcno']=$lcno;
	$this->punchData['account']=$account;
	$this->punchData['party']=$party;
	$this->punchData['unit']=$unit;
	$this->punchData['department']=$department;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="LC Sale Voucher";
	$this->punchData['view']="$segment1/voucher/$segment2/main";
	$this->punchData['loadVoucher']="$segment1/voucher/$segment2/voucher";
	$lcbond=$this->dataModel->getData("LCBOND","","ID,LCBOND","LCBOND ASC");
	$this->punchData['lcbond']=$lcbond;
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
	
	function journal(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");	
	$mainTable="LCJOURNAL";
	$voucher_Jo="LJ";
	$gnrllgr="Gnrllgr";	
	$this->load->model("LcJournalModel");
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
			if($this->LcJournalModel->insert($data)){
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
	$lcno=$this->dataModel->query("SELECT LCNO FROM LC1 GROUP BY LCNO ORDER BY LCNO ASC");
	$party=$this->dataModel->getParties(4);
	$supplier=$this->dataModel->getParties(5);
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$this->punchData['account']=$account;
	$this->punchData['lcno']=$lcno;
	$this->punchData['party']=$party;
	$this->punchData['supplier']=$supplier;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="LC Journal Voucher";
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
	
	function stockTransfer(){
	$this->punchData['libraries']=array("voucherJs","inputMask","slimscroll","numberJs");
	$mainTable="LCSTRNF1";
	$mainTable2="LCSTRNF2";
	$voucher_Jo="LT";	
	$stock="STOCK_LC";		
	$stock2="STOCK";		
	$this->load->model("LCstockTransferModel");
	$type=$this->uri->segment(3);
	$type2=$this->uri->segment(4);
	$segment1=$this->router->class;
	$segment2=$this->router->method;
	$this->punchData['loadControls']="$segment1/voucher/$segment2/controls";
	$this->punchData['loadRow']="$segment1/voucher/$segment2/row";
	if($this->input->post() && $type2!="delete"){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("vdate","Voucher Date","required");
	$this->form_validation->set_rules("flcbond","From LC Bond","required");
	$this->form_validation->set_rules("tbranch","To Branch","required");
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
		$response=$this->LCstockTransferModel->insert($data);
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
	$this->dataModel->deleteData("$stock2",array("JO"=>"$voucher_Jo","TNO"=>$no,"TB_ID"=>$this->userData['B_ID']));	
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
	$branches=$this->dataModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
	$unit=$this->dataModel->getData("UNIT","","ID,UNIT","UNIT ASC");
	$department=$this->dataModel->getData("DEPT","","DPCode as ID,DPName AS DEPT","DPName ASC");
	$product=$this->dataModel->getData("PRODUCT","","PCODE,PNAME","PNAME ASC");
	$max=$this->dataModel->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1),"","");
	$this->punchData['branches']=$branches;
	$lcno=$this->dataModel->query("SELECT LCNO FROM LC1 ORDER BY LCNO ASC");
	$lcbond=$this->dataModel->getData("LCBOND","","ID,LCBOND","LCBOND ASC");
	$this->punchData['lcbond']=$lcbond;
	$this->punchData['lcno']=$lcno;
	$this->punchData['unit']=$unit;
	$this->punchData['product']=$product;
	$this->punchData['max']=$max;
	$this->punchData['vdate']=date("d/m/Y");
	$this->punchData['navbar']=$this->session->userdata("NAVBAR");
	$this->punchData['heading']="LC Stock Transfer Voucher";
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
	
}
