<?php
	class ChartOfAccountModel extends MY_Model{
		
	public function insertAccountLevel($data){
	$level=$data['level'];	
	if($level==1){
	$maxWhere=array("LEVL"=>1);	
	}
	if($level==2){
	$maxWhere=array("LEVL"=>2,"L1CODE"=>$data['level_1']);	
	}
	if($level==3){
	$maxWhere=array("LEVL"=>3,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2']);	
	}
	$max = $this->getMax("ACCOUNT","ACODE",$maxWhere);
	if($max==1 && $level!=1){
	$max=$data['level_1'].'01';	
	if($level==3){
	$max=$data['level_2'].'01';		
	}
	}
	$run = $this->db->query("INSERT INTO ACCOUNT(ACODE,ANAME,ATYPE,ATPNAME,AGROUP,AGRPNAME,LEVL,UPPER,L1CODE,L2CODE,L3CODE) VALUES ('".$max."','".strtoupper($data['name'])."','".$data['atype']."','','".$data['agroup']."','','$level','','".$data['level_1']."','".$data['level_2']."','')");
	return true;	
	}
	public function updateAccountLevel($data){
	$where="AND LEVL=1";	
	$level=$data['level'];	
	if($level==2){
	$where="AND LEVL=2 AND L1CODE='".$data['level_1']."'";	
	}
	else if($level==3){
	$where="AND LEVL=3 AND L1CODE='".$data['level_1']."' AND L2CODE='".$data['level_2']."'";	
	}	
	$run = $this->db->query("UPDATE ACCOUNT SET ANAME='".strtoupper($data['name'])."' WHERE ACODE='".$data['id']."'");
	return true;		
	}	
	public function insertAccount($data){
	$maxWhere=array("LEVL"=>4,"L1CODE"=>$data['level_1'],"L2CODE"=>$data['level_2'],"L3CODE"=>$data['level_3']);	
	$max = $this->getMax("ACCOUNT","ACODE",$maxWhere);
	if($max==1){
	$max=$data['level_3'].'001';
	}
	$atpnm=$this->getData("ACCOUNT_TYPE",array("ATYPE"=>$data['atype']),"ATPNAME","");
	$atype=$atpnm[0]['ATPNAME'];	
	$agroup=array("Assets","Capital","liabilty","Income","Expense");
	$run = $this->db->query("INSERT INTO ACCOUNT(ACODE,ANAME,ATYPE,ATPNAME,AGROUP,AGRPNAME,LEVL,UPPER,L1CODE,L2CODE,L3CODE) VALUES ('".$max."','".strtoupper($data['aname'])."','".$data['atype']."','$atype','".$data['agroup']."','".$agroup[$data['agroup']]."',4,'','".$data['level_1']."','".$data['level_2']."','".$data['level_3']."')");
	return true;	
	}
	public function updateAccount($data)
	{
	$atpnm=$this->getData("ACCOUNT_TYPE",array("ATYPE"=>$data['atype']),"ATPNAME","");
	$atype=$atpnm[0]['ATPNAME'];	
	$run = $this->db->query("UPDATE ACCOUNT SET ANAME='".$data['aname']."',ATYPE='".$data['atype']."',ATPNAME='".$atype."' WHERE ACODE='".$data['id']."'");
	return true;		
	}
	
	public function saveParty($data){
	$cid=$data['party_city'];	
	$cname=$this->getData("CITY",array("CCODE"=>$cid),"CNAME","");
	$city=$cname[0]['CNAME'];
	$sid=$data['party_sman'];	
	$sid=$data['party_sman'];	
	$spname=$this->getData("SPERSON",array("BCODE"=>$sid),"BNAME","");
	$sperson=$spname[0]['BNAME'];
	$vcode=$data['id'];	
	$party=$this->getData("ACCOUNT",array("ACODE"=>$vcode),"ANAME","");
	$vname=$party[0]['ANAME'];
	$addr=$data['p_addr'];	
	$b_id=$data['party_branch'];	
	$climit=$data['p_climit'];	
	$email=$data['p_mail'];	
	$mobile=$data['p_mnum'];	
	$phone=$data['p_phone'];	
	$mobile2=$data['p_mnum2'];	
	$cdays=$data['p_cdays'];	
	$ptype=$data['party_type'];	
	$status=$data['party_status'];	
	$ofaddr=$data['p_ofaddr'];	
	$ofphone=$data['p_ofphone'];	
	$ofmobile=$data['p_ofmnum'];	
	$ofemail=$data['p_ofmail'];
	$ofcid=$data['party_offcity'];
	$cheque=$data['cheque_type'];
	$ofcity="";
	if($ofcid!=0){
	$ofcname=$this->getData("CITY",array("CCODE"=>$ofcid),"CNAME","");
	$ofcity=$ofcname[0]['CNAME'];
	}
	$cperson=$data['p_cperson'];	
	$desig=$data['p_cdesig'];	
	$cmobile=$data['p_cmob'];	
	$bid=$data['party_bank'];	
	$accno=$data['p_bacc'];
	$bank="";
	if($bid!=0){
	$bname=$this->getData("BANK",array("BCODE"=>$bid),"BNAME","");
	$bank=$bname[0]['BNAME'];
	}
	$nparty=$this->getData("PARTY",array("VCODE"=>$vcode),"VNAME","");
	if(empty($nparty)){
	$run = $this->db->query("INSERT INTO PARTY(VCODE,VNAME,ADDR,EMAIL,PHONE,MOBILE,CLIMIT,CID,CITY,SID,SPERSON,B_ID,ATYPE,MOBILE2,CDAYS,PTYPE,STATUS,OFADDR,OFPHONE,OFMOBILE,OFEMAIL,OFCID,OFCITY,CPERSON,DESIG,CMOBILE,BID,BANK,ACCNO,CHEQUE) VALUES ('$vcode','$vname','$addr','$email','$phone','$mobile','$climit','$cid','$city','$sid','$sperson','$b_id',4,'$mobile2','$cdays','$ptype','$status','$ofaddr','$ofphone','$ofmobile','$ofemail','$ofcid','$ofcity','$cperson','$desig','$cmobile','$bid','$bank','$accno','$cheque')");	
	}
	else{
	$run = $this->db->query("UPDATE PARTY SET ADDR='$addr',EMAIL='$email',PHONE='$phone',MOBILE='$mobile',CLIMIT='$climit',CID='$cid',CITY='$city',SID='$sid',SPERSON='$sperson',B_ID='$b_id',MOBILE2='$mobile2',CDAYS='$cdays',PTYPE='$ptype',STATUS='$status',OFADDR='$ofaddr',OFPHONE='$ofphone',OFMOBILE='$ofmobile',OFEMAIL='$ofemail',OFCID='$ofcid',OFCITY='$ofcity',CPERSON='$cperson',DESIG='$desig',CMOBILE='$cmobile',BID='$bid',BANK='$bank',ACCNO='$accno',CHEQUE='$cheque' WHERE VCODE='$vcode'");		
	}
	return true;	
	}
	
	public function saveEmployee($data){
	$cid=$data['e_city'];	
	$cname=$this->getData("CITY",array("CCODE"=>$cid),"CNAME","");
	$city=$cname[0]['CNAME'];
	$dpid=$data['e_department'];		
	$dpname=$this->getData("UDEPT",array("ID"=>$dpid),"UDEPT","");
	$department=$dpname[0]['UDEPT'];
	$dsid=$data['e_designation'];
	$dsname=$this->getData("UDESIG",array("ID"=>$dsid),"UDESIG","");
	$designation=$dsname[0]['UDESIG'];
	$id=$data['id'];	
	$eet=$this->getData("ACCOUNT",array("ACODE"=>$id),"ANAME","");
	$name=$eet[0]['ANAME'];
	$fullname=$data['e_fullname'];	
	$father=$data['e_father'];	
	$reference=$data['e_ref'];	
	$dob=$data['e_dob'];	
	if($dob!=""){
	$dob=$this->dateFormat($dob);	
	}
	$jdate=$data['e_jdate'];
	if($jdate!=""){
	$jdate=$this->dateFormat($jdate);	
	}	
$psdate=$data['e_pdate'];	
	if($psdate!=""){
	$psdate=$this->dateFormat($psdate);	
	}
	$exdate=$data['e_edate'];
	if($exdate!=""){
	$exdate=$this->dateFormat($exdate);	
	}
$vsdate=$data['e_vdate'];	
	if($vsdate!=""){
	$vsdate=$this->dateFormat($vsdate);	
	}
	$vxdate=$data['e_vedate'];
	if($vxdate!=""){
	$vxdate=$this->dateFormat($vxdate);	
	}

	
	$status=$data['e_status'];	
	$addr=$data['e_addr'];	
	$bid=$data['e_branch'];	
	$email=$data['e_mail'];	
	$mobile=$data['e_mnum'];	
	$mobile2=$data['e_mnum2'];
	$emergency=$data['e_emergency'];	
	$bgroup=$data['e_bgroup'];	
	$cnic=$data['e_cnic'];	
	$username=$data['e_user'];	
	$img=$data['img'];	
	
	$nemployee=$this->getData("EMPLOYEE",array("ID"=>$id),"NAME","");
	if(empty($nemployee)){
	$run = $this->db->query("INSERT INTO EMPLOYEE(ID,NAME,FULLNAME,FATHER,REFERENCE,DOB,JDATE,PSDATE,EXDATE,VSDATE,VXDATE,DPID,DEPARTMENT,DSID,DESIGNATION,STATUS,MOBILE
	,MOBILE2,EMERGENCY,EMAIL,BGROUP,CNIC,ADDR,CID,CITY,USERNAME,BID,IMG) VALUES ('$id','$name','$fullname','$father','$reference','$dob','$jdate','$psdate','$exdate','$vsdate','$vxdate','$dpid','$department','$dsid','$designation','$status','$mobile','$mobile2','$emergency','$email','$bgroup','$cnic','$addr','$cid','$city','$username','$bid','$img')");	
	}
	else{
	$run = $this->db->query("UPDATE EMPLOYEE SET FULLNAME='$fullname',FATHER='$father',REFERENCE='$reference',DOB='$dob',JDATE='$jdate',PSDATE='$psdate',EXDATE='$exdate',VSDATE='$vsdate',VXDATE='$vxdate',DPID='$dpid',DEPARTMENT='$department',DSID='$dsid',DESIGNATION='$designation',STATUS='$status',MOBILE='$mobile',MOBILE2='$mobile2',EMERGENCY='$emergency',EMAIL='$email',BGROUP='$bgroup',CNIC='$cnic',ADDR='$addr',CID='$cid',CITY='$city',USERNAME='$username',BID='$bid',IMG='$img' WHERE ID='$id'");		
	}
	return true;	
	}
	
	}
?>