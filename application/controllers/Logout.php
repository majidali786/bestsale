<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

Class logout extends CI_Controller{


public function index(){
$this->session->unset_userdata(array("project","user"));
redirect(base_url());
}	
}
?>