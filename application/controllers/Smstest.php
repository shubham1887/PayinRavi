<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Smstest extends CI_Controller 
{ 
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
    public function index()
    {
        $mobile_no = "8238232303";
        $message = 'Dear Customer, INR 1000 To Ac No: 964000102016012 ,Beneficiary Name: ravikant And Your IMPS Ref No. is: 10012135654 is Successful.';
        $this->ExecuteSMSApi($mobile_no,$message);
    }
    public function ExecuteSMSApi($mobile_no,$message,$template_id = "")
    {
        
        $this->load->model('Sms');

        $this->load->model('Api_model');
        $smsapi = $this->Api_model->getsmsapi();
        //$this->Sms->insertintable($mobile_no,$message); 
        //$message = rawurlencode($message);


        echo $message."<br>";

        $url =urldecode( $this->Api_model->getsmsapiurl($smsapi));
        $url = str_replace("[to]",$mobile_no,$url);
        $url = str_replace("[message]",urlencode($message),$url);
        $url = str_replace("[template_id]",urlencode($template_id),$url);
        echo $url."<br>";
        $opcode = 'aeb9aaa4812159dfrww112'; 
        $mobileno =$mobile_no;
        $message = $message;
        

        //echo $url;exit;
        
         $this->Api_model->smslog($url);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $buffer = curl_exec($ch);
        
        curl_close($ch);
        echo $buffer;exit;
       // $this->Sms->addSentMessage($mobile_no,$message,$buffer);
        
            
        return $buffer;
    }
}