<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('num$bertowords'))
{
function numbertowords($number)
{
	$nm=explode(".",$number);
	$number=$nm[0];
    
		$a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
		$c = ['zero', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine '];
	$b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    if ( strlen($number) > 9) return 'overflow';
	preg_match("/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/",sprintf('%09d',$number),$n);
    if (!$n) return;
    $str = '';
	if($n[1] != 0){
	if(!empty($a[$n[1]])){
	$abc=$a[$n[1]];
	}
	else{
	$abc=$b[$n[1][0]] . ' ' . $a[$n[1][1]];	
	}
	$abc.='crore ';
	}
	else{
	$abc='';	
	}
	$str.=$abc;
	if($n[2] != 0){
	if(!empty($a[$n[2]])){
	$abc=$a[$n[2]];
	}
	else{
	$abc=$b[$n[2][0]] . ' ' . $a[$n[2][1]];	
	}
	$abc.='lakh ';
	}
	else{
	$abc='';	
	}
	$str.=$abc;
	if($n[3] != 0){
	if(!empty($a[$n[3]])){
	$abc=$a[$n[3]];
	}
	else{
	$abc=$b[$n[3][0]] . ' ' . $a[$n[3][1]];	
	}
	$abc.='thousand ';
	}
	else{
	$abc='';	
	}
	$str.=$abc;
	if($n[4] != 0){
	if(!empty($a[$n[4]])){
	$abc=$a[$n[4]];
	}
	else{
	$abc=$b[$n[4][0]] . ' ' . $a[$n[4][1]];	
	}
	$abc.='hundred ';
	}
	else{
	$abc='';	
	}
	$str.=$abc;
	if($n[5] != 0){
	if($str!=""){
	$str.='and ';	
	}
	if(!empty($a[$n[5]])){
	$abc=$a[$n[5]];
	}
	else{
	$abc=$b[$n[5][0]] . ' ' . $a[$n[5][1]];	
	}
	}
	else{
	$abc='';	
	}
	$str.=$abc;
	if(!empty($nm[1]) && $nm[1]!=""){
	$dc=str_split($nm[1]);
	$str .=" point ".$c[$dc[0]];
	if(!empty($dc[1]) && $dc[1]>0){
	$str .=" ".$c[$dc[1]];	
	}
	}
    return $str;
}
	
	
}
?>