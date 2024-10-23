<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AdharVerification_get_otp extends CI_Controller { 
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
		 // error_reporting(E_ALL);
   //      ini_set('display_errors', 1);
   //      $this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');

        /*
        https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/generate-otp
        https://kyc-api.aadhaarkyc.io/api/v1/aadhaar-v2/submit-otp
        */
    }
    private function DownlineResponse($status,$statuscode,$message)
    {
        $resp_array = array(
                "status"=>$status,
                "statuscode"=>$statuscode,
                "message"=>$message
            );
        echo json_encode($resp_array);exit;
    }
    private function getToken()
    {
        $rslt = $this->db->query("SELECT param1,param2,param3 FROM api_configuration where api_name = 'PDRS'");
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->param3;
        }
        return "";
    }
    private function getUsername()
    {
        $rslt = $this->db->query("SELECT param1,param2,param3 FROM api_configuration where api_name = 'PDRS'");
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->param1;
        }
        return "";
    }
    private function getPassword()
    {
        $rslt = $this->db->query("SELECT param1,param2,param3 FROM api_configuration where api_name = 'PDRS'");
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->param2;
        }
        return "";
    }

    public function index()
    {
        if(isset($_GET['username']) && isset($_GET['password'])  && isset($_GET['aadhaar_number']))
        {
            $username = $_GET['username'];
            $pwd =  $_GET['password'];
            $aadhaar_number =  $_GET['aadhaar_number'];
            $userinfo = $this->db->query("select * from tblusers where mobile_no = ? and password = ?",array($username,$pwd));
            if($userinfo->num_rows() == 1)
            {
                $user_id = $userinfo->row(0)->user_id;
                $user_status = $userinfo->row(0)->status;
                $usertype_name = $userinfo->row(0)->usertype_name;
                if($userinfo->row(0)->usertype_name == "Agent" or $userinfo->row(0)->usertype_name == "Distributor" or $userinfo->row(0)->usertype_name == "MasterDealer" or $userinfo->row(0)->usertype_name == "APIUSER")
                {
                    if($user_status == "1")
                    {
                    
                            $user_id = $userinfo->row(0)->user_id;
                            if($userinfo->row(0)->usertype_name == "Agent" or $userinfo->row(0)->usertype_name == "Distributor" or $userinfo->row(0)->usertype_name == "MasterDealer" or $userinfo->row(0)->usertype_name == "APIUSER")
                            {
                                if($userinfo->row(0)->status == "1")
                                {

$add_date = $this->common->getDate();
$ipaddress = $this->common->getRealIpAddr();                                        
$rsltcheck = $this->db->query("insert into adhar_verification(add_date,ipaddress,adhaar_number,user_id) values(?,?,?,?)",array($add_date,$ipaddress,$aadhaar_number,$user_id));
if($rsltcheck == true)
{
    $insert_id = $this->db->insert_id();   
    $url = 'https://pdrs.online/API2/AdharVerification_get_otp?username='.$this->getUsername().'&password='.$this->getPassword().'&token='.$this->getToken().'&aadhaar_number='.$aadhaar_number;
  //  echo $url;exit;

    $buffer = $response = $this->common->callurl($url);
    
    $json_obj = json_decode($buffer);
    if(isset($json_obj->statuscode))
    {
        $statuscode = trim($json_obj->statuscode);
        $message = trim($json_obj->message);
        $status = trim($json_obj->status);
        if($statuscode == "TXN")
        {
           $client_id = trim($json_obj->client_id);
           

                $this->db->query("update adhar_verification set client_id = ?,status_code=?,message_code=?,message=? where Id = ?",array($client_id,$statuscode,$status,$message,$insert_id));
            
                $resp_array = array(
                    "status"=>"0",
                    "statuscode"=>"TXN",
                    "message"=>$message,
                    "client_id"=>$client_id
                );
                echo json_encode($resp_array);exit;

        }
        else
        {
            $this->db->query("update adhar_verification set status_code=?,message_code=?,message=? where Id = ?",array($statuscode,$status,$message,$insert_id));
            $statuscode = "1";
            $statuscode = "ERR";
            $this->DownlineResponse($status,$statuscode,$message);
        }
    }
    else 
    {
        $status_code = "UNK";
        $message_code = "UNK";
        $message = "Unknown Response or No Response Fro Server";
        $this->db->query("update adhar_verification set status_code=?,message_code=?,message=? where Id = ?",array($statuscode,$status,$message,$insert_id));
        $message = "Some Error Occured. Please Try After Some Time..";
        $status = "1";
        $statuscode = "ERR";
        $this->DownlineResponse($status,$statuscode,$message);
    }
}
                                }
                                else
                                {
                                    $message = "ERROR::Your Activation disabled, Contact Administrator";
                                    $status = "1";
                                    $statuscode = "ERR";
                                    $this->DownlineResponse($status,$statuscode,$message);
                                }
                            }
                            else
                            {
                                $message = "ERROR::Invalid Access";
                                $status = "1";
                                $statuscode = "ERR";
                                $this->DownlineResponse($status,$statuscode,$message);
                            }
                        
                        
                    }
                    else
                    {
                        $message = "ERROR::Account Deactive";
                        $status = "1";
                        $statuscode = "ERR";
                        $this->DownlineResponse($status,$statuscode,$message);
                    }
                }
                else
                {
                    $message = "ERROR::Invalid Access";
                    $status = "1";
                    $statuscode = "ERR";
                    $this->DownlineResponse($status,$statuscode,$message);
                }
            }
            else
            {
                $message = "ERROR::ERROR::Authentication Fail";
                $status = "1";
                $statuscode = "ERR";
                $this->DownlineResponse($status,$statuscode,$message);
                
            }
        }
        else
        {
            $message = "Some Perameter Missing";
            $status = "1";
            $statuscode = "ERR";
            $this->DownlineResponse($status,$statuscode,$message);
        }                    
    }
}
