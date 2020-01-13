<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('num$bertowords'))
{
function removecommas($number)
{
$str=preg_replace("/,/",'',$number);	
return $str;
}
	
	
}
?>