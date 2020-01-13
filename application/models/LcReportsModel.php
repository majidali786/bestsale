<?php
	class LcReportsModel extends MY_Model{
		
	public function ledger($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	$branch='';	
	
	$lcno=$data['party'];
	$crm=$this->getData("LC1",array("LCNO"=>$lcno),"LCCODE","");
	if(!empty($crm)){
	$acode=$crm[0]['LCCODE'];	
	}
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,U_ID,B_ID,DATE1,DATE2,LCNO) SELECT '$acode','$aname',DEBIT,CREDIT,NO,Jo,VDATE,Descr,'".$this->userData['U_ID']."',B_ID,'$date1','$date2','$lcno' FROM Gnrllgr WHERE LCNO='$lcno' AND VDATE >='$date1' AND VDATE <='$date2' $branch 
	ORDER BY VDATE ASC");
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	
	return $query1;
	
	}	
	
	
	public function stockMovement($data){
		
	$this->deleteData("STKLGR",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['lctype']==1){
	$br=implode("','",$data['lcno']);
	$lcno="AND T3.LCNO IN ('$br')";
	}	
	else{
	$lcno="";	
	}
	$insert=$this->query("SELECT T3.B_ID,T3.COIL,T5.PNAME,T3.LCNO,T4.TBID,T4.TBRANCH,T4.LTYPE,SUM(T3.INQT)AS INQT,SUM(T3.OUTQT) AS OUTQT,SUM(T3.INWGHT) AS INWGHT
	,SUM(T3.OUTWGHT) AS OUTWGHT,SUM(T3.INWGHT-T3.OUTWGHT) AS INHANDWGHT,SUM(T3.INQT-T3.OUTQT) AS INHANDQT
	,(CASE WHEN SUM(T3.INQT)>0 THEN AVG(T3.RATE) ELSE 0 END) AS INRATE
	,(CASE WHEN SUM(T3.OUTQT)>0 THEN AVG(T3.RATE) ELSE 0 END) AS OUTRATE
	FROM STOCK_LC AS T3 LEFT JOIN ((SELECT T1.NO,T1.JO,T1.B_ID,T1.COIL,T1.LCNO,T2.TBID,T2.TBRANCH,T2.LTYPE FROM 
	(SELECT NO,JO,B_ID,COIL,LCNO FROM STOCK_LC GROUP BY NO,JO,B_ID,COIL,LCNO HAVING SUM(OUTWGHT)>0)
	AS T1  INNER JOIN ((SELECT NO,B_ID,TBID,TBRANCH,'LT' AS JO,'1' AS LTYPE FROM LCSTRNF1) UNION
	(SELECT NO,B_ID,VCODE,VNAME,'LS' AS JO,'3' AS LTYPE FROM LCSALE1))
	AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID AND T1.JO=T2.JO)
	UNION (SELECT T1.NO,T1.JO,T1.B_ID,T1.COIL,T1.LCNO,T2.BNID,T2.LCBOND,T2.LTYPE FROM 
	(SELECT T1.NO,T1.JO,T1.B_ID,T2.COIL,T2.LCNO FROM STOCK_LC AS T1 INNER JOIN (SELECT COIL,LCNO FROM STOCK_LC GROUP BY COIL,LCNO HAVING SUM(OUTWGHT)<=0) AS T2
	ON T1.COIL=T2.COIL AND T1.LCNO=T2.LCNO
	GROUP BY T1.NO,T1.JO,T1.B_ID,T2.COIL,T2.LCNO HAVING SUM(OUTWGHT)<=0)
	AS T1  INNER JOIN (SELECT NO,B_ID,BNID,LCBOND,'PL' AS JO,'2' AS LTYPE FROM LCPURCH1)
	AS T2 ON T1.NO=T2.NO AND T1.B_ID=T2.B_ID AND T1.JO=T2.JO)) AS T4 ON T3.B_ID=T4.B_ID AND T3.LCNO=T4.LCNO AND T3.COIL=T4.COIL
	LEFT JOIN LC2 T5 on T3.COIL = T5.COIL
	WHERE T3.COIL IS NOT NULL AND T3.VDATE>='$date1' AND T3.VDATE<='$date2' $lcno
	GROUP BY T3.B_ID,T3.COIL,T5.PNAME,T3.LCNO,T4.TBID,T4.TBRANCH,T4.LTYPE");
	
	//$query1=$this->query("SELECT * FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	return $insert;
	
	}
	
	
	}
	
?>