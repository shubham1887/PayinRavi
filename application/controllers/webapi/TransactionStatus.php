<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TransactionStatus extends CI_Controller 
{
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

				if(isset($json_obj->username) && isset($json_obj->password) && isset($json_obj->order_id) )
				{
					$username = trim($json_obj->username);
					$pwd =  trim($json_obj->password);
					$order_id = trim($json_obj->order_id);
					
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
						//if($ip == $client_ip or $ip == $client_ip2 or $ip == $client_ip3 or $ip == $client_ip4)
						if(true)
						{
							if($status == '1')
							{
								if($mt_access != '1')
								{
									$resp_array = array(
										"message"=>"You Are Not Allowed To Use This Service",
										"status"=>3,
										"statuscode"=>"AUTH"
									);
									echo json_encode($resp_array);exit;
								}
								if($header_developer_key != $developer_key)
								{
									$resp_array = array(
										"message"=>"Invalid authentication_key",
										"status"=>3,
										"statuscode"=>"AUTH"
									);
									echo json_encode($resp_array);exit;
								}
								
								
									
									//echo $order_id;exit;
									
									$rsltdmtinfo = $this->db->query("select Id from mt3_transfer where order_id = ? and user_id = ?",array($order_id,$user_id));
									//print_r($rsltdmtinfo->result());exit;
									if($rsltdmtinfo->num_rows() == 1)
									{
										$dmr_id = $rsltdmtinfo->row(0)->Id;
										$resultdmr = $this->db->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.dist_charge_amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where a.Id = ?",array($dmr_id));
		
		
		
		if($resultdmr->num_rows() == 1)
		{
			$Status = $resultdmr->row(0)->Status;
			$user_id = $resultdmr->row(0)->user_id;
			$DId = $resultdmr->row(0)->DId;
			$API = $resultdmr->row(0)->API;
			$RESP_status = $resultdmr->row(0)->RESP_status;
			$Amount = $amount =  $resultdmr->row(0)->Amount;
			$debit_amount = $resultdmr->row(0)->debit_amount;
			
			
			$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
			$benificiary_ifsc = $resultdmr->row(0)->IFSC;
			$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
			$remittermobile = $resultdmr->row(0)->RemiterMobile;
			
			$dist_charge_amount= $resultdmr->row(0)->dist_charge_amount;
			$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
			$sub_txn_type = "REMITTANCE";
			$remark = "Money Remittance";
			
			$RESP_opr_id = $resultdmr->row(0)->RESP_opr_id;
			$RESP_name = $resultdmr->row(0)->RESP_name;
			if($Status == "SUCCESS")
			{
				$resp_arr = array(
								"message"=>"SUCCESS",
								"status"=>0,
								"statuscode"=>"TXN",
								"data"=>array(
									"tid"=>$dmr_id,
									"ref_no"=>$RESP_opr_id,
									"opr_id"=>$RESP_opr_id,
									"name"=>$RESP_name,
									"balance"=>0,
									"amount"=>$amount,

								)
							);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}
			else if($Status == "FAILURE")
			{
				$resp_arr = array(
								"message"=>"FAILURE",
								"status"=>1,
								"statuscode"=>"ERR",
								"data"=>array(
									"tid"=>$dmr_id,
									"ref_no"=>"Transaction Failed",
									"opr_id"=>"Transaction Failed",
									"name"=>$RESP_name,
									"balance"=>0,
									"amount"=>$amount,

								)
							);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}
			else if($Status == "PENDING")
			{
				$resp_arr = array(
								"message"=>"PENDING",
								"status"=>0,
								"statuscode"=>"TUP",
								"data"=>array(
									"tid"=>$dmr_id,
									"ref_no"=>"Transaction Under Pending Process",
									"opr_id"=>"Transaction Under Pending Process",
									"name"=>$RESP_name,
									"balance"=>0,
									"amount"=>$amount,

								)
							);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}
			
			
		}
									}
									else
									{
										$resp_array = array(
													"message"=>"Invalid Order Id",
													"status"=>3,
													"statuscode"=>"RNF"
												);
										echo json_encode($resp_array);exit;
									}
								
							}
							else
							{
								$resp_array = array(
													"message"=>"Your Account Not Active",
													"status"=>3,
													"statuscode"=>"AUTH"
												);
								echo json_encode($resp_array);exit;
							}
						}
						else
						{
							$resp_array = array(
													"message"=>"Invalid Ip Address [".$ip."]",
													"status"=>3,
													"statuscode"=>"AUTH"
												);
							echo json_encode($resp_array);exit;
						}
					}
					else
					{
						$resp_array = array(
												"message"=>"UserId Or Password Invalid",
												"status"=>3,
												"statuscode"=>"AUTH"
											);
						echo json_encode($resp_array);exit;
					}
					
					
				}
				else
				{
					$resp_array = array(
												"message"=>"Parameter Missing",
												"status"=>3,
												"statuscode"=>"ERR"
											);
					echo json_encode($resp_array);exit;
				}			
			}
			else
			{
				$resp_array = array(
												"message"=>"Something Went Wrong",
												"status"=>3,
												"statuscode"=>"ERR"
											);
				echo json_encode($resp_array);exit;
			}
		}
		else
		{
			$resp_array = array(
												"message"=>"authentication_key Not Found",
												"status"=>3,
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
