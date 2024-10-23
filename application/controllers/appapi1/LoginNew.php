<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginNew extends CI_Controller {
	
	public function index()
	{ 
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;

		if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['device_id']))
		{
			$username = $_GET['username'];
			$pwd =  substr($_GET['pwd'],0,20);
			$device_id =  $_GET['device_id'];
			if(strlen($username) == 10)
			{
				$userinfo = $this->db->query("select user_id,businessname,username,mobile_no,status from tblusers where username = ? and password = ?",array($username,$pwd));	
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->businessname;
					$usertype_name = $userinfo->row(0)->usertype_name;
					$status = $userinfo->row(0)->status;
					if($status == '1')
					{
						$check_devices_rslt = $this->db->query("select 
							device1_imei,device2_imei,device3_imei, 
							device1_otp,device2_otp,device3_otp, 
							device1_status,device2_status,device3_status
							from tblusers_login_devices 
							where 
							user_id = ? ",
							array($user_id));
						if($check_devices_rslt->num_rows() == 1)
						{

						}
						else
						{
							$otp = rand(1111111,999999);
							$rsltinsertNewDevice = $this->db->query("insert into tblusers_login_devices(user_id,device1_imei,device1_otp) values(?,?,?)",array($user_id,$device1_imei,$otp));
							if($rsltinsertNewDevice == true)
							{
								$sms_message = 'MyPayMall user LOGIN verification OTP '.$otp.'. MyPayMall will never call for OTP. Sharing it with anyone gives them full access to your MyPayMall Terminal';		
								$result_sms = $this->common->ExecuteSMSApi($username,$sms_message);	
								$resp_array = array(
									"status"=>"2",
									"message"=>"Otp Sent To Registered Mobile Number"
								);
								echo json_encode($resp_array);exit;
							}
						}
					}
					else
					{
						$resp_array = array(
							"status"=>"1",
							"message"=>"Your Account Deactivated"
						);
						echo json_encode($resp_array);exit;
					}
				}
			}
			

		}
		else
		{echo 'Paramenter is missing';exit;}			
				
	
	
	}	
	
}
