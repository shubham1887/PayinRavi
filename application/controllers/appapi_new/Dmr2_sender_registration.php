<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr2_sender_registration extends CI_Controller {
	
	public function index()
	{ 
		//http://www.rechargeunlimited.com/appapi1/dmr2_sender_registration?username=100001&password=777&sendermobile=9898946699&Name=kamleshbhhai&Pincode=380052&idstr=ZFXXFX
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) && isset($_GET['Name']) && isset($_GET['lastname']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
				$Name = trim($_GET['Name']);
				$lastname = trim($_GET['lastname']);
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where username = ?  and password = ?",array($username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->businessname;
					$username = $userinfo->row(0)->username;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					
					$mt_access = $userinfo->row(0)->mt_access;
					if($status == '1')
					{
						/*if($mt_access != '1')
						{
							$resp_arr = array(
								"message"=>"You Dont Have Permission to Use DMR. Please Contact Administrator",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}*/
						if(ctype_digit($sendermobile))
						{
							
							
								$this->load->model("Shootcase");
								echo $this->Shootcase->remitter_registration($sendermobile,$Name,$lastname,$userinfo);
						}
						else
						{
							$resp_arr = array(
								"message"=>"Invalid Mobile Number",
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
