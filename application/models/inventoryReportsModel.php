<?php
	class InventoryReportsModel extends MY_Model{
		
	public function balance($data){
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND STOCK.B_ID='".$data['branch']."'";		
	}
	
	if($data['ptype']==1){
	$br=implode(",",$data['party']);
	$design="AND DESIGN.ID IN ($br)";
	}	
	else{
	$design="";	
	}
	
	$this->deleteData("STKLGR",array("U_ID"=>$this->userData['U_ID']));
	$vdate=$data['vdate'];
/* 	
	$insert=$this->db->query("INSERT INTO STKLGR(PCODE,PNAME,UNIT,SIZE,COLOR,B_ID,QTY,U_ID,DATE1) 
	SELECT T2.PCODE,T2.PNAME,T2.UNIT,T2.SIZE,T2.COLOR,T1.B_ID,SUM(T1.INQT-T1.OUTQT) AS TQT
	,'".$this->userData['U_ID']."','$vdate' FROM STOCK AS T1 INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE
	WHERE T2.PCODE IS NOT NULL AND T1.VDATE <='$vdate' $branch 
	GROUP BY T2.PCODE,T2.PNAME,T2.UNIT,T2.SIZE,T2.COLOR,T1.B_ID HAVING SUM(T1.INQT-T1.OUTQT)<>0  ORDER BY T2.PNAME ASC");
	 */
	 
	 $insert=$this->db->query("INSERT INTO STKLGR(PCODE,PNAME,UNIT,SIZE,COLOR,DESIGN,IMG,B_ID,QTY,U_ID,DATE1) 
	 SELECT     dbo.PRODUCT.PCODE, dbo.PRODUCT.PNAME, dbo.PRODUCT.UNIT, dbo.PRODUCT.SIZE, dbo.PRODUCT.COLOR, dbo.PRODUCT.DESIGN, 
                      dbo.DESIGN.IMG, dbo.STOCK.B_ID, SUM(dbo.STOCK.INQT - dbo.STOCK.OUTQT) AS QTY,'".$this->userData['U_ID']."','$vdate'
FROM         dbo.PRODUCT INNER JOIN
                      dbo.STOCK ON dbo.PRODUCT.PCODE = dbo.STOCK.PCODE INNER JOIN
                      dbo.DESIGN ON dbo.PRODUCT.DID = dbo.DESIGN.ID
					  WHERE  STOCK.VDATE <='$vdate' $branch $design
					  
GROUP BY dbo.PRODUCT.PCODE, dbo.PRODUCT.PNAME, dbo.PRODUCT.UNIT, dbo.PRODUCT.SIZE, dbo.PRODUCT.DID, dbo.PRODUCT.DESIGN, dbo.DESIGN.IMG, dbo.STOCK.B_ID, 
                      dbo.PRODUCT.COLOR
HAVING      SUM(dbo.STOCK.INQT - dbo.STOCK.OUTQT) > 0");

	$query1=$this->query("SELECT PCODE,PNAME,UNIT,SIZE,COLOR,DESIGN,IMG FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."'
	GROUP BY PCODE,PNAME,UNIT,SIZE,COLOR,DESIGN,IMG ORDER BY PNAME ASC");
	$query2=$this->query("SELECT PCODE,QTY,B_ID,UNIT,SIZE,COLOR,COLOR,DESIGN,IMG FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."'
	GROUP BY PCODE,UNIT,SIZE,COLOR,QTY,B_ID,DESIGN,IMG ORDER BY PCODE ASC");
	
	return array($query1,$query2);
	
	
	}		
		
	public function movement($data){
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND T1.B_ID='".$data['branch']."'";		
	}
	$this->deleteData("STKLGR",array("U_ID"=>$this->userData['U_ID']));
	$vdate1=$data['date1'];
	$vdate2=$data['date2'];
	
	$insert=$this->db->query("INSERT INTO STKLGR(PCODE,PNAME,UNIT,B_ID,INQT,QTY,OUTQT,U_ID,DATE1,DATE2) 
	SELECT T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID,
	SUM(case when T1.VDATE>='$vdate1' then T1.INQT-T1.OUTQT else 0 end ) AS TQT_op,
	SUM(case when T1.VDATE>='$vdate1' and T1.VDATE<='$vdate2' then T1.INQT-T1.OUTQT else 0 end ) AS TQT_du,
	SUM(case when T1.VDATE>='$vdate2' then T1.INQT-T1.OUTQT else 0 end ) AS TQT_cl 

	,'".$this->userData['U_ID']."','$vdate1','$vdate2' FROM STOCK AS T1 INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE 
	WHERE T2.PCODE IS NOT NULL $branch GROUP BY T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID HAVING SUM(T1.INQT-T1.OUTQT)<>0  ORDER BY T2.PNAME ASC");
	
	$query2=$this->query("SELECT PCODE,PNAME,UNIT,INQT,QTY,OUTQT,B_ID FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."' 
	GROUP BY PCODE,PNAME,UNIT,INQT,QTY,OUTQT,B_ID ORDER BY PCODE ASC");
	
	return array($query2);
	
	}	
public function amount($data){
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND T1.B_ID='".$data['branch']."'";		
	}
	
	$this->deleteData("STKLGR",array("U_ID"=>$this->userData['U_ID']));
	$vdate=$data['vdate'];
	
	if($data['rtype']!=1){
	$insert=$this->db->query("INSERT INTO STKLGR(PCODE,PNAME,UNIT,B_ID,QTY,RATE,U_ID,DATE1) SELECT T2.PCODE,T2.PNAME
	,T2.UNIT,T1.B_ID,SUM(T1.INQT-T1.OUTQT) AS TQT
	,(SELECT (sum(INAMT)/sum(INQT)) as RATE  from stock where JO IN ('PU','OS') and PCODE=T2.PCODE) 
	,'".$this->userData['U_ID']."','$vdate' FROM STOCK AS T1 INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE WHERE T2.PCODE
	IS NOT NULL AND T1.VDATE <='$vdate' $branch  GROUP BY T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID HAVING SUM(T1.INQT-T1.OUTQT)>0 
	ORDER BY T2.PNAME ASC");

	}	else if($data['rtype']==1) {
	$insert=$this->db->query("INSERT INTO STKLGR(PCODE,PNAME,UNIT,B_ID,QTY,RATE,U_ID,DATE1) 
	SELECT T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID,SUM(T1.INQT-T1.OUTQT) AS TQT,(SELECT (sum(INAMT)/sum(INQT)) 
	
	from stock where JO IN ('PU','OS') and PCODE=T2.PCODE) as RATE,'".$this->userData['U_ID']."','$vdate'

	FROM STOCK AS T1 INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE WHERE T2.PCODE IS NOT NULL AND T1.VDATE <='$vdate' $branch 
	GROUP BY T2.PCODE,T2.PNAME,T2.UNIT,T1.B_ID HAVING SUM(T1.INQT-T1.OUTQT)<>0 ORDER BY T2.PNAME ASC");
	}
	
	$query1=$this->query("SELECT PCODE,PNAME,UNIT,RATE FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."' GROUP BY PCODE,PNAME,UNIT,RATE ORDER BY PNAME ASC");
	$query2=$this->query("SELECT PCODE,QTY,RATE,B_ID FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."' GROUP BY PCODE,QTY,RATE,B_ID ORDER BY PCODE ASC");
	
	return array($query1,$query2);
	
	}

	
	public function StockTransferlist($data){
		
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND STRNF1.B_ID='".$data['branch']."'";		
	}

	
	
	$date1=$data['date1'];
	$date2=$data['date2'];
	
	$result=$this->query("SELECT      dbo.STRNF1.NO, dbo.STRNF1.VDATE, 
	dbo.STRNF1.FBRANCH, dbo.STRNF1.TBRANCH, dbo.STRNF2.PCODE, dbo.STRNF2.PNAME, dbo.STRNF2.UNIT, dbo.STRNF2.QTY,dbo.STRNF1.B_ID
FROM         dbo.STRNF1 INNER JOIN
                      dbo.STRNF2 ON dbo.STRNF1.NO = dbo.STRNF2.NO AND dbo.STRNF1.B_ID = dbo.STRNF2.B_ID
					  
					  WHERE dbo.STRNF1.VDATE >='$date1' AND dbo.STRNF1.VDATE <='$date2' $branch
GROUP BY  dbo.STRNF1.NO, dbo.STRNF1.VDATE, dbo.STRNF1.FBRANCH, dbo.STRNF1.TBRANCH, 
dbo.STRNF2.PCODE, dbo.STRNF2.PNAME, dbo.STRNF2.UNIT, dbo.STRNF2.QTY,dbo.STRNF1.B_ID
	");

	return $result;
		
	}	
	
	public function ledger($data){
		
	$this->deleteData("STKLGR",array("U_ID"=>$this->userData['U_ID']));
	$date1=$data['date1'];
	$date2=$data['date2'];
	if($data['branch']==0){
	$branch="";	
	}
	else{
	$branch="AND T1.B_ID='".$data['branch']."'";		
	}
	$insert=$this->db->query("INSERT INTO STKLGR(NO,JO,VDATE,DESCR,PCODE,PNAME,UNIT,INQT,OUTQT,B_ID,U_ID,DATE1,DATE2) SELECT T1.NO,T1.JO,T1.VDATE
	,T1.DESCR,T2.PCODE,T2.PNAME,T2.UNIT,T1.INQT,T1.OUTQT,T1.B_ID,'".$this->userData['U_ID']."','$date1','$date2' FROM STOCK AS T1 
	INNER JOIN PRODUCT AS T2 ON T1.PCODE=T2.PCODE WHERE T2.PCODE IS NOT NULL AND T1.VDATE >='$date1' AND T1.VDATE <='$date2' 
	AND T1.PCODE='".$data['product']."' $branch");
	
	$query1=$this->query("SELECT * FROM STKLGR WHERE U_ID='".$this->userData['U_ID']."'  ORDER BY VDATE ASC");
	return $query1;
	}
		
}