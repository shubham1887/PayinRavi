<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class White { 
	public function getName()
	{
		$root = strtoupper($_SERVER['HTTP_HOST']);
		$stbstrdomain  = substr($root,0,4); 
		if($stbstrdomain == "WWW.")
		{
			$domainname = str_replace("WWW.",'',$root);	
			return $domainname;
		}
		else
		{
			return $root;
		}										
	}
	public function getDomainName()
	{
		$root = "http://".$_SERVER['HTTP_HOST'];
		$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		$host = parse_url($root, PHP_URL_HOST);
		$host = str_replace('http://', '',$host);
	    $host = str_replace('www.', '',$host);
	    return strtoupper($host);										
	}
	public function getRoot()
	{
		$root = "http://".$_SERVER['HTTP_HOST'];
		$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
		
	    return $root;										
	}
	
}