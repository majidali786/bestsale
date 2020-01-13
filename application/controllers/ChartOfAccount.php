<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChartOfAccount extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("ChartOfAccountModel");
	$this->punchData['libraries']=array("datatable","formJs","chartOfAccountJs","datePicker");
	}
	
	function index(){
		$segment=$this->uri->segment(3);
		$segment1="edit";
		$segment2="chartofaccount";		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->ChartOfAccountModel->getData("ACCOUNT",array("LEVL"=>4),"ANAME AS NAME,ACODE AS ID","ANAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("aname","4th Level Name","required|is_unique[ACCOUNT.ANAME]");
		$this->form_validation->set_rules("acode","4th Level Code","required");
		$this->form_validation->set_rules("level_1","1st Level","required");
		$this->form_validation->set_rules("level_2","2nd Level","required");
		$this->form_validation->set_rules("level_3","3rd Level","required");
		$this->form_validation->set_rules("atype","Account Type","required");
		$this->form_validation->set_rules("agroup","Account Group","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->ChartOfAccountModel->insertAccount($data)){
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
		$data=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$this->input->post("id")),"","");
		$atype=$this->ChartOfAccountModel->getData("ACCOUNT_TYPE","","","ATPNAME ASC");
		$level1=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$data[0]['L1CODE']),"","");
		$level2=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$data[0]['L2CODE']),"","");
		$level3=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$data[0]['L3CODE']),"","");
		$this->punchData['atype']=$atype;
		$this->punchData['level1']=$level1;
		$this->punchData['level2']=$level2;
		$this->punchData['level3']=$level3;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$this->input->post("id")),"","");	
		if($match[0]['ANAME']!=$this->input->post("aname"))
		{
		$unique="|is_unique[ACCOUNT.ANAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("aname","Account Name","required".$unique."");
		$this->form_validation->set_rules("atype","Account Type","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->ChartOfAccountModel->updateAccount($data)){
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
		$data=$this->ChartOfAccountModel->deleteData("ACCOUNT",array("ACODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Chart Of Account";
		$atype=$this->ChartOfAccountModel->getData("ACCOUNT_TYPE","","","ATPNAME ASC");
		$this->punchData['atype']=$atype;
		$level1=$this->ChartOfAccountModel->getData("ACCOUNT",array("LEVL"=>1),"ACODE,ANAME","ANAME ASC");
		$this->punchData['level1']=$level1;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
	}
	function getAccountLevel(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$level=$this->uri->segment(2);
		$levelName=array("","1st","2nd","3rd");
		$this->punchData['level']=$level;
		$this->punchData['levelName']=$levelName[$level];
		echo $this->load->view("edit/chartofaccount/add",$this->punchData,TRUE);
		}	
	}
	function addAccountLevel(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$level=$this->uri->segment(2);
		$levelName=array("","1st","2nd","3rd");
		$this->form_validation->set_rules("name","".$levelName[$level]." Level Name","required");
		if($level==2 || $level==3){
		$this->form_validation->set_rules("level_1","1st Level","required");	
		}
		if($level==3){
		$this->form_validation->set_rules("level_2","2nd Level","required");	
		}
		if($this->form_validation->run()){
				$data = $this->input->post();
				$data['level']=$level;
				if($this->ChartOfAccountModel->insertAccountLevel($data)){
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
	}
	function loadAccountLevel(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$level=$this->uri->segment(2);
		$levelName=array("","1st","2nd","3rd");
		if($level==1){
		$this->punchData['loadLevel']=2;	
		$this->form_validation->set_rules("level_1","1st Level","");
		}
		if($level==2 || $level==3){
		$this->punchData['loadLevel']=3;	
		$this->form_validation->set_rules("level_1","1st Level","required");	
		}
		if($level==3){
		$this->punchData['loadLevel']="code&name";	
		$this->form_validation->set_rules("level_2","2nd Level","required");	
		}
		$data=$this->input->get();	
		if($level==1){
		$where=array("LEVL"=>1);	
		}
		else if($level==2){
		$where=array("LEVL"=>2,"L1CODE"=>$data['level_1']);	
		}
		else if($level==3){
		$where=array("LEVL"=>3,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2']);	
		}
		$data=$this->ChartOfAccountModel->getData("ACCOUNT",$where,"ACODE,ANAME","ANAME ASC");
		$this->punchData['level']=$level;
		$this->punchData['data']=$data;
		$this->punchData['levelName']=$levelName[$level];
		echo $this->load->view("edit/chartofaccount/load",$this->punchData,TRUE);
		
		}	
	}
	function getAccountLevelEdit(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$level=$this->uri->segment(2);
		$levelName=array("","1st","2nd","3rd");
		$data=$this->input->get();	
		if($level==1){
		$where=array("LEVL"=>1,"ACODE"=>$data['level_1']);	
		}
		else if($level==2){
		$where=array("LEVL"=>2,"L1CODE"=>$data['level_1'],"ACODE"=>$data['level_2']);	
		}
		else if($level==3){
		$where=array("LEVL"=>3,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2'],"ACODE"=>$data['level_3']);	
		}
		$data=$this->ChartOfAccountModel->getData("ACCOUNT",$where,"ACODE,ANAME","ANAME ASC");
		$this->punchData['level']=$level;
		$this->punchData['data']=$data;
		$this->punchData['levelName']=$levelName[$level];
		echo $this->load->view("edit/chartofaccount/editLevel",$this->punchData,TRUE);
		
		}	
	}
	function editAccountLevel(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$level=$this->uri->segment(2);
		$levelName=array("","1st","2nd","3rd");
		$this->form_validation->set_rules("name","".$levelName[$level]." Level Name","required");
		$this->form_validation->set_rules("id","".$levelName[$level]." Level Code","required");
		if($level==2 || $level==3){
		$this->form_validation->set_rules("level_1","1st Level","required");	
		}
		if($level==3){
		$this->form_validation->set_rules("level_2","2nd Level","required");	
		}
		if($this->form_validation->run()){
				$data = $this->input->post();
				$data['level']=$level;
				if($this->ChartOfAccountModel->updateAccountLevel($data)){
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
	}
	function deleteAccountLevel(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$level=$this->uri->segment(2);
		$levelName=array("","1st","2nd","3rd");
		$data = $this->input->post();
		if($level==1){	
		$delWhere=array("L1CODE"=>$data['level_1'],"LEVL!="=>1);
		$where=array("LEVL"=>1,"ACODE"=>$data['level_1']);
		}
		if($level==2){	
		$delWhere=array("LEVL!="=>2,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2']);
		$where=array("LEVL"=>2,"L1CODE"=>$data['level_1'],"ACODE"=>$data['level_2']);
		}
		if($level==3){
		$delWhere=array("LEVL!="=>3,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2'],"L3CODE"=>$data['level_3']);			
		$where=array("LEVL"=>3,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2'],"ACODE"=>$data['level_3']);			
		}
		$data=$this->ChartOfAccountModel->getData("ACCOUNT",$delWhere,"ACODE,ANAME","ANAME ASC");
		if(empty($data)){
		$data=$this->ChartOfAccountModel->deleteData("ACCOUNT",$where);	
		echo json_encode(array("success"=>"true"));
		}
		else{
		echo json_encode(array("error"=>"Data Exist"));	
		}
		}	
	}
	
	function getAccountCode(){
	if($this->input->is_ajax_request()){
	$data = $this->input->get();	
	$maxWhere=array("LEVL"=>4,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2'],"L3CODE"=>$data['level_3']);	
	$max = $this->ChartOfAccountModel->getMax("ACCOUNT","ACODE",$maxWhere);
	if($max==1){
	$max=$data['level_3'].'001';
	}
	echo json_encode($max);
	}
	}
	
	public function getAcountsAtype(){
	if($this->input->is_ajax_request()){
	$atype=$this->input->get("atype");
	$data=$this->ChartOfAccountModel->getData("ACCOUNT",array("ATYPE"=>$atype,"LEVL"=>4),"ACODE,ANAME,ATPNAME","ANAME");
	$atpname=$this->ChartOfAccountModel->getData("ACCOUNT_TYPE",array("ATYPE"=>$atype),"","ATPNAME ASC");
	$this->punchData['atype']=$atype;
	$this->punchData['name']=ucfirst(strtolower($atpname[0]['ATPNAME']));
	$this->punchData['data']=$data;
	echo $this->load->view("edit/chartofaccount/accounts",$this->punchData,TRUE);
	}		
	}
	
	public function getAcountsDetail(){
	if($this->input->is_ajax_request()){
	$data=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$this->input->get("acode")),"","");
	$atype=$this->ChartOfAccountModel->getData("ACCOUNT_TYPE","","","ATPNAME ASC");
	$level1=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$data[0]['L1CODE']),"","");
	$level2=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$data[0]['L2CODE']),"","");
	$level3=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$data[0]['L3CODE']),"","");
	$this->punchData['atype']=$atype;
	$this->punchData['level1']=$level1;
	$this->punchData['level2']=$level2;
	$this->punchData['level3']=$level3;
	$this->punchData['data']=$data;
	echo $this->load->view("edit/chartofaccount/detail",$this->punchData,TRUE);
	}		
	}
	
	function getParty(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$vcode=$this->input->get("id");
		$vname=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$vcode),"ANAME","");
		$party=$this->ChartOfAccountModel->getData("PARTY",array("VCODE"=>$vcode),"","");
		$city=$this->ChartOfAccountModel->getData("CITY","","CCODE,CNAME","CNAME ASC");
		$bank=$this->ChartOfAccountModel->getData("BANK","","BCODE,BNAME","BNAME ASC");
		$this->punchData['city']=$city;
		$this->punchData['bank']=$bank;
		$sperson=$this->ChartOfAccountModel->getData("SPERSON","","BCODE,BNAME","BNAME ASC");
		$branch=$this->ChartOfAccountModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
		$this->punchData['sperson']=$sperson;
		$this->punchData['party']=$party;
		$this->punchData['branch']=$branch;
		$this->punchData['vcode']=$vcode;
		$this->punchData['vname']=$vname;
		echo $this->load->view("edit/chartofaccount/party",$this->punchData,TRUE);
		}	
	}
	
	function getEmployee(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$id=$this->input->get("id");
		$name=$this->ChartOfAccountModel->getData("ACCOUNT",array("ACODE"=>$id),"ANAME","");
		$employee=$this->ChartOfAccountModel->getData("EMPLOYEE",array("ID"=>$id),"","");
		$department=$this->ChartOfAccountModel->getData("UDEPT","","ID,UDEPT","UDEPT ASC");
		$designation=$this->ChartOfAccountModel->getData("UDESIG","","ID,UDESIG","UDESIG ASC");
		$branch=$this->ChartOfAccountModel->getData("BRANCH","","BCODE,BNAME","BNAME ASC");
		$users=$this->ChartOfAccountModel->getData("login",array("TYPE<>"=>0),"USERNAME","USERNAME ASC");
		$city=$this->ChartOfAccountModel->getData("CITY","","CCODE,CNAME","CNAME ASC");
		$this->punchData['city']=$city;
		$this->punchData['department']=$department;
		$this->punchData['designation']=$designation;
		$this->punchData['employee']=$employee;
		$this->punchData['branch']=$branch;
		$this->punchData['users']=$users;
		$this->punchData['id']=$id;
		$this->punchData['name']=$name;
		echo $this->load->view("edit/chartofaccount/employee",$this->punchData,TRUE);
		}	
	}
	function saveParty(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$this->form_validation->set_rules("party_city","City","required");
		$this->form_validation->set_rules("party_sman","Salesman","required");
		$this->form_validation->set_rules("party_branch","Branch","required");
		$this->form_validation->set_rules("p_climit","Credit Limit","numeric");
		$this->form_validation->set_rules("p_mail","Email","valid_email");
		$this->form_validation->set_rules("p_mnum","Mobile","numeric");
		$this->form_validation->set_rules("p_mnum2","Mobile 2","numeric");
		$this->form_validation->set_rules("p_phone","Phone","numeric");
		$this->form_validation->set_rules("p_cdays","Credit Days","numeric");
		$this->form_validation->set_rules("party_type","Party Type","required");
		$this->form_validation->set_rules("party_status","Party Status","required");
		$this->form_validation->set_rules("p_ofphone","Phone","numeric");
		$this->form_validation->set_rules("p_ofmnum","Phone","numeric");
		$this->form_validation->set_rules("p_cmob","Mobile","numeric");
		$this->form_validation->set_rules("p_bacc","Account No.","numeric");
		$this->form_validation->set_rules("p_ofmail","Email","valid_email");

		if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->ChartOfAccountModel->saveParty($data)){
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
	}
	
	function saveEmployee(){
		if($this->uri->segment(2) && $this->input->is_ajax_request()){
		$this->form_validation->set_rules("e_city","City","required");
		$this->form_validation->set_rules("e_branch","Branch","required");
		$this->form_validation->set_rules("e_designation","Designation","required");
		$this->form_validation->set_rules("e_department","Department","required");
		$this->form_validation->set_rules("p_mail","Email","valid_email");
		$this->form_validation->set_rules("p_mnum","Mobile","numeric");
		$this->form_validation->set_rules("p_mnum2","Mobile 2","numeric");
		$this->form_validation->set_rules("e_emergency","Emergency","numeric");
		$this->form_validation->set_rules("cnic","Cnic","numeric|exact_length[13]");
		$this->form_validation->set_rules("e_status","Status","required");

		if($this->form_validation->run()){
				$data = $this->input->post();
					if(!empty($_FILES['img']['e_status']))
		{
		$foldername="category";
		$uniquename = md5(microtime(true));	
		$path=$this->ImgUploadUrl()."product/".$foldername;
		$this->load->library('upload');
		if(!file_exists($path))
		{
		mkdir($path);	
		}
		$imageFullname=$uniquename."-".$data['e_status'];
		$rawname=$this->uploadImg($path,$imageFullname,"img");
		$data['img']=$rawname;	
		}
		else{
		$data['img']="";	
		}
		
				if($this->ChartOfAccountModel->saveEmployee($data)){
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
	}
	
			public function resizeImage($rawname,$name,$path){
		$this->load->library('image_nation');
			$this->image_nation->parent_directory=$path;
			$this->image_nation->clear_source_directory();
			$this->image_nation->set_source_directory($path);
			$this->image_nation->clear_images();
			$this->image_nation->source($name);
			$this->image_nation->clear_sizes();
			$dimensions = array(
					'614x409' => array(
					'master_dim' => 'auto',
					'keep_aspect_ratio' => FALSE,
					'style' => array('vertical'=>'center','horizontal'=>'center'),
					'overwrite' => TRUE,
					'quality' => '80%',
					'file_name' => $rawname),
					'105x104' => array(
					'master_dim' => 'auto',
					'keep_aspect_ratio' => FALSE,
					'style' => array('vertical'=>'center','horizontal'=>'center'),
					'overwrite' => TRUE,
					'quality' => '100%',
					'file_name' => 'thumb_'.$rawname));
			$this->image_nation->add_size($dimensions);
			$images=$this->image_nation->process();	
			if(!$this->image_nation->get_errors()) {	
			return $processed_images = $this->image_nation->get_processed();
			}
			
	}
	public function uploadImg($path,$name,$input){	
	$config['upload_path']=$path;
	$config['allowed_types']='gif|jpg|png';
	$config['max_size']='2048';
	$config['file_name']=$name;
	$this->upload->initialize($config);
	$this->upload->do_upload($input);
	$raw_names=$this->upload->data("raw_name");
	$file_names=$this->upload->data("file_name");
	$full_path=$this->upload->data("full_path");
	$simg_thumb=$this->resizeImage($raw_names,$file_names,$path);	
	return $file_names;
	}	
}
