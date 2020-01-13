<?php
	class PayrollReportsModel extends MY_Model{
	
	public function loanAdvance($data){
		
	if($data['etype']==1){
	$br=implode(",",$data['employee']);
	$employee="AND T1.ID IN ($br)";
	}	
	else{
	$employee="";	
	}
	if($data['dptype']==1){
	$br=implode(",",$data['department']);
	$department="AND T1.DPID IN ($br)";
	}	
	else{
	$department="";	
	}
	if($data['dstype']==1){
	$br=implode(",",$data['designation']);
	$designation="AND T1.DSID IN ($br)";
	}	
	else{
	$designation="";	
	}
	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$result=$this->query("SELECT T1.NAME,T1.DESIGNATION,T1.DEPARTMENT,T1.BID,T2.No,T2.VDate,T2.Jo,T2.Descr,T2.Debit,T2.Credit,T2.LTYPE,T2.U_ID,T2.B_ID 
	FROM EMPLOYEE AS T1 INNER JOIN Gnrllgr_loan AS T2 ON T1.ID=T2.ACode
	LEFT JOIN ACCOUNT AS T3 ON T1.ID=T3.ACODE 
	WHERE T2.VDATE >='$date1' AND T2.VDATE <='$date2' 
	$employee $designation $department 
	ORDER BY T2.VDATE");

	return $result;
		
	}	
	
	public function salaryIncrement($data){
		
	if($data['etype']==1){
	$br=implode(",",$data['employee']);
	$employee="AND T1.ID IN ($br)";
	}	
	else{
	$employee="";	
	}
	if($data['dptype']==1){
	$br=implode(",",$data['department']);
	$department="AND T1.DPID IN ($br)";
	}	
	else{
	$department="";	
	}
	if($data['dstype']==1){
	$br=implode(",",$data['designation']);
	$designation="AND T1.DSID IN ($br)";
	}	
	else{
	$designation="";	
	}
	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$result=$this->query("SELECT T1.NAME,T1.DESIGNATION,T1.DEPARTMENT,T1.BID,T2.NO,T2.VDATE,T2.ECODE,T2.EMPLOYEE,T2.CSALARY,T2.ISALARY 
	FROM EMPLOYEE AS T1 INNER JOIN SALARYINC AS T2 ON T1.ID=T2.ECODE
	LEFT JOIN ACCOUNT AS T3 ON T1.ID=T3.ACODE 
	WHERE T2.VDATE >='$date1' AND T2.VDATE <='$date2' 
	$employee $designation $department 
	ORDER BY T2.VDATE");

	return $result;
		
	}	
	
	}
	
?>