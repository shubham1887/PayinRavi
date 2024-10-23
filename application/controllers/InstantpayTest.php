<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class InstantpayTest extends CI_Controller { 
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
		 error_reporting(E_ALL);
ini_set('display_errors', 1);
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
    public function getbanklist()
    {
        $postparam = '{"token": "232612cff9f1ea3c6dfaaee8e37772ef","request": {"account": ""}}';
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        //
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,'https://www.instantpay.in/ws/utilities/banks');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postparam);
        $buffer = curl_exec($ch);
        curl_close($ch);
        
        //echo $buffer;exit;
        $json_obj = json_decode($buffer);
        print_r($json_obj);exit;
    }
    
}
