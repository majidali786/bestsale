<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	$this->load->model("EditModel");
	$this->punchData['libraries']=array("datatable","formJs");
	}
	
	function design(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("DESIGN","","NAME AS NAME,ID AS ID,IMG","NAME ASC");
		$data['list']=$list;
		
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Design","required|is_unique[DESIGN.NAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				
		if(!empty($_FILES['img']['name']))
		{
		$foldername="category";
		$uniquename = md5(microtime(true));	
		$path=$this->ImgUploadUrl()."product/".$foldername;
		$this->load->library('upload');
		if(!file_exists($path))
		{
		mkdir($path);	
		}
		$imageFullname=$uniquename."-".$data['name'];
		$rawname=$this->uploadImg($path,$imageFullname,"img");
		$data['img']=$rawname;	
		}
		else{
		$data['img']="";	
		}
				
				if($this->EditModel->insertDesign($data)){
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
		$data=$this->EditModel->getData("DESIGN",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("DESIGN",array("ID"=>$this->input->post("id")),"","");	
       $oldImage=$match[0]['IMG'];  
		if($match[0]['NAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[DESIGN.NAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Design","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				
				if(!empty($_FILES['img']['name']))
					{
						
					$foldername="category";
					$uniquename = md5(microtime(true));	
					$path=$this->ImgUploadUrl()."product/".$foldername;
					$this->load->library('upload');
 					if(!file_exists($path))
					{
					mkdir($path);	
					}
 					$imageFullname=$uniquename."-".$data['name'];
					$rawname=$this->uploadImg($path,$imageFullname,"img");
					$data['img']=$rawname;	
					}
					else{
					$data['img']=$oldImage;	
					}
				
				
				if($this->EditModel->updateDesign($data)){
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
		$data=$this->EditModel->deleteData("DESIGN",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Design Information";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function pricelist(){
$segment=$this->uri->segment(3);
$segment1=$this->router->class;
$segment2=$this->router->method;		
if($this->input->is_ajax_request())
{
if($segment=="list")
{
$list=$this->EditModel->getData("PRODUCT","","","PCODE ASC");
$data['list']=$list;
echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
}

if($segment=="list_by_product")
{
$list=$this->EditModel->getData("PRODUCT",array("PCODE"=>$this->input->post("pcode")),"","PCODE ASC");
$data['list']=$list;
echo $this->load->view("$segment1/$segment2/list.php",$data,TRUE);	
}

//list by group
if($segment=="list_by_grp")
{
if ($this->input->post("type") == 'all') 
{
$data=$this->EditModel->getData("PRODUCT",array("DID"=>$this->input->post("grp")),"","PCODE ASC");
}
else if ($this->input->post("type") != 'all') 
{
$data=$this->EditModel->getData("PRODUCT",array("DID"=>$this->input->post("grp")),"","PCODE ASC");
}
if (!empty($data)) 
{
$data['list']=$data;
echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);
} 
}

//list for product
if($segment=="load_products")
{
if ($this->input->post("type") == 'allproduct') 
{
$products=$this->EditModel->getData("PRODUCT",array("DID"=>$this->input->post("grp")),"","PCODE ASC");
}
else if ($this->input->post("type") != 'allproduct') 
{
$products=$this->EditModel->getData("PRODUCT",array("DID"=>$this->input->post("grp")),"","PCODE ASC");
}
if (!empty($products)) 
{
$data['products']=$products;
echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);
} 
}



if($segment=="save")
{
$data = $this->input->post();
if($this->EditModel->updatepricelist($data)){
echo json_encode(array("error"=>"","success"=>"true"));
}
else{
echo json_encode(array("error"=>"Something Went Wrong","success"=>"Something Went Wrong"));
}

}

}
else{
if ($this->uri->segment(3)!=FALSE)
{
redirect("$segment1/$segment2");	
}
$mgroup=$this->EditModel->getData("DESIGN","","","ID ASC");
$this->punchData['mgroup']=$mgroup;	
$sgroup=$this->EditModel->getData("COLOR","","","ID ASC");
$this->punchData['sgroup']=$sgroup;		
$product=$this->EditModel->getData("PRODUCT","","","PCODE ASC");
$this->punchData['product']=$product;						
$this->punchData['navbar']=$this->session->userdata("NAVBAR");
$this->punchData['heading']="Product Price List";
$this->punchData['view']="$segment1/$segment2/main";
$this->load->view("main",$this->punchData);		
}	
}

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
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
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
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Account Group";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		function account(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;
		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("ACCOUNT","","","ACODE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Account Name","required");
		$this->form_validation->set_rules("atype","Account Type","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertAccount($data)){
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
		$data=$this->EditModel->getData("ACCOUNT",array("ACODE"=>$this->input->post("id")),"","");
		$atype=$this->EditModel->getData("ATYPE","","","TCODE ASC");
		$this->punchData['atype']=$atype;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		

}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("ACCOUNT",array("ACODE"=>$this->input->post("id")),"","");	
		if($match[0]['ANAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[ACCOUNT.ANAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Account Name","required");
		$this->form_validation->set_rules("atype","Account Type","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateAccount($data)){
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
		$data=$this->EditModel->deleteData("ACCOUNT",array("ACODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Chart Of Account Profile";
		$atype=$this->EditModel->getData("ATYPE","","","TCODE ASC");
		$maxcode=$this->EditModel->getMax("ACCOUNT","ACODE","");

			if($maxcode==1)
			{
			$accode = '1101';
			}else{
			$accode = $maxcode;
			}
		$this->punchData['code']=$accode;
		$this->punchData['atype']=$atype;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
			
	function bank(){
		$segment=$this->uri->segment(3); //crud functionality (save,update,list(retrive).delete)
		$segment1=$this->router->class; //edit
		$segment2=$this->router->method;//function 		
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
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
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
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
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
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
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
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Province";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		//SALES MAN
		
		
			function saleman(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("SALESMAN",array("B_ID"=>$this->userData['B_ID']),"NAME AS NAME,ID AS ID","NAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Salesman Name","required|is_unique[SALESMAN.NAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertsaleman($data)){
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
		$data=$this->EditModel->getData("SALESMAN",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("SALESMAN",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['NAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[SALESMAN.NAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","salesman Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updatesaleman($data)){
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
		$data=$this->EditModel->deleteData("SALESMAN",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Sales Man";
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
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
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
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
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
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
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
		if($this->uri->segment(3)!=FALSE){
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
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
		$list=$this->EditModel->getData("SPERSON","","BNAME AS NAME,BCODE AS ID,USERNAME","BNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Salesman Name","required|is_unique[SPERSON.BNAME]");
		$this->form_validation->set_rules("user","Username","required|is_unique[SPERSON.USERNAME]");
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
		$userName=$this->EditModel->getData("login",array("TYPE"=>2),"USERNAME","USERNAME ASC");	
		$data=$this->EditModel->getData("SPERSON",array("BCODE"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		$this->punchData['userName']=$userName;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
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
		if($match[0]['USERNAME']!=$this->input->post("user"))
		{
		$uniquea="|is_unique[SPERSON.USERNAME]";	
		}
		else{
		$uniquea="";	
		}
		$this->form_validation->set_rules("name","Salesman Name","required".$unique."");
		$this->form_validation->set_rules("user","Username","required".$uniquea."");
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
		
		$userName=$this->EditModel->getData("login",array("TYPE"=>2),"USERNAME","USERNAME ASC");
		
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Salesman";
		$this->punchData['userName']=$userName;
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
		$this->punchData['province']=$province;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
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
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="City";
		$province=$this->EditModel->getData("PROVINCE","","","PRNAME ASC");
		$this->punchData['province']=$province;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function user(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("login","","","USERNAME ASC");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$type=$this->EditModel->getData("UTYPE","","","TYPE ASC");
		$data['list']=$list;
		$data['list_branch']=$branch;
		$data['list_type']=$type;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Username","required|is_unique[login.USERNAME]");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("type","Type","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("password","Password","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertUser($data)){
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
		$data=$this->EditModel->getData("login",array("USERNAME"=>$this->input->post("id")),"","");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$type=$this->EditModel->getData("UTYPE","","","TYPE ASC");
		$this->punchData['branch']=$branch;
		$this->punchData['type']=$type;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$this->form_validation->set_rules("id","Username","required");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("type","Type","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("password","Password","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateUser($data)){
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
		$data=$this->EditModel->deleteData("login",array("USERNAME"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="User";
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$type=$this->EditModel->getData("UTYPE","","","TYPE ASC");
		$this->punchData['branch']=$branch;
		$this->punchData['type']=$type;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		//customer
	    function party(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PARTY",array("ATYPE"=>'0'),"","VCODE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("city","City","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("mob","Mobile","required");
		$this->form_validation->set_rules("limit","Credit Limit","required");
	    if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertParty($data)){
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
		$data=$this->EditModel->getData("PARTY",array("VCODE"=>$this->input->post("id")),"","");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['branch']=$branch;
		$this->punchData['city']=$city;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("city","City","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("mob","Mobile","required");
		$this->form_validation->set_rules("limit","Credit Limit","required");
		if($this->form_validation->run()){
		$data = $this->input->post();
		if($this->EditModel->updateParty($data)){
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
	$chck1=$this->dataModel->getData("PURCH1",array("VCODE"=>$this->input->post("id")),"","");
	$chck2=$this->dataModel->getData("SALE1",array("VCODE"=>$this->input->post("id")),"","");
	$chck3=$this->dataModel->getData("Gnrllgr",array("ACode"=>$this->input->post("id")),"","");
	if(empty($chck1) && empty($chck2) && empty($chck3)){
		
	$data=$this->EditModel->deleteData("PARTY",array("VCODE"=>$this->input->post("id")));
	$data=$this->EditModel->deleteData("ACOUNT",array("ACODE"=>$this->input->post("id")));
	
	return true;	
		}	else {
	echo json_encode(array("error"=>"Entry Present Against this Party","success"=>"Something Went Wrong"));
	}	
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Customer Profile";
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['branch']=$branch;
		$this->punchData['city']=$city;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
		//supplier 
	    function sparty(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PARTY",array("ATYPE"=>'1'),"","VCODE ASC");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("city","City","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("mob","Mobile","required");
		$this->form_validation->set_rules("limit","Credit Limit","required");
	    if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertSParty($data)){
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
		$data=$this->EditModel->getData("PARTY",array("VCODE"=>$this->input->post("id")),"","");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['branch']=$branch;
		$this->punchData['city']=$city;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("city","City","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("mob","Mobile","required");
		$this->form_validation->set_rules("limit","Credit Limit","required");
		if($this->form_validation->run()){
		$data = $this->input->post();
		if($this->EditModel->updateSParty($data)){
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
	$chck1=$this->dataModel->getData("PURCH1",array("VCODE"=>$this->input->post("id")),"","");
	$chck2=$this->dataModel->getData("SALE1",array("VCODE"=>$this->input->post("id")),"","");
	$chck3=$this->dataModel->getData("Gnrllgr",array("ACode"=>$this->input->post("id")),"","");
	if(empty($chck1) && empty($chck2) && empty($chck3)){
		
	$data=$this->EditModel->deleteData("PARTY",array("VCODE"=>$this->input->post("id")));
	$data=$this->EditModel->deleteData("ACOUNT",array("ACODE"=>$this->input->post("id")));
	
	return true;	
		}	else {
	echo json_encode(array("error"=>"Entry Present Against this Party","success"=>"Something Went Wrong"));
	}	
	}
	}
	else{
	if ($this->uri->segment(3)!=FALSE)
	{
	redirect("$segment1/$segment2");	
	}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Supplier Profile";
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['branch']=$branch;
		$this->punchData['city']=$city;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
		
		//cargo
	    function cargo(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("CARGO","","","CODE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("mob","Mobile","required");
	
	    if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertCargo($data)){
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
		$data=$this->EditModel->getData("CARGO",array("CODE"=>$this->input->post("id")),"","");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['city']=$city;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("city","City","required");
		$this->form_validation->set_rules("mob","Mobile","required");
		if($this->form_validation->run()){
		$data = $this->input->post();
		if($this->EditModel->updateCargo($data)){
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
		$data=$this->EditModel->deleteData("CARGO",array("CODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Cargo Profile";
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['city']=$city;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
		
	function subparty(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("SUBPARTY","","","VCODE ASC");
		$listsp=$this->EditModel->getData("PARTY","","","VCODE ASC");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$data['list']=$list;
		$data['listsp']=$listsp;
		$data['list_branch']=$branch;
		$data['city']=$city;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("customer","Customer","required");
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("city","City","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("mob","Mobile","required");
		$this->form_validation->set_rules("limit","Credit Limit","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertSubParty($data)){
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
		$data=$this->EditModel->getData("SUBPARTY",array("VCODE"=>$this->input->post("id")),"","");
		$party=$this->EditModel->getData("PARTY","","","VNAME ASC");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['party']=$party;
		$this->punchData['branch']=$branch;
		$this->punchData['city']=$city;
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$this->form_validation->set_rules("customer","Customer","required");
		$this->form_validation->set_rules("name","Username","required");
		$this->form_validation->set_rules("branch","Branch","required");
		$this->form_validation->set_rules("city","City","required");
		$this->form_validation->set_rules("status","Status","required");
		$this->form_validation->set_rules("mob","Mobile","required");
		$this->form_validation->set_rules("limit","Credit Limit","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateSubParty($data)){
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
		$data=$this->EditModel->deleteData("SUBPARTY",array("VCODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Sub Customer";
		$customer=$this->EditModel->getData("PARTY","","","VNAME ASC");
		$branch=$this->EditModel->getData("BRANCH","","","BNAME ASC");
		$city=$this->EditModel->getData("CITY","","","CNAME ASC");
		$this->punchData['customer']=$customer;
		$this->punchData['branch']=$branch;
		$this->punchData['city']=$city;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
	
	function userType(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("UTYPE","","TYPE AS NAME,ID AS ID","TYPE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","User Type","required|is_unique[UTYPE.TYPE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertUserType($data)){
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
		$data=$this->EditModel->getData("UTYPE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("UTYPE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['TYPE']!=$this->input->post("name"))
		{
		$unique="|is_unique[UTYPE.TYPE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","User Type","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateUserType($data)){
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
		$data=$this->EditModel->deleteData("UTYPE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="User Type";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function mainGroup(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("MGROUP","","MGROUP AS NAME,ID AS ID","MGROUP ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Main Group","required|is_unique[MGROUP.MGROUP]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertMainGroup($data)){
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
		$data=$this->EditModel->getData("MGROUP",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("MGROUP",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['MGROUP']!=$this->input->post("name"))
		{
		$unique="|is_unique[MGROUP.MGROUP]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Main Group","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateMainGroup($data)){
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
		$data=$this->EditModel->deleteData("MGROUP",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Main Group";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
	
	
	function pmgroup(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PMGROUP","","MGROUP AS NAME,ID AS ID","MGROUP ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Product Group","required|is_unique[PMGROUP.MGROUP]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertpmgroup($data)){
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
		$data=$this->EditModel->getData("PMGROUP",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("PMGROUP",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['MGROUP']!=$this->input->post("name"))
		{
		$unique="|is_unique[PMGROUP.MGROUP]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Product Group","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updatepmgroup($data)){
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
		$data=$this->EditModel->deleteData("PMGROUP",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Product Group";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		

	function subgroup(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PSGROUP","","","ID ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Sub Group name","required|is_unique[PSGROUP.MGROUP]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertSubGroup($data)){
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
		$data=$this->EditModel->getData("PSGROUP",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("PSGROUP",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['MGROUP']!=$this->input->post("name"))
		{
		$unique="|is_unique[PSGROUP.MGROUP]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Sub Group","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateSubGroup($data)){
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
		$data=$this->EditModel->deleteData("SGRP",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Sub Group";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
	
	function size(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("SIZE","","","ID ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Siz name","required|is_unique[SIZE.SIZE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertSize($data)){
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
		$data=$this->EditModel->getData("SIZE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("SIZE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['SIZE']!=$this->input->post("name"))
		{
		$unique="|is_unique[SIZE.SIZE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Size","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateSize($data)){
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
		$data=$this->EditModel->deleteData("SIZE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Size Information";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}


	function origing(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("ORIGING","","ORIGING AS NAME,ID AS ID","ORIGING ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Origing","required|is_unique[ORIGING.ORIGING]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertOriging($data)){
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
		$data=$this->EditModel->getData("ORIGING",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("ORIGING",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['ORIGING']!=$this->input->post("name"))
		{
		$unique="|is_unique[ORIGING.ORIGING]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Origing","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateOriging($data)){
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
		$data=$this->EditModel->deleteData("ORIGING",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Origing";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function innerDia(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("INNERDIA","","INNERDIA AS NAME,ID AS ID","INNERDIA ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Inner Dia","required|is_unique[INNERDIA.INNERDIA]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertinnerDia($data)){
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
		$data=$this->EditModel->getData("INNERDIA",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("INNERDIA",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['INNERDIA']!=$this->input->post("name"))
		{
		$unique="|is_unique[INNERDIA.INNERDIA]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Inner Dia","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateinnerDia($data)){
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
		$data=$this->EditModel->deleteData("INNERDIA",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Inner Dia";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function outerDia(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("OUTERDIA","","OUTERDIA AS NAME,ID AS ID","OUTERDIA ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Outer Dia","required|is_unique[OUTERDIA.OUTERDIA]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertOuterDia($data)){
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
		$data=$this->EditModel->getData("OUTERDIA",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("OUTERDIA",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['OUTERDIA']!=$this->input->post("name"))
		{
		$unique="|is_unique[OUTERDIA.OUTERDIA]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Outer Dia","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateOuterDia($data)){
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
		$data=$this->EditModel->deleteData("OUTERDIA",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Outer Dia";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	
		
	function color(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("COLOR","","NAME AS NAME,ID AS ID","NAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Color","required|is_unique[COLOR.NAME]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertColor($data)){
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
		$data=$this->EditModel->getData("COLOR",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("COLOR",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['NAME']!=$this->input->post("name"))
		{
		$unique="|is_unique[COLOR.NAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Color","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateColor($data)){
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
		if($segment=="delete"){
		$data=$this->EditModel->deleteData("COLOR",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Color Information";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function gauge(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("GAUGE","","GAUGE AS NAME,ID AS ID","GAUGE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Gauge","required|is_unique[GAUGE.GAUGE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertGauge($data)){
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
		$data=$this->EditModel->getData("GAUGE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("GAUGE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['GAUGE']!=$this->input->post("name"))
		{
		$unique="|is_unique[GAUGE.GAUGE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Gauge","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateGauge($data)){
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
		$data=$this->EditModel->deleteData("GAUGE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Gauge";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function subProduct(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("GAUGE","","GAUGE AS NAME,ID AS ID","GAUGE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Gauge","required|is_unique[GAUGE.GAUGE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertsubProduct($data)){
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
		$data=$this->EditModel->getData("GAUGE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("GAUGE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['GAUGE']!=$this->input->post("name"))
		{
		$unique="|is_unique[GAUGE.GAUGE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Gauge","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updatesubProduct($data)){
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
		$data=$this->EditModel->deleteData("GAUGE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Gauge";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function feet(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("FEET","","FEET AS NAME,ID AS ID","FEET ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Feet","required|is_unique[FEET.FEET]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertFeet($data)){
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
		$data=$this->EditModel->getData("FEET",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("FEET",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['FEET']!=$this->input->post("name"))
		{
		$unique="|is_unique[FEET.FEET]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Feet","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateFeet($data)){
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
		$data=$this->EditModel->deleteData("FEET",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Feet";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function unit(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("UNIT","","UNIT AS NAME,ID AS ID","UNIT ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Unit","required|is_unique[UNIT.UNIT]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertUnit($data)){
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
		$data=$this->EditModel->getData("UNIT",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("UNIT",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['UNIT']!=$this->input->post("name"))
		{
		$unique="|is_unique[UNIT.UNIT]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Unit","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateUnit($data)){
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
		$data=$this->EditModel->deleteData("UNIT",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Unit";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function nature(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("NATURE","","NATURE AS NAME,ID AS ID","NATURE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Nature","required|is_unique[NATURE.NATURE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertNature($data)){
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
		$data=$this->EditModel->getData("NATURE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("NATURE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['NATURE']!=$this->input->post("name"))
		{
		$unique="|is_unique[NATURE.NATURE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Nature","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateNature($data)){
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
		$data=$this->EditModel->deleteData("NATURE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Nature";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function weight(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("WEIGHT","","WEIGHT AS NAME,ID AS ID","WEIGHT ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Weight","required|is_unique[WEIGHT.WEIGHT]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertWeight($data)){
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
		$data=$this->EditModel->getData("WEIGHT",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("WEIGHT",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['WEIGHT']!=$this->input->post("name"))
		{
		$unique="|is_unique[WEIGHT.WEIGHT]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Weight","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateWeight($data)){
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
		$data=$this->EditModel->deleteData("WEIGHT",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Weight";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function HRType(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("HRTYPE","","HRTYPE AS NAME,ID AS ID","HRTYPE ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Unit","required|is_unique[HRTYPE.HRTYPE]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertHRType($data)){
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
		$data=$this->EditModel->getData("HRTYPE",array("ID"=>$this->input->post("id")),"","");
		$this->punchData['data']=$data;
		echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("HRTYPE",array("ID"=>$this->input->post("id")),"","");	
		if($match[0]['HRTYPE']!=$this->input->post("name"))
		{
		$unique="|is_unique[HRTYPE.HRTYPE]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Cr/HR Type","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateHRType($data)){
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
		$data=$this->EditModel->deleteData("HRTYPE",array("ID"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Cr/HR Type";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
		
	function product(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PRODUCT","","","PNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Name","required|is_unique[PRODUCT.PNAME]");
		$this->form_validation->set_rules("unit","Product Unit","required");
		$this->form_validation->set_rules("prate","Purchase Rate");
		$this->form_validation->set_rules("srate","Sales Rate");
		$this->form_validation->set_rules("grp","Main Group","required");
		$this->form_validation->set_rules("status","Product Status","required");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertProduct($data)){
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
		$data=$this->EditModel->getData("PRODUCT",array("PCODE"=>$this->input->post("id")),"","");	
		$this->punchData['data']=$data;
		$mgroup=$this->EditModel->getData("MGROUP","","","ID ASC");
		$this->punchData['mgroup']=$mgroup;
		$unit=$this->EditModel->getData("UNIT","","","ID ASC");
		$this->punchData['unit']=$unit;
		$this->load->view("$segment1/$segment2/$segment",$this->punchData);
		}
		if($segment=="update")
		{
		$match=$this->EditModel->getData("PRODUCT",array("PCODE"=>$this->input->post("id")),"","");	
		if($match[0]['PNAME']!=$this->input->post("name")){
		$unique="|is_unique[PRODUCT.PNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Product Name","required".$unique."");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->updateProduct($data)){
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
		$data=$this->EditModel->deleteData("PRODUCT",array("PCODE"=>$this->input->post("id")));
		return true;	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Product Information";
		$product=$this->EditModel->getData("GAUGE","","","GAUGE ASC");
		$party=$this->EditModel->getData("PARTY","","","VNAME ASC");	
		$unit=$this->EditModel->getData("UNIT","","","ID ASC");
		$mgroup=$this->EditModel->getData("MGROUP","","","ID ASC");	
		$this->punchData['mgroup']=$mgroup;		
		$this->punchData['party']=$party;	
		$this->punchData['unit']=$unit;
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}
		
		}
		
	function changePassword(){
		$segment=$this->uri->segment(2);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="save")
		{
		$this->form_validation->set_rules("cpassword","Current Password","required");
		$this->form_validation->set_rules("npassword","New Password","required");
		$this->form_validation->set_rules("cnpassword","Confirm New Password","required|matches[npassword]");
			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->changePassword($data)==true){
					echo json_encode(array("error"=>"","success"=>"true"));
				}
				else{
				echo json_encode(array("error"=>"Current Password is not correct !","success"=>"Something Went Wrong"));
				}
			}
			else{
				echo json_encode(array("error"=>$this->form_validation->error_array(),"success"=>"false"));	
			}	
		}
		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Change Current Password";
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
		}	
		}
	
	
	
	function pprofile(){
		$segment=$this->uri->segment(3);
		$segment1=$this->router->class;
		$segment2=$this->router->method;		
		if($this->input->is_ajax_request())
		{
		if($segment=="list")
		{
		$list=$this->EditModel->getData("PRODUCT","","","PNAME ASC");
		$data['list']=$list;
		echo $this->load->view("$segment1/$segment2/$segment",$data,TRUE);	
		}
		if($segment=="save")
		{
		$this->form_validation->set_rules("name","Name","required|is_unique[PRODUCT.PNAME]");
		$this->form_validation->set_rules("pgrp","Product Group","required");
		$this->form_validation->set_rules("sgrp","Sub Group","required");
		$this->form_validation->set_rules("size","Size","required");		
		$this->form_validation->set_rules("prate","Purchase Rate","required");
		$this->form_validation->set_rules("srate","Sales Rate","required");

			if($this->form_validation->run()){
				$data = $this->input->post();
				if($this->EditModel->insertPProfile($data)){
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
		$data=$this->EditModel->getData("PRODUCT",array("PCODE"=>$this->input->post("id")),"","");	
		$this->punchData['data']=$data;
	$pgrp=$this->EditModel->getData("DESIGN","","","NAME ASC");
	$sgrp=$this->EditModel->getData("COLOR","","","NAME ASC");
	$size=$this->EditModel->getData("SIZE","","","SIZE ASC");
	
	
	$this->punchData['pgrp']=$pgrp;
	$this->punchData['sgrp']=$sgrp;
	$this->punchData['size']=$size;
	

	$this->punchData['data']=$data;
	echo $this->load->view("$segment1/$segment2/$segment",$this->punchData,TRUE);	
	}
		
	
		if($segment=="update")
		{
		$match=$this->EditModel->getData("PRODUCT",array("PCODE"=>$this->input->post("id")),"","");	
		if($match[0]['PNAME']!=$this->input->post("name")){
		$unique="|is_unique[PRODUCT.PNAME]";	
		}
		else{
		$unique="";	
		}
		$this->form_validation->set_rules("name","Product Name","required".$unique."");
			if($this->form_validation->run())
			{
			$data = $this->input->post();
			if($this->EditModel->updatePProfile($data)){
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
		$data=$this->EditModel->deleteData("PRODUCT",array("PCODE"=>$this->input->post("id")));
		return true;	
		}

		if($segment=="get-name")
		{
		$name="";	
		$data=$this->input->post();	
		if($data['pgrp']!='' && $data['pgrp']!='0')
		{
		$a=explode("-",$data['pgrp']);	
	
		if(!empty($data['inc_pgrp']))
		{
		 $name=$name."".$a[1];
		}		
		}
		
		
		if($data['sgrp']!='' && $data['sgrp']!='0')
		{
		$a=explode("-",$data['sgrp']);	
		
		if(!empty($data['inc_sgrp']))
		{
		$name=$name."-".$a[1];
		}		
		}

		
		if($data['size']!='' && $data['size']!='0')
		{
		$a=explode("-",$data['size']);	
	
		if(!empty($data['inc_size']))
		{
		$name=$name."-".$a[1];
		}		
		}
		
	
		
		echo json_encode(array("name"=>$name));
		}

		}
		else{
		if ($this->uri->segment(3)!=FALSE)
		{
		redirect("$segment1/$segment2");	
		}
		$this->punchData['navbar']=$this->session->userdata("NAVBAR");
		$this->punchData['heading']="Product Information";
		
	
		$pgrp=$this->EditModel->getData("DESIGN","","","NAME ASC");
		$this->punchData['pgrp']=$pgrp;
				
		$sgrp=$this->EditModel->getData("COLOR","","","NAME ASC");
		$this->punchData['sgrp']=$sgrp;		
		
		$size=$this->EditModel->getData("SIZE","","","SIZE ASC");
		$this->punchData['size']=$size;
		

		$unit=$this->EditModel->getData("UNIT","","","UNIT ASC");
		$this->punchData['unit']=$unit;
		
		$this->punchData['view']="$segment1/$segment2/main";
		$this->load->view("main",$this->punchData);		
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
