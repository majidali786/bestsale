<?php
	class PromiseReportsModel extends MY_Model{			
	
	
	public function promises($data){
		
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch='';	
	}
	else{
	$branch="AND B_ID='".$data['branch']."'";	
	}
	$party="";
	if($data['ptype']==1){
	$br=implode("','",$data['party']);
	$party="AND ACODE IN ('$br')";
	}
	if($data['rtype']==2){
	$rtype="";	
	}
	else{
	$rtype="AND STATUS='".$data['rtype']."'";	
	}
	if($data['dtype']==1){
	$dtype="VDATE";	
	}
	else if($data['dtype']==2){
	$dtype="PDATE";	
	}
	else{
	$dtype="PMDATE";	
	}
		
	$query1=$this->query("SELECT * FROM PROMISE
	WHERE CONVERT(date, $dtype)>='$date1' AND CONVERT(date, $dtype)<='$date2'  $branch $rtype $party
	ORDER BY NO ASC
	");
	$data2=array();
	foreach($query1 as $a){
	$response=$this->query("SELECT * FROM PROMISECOMMENT
	WHERE PNO='".$a['NO']."' AND B_ID='".$a['B_ID']."'
	ORDER BY SNO ASC
	");
	$data2[$a['NO']."-".$a['B_ID']]=$response;
	}	
	return array("data1"=>$query1,"data2"=>$data2);
	}
	
	
	}
	
?>