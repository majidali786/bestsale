<?php
	class memoReportsModel extends MY_Model{
	
	public function invoiceDetail($data){
		
	$this->deleteData("Lgrrep",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	$insert=$this->db->query("INSERT INTO Lgrrep(ACODE,ANAME,DEBIT,CREDIT,NO,JO,VDATE,DESCR,U_ID,B_ID,DATE1,DATE2,CDAYS) SELECT ACCOUNT.ACODE AS ACODE,ACCOUNT.ANAME,Gnrllgr.DEBIT,Gnrllgr.CREDIT,Gnrllgr.NO,Gnrllgr.Jo,Gnrllgr.VDATE,Gnrllgr.Descr,'".$this->userData['U_ID']."',Gnrllgr.B_ID,'$date1','$date2',T3.NO FROM Gnrllgr INNER JOIN ACCOUNT ON ACCOUNT.ACODE=Gnrllgr.ACode
	LEFT JOIN ( SELECT NO,B_ID FROM MEMO1 WHERE CACODE='".$data['party']."' GROUP BY NO,B_ID) AS T3 ON Gnrllgr.MNO=T3.NO AND Gnrllgr.B_ID=T3.B_ID
	WHERE ACCOUNT.LEVL=4 AND Gnrllgr.ACODE='".$data['party']."' AND Gnrllgr.VDATE >='$date1' AND Gnrllgr.VDATE <='$date2' AND Gnrllgr.MNO <>'' AND Gnrllgr.MNO IS NOT NULL 
	ORDER BY Gnrllgr.B_ID,Gnrllgr.NO,Gnrllgr.VDATE ASC");
	
	$query1=$this->query("SELECT * FROM Lgrrep WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	
	return $query1;
	
	}
	
	
	}
	
?>