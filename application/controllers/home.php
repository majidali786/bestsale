<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function index(){
		$this->load->model("Homemodel");
		$this->punchData['libraries']=array("datePicker","inputMask","slimscroll","numberJs","promiseJs");
		if($this->session->flashdata('aunthorized')){
		$this->punchData['aunthorized']=$this->session->flashdata('aunthorized');	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$rt=$this->dataModel->getData("OTHERRIGHTS",array("USR"=>$this->userData['U_ID']),"","");
		$rights=array();
		if(!empty($rt)){
		$rights=$rt[0];	
		}
		if($this->userData['U_TYPE']==0){
		$rights=["PROMISES"=>1,"DASHBOARD"=>1,"PENDINGDC"=>1];	
		}
		$this->punchData['graph']=$this->Homemodel->get_graph();
		$this->punchData['pie_chart']=$this->Homemodel->get_pie_chart();
		$this->punchData['pie_chart2']=$this->Homemodel->get_pie_chart2();
		$this->punchData['credit']=$this->Homemodel->get_prev();
		$this->punchData['rights']=$rights;
		$this->punchData['view']="dashboard";
		$this->punchData['heading']="Dashboard";
		$this->load->view('main',$this->punchData);
		
		
	}
	
}
