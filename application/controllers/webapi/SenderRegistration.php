<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SenderRegistration extends CI_Controller 
{
	public function getotp()
	{  
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) )
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
				
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
								$this->load->model("Paytm");
								echo $this->Paytm->remitter_registration_getotp($sendermobile,$userinfo);
								//($sendermobile,$Name,$Pincode,$userinfo);exit;
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
	public function index()
	{ 

		$header_array = array(); 
		foreach (getallheaders() as $name => $value) 
		{
			$header_array[$name]= $value;
			//echo "$name: $value\n<br>";
		}
		if(isset($header_array["authentication_key"]))
		{
		
			$header_developer_key = trim($header_array["authentication_key"]);
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				
				$json = file_get_contents('php://input');
				$json_obj = json_decode($json);
//print_r($json_obj);exit;
				if(isset($json_obj->username) && isset($json_obj->password) && isset($json_obj->sendermobile) && isset($json_obj->firstname) && isset($json_obj->lastname) && isset($json_obj->pincode) && isset($json_obj->otp) )
				{

					$username = trim($json_obj->username);
					$pwd =  trim($json_obj->password);
					$sendermobile = trim($json_obj->sendermobile);
					$firstname = trim($json_obj->firstname);
					$lastname = trim($json_obj->lastname);
					$pincode = trim($json_obj->pincode);
					$otp = trim($json_obj->otp);
					
					$userinfo = $this->db->query("
					select 
					a.user_id,
					a.businessname,
					a.username,
					a.status,
					a.usertype_name,
					a.mobile_no,
					a.mt_access,
					a.developer_key,
					info.client_ip,
					info.client_ip2,
					info.client_ip3,
					info.client_ip4
					from tblusers  a 
					left join tblusers_info info on a.user_id = info.user_id
					where a.mobile_no = ? and a.password = ?",array($username,$pwd));
					
					if($userinfo->num_rows() == 1)
					{
						$developer_key = $userinfo->row(0)->developer_key;
						$status = $userinfo->row(0)->status;
						$user_id = $userinfo->row(0)->user_id;
						$businessname = $userinfo->row(0)->businessname;
						$username = $userinfo->row(0)->username;
						$mobile_no = $userinfo->row(0)->mobile_no;
						$usertype_name = $userinfo->row(0)->usertype_name;
						$mt_access = $userinfo->row(0)->mt_access;
						
						$client_ip = $userinfo->row(0)->client_ip;
						$client_ip2 = $userinfo->row(0)->client_ip2;
						$client_ip3 = $userinfo->row(0)->client_ip3;
						$client_ip4 = $userinfo->row(0)->client_ip4;
						
						$ip = $this->common->getRealIpAddr();
						if($ip == $client_ip or $ip == $client_ip2 or $ip == $client_ip3 or $ip == $client_ip4)
						{
							if($status == '1')
							{
								if($mt_access != '1')
								{
									$resp_array = array(
										"message"=>"You Are Not Allowed To Use This Service",
										"status"=>1,
										"statuscode"=>"AUTH"
									);
									echo json_encode($resp_array);exit;
								}
								if($header_developer_key != $developer_key)
								{
									$resp_array = array(
										"message"=>"Invalid authentication_key",
										"status"=>1,
										"statuscode"=>"AUTH"
									);
									echo json_encode($resp_array);exit;
								}
								if(ctype_digit($sendermobile))
								{
									
										$rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
										if($rsltcommon->num_rows() == 1)
										{
											$is_service = $rsltcommon->row(0)->value;
											if($is_service == "DOWN")
											{
												$resp_array = array(
													"message"=>"Dmt Service Temporarily Down",
													"status"=>1,
													"statuscode"=>"ERR"
												);
												echo json_encode($resp_array);exit;
											}
										}
										$rsltsender = $this->db->query("select Id,mobile,name,lastname,pincode from mt3_remitter_registration where mobile = ? and PAYTM = 'yes'",array($sendermobile));
										if($rsltsender->num_rows() == 1)
										{
											$resp_arr = array(
													"message"=>$status,
													"status"=>0,
													"statuscode"=>"TXN",
												);
											$json_resp =  json_encode($resp_arr);
											echo $json_resp;exit;
										}
										else
										{
											$getrequest_id = $this->db->query("select * from sender_registration_getotp where sender_mobile = ? order by Id desc limit 1",array($sendermobile));
											
											if($getrequest_id->num_rows() == 1)
											{
												
												$requset_id = $getrequest_id->row(0)->request_id;
												
												$address1 = $address2 = "abc";
												$this->load->model("Paytm");
												echo $this->Paytm->remitter_registration($sendermobile,$firstname,$lastname,$address1,$address2,$pincode,$requset_id,$otp,$userinfo);
											}
											else
											{
												$resp_array = array(
													"message"=>"Something Went Wrong..".$sendermobile,
													"status"=>1,
													"statuscode"=>"ERR"
												);
												echo json_encode($resp_array);exit;
											}
										}
								}
								else
								{
									$resp_array = array(
													"message"=>"Invalid Sender Mobile Number",
													"status"=>1,
													"statuscode"=>"ERR"
												);
									echo json_encode($resp_array);exit;
								}
								
							}
							else
							{
								$resp_array = array(
													"message"=>"Your Account Not Active",
													"status"=>1,
													"statuscode"=>"AUTH"
												);
								echo json_encode($resp_array);exit;
							}
						}
						else
						{
							$resp_array = array(
													"message"=>"Invalid Ip Address [".$ip."]",
													"status"=>1,
													"statuscode"=>"AUTH"
												);
							echo json_encode($resp_array);exit;
						}
					}
					else
					{
						$resp_array = array(
												"message"=>"UserId Or Password Invalid",
												"status"=>1,
												"statuscode"=>"AUTH"
											);
						echo json_encode($resp_array);exit;
					}
					
					
				}
				else
				{
					$resp_array = array(
												"message"=>"Parameter Missing.",
												"status"=>1,
												"statuscode"=>"ERR"
											);
					echo json_encode($resp_array);exit;
				}			
			}
			else
			{
				$resp_array = array(
												"message"=>"Something Went Wrong..2",
												"status"=>1,
												"statuscode"=>"ERR"
											);
				echo json_encode($resp_array);exit;
			}
		}
		else
		{
			$resp_array = array(
												"message"=>"authentication_key Not Found",
												"status"=>1,
												"statuscode"=>"AUTH"
											);
			echo json_encode($resp_array);exit;
		}
		
		
		
	
	
	}	
	public function checkexist()
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']) )
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$sendermobile = trim($_GET['sendermobile']);
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
							echo "NO";exit;
						}
						if(ctype_digit($sendermobile))
						{
							
							    $rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
							    if($rsltcommon->num_rows() == 1)
							    {
							        $is_service = $rsltcommon->row(0)->value;
							    	if($is_service == "DOWN")
							    	{
							    	    echo "NO";exit;
							    	}
							    }
								$rsltsender = $this->db->query("select Id from mt3_remitter_registration where mobile = ? and PAYTM = 'yes'",array($sendermobile));
								if($rsltsender->num_rows() == 1)
								{
								
									echo "yes";
								}
								else
								{
									$this->load->model("Paytm");
									echo $this->Paytm->is_sender_exist($sendermobile,$userinfo);
								}
						}
						else
						{
							echo "NO";exit;
						}
						
					}
					else
					{
						echo "NO";exit;
					}
				}
				else
				{
					echo "NO";exit;
				}
				
				
			}
			else
			{
				echo "NO";exit;
			}			
		}
		else
		{
			echo "NO";exit;
		}
	}
	public function getpaytmbalance()
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['key']) )
			{
				$key = trim($_GET['key']);
				if($key == "vffhb1sdsfdawephwlbjhbvd5351ubjh")
				{
					$this->load->model("Paytm");
					echo $this->Paytm->getBalance();exit;
				}
				
				
			}
			else
			{
				echo "";exit;
			}			
		}
		else
		{
			echo "";exit;
		}
	}
}
