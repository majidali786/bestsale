<?php
	class EditModel extends MY_Model{
		
	public function insertAccountGroup($data)
	{
	$max = $this->getMax("PGROUP","PGRP","");
	$run = $this->db->query("INSERT INTO PGROUP(PGRP,PGNAME) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateAccountGroup($data)
	{
	$run = $this->db->query("UPDATE PGROUP SET PGNAME='".$data['name']."' WHERE PGRP='".$data['id']."'");
	return true;		
	}

     public function DeleteImg($input,$id,$table){
			$this->db->set($input,"");
			$this->db->where($id);
			$this->db->update($table);
			return true;
			}
	public function insertDesign($data)
	{
	$max = $this->getMax("DESIGN","ID","");
	$run = $this->db->query("INSERT INTO DESIGN(ID,NAME,IMG) VALUES ('".$max."','".$data['name']."','".$data['img']."')");
	return true;	
	}
	public function updateDesign($data)
	{
	$run = $this->db->query("UPDATE DESIGN SET NAME='".$data['name']."',IMG='".$data['img']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertAccount($data)
	{
		
	$max = $this->getMax("ACCOUNT","ACODE","");
	$atype=$this->getData("ATYPE",array("TCODE"=>$data['atype']),"TYPE","");
	$tcode=$atype[0]['TYPE'];	
	$run = $this->db->query("INSERT INTO ACCOUNT(ACODE,ANAME,ATYPE,ATPNAME) 
	VALUES ('$max','".$data['name']."' ,'".$data['atype']."' ,'".$tcode."')");
	
	return true;	
	}
	public function updateAccount($data)
	{	
	$Atype=$this->getData("ATYPE",array("TCODE"=>$data['atype']),"TYPE","");
	$tpname=$Atype[0]['TYPE'];
	$run = $this->db->query("UPDATE ACCOUNT SET ANAME='".$data['name']."',ATYPE='".$data['atype']."',ATPNAME='$tpname' WHERE ACODE='".$data['id']."'");	
	return true;
	}	
	
	
	public function insertBank($data)
	{
	$max = $this->getMax("BANK","BCODE","");
	$run = $this->db->query("INSERT INTO BANK(BCODE,BNAME) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateBank($data)
	{
	$run = $this->db->query("UPDATE BANK SET BNAME='".$data['name']."' WHERE BCODE='".$data['id']."'");
	return true;		
	}
	
	public function insertsaleman($data)
	{
	$max = $this->getMax("SALESMAN","ID","");
	$run = $this->db->query("INSERT INTO SALESMAN(ID,NAME,B_ID) VALUES ('".$max."','".$data['name']."','".$this->userData['B_ID']."')");
	return true;	
	}
	public function updatesaleman($data)
	{
	$run = $this->db->query("UPDATE SALESMAN SET NAME='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertProvince($data)
	{
	$max = $this->getMax("PROVINCE","PRCODE","");
	$run = $this->db->query("INSERT INTO PROVINCE(PRCODE,PRNAME) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateProvince($data)
	{
	$run = $this->db->query("UPDATE PROVINCE SET PRNAME='".$data['name']."' WHERE PRCODE='".$data['id']."'");
	return true;		
	}	
	public function insertDepartment($data)
	{
	$max = $this->getMax("DEPT","DPCode","");
	$run = $this->db->query("INSERT INTO DEPT(DPCode,DPName) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateDepartment($data)
	{
	$run = $this->db->query("UPDATE DEPT SET DPName='".$data['name']."' WHERE DPCode='".$data['id']."'");
	return true;		
	}
	public function insertBranch($data)
	{
	$max = $this->getMax("BRANCH","BCODE","");
	$run = $this->db->query("INSERT INTO BRANCH(BCODE,BNAME) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	
	public function updateBranch($data)
	{
	$run = $this->db->query("UPDATE BRANCH SET BNAME='".$data['name']."' WHERE BCODE='".$data['id']."'");
	return true;		
	}
	
	public function insertSalesman($data)
	{
	$max = $this->getMax("SPERSON","BCODE","");
	$run = $this->db->query("INSERT INTO SPERSON(BCODE,BNAME,USERNAME) VALUES ('".$max."','".$data['name']."','".$data['user']."')");
	return true;	
	}
	public function updateSalesman($data)
	{
	$run = $this->db->query("UPDATE SPERSON SET BNAME='".$data['name']."',USERNAME='".$data['user']."' WHERE BCODE='".$data['id']."'");
	return true;		
	}
	
	public function insertCity($data)
	{
	$max = $this->getMax("CITY","CCODE","");
	$Prname=$this->getData("PROVINCE",array("PRCODE"=>$data['province']),"PRNAME","");
	$province=$Prname[0]['PRNAME'];	
	$run = $this->db->query("INSERT INTO CITY(CCODE,CNAME,PRCODE,PRNAME) VALUES ('".$max."','".$data['name']."','".$data['province']."','".$province."')");
	return true;	
	}
	
	public function updateCity($data)
	{
	$Prname=$this->getData("PROVINCE",array("PRCODE"=>$data['province']),"PRNAME","");
	$province=$Prname[0]['PRNAME'];		
	$run = $this->db->query("UPDATE CITY SET CNAME='".$data['name']."',PRCODE='".$data['province']."',PRNAME='".$province."' WHERE CCODE='".$data['id']."'");
	return true;		
	}
	
	public function insertUser($data)
	{
	$run = $this->db->query("INSERT INTO login(USERNAME,PASSWORD,STATUS,TYPE,B_ID) VALUES ('".$data['name']."','".$data['password']."','".$data['status']."','".$data['type']."','".$data['branch']."')");
	return true;	
	}
	
	public function updateUser($data)
	{	
		
	$run = $this->db->query("UPDATE login SET PASSWORD='".$data['password']."',STATUS='".$data['status']."',TYPE='".$data['type']."',B_ID='".$data['branch']."' WHERE USERNAME='".$data['id']."' ");
	return true;		
	}
	//customer
	public function insertParty($data)	
	{
	$max = $this->getMax("PARTY","VCODE",array("ATYPE"=>0));
	if ($max=='1') 
	{
	$vcode = '10102001';
	}
	else
	{
	$vcode = $max;
	}
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("INSERT INTO PARTY(VCODE,VNAME,ADDR,MOBILE,CLIMIT,CID,CITY,STATUS,B_ID ,ATYPE,ATYPNAME) 
	VALUES ('$vcode','".$data['name']."','".$data['addr']."','".$data['mob']."','".$data['limit']."','".$data['city']."','$cname','".$data['status']."','".$data['branch']."','0','Customer')");
	
	$run2 = $this->db->query("INSERT INTO ACCOUNT(ACODE, ANAME, ATYPE, ATPNAME, AGROUP, AGRPNAME, LEVL, L1CODE, L2CODE, L3CODE) 
	VALUES ('$vcode','".$data['name']."','4','CUSTOMER','0','Assets','4','1','101','10102')");
	
	
	
	return true;	
	}
	public function updateParty($data)
	{	
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("UPDATE PARTY SET VNAME='".$data['name']."',ADDR='".$data['addr']."',STATUS='".$data['status']."'
	,MOBILE='".$data['mob']."',CLIMIT='".$data['limit']."',CID='".$data['city']."',CITY='".$cname."',B_ID='".$data['branch']."' 
	WHERE VCODE='".$data['id']."'");
	
	$run2 = $this->db->query("UPDATE ACCOUNT SET ANAME='".$data['name']."' WHERE ACODE='".$data['id']."'");
	
	
	return true;		
	}	
	
	//supplier
	public function insertSParty($data)	
	{
	$max = $this->getMax("PARTY","VCODE",array("ATYPE"=>1));
	if ($max=='1') 
	{
	$vcode = '20101001';
	}
	else
	{
	$vcode = $max;
	}
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("INSERT INTO PARTY(VCODE,VNAME,ADDR,MOBILE,CLIMIT,CID,CITY,STATUS,B_ID ,ATYPE,ATYPNAME) 
	VALUES ('$vcode','".$data['name']."','".$data['addr']."','".$data['mob']."','".$data['limit']."','".$data['city']."','$cname','".$data['status']."','".$data['branch']."','1','Supplier')");
	
	$run2 = $this->db->query("INSERT INTO ACCOUNT(ACODE, ANAME, ATYPE, ATPNAME, AGROUP, AGRPNAME, LEVL, L1CODE, L2CODE, L3CODE) 
	VALUES ('$vcode','".$data['name']."','5','SUPPLIER','2','liabilty','4','2','201','20101')");
	
	
	return true;	
	}
	
	public function updateSParty($data)
	{
		
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("UPDATE PARTY SET VNAME='".$data['name']."',ADDR='".$data['addr']."',STATUS='".$data['status']."',MOBILE='".$data['mob']."',CLIMIT='".$data['limit']."',CID='".$data['city']."',CITY='".$cname."',B_ID='".$data['branch']."' WHERE VCODE='".$data['id']."' AND ATYPE='1'");
	
	$run2 = $this->db->query("UPDATE ACCOUNT SET ANAME='".$data['name']."' WHERE ACODE='".$data['id']."'");
	
	return true;		
	}
	
	
		public function insertCargo($data)	
	{
	$max = $this->getMax("CARGO","CODE","");
	if ($max=='1') 
	{
	$code = '2001';
	}
	else
	{
	$code = $max;
	}
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("INSERT INTO CARGO(CODE,VNAME,ADDR,MOBILE,EMAIL,CID,CITY,B_ID) 
	VALUES ('$code','".$data['name']."','".$data['addr']."','".$data['mob']."','".$data['email']."','".$data['city']."','$cname','1')");
	return true;	
	}
	public function updateCargo($data)
	{	
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("UPDATE CARGO SET VNAME='".$data['name']."',ADDR='".$data['addr']."',EMAIL='".$data['email']."',MOBILE='".$data['mob']."'
	,CID='".$data['city']."',CITY='".$cname."',B_ID='1' WHERE CODE='".$data['id']."'");
	return true;		
	}	
	public function insertSubParty($data)
	{
	$max = $this->getMax("SUBPARTY","VCODE","");
	$vname=$this->getData("PARTY",array("VCODE"=>$data['customer']),"VNAME","");
	$vname = $vname[0]['VNAME'];
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("INSERT INTO SUBPARTY(VCODE,VNAME,ADDR,MOBILE,CLIMIT,CID,CITY,STATUS,B_ID,CUSCODE,CUSTOMER) VALUES ('$max','".$data['name']."','".$data['addr']."','".$data['mob']."','".$data['limit']."','".$data['city']."','$cname','".$data['status']."','".$data['branch']."','".$data['customer']."','$vname')");
	return true;	
	}
	
	public function updateSubParty($data)
	{	
	$vname=$this->getData("PARTY",array("VCODE"=>$data['customer']),"VNAME","");
	$vname = $vname[0]['VNAME'];
	$cname=$this->getData("CITY",array("CCODE"=>$data['city']),"CNAME","");
	$cname = $cname[0]['CNAME'];
	$run = $this->db->query("UPDATE SUBPARTY SET VNAME='".$data['name']."',CUSTOMER='".$vname."',CUSCODE='".$data['customer']."',ADDR='".$data['addr']."',STATUS='".$data['status']."',MOBILE='".$data['mob']."',CLIMIT='".$data['limit']."',CID='".$data['city']."',CITY='".$cname."',B_ID='".$data['branch']."' WHERE VCODE='".$data['id']."'");
	return true;	
	}	
	
	public function insertUserType($data)
	{
	$max = $this->getMax("UTYPE","ID","");
	$run = $this->db->query("INSERT INTO UTYPE(ID,TYPE) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	
	public function updateUserType($data)
	{
	$run = $this->db->query("UPDATE UTYPE SET TYPE='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}

	public function insertMainGroup($data)
	{
	$max = $this->getMax("MGROUP","ID","");
	$run = $this->db->query("INSERT INTO MGROUP(ID,MGROUP) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateMainGroup($data)
	{
	$run = $this->db->query("UPDATE MGROUP SET MGROUP='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	
	public function insertpmgroup($data)
	{
	$max = $this->getMax("PMGROUP","ID","");
	$run = $this->db->query("INSERT INTO PMGROUP(ID,MGROUP) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updatepmgroup($data)
	{
	$run = $this->db->query("UPDATE PMGROUP SET MGROUP='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	
	public function insertSubGroup($data)
	{
	$max = $this->getMax("PSGROUP","ID","");
	$run = $this->db->query("INSERT INTO PSGROUP(ID,MGROUP) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateSubGroup($data)
	{
	$run = $this->db->query("UPDATE PSGROUP SET MGROUP='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	
	public function insertSize($data)
	{
	$max = $this->getMax("SIZE","ID","");
	$run = $this->db->query("INSERT INTO SIZE(ID,SIZE) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateSize($data)
	{
	$run = $this->db->query("UPDATE SIZE SET SIZE='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	
	public function insertOriging($data)
	{
	$max = $this->getMax("ORIGING","ID","");
	$run = $this->db->query("INSERT INTO ORIGING(ID,ORIGING) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateOriging($data)
	{
	$run = $this->db->query("UPDATE ORIGING SET ORIGING='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertinnerDia($data)
	{
	$max = $this->getMax("INNERDIA","ID","");
	$run = $this->db->query("INSERT INTO INNERDIA(ID,INNERDIA) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateinnerDia($data)
	{
	$run = $this->db->query("UPDATE INNERDIA SET INNERDIA='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertColor($data)
	{
	$max = $this->getMax("COLOR","ID","");
	$run = $this->db->query("INSERT INTO COLOR(ID,NAME) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateColor($data)
	{
	$run = $this->db->query("UPDATE COLOR SET NAME='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	//-----Sub category------
		public function insertCategory($data)
		{
		$Fname=$this->getData("MCATEGORY",array("ID"=>$data['mcategory']),"MCATEGORY","");
		$name=$Fname[0]['MCATEGORY'];	
		$max = $this->getMax("CATEGORY","ID","");
		$run = $this->db->query("INSERT INTO CATEGORY(ID,CATEGORY,MCID,UCATEGORY,MCATEGORY,IMG) 
		VALUES ('".$max."','".$data['category']."','".$data['mcategory']."',N'".$data['ucategory']."','".$name."','".$data['img']."')");
		return true;	
		}
		public function updateCategory($data)
		{
		$Fname=$this->getData("MCATEGORY",array("ID"=>$data['mcategory']),"MCATEGORY","");
		$name=$Fname[0]['MCATEGORY'];
		$run = $this->db->query("UPDATE CATEGORY SET CATEGORY='".$data['category']."',MCID='".$data['mcategory']."',MCATEGORY='".$name."',UCATEGORY=N'".$data['ucategory']."',IMG='".$data['img']."' WHERE ID='".$data['id']."'");
		return true;		
		}

	public function insertOuterDia($data)
	{
	$max = $this->getMax("OUTERDIA","ID","");
	$run = $this->db->query("INSERT INTO OUTERDIA(ID,OUTERDIA) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateOuterDia($data)
	{
	$run = $this->db->query("UPDATE OUTERDIA SET OUTERDIA='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertsubProduct($data)
	{
	$max = $this->getMax("GAUGE","ID","");
	$run = $this->db->query("INSERT INTO GAUGE(ID,GAUGE) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updatesubProduct($data)
	{
	$run = $this->db->query("UPDATE GAUGE SET GAUGE='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertFeet($data)
	{
	$max = $this->getMax("FEET","ID","");
	$run = $this->db->query("INSERT INTO FEET(ID,FEET) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateFeet($data)
	{
	$run = $this->db->query("UPDATE FEET SET FEET='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertUnit($data)
	{
	$max = $this->getMax("UNIT","ID","");
	$run = $this->db->query("INSERT INTO UNIT(ID,UNIT) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateUnit($data)
	{
	$run = $this->db->query("UPDATE UNIT SET UNIT='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertNature($data)
	{
	$max = $this->getMax("NATURE","ID","");
	$run = $this->db->query("INSERT INTO NATURE(ID,NATURE) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateNature($data)
	{
	$run = $this->db->query("UPDATE NATURE SET NATURE='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertWeight($data)
	{
	$max = $this->getMax("WEIGHT","ID","");
	$run = $this->db->query("INSERT INTO WEIGHT(ID,WEIGHT) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateWeight($data)
	{
	$run = $this->db->query("UPDATE WEIGHT SET WEIGHT='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function insertHRType($data)
	{
	$max = $this->getMax("HRTYPE","ID","");
	$run = $this->db->query("INSERT INTO HRTYPE(ID,HRTYPE) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateHRType($data)
	{
	$run = $this->db->query("UPDATE HRTYPE SET HRTYPE='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	public function changePassword($data)
	{
	$check=$this->getData("login",array("USERNAME"=>$this->userData['U_ID'],"PASSWORD"=>$data['cpassword']),"","");
	if(!empty($check)){
	$run = $this->db->query("UPDATE login SET PASSWORD='".$data['npassword']."' WHERE USERNAME='".$this->userData['U_ID']."'");
	return true;
	}
	else{
	return false;	
	}
	}
	public function insertProduct($data)
	{	
	$pname=$data['name'];
	$grpcode=$data['grp'];
	$prate=$data['prate'];
	$srate=$data['srate'];
	$status=$data['status'];
	$unitcode=$data['unit'];

	$max = $this->getMax("PRODUCT","PCODE","");
	if ($max=='1') 
	{
	$pcode = '10001';
	}
	else
	{
	$pcode = $max;
	}
	$get_grpname=$this->getData("MGROUP",array("ID"=>$grpcode),"MGROUP","");
	$grpname = $get_grpname[0]['MGROUP'];
	$unitname=$this->getData("UNIT",array("ID"=>$unitcode),"UNIT","");
	$unitname = $unitname[0]['UNIT'];
	
	$run = $this->db->query("INSERT INTO PRODUCT(PCODE,PNAME,UNIT,GRP,MGROUP,PRATE,SRATE,STATUS) 
	VALUES ('$pcode','$pname','$unitname','$grpcode','$grpname','$prate','$srate','$status')");
	return true;	
	}
	public function updateProduct($data)
	{
		$grpcode=$data['grp'];
		$prate=$data['prate'];
		$srate=$data['srate'];
		$unitcode = $data['unit'];
		$get_grpname=$this->getData("MGROUP",array("ID"=>$grpcode),"MGROUP","");
		$grpname = $get_grpname[0]['MGROUP'];

		$unitname=$this->getData("UNIT",array("ID"=>$unitcode),"UNIT","");
		$unitname = $unitname[0]['UNIT'];
	$run = $this->db->query("UPDATE PRODUCT SET PNAME='".$data['name']."',STATUS='".$data['status']."',UNIT='$unitname',PRATE='".$data['prate']."',SRATE ='".$data['srate']."',GRP='$grpcode',MGROUP='$grpname' WHERE PCODE='".$data['id']."'");
	return true;		
	}
	
	
	
	public function insertPProfile($data)
	{	
	
	$max = $this->getMax("PRODUCT","PCODE","");
	if ($max=='1') 
	{
	$pcode = '50001';
	}
	else
	{
	$pcode = $max;
	}

	$grid=0;
	$pgrp="";
	if($data['pgrp']!='0')
	{
	$a=explode("-",$data['pgrp']);
	$grid=$a[0];
	$pgrp=$a[1];	
	}
	$sgid=0;
	$sgrp="";
	if($data['sgrp']!='0')
	{
	$a=explode("-",$data['sgrp']);
	$sgid=$a[0];
	$sgrp=$a[1];	
	}

	$sid=0;
	$size="";
	if($data['size']!='0')
	{
	$a=explode("-",$data['size']);
	$sid=$a[0];
	$size=$a[1];	
	}	
		

	$inc_pgrp=0;
	if(!empty($data['inc_pgrp'])){
	$inc_pgrp=1;	
	}
	$inc_sgrp=0;
	if(!empty($data['inc_sgrp'])){
	$inc_sgrp=1;	
	}
	$inc_size=0;
	if(!empty($data['inc_size'])){
	$inc_size=1;	
	}
	$prate=$data['prate'];
	$srate=$data['srate'];
	$unit = $data['unit'];
	$pmargin = $data['pmargin'];
	$pamount = $data['pamount'];
		
	$run = $this->db->query("INSERT INTO PRODUCT(PCODE,PNAME,DID,DESIGN,CID,COLOR,SID,SIZE,INC_SIZE,INC_PGRP,INC_SGRP,UNIT,PRATE,SRATE,PMARGIN,PAMOUNT,STATUS) 
	VALUES ('$pcode','".$data['name']."','$grid','$pgrp','$sgid','$sgrp','$sid','$size','$inc_size','$inc_pgrp','$inc_sgrp'
	,'$unit','$prate','$srate','$pmargin','$pamount','".$data['status']."')");
	
	return true;	
	
	
	}
	
	public function updatePProfile($data)
	{
	$getval2=$this->getData("DESIGN",array("ID"=>$data['pgrp']),"NAME","");
	$mname = $getval2[0]['NAME'];
	$getval3=$this->getData("COLOR",array("ID"=>$data['sgrp']),"NAME","");
	$psname = $getval3[0]['NAME'];
	$getval4=$this->getData("SIZE",array("ID"=>$data['size']),"SIZE","");
	$sgname = $getval4[0]['SIZE'];
	
	$run = $this->db->query("UPDATE PRODUCT SET PNAME='".$data['name']."',DID='".$data['pgrp']."',DESIGN='$mname',CID='".$data['sgrp']."',COLOR='$psname'
	,SID='".$data['size']."',SIZE='$sgname',UNIT='".$data['unit']."'
	,PRATE='".$data['prate']."',SRATE='".$data['srate']."',PMARGIN='".$data['pmargin']."',PAMOUNT='".$data['pamount']."'
	,STATUS='".$data['status']."' WHERE PCODE='".$data['id']."'");
	return true;		
	
	}
	
	
	//pricelist entry
	public function updatepricelist($data)
	{
	$nrows=$data['nrows'];
	$row=1;
	while($row<$nrows)
	{
	$pcode=$data['pcode'.$row.''];
	$prate=$data['prate'.$row.''];
	$srate=$data['srate'.$row.''];
	$pmargin=$data['pmargin'.$row.''];
	$pamount=$data['pamount'.$row.''];

	$run = $this->db->query("UPDATE PRODUCT SET PRATE='".$prate."',SRATE ='".$srate."',PMARGIN ='".$pmargin."',PAMOUNT ='".$pamount."' WHERE PCODE='".$pcode."'");
	$row++;
	} // while ends
	return true;	
	}

	
	
	
	}
?>