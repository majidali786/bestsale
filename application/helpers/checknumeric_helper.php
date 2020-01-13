<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('num$bertowords'))
{
function checknumeric($number)
{
return preg_match("/^[0-9,]+(\.[0-9]+)$/",$number);	
}
	
	
}
?>