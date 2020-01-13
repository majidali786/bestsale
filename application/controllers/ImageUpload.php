<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ImageUpload extends MY_Controller {
	
 	function __construct(){
	parent::__construct();
	$this->load->library('imageuploader');
	}
	public function upload(){
	
	$data['request']=$_REQUEST;
	$data['get']=$_GET;
	echo $this->imageuploader->Upload($data);
	}
	
}


?>