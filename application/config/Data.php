<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends MY_Controller{

function __construct(){
parent::__construct();
}

function barcode()
{
    $this->load->library('zend');
    $this->zend->load('Zend/Barcode');

    Zend_Barcode::render('code39', 'image', array('text' => 'CodeIgniter Rocks'), array());
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
$resultArray['climit']=$climit['CLIMIT'];
}
endfor;
echo json_encode($resultArray);
}	
function branchChange(){
$branch=$this->input->post("branch");	
if(!empty($branch)){	
$query=$this->db->query("SELECT B_ID FROM MENU_RIGHTS WHERE USR='".$this->userData['U_ID']."' AND B_ID='$branch'");
if(!empty($query)){
$datatoUpdate=array('U_ID'=>$this->userData['U_ID'],'B_ID'=>$branch,'U_TYPE'=>$this->userData['U_TYPE'],'BRANCHES'=>$this->userData['BRANCHES'],'UB_ID'=>$this->userData['UB_ID']);
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
