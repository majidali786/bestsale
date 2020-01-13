<?php
defined("BASEPATH") OR exit("No direct script access allowed");

Class Login extends CI_Controller{

function __construct(){
parent::__construct();
$this->load->model("loginModel");		
}
function index(){	
if($this->session->has_userdata("project"))
{	
redirect("home");	
}
else{
$branches=$this->loginModel->branches();	
$this->load->view("login",['branches'=>$branches]);	
}	
}
public function userlogin(){
	$this->form_validation->set_rules("username","Username","required");
	$this->form_validation->set_rules("pword","Password","required");
	$this->form_validation->set_rules("branch","Location","required");
	if($this->form_validation->run()==TRUE)
	{
	$data=$this->input->post();
	$validate=$this->loginModel->validateuser($data);
	if($validate=="true")
	{	
	$this->navigation();
	echo json_encode(array("success"=>"true","url"=>base_url("home")));	
	}
	else if($validate=='unauthorized'){
	echo json_encode(array("error"=>"Not Authorized to login from this branch","success"=>"wrong"));
	}
	else{
	echo json_encode(array("error"=>"Username & Password is In correct","success"=>"wrong"));
	}
	}
	else{
	echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
	}
    }
public function navigation(){
	$this->load->model("navbar");
	$navbar=$this->navbar->mynavigation();	
	$this->session->set_userdata(array("NAVBAR"=>$navbar));
	}	
}
?>