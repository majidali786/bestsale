<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("EditModel");
	}
	// public function index(){
		// $this->punchData['view']="dashboard";
		// $this->punchData['heading']="Dashboard";
		// $this->load->model("Homemodel");
		// $this->load->view('main',$this->punchData);
	// }
	
	function accountGroup(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PGROUP","","PGNAME AS NAME,PGRP AS ID","PGNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Account Group","required|is_unique[PGROUP.PGNAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertAccountGroup($data)){
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
		$data=$this->EditModel->getData("PGROUP",array("PGRP"=>$this->input->post("id")),"","");
		$this->punchdata['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchdata,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("PGROUP",array("PGRP"=>$this->input->post("id")),"","");	
		if($match[0]['PGNAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[PGROUP.PGNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Account Group","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateAccountGroup($data)){
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
		$data=$this->EditModel->deleteData("PGROUP",array("PGRP"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['heading']="Account Group";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		function bank(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("BANK","","BNAME AS NAME,BCODE AS ID","BNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Bank Name","required|is_unique[BANK.BNAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertBank($data)){
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
		$data=$this->EditModel->getData("BANK",array("BCODE"=>$this->input->post("id")),"","");
		$this->punchdata['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchdata,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("BANK",array("BCODE"=>$this->input->post("id")),"","");	
		if($match[0]['BNAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[BANK.BNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Bank Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateBank($data)){
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
		$data=$this->EditModel->deleteData("BANK",array("BCODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['heading']="Bank";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		function province(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PROVINCE","","PRNAME AS NAME,PRCODE AS ID","PRNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Province Name","required|is_unique[PROVINCE.PRNAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertProvince($data)){
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
		$data=$this->EditModel->getData("PROVINCE",array("PRCODE"=>$this->input->post("id")),"","");
		$this->punchdata['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchdata,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("PROVINCE",array("PRCODE"=>$this->input->post("id")),"","");	
		if($match[0]['PRNAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[PROVINCE.PRNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Province Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateProvince($data)){
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
		$data=$this->EditModel->deleteData("PROVINCE",array("PRCODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['heading']="Province";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function department(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("DEPT","","DPName AS NAME,DPCode AS ID","DPName ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Department Name","required|is_unique[DEPT.DPName]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertDepartment($data)){
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
		$data=$this->EditModel->getData("DEPT",array("DPCode"=>$this->input->post("id")),"","");
		$this->punchdata['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchdata,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("DEPT",array("DPCode"=>$this->input->post("id")),"","");	
		if($match[0]['DPName']!=$this->input->post("name"))
		{
		$unique="|is_unique[DEPT.DPName]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Department Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateDepartment($data)){
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
		$data=$this->EditModel->deleteData("DEPT",array("DPCode"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['heading']="Department";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}	
		
		function branch(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("BRANCH","","BNAME AS NAME,BCODE AS ID","BNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Branch Name","required|is_unique[BRANCH.BNAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertBranch($data)){
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
		$data=$this->EditModel->getData("BRANCH",array("BCODE"=>$this->input->post("id")),"","");
		$this->punchdata['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchdata,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("BRANCH",array("BCODE"=>$this->input->post("id")),"","");	
		if($match[0]['BNAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[BRANCH.BNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Branch Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateBranch($data)){
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
		$data=$this->EditModel->deleteData("BRANCH",array("BCODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['heading']="Branch";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
	
		function salesman(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("SPERSON","","BNAME AS NAME,BCODE AS ID","BNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Salesman Name","required|is_unique[SPERSON.BNAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertSalesman($data)){
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
		$data=$this->EditModel->getData("SPERSON",array("BCODE"=>$this->input->post("id")),"","");
		$this->punchdata['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchdata,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("SPERSON",array("BCODE"=>$this->input->post("id")),"","");	
		if($match[0]['BNAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[SPERSON.BNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Salesman Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateSalesman($data)){
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
		$data=$this->EditModel->deleteData("SPERSON",array("BCODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['heading']="Salesman";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
	
		function city(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("CITY","","CNAME AS NAME,CCODE AS ID,PRNAME","CNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","City Name","required|is_unique[CITY.CNAME]");
		$this->form_validation->set_rules("province","Province","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertCity($data)){
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
		$data=$this->EditModel->getData("CITY",array("CCODE"=>$this->input->post("id")),"","");
		$province=$this->EditModel->getData("PROVINCE","","","PRNAME ASC");
		$this->punchdata['province']=$province;
		$this->punchdata['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchdata,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("CITY",array("CCODE"=>$this->input->post("id")),"","");	
		if($match[0]['CNAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[CITY.CNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","City Name","required".$unique."");
		$this->form_validation->set_rules("province","Province","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateCity($data)){
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
		$data=$this->EditModel->deleteData("CITY",array("CCODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['heading']="City";
		$province=$this->EditModel->getData("PROVINCE","","","PRNAME ASC");
		$this->punchData['province']=$province;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
	
	
	
}
