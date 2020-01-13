<?php
defined("BASEPATH") OR exit("No direct script access allowed");
class MY_Controller extends CI_Controller {
	
	public $userData;
	public $punchData;
	
	function __construct(){
	parent::__construct();
	
	if(!$this->session->userdata("user")){
	redirect(base_url());	
	}
	$this->load->model("dataModel");
	$this->userData=$this->session->userdata("user");
	$this->punchData['user']=$this->userData;
	$this->punchData['libraries']=array();
	$accessUrl=$this->uri->segment(1);
	if($this->uri->segment(2) && $this->uri->segment(2)!=""){
	$accessUrl=$accessUrl."/".$this->uri->segment(2);
	}
	if($this->userData['U_TYPE']!=0){ 
	$checknotmenu=$this->dataModel->getData("MENU",array("LINK"=>$accessUrl),"","");
	}
	if($this->userData['U_TYPE']!=0 && $this->uri->segment(1)!="home" && !empty($checknotmenu)){	
	$checkUserRight=$this->dataModel->query("SELECT MENU.NO,MENU.VOUCHER FROM MENU INNER JOIN MENU_RIGHTS ON MENU.NO=MENU_RIGHTS.MENU WHERE MENU_RIGHTS.USR='".$this->userData['U_ID']."' AND MENU.LINK='$accessUrl' AND ( MENU_RIGHTS.B_ID='".$this->userData['B_ID']."' OR MENU.UNIVERSAL=0 )  GROUP BY MENU.NO,MENU.VOUCHER");	
	if(empty($checkUserRight)){
	$this->session->set_flashdata("aunthorized","Your are not authorized to view this page");
	redirect(base_url("home"));
	}
	else if(!empty($checkUserRight)){
	if($checkUserRight[0]['VOUCHER']==1){
	$voucherrights=$this->dataModel->getData("VOUCHER_RIGHTS",array("USR"=>$this->userData['U_ID'],"B_ID"=>$this->userData['B_ID'],"MENU"=>$checkUserRight[0]['NO']),"","");
	$this->punchData['voucherrights']=$voucherrights;
	}	
	}
	}
	else if($this->userData['U_TYPE']==0){
	$this->punchData['voucherrights']=array(array('USR'=>$this->userData['U_ID'],'MENU'=>1,'NAV'=>1,'AD'=>1,'EDIT'=>1,'DEL'=>1,'PRNT'=>1,'UNPOSTED'=>0,'POSTED'=>0,'APPROVED'=>1,'B_ID'=>$this->userData['B_ID']));	
	}
	
	}

	public function validateUser(){
	if($this->session->has_userdata("memberlogin")){
	return true;	
	}		
	else{
	return false;	
	}
	}
	
	public function cropyear(){
	$b=array();
	$year=date("Y");
	$lastyear="";
	for($a=1;$a<=8;$a++)
	{
	if($a%2==0)
	{
	$c=$year+1;	
	$lastyear=$c."-".$year;
	array_push($b,$lastyear);
	}
	else{
	array_push($b,$year);
	$year--;
	}	
	}
	return $b;
	}
	public function makeUrl($segments,$prefix,$value,$q){
	$urisegment=$prefix."_".strtolower(url_title($value));
	if(!in_array($urisegment,$segments))
	{
	array_push($segments,$urisegment);
	}
	if($q!="")
	{
	$q="/?q=".$q;	
	}
	return base_url($segments).$q;	
	}
	public function searchFilters($segments,$value,$q){
	array_splice($segments,array_search($value,$segments),1);
	if($q!="")
	{
	$q="/?q=".$q;	
	}
	$b=explode("_",$value);
	$c=str_replace("-"," ",$b[1]);
	if($b[0]=="pt")
	{
	if($c==0)
	{
	$c="Cash & Due";	
	}
	else if($c==1)
	{
	$c="Only Cash";	
	}
	else if($c==2)
	{
	$c="Only Due";	
	}		
	}
	$a='<a href="'.base_url($segments).$q.'">'. ucwords($c).' <span class="pull-right"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>';
	return $a;
	}
	public function filterSegments($regularexpression,$segments){
	$input=array_filter($segments,function($value) use($regularexpression){ return (!preg_match($regularexpression,$value)); });
	$input=array_values($input);
	return $input;
	}
	/* 
	public function ImgUploadUrl(){
	return $path="../img.mandionline.com.pk/";
	}
 */
    public function ImgUploadUrl(){
	return $path="";

	}



	public function getTradeImage($image,$thumb){
	$dir=explode("-",$image);
	$path=img_url()."trade_images/".$dir[0]."/";	
	if($thumb==true){
	$image="thumb_".$image;	
	}
	return $path.$image;
	}

	public function getTradeImageFront($image,$thumb){
	if(!empty($image))
	{	
	$dir=explode("-",$image);
	$folder=$dir[0];
	$path=img_url()."trade_images/".$folder."/";	
	if($thumb==true){
	$image="thumb_".$image;	
	}
	return $path.$image;
	}
	else{
	return $path=img_url()."no-image.jpg";		
	}
	}
	public function getImageSell($image,$thumb){	
	$path=img_url()."edit/DPICS/";	
	if($thumb==true){
	$image="thumb_".$image;	
	}
	return $path.$image;
	}
	
	
	
	public function sendSms($to,$message){
	$username='03214484487';
	$pass='03224484487';
	$mask='Sol Experts';
	// $username='03214445553';
	// $pass='mz1234';
	// $mask='MandiOnline';	
	$url = "http://weblogin.premiumsms.pk/sendsms_url.html?Username=".$username."&Password=".$pass."&From=".urlencode($mask)."&To=".urlencode($to)."&Message=".urlencode($message);
	
	//setting the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
	//curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	$data = curl_exec($ch);
	
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	
	if(!curl_errno($ch))
	{
		$info = curl_getinfo($ch);
		
		//echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];echo '<br>';
		
		//print_r($info);echo '<br>';
	}
	curl_close($httpcode);	
	}
	
	public function dateFormat($date){
	$dt=explode("/",$date);
	return $dt[2]."-".$dt[1]."-".$dt[0];
	}
	
	public function printReport($type,$report,$formula){
	$path="C:\\Inetpub\\mstradings.com\\reports\\"; 	
	$path2="C:\\Inetpub\\mstradings.com\\"; 	
	$my_report = $path."rpt\\".$report.".rpt"; 
	$filename=$report."-".$this->userData['U_ID'].".".$type;
	$forvd=base_url()."pdf&excel/".$filename;
	$myfile = $path2."pdf&excel\\".$filename;
	if($type=='pdf')
	{
	$FormatType=31;	
	}
	else if($type=='xls')
	{
	$FormatType=29;	
	}
	try{
	// $ObjectFactory= New COM("CrystalReports12.ObjectFactory.1");salmanahmed
	 $ObjectFactory= New COM("CrystalReports115.ObjectFactory.1");
	//	$ObjectFactory= New COM("CrystalReports12.ObjectFactory.");
//	$crapp = $ObjectFactory->CreateObject("CrystalRunTime.Application.11");salmanahmed
//$crapp = $ObjectFactory->CreateObject("CrystalRuntime.Application");
     $crapp = $ObjectFactory->CreateObject("CrystalDesignRunTime.Application");

				} 
			catch (exception  $e) 
			{
				echo("<br>Error on instance creation:<br>".$e->getMessage().'<p>'.$e->getTraceAsString().'</p>');
				echo "<p><pre>".print_r($e, true)."</pre></p>";
				exit;
			}

	
// Register the typelibrary.
com_load_typelib('CrystalDesignRunTime.Application');

	$creport = $crapp->OpenReport($my_report, 1);
	$creport->Database->Tables(1)->SetLogOnInfo("207.180.198.107", "HANS", "salu", "aaa123*"); 
	if($formula!=false){
	$creport->FormulaSyntax=0; 
	$creport->RecordSelectionFormula=$formula;
	}
	$creport->EnableParameterPrompting = 0;
	$creport->DiscardSavedData;
	$creport->ReadRecords();
	$creport->ExportOptions->DiskFileName=$myfile;
	$creport->ExportOptions->FormatType=$FormatType;
	$creport->ExportOptions->DestinationType=1;
	$creport->Export(false);
	$creport = null;
	$crapp = null;
	$ObjectFactory = null;
	return $forvd;
	}
	
	/* public function printReport($type,$report,$formula){
	$path="C:\\Inetpub\\vhosts\\tplcnt.net\\2019.tplcnt.net\\reports\\"; 	
	$path2="C:\\Inetpub\\vhosts\\tplcnt.net\\2019.tplcnt.net\\"; 	
	$my_report = $path."rpt\\".$report.".rpt"; 
	$filename=$report."-".$this->userData['U_ID'].".".$type;
	$forvd=base_url()."pdf&excel/".$filename;
	$myfile = $path2."pdf&excel\\".$filename;
	if($type=='pdf')
	{
	$FormatType=31;	
	}
	else if($type=='xls')
	{
	$FormatType=29;	
	}
	$ObjectFactory= new COM("CrystalReports115.ObjectFactory.1");
	$crapp = $ObjectFactory->CreateObject("CrystalRunTime.Application.9");
	$creport = $crapp->OpenReport($my_report, 1);
	$creport->Database->Tables(1)->SetLogOnInfo("173.249.35.42", "TPL19", "tpl19", "sep302*"); 
	if($formula!=false){
	$creport->FormulaSyntax=0; 
	$creport->RecordSelectionFormula=$formula;
	}
	$creport->EnableParameterPrompting = 0;
	$creport->DiscardSavedData;
	$creport->ReadRecords();
	$creport->ExportOptions->DiskFileName=$myfile;
	$creport->ExportOptions->FormatType=$FormatType;
	$creport->ExportOptions->DestinationType=1;
	$creport->Export(false);
	$creport = null;
	$crapp = null;
	$ObjectFactory = null;
	return $forvd;
	} */
	
	
}
?>