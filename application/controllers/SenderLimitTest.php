<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class SenderLimitTest extends CI_Controller { 
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
    public function getApiName($apiname,$api_id,$remittermobile,$amount,$userinfo)
    {
       // echo $apiname;exit;
        if($apiname == "PAYTM")
        {
            $paytm_limit = $this->remitter_details_limit($remittermobile,$userinfo);
            if($paytm_limit >= $amount)
            {
                $API_NAME = "PAYTM";
            }   
        }
        else if($apiname == "AIRTEL")
        {
            $this->load->model("Airtel_model");
            $airtel_limit = $this->Airtel_model->getSenderLimit_airtel($remittermobile);    
            if($airtel_limit >= $amount)
            {
                $API_NAME = "AIRTEL";
            }   
        }
        else if($apiname == "ZPULS")
        {
            $this->load->model("Api_model");
            $zpbalance = $this->Api_model->getBalance($api_id);
           // echo $zpbalance;exit;
            if($zpbalance > ($amount + 15))
            {
                $this->load->model("Zpuls_model");
                $zplimit = $this->Zpuls_model->getsenderlimit($remittermobile);
                if($zplimit >= $amount)
                {
                    $API_NAME = "ZPULS";
                }       
            }
        }
        else 
        {
            $API_NAME = "HOLD";
        }
        return $API_NAME;
    }
    public function index()
    {
        if(isset($_GET["number"]))
        {

            $this->load->model("Paytm");
            $this->load->model("Zpuls_model");
            $this->load->model("Airtel_model");
            
            $userinfo = $this->db->query("select * from tblusers where mobile_no = 8080623623");
            $number = trim($this->input->get("number"));
            $amount = 5000;
            $api_info = $this->db->query("select 
                                                a.Id,
                                                a.api_name,
                                                a.priority,
                                                a.is_dmt,
                                                a.is_active
                                                from api_configuration  a 
                                                
                                                where a.is_dmt = 'yes' and a.is_active = 'yes' order by a.priority");

            foreach($api_info->result() as $rwapi)
            {
                $API_NAME = $this->getApiName($rwapi->api_name,$rwapi->Id,$number,$amount,$userinfo);
               // echo $API_NAME;exit;
                if($API_NAME != "HOLD")
                {
                    break;
                }
            }
            echo $API_NAME."<br>";
            echo "<hr>";


            
            
            $paytm_limit = "PAYTM LIMIT : ".$this->Paytm->remitter_details_limit($number,$userinfo);
            echo $paytm_limit;
            echo "<br>";

            $airtel_limit = "AIRTEL LIMIT : ".$this->Airtel_model->getSenderLimit_airtel($number);
            echo $airtel_limit;
            echo "<br>";


            $zplimit = "ZPLUS LIMIT : ".$this->Zpuls_model->getsenderlimit($number);
            echo $zplimit;
            echo "<br>";exit;
        }
    }
    
}
