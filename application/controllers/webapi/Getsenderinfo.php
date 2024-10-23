<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getsenderinfo extends CI_Controller 
{
	public function index()
	{ 

		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;

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

				if(isset($json_obj->username) && isset($json_obj->password) &&  isset($json_obj->sendermobile) )
				{
					$username = trim($json_obj->username);
					$pwd =  trim($json_obj->password);
					$sendermobile =  trim($json_obj->sendermobile);
					
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
												$resp_arr = array(
													"message"=>"Service Temporarily Down",
													"status"=>1,
													"statuscode"=>"ERR",
													);
												$json_resp =  json_encode($resp_arr);
												echo $json_resp;exit;
											}
										}
									
										$this->load->model("Paytm");
										$senderinfo =  json_decode($this->Paytm->remitter_details($sendermobile,$userinfo));
										
										if(isset($senderinfo->status))
										{
											$status = trim((string)$senderinfo->status);
											$response_code = trim((string)$senderinfo->response_code);
											if($status == "success" and $response_code == "0")
											{
		
												
												$firstName = $senderinfo->firstName;
												$lastName = $senderinfo->lastName;
												$customerMobile = $senderinfo->customerMobile;
												$limitLeft = $senderinfo->limitLeft;
												
		
		

												$rsltchecksender_db = $this->db->query("SELECT * FROM `mt3_remitter_registration` where mobile = ?",array($sendermobile));
												if($rsltchecksender_db->num_rows() == 0)
												{
													$this->db->query("insert into mt3_remitter_registration(user_id,add_date,ipaddress,mobile,name,lastname,pincode,status,PAYTM)
											values(?,?,?,?,?,?,?,?,?)",
											array(
											$user_id,
											$this->common->getDate(),
											$this->common->getRealIpAddr(),
											$sendermobile,
											$firstName,
											$lastName,
											"",
											"SUCCESS",
											"yes"
											));
												}

		
												$sender_array = array(
													"id"=>$customerMobile,
													"name"=>$firstName,
													"lastName"=>$lastName,
													"mobile"=>$customerMobile,
													"totallimit"=>$limitLeft,
													"remaininglimit"=>$limitLeft,
													
												);
												//($sendermobile,$userinfo)
												$beneficiary_main_array = array();
												$beneresult =  json_decode($this->Paytm->getbenelist2($sendermobile,$userinfo,2000,0));
												
												if(isset($beneresult->status))
												{
													$bene_status = trim((string)$beneresult->status);
													if($bene_status == "0")
													{
														$recipient_list = $beneresult->data;
														if(count($recipient_list) > 0)
														{
															foreach($recipient_list as $benelsit)
															{
																$recipient_id = $benelsit->beneficiaryId;
																$recipient_name = $benelsit->accountHolderName;
																$recipient_mobile = "";
																$account = $benelsit->accountNumber;
																$ifsc = $benelsit->ifscCode;
																$bank = $benelsit->bankName;
																$bankId = $benelsit->bankId;
																$verifystatus = $benelsit->verifystatus;
																$verified_name = $benelsit->verified_name;
																
																/*$checkbene_exist = $this->db->query("select Id from beneficiaries where account_number = ? and IFSC = ? and sender_mobile = ?",array($account,$ifsc,$sendermobile));
																//echo $checkbene_exist->num_rows();exit;
																if($checkbene_exist->num_rows() == 0)
																{
																	$this->db->query("insert into beneficiaries
																	(
																	bene_name,account_number,IFSC,benemobile,
																	sender_mobile,is_verified,paytm_bene_id,is_paytm,bank_name
																	) values(?,?,?,?,?,?,?,?,?)",
																	array($recipient_name,$account,$ifsc,0,$sendermobile,false,$recipient_id,'yes',$bank) );
																}
																if($checkbene_exist->num_rows() == 1)
																{
																	$this->db->query("update beneficiaries set paytm_bene_id = ?,is_paytm = 'yes' where id = ?",array($recipient_id ,$checkbene_exist->row(0)->Id));
																}*/
																
																
																if($bank==null||$bank==NULL)$bank="";
																$benearray = array(
																			"id"=>$recipient_id,
																			"name"=>$recipient_name,
																			"mobile"=>$sendermobile,
																			"account"=>$account,
																			"bank"=>$bank,
																			"bankId"=>$bankId,
																			"ifsc"=>$ifsc,
																			"available_channel"=>"",
																			"is_verified"=>$verifystatus,
																			"verified_name"=>$verified_name
																);
																array_push($beneficiary_main_array,$benearray);
															}
															
														}
													}
												}
												$array = array(
														"message"=>"Transaction Successful",
														"status"=>"0",
														"statuscode"=>"TXN",
														"remitter"=>$sender_array,
														"beneficiary"=>$beneficiary_main_array
													);
												echo json_encode($array);
											}
											else
											{
												$resp_arr = array(
													"message"=>"Sender Not Found",
													"status"=>1,
													"statuscode"=>"RNF",
													);
												$json_resp =  json_encode($resp_arr);
												echo $json_resp;exit;
											}
										}
										else
										{
		
										}
										
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
												"message"=>"Parameter Missing",
												"status"=>1,
												"statuscode"=>"ERR"
											);
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
}
