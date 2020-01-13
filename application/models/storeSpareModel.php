<?php
	class storeSpareModel extends MY_Model{
		
	public function insertProduct($data)
	{	
	$a=explode("-",$data['mgroup']);
	$mgid=$a[0];
	$mgroup=$a[1];
	$inid=0;
	$itemname="";
	if($data['itemname']!='0')
	{
	$a=explode("-",$data['itemname']);
	$inid=$a[0];
	$itemname=$a[1];	
	}
	$sid=0;
	$size="";
	if($data['size']!='0')
	{
	$a=explode("-",$data['size']);
	$sid=$a[0];
	$size=$a[1];	
	}	
	$nid=0;
	$nature="";
	if($data['nature']!='0')
	{
	$a=explode("-",$data['nature']);
	$nid=$a[0];
	$nature=$a[1];	
	}		
	$fid=0;
	$feet="";
	if($data['feet']!='0')
	{
	$a=explode("-",$data['feet']);
	$fid=$a[0];
	$feet=$a[1];	
	}	
	$uid=0;
	$unit="";
	if($data['unit']!='0')
	{
	$a=explode("-",$data['unit']);
	$uid=$a[0];
	$unit=$a[1];	
	}	
	$wid=0;
	$weight="";
	if($data['weight']!='0')
	{
	$a=explode("-",$data['weight']);
	$wid=$a[0];
	$weight=$a[1];	
	}
	$o1id=0;
	$others1="";
	if($data['others1']!='0')
	{
	$a=explode("-",$data['others1']);
	$o1id=$a[0];
	$others1=$a[1];	
	}
	$o2id=0;
	$others2="";
	if($data['others2']!='0')
	{
	$a=explode("-",$data['others2']);
	$o2id=$a[0];
	$others2=$a[1];	
	}
	$o3id=0;
	$others3="";
	if($data['others3']!='0')
	{
	$a=explode("-",$data['others3']);
	$o3id=$a[0];
	$others3=$a[1];	
	}

	
	$inc_itemname=0;
	if(!empty($data['inc_itemname'])){
	$inc_itemname=1;	
	}	
	$inc_size=0;
	if(!empty($data['inc_size'])){
	$inc_size=1;	
	}
	$inc_feet=0;
	if(!empty($data['inc_feet'])){
	$inc_feet=1;	
	}
	$inc_nature=0;
	if(!empty($data['inc_nature'])){
	$inc_nature=1;	
	}
	$inc_unit=0;
	if(!empty($data['inc_unit'])){
	$inc_unit=1;	
	}
	$inc_weight=0;
	if(!empty($data['inc_weight'])){
	$inc_weight=1;	
	}
	$inc_others1=0;
	if(!empty($data['inc_others1'])){
	$inc_others1=1;	
	}
	$inc_others2=0;
	if(!empty($data['inc_others2'])){
	$inc_others2=1;	
	}
	$inc_others3=0;
	if(!empty($data['inc_others3'])){
	$inc_others3=1;	
	}
	
	
	$run = $this->db->query("INSERT INTO SSPRODUCT(PCODE,PNAME,MGID,MGROUP,INID,ITEMNAME,SID,SIZE,NID,NATURE,FID,FEET,UID,UNIT,WID,WEIGHT,O1ID,OTHERS1,O2ID,OTHERS2,O3ID,OTHERS3,INC_ITEMNAME,INC_SIZE,INC_NATURE,INC_FEET,INC_UNIT,INC_WEIGHT,INC_OTHERS1,INC_OTHERS2,INC_OTHERS3) VALUES ('".$data['code']."','".$data['name']."','$mgid','$mgroup','$inid','$itemname','$sid','$size','$nid','$nature','$fid','$feet','$uid','$unit','$wid','$weight','$o1id','$others1','$o2id','$others2','$o3id','$others3','$inc_itemname','$inc_size','$inc_nature','$inc_feet','$inc_unit','$inc_weight','$inc_others1','$inc_others2','$inc_others3')");
	return true;	
	}
	
	public function updateProduct($data)
	{
	$inc_itemname=0;
	if(!empty($data['inc_itemname'])){
	$inc_itemname=1;	
	}	
	$inc_size=0;
	if(!empty($data['inc_size'])){
	$inc_size=1;	
	}
	$inc_feet=0;
	if(!empty($data['inc_feet'])){
	$inc_feet=1;	
	}
	$inc_nature=0;
	if(!empty($data['inc_nature'])){
	$inc_nature=1;	
	}
	$inc_unit=0;
	if(!empty($data['inc_unit'])){
	$inc_unit=1;	
	}
	$inc_weight=0;
	if(!empty($data['inc_weight'])){
	$inc_weight=1;	
	}
	$inc_others1=0;
	if(!empty($data['inc_others1'])){
	$inc_others1=1;	
	}
	$inc_others2=0;
	if(!empty($data['inc_others2'])){
	$inc_others2=1;	
	}
	$inc_others3=0;
	if(!empty($data['inc_others3'])){
	$inc_others3=1;	
	}
	$run = $this->db->query("UPDATE SSPRODUCT SET PNAME='".$data['name']."',INC_ITEMNAME=$inc_itemname,INC_SIZE=$inc_size,INC_NATURE=$inc_nature,INC_FEET=$inc_feet,INC_UNIT=$inc_unit,INC_WEIGHT=$inc_weight,INC_OTHERS1=$inc_others1,INC_OTHERS2=$inc_others2,INC_OTHERS3=$inc_others3 WHERE PCODE='".$data['id']."'");
	return true;		
	}
		
	public function insertMainGroup($data)
	{
	$max = $this->getMax("SSMGROUP","ID","");
	$run = $this->db->query("INSERT INTO SSMGROUP(ID,SSMGROUP) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateMainGroup($data)
	{
	$run = $this->db->query("UPDATE SSMGROUP SET SSMGROUP='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertItemName($data)
	{
	$max = $this->getMax("SSINAME","ID","");
	$run = $this->db->query("INSERT INTO SSINAME(ID,SSINAME) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateItemName($data)
	{
	$run = $this->db->query("UPDATE SSINAME SET SSINAME='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertSize($data)
	{
	$max = $this->getMax("SSSIZE","ID","");
	$run = $this->db->query("INSERT INTO SSSIZE(ID,SSSIZE) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateSize($data)
	{
	$run = $this->db->query("UPDATE SSSIZE SET SSSIZE='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
		
	public function insertFeet($data)
	{
	$max = $this->getMax("SSFEET","ID","");
	$run = $this->db->query("INSERT INTO SSFEET(ID,SSFEET) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateFeet($data)
	{
	$run = $this->db->query("UPDATE SSFEET SET SSFEET='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertUnit($data)
	{
	$max = $this->getMax("SSUNIT","ID","");
	$run = $this->db->query("INSERT INTO SSUNIT(ID,SSUNIT) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateUnit($data)
	{
	$run = $this->db->query("UPDATE SSUNIT SET SSUNIT='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertNature($data)
	{
	$max = $this->getMax("SSNATURE","ID","");
	$run = $this->db->query("INSERT INTO SSNATURE(ID,SSNATURE) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateNature($data)
	{
	$run = $this->db->query("UPDATE SSNATURE SET SSNATURE='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertWeight($data)
	{
	$max = $this->getMax("SSWEIGHT","ID","");
	$run = $this->db->query("INSERT INTO SSWEIGHT(ID,SSWEIGHT) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateWeight($data)
	{
	$run = $this->db->query("UPDATE SSWEIGHT SET SSWEIGHT='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertOthers1($data)
	{
	$max = $this->getMax("SSOTHERS1","ID","");
	$run = $this->db->query("INSERT INTO SSOTHERS1(ID,SSOTHERS1) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateOthers1($data)
	{
	$run = $this->db->query("UPDATE SSOTHERS1 SET SSOTHERS1='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertOthers2($data)
	{
	$max = $this->getMax("SSOTHERS2","ID","");
	$run = $this->db->query("INSERT INTO SSOTHERS2(ID,SSOTHERS2) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	public function updateOthers2($data)
	{
	$run = $this->db->query("UPDATE SSOTHERS2 SET SSOTHERS2='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertOthers3($data)
	{
	$max = $this->getMax("SSOTHERS3","ID","");
	$run = $this->db->query("INSERT INTO SSOTHERS3(ID,SSOTHERS3) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	
	public function updateOthers3($data)
	{
	$run = $this->db->query("UPDATE SSOTHERS3 SET SSOTHERS3='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	
	
	
	
	
	}
?>