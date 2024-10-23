<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getsenderinfo extends CI_Controller {
	public function test()
	{
		$sendermobile = "8238232303";
		$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,mt_access from tblusers where mobile_no = '1234567890'");
		$this->load->model("Bankit");
		$bankitlimit = $this->Bankit->remitter_details_limit($sendermobile,$userinfo);
		echo $bankitlimit ;exit;
	}
	public function index()
	{ 
		//echo "";exit;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['sendermobile']))
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
							
								$this->load->model("Paytm");
								$senderinfo =  json_decode($this->Paytm->remitter_details($sendermobile,$userinfo));
								
								if(isset($senderinfo->status))
								{
									$status = trim((string)$senderinfo->status);
									$message = trim((string)$senderinfo->message);
									$statuscode = trim((string)$senderinfo->statuscode);
									if($status == "0")
									{

										$data = $senderinfo->data;
										$firstName = $data->firstName;
										$lastName = $data->lastName;
										$customerMobile = $data->customerMobile;
										$limitLeft = $data->limitLeft;
										

$this->load->model("Bankit");
$bankitlimit = $this->Bankit->remitter_details_limit($sendermobile,$firstName,$lastName,$userinfo);

										$sender_array = array(
											"id"=>$customerMobile,
											"name"=>$firstName,
											"mobile"=>$customerMobile,
											"totallimit"=>$limitLeft,
											"remaininglimit"=>$limitLeft." + ".$bankitlimit,
											
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
																	"mobile"=>$recipient_mobile,
																	"account"=>$account,
																	"bank"=>$bank,
																	"bankId"=>$bankId,
																	"ifsc"=>$ifsc,
																	"available_channel"=>"",
																	"is_verified"=>false
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
											"message"=>$senderinfo->message,
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
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		$this->db->query("insert into templog(dmt_id,add_date,ipaddress,request,response,downline_response,type) values(?,?,?,?,?,?,?)",
											array(0,$this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$json_resp,$methiod));
	}
}
