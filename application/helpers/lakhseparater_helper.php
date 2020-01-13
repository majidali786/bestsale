<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('lakhseparater'))
{
    function lakhseparater($num,$decimal=0)
    {
	$num=round($num,$decimal);	
	$decimal="";
	$a=explode(".",$num);
	$num=$a[0];
    if(setlocale(LC_MONETARY, 'en_IN'))
      return money_format('%.0n', $num);
	else {
      $explrestunits = "" ;
      if(strlen($num)>3){
          $lastthree = substr($num, strlen($num)-3, strlen($num));
          $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
          $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
          $expunit = str_split($restunits, 2);
          for($i=0; $i<sizeof($expunit); $i++){
              // creates each of the 2's group and adds a comma to the end
              if($i==0)
              {
                  $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
              }else{
                  $explrestunits .= $expunit[$i].",";
              }
          }
          $thecash = $explrestunits.$lastthree;
      } else {
          $thecash = $num;
      }
	  if(!empty($a[1])){
	  $thecash=$thecash.".".$a[1]; 
	  }
	  
      return $thecash;
    }
    }   
}
?>