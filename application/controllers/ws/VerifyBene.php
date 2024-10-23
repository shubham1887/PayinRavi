<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyBene extends CI_Controller {
	
	public function index()
	{ 
		//echo "fdgsdfgdfsg";exit;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile'])  && isset($_GET['account_number'])  && isset($_GET['ifsc']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
				$account_number = trim($_GET['account_number']);
				$ifsc = trim($_GET['ifsc']);

$bank  = "";

				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where mobile_no = ? and password = ?",array($username,$pwd));
				
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
						if($mt_access != '1')
						{
							
							$resp_arr = array(
								"message"=>"You Dont Have Permission to Use DMR. Please Contact Administrator",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						if(ctype_digit($sendermobile))
						{
							
							    $rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
							    if($rsltcommon->num_rows() == 1)
							    {
							        $is_service = $rsltcommon->row(0)->value;
							    	if($is_service == "DOWN")
							    	{
							    	    $resp_arr = array(
            								"message"=>"Service Temporarily Down",
            								"status"=>1,
            								"statuscode"=>"ERR",
            								);
            							$json_resp =  json_encode($resp_arr);
            							echo $json_resp;exit;
							    	}
							    }
							
								//$this->load->model("Bankit");
								//echo $this->Bankit->verify_bene($sendermobile,$account_number,$ifsc,$userinfo);exit;

								$this->load->model("Paytm");
								echo $this->Paytm->verify_bene($sendermobile,$account_number,$ifsc,"",$userinfo);exit;
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
