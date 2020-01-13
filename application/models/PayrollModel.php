<?php
	class PayrollModel extends MY_Model{
		
	public function insertDepartment($data){
	$max = $this->getMax("UDEPT","ID","");
	$run = $this->db->query("INSERT INTO UDEPT(ID,UDEPT) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	
	public function updateDepartment($data){
	$run = $this->db->query("UPDATE UDEPT SET UDEPT='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertDesignation($data){
	$max = $this->getMax("UDESIG","ID","");
	$run = $this->db->query("INSERT INTO UDESIG(ID,UDESIG) VALUES ('".$max."','".$data['name']."')");
	return true;	
	}
	
	public function updateDesignation($data){
	$run = $this->db->query("UPDATE UDESIG SET UDESIG='".$data['name']."' WHERE ID='".$data['id']."'");
	return true;		
	}
	
	public function insertSalaryInfo($data){
	$id=$data['employee'];	
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$id),"ANAME","");
	$name=$cnm[0]['ANAME'];
	$basic=$data['basic'];	
	$callowance=$data['callowance'];	
	$conveyance=$data['conveyance'];	
	$utility=$data['utility'];	
	$overtime=$data['overtime'];	
	$loan=$data['loan'];	
	$advance=$data['advance'];	
	$incometax=$data['incometax'];	
	$leave=$data['leave'];	
	$eobi=$data['eobi'];	
	$tallowance=$data['tallowances'];	
	$gpay=$data['gpay'];	
	$tdeduction=$data['tdeduction'];	
	$npay=$data['npay'];	
	$yleave=$data['yleave'];
	$whours=$data['whours'];
	$check=$this->getData("SALARYINFO",array("ID"=>$id),"","");
	if(empty($check)){
	$run = $this->db->query("INSERT INTO SALARYINFO(ID,NAME,BASIC,CALLOWANCE,CONVEYANCE,UTILITY,OVERTIME,LOAN,ADVANCE,INCOMETAX,
	LEAVE,EOBI,TALLOWANCE,GPAY,TDEDUCTION,NPAY,YLEAVE,WHOURS)
	VALUES ('$id','$name','$basic','$callowance','$conveyance','$utility','$overtime','$loan','$advance','$incometax','$leave'
	,'$eobi','$tallowance','$gpay','$tdeduction','$npay','$yleave','$whours')");
	}
	else{
	$run = $this->db->query("UPDATE SALARYINFO SET NAME='$name',BASIC='$basic',CALLOWANCE='$callowance',CONVEYANCE='$conveyance'
	,UTILITY='$utility',OVERTIME='$overtime',LOAN='$loan',ADVANCE='$advance',INCOMETAX='$incometax',LEAVE='$leave',EOBI='$eobi'
	,TALLOWANCE='$tallowance',GPAY='$gpay',TDEDUCTION='$tdeduction',NPAY='$npay',YLEAVE='$yleave',WHOURS='$whours' WHERE ID='$id'");	
	}
	return true;		
	}
	
	public function insertLoan($data){		
	$mainTable="LOAN";
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="LN";
	$post_type;	
	
	if($data['action']=="save"){	
	$no=$data['no'];	
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	if($data['no']>$max || $data['no']<=0){
	$no=$max;	
	}
	$check1=$this->getData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($check1)){
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$no=$max;	
	}
	}
	else{
	$no=$data['no'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgrloan",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	}
	
	if(!empty($data['rights'])){
	if($data['rights']['UNPOSTED']==1){
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";		
	$post_type=1;		
	}
	else if($data['rights']['POSTED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved="";	
	$post_type=2;	
	}
	else if($data['rights']['APPROVED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved=$this->userData['U_ID'];
	$post_type=3;	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";
	$post_type=1;	
	}	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";			
	$post_type=1;
	}
	
	$vdate=$this->dateFormat($data['vdate']);
	$ecode=$data['ecode'];
	$crm=$this->getData("ACCOUNT",array("ACODE"=>$ecode),"ANAME","");
	if(!empty($crm)){
	$employee=$crm[0]['ANAME'];	
	}
	$acode=$data['acode'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	
	$loan=removecommas($data['amount']);
	$type=$data['type'];
	$atype=$data['atype'];
	$ninstall=removecommas($data['ninstall']);
	$pminstall=removecommas($data['pminstall']);
	$tp=array("","Short Term Loan","Long Term Loan","Advance");
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,TYPE,ATYPE,ECODE,EMPLOYEE,ACODE,ANAME,LOAN,NINSTALL,PMINSTALL
	,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$type','$atype','$ecode','$employee','$acode','$aname','$loan'
	,'$ninstall','$pminstall','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$descrip1="".$tp[$type]." To $employee";
	$descrip2="".$tp[$type]." From $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip1',0,$loan,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$ecode','$descrip2',$loan,0,'".$this->userData['B_ID']."')");
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE,STYPE) 
	VALUES ('$no','$vdate','$voucher_Jo','$ecode','$descrip2',$loan,0,'".$this->userData['B_ID']."','$type','$atype')");
	}
	}
	
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	
	public function insertLoanPayment($data){
			
	$mainTable="LOANPAYMENT";
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="LP";
	$post_type;	
	
	if($data['action']=="save"){	
	$no=$data['no'];	
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	if($data['no']>$max || $data['no']<=0){
	$no=$max;	
	}
	$check1=$this->getData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($check1)){
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$no=$max;	
	}
	}
	else{
	$no=$data['no'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	$this->deleteData("$gnrllgrloan",array("Jo"=>"$voucher_Jo","NO"=>$no,"B_ID"=>$this->userData['B_ID']));	
	}
	
	if(!empty($data['rights'])){
	if($data['rights']['UNPOSTED']==1){
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";		
	$post_type=1;		
	}
	else if($data['rights']['POSTED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved="";	
	$post_type=2;	
	}
	else if($data['rights']['APPROVED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved=$this->userData['U_ID'];
	$post_type=3;	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";
	$post_type=1;	
	}	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";			
	$post_type=1;
	}
	
	$vdate=$this->dateFormat($data['vdate']);
	$ecode=$data['ecode'];
	$crm=$this->getData("ACCOUNT",array("ACODE"=>$ecode),"ANAME","");
	if(!empty($crm)){
	$employee=$crm[0]['ANAME'];	
	}
	$acode=$data['acode'];
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	
	$loan=removecommas($data['amount']);
	$type=$data['type'];
	$tp=array("","Short Term Loan","Long Term Loan","Advance");
	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,TYPE,ECODE,EMPLOYEE,ACODE,ANAME,LOAN,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$type','$ecode','$employee','$acode','$aname','$loan','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$descrip1="".$tp[$type]." Payment From $employee";
	$descrip2="".$tp[$type]." Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$acode','$descrip1',$loan,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('$no','$vdate','$voucher_Jo','$ecode','$descrip2',0,$loan,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('$no','$vdate','$voucher_Jo','$ecode','$descrip2',0,$loan,'".$this->userData['B_ID']."',$type)");
	}
	}
	
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	return true;	
	}
	
	public function insertSalarySheet($data){
	
	$mainTable="SALARYSHEET";
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="SS";
	$post_type=2;	
	
	$vdate=$this->dateFormat($data['date']);
	$vdate1=date("Y-m-d",strtotime("+1 month",strtotime($vdate)));
	$vdate2=date("Y-m-d",strtotime("+2 month",strtotime($vdate)));
	
	$del=$this->db->query("DELETE FROM $mainTable WHERE DATEPART(MONTH,VDATE)='".date("m",strtotime($vdate))."' and DATEPART(YEAR,VDATE)='".date("Y",strtotime($vdate))."' ");
	$del2=$this->db->query("DELETE FROM $gnrllgr WHERE DATEPART(MONTH,VDATE)='".date("m",strtotime($vdate))."' and DATEPART(YEAR,VDATE)='".date("Y",strtotime($vdate))."' AND Jo='$voucher_Jo' AND NO=1");
	$del3=$this->db->query("DELETE FROM $gnrllgrloan WHERE DATEPART(MONTH,VDATE)='".date("m",strtotime($vdate))."' and DATEPART(YEAR,VDATE)='".date("Y",strtotime($vdate))."' AND Jo='$voucher_Jo' AND NO=1");
	$nrows=$data['trows'];
	$row=1;
	while($row<$nrows){
	
	if(removecommas($data['gpay_'.$row])>0){
	
	$ecode=$data['id_'.$row];
	$crm=$this->getData("ACCOUNT",array("ACODE"=>$ecode),"ANAME","");
	if(!empty($crm)){
	$employee=$crm[0]['ANAME'];	
	}
	$basic=removecommas($data['basic_'.$row]);
	$wdays=removecommas($data['wdays_'.$row]);
	$whours=removecommas($data['whours_'.$row]);
	$ohours=removecommas($data['hours_'.$row]);
	$oamount=removecommas($data['oamount_'.$row]);
	$tltloan=removecommas($data['tltl_'.$row]);
	$ltloan=removecommas($data['ltermded_'.$row]);
	$tstloan=removecommas($data['tstl_'.$row]);
	$stloan=removecommas($data['stermded_'.$row]);
	$tadvance=removecommas($data['tadvance_'.$row]);
	$advance=removecommas($data['advanceded_'.$row]);
	$gross=removecommas($data['gpay_'.$row]);
	$net=removecommas($data['npay_'.$row]);
	$total=removecommas($data['tpay_'.$row]);
	
	$cltloan=1;
	$cstloan=1;
	$cadvance=1;
	
	$insert=$this->db->query("INSERT INTO SALARYSHEET(VDATE,ECODE,EMPLOYEE,BASIC,WDAYS,WHOURS,OHOURS,OAMOUNT,TLTLOAN,LTLOAN,TSTLOAN
	,STLOAN,TADVANCE,ADVANCE,CLTLOAN,CSTLOAN,CADVANCE,GROSS,NET,TOTAL,B_ID) VALUES('$vdate','$ecode','$employee','$basic','$wdays'
	,'$whours','$ohours','$oamount','$tltloan','$ltloan','$tstloan','$stloan','$tadvance','$advance','$cltloan','$cstloan','$cadvance'
	,'$gross','$net','$total','".$this->userData['B_ID']."')");
	
	if($insert){

	$acode=40201026;
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}	
		
	if($ltloan>0){

	$descrip1="Long Term Loan Payment From $employee";
	$descrip2="Long Term Loan Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) 
	VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$ltloan,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) 
	VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$ltloan,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE)
	VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$ltloan,'".$this->userData['B_ID']."',2)");

	}
	if($stloan>0){
	
	$descrip1="Short Term Loan Payment From $employee";
	$descrip2="Short Term Loan Payment To $aname";
	
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) 
	VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$stloan,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) 
	VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$stloan,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) 
	VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$stloan,'".$this->userData['B_ID']."',1)");
	
	}
	if($advance>0){
	
	$descrip1="Advance From $employee";
	$descrip2="Advance Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) 
	VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$advance,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) 
	VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$advance,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) 
	VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$advance,'".$this->userData['B_ID']."',3)");
	
	}
	
		
	}
	
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE)
	VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','1','$voucher_Jo','$post_type')");
	return true;
	}
	
	public function insertPaymentContract($data){
	
	$mainTable="PAYMENTCONTRACT";
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="PC";
	$post_type=2;	
	
	$sdate=$data['date1'];
	$edate=$data['date2'];
	$del=$this->db->query("DELETE FROM $mainTable WHERE SDATE='$sdate' ");
	$del2=$this->db->query("DELETE FROM $gnrllgr WHERE VDATE='$sdate' AND Jo='$voucher_Jo' AND NO=1");
	$del3=$this->db->query("DELETE FROM $gnrllgrloan WHERE VDATE='$sdate' AND Jo='$voucher_Jo' AND NO=1");
	$nrows=$data['trows'];
	$row=1;
	while($row<$nrows){
	
	if(removecommas($data['ttot_'.$row])>0){
	
	$ecode=$data['acode_'.$row];
	$crm=$this->getData("ACCOUNT",array("ACODE"=>$ecode),"ANAME","");
	if(!empty($crm)){
	$contractor=$crm[0]['ANAME'];	
	}
	$acode=40102083;
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	$totalpipeproduct=removecommas($data['totalpipeproduct_'.$row]);
	$pipeproduct20=removecommas($data['pipeproduct20_'.$row]);
	$change=removecommas($data['change_'.$row]);
	$amount=removecommas($data['amount_'.$row]);
	$tadvance=removecommas($data['tadvance_'.$row]);
	$tsloan=removecommas($data['tsloan_'.$row]);
	$tlloan=removecommas($data['tlloan_'.$row]);
	$adjustment=removecommas($data['adjustment_'.$row]);
	$cause=removecommas($data['cause_'.$row]);
	$ttot=removecommas($data['ttot_'.$row]);
	
	$insert=$this->db->query("INSERT INTO PAYMENTCONTRACT(SDATE,ACODE,ANAME,TOTALPIPE,PIPE20,SETCHANGE,AMOUNT,TADVANCE,TSLOAN,TLLOAN,ADJUSTMENT,CAUSE,TTOTAL,EDATE,B_ID) VALUES('$sdate','$ecode','$contractor','$totalpipeproduct','$pipeproduct20','$change','$amount','$tadvance','$tsloan','$tlloan','$adjustment','$cause','$ttot','$edate','".$this->userData['B_ID']."')");
	if($tadvance>0 || $tlloan>0 || $tsloan>0){
	$descrip1="Advance From $contractor";
	$descrip2="Advance Payment To $aname";
	$descrip3="Short Term Payment To $aname";
	$descrip4="Long Term Payment To $aname";
	if($tadvance>0){
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$acode','$descrip1',$tadvance,0,'".$this->userData['B_ID']."')");
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$ecode','$descrip2',0,$tadvance,'".$this->userData['B_ID']."')");
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$sdate','$voucher_Jo','$ecode','$descrip2',0,$tadvance,'".$this->userData['B_ID']."',3)");
	}	else if($tsloan>0){
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$acode','$descrip1',$tsloan,0,'".$this->userData['B_ID']."')");
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$ecode','$descrip2',0,$tsloan,'".$this->userData['B_ID']."')");
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$sdate','$voucher_Jo','$ecode','$descrip3',0,$tsloan,'".$this->userData['B_ID']."',1)");
	}	else if($tlloan>0){
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$acode','$descrip1',$tlloan,0,'".$this->userData['B_ID']."')");
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$ecode','$descrip2',0,$tlloan,'".$this->userData['B_ID']."')");
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$sdate','$voucher_Jo','$ecode','$descrip4',0,$tlloan,'".$this->userData['B_ID']."',2)");
	}	
	}
	if($ttot>0){
	$descrip1="Salary to $contractor";
	$descrip2="Salary from $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$acode','$descrip1',0,$ttot,'".$this->userData['B_ID']."')");
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$sdate','$voucher_Jo','$ecode','$descrip2',$ttot,0,'".$this->userData['B_ID']."')");
	}
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','1','$voucher_Jo','$post_type')");
	return true;
	}
	
	public function insertsalarySheetDaily($data){
	
	$mainTable="SALARYSHEETDAILY";
	print_r($mainTable);
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="SD";
	$post_type=2;	
	
	$vdate=$data['fdate'];
	$dt=explode(" - ",$vdate);
	$date1=$this->dateFormat($dt[0]);
	$date2=$this->dateFormat($dt[1]);
	$del=$this->db->query("DELETE FROM $mainTable WHERE VDATE='$date1' ");
	$del2=$this->db->query("DELETE FROM $gnrllgr WHERE VDATE='$date1' AND Jo='$voucher_Jo' AND NO=1");
	$del3=$this->db->query("DELETE FROM $gnrllgrloan WHERE VDATE='$date1' AND Jo='$voucher_Jo' AND NO=1");
	$nrows=$data['trows'];
	$row=1;
	while($row<$nrows){
	
	if(removecommas($data['gpay_'.$row])>0 || removecommas($data['npay_'.$row])>0 || removecommas($data['tpay_'.$row])>0){
	
	$ecode=$data['id_'.$row];
	$crm=$this->getData("ACCOUNT",array("ACODE"=>$ecode),"ANAME","");
	if(!empty($crm)){
	$employee=$crm[0]['ANAME'];	
	}
	$basic=removecommas($data['basic_'.$row]);
	$wdays=removecommas($data['wdays_'.$row]);
	$whours=removecommas($data['whours_'.$row]);
	$ohours=removecommas($data['hours_'.$row]);
	$oamount=removecommas($data['oamount_'.$row]);
	$tltloan=removecommas($data['tltl_'.$row]);
	$ltloan=removecommas($data['ltermded_'.$row]);
	$tstloan=removecommas($data['tstl_'.$row]);
	$stloan=removecommas($data['stermded_'.$row]);
	$tadvance=removecommas($data['tadvance_'.$row]);
	$advance=removecommas($data['advanceded_'.$row]);
	$gross=removecommas($data['gpay_'.$row]);
	$net=removecommas($data['npay_'.$row]);
	$total=removecommas($data['tpay_'.$row]);
	
	$cltloan=1;
	$cstloan=1;
	$cadvance=1;
	
	$insert=$this->db->query("INSERT INTO $mainTable(VDATE,ECODE,EMPLOYEE,BASIC,WDAYS,WHOURS,OHOURS
	,OAMOUNT,TLTLOAN,LTLOAN,TSTLOAN,STLOAN,TADVANCE,ADVANCE,CLTLOAN,CSTLOAN,CADVANCE,GROSS,NET,TOTAL,B_ID,DATE1,DATE2)
	VALUES('$date1','$ecode','$employee','$basic','$wdays','$whours','$ohours','$oamount','$tltloan','$ltloan'
	,'$tstloan','$stloan','$tadvance','$advance','$cltloan','$cstloan','$cadvance','$gross'
	,'$net','$total','".$this->userData['B_ID']."','$date1','$date2')");
	
	
	$vdate=$date1;
	if($insert){
	$acode=40201026;
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	
	if($ltloan>0){
	$descrip1="Long Term Loan Payment From $employee";
	$descrip2="Long Term Loan Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$ltloan,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$ltloan,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$ltloan,'".$this->userData['B_ID']."',2)");
	}
	
	if($stloan>0){
	$descrip1="Short Term Loan Payment From $employee";
	$descrip2="Short Term Loan Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$stloan,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$stloan,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$stloan,'".$this->userData['B_ID']."',1)");
	
	}
	if($advance>0){
	
	$descrip1="Advance From $employee";
	$descrip2="Advance Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$advance,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$advance,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$advance,'".$this->userData['B_ID']."',3)");
	
	}
	
		
	}
	
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','1','$voucher_Jo','$post_type')");
	return true;
	}
	
	public function insertsalarySheetOvertime($data){
	
	$mainTable="SALARYSHEETOVERTIME";
	$gnrllgr="Gnrllgr";
	$gnrllgrloan="Gnrllgr_loan";
	$voucher_Jo="SSO";
	$post_type=2;	
	
	$vdate=$data['fdate'];
	$dt=explode(" - ",$vdate);
	$date1=$this->dateFormat($dt[0]);
	$date2=$this->dateFormat($dt[1]);
	$del=$this->db->query("DELETE FROM $mainTable WHERE VDATE='$date1' ");
	$del2=$this->db->query("DELETE FROM $gnrllgr WHERE VDATE='$date1' AND Jo='$voucher_Jo' AND NO=1");
	$del3=$this->db->query("DELETE FROM $gnrllgrloan WHERE VDATE='$date1' AND Jo='$voucher_Jo' AND NO=1");
	$nrows=$data['trows'];
	$row=1;
	while($row<$nrows){
	
	if(removecommas($data['gpay_'.$row])>0 || removecommas($data['npay_'.$row])>0 || removecommas($data['tpay_'.$row])>0){
	
	$ecode=$data['id_'.$row];
	$crm=$this->getData("ACCOUNT",array("ACODE"=>$ecode),"ANAME","");
	if(!empty($crm)){
	$employee=$crm[0]['ANAME'];	
	}
	$basic=removecommas($data['basic_'.$row]);
	$wdays=removecommas($data['wdays_'.$row]);
	$whours=removecommas($data['whours_'.$row]);
	$ohours=removecommas($data['hours_'.$row]);
	$oamount=removecommas($data['oamount_'.$row]);
	$tltloan=removecommas($data['tltl_'.$row]);
	$ltloan=removecommas($data['ltermded_'.$row]);
	$tstloan=removecommas($data['tstl_'.$row]);
	$stloan=removecommas($data['stermded_'.$row]);
	$tadvance=removecommas($data['tadvance_'.$row]);
	$advance=removecommas($data['advanceded_'.$row]);
	$gross=removecommas($data['gpay_'.$row]);
	$net=removecommas($data['npay_'.$row]);
	$total=removecommas($data['tpay_'.$row]);
	
	$cltloan=1;
	$cstloan=1;
	$cadvance=1;
	
	$insert=$this->db->query("INSERT INTO $mainTable(VDATE,ECODE,EMPLOYEE,BASIC,WDAYS,WHOURS,OHOURS,OAMOUNT,TLTLOAN,LTLOAN,TSTLOAN,STLOAN,TADVANCE,ADVANCE,CLTLOAN,CSTLOAN,CADVANCE,GROSS,NET,TOTAL,B_ID,DATE1,DATE2) VALUES('$date1','$ecode','$employee','$basic','$wdays','$whours','$ohours','$oamount','$tltloan','$ltloan','$tstloan','$stloan','$tadvance','$advance','$cltloan','$cstloan','$cadvance','$gross','$net','$total','".$this->userData['B_ID']."','$date1','$date2')");
	$vdate=$date1;
	if($insert){
	$acode=40201026;
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	
	if($ltloan>0){
	$descrip1="Long Term Loan Payment From $employee";
	$descrip2="Long Term Loan Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$ltloan,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$ltloan,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$ltloan,'".$this->userData['B_ID']."',2)");
	}
	
	if($stloan>0){
	$descrip1="Short Term Loan Payment From $employee";
	$descrip2="Short Term Loan Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$stloan,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$stloan,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$stloan,'".$this->userData['B_ID']."',1)");
	
	}
	if($advance>0){
	
	$descrip1="Advance From $employee";
	$descrip2="Advance Payment To $aname";
	$gnrllgrCash = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$acode','$descrip1',$advance,0,'".$this->userData['B_ID']."')");
	
	$gnrllgrAcc = $this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$advance,'".$this->userData['B_ID']."')");
	
	$gnrllgrLoanAcc = $this->db->query("INSERT INTO $gnrllgrloan(No,VDate,Jo,ACode,Descr,Debit,Credit,B_ID,LTYPE) VALUES ('1','$vdate','$voucher_Jo','$ecode','$descrip2',0,$advance,'".$this->userData['B_ID']."',3)");
	
	}
	
		
	}
	
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','1','$voucher_Jo','$post_type')");
	return true;
	}
	
	public function salaryIncrement($data){
		
	$mainTable="SALARYINC";
	$voucher_Jo="SI";
	$post_type;	
		
	if($data['action']=="save"){	
	$no=$data['no'];	
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	if($data['no']>$max || $data['no']<=0){
	$no=$max;	
	}
	$check1=$this->getData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']),"","");
	if(!empty($check1)){
	$max = $this->getMax("$mainTable","NO",array("B_ID"=>$this->userData['B_ID']));
	$no=$max;	
	}
	}
	else{
	$no=$data['no'];
	$this->deleteData("$mainTable",array("NO"=>$no,"B_ID"=>$this->userData['B_ID']));
	}
	
	if(!empty($data['rights'])){
	if($data['rights']['UNPOSTED']==1){
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";		
	$post_type=1;		
	}
	else if($data['rights']['POSTED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved="";	
	$post_type=2;	
	}
	else if($data['rights']['APPROVED']==1){
	$unposted="";	
	$posted=$this->userData['U_ID'];	
	$approved=$this->userData['U_ID'];
	$post_type=3;	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";
	$post_type=1;	
	}	
	}
	else{
	$unposted=$this->userData['U_ID'];	
	$posted="";	
	$approved="";			
	$post_type=1;
	}
	
	
	$vdate=$this->dateFormat($data['vdate']);
	
	$nrows=$data['nrows'];
	$row=1;
	while($row<$nrows){
	if(!empty($data['acode_'.$row.''])){
	if(removecommas($data['increment_'.$row.''])>0 || removecommas($data['current_'.$row.''])>0){

	$acode=$data['acode_'.$row.''];
	$csalary=removecommas($data['current_'.$row.'']);
	$isalary=removecommas($data['increment_'.$row.'']);
	$cnm=$this->getData("ACCOUNT",array("ACODE"=>$acode),"ANAME","");
	if(!empty($cnm)){
	$aname=$cnm[0]['ANAME'];	
	}
	

	
	$insertMain = $this->db->query("INSERT INTO $mainTable(NO,VDATE,ECODE,EMPLOYEE,CSALARY,ISALARY,U_ID,B_ID,UNPOSTED,POSTED,APPROVED) VALUES ('$no','$vdate','$acode','$aname','$csalary','$isalary','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$unposted','$posted','$approved')");
	
	if($insertMain){
	if($data['rights']['UNPOSTED']==0){	
	$gnrllgrCash = $this->db->query("UPDATE SALARYINFO SET BASIC='$isalary',GPAY='$isalary' WHERE ID='$acode'");
	}
	}
		
	}
	}
	$row++;
	}
	$venterDate=date("Y-m-d H:i:s");
	$this->db->query("INSERT INTO VLOG(VDATE,U_ID,B_ID,NO,JO,TYPE) VALUES('$venterDate','".$this->userData['U_ID']."','".$this->userData['B_ID']."','$no','$voucher_Jo','$post_type')");
	
	return true;	
	}
	
	}
?>