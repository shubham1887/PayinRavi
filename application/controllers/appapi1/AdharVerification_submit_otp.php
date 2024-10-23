<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AdharVerification_submit_otp extends CI_Controller { 
    private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
		 error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $this->db->db_debug = TRUE;
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
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
        if(isset($_GET['username']) && isset($_GET['password'])  && isset($_GET['client_id'])  && isset($_GET['otp'])  && isset($_GET['mobile_number']))
        {
            $username = $_GET['username'];
            $pwd =  $_GET['password'];
            $client_id =  $_GET['client_id'];
            $otp =  $_GET['otp'];
            $mobile_number =  $_GET['mobile_number'];

            if(!is_numeric($otp))
            {
                $message = "ERROR::Please Enter VALID OTP";
                $status = "1";
                $statuscode = "ERR";
                $this->DownlineResponse($status,$statuscode,$message);
            }
            if(!is_numeric($username))
            {
                $message = "ERROR::Please Enter VALID USERNAME";
                $status = "1";
                $statuscode = "ERR";
                $this->DownlineResponse($status,$statuscode,$message);
            }
            if(strlen($username) != 10)
            {
                $message = "ERROR::Please Enter VALID USERNAME.";
                $status = "1";
                $statuscode = "ERR";
                $this->DownlineResponse($status,$statuscode,$message);
            }



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
$rsltcheck = $this->db->query("select * from adhar_verification where Date(add_date) = ? and client_id = ? ",array($this->common->getMySqlDate(),$client_id));
if($rsltcheck->num_rows() == 1)
{
    $url = 'https://pdrs.online/API2/AdharVerification_submit_otp?username='.$this->getUsername().'&password='.$this->getPassword().'&token='.$this->getToken().'&client_id='.$client_id.'&otp='.$otp.'&mobile_number='.$mobile_number;
    $buffer = $response = $this->common->callurl($url);
$json_obj = json_decode($buffer);
if(isset($json_obj->status_code))
{
        $status_code = trim($json_obj->status_code);
        $message_code = trim($json_obj->message_code);
        $message = trim($json_obj->message);
        if($status_code == "200")
        {
            $status_code = trim($json_obj->status_code);
            $message_code = trim($json_obj->message_code);
            $message = trim($json_obj->message);
            $success = trim($json_obj->success);
            $data = $json_obj->data;

            $this->db->query("update tblusers set adhar_verified = 'yes' where user_id = ?",array($user_id));
            $client_id = "";
            $otp_sent = "";
            $if_number = "";
            $valid_aadhaar = "";
            if(isset($data->client_id))
            {
                $client_id = trim($data->client_id);
                $full_name = trim($data->full_name);
                $aadhaar_number  = trim($data->aadhaar_number);
                $dob = trim($data->dob);
                $gender = trim($data->gender);
                $address = $data->address;
                    $country = trim($address->country);
                    $dist = trim($address->dist);
                    $state = trim($address->state);
                    $po = trim($address->po);
                    $loc = trim($address->loc);
                    $vtc = trim($address->vtc);
                    $subdist = trim($address->subdist);
                    $street = trim($address->street);
                    $house = trim($address->house);
                    $landmark = trim($address->landmark);
                $face_status = trim($data->face_status);
                $face_score = trim($data->face_score);
                $zip = trim($data->zip);
                $profile_image = trim($data->profile_image);
                $has_image = trim($data->has_image);
                $raw_xml = trim($data->raw_xml);
                $zip_data = trim($data->zip_data);
                $care_of = trim($data->care_of);
                $share_code = trim($data->share_code);
                $mobile_verified = trim($data->mobile_verified);
                $reference_id = trim($data->reference_id);
                $aadhaar_pdf = trim($data->aadhaar_pdf);
            }
            
            $add_date = $this->common->getDate();
            $ipaddress = $this->common->getRealIpAddr();
            $this->db->query("insert into adhar_data(user_id, add_date, ipaddress, client_id, full_name, aadhaar_number, dob, gender, country, dist, state, po, loc, vtc, subdist, street, house, landmark, face_status, face_score, zip, profile_image, has_image, raw_xml, zip_data, care_of, share_code, mobile_verified, reference_id, aadhaar_pdf) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($user_id, $add_date, $ipaddress, $client_id, $full_name, $aadhaar_number, $dob, $gender, $country, $dist, $state, $po, $loc, $vtc, $subdist, $street, $house, $landmark, $face_status, $face_score, $zip, $profile_image, $has_image, $raw_xml, $zip_data, $care_of, $share_code, $mobile_verified, $reference_id, $aadhaar_pdf));
            
            $resp_array = array(
                "status"=>"0",
                "statuscode"=>"TXN",
                "message"=>$message,
                "profile_image"=>$profile_image,
                "full_name"=>$full_name
            );
            echo json_encode($resp_array);exit;


           // echo $buffer;exit;

        }
        else
        {
          
            $resp_array = array(
                "status"=>"1",
                "statuscode"=>"ERR",
                "message"=> $message
            );
            echo json_encode($resp_array);exit;
        }
    }
else 
{
   
    $message = "Some Error Occured. Please Try After Some Time..";
    $status = "1";
    $statuscode = "ERR";
    $this->DownlineResponse($status,$statuscode,$message);
}
}
else
{
$message = "ERROR::Invalid Client Id";
$status = "1";
$statuscode = "ERR";
$this->DownlineResponse($status,$statuscode,$message);
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
