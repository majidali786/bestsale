<?php
	class UserRightsModel extends MY_Model{
		
	public function saveMenuRights($data){
	if(!empty($data['notchecked'])){
	$this->db->query("DELETE FROM MENU_RIGHTS WHERE USR='".$data['user']."' AND B_ID='".$data['branch']."' AND MENU IN (".$data['notchecked'].") ");
	}
	if(!empty($data['level1'])){
	$a=$data['level1']-1;	
		if($a>0){
		$b=1;	
		while($b<=$a){	
			if(!empty($data['level1_'.$b.''])){
			$this->deleteData("MENU_RIGHTS",array("USR"=>$data['user'],"B_ID"=>$data['branch'],"MENU"=>$data['level1_'.$b.'']));
			$this->db->query("INSERT INTO MENU_RIGHTS(USR,B_ID,MENU) VALUES ('".$data['user']."','".$data['branch']."','".$data['level1_'.$b.'']."')");
			}
		$b++;
		}	
		}
	}
	
	if(!empty($data['level2'])){
	$a=$data['level2']-1;	
		if($a>0){
		$b=1;	
		while($b<=$a){		
			if(!empty($data['level2_'.$b.''])){
			$this->deleteData("MENU_RIGHTS",array("USR"=>$data['user'],"B_ID"=>$data['branch'],"MENU"=>$data['level2_'.$b.'']));
			$this->db->query("INSERT INTO MENU_RIGHTS(USR,B_ID,MENU) VALUES ('".$data['user']."','".$data['branch']."','".$data['level2_'.$b.'']."')");
			}
			else if(!empty($data['notchecked']['level1_'.$b.''])){
			$this->deleteData("MENU_RIGHTS",array("USR"=>$data['user'],"B_ID"=>$data['branch'],"MENU"=>$data['notchecked']['level1_'.$b.'']));	
			}
		$b++;
		}	
		}	
	}
	
	if(!empty($data['level3'])){
	$a=$data['level3']-1;	
		if($a>0){
		$b=1;	
		while($b<=$a){	
			if(!empty($data['level3_'.$b.''])){
			$this->deleteData("MENU_RIGHTS",array("USR"=>$data['user'],"B_ID"=>$data['branch'],"MENU"=>$data['level3_'.$b.'']));
			$this->db->query("INSERT INTO MENU_RIGHTS(USR,B_ID,MENU) VALUES ('".$data['user']."','".$data['branch']."','".$data['level3_'.$b.'']."')");
			}
			else if(!empty($data['notchecked']['level1_'.$b.''])){
			$this->deleteData("MENU_RIGHTS",array("USR"=>$data['user'],"B_ID"=>$data['branch'],"MENU"=>$data['notchecked']['level1_'.$b.'']));	
			}
		$b++;
		}	
		}	
	}
	return true;
	}
	
	public function saveVoucherRights($data){
	$uparray=array();
	if(!empty($data['v_add'])){
	$uparray['AD']=1;	
	}
	else{
	$uparray['AD']=0;	
	}
	if(!empty($data['v_edit'])){
	$uparray['EDIT']=1;	
	}
	else{
	$uparray['EDIT']=0;		
	}
	if(!empty($data['v_delete'])){
	$uparray['DEL']=1;	
	}
	else{
	$uparray['DEL']=0;		
	}
	if(!empty($data['v_print'])){
	$uparray['PRNT']=1;	
	}
	else{
	$uparray['PRNT']=0;		
	}
	if(!empty($data['v_nav'])){
	$uparray['NAV']=1;	
	}
	else{
	$uparray['NAV']=0;		
	}
	if(!empty($data['vstatus'])){
	if($data['vstatus']==1){
	$uparray['UNPOSTED']=1;	
	$uparray['POSTED']=0;		
	$uparray['APPROVED']=0;	
	}
	else if($data['vstatus']==2){
	$uparray['UNPOSTED']=0;	
	$uparray['POSTED']=1;		
	$uparray['APPROVED']=0;	
	}
	else if($data['vstatus']==3){
	$uparray['UNPOSTED']=0;	
	$uparray['POSTED']=0;		
	$uparray['APPROVED']=1;	
	}
	}
	
	$dba=$this->getData("VOUCHER_RIGHTS",array("USR"=>$data['user'],"B_ID"=>$data['branch'],"MENU"=>$data['menu']),"","");
	if(empty($dba)){
	$uparray['USR']=$data['user'];	
	$uparray['B_ID']=$data['branch'];	
	$uparray['MENU']=$data['menu'];
	$this->db->insert('VOUCHER_RIGHTS',$uparray);	
	}
	else{
	$this->db->where(array("USR"=>$data['user'],"B_ID"=>$data['branch'],"MENU"=>$data['menu']));
	$this->db->update('VOUCHER_RIGHTS', $uparray);	
	}
	return true;
	}
	
	public function saveOtherRights($data){
	if(!empty($data['apromise'])){
	$promise=1;	
	}
	else{
	$promise=0;
	}
	if(!empty($data['dashboard'])){
	$dashboard=1;	
	}
	else{
	$dashboard=0;
	}
	if(!empty($data['pendingdc'])){
	$pendingdc=1;	
	}
	else{
	$pendingdc=0;
	}
	if(!empty($data['aactivity'])){
	$aactivity=1;	
	$actypes=implode(",",$data['actypes']);	
	}
	else{
	$aactivity=0;
	$actypes="";
	}
	$dba=$this->getData("OTHERRIGHTS",array("USR"=>$data['user']),"","");
	if(empty($dba)){
	$this->db->query("INSERT INTO OTHERRIGHTS(USR,PROMISES,ACCOUNTACTIVITY,ACCOUNTACTIVITYDATA,DASHBOARD,PENDINGDC) VALUES('".$data['user']."',$promise,$aactivity,'$actypes',$dashboard,$pendingdc)");	
	}
	else{
	$this->db->query("UPDATE OTHERRIGHTS SET PROMISES=$promise, ACCOUNTACTIVITY=$aactivity, ACCOUNTACTIVITYDATA='$actypes',DASHBOARD=$dashboard,PENDINGDC=$pendingdc WHERE USR='".$data['user']."'");
	}
	return true;
	}	
	
	}
?>