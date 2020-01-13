<?php
	class PromiseModel extends MY_Model{
		
	public function insertComment($data)
	{
	$voucher_Jo="PC";
	$gnrllgr="Gnrllgr_promise";		
	$max = $this->getMax("PROMISECOMMENT","NO",array("B_ID"=>$this->userData['B_ID']));
	$vdate=date("Y-m-d H:i:s");
	$pamount=removecommas($data['pamount']);
	$eamount=removecommas($data['eamount']);
	$edate="";
	if(!empty($data['edate'])){
	$edate=$this->dateFormat($data['edate']);
	}
	$run = $this->db->query("INSERT INTO PROMISECOMMENT(NO,VDATE,DESCR,PAMOUNT,EAMOUNT,EDATE,sno,U_ID,B_ID,STATUS,PNO) VALUES ('$max','$vdate','".$data['description']."','$pamount','$eamount','$edate','1','".$this->userData['U_ID']."','".$this->userData['B_ID']."','".$data['cstatus']."','".$data['pno']."')");
	$cnm=$this->getData("PROMISE",array("NO"=>$data['pno'],"B_ID"=>$this->userData['B_ID']),"ACODE","");
	if(!empty($cnm)){
	$acode=$cnm[0]['ACODE'];	
	}
	if($data['cstatus']==0){
	$this->db->query("UPDATE PROMISE SET STATUS=0 WHERE NO='".$data['pno']."' AND B_ID='".$this->userData['B_ID']."'");	
	}
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(NO,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,PMDATE,PDATE,PNO,SNO,PAMOUNT) VALUES($max,'$vdate','$voucher_Jo','$acode','".$data['description']."',0,$pamount,'".$this->userData['B_ID']."','$vdate','$edate','".$data['pno']."',$max,'$eamount')");
	
	return true;	
	}
	public function updateComment($data)
	{
	$voucher_Jo="PC";
	$gnrllgr="Gnrllgr_promise";		
	$pamount=removecommas($data['pamount']);
	$eamount=removecommas($data['eamount']);
	$edate="";
	if(!empty($data['edate'])){
	$edate=$this->dateFormat($data['edate']);
	}	
	if($data['cstatus_e']==0){
	$this->db->query("UPDATE PROMISE SET STATUS=0 WHERE NO='".$data['pno']."' AND B_ID='".$this->userData['B_ID']."'");	
	}
	else{
	$this->db->query("UPDATE PROMISE SET STATUS=1 WHERE NO='".$data['pno']."' AND B_ID='".$this->userData['B_ID']."'");	
	}
	
	
	$this->db->query("UPDATE PROMISECOMMENT SET DESCR='".$data['description']."',PAMOUNT='$pamount',EAMOUNT='$eamount',EDATE='$edate',STATUS='".$data['cstatus_e']."' WHERE NO='".$data['no']."' AND B_ID='".$this->userData['B_ID']."'");
	
	$this->db->query("UPDATE $gnrllgr SET Descr='".$data['description']."',Credit='$pamount',PAMOUNT='$eamount',PDATE='$edate' WHERE NO='".$data['no']."' AND B_ID='".$this->userData['B_ID']."' AND JO='$voucher_Jo'");	
	
	return true;		
	}	
}
	