<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends MY_Controller{
	
	function __construct(){
	parent::__construct();
	}
		
	function partyData(){

	$acode=$this->input->get("acode");
	$typeArray=$this->uri->segment_array();
	$resultArray=array();
	for($row=1;$row<=count($typeArray);$row++):
	$type=$typeArray[$row];
	if($type=="address"){
	$resultArray['address']="None";	
	}
	if($type=="balance"){
	$balance=$this->dataModel->getBalance($acode,false,false,false);
	$resultArray['balance']=$balance;
	}
	if($type=="climit"){
	$climit=$this->dataModel->getData("PARTY",array("VCODE"=>$acode,"B_ID"=>$this->userData['B_ID']),"CLIMIT","");
	$resultArray['climit']=$climit[0]['CLIMIT'];
	}
	endfor;
	echo json_encode($resultArray);
	}	
	function branchChange(){
	$branch=$this->input->post("branch");	
	if(!empty($branch)){	
	$query=$this->db->query("SELECT B_ID FROM MENU_RIGHTS WHERE USR='".$this->userData['U_ID']."' AND B_ID='$branch'");
	if(!empty($query)){
	$spcode="";	
	$sperson=$this->dataModel->query("SELECT BCODE FROM SPERSON WHERE USERNAME='".$this->userData['U_ID']."'");
	if(!empty($sperson)){
	$spcode=$sperson[0]['BCODE'];	
	}
	$datatoUpdate=array('U_ID'=>$this->userData['U_ID'],'B_ID'=>$branch,'U_TYPE'=>$this->userData['U_TYPE'],'BRANCHES'=>$this->userData['BRANCHES'],'UB_ID'=>$this->userData['UB_ID'],"SPCODE"=>$spcode);
	
	$this->session->set_userdata("user",$datatoUpdate);
	if($this->userData['U_TYPE']!="0"){
	$this->load->model("navbar");
	$navbar=$this->navbar->mynavigation();	
	$this->session->set_userdata(array("NAVBAR"=>$navbar));
	}
	echo json_encode(array("success"=>"true","response"=>"Successfully Switched"));	
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Your are not authorized to login from this branch."));	
	}
	}
	else{
	echo json_encode(array("success"=>"false","error"=>"Please Select Branch"));	
	}
	}
	public function referenceCheque(){	
	$acode=$this->input->get("acode");	
	$query=$this->dataModel->query("SELECT CHQNO,SUM(DEBIT-CREDIT) AS DIF FROM Gnrllgr_chq WHERE ACODE='$acode' GROUP BY CHQNO HAVING SUM(DEBIT-CREDIT)<>0");
	$this->punchData['refchq']=$query;//$data=$this->load->view("financial/voucher/referencechq",$this->punchData,true);
	echo json_encode(array("data"=>$query));
	}
	
	public function referenceChequeInvoices(){	
	$acode=$this->input->get("acode");	
	$query=$this->dataModel->query("SELECT Gnrllgr_chq.CHQNO,SUM(Gnrllgr_chq.DEBIT-Gnrllgr_chq.CREDIT) AS DIF,CHQRECIEPT.NO,CHQRECIEPT.VDATE,CHQRECIEPT.CHQDATE,CHQRECIEPT.DEBIT FROM Gnrllgr_chq INNER JOIN CHQRECIEPT ON Gnrllgr_chq.CHQNO=CHQRECIEPT.CHQNO AND Gnrllgr_chq.ACODE=CHQRECIEPT.ACODE WHERE Gnrllgr_chq.ACODE='$acode' GROUP BY Gnrllgr_chq.CHQNO,CHQRECIEPT.NO,CHQRECIEPT.VDATE,CHQRECIEPT.CHQDATE,CHQRECIEPT.DEBIT HAVING SUM(Gnrllgr_chq.DEBIT-Gnrllgr_chq.CREDIT)<>0");
	$date=date("Y-m-d");
	$query2=$this->dataModel->query("SELECT Gnrllgr.SNO AS INVNO,SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT) AS DIF,SALE1.NO,SALE1.VDATE,SALE1.NET,DATEDIFF(day,SALE1.VDATE,'$date') AS INVDAYS FROM Gnrllgr INNER JOIN SALE1 ON SALE1.NO=Gnrllgr.SNO AND Gnrllgr.B_ID=SALE1.B_ID WHERE Gnrllgr.ACODE='$acode' AND Gnrllgr.B_ID='".$this->userData['B_ID']."' AND Gnrllgr.SNO IS NOT NULL AND Gnrllgr.SNO > 0 GROUP BY Gnrllgr.SNO,SALE1.NO,SALE1.VDATE,SALE1.NET HAVING SUM(DEBIT-CREDIT)<>0");
	
	$chqs=$this->load->view("financial/voucher/referencechq",['data'=>$query],true);
	$inv=$this->load->view("financial/voucher/saleinvoices",['data'=>$query2],true);
	
	echo json_encode(array("data"=>$query,"data2"=>$query2,'saleinv'=>$inv,'refchq'=>$chqs));
	}
	
	public function pendingChq(){	
	$acode=$this->input->get("acode");	
	$query=$this->dataModel->query("SELECT Gnrllgr_chq.CHQNO,SUM(Gnrllgr_chq.DEBIT-Gnrllgr_chq.CREDIT) AS DIF,CHQRECIEPT.NO,CHQRECIEPT.VDATE,CHQRECIEPT.CHQDATE,CHQRECIEPT.DEBIT FROM Gnrllgr_chq INNER JOIN CHQRECIEPT ON Gnrllgr_chq.CHQNO=CHQRECIEPT.CHQNO AND Gnrllgr_chq.ACODE=CHQRECIEPT.ACODE WHERE Gnrllgr_chq.ACODE='$acode' GROUP BY Gnrllgr_chq.CHQNO,CHQRECIEPT.NO,CHQRECIEPT.VDATE,CHQRECIEPT.CHQDATE,CHQRECIEPT.DEBIT HAVING SUM(Gnrllgr_chq.DEBIT-Gnrllgr_chq.CREDIT)<>0");

	
	$chqs=$this->load->view("financial/voucher/pendingchq",['data'=>$query],true);
	
	echo json_encode(array("data"=>$query,'chqs'=>$chqs));
	}
	
	public function booknoClosed(){
		
	$query=$this->dataModel->query("SELECT T1.NO,T1.BNO,T1.SNO,T1.B_ID,T1.TYPE,T2.BNO AS 'BOOKNO' FROM (SELECT BISSUE2.NO,BISSUE2.BNO,BISSUE2.SNO,BISSUE2.B_ID,'1' AS TYPE FROM BISSUE2 WHERE STATUS=0
	UNION
	SELECT BISSUE2.NO,BISSUE2.BNO,BISSUE2.SNO,BISSUE2.B_ID,'2' AS TYPE FROM BISSUE2
	LEFT JOIN SALE1 ON SALE1.NO=BISSUE2.SNO AND SALE1.B_ID=BISSUE2.B_ID 
	WHERE SALE1.NO IS NULL AND BISSUE2.STATUS=1) AS T1 INNER JOIN BISSUE1 AS T2 ON T1.BNO=T2.NO AND T1.B_ID=T2.B_ID
	ORDER BY T2.BNO,T1.NO ASC 
	");
	$data=$this->load->view("sales/voucher/booknoclosed",['data'=>$query],true);
	
	echo json_encode(array("data"=>$data));
	
	}
	
	public function booknoMemoClosed(){
		
	$query=$this->dataModel->query("SELECT T1.NO,T1.BNO,T1.SNO,T1.B_ID,T1.TYPE,T2.BNO AS 'BOOKNO' FROM (SELECT BISSUEMEMO2.NO,BISSUEMEMO2.BNO,BISSUEMEMO2.SNO,BISSUEMEMO2.B_ID,'1' AS TYPE FROM BISSUEMEMO2 WHERE STATUS=0
	UNION
	SELECT BISSUEMEMO2.NO,BISSUEMEMO2.BNO,BISSUEMEMO2.SNO,BISSUEMEMO2.B_ID,'2' AS TYPE FROM BISSUEMEMO2
	LEFT JOIN MEMO1 ON MEMO1.NO=BISSUEMEMO2.SNO AND MEMO1.B_ID=BISSUEMEMO2.B_ID 
	WHERE MEMO1.NO IS NULL AND BISSUEMEMO2.STATUS=1) AS T1 INNER JOIN BISSUE1 AS T2 ON T1.BNO=T2.NO AND T1.B_ID=T2.B_ID
	ORDER BY T2.BNO,T1.NO ASC 
	");
	$data=$this->load->view("memo/voucher/booknoclosed",['data'=>$query],true);
	
	echo json_encode(array("data"=>$data));
	
	}
	
	public function booknoClosedReuse(){
	$val=$this->input->post("val");	
	$cbc=explode(",",$val);
	if(!empty($cbc[1])){
	$no=$cbc[0];
	$bno=$cbc[1];
	$sno=$cbc[2];
	$bid=$cbc[3];
	$this->dataModel->deleteData("BISSUE2",array("NO"=>$no,"BNO"=>$bno,"B_ID"=>$bid));
	}
	echo json_encode(array("success"=>"true",'echo'=>$bid));
	
	}
	
	public function booknoMemoClosedReuse(){
	$val=$this->input->post("val");	
	$cbc=explode(",",$val);
	if(!empty($cbc[1])){
	$no=$cbc[0];
	$bno=$cbc[1];
	$sno=$cbc[2];
	$bid=$cbc[3];
	$this->dataModel->deleteData("BISSUEMEMO2",array("NO"=>$no,"BNO"=>$bno,"B_ID"=>$bid));
	}
	echo json_encode(array("success"=>"true",'echo'=>$bid));
	
	}
	
	
	public function purchaseInvoices(){	
	$acode=$this->input->get("acode");
	$date=date("Y-m-d");
	$query=$this->dataModel->query("SELECT Gnrllgr.PNO AS INVNO,SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT) AS DIF,PURCH1.NO,PURCH1.VDATE,PURCH1.NET,DATEDIFF(day,PURCH1.VDATE,'$date') AS INVDAYS FROM Gnrllgr INNER JOIN PURCH1 ON PURCH1.NO=Gnrllgr.PNO AND Gnrllgr.B_ID=PURCH1.B_ID WHERE Gnrllgr.ACODE='$acode' AND Gnrllgr.B_ID='".$this->userData['B_ID']."' AND Gnrllgr.PNO IS NOT NULL AND Gnrllgr.PNO > 0 GROUP BY Gnrllgr.PNO,PURCH1.NO,PURCH1.VDATE,PURCH1.NET HAVING SUM(DEBIT-CREDIT)<>0");
	$this->punchData['refchq']=$query;
	$data=$this->load->view("financial/voucher/purchaseinvoices",['data'=>$query],true);
	echo json_encode(array("data"=>$query,'purchinv'=>$data));
	}
	public function memoInvoices(){	
	$acode=$this->input->get("acode");
	$date=date("Y-m-d");
	$query=$this->dataModel->query("SELECT Gnrllgr.MNO AS INVNO,SUM(Gnrllgr.DEBIT-Gnrllgr.CREDIT) AS DIF,MEMO1.NO,MEMO1.VDATE,MEMO1.NET,DATEDIFF(day,MEMO1.VDATE,'$date') AS INVDAYS FROM Gnrllgr INNER JOIN MEMO1 ON MEMO1.NO=Gnrllgr.MNO AND Gnrllgr.B_ID=MEMO1.B_ID WHERE Gnrllgr.ACODE='$acode' AND Gnrllgr.B_ID='".$this->userData['B_ID']."' AND Gnrllgr.MNO IS NOT NULL AND Gnrllgr.MNO > 0 GROUP BY Gnrllgr.MNO,MEMO1.NO,MEMO1.VDATE,MEMO1.NET HAVING SUM(DEBIT-CREDIT)<>0");
	$this->punchData['refchq']=$query;
	$data=$this->load->view("memo/voucher/memoinvoices",['data'=>$query],true);
	echo json_encode(array("data"=>$query,'purchinv'=>$data));
	}
	
	public function saleInvoices(){	
	$acode=$this->input->get("acode");
	$query=$this->dataModel->query("SELECT SNO AS INVNO,SUM(DEBIT-CREDIT) AS DIF FROM Gnrllgr WHERE ACODE='$acode' AND B_ID='".$this->userData['B_ID']."' AND SNO IS NOT NULL AND SNO > 0  GROUP BY SNO HAVING SUM(DEBIT-CREDIT)<>0");
	$this->punchData['refchq']=$query;//$data=$this->load->view("financial/voucher/referencechq",$this->punchData,true);
	echo json_encode(array("data"=>$query));
	}
	
	public function chqbook(){	
	$bcode=$this->input->get("bcode");
	$query=$this->dataModel->query("SELECT BNO,BCODE,BNAME,SUM(DEBIT-CREDIT) AS DIF FROM Gnrllgr_cb WHERE BCODE='$bcode'  AND JO<>'CL' GROUP BY BNO,BCODE,BNAME HAVING SUM(DEBIT-CREDIT)>0");
	$this->punchData['data']=$query;
	$data=$this->load->view("financial/voucher/chqbook",$this->punchData,true);
	echo json_encode(array("data"=>$query,"chqbook"=>$data));
	}
	public function chqbookChq(){	
	$bcode=$this->input->get("bcode");
	$cbcode=$this->input->get("cbcode");
	$query=$this->dataModel->query("SELECT BNO,BCODE,BNAME,CHQNO,SUM(DEBIT-CREDIT) AS DIF FROM Gnrllgr_cb WHERE BCODE='$bcode' AND BNO='$cbcode' GROUP BY BNO,BCODE,BNAME,CHQNO HAVING SUM(DEBIT-CREDIT)>0");
	$query2=$this->dataModel->query("SELECT BNO,BCODE,BNAME,CHQNO FROM Gnrllgr_cb WHERE BCODE='$bcode' AND BNO='$cbcode'  AND JO='CL'GROUP BY BNO,BCODE,BNAME,CHQNO");
	$this->punchData['data']=$query;
	$this->punchData['data2']=$query2;
	$data=$this->load->view("financial/voucher/chqbookchq",$this->punchData,true);
	echo json_encode(array("data"=>$query,"chqbook"=>$data));
	}
	
	public function chqbookChqCancel(){	
	$bcode=$this->input->post("bank");
	$bcno=$this->input->post("bcno");
	$voucher_Jo="CL";
	$gnrllgr="Gnrllgr_cb";
	$cbc=explode("-",$bcno);
	if(!empty($cbc[1])){
	$bno=$cbc[0];
	$chqno=$cbc[1];
	$venterDate=date("Y-m-d H:i:s");
	$vdate=date("Y-m-d");
	$bmm=$this->dataModel->getData("BANK",array("BCODE"=>$bcode),"BNAME","");
	if(!empty($bmm)){
	$bank=$bmm[0]['BNAME'];	
	}
	$descr="Closed By ".$this->userData['U_ID'];
	$this->db->query("INSERT INTO $gnrllgr(No,VDate,Jo,Debit,Credit,B_ID,CHQNO,BCODE,BNAME,BNO,DESCR) VALUES ('1','$vdate','$voucher_Jo',0,1,'".$this->userData['B_ID']."','$chqno','$bcode','$bank','$bno','$descr')");
	}
	echo json_encode(array("success"=>"true"));
	}
	
	public function chqbookChqCancelUndo(){	
	$bcode=$this->input->post("bank");
	$bcno=$this->input->post("bcno");
	$voucher_Jo="CL";
	$gnrllgr="Gnrllgr_cb";
	$cbc=explode("-",$bcno);
	if(!empty($cbc[1])){
	$bno=$cbc[0];
	$chqno=$cbc[1];
	$this->dataModel->deleteData("$gnrllgr",array("Jo"=>"$voucher_Jo","NO"=>1,"B_ID"=>$this->userData['B_ID'],"CHQNO"=>$chqno,"BNO"=>$bno,"BCODE"=>$bcode));
	}
	echo json_encode(array("success"=>"true"));
	}
	
	public function clearBookNo(){
	$no=$this->input->post("no");	
	$bno=$this->input->post("bno");	
	$sno=$this->input->post("sno");	
	$Bissue1=$this->dataModel->getData("BISSUE1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1,"BNO"=>$bno),"","");
	if(!empty($Bissue1)){
	$insert=$this->db->query("INSERT INTO BISSUE2(NO,BNO,SNO,B_ID,STATUS) VALUES ($no,".$Bissue1[0]['NO'].",'$sno','".$this->userData['B_ID']."',0)");
	$maxFBissue=$this->dataModel->getMax("BISSUE2","NO",array("B_ID"=>$this->userData['B_ID'],"BNO"=>$Bissue1[0]['NO']));
	if($maxFBissue<=$Bissue1[0]['ENDAT']){
	if($maxFBissue==1){
	$maxFBissue=$Bissue1[0]['STARTAT'];	
	}	
	$maxBissue=$Bissue1[0]['BNO']."-".$maxFBissue;	
	echo json_encode(array("data"=>$maxBissue,"success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Old Book is full issue New Book","success"=>"false"));
	}
	}
	else{
	echo json_encode(array("error"=>"No Book Found ! Issue Book","success"=>"false"));	
	}
	}
	
	public function clearBookNoMemo(){
	$no=$this->input->post("no");	
	$bno=$this->input->post("bno");	
	$sno=$this->input->post("sno");	
	$Bissue1=$this->dataModel->getData("BISSUEMEMO1",array("B_ID"=>$this->userData['B_ID'],"STATUS"=>1,"BNO"=>$bno),"","");
	if(!empty($Bissue1)){
	$insert=$this->db->query("INSERT INTO BISSUEMEMO2(NO,BNO,SNO,B_ID,STATUS) VALUES ($no,".$Bissue1[0]['NO'].",'$sno','".$this->userData['B_ID']."',0)");
	$maxFBissue=$this->dataModel->getMax("BISSUEMEMO2","NO",array("B_ID"=>$this->userData['B_ID'],"BNO"=>$Bissue1[0]['NO']));
	if($maxFBissue<=$Bissue1[0]['ENDAT']){
	if($maxFBissue==1){
	$maxFBissue=$Bissue1[0]['STARTAT'];	
	}	
	$maxBissue=$Bissue1[0]['BNO']."-".$maxFBissue;	
	echo json_encode(array("data"=>$maxBissue,"success"=>"true"));
	}
	else{
	echo json_encode(array("error"=>"Old Book is full issue New Book","success"=>"false"));
	}
	}
	else{
	echo json_encode(array("error"=>"No Book Found ! Issue Book","success"=>"false"));	
	}
	}
	
	public function printOuts(){
	if($this->input->is_ajax_request()){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("type","Print Type","required");
	$this->form_validation->set_rules("format","Print Format","required");
	$this->form_validation->set_rules("name","Print Name","required");
		if($this->form_validation->run()){
		$data=$this->input->post();
		$type=$data['format'];		
		$formula=false;
		if($data['name']=="account-activity"){
		$type=$data['format'];
		$report="acc";
		$DisplayName="Account Activity Report";
		$formula="{Lgrrep.U_ID}='".$this->userData['U_ID']."'";
		}
		else if($data['name']=="trial"){
		$type=$data['format'];
		$report="trial";
		$DisplayName=" Trial Balance Report";
		$formula="{TRIAL.U_ID}='".$this->userData['U_ID']."'";
		}
		else if($data['name']=="cashbook"){
		$type=$data['format'];
		$report="cashbook";
		$DisplayName="Cash Book Report";
		$formula="{Lgrrep.U_ID}='".$this->userData['U_ID']."'";
		}
		else if($data['name']=="custbal"){
		$type=$data['format'];
		$report="custbal";
		$DisplayName="Customer Balances Report";
		$formula="{Lgrrep.U_ID}='".$this->userData['U_ID']."'";
		}
		else if($data['name']=="custlgr"){
		$type=$data['format'];
		$report="custlgr";
		$DisplayName="Customer Ledger Report";
		$formula="{Lgrrep.U_ID}='".$this->userData['U_ID']."'";
		}
		else if($data['name']=="custage"){
		$type=$data['format'];
		$report="custage";
		$DisplayName="Customer Aging Report";
		$formula="{AGBAL.U_ID}='".$this->userData['U_ID']."'";
		}
		else if($data['name']=="custageall"){
		$type=$data['format'];
		$report="custageall";
		$DisplayName="Customer Aging Report(All)";
		$formula="{CSLREP.U_ID}='".$this->userData['U_ID']."'";
		}
		//tasawar chohan
		else if($data['name']=="cash_reciept"){
		$type=$data['format'];
		$report="CashVr1";
		$DisplayName="Cash Receipt";
 		$formula="{Lgrrep.NO}=".$data['no']." AND {Lgrrep.B_ID}='".$this->userData['B_ID']."' ";
		}
		else if($data['name']=="cash_payment"){
		$type=$data['format'];
		$report="CashVr";
	 	$DisplayName="Cash Payment"; 
  		$formula="{Lgrrep.NO}=".$data['no']."  AND {Lgrrep.B_ID}='".$this->userData['B_ID']."'";
		}

		$this->load->helper('download');
		$reports=$this->printReport($type,$report,$formula);
		echo $this->load->view("reports/main",['name'=>$DisplayName,'type'=>$type,'report'=>$reports],true);

		}
	}
	else{
	echo "not allowed";	
	}
	}
	
	public function checkBranch(){	
	$data=$this->input->post();
	if($data['branch']==$this->userData['B_ID']){
	echo json_encode("true");
	}
	else{
	echo json_encode("false");	
	}
	}
	
	public function saleVoucherDetails(){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("bid","Branch Id","required|numeric");
	if($this->form_validation->run()){
	$data=$this->input->post();
	$puchData=array();	
	$data1=$this->dataModel->getData("SALE1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$data2=$this->dataModel->getData("SALE2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$response=$this->load->view("sales/voucher/saledetails",$puchData,true);
	echo json_encode(array("success"=>"true","data"=>$response));
	}	
	else{
	echo json_encode(array("error"=>"Not Found","success"=>"false"));	
	}
	}
	public function voucherDetails(){	
	$this->form_validation->set_rules("no","Voucher No.","required|numeric");
	$this->form_validation->set_rules("type","Voucher Type","required");
	$this->form_validation->set_rules("bid","Branch Id","required|numeric");
	if($this->form_validation->run()){
	$data=$this->input->post();
	$data1="";
	$puchData=array();
	$type=$data['type'];
	if($type=="SL"){
	$data1=$this->dataModel->getData("SALE1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$data2=$this->dataModel->getData("SALE2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="sale";
	}
	else if($type=="SR"){
	$data1=$this->dataModel->getData("SRET1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$data2=$this->dataModel->getData("SRET2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="salereturn";
	}
	else if($type=="PU"){
	$data1=$this->dataModel->getData("PURCH1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$data2=$this->dataModel->getData("PURCH2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="purchase";
	}
	else if($type=="PR"){
	$data1=$this->dataModel->getData("PRET1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$data2=$this->dataModel->getData("PRET2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="purchasereturn";
	}
	else if($type=="CR"){
	$data1=$this->dataModel->getData("CASHRCP",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="cashreciept";
	}
	else if($type=="CP"){
	$data1=$this->dataModel->getData("CASHPYM",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="cashpayment";
	}
	else if($type=="BR"){
	$data1=$this->dataModel->getData("DEBIT",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="bankreciept";
	}
	else if($type=="BP"){
	$data1=$this->dataModel->getData("CREDIT",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="bankpayment";
	}
	else if($type=="JV"){
	$data1=$this->dataModel->getData("JOURNAL",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="journal";
	}
	else if($type=="OP"){
	$data1=$this->dataModel->getData("OPJOURNAL",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="openingjournal";
	}
	else if($type=="BI"){
	$data1=$this->dataModel->getData("BISSUE1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="bookissue";
	}
	else if($type=="CT"){
	$data1=$this->dataModel->getData("CHQTRANSFER",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="chqtransfer";
	}
	else if($type=="DO"){
	$data1=$this->dataModel->getData("DO1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$data2=$this->dataModel->getData("DO2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="cusdemandorder";
	}
	else if($type=="LC"){
	$data1=$this->dataModel->getData("LC1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$data2=$this->dataModel->getData("LC2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="lcinfo";
	}
	else if($type=="LE"){
	$data1=$this->dataModel->getData("LCEXPENSE",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$puchData['data1']=$data1;
	$view="lcexpense";
	}
	else if($type=="LJ"){
	$data1=$this->dataModel->getData("LCJOURNAL",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$puchData['data1']=$data1;
	$view="lcjournal";
	}
	else if($type=="LN"){
	$data1=$this->dataModel->getData("LOAN",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$puchData['data1']=$data1;
	$view="loanadvance";
	}
	else if($type=="LP"){
	$data1=$this->dataModel->getData("LOANPAYMENT",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$puchData['data1']=$data1;
	$view="loanadvancepayment";
	}
	else if($type=="LS"){
	$data1=$this->dataModel->getData("LCSALE1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$data2=$this->dataModel->getData("LCSALE2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="lcsale";
	}
	else if($type=="PL"){
	$data1=$this->dataModel->getData("LCPURCH1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$data2=$this->dataModel->getData("LCPURCH2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");		
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="lcpurchase";
	}
	else if($type=="RC"){
	$data1=$this->dataModel->getData("CHQRECIEPT",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");				
	$puchData['data1']=$data1;
	$view="chqreciept";
	}
	else if($type=="SO"){
	$data1=$this->dataModel->getData("SORDR1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");				
	$data2=$this->dataModel->getData("SORDR2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");				
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="saleorder";
	}
	else if($type=="ST"){
	$data1=$this->dataModel->getData("STRNF1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("STRNF2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="stocktransfer";
	}
	else if($type=="SG"){
	$data1=$this->dataModel->getData("SSGRN1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("SSGRN2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="storesparegoodsreceipt";
	}
	else if($type=="OR"){
	$data1=$this->dataModel->getData("SSOPSTOCK1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("SSOPSTOCK2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="opstockstorespare";
	}
	else if($type=="TS"){
	$data1=$this->dataModel->getData("SSSTRNF1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("SSSTRNF2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="storesparetransfer";
	}
	else if($type=="MO"){
	$data1=$this->dataModel->getData("MEMO1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("MEMO2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="memovoucher";
	}
	else if($type=="CM"){
	$data1=$this->dataModel->getData("CASHPYMMEMO",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$view="cashpaymentmemo";
	}
	else if($type=="DS"){
	$data1=$this->dataModel->getData("SSDO1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("SSDO2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="storesparedemandorder";
	}
	else if($type=="SN"){
	$data1=$this->dataModel->getData("SSSRN1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("SSSRN2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="storesparereturn";
	}
	else if($type=="SC"){
	$data1=$this->dataModel->getData("SSSCN1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("SSSCN2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="storespareconsumption";
	}
	else if($type=="OS"){
	$data1=$this->dataModel->getData("OPSTOCK1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("OPSTOCK2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="opstock";
	}
	else if($type=="LT"){
	$data1=$this->dataModel->getData("LCSTRNF1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$data2=$this->dataModel->getData("LCSTRNF2",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");
	$puchData['data1']=$data1;
	$puchData['data2']=$data2;
	$view="lcstocktransfer";
	}
	else if($type=="SS"){
	$data1=$this->dataModel->getData("SALARYSHEET",array("VDATE"=>$data['vdate']),"","");
	$puchData['data1']=$data1;
	$view="salarysheet";
	}
	else if($type=="SD"){
	$data1=$this->dataModel->getData("SALARYSHEETDAILY",array("VDATE"=>$data['vdate']),"","");
	$puchData['data1']=$data1;
	$view="salarysheetdaily";
	}
	else if($type=="DV"){
	$data1=$this->dataModel->getData("DISCOUNT",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="discountvoucher";
	}
	else if($type=="BM"){
	$data1=$this->dataModel->getData("BISSUEMEMO1",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data1']=$data1;
	$view="bookissuememo";
	}
	else if($type=="AM"){
	$data1=$this->dataModel->getData("AMENDMENT",array("NO"=>$data['no'],"B_ID"=>$data['bid']),"","");	
	$puchData['data']=$data1;
	if(!empty($data)){
	$data1a=$this->dataModel->getData("SALE1",array("NO"=>$data1[0]['SALENO'],"B_ID"=>$data1[0]['B_ID']),"","");	
	$data2a=$this->dataModel->getData("SALE2",array("NO"=>$data1[0]['SALENO'],"B_ID"=>$data1[0]['B_ID']),"","");	
	$puchData['data1']=$data1a;
	$puchData['data2']=$data2a;
	}
	$view="amendment";
	}
	else{
	echo json_encode(array("error"=>"Unknown Type","success"=>"false"));
	}
	
	if(!empty($puchData)){
	if(!empty($puchData['data1'])){	
	$unposted=$this->dataModel->getData("VLOG",array("NO"=>$data['no'],"JO"=>$type,"B_ID"=>$data['bid'],"TYPE"=>1),"","VDATE DESC");
	$posted=$this->dataModel->getData("VLOG",array("NO"=>$data['no'],"JO"=>$type,"B_ID"=>$data['bid'],"TYPE"=>2),"","VDATE DESC");
	$approved=$this->dataModel->getData("VLOG",array("NO"=>$data['no'],"JO"=>$type,"B_ID"=>$data['bid'],"TYPE"=>3),"","VDATE DESC");
	$puchData['unposted']=$unposted;
	$puchData['posted']=$posted;
	$puchData['approved']=$approved;	
	$response=$this->load->view("popup/voucher/$view",$puchData,true);
	echo json_encode(array("success"=>"true","data"=>$response));
	}
	else{
	echo json_encode(array("error"=>"Not Found","success"=>"false"));		
	}
	}
	}
	else{
	echo json_encode(array("error"=>"Declare All Fields","success"=>"false"));	
	}
	
	}
	
	public function currentStock(){
	$data=$this->input->get();	
	$query=$this->dataModel->query("SELECT SUM(INQT-OUTQT) AS BQTY,SUM(INWGHT-OUTWGHT) AS BWGHT FROM STOCK WHERE PCODE='".$data['pcode']."' AND B_ID='".$this->userData['B_ID']."'");	
	if(!empty($query)){
	$bal="Qty : ".$query[0]['BQTY']." Pcs ,Weight : ".$query[0]['BWGHT']." Kg";	
	}
	else{
	$bal="Qty : 0 Pcs ,Weight : 0 Kg";	
	}
	
	echo json_encode(array("success"=>"true","bal"=>$bal));	
	}
	
	
}
