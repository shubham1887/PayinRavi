<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_direct_one extends CI_Controller 
{
	private function checkduplicate_order_id($order_id,$user_id)
	{
		$rslt = $this->db->query("insert into locking_order_id	(user_id,order_id,add_date,ipaddress) values(?,?,?,?)",
		array($user_id,$order_id,$this->common->getDate(),$this->common->getRealIpAddr()));
		  if($rslt == true)
		  {
			return true;
		  }
		  else
		  {
			return false;
		  }
	}
	public function inputlog($user_id,$request,$response)
	{
		// error_reporting(-1);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;

		// $add_date = $this->common->getDate();
		// $ipaddress = $this->common->getRealIpAddr();
		// $this->db->query("insert into apiuser_request_log(user_id,add_date,ipaddress,input_request,response,order_id)
		// 													values(?,?,?,?,?,?)",
		// 					array($user_id,$add_date,$ipaddress,$request,$response,""));
	}
	public function index()
	{ 
	    
	    
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
		$header_array = array(); 
		foreach (getallheaders() as $name => $value) 
		{
			$header_array[$name]= $value;
		//	echo "$name: $value\n<br>";
		}
		if(isset($header_array["Authkey"]))
		{
		
			$header_developer_key = trim($header_array["Authkey"]);
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				
				$json = file_get_contents('php://input');
				$this->inputlog(0,$json,"");
				$json_obj = json_decode($json);
				if(isset($json_obj->username) && isset($json_obj->password) && isset($json_obj->sendermobile) && isset($json_obj->benificiary_name) && isset($json_obj->benificiary_ifsc) && isset($json_obj->benificiary_account_no) && isset($json_obj->benificiary_mobile) && isset($json_obj->bank_id) && isset($json_obj->amount) && isset($json_obj->mode) && isset($json_obj->order_id) )
				{
					$username = trim($json_obj->username);
					$pwd =  trim($json_obj->password);
					$sendermobile = trim($json_obj->sendermobile);
					$benificiary_name = trim($json_obj->benificiary_name);
					$benificiary_ifsc = trim($json_obj->benificiary_ifsc);
					$benificiary_account_no = trim($json_obj->benificiary_account_no);
					$benificiary_mobile = trim($json_obj->benificiary_mobile);
					$bank_id = trim($json_obj->bank_id);
					$amount = trim($json_obj->amount);
					$mode = trim($json_obj->mode);
					$order_id = trim($json_obj->order_id);





				
					$userinfo = $this->db->query("
					select 
					a.user_id,
					a.parentid,
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
									$this->inputlog(0,"",json_encode($resp_array));
									echo json_encode($resp_array);exit;
								}
								if($header_developer_key != $developer_key)
								{
									$resp_array = array(
										"message"=>"Invalid authentication_key",
										"status"=>1,
										"statuscode"=>"AUTH"
									);
									$this->inputlog(0,"",json_encode($resp_array));
									echo json_encode($resp_array);exit;
								}


								$balance = $this->Ew2->getAgentBalance($user_id);
								if($balance <= $amount)
								{
									$resp_array = array(
													"message"=>"InSufficient Balance",
													"status"=>1,
													"statuscode"=>"ERR"
												);
									$this->inputlog(0,"",json_encode($resp_array));
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
												$this->inputlog(0,"",json_encode($resp_array));
												echo json_encode($resp_array);exit;
											}
										}
								
									    if($this->checkduplicate_order_id($order_id,$user_id))
										{
											$this->load->model("Airtel_model");
											$resparray = array();
											$userinfo_balance = $this->db->query("select balance from tblusers where user_id = ? and user_id > 1",array(intval($user_id)));
											if($userinfo_balance->num_rows() == 1)
											{


					
												$resp =   $this->Airtel_model->transfer_direct($sendermobile,$benificiary_name,$benificiary_mobile,$benificiary_ifsc,$benificiary_account_no,$amount,$mode,$userinfo,$order_id);
												echo $resp;exit;
											}	
											else
											{
												$resp_arr = array(
													"message"=>"Something Went Wrong",
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
												"message"=>"Duplicate Entry.Try After 1 Hour",
												"status"=>1,
												"statuscode"=>"ERR",
												);
											$json_resp =  json_encode($resp_arr);
											$this->inputlog(0,"",json_encode($resp_arr));
											echo $json_resp;exit;
										}
									
								}
								else
								{
									$resp_array = array(
													"message"=>"Invalid Sender Mobile Number",
													"status"=>1,
													"statuscode"=>"ERR"
												);
									$this->inputlog(0,"",json_encode($resp_array));
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
								$this->inputlog(0,"",json_encode($resp_array));
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
							$this->inputlog(0,"",json_encode($resp_array));
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
						$this->inputlog(0,"",json_encode($resp_array));
						echo json_encode($resp_array);exit;
					}
					
					
				}
				else
				{
					$resp_array = array(
												"message"=>"Parameter Missing",
												"status"=>1,
												"statuscode"=>"ERR"
											);
					$this->inputlog(0,"",json_encode($resp_array));
					echo json_encode($resp_array);exit;
				}			
			}
			else
			{
				$resp_array = array(
												"message"=>"Something Went Wrong",
												"status"=>1,
												"statuscode"=>"ERR"
											);
				$this->inputlog(0,"",json_encode($resp_array));
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
			$this->inputlog(0,"",json_encode($resp_array));
			echo json_encode($resp_array);exit;
		}
	}	




	public function getsenderlimit()
	{ 
	    
	    
	   // error_reporting(-1);
	   // ini_set('display_errors',1);
	   // $this->db->db_debug = TRUE;
		$header_array = array(); 
		foreach (getallheaders() as $name => $value) 
		{
			$header_array[$name]= $value;
		//	echo "$name: $value\n<br>";
		}
		if(isset($header_array["Authkey"]))
		{
		
			$header_developer_key = trim($header_array["Authkey"]);
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				
				$json = file_get_contents('php://input');
				$this->inputlog(0,$json,"");
				$json_obj = json_decode($json);
				if(isset($json_obj->username) && isset($json_obj->password) && isset($json_obj->sendermobile) )
				{
					$username = trim($json_obj->username);
					$pwd =  trim($json_obj->password);
					$sendermobile = trim($json_obj->sendermobile);
					
				
					$userinfo = $this->db->query("
					select 
					a.user_id,
					a.parentid,
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
									echo "";exit;
								}
								if($header_developer_key != $developer_key)
								{
									echo "";exit;
								}
								$this->load->model("Mastermoney");
								$resp =   $this->Mastermoney->transfer2_direct_senderlimit($sendermobile);
								echo $resp;exit;	
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
