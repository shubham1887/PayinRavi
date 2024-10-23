<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr3_sender_otpvalidation extends CI_Controller {
	
	public function index()
	{ 
	    $this->db->db_debug = TRUE;
						    error_reporting(E_ALL);
						    ini_set('display_errors',1);
		//http://demo.mpayonline.co/appapi1/dmr2_sender_otpvalidation?username=&password=&sendermobile=&otp=
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) && isset($_GET['otp']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
				$otp = trim($_GET['otp']);
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no from tblusers where username = ?  and password = ?",array($username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->businessname;
					$username = $userinfo->row(0)->username;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					
					if($status == '1')
					{
						if(ctype_digit($sendermobile))
						{
						    $requestid_rslt = $this->db->query("select request_id,firstname,lastname,pincode from sender_registration_getotp where sender_mobile = ? order by Id desc limit 1",array($sendermobile));
					        if($requestid_rslt->num_rows() == 1)
					        {
					          $requset_id = $requestid_rslt->row(0)->request_id;
					          $fname = $requestid_rslt->row(0)->firstname;
					          $lName = $requestid_rslt->row(0)->lastname;
					          $pincode = $requestid_rslt->row(0)->pincode;
					           $address1 = "ahmedabad";
        						$address2 = "gujarat";
					          $this->load->model("Paytm");
					          echo $this->Paytm->remitter_registration($sendermobile,$fname,$lName,$address1,$address2,$pincode,$requset_id,$otp,$userinfo);exit;
					        }
					       // echo $number." ".$fname." ".$lName." ".$pinCode." ".$otp."  ".$requset_id;exit;
					        
						}
						else
						{
							$resp_arr = array(
								"message"=>"Invalid Remitter Id",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						
					}
					else
					{
						$resp_arr = array(
							"message"=>"Your account is deactivated. contact your Administrator",
							"status"=>1,
							"statuscode"=>"ERR",
						);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
					}
				}
				else
				{
					$resp_arr = array(
						"message"=>"Authentication Failed",
						"status"=>1,
						"statuscode"=>"ERR",
					);
					$json_resp =  json_encode($resp_arr);
					echo $json_resp;exit;
				}
				
				
			}
			else
			{
				$resp_arr = array(
							"message"=>"Invalid Input",
							"status"=>1,
							"statuscode"=>"ERR",
						);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}			
		}
		else
		{
			$resp_arr = array(
							"message"=>"Invalid Input",
							"status"=>1,
							"statuscode"=>"ERR",
						);
			$json_resp =  json_encode($resp_arr);
			echo $json_resp;exit;
		}
		
		
	
	
	}	
}
