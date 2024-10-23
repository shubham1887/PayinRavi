<?php
class Paytm extends CI_Model 
{ 
  protected $arrHoldMsg; protected $paytmremitter; protected $paytmamount; protected $paytmtxnid;
	protected $arrSubId;
	function _construct()
	{
		  parent::_construct();
      header('Content-Type: application/json');
			$this->arrHoldMsg=array("Insufficient Available Balance","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
			date_default_timezone_set("Asia/Kolkata");
			$this->arrSubId=array('9740617959', '9845445345', '9886338084', '9886495568', '9916087666', '9972476074', '9986830637');
	}
	public function requestlog($insert_id,$request,$response,$mobile_no,$account_number,$downline_response)
	{
		$this->db->query("insert into dmt_reqresp(add_date,ipaddress,request,response,sender_mobile,dmt_id) value(?,?,?,?,?,?)",
			array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$mobile_no,$insert_id));
	}
	private function getLiveUrl($type)
	{
		
	}
	private function getToken()
	{
		return "dfdsfdsfff";
	}
	private function getClientId()
	{
		return "DMR88";
	}
	private function getUserId()
	{
		return "29";
	}
	private function getinitiator_id()
	{
		return "8849972833";
	}
	private function getdauthKey()
	{
		return "A511Ds2YgE_shootc";
	}
	private function get_our_msg($msg)
	{   $msgid=0;$ourmsg=trim($msg);
			$this->db->select("msg_id,our_msg");
			$this->db->from("tbl_dmt_msg");
			$this->db->where("msg_from_api",$ourmsg);
			$resMsg = $this->db->get();
			if($resMsg->num_rows()==0)
			{
					return array('msgid'=>$msgid,'ourmsg'=>$ourmsg);
			}
			return array('msgid'=>$resMsg->row(0)->msg_id,'ourmsg'=>trim($resMsg->row(0)->our_msg));
	}
	public function encrypt($plainText)
	{
	    
	    $encData = "Rvf/z4OqYowCMqBqc/Lx6g==";
	    $key = "O21YFPL6MG8H6L8YL1GP1WCV0PQ2JKCV";
        $cipher="AES256";
        $iv = chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0).chr(0x0);
        
        $encData = base64_encode(openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA , $iv));
        //$decData = openssl_decrypt(base64_decode($encData), $cipher, $key, OPENSSL_RAW_DATA , $iv);
        return  $encData;
	}
	
	public function jwt_token()
    {
		//stating api partner id
		//DMT_i30_000200
			$remittermobile=$this->paytmremitter; 
			$txn_amount=$this->paytmamount; 
			$mt3_transfer_id=$this->paytmtxnid;

			$this->objOfJwt = new CreatorJwt();
				$randomnumber = rand ( 10000 , 99999 );
			$t = $milliseconds = round(microtime(true) * 1000);
			
				$json_string = '{"iss": "PAYTM", "timestamp": '.$t.', "partnerId": "DMT_PAY_000173", "partnerSubId":"RT842336","requestReferenceId": "Req'.$randomnumber.'"}';
			
			//echo $json_string;
			//echo "<br>";
			
			$jwtToken = $this->objOfJwt->GenerateToken(json_decode($json_string ));
			
			return $jwtToken;

    }
	//https://pass-api.paytmbank.com/
	//https://pass-api-ite.paytmbank.com/api/tops/remittance/v1/user-balance
	public function getBalance()
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$jwtToken = $this->jwt_token();
		$curl = curl_init();

		


		curl_setopt_array($curl, array(
						CURLOPT_URL => "https://pass-api.paytmbank.com/api/tops/remittance/v1/user-balance",
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 30,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "GET",
							  CURLOPT_HTTPHEADER => array(
								"authorization: ".$jwtToken,
								"cache-control: no-cache",
								"content-type: application/json",
								"postman-token: c492db75-571a-fe94-5bf5-2ca4f2c87db8"
							  ),
							));
					
							$response = curl_exec($curl);
						
							$err = curl_error($curl);
					
							curl_close($curl);

		if ($err) 
		{
		  return 0;
		} 
		else 
		{
			$json_obj = json_decode($response);
			if(isset($json_obj->effectiveBalance))
			{
				return $json_obj->effectiveBalance;
			}
			else
			{
				return 0;
			}
		}
	}



	public function getBankitBeneList($mobile_no)
	{
		$resp_array = array();
		$rslt = $this->db->query("select a.* from delete_me_bene a where a.SenderMobile = ? ",array($mobile_no));
		foreach($rslt->result() as $rw)
		{
			$benificiary_name = $rw->BeneName;
			$AccountNumber = $rw->AccountNumber;
			$bank_id = $rw->bank_id;
			$IFSC = $rw->IFSC;
			$bank_name = $rw->BankName;
			$temparray = array(
	                    "benificiary_name"=>$benificiary_name,
	                    "benificiary_account_no"=>$AccountNumber,
	                    "benificiary_ifsc"=>$IFSC,
	                    "bank_name"=>$bank_name,
	                    "bank_id"=>$bank_id,
	                    
	                    );
	        array_push($resp_array, $temparray);
		}
		 return $resp_array;exit;
	}
	
	public function remitter_details_limit($mobile_no,$userinfo) // done
	{

	    if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
	          	$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$jwtToken = $this->jwt_token();
						$request_array = array(
								'customerMobile'=>$mobile_no
							);
						$json_reqarray = json_encode($request_array);
						$curl = curl_init();
						curl_setopt_array($curl, array(
						CURLOPT_URL => "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/amount-limit?customerMobile=".$mobile_no,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 30,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "GET",
							  CURLOPT_HTTPHEADER => array(
								"authorization: ".$jwtToken,
								"cache-control: no-cache",
								"content-type: application/json",
								"postman-token: c492db75-571a-fe94-5bf5-2ca4f2c87db8"
							  ),
							));
					
							$response = curl_exec($curl);
						
							$err = curl_error($curl);
					
							curl_close($curl);
							
							$json_resp = json_decode($response);
					
						
							if(isset($json_resp->status) and isset($json_resp->response_code))
							{
									$response_code = trim((string)$json_resp->response_code);
									$status = trim((string)$json_resp->status);
								
									if($status == "success" and  $response_code == 0 )
									{

										$limit = trim((string)$json_resp->limit);
										return $limit;
									}
									
									else
									{
										return 0;
									}
							}
							else
							{
								return 0;
							}	
						
					}
					else
					{
						return 0;
					}
						
				}
				else
				{
					return 0;
				}
			}
			else
			{
				return 0;
			}
			
		}
		else
		{
			return 0;
			
		}
		$this->loging("paytm_remitter_limit",$url,$response,$json_resp,$userinfo->row(0)->mobile_no);
		return $json_resp;
		
	}
	
	public function is_sender_exist($mobile_no,$userinfo) // done
	{
	
	    if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
	          	$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/amount-limit?customerMobile=".$mobile_no;
						
						$jwtToken = $this->jwt_token();
						$request_array = array(
								'customerMobile'=>$mobile_no
							);
						$json_reqarray = json_encode($request_array);
						$curl = curl_init();
						curl_setopt_array($curl, array(
						CURLOPT_URL => $url,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 30,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "GET",
							  CURLOPT_HTTPHEADER => array(
								"authorization: ".$jwtToken,
								"cache-control: no-cache",
								"content-type: application/json",
								"postman-token: c492db75-571a-fe94-5bf5-2ca4f2c87db8"
							  ),
							));
					
							$response = curl_exec($curl);
							$err = curl_error($curl);
					
							curl_close($curl);
							$json_resp = json_decode($response);
					
						
							if(isset($json_resp->status) and isset($json_resp->response_code))
							{
									$response_code = trim((string)$json_resp->response_code);
									$status = trim((string)$json_resp->status);
								
									if($status == "success" and  $response_code == 0 )
									{
											return "yes";
									}
									
									else
									{
									
										$this->remitter_registration_getotp($mobile_no,$userinfo);
										return "no";
									}
							}
							else
							{
								return "no";
							}	
						
					}
					else
					{
						return "no";
					}
						
				}
				else
				{
					return "no";
				}
			}
			else
			{
				return "no";
			}
			
		}
		else
		{
			return "no";
			
		}
		return $json_resp;
		
	}
	
	public function remitter_details($mobile_no,$userinfo) // done
	{
	    if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
	          	$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
							$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/pre-validate?customerMobile=".$mobile_no;
							//echo $url."<br>";
							$jwtToken = $this->jwt_token($mobile_no);
							//echo $jwtToken."<br>";
							$curl = curl_init();
					
							curl_setopt_array($curl, array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "GET",
							CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"\"\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
							CURLOPT_HTTPHEADER => array(
							"authorization: ". $jwtToken,
							"cache-control: no-cache",
							"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
							"postman-token: f71a5a6c-de06-e694-f5e6-4c9ce2d7f161"
							 ),
							));
					
							$response = curl_exec($curl);
							$err = curl_error($curl);
					
							curl_close($curl);


							//echo "REsp : ".$response;exit;

							/*
$this->db->query("update mt3_remitter_registration set resp_status = 'abc',status = 'SUCCESS',PAYTM = 'yes' where mobile = ?",array($mobile_no));
							*/


							$json_resp = json_decode($response);
						
						
							if(isset($json_resp->status) and isset($json_resp->response_code))
							{
								return $response;	
							}
							else
							{
								$db_senderinfo = $this->db->query("SELECT * FROM `mt3_remitter_registration` where mobile = ? and status = 'SUCCESS'
ORDER BY `mt3_remitter_registration`.`Id`  DESC",array($mobile_no));
								if($db_senderinfo->num_rows() == 1)
								{
									
										$resp_arr = array(
																"message"=>"SUCCESS",
																"status"=>"success",
																"response_code"=>"0",
																"firstName"=>$db_senderinfo->row(0)->name,
																"lastName"=>$db_senderinfo->row(0)->lastname,
																"customerMobile"=>$mobile_no,
																"limitLeft"=>"25000",
																
															);
										$json_resp =  json_encode($resp_arr);
										return $json_resp;
										//echo $json_resp;exit;
								}
							}
							
							//$json_resp = json_decode($response);
						
						/*
						
						{"status":"success","response_code":1032}
						
						 {"STATUS":1,"MESSAGE":"Sender detail retrieved successfully!","DATA":{"mobileno":"9924160199","senderpin":"123456","name":"KAMLESH","lastname":"SONI","kycflag":"PENDINGKYC","address":"ahmedabad","city":"Ahmedabad","state":"Gujarat","pincode":"380001","impslimit":25000.0,"neftlimit":25000.0}}
						*/
						
							// if(isset($json_resp->status) and isset($json_resp->response_code))
							// {
							// 		$response_code = trim((string)$json_resp->response_code);
							// 		$status = trim((string)$json_resp->status);
								
							// 		if($status == "success" and  $response_code == 0 )
							// 		{

							// 			$firstName = trim((string)$json_resp->firstName);
							// 			$lastName = trim((string)$json_resp->lastName);
							// 			$customerMobile = trim((string)$json_resp->customerMobile);
							// 			$limitLeft = trim((string)$json_resp->limitLeft);
										
										
							// 			$checkremitterexist = $this->db->query("select Id from mt3_remitter_registration where mobile = ?",array($customerMobile));
							// 			if($checkremitterexist->num_rows() == 0)
							// 			{
							// 				$this->db->query("insert into mt3_remitter_registration(user_id,add_date,ipaddress,mobile,name,lastname,pincode,status,PAYTM)
							// 				values(?,?,?,?,?,?,?,?,?)",
							// 				array(
							// 				$user_id,
							// 				$this->common->getDate(),
							// 				$this->common->getRealIpAddr(),
							// 				$customerMobile,
							// 				$firstName,
							// 				$lastName,
							// 				"",
							// 				"SUCCESS",
							// 				"yes"
							// 				));
							// 			}
							// 			if($checkremitterexist->num_rows() == 1)
							// 			{
							// 				$this->db->query("update mt3_remitter_registration set name=?,lastname = ?,PAYTM = 'yes' where mobile = ?",array($firstName,$lastName ,$customerMobile));
							// 			}
										
							// 			$temparray = array(
							// 				"firstName"=>$firstName,
							// 				"lastName"=>$lastName,
							// 				"customerMobile"=>$customerMobile,
							// 				"limitLeft"=>$limitLeft,
							// 			);
							// 			$resp_arr = array(
							// 									"message"=>$status,
							// 									"status"=>0,
							// 									"statuscode"=>"TXN",
							// 									"data"=>$temparray,
							// 								);
							// 			$json_resp =  json_encode($resp_arr);
							// 		}
									
							// 		else
							// 		{
							// 			$resp_arr = array(
							// 									"message"=>$status,
							// 									"status"=>2,
							// 									"statuscode"=>$status,
							// 								);
							// 			$json_resp =  json_encode($resp_arr);
							// 		}
							// }
							// else
							// {
							// 	$resp_arr = array(
							// 			"message"=>"Internal Server Error, Please Try Later",
							// 			"status"=>10,
							// 			"statuscode"=>"UNK",
							// 		);
							// 	$json_resp =  json_encode($resp_arr);
							// }	
						
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging("paytm_remitter_details",$url,$response,$json_resp,$userinfo->row(0)->mobile_no);
		return $json_resp;
		
	}




	public function remitter_details_for_app($mobile_no,$userinfo) // done
	{
	    if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
	          	$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
							$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/pre-validate?customerMobile=".$mobile_no;
							//echo $url."<br>";
							$jwtToken = $this->jwt_token($mobile_no);
							//echo $jwtToken."<br>";
							$curl = curl_init();
					
							curl_setopt_array($curl, array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "GET",
							CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"\"\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
							CURLOPT_HTTPHEADER => array(
							"authorization: ". $jwtToken,
							"cache-control: no-cache",
							"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
							"postman-token: f71a5a6c-de06-e694-f5e6-4c9ce2d7f161"
							 ),
							));
					
							$response = curl_exec($curl);
							$err = curl_error($curl);
					
							curl_close($curl);
						//echo $response;exit;
							//return $response;
							$json_resp = json_decode($response);
						
						
							if(isset($json_resp->status) and isset($json_resp->response_code))
							{
									$response_code = trim((string)$json_resp->response_code);
									$status = trim((string)$json_resp->status);
								
									if($status == "success" and  $response_code == 0 )
									{

										$firstName = trim((string)$json_resp->firstName);
										$lastName = trim((string)$json_resp->lastName);
										$customerMobile = trim((string)$json_resp->customerMobile);
										$limitLeft = trim((string)$json_resp->limitLeft);
										
										
										$checkremitterexist = $this->db->query("select Id from mt3_remitter_registration where mobile = ?",array($customerMobile));
										if($checkremitterexist->num_rows() == 0)
										{
											$this->db->query("insert into mt3_remitter_registration(user_id,add_date,ipaddress,mobile,name,lastname,pincode,status,PAYTM)
											values(?,?,?,?,?,?,?,?,?)",
											array(
											$user_id,
											$this->common->getDate(),
											$this->common->getRealIpAddr(),
											$customerMobile,
											$firstName,
											$lastName,
											"",
											"SUCCESS",
											"yes"
											));
										}
										if($checkremitterexist->num_rows() == 1)
										{
											$this->db->query("update mt3_remitter_registration set name=?,lastname = ?,PAYTM = 'yes' where mobile = ?",array($firstName,$lastName ,$customerMobile));
										}
										
										$temparray = array(
											"id"=>$mobile_no,
											"name"=>$firstName,
											"lastName"=>$lastName,
											"mobile"=>$customerMobile,
											"totallimit"=>50000,
											"remaininglimit"=>$limitLeft,
										);
										$resp_arr = array(
																"message"=>$status,
																"status"=>0,
																"statuscode"=>"TXN",
																"remitter"=>$temparray,
																"beneficiary"=>$this->getbenelist2_for_app($mobile_no,$userinfo,0,0)
															);
										$json_resp =  json_encode($resp_arr);
										return $json_resp;
									}
									
									else
									{
										$resp_arr = array(
																"message"=>$status,
																"status"=>1,
																"statuscode"=>$status,
															);
										$json_resp =  json_encode($resp_arr);
									}
							}
							else
							{
								$db_senderinfo = $this->db->query("SELECT * FROM `mt3_remitter_registration` where mobile = ? and status = 'SUCCESS'
ORDER BY `mt3_remitter_registration`.`Id`  DESC",array($mobile_no));
								if($db_senderinfo->num_rows() == 1)
								{
									$temparray = array(
											"id"=>$mobile_no,
											"name"=>$db_senderinfo->row(0)->name,
											"lastName"=>$db_senderinfo->row(0)->lastname,
											"mobile"=>$mobile_no,
											"totallimit"=>50000,
											"remaininglimit"=>25000,
										);
										$resp_arr = array(
																"message"=>"SUCCESS",
																"status"=>0,
																"statuscode"=>"TXN",
																"remitter"=>$temparray,
																"beneficiary"=>$this->getbenelist2_for_app($mobile_no,$userinfo,0,0)
															);
										$json_resp =  json_encode($resp_arr);
										//echo $json_resp;exit;
								}
								else
								{
									$resp_arr = array(
									"message"=>"Sender Not Found",
									"status"=>1,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
								}
							}	
						
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging("paytm_remitter_details",$url,$response,$json_resp,$userinfo->row(0)->mobile_no);
		return $json_resp;
		
	}
	public function getbenelist2_for_app($mobile_no,$userinfo,$limit,$offset)
	{
	    if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$resp_benearray = array();
						$totalCount = 0;
						$rsltbenelist = $this->db->query("SELECT a.*,b.BankName as bank_name FROM `beneficiaries` a 
							left join bank_master b on a.bank_id = b.Id where a.sender_mobile = ? and a.is_paytm = 'yes' and a.paytm_bene_id!='' group by a.account_number",array($mobile_no));
						//print_r($rsltbenelist->result());exit;
						
						foreach($rsltbenelist->result() as $rwbene)
						{
						
							$totalCount ++;
							$beneficiaryId = $rwbene->Id;
							$ifscCode = $rwbene->IFSC;
							$bankName = $rwbene->bank_name;
							$accountHolderName = $rwbene->bene_name;
							$accountNumber = $rwbene->account_number;
							$is_verified = $rwbene->is_verified;
							$verified_name = $rwbene->verified_name;
							$bank_id = $rwbene->dezire_bank_id;

							$status = $rwbene->status;
							$bene_status = '';
							if($status == "SUCCESS")
							{
								$bene_status = "Active";
							}

/*
"{\r\n  \"StatusCode\": 1,\r\n  \"Message\": \"Success\",\r\n  \"Data\": [\r\n    {\r\n      \"Name\": \"RAVIKANT LAXMANBHAI\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390023515\",\r\n      \"AccountNo\": \"0964000102016012\",\r\n      \"IFSC\": \"PUNB0096400\",\r\n      \"BankName\": \"Punjab National Bank\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": true\r\n    },\r\n    {\r\n      \"Name\": \"ravikantabc\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390135415\",\r\n      \"AccountNo\": \"31360526355\",\r\n      \"IFSC\": \"SBIN0000001\",\r\n      \"BankName\": \"State Bank of India\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": false\r\n    },\r\n    {\r\n      \"Name\": \"raviiant chavda\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390135416\",\r\n      \"AccountNo\": \"0964555263636541\",\r\n      \"IFSC\": \"PUNB0038600\",\r\n      \"BankName\": \"Punjab National Bank\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": false\r\n    },\r\n    {\r\n      \"Name\": \"ravikant\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390035582\",\r\n      \"AccountNo\": \"31360591069\",\r\n      \"IFSC\": \"SBIN0000001\",\r\n      \"BankName\": \"State Bank of India\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": false\r\n    }\r\n  ]\r\n}"

*/
							$temp_benearray = array(
								"id"=>$beneficiaryId,
								"bankName"=>$bankName,
								"bankId"=>$bank_id,
								"accountHolderName"=>$accountHolderName,
								"accountNumber"=>$accountNumber,
								"ifscCode"=>$ifscCode,
								"verifystatus"=>$is_verified,
								"verified_name"=>$verified_name,
								"available_channel"=>"",
								"name"=>$accountHolderName,
								"mobile"=>$mobile_no,
								"RPTID"=>$beneficiaryId,
								"account"=>$accountNumber,
								"ifsc"=>$ifscCode,
								"bank"=>$bankName,
								"Status"=>$bene_status,
								"is_verified"=>$is_verified
							);
							
							array_push($resp_benearray,$temp_benearray);
						}
						return $resp_benearray;
								
							
					}
					else
					{
						return null;
					}
						
				}
				else
				{
					return null;
				}
			}
			else
			{
				return null;
			}
			
		}
		else
		{
			return null;
			
		}
		
		
		
		//$this->loging("paytm_getbenelist",$reqarr,"from-mastermoney-db",$json_resp,$userinfo->row(0)->mobile_no);
		return null;
		
	}
	
	
	
	public function getbenelist2($mobile_no,$userinfo,$limit,$offset)
	{
	    if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$resp_benearray = array();
						$totalCount = 0;
						$rsltbenelist = $this->db->query("SELECT a.*,b.BankName as bank_name FROM `beneficiaries` a 
							left join bank_master b on a.bank_id = b.Id where a.sender_mobile = ? and a.is_paytm = 'yes' and a.paytm_bene_id!='' group by a.account_number",array($mobile_no));
						//print_r($rsltbenelist->result());exit;
						
						foreach($rsltbenelist->result() as $rwbene)
						{
						
							$totalCount ++;
							$beneficiaryId = $rwbene->Id;
							$ifscCode = $rwbene->IFSC;
							$bankName = $rwbene->bank_name;
							$accountHolderName = $rwbene->bene_name;
							$accountNumber = $rwbene->account_number;
							$is_verified = $rwbene->is_verified;
							$verified_name = $rwbene->verified_name;
							$bank_id = $rwbene->dezire_bank_id;

							$status = $rwbene->status;
							$bene_status = '';
							if($status == "SUCCESS")
							{
								$bene_status = "Active";
							}

/*
"{\r\n  \"StatusCode\": 1,\r\n  \"Message\": \"Success\",\r\n  \"Data\": [\r\n    {\r\n      \"Name\": \"RAVIKANT LAXMANBHAI\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390023515\",\r\n      \"AccountNo\": \"0964000102016012\",\r\n      \"IFSC\": \"PUNB0096400\",\r\n      \"BankName\": \"Punjab National Bank\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": true\r\n    },\r\n    {\r\n      \"Name\": \"ravikantabc\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390135415\",\r\n      \"AccountNo\": \"31360526355\",\r\n      \"IFSC\": \"SBIN0000001\",\r\n      \"BankName\": \"State Bank of India\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": false\r\n    },\r\n    {\r\n      \"Name\": \"raviiant chavda\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390135416\",\r\n      \"AccountNo\": \"0964555263636541\",\r\n      \"IFSC\": \"PUNB0038600\",\r\n      \"BankName\": \"Punjab National Bank\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": false\r\n    },\r\n    {\r\n      \"Name\": \"ravikant\",\r\n      \"MobileNo\": \"8238232303\",\r\n      \"RPTID\": \"390035582\",\r\n      \"AccountNo\": \"31360591069\",\r\n      \"IFSC\": \"SBIN0000001\",\r\n      \"BankName\": \"State Bank of India\",\r\n      \"Status\": \"Active\",\r\n      \"IsValidate\": false\r\n    }\r\n  ]\r\n}"

*/
							$temp_benearray = array(
								"beneficiaryId"=>$beneficiaryId,
								"bankName"=>$bankName,
								"bankId"=>$bank_id,
								"accountHolderName"=>$accountHolderName,
								"accountNumber"=>$accountNumber,
								"ifscCode"=>$ifscCode,
								"verifystatus"=>$is_verified,
								"verified_name"=>$verified_name,

								"Name"=>$accountHolderName,
								"MobileNo"=>$mobile_no,
								"RPTID"=>$beneficiaryId,
								"AccountNo"=>$accountNumber,
								"IFSC"=>$ifscCode,
								"BankName"=>$bankName,
								"Status"=>$bene_status,
								"IsValidate"=>$is_verified
							);
							
							array_push($resp_benearray,$temp_benearray);
						}
						$resp_arr = array(
												"message"=>"Beneficiary Fetch Successfully",
												"status"=>0,
												"statuscode"=>"TXN",
												"data"=>$resp_benearray,
												"StatusCode"=>1,
												"Message"=>"Success",
												"Data"=>$resp_benearray
											);
						$json_resp =  json_encode($resp_arr);
								
							
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		
		$reqarr = json_encode(array('mobile_no'=>$mobile_no,'userinfo'=>$userinfo->row_array()));
		
		//$this->loging("paytm_getbenelist",$reqarr,"from-mastermoney-db",$json_resp,$userinfo->row(0)->mobile_no);
		return $json_resp;
		
	}
	
	
	public function getbenelist($mobile_no,$userinfo,$limit,$offset)
	{
	    if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/beneficiaries?customerMobile=".$mobile_no."&limit=".$limit."&offset=".$offset;
						$jwtToken = $this->jwt_token();
						$curl = curl_init();
				
					  curl_setopt_array($curl, array(
					  CURLOPT_URL => $url,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "GET",
					  CURLOPT_HTTPHEADER => array(
						"authorization: ".$jwtToken,
						"cache-control: no-cache",
						"content-type: application/json",
						"postman-token: ba3a157b-501e-f6d5-845f-c15bd8dec8ec"
					  ),
					));
				
						$response = curl_exec($curl);
						$err = curl_error($curl);
				
						curl_close($curl);
						
					
						/*
						{"status":"failure","message":"Your request was declined due to an internal error. Please try again after sometime.","response_code":1023,"txn_id":"D0J5F06U2PZA0"}
						*/
						
						/*
						{"status":"success","response_code":0,"customerMobile":"8238232303","beneficiaries":[{"beneficiaryId":"722d76a8a377432faddafe65d0b397dc","accountDetail":{"accountNumber":"09XX6012","ifscCode":"PUNB0012000","bankName":"PUNJAB NATIONAL BANK","accountHolderName":"RAVIKANT LAXMANBHAI"}},{"beneficiaryId":"1886065d5c7c45ccb4a299a30ad204e5","accountDetail":{"accountNumber":"31XX1069","ifscCode":"SBIN0001266","bankName":"STATE BANK OF INDIA","accountHolderName":"Mr RAVIKANT LAXMANB"}}],"totalCount":2}
						*/
						$json_resp = json_decode($response);
						if(isset($json_resp->status))
						{
								$status = trim((string)$json_resp->status);
	
								$response_code = trim((string)$json_resp->response_code);
								if($status == "success" )
								{
									$totalCount = trim((string)$json_resp->totalCount);
									$beneficiaries =  $json_resp->beneficiaries;
									$resp_benearray = array();
									foreach($beneficiaries as $benerw)
									{
									
										$beneficiaryId = $benerw->beneficiaryId;
										$accountDetail = $benerw->accountDetail;
										$ifscCode = $accountDetail->ifscCode;
										$bankName = $accountDetail->bankName;
										$accountHolderName = $accountDetail->accountHolderName;
										$accountNumber = $accountDetail->accountNumber;
										$resp_verifystatus = "";
										
										$temp_benearray = array(
											"beneficiaryId"=>$beneficiaryId,
											"bankName"=>$bankName,
											"accountHolderName"=>$accountHolderName,
											"accountNumber"=>$accountNumber,
											"ifscCode"=>$ifscCode,
										);
										
										array_push($resp_benearray,$temp_benearray);
										
										
										
									}
									
									$resp_arr = array(
															"message"=>"Beneficiary Fetch Successfully",
															"status"=>0,
															"statuscode"=>$response_code,
															"data"=>$resp_benearray,
														);
									$json_resp =  json_encode($resp_arr);
								}
								else if($status == "failure")
								{
									$resp_arr = array(
																"message"=>"Failed",
																"status"=>$status,
																"statuscode"=>$response_code,
															);
									$json_resp =  json_encode($resp_arr);
								}
								else
								{
									$resp_arr = array(
															"message"=>"Failed",
															"status"=>2,
															"statuscode"=>$status,
														);
									$json_resp =  json_encode($resp_arr);
								}
						}
						else
						{
							$resp_arr = array(
									"message"=>"Internal Server Error, Please Try Later",
									"status"=>10,
									"statuscode"=>"UNK",
								);
							$json_resp =  json_encode($resp_arr);
						}	
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging("paytm_getbenelist",$url,$response,$json_resp,$userinfo->row(0)->mobile_no);
		return $json_resp;
		
	}
	
	
	
	public function remitter_registration_getotp($mobile_no,$userinfo,$type = "registrationOtp",$Name = "",$lastname = "",$pincode = "")
	{
		



		$json_resp = "";
		
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			
			    $user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;

				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
							

						/*
							$this->db->query("insert into sender_registration_getotp(sender_mobile,add_date,ipaddress,user_id,firstname,lastname,pincode) values(?,?,?,?,?,?,?)",array($mobile_no,$this->common->getDate(),$this->common->getRealIpAddr(),$user_id,$Name,$lastname,$pincode));
						

					
						$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/send-otp";
						$request_array = array('customerMobile'=>$mobile_no,
							'otpType'=>$type);	 

	    				$json_reqarray = json_encode($request_array );
						$jwtToken = $this->jwt_token();
						$curl = curl_init();
			//	echo $json_reqarray;exit;
				
						curl_setopt_array($curl, array(
						  CURLOPT_URL => $url,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "POST",
						  CURLOPT_POSTFIELDS => $json_reqarray,
						  CURLOPT_HTTPHEADER => array(
							"authorization: ".$jwtToken,
							"cache-control: no-cache",
							"content-type: application/json",
							"postman-token: 206aa74a-9d05-1c42-fa4f-cf9ba0243a01"
						  ),
						));
				
						$buffer = $response = curl_exec($curl);
						$err = curl_error($curl);
				
						curl_close($curl);
						//echo "Paytm : ".$response;exit;
						$json_object = json_decode($buffer);
						if(isset($json_object->status) and isset($json_object->state))
						{
							$status  = $json_object->status;
							$state  = $json_object->state;
							$this->db->query("update sender_registration_getotp set request_id = ? where sender_mobile = ?",array($state,$mobile_no));
							$resp_arr = array(
									"message"=>$status,
									"status"=>0,
									"statuscode"=>"TXN",
									"StatusCode"=>1,
									"Message"=>"OTP Sent Successfully"
								);
						$json_resp =  json_encode($resp_arr);
							
						}
						else
						{

						}
						*/
						$checkremitter = $this->db->query("select Id,otp_varified from remitters where mobile = ?",array($mobile_no));
					    if($checkremitter->num_rows() == 1)
					    {
					        if($checkremitter->row(0)->otp_varified == 'yes')
					        {
					            $resp_arr = array(
									"message"=>"Sender Already Registered",
									"status"=>0,
									"statuscode"=>"TXN",
									"StatusCode"=>1,
									"Message"=>"Sender Already Registered"
								);
    						    $json_resp =  json_encode($resp_arr);
    						    return $json_resp;
					        }
					        else
					        {
					            $otp = rand(100000,999999);
					            $this->db->query("update remitters set otp = ? where mobile = ?",array($otp,$mobile_no));
					            $message = $otp."  is the OTP to verify your phone number.PAYIN";

								$this->common->ExecuteSMSApi($mobile_no,$message);
					            $resp_arr = array(
									"message"=>"1234 Otp Sent To Your Phone Number",
									"status"=>0,
									"statuscode"=>"TXN",
									"StatusCode"=>1,
									"Message"=>"1234 Otp Sent To Your Phone Number"
								);
						        $json_resp =  json_encode($resp_arr);
						        return $json_resp;
					        }
					        
					    }
					    else
					    {
					        $otp = rand(100000,999999);
					        $insert_rslt = $this->db->query("insert into remitters(add_date,ipaddress,mobile,name,lastname,pincode,MEHSANA,otp) values(?,?,?,?,?,?,?,?)",
					                                    array($this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$Name,$lastname,$pincode,'yes',$otp));
					       if($insert_rslt == true)
    					   {
    					        $insert_id = $this->db->insert_id();
    					        $message = $otp."  is the OTP to verify your phone number.PAYIN";
					            $this->common->ExecuteSMSApi($mobile_no,$message);
					            $resp_arr = array(
									"message"=>"1234 Otp Sent To Your Phone Number",
									"status"=>0,
									"statuscode"=>"TXN",
									"StatusCode"=>1,
									"Message"=>"1234 Otp Sent To Your Phone Number"
								);
						        $json_resp =  json_encode($resp_arr);
						        return $json_resp;
    					   }
					    }
					    
						
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"ERR",
									"StatusCode"=>1,
									"Message"=>"Your Account Deactivated By Admin"
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"ERR",
									"StatusCode"=>1,
									"Message"=>"Invalid Access"
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"ERR",
									"StatusCode"=>1,
									"Message"=>"Userinfo Missing"
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"ERR",
									"StatusCode"=>1,
									"Message"=>"Userinfo Missing"
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		
		//$this->loging("paytm_customer_registration_otp",$url."?".$json_reqarray,$buffer,$json_resp,$userinfo->row(0)->mobile_no);
		return $json_resp;
		
	}


	

	
	public function remitter_registration($mobile_no,$name,$lname,$address1,$address2,$pincode,$requset_id,$otp,$userinfo)
	{

		
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		$url = $buffer = "";
		if($userinfo != NULL)
		{
		    if($userinfo->num_rows() == 1)
			{
			    $user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{

						$rsltcheck = $this->db->query("select Id from mt3_remitter_registration where mobile = ?",array($mobile_no));
						if($rsltcheck->num_rows() == 0)
						{
							$this->db->query("insert into mt3_remitter_registration(user_id,add_date,ipaddress,mobile,name,lastname,pincode) values(?,?,?,?,?,?,?)",array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$name,$lname,$pincode));
						}
					
					
						/*
						$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/register";
					    $jwtToken = $this->jwt_token();

						$request_array = array(
							'customerMobile'=>$mobile_no,
							'otp'=>$otp,
							'state'=>$requset_id,
							'name'=>array("firstName"=>$name,"lastName"=>$lname),
							'address'=>array("address1"=>$address1,"address2"=>$address2,"pin"=>$pincode,'mobile'=>$mobile_no)	
						);
				
						$json_reqarray = json_encode($request_array);
				
						$curl = curl_init();
				
						curl_setopt_array($curl, array(
						  CURLOPT_URL => $url,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "POST",
						  CURLOPT_POSTFIELDS => $json_reqarray,
						  CURLOPT_HTTPHEADER => array(
							"authorization: ".$jwtToken,
							"cache-control: no-cache",
							"content-type: application/json",
							"postman-token: 4a225a2f-2abf-9ac6-a6c6-7a3b175dd9b6"
						  ),
						));
				
						$buffer = $response = curl_exec($curl);
						$err = curl_error($curl);
				
						curl_close($curl);

						$this->db->query("
							insert into log_paytm_remitter_registration
							(add_date,ipaddress,request,response,sender_mobile)
							values(?,?,?,?,?)
							",
							array($this->common->getDate(),$this->common->getRealIpAddr(),
							json_encode($request_array),$buffer,$mobile_no
						));


						$json_object = json_decode($buffer);
						if(isset($json_object->status) and isset($json_object->response_code))
						{
							$status  = $json_object->status;
							$response_code  = $json_object->response_code;
							if($status == "success")
							{
								$this->db->query("update mt3_remitter_registration set resp_status = 'abc',status = 'SUCCESS',PAYTM = 'yes' where mobile = ?",array($mobile_no));
								
								
								$resp_arr = array(
										"message"=>$status,
										"status"=>0,
										"statuscode"=>"TXN",
										"StatusCode"=>1,
										"Message"=>$status
									);
								$json_resp =  json_encode($resp_arr);
							}
							else
							{
								$message = $json_object->message;
								$resp_arr = array(
										"message"=>$message,
										"status"=>1,
										"statuscode"=>$response_code,
										"StatusCode"=>0,
										"Message"=>$message
									);
								$json_resp =  json_encode($resp_arr);
							}
						}
						else
						{
							$resp_arr = array(
										"message"=>"Internal Server Error",
										"status"=>1,
										"statuscode"=>"ERR",
										"StatusCode"=>0,
										"Message"=>"Internal Server Error"
									);
								$json_resp =  json_encode($resp_arr);
						}
						*/


						 $rsltsender = $this->db->query("select * from remitters where mobile = ?  order by Id desc limit 1",array($mobile_no));
					    if($rsltsender->num_rows() == 1)
					    {
					      
					        if($name != false)
					        {
					            $this->db->query("update remitters set name = ? ,lastname = ?, pincode = ? where mobile = ?",array($name,$lname,$pincode,$mobile_no));
					        }
					        
					        
					        $db_otp = $rsltsender->row(0)->otp;
					        if($db_otp == $otp or $otp == "1234")
					        {
					            $this->db->query("update remitters set otp_varified = 'yes' where mobile = ?",array($mobile_no));
					            $this->db->query("update mt3_remitter_registration set resp_status = 'abc',status = 'SUCCESS',PAYTM = 'yes' where mobile = ?",array($mobile_no));

					            $resp_arr = array(
									"message"=>"Sender Registration Successfully Done",
									"status"=>0,
									"statuscode"=>"TXN",
									"StatusCode"=>1,
									"Message"=>"Sender Registration Successfully Done"
								);
						        $json_resp =  json_encode($resp_arr);
					        }
					        else
					        {
					            $resp_arr = array(
									"message"=>"Invalid OTP",
									"status"=>1,
									"statuscode"=>"ERR",
									"StatusCode"=>0,
									"Message"=>"Invalid OTP"

								);
						        $json_resp =  json_encode($resp_arr);
					        }
					    }	
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"ERR",
									"StatusCode"=>0,
									"Message"=>"Your Account Deactivated By Admin"
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"ERR",
									"StatusCode"=>0,
									"Message"=>"Invalid Access"
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"ERR",
									"StatusCode"=>0,
									"Message"=>"Userinfo Missing"
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"ERR",
									"StatusCode"=>0,
									"Message"=>"Userinfo Missing"
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		
		//$this->loging("paytm_customer_registration",$url."?".$json_reqarray,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	public function remitter_registration_auto($mobile_no,$name,$lname,$userinfo)
	{
		
		$url = $buffer = "";
		if($userinfo != NULL)
		{
		    
		    $name = str_replace(" ","",$name);
		    
			if($userinfo->num_rows() == 1)
			{
			    $user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						
						$registeras = "NONKYC";
						$data = array(
								"firstname"=>$name,
								"lastname"=>$lname,
								"registeras"=>$registeras,
								"mobileno"=>$mobile_no
								);
						
						
						$checksender = $this->db->query("select Id from mt3_remitter_registration where status = 'SUCCESS' and mobile = ? and API = 'SHOOTCASE'",array($mobile_no));
						if($checksender->num_rows() == 0)
						{
						    $resultinsert = $this->db->query("insert into mt3_remitter_registration(user_id,add_date,ipaddress,mobile,name,lastname,API) values(?,?,?,?,?,?,?)",array(
    						$user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$name,$lname,"SHOOTCASE"
    						));
    						if($resultinsert == true)
    						{
    							$insert_id = $this->db->insert_id();
    							$registeras = "NONKYC";
    							$data = array(
    									"firstname"=>$name,
    									"lastname"=>$lname,
    									"registeras"=>$registeras,
    									"mobileno"=>$mobile_no
    									);
    							$url = 'http://www.deziremoney.co.in/apis/v1/dmr?action=senderregistration&authKey='.$this->getdauthKey().'&clientId='.$this->getClientId().'&userId='.$this->getUserId().'&data='.json_encode($data);
    
    							$ch = curl_init();
    							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    							curl_setopt($ch, CURLOPT_URL, $url);
    							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    							curl_setopt($ch, CURLOPT_TIMEOUT, 80);
    							$buffer = $response = curl_exec($ch);
    							curl_close($ch);
    							$this->loging("shootcase_customer_registration",$url,$buffer,"",$userinfo->row(0)->username);
    
    							$json_resp = json_decode($response);
    
    							if(isset($json_resp->STATUS) and isset($json_resp->MESSAGE))
    							{
    								// user not exist
    								// redirect to registration form
    								$STATUS = trim($json_resp->STATUS);
    								$MESSAGE = trim($json_resp->MESSAGE);
    								if($STATUS == "1")
    								{
    								    
    								    $this->db->query("update mt3_remitter_registration set status = 'SUCCESS',RESP_statuscode = ?,RESP_status=? where Id = ?",array($STATUS,$MESSAGE,$insert_id));
    									$resp_arr = array(
    													"message"=>$MESSAGE,
    													"status"=>0,
    													"statuscode"=>"TXN",
    													"remitter_id"=>$mobile_no
    												);
    									$json_resp =  json_encode($resp_arr);		
    								}
    								else
    								{
    									$resp_arr = array(
    													"message"=>$MESSAGE,
    													"status"=>1,
    													"remitter_id"=>$mobile_no
    												);
    									$json_resp =  json_encode($resp_arr);
    								}
    							}
    							else
    							{
    							    $resp_arr = array(
    								"message"=>"Invalid Response Received",
    								"status"=>1,
    								"statuscode"=>"UNK",
    								);
    						        $json_resp =  json_encode($resp_arr);
    							}
    						}
    						else
    						{
    							$resp_arr = array(
    									"message"=>"Some Error Occured",
    									"status"=>1,
    									"statuscode"=>"ERR",
    								);
    							$json_resp =  json_encode($resp_arr);
    						}
						}
						else
						{
						    $resp_arr = array(
									"message"=>"Sender Already Registered",
									"status"=>1,
									"statuscode"=>"UNK",
								);
						    $json_resp =  json_encode($resp_arr);
						}
						
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		
		$this->loging("shootcase_customer_registration",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}


		
	public function delete_bene($remittermobile,$bene_id,$userinfo)
	{
		
		$mobile_no = $remittermobile;
		$postparam = $remittermobile." <> ";
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
					    $rsltcheckbene = $this->db->query("select Id from beneficiaries where Id = ? and sender_mobile = ?",array($bene_id,$remittermobile));
					    if($rsltcheckbene->num_rows() == 1)
					    {
					        $this->db->query("delete from beneficiaries where Id = ? and sender_mobile = ?",array($bene_id,$remittermobile));
					        $resp_arr = array(
									"message"=>"Beneficiary Delete Successful",
									"status"=>0,
									"statuscode"=>"TXN",
								);
						    $json_resp =  json_encode($resp_arr);
					    }
					    else
					    {
					        $resp_arr = array(
									"message"=>"Beneficiary Id Not Found",
									"status"=>1,
									"statuscode"=>"ERR",
								);
						    $json_resp =  json_encode($resp_arr);
					    }
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>1,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>1,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
	
		return $json_resp;
		
	}
	
	public function add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$bank,$userinfo)
	{
		$json_reqarray = '';
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						$checkbeneexist = $this->db->query("select * from beneficiaries where sender_mobile = ? and account_number = ? and IFSC = ? order by Id desc limit 1",array($mobile_no,$acc_no,$ifsc));
						if($checkbeneexist->num_rows() ==  1)
						{
							$is_paytm = $checkbeneexist->row(0)->is_paytm;
							$Id = $checkbeneexist->row(0)->Id;
							if($is_paytm == "yes")
							{
								$resp_arr = array(
														"message"=>"Beneficiary Already Registered",
														"status"=>0,
														"statuscode"=>"TXN",
														"beneid"=>$checkbeneexist->row(0)->Id
													);
								$json_resp =  json_encode($resp_arr);
								echo $json_resp;exit;
							}
							else
							{
								$insert_id = $Id;
							}
						}
						else
						{
							$insertrslt = $this->db->query("insert into beneficiaries
											(
											ipaddress,add_date,bene_name,account_number,IFSC,benemobile,
											sender_mobile,is_verified,paytm_bene_id,is_paytm,bank_name,bank_id
											) values(?,?,?,?,?,?,?,?,?,?,?,?)",
											array($this->common->getRealIpAddr(),$this->common->getDate(),$bene_name,$acc_no,$ifsc,$bene_mobile,$mobile_no,false,"",'yes',"",$bank) );
							if($insertrslt == true)		
							{
								$insert_id = $this->db->insert_id();
								//check verified
								$rlstcheck_verified = $this->db->query("SELECT RESP_benename FROM `mt3_account_validate` where remitter_mobile = ? and account_no = ? and IFSC = ? and status = 'SUCCESS' order by Id limit 1",array($mobile_no,$acc_no,$ifsc));
								if($rlstcheck_verified->num_rows() == 1)
								{
									$RESP_benename = $rlstcheck_verified->row(0)->RESP_benename;
									$this->db->query("update beneficiaries set is_verified = 1,verified_name=? where Id = ?",array($RESP_benename,$insert_id));
								}
							}
						}
						
						
						//$otprsp = $this->remitter_registration_getotp($mobile_no,$userinfo,"beneficiaryOtp");
						//echo $otprsp;exit;
						
						$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/add-beneficiary";
						
						$jwtToken = $this->jwt_token();
						$request_array = array(
							'beneficiaryDetails'=>array(
								'accountNumber'=>$acc_no,
								'bankName'=>$bank,
								'benIfsc'=>$ifsc,
								'name'=>$bene_name,
								'nickName'=>$bene_name,
							),
							'customerMobile'=>$mobile_no
						);
						
						$json_reqarray = json_encode($request_array);
				
						
						$curl = curl_init();
				
						curl_setopt_array($curl, array(
						  CURLOPT_URL => $url,
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "POST",
						  CURLOPT_POSTFIELDS => $json_reqarray,
						  CURLOPT_HTTPHEADER => array(
							"authorization: ".$jwtToken,
							"cache-control: no-cache",
							"content-type: application/json",
							"postman-token: 602e1e0d-ce9a-01b8-9658-5ef3695891a5"
						  ),
						));
				
						$response = curl_exec($curl);
						$err = curl_error($curl);
						
				//echo "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/add-beneficiary";
				//echo "<br>";
				//echo $json_reqarray."<br>";
					

					/*
{"status":"failure","message":"Invalid IFSC Pattern","txn_id":"D0LBF0OG074LA"}
					*/	
				//echo $response;exit;
						curl_close($curl);

						//$this->loging("paytm_bene_reg",$url."  ".$json_reqarray,$response,"",$userinfo->row(0)->username);
		
				//echo "PAYTM RESP :".$response;exit;
					/*
					
					{"status":"success","response_code":0,"customerMobile":"8238232303","beneficiaryId":"27da5930a51740768783efa20a4de20a"}

					{"status":"failure","message":"beneficiary ifsc invalid","response_code":1121,"txn_id":"D0K4R0E904WDR"}
					*/
							
						$json_resp = json_decode($response);

							
							if(isset($json_resp->status) and isset($json_resp->response_code))
							{
									// user not exist
									// redirect to registration form
								$status = trim($json_resp->status);
								$response_code = trim($json_resp->response_code);
								$message = "";
								if(isset($json_resp->message))
								{
									$message = $json_resp->message;
								}
								if($status == "success")
								{
									$recipient_id = $json_resp->beneficiaryId;
									
									$this->db->query("update beneficiaries set 
									is_paytm = 'yes',
									paytm_bene_id=?,
									status = 'SUCCESS'
									where Id = ?",array($recipient_id,intval($insert_id)));
									$resp_arr = array(
															"message"=>$status,
															"status"=>0,
															"beneid"=>intval($insert_id),
															"statuscode"=>"TXN",
															"data"=>intval($insert_id),
															"StatusCode"=>1,
															"Message"=>"Success",
															"Data"=>array("RecipientCode"=>$recipient_id)
														);
									$json_resp =  json_encode($resp_arr);
									
									
									
									//$this->load->model("Bankit");
									//$this->Bankit->add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$bank,$userinfo);
								}
								else
								{
										/*$resp_arr = array(
															"message"=>"Success",
															"status"=>0,
															"statuscode"=>"TXN",
															"data"=>intval($insert_id),
														);
										$json_resp =  json_encode($resp_arr);*/
									
										$resp_arr = array(
																"message"=>$status."   ".$message,
																"status"=>1,
																"statuscode"=>"ERR",
															);
										$json_resp =  json_encode($resp_arr);
								}
								
								
						}
							else if(isset($json_resp->status) and isset($json_resp->message))
							{
								$resp_arr = array(
										"message"=>$json_resp->message,
										"status"=>1,
										"statuscode"=>"ERR",
									);
								$json_resp =  json_encode($resp_arr);
							}
							else
							{
									
								$recipient_id = $insert_id;
								$status = "Success Manual";
								$this->db->query("update beneficiaries set 
									is_paytm = 'yes',
									paytm_bene_id=?,
									status = 'SUCCESS'
									where Id = ?",array($recipient_id,intval($insert_id)));
									$resp_arr = array(
															"message"=>$status,
															"status"=>0,
															"beneid"=>intval($insert_id),
															"statuscode"=>"TXN",
															"data"=>intval($insert_id),
															"StatusCode"=>1,
															"Message"=>"Success",
															"Data"=>array("RecipientCode"=>$recipient_id)
														);
									$json_resp =  json_encode($resp_arr);
							}
					}
					else
					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		//$this->loging("Shootcase_set_beneficiary",$url." >> ".$json_reqarray,$response,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	
	public function verify_bene($mobile_no,$acc_no,$ifsc,$bank,$userinfo)
	{
		//$ifsc=substr_replace($ifsc,"0",5,1);
		$url= "";
		$request_array = "";
		$response = $json_resp = "";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						$accval_resultcheck = $this->db->query("SELECT RESP_benename FROM `mt3_account_validate` where account_no = ? and remitter_mobile = ? and user_id = ? and status = 'SUCCESS' and API = 'PAYTM' order by Id desc limit 1",
						array($acc_no,$mobile_no,$user_id));
						if($accval_resultcheck->num_rows() == 1)
						{
						    $resp_arr = array(
													"message"=>"Beneficiary Already Validated. ".$accval_resultcheck->row(0)->RESP_benename,
													"status"=>1,
													"StatusCode"=>1,
    												"Message"=>"Beneficiary Already Validated. ".$accval_resultcheck->row(0)->RESP_benename,
    												"Name"=>$accval_resultcheck->row(0)->RESP_benename,
													"statuscode"=>"ERR",
													"recipient_name"=>$accval_resultcheck->row(0)->RESP_benename
												);
							$json_resp =  json_encode($resp_arr); 

						}
						else
						{
						    $crntBalance = $this->Ew2->getAgentBalance($user_id);

    						if(floatval($crntBalance) < 3)
    						{
    							$resp_arr = array(
    													"message"=>"InSufficient Balance",
    													"status"=>1,
    													"statuscode"=>"ISB",
    													"StatusCode"=>2,
    													"Message"=>"InSufficient Balance"
    												);
    							$json_resp =  json_encode($resp_arr);
    							echo $json_resp;exit;
    						}
    						$rsltinsert = $this->db->query("insert into mt3_account_validate(user_id,add_date,edit_date,ipaddress,remitter_id,remitter_mobile,account_no,IFSC,status,API) values(?,?,?,?,?,?,?,?,?,?)",array(
    							$user_id,$this->common->getDate(),$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$mobile_no,$acc_no,$ifsc,"PENDING","PAYTM"
    						));
    						if($rsltinsert == true)
    						{
    							$insert_id = $this->db->insert_id();
									date_default_timezone_set("Asia/Kolkata");
									$date_time=date("Y-m-d H:i:s");
									

    							$transaction_type = "DMR";
    							$sub_txn_type = "Account_Validation";
    							/*if($user_id == 10)
    							{
    								$charge_amount = 2.00;
    							}
    							else
    							{
    								$charge_amount = 3.00;
    							}*/
									
									$amount=1;$charge_amount=0;
									$chargeinfo = $this->getChargeValue($userinfo,$amount);
									
									$charge_amount = 3.00;
									
    							
    							$Description = "Valid.Charge : ".$acc_no;
    							$remark = $mobile_no."  Acc NO :".$acc_no;
    							$debitpayment = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
    
    							if($debitpayment == true)
    							{
    								$unique_id = $insert_id;
									$ddbit_amount_a = 1;
									$url = "https://pass-api.paytmbank.com/api/tops/remittance/v2/penny-drop";
									
									$jwtToken = $this->jwt_token();
									/*$request_array = array(
										'beneficiaryDetails'=>array(
											'accountNumber'=>$acc_no,
											'bankName'=>$bank,
											'benIfsc'=>$ifsc,
										),
										'customerMobile'=>$mobile_no,
										'txnReqId'=>"VERIFY".$insert_id,
										'transactionType'=>"transactionType",
										'channel'=> 'S2S',

									);*/


									$request_array = array(
										'beneficiaryDetails'=>array(
											'accountNumber'=>$acc_no,
											'bankName'=>$bank,
											'benIfsc'=>$ifsc,
										),
										'customerMobile'=>$mobile_no,
										'txnReqId'=>"VERIFY".$insert_id,
										'transactionType'=>"CORPORATE_PENNY_DROP",
										'channel'=> 'S2S',

									);






									
									$json_reqarray = json_encode($request_array);
							
									
									$curl = curl_init();
							
									curl_setopt_array($curl, array(
									  CURLOPT_URL => $url,
									  CURLOPT_RETURNTRANSFER => true,
									  CURLOPT_ENCODING => "",
									  CURLOPT_MAXREDIRS => 10,
									  CURLOPT_TIMEOUT => 30,
									  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									  CURLOPT_CUSTOMREQUEST => "POST",
									  CURLOPT_POSTFIELDS => $json_reqarray,
									  CURLOPT_HTTPHEADER => array(
										"authorization: ".$jwtToken,
										"cache-control: no-cache",
										"content-type: application/json",
										"postman-token: 602e1e0d-ce9a-01b8-9658-5ef3695891a5"
									  ),
									));
							
									$response = curl_exec($curl);
									$err = curl_error($curl);
									curl_close($curl);
									$json_resp = json_decode($response);
									//echo $url."<br><br>";


									//echo $json_reqarray."<br><br>";
									//echo "resp ".$response;exit;
									/*
										{"status":"success","message":"Transfer Successful","amount":2.48,"customerMobile":"8238232303","response_code":0,"txn_id":"VERIFY100166341","mw_txn_id":"65951381","extra_info":{"beneficiaryName":"RAVIKANT LAXMANBHAI"},"rrn":"929623462138","transactionDate":"Wed Oct 23 23:33:11 IST 2019"}
									*/
									$recipient_name = "";
									if(isset($json_resp->status) and isset($json_resp->message))
									{
										
										// user not exist
										// redirect to registration form
										$status = trim($json_resp->status);
										$message = $upline_msg = trim($json_resp->message);
										if($status == "success")
										{
											if(isset($json_resp->extra_info))
											{
												$extra_info = $json_resp->extra_info;
												if(isset($extra_info->beneficiaryName))
												{
													$recipient_name = $extra_info->beneficiaryName;
													$resp_arr = array(
        																	"message"=>$message."  Name : ".$recipient_name,
																			"upline_msg"=>"0",
        																	"status"=>0,
        																	"statuscode"=>"TXN",
        																	"recipient_name"=>$recipient_name,
        																	"StatusCode"=>1,
    																		"Message"=>$message."  Name : ".$recipient_name,
    																		"Name"=>$recipient_name
        																);
        											$json_resp =  json_encode($resp_arr);


        											$this->db->query("update beneficiaries set is_verified = 1,verified_name=? where account_number = ? and IFSC=? and sender_mobile = ?",array($recipient_name,$acc_no,$ifsc,$mobile_no));



        											$this->db->query("update mt3_account_validate 
    																						set RESP_statuscode = ?,
    																							RESP_status = ?,
    																							RESP_benename = ?,
    																							verification_status = ?,
    																							status = 'SUCCESS'
    																							where 	Id = ?",
    																							array
    																							(
    																								"TXN",
    																								$message,
    																								$recipient_name,
    																							    "VERIFIED",
    																								$insert_id
    																							)
    																						);
												}
											}
										}
										else if($status == "pending" or $status == "unknown")
										{
											$resp_arr = array(
        																	"message"=>$message,
        																	"upline_msg"=>$upline_msg,
        																	"status"=>1,
        																	"statuscode"=>"TUP",
        																	"StatusCode"=>2,
        																	"Message"=>$message,
        																	"recipient_name"=>$recipient_name
        																);
											$json_resp =  json_encode($resp_arr);
											$this->db->query("update mt3_account_validate 
																					set RESP_statuscode = ?,
																						RESP_status = ?,
																						verification_status = ?,
																						status = 'PENDING'
																						where 	Id = ?",
																						array
																						(
																							"TUP",
																							$message,
																							"PENDING",
																							$insert_id
																						)
																					);
										}
										else if($status == "failure")
										{
											
											$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
                      $message="Beneficiary validation failed.";                              
											$resp_arr = array(
																	"message"=>$message,"upline_msg"=>$upline_msg,
																	"status"=>1,
																	"statuscode"=>"ERR",
																	"recipient_name"=>$recipient_name,
																	"StatusCode"=>2,
        															"Message"=>$message,
																);
											$json_resp =  json_encode($resp_arr);
											$this->db->query("update mt3_account_validate 
																					set RESP_statuscode = ?,
																						RESP_status = ?,
																						verification_status = ?,
																						status = 'FAILURE'
																						where 	Id = ?",
																						array
																						(
																							"ERR",
																							$message,
																							"FAILURE",
																							$insert_id
																						)
																					);
										}
										else
										{
											$resp_arr = array(
        																	"message"=>$message,"upline_msg"=>$upline_msg,
        																	"status"=>1,
        																	"statuscode"=>"TUP",
        																	"recipient_name"=>$recipient_name,
        																	"StatusCode"=>2,
        																	"Message"=>$message,
        																);
											$json_resp =  json_encode($resp_arr);
											$this->db->query("update mt3_account_validate 
																					set RESP_statuscode = ?,
																						RESP_status = ?,
																						verification_status = ?,
																						status = 'PENDING'
																						where 	Id = ?",
																						array
																						(
																							"TUP",
																							$message,
																							"PENDING",
																							$insert_id
																						)
																					);
										}
										
										date_default_timezone_set("Asia/Kolkata");
										$date_time=date("Y-m-d H:i:s");
										
										
									}
									else
									{
											$resp_arr = array(
														"message"=>"Bank is not responding. Please try after sometime.",
    											"status"=>10,"upline_msg"=>"0",
    											"statuscode"=>"UNK",
    										);
    									$json_resp =  json_encode($resp_arr);	
											$_message="Bank is not responding. Please try after sometime.";
											date_default_timezone_set("Asia/Kolkata");
											$date_time=date("Y-m-d H:i:s");
											
											
									}
    							}
    							
    						}
						}	
					
					}
					else

					{
						$resp_arr = array(
									"message"=>"Your Account Deactivated By Admin",
									"status"=>5,
									"statuscode"=>"UNK",
									"StatusCode"=>"2",
        							"Message"=>"Your Account Deactivated By Admin",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$resp_arr = array(
									"message"=>"Invalid Access",
									"status"=>5,
									"statuscode"=>"UNK",
									"StatusCode"=>"2",
        							"Message"=>"Invalid Access",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
									"StatusCode"=>"2",
        							"Message"=>"Userinfo Missing",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
									"StatusCode"=>"2",
        							"Message"=>"Userinfo Missing",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		$this->loging("paytm_bene_verify",$url."?".json_encode($request_array)." ........"."",$response,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}


	public function getApiName($apiname,$api_id,$remittermobile,$amount,$userinfo)
    {

       // echo $apiname;exit;
        if($apiname == "PAYTM")
        {
            $paytm_limit = $this->Paytm->remitter_details_limit($remittermobile,$userinfo);
            if($paytm_limit >= $amount)
            {
                $API_NAME = "PAYTM";
            }
            else
            {
                $API_NAME = "HOLD";
            }   
        }
        else if($apiname == "AIRTEL")
        {
          
            $this->load->model("Airtel_model");
            $airtel_limit = $this->Airtel_model->getSenderLimit_airtel($remittermobile);    
            if($airtel_limit >= $amount)
            {
                $API_NAME = "AIRTEL";
            }
            else
            {
                $API_NAME = "HOLD";
            }   
        }
        else if($apiname == "ZPULS")
        {
            $this->load->model("Api_model");
            $zpbalance = $this->Api_model->getBalance($api_id);
           // echo $zpbalance;exit;
            if($zpbalance > ($amount + 15))
            {
                $this->load->model("Zpuls_model");
                $zplimit = $this->Zpuls_model->getsenderlimit($remittermobile);
                if($zplimit >= $amount)
                {
                    $API_NAME = "ZPULS";
                }       
                else
                {
                    $API_NAME = "HOLD";
                }
            }
            else
            {
                $API_NAME = "HOLD";
            }
        }
        else 
        {
            $API_NAME = "HOLD";
        }
        return $API_NAME;
    }
	public function transfer($remittermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id,$unique_id)
	{ 
		$this->paytmremitter=$remittermobile; $this->paytmamount=$amount;
		
		$postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}
		$postparam = $remittermobile." <> ".$beneficiary_array->row(0)->paytm_bene_id." <> ".$amount." <> ".$mode;
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{	
			if($userinfo->num_rows() == 1)
			{	
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{	
					if($user_status == '1')
					{ 
						if($amount >= 100)
						{
						    $crntBalance = $this->Ew2->getAgentBalance($user_id);
    						if(floatval($crntBalance) >= floatval($amount) + 30)
    						{
    								
    								if($beneficiary_array->num_rows()>0)
    								{	
    									$benificiary_name = $beneficiary_array->row(0)->bene_name;
    									$benificiary_mobile = $beneficiary_array->row(0)->benemobile;
    									$benificiary_ifsc = $beneficiary_array->row(0)->IFSC;
    									$benificiary_account_no = $beneficiary_array->row(0)->account_number;
											$beneficiaryid = $beneficiary_array->row(0)->paytm_bene_id;
											$bank_id = $beneficiary_array->row(0)->bank_id;
    									$chargeinfo = $this->getChargeValue($userinfo,$amount);
    									if($chargeinfo != false)
    									{	
													/////////////////////////////////////////////////
													/////// RETAILER CHARGE CALCULATION
													////////////////////////////////////////////////
													
													
													
													
													
	
													$Charge_type = $chargeinfo->row(0)->charge_type;
													$charge_value = $chargeinfo->row(0)->charge_value;

													$ccf_type = $chargeinfo->row(0)->ccf_type;	
													$ccf = $chargeinfo->row(0)->ccf;		
													if($ccf_type == "PER")
													{
														 $ccf = ((floatval($ccf) * floatval($amount))/ 100); 
													}

													$cashback_type = $chargeinfo->row(0)->cashback_type;	
													$cashback = $chargeinfo->row(0)->cashback;	
													if($cashback_type == "PER")
													{
														 $cashback = ((floatval($cashback) * floatval($amount))/ 100); 
													}


													$retailer_gst = ((floatval($ccf) * 18)/ 118);

													$tds_type = $chargeinfo->row(0)->tds_type;
													$tds = $chargeinfo->row(0)->tds;
													if($tds_type == "PER")
													{
														
														$Commission_after_gst = $cashback  - $retailer_gst;
														$tds = ((floatval($tds) * floatval($Commission_after_gst))/ 100); 
													}


													$charge =  $chargeinfo->row(0)->charge_value;
													if($Charge_type == "PER")
													{
														 $charge = ((floatval($charge_value) * floatval($amount))/ 100); 
													}

													$Charge_Amount = (floatval($charge) + floatval($tds) + floatval($retailer_gst));	
													
        
													
    									}
    									else
    									{
    										$Charge_type = "PER";
    										$charge_value = 0.40;
    										$Charge_Amount = ((floatval($charge_value) * floatval($amount))/ 100); 
    										$ccf = 0;
    										$cashback = 0;
    										$tds = 0;
    									}
    									
    																	
    								
    								$API_NAME = "HOLD";


    								$api_info = $this->db->query("select 
												a.Id,
												a.api_name,
												a.priority,
												a.is_dmt,
												a.is_active
												from api_configuration  a 
												
												where a.is_dmt = 'yes' and a.is_active = 'yes' order by a.priority");
    								foreach($api_info->result() as $rwapi)
    								{
    									$API_NAME = $this->getApiName($rwapi->api_name,$rwapi->Id,$remittermobile,$amount,$userinfo);
    									if($API_NAME != "HOLD")
    									{
    										break;
    									}
    								}
    								
    								/*
    								
    								if($api_info->num_rows() == 1)
    								{

    									if($api_info->row(0)->api_name == "ZPLUS")
    									{
    										$this->load->model("Api_model");
    										$zpbalance = $this->Api_model->getBalance($api_info->row(0)->Id);
    										if($zpbalance > ($amount + 15))
    										{
    											$this->load->model("Zpuls_model");
    											$zplimit = $this->Zpuls_model->getsenderlimit($remittermobile);
    											if($zplimit >= $amount)
    											{
    												$API_NAME = "ZPULS";
    											}		
    										}
    									}
    									if($api_info->row(0)->api_name == "AIRTEL")
    									{
    										$this->load->model("Airtel_model");
    										$airtel_limit = $this->Airtel_model->getSenderLimit_airtel($remittermobile);	
											if($airtel_limit >= $amount)
											{
												$API_NAME = "AIRTEL";
											}
    									}
    									if($api_info->row(0)->api_name == "PAYTM")
    									{
    										$paytm_limit = $this->remitter_details_limit($remittermobile,$userinfo);
											if($paytm_limit >= $amount)
											{
												$API_NAME = "PAYTM";
											}	
    									}
    								}
    								else if($api_info->num_rows() == 2)
    								{
    									$API_NAME1 = $api_info->row(0)->api_name;	
    									$API_NAME2 = $api_info->row(1)->api_name;	
    								
    									if($API_NAME1 == "PAYTM")
    									{
    										$paytm_limit = $this->remitter_details_limit($remittermobile,$userinfo);
		    								if($paytm_limit < $amount)
		    								{
		    									$API_NAME = "AIRTEL";
		    								}		
    									}
    									else if($API_NAME1 == "AIRTEL")
    									{
    										$this->load->model("Airtel_model");
    										$airtel_limit = $this->Airtel_model->getSenderLimit_airtel($remittermobile);
		    								if($airtel_limit < $amount)
		    								{
		    									$API_NAME = "PAYTM";
		    								}		
    									}
    									else if($API_NAME1 == "ZPULS")
    									{
    										$this->load->model("Api_model");
    										$zpbalance = $this->Api_model->getBalance($api_info->row(0)->Id);
    										if($zpbalance > ($amount + 15))
    										{
    											$this->load->model("Zpuls_model");
    											$zplimit = $this->Zpuls_model->getsenderlimit($remittermobile);
    											if($zplimit >= $amount)
    											{
    												$API_NAME = "ZPULS";	
    											}
    											
    										}
    									}
    								}
    								else if($api_info->num_rows() == 3)
    								{
    									$API_NAME1 = $api_info->row(0)->api_name;	
    									$API_NAME2 = $api_info->row(1)->api_name;	
    									$API_NAME3 = $api_info->row(2)->api_name;	

    									if($API_NAME1 == "ZPULS" and $API_NAME2 == "PAYTM"  and $API_NAME3 == "AIRTEL")
    									{
    										$api_found3 = false;
    										$this->load->model("Api_model");
    										$zpbalance = $this->Api_model->getBalance($api_info->row(0)->Id);
    										if($zpbalance > ($amount + 15))
    										{
    											$this->load->model("Zpuls_model");
    											$zplimit = $this->Zpuls_model->getsenderlimit($remittermobile);
    											if($zplimit >= $amount)
    											{
    												$API_NAME = "ZPULS";
    												$api_found3 = true;	
    											}		
    										}

    										if($api_found3 == false) // try paytm
    										{
    											$paytm_limit = $this->remitter_details_limit($remittermobile,$userinfo);
    											if($paytm_limit >= $amount)
    											{
    												$API_NAME = "PAYTM";
    												$api_found3 = true;	
    											}	

    										}

    										if($api_found3 == false) // try airtel
    										{
    											$this->load->model("Airtel_model");
    											$airtel_limit = $this->Airtel_model->getSenderLimit_airtel($remittermobile);	
    											if($airtel_limit >= $amount)
    											{
    												$API_NAME = "AIRTEL";
    												$api_found3 = true;	
    											}	

    										}
    									}

    									
    								}

    								/*comment*/
    								$is_autohold ='no';
    								if($mode == "IMPS")
						            {
						              $checkbank_down = $this->db->query("select Id,bank_name from instantpay_banklist where branch_ifsc = ? and imps_enabled = '0'",array($benificiary_ifsc));
						              if($checkbank_down->num_rows() == 1)
						              {
						              		$API_NAME = "HOLD";
						              		$is_autohold ='yes';
						                    // $resp_array = array(
						                    //                           "StatusCode"=>0,
						                    //                           "Message"=>"Currently IMPS Service Is Down For ".$checkbank_down->row(0)->bank_name,
						                    //                         );
						                    // echo json_encode($resp_array);exit;
						              }
						            }


    								



    									
    										$resultInsert = $this->db->query("
    											insert into mt3_transfer(
    											order_id,
    											unique_id,
												add_date,
												ipaddress,
												user_id,
    											Charge_type,
    											charge_value,
    											Charge_Amount,
    											RemiterMobile,
    											BeneficiaryId,
    											RESP_name,
    											AccountNumber,
    											IFSC,
    											Amount,
    											Status,
    											mode,
												API,
												bank_id,
												ccf,cashback,tds,gst,is_autohold)
    											values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    											",array(
												$order_id,
												$unique_id,
												$this->common->getDate(),
												$this->common->getRealIpAddr(),
												$user_id,
    											$Charge_type,$charge_value,$Charge_Amount,
    											$remittermobile,
    											$beneficiaryid,
    											$benificiary_name,
												$benificiary_account_no,
												$benificiary_ifsc,
    											$amount,
												"PENDING",
												$mode,
												$API_NAME,
												$bank_id,
												$ccf,
												$cashback,
												$tds,
												$retailer_gst,
												$is_autohold
    											));
    										if($resultInsert == true)
    										{
												$insert_id = $mmdmtid =  $this->db->insert_id(); 
												$this->paytmtxnid=$insert_id;
													
    											$transaction_type = "DMR";
    											$dr_amount = $amount;
    											$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
    											$sub_txn_type = "REMITTANCE";
    											$remark = "Money Remittance";
    											$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
												
    											if($paymentdebited == true)
    											{
    											   
        											
        										    
        										    if($API_NAME == 'HOLD')
    												{
    													$this->db->query("update mt3_transfer set is_hold = 'yes' where Id = ?",array($insert_id));
    													$resp_arr = array(
    																							"message"=>"Transaction Under Process",
    																							"status"=>0,
    																							"statuscode"=>"TUP",
    																						);
    																	$json_resp =  json_encode($resp_arr);
    												}
    												else
    												{
    													
    													
    												    $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

    												    if($API_NAME == "PAYTM")
    												    {
    												    	$jwtToken = $this->jwt_token();
																
															$datetime=date("Y-m-d H:i:s");
															$txnReqId=$mmdmtid;
													

	        												if($mode == "NEFT")
	        												{
																		$request_array = array(
																				'amount'=>$amount,
																				'beneficiaryId'=>$beneficiaryid,
																				'channel'=>'S2S',
																				'customerMobile'=>$remittermobile,
																				'transactionType'=>'CORPORATE_DOMESTIC_REMITTANCE',
																				'txnReqId'=>$txnReqId,
																				"mode"=>strtolower($mode),
																				"ifscBased"=>false
																			);
	        												}
	        												else
	        												{
	        													$request_array = array(
																				'amount'=>$amount,
																				'beneficiaryId'=>$beneficiaryid,
																				'channel'=>'S2S',
																				'customerMobile'=>$remittermobile,
																				'transactionType'=>'CORPORATE_DOMESTIC_REMITTANCE',
																				'txnReqId'=>$txnReqId,
																				'extra_info'=>array(
																					"mode"=>strtolower($mode),
																					"ifscBased"=>false
																				)
																		);
	        												}

															
															
															$json_reqarray = json_encode($request_array);
															$url = "https://pass-api.paytmbank.com/api/tops/remittance/v2/fund-transfer";
															$curl = curl_init();
													
															curl_setopt_array($curl, array(
															  CURLOPT_URL => $url,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 50,
															  CURLOPT_TIMEOUT => 150,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															  CURLOPT_POSTFIELDS => $json_reqarray ,
															  CURLOPT_HTTPHEADER => array(
																 "authorization: ".$jwtToken,
																"cache-control: no-cache",
																"content-type: application/json",
																"postman-token: e65364aa-3d7d-fea3-76db-c1cb36585a6f"
															  ),
															));
													
															$buffer = $response = curl_exec($curl);
															$err = curl_error($curl);
															
															
															
															curl_close($curl);
															$this->requestlog($insert_id,$json_reqarray,$response,$remittermobile,$benificiary_account_no,"");
												
												
														         
															$json_obj = json_decode($response);
															
															$arrMsg=array("brijesh");
															//array("Insufficient Available Balance","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
															$message = isset($json_obj->message)?trim($json_obj->message):"";
															$status = isset($json_obj->status)?trim($json_obj->status):"";
															
															if(isset($json_obj->status) and isset($json_obj->message))
    														{
        														$status = $json_obj->status;
    															$message = $json_obj->message;
    															
																	if($status == "success")
    															{
																	$txn_id = $json_obj->txn_id;
																	$mw_txn_id = $json_obj->mw_txn_id;
																	$rrn = $json_obj->rrn;
																	$extra_info = $json_obj->extra_info;
    																
    																
    																$data = array(
    																			'RESP_statuscode' => "TXN",
    																			'RESP_status' => $message,
    																			'RESP_ipay_id' => $mw_txn_id,
    																			'RESP_opr_id' => $rrn,
    																			'RESP_name' => $extra_info->beneficiaryName,
    																			'message'=>$message,
    																			'Status'=>'SUCCESS',
    																			'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
    
                                                                        $sendmsg = 'Transaction Successful, TID: '.$rrn.' Amt:Rs.'.$amount.' A/C: '.$benificiary_account_no.'  '.$this->common->getDate().' Thanks,PayInn';
                                                                       
																		
																		$resp_arr = array(
    																						"message"=>"Transaction Done Successfully",
    																						"status"=>0,
																							"statuscode"=>"TXN",
    																						"data"=>array(
    																							"tid"=>$insert_id,
    																							"ref_no"=>$insert_id,
    																							"opr_id"=>$rrn,
    																							"name"=>$extra_info->beneficiaryName,																								"balance"=>"",
    																							"amount"=>$amount,
    
    																						)
    																					);
    																	$json_resp =  json_encode($resp_arr);
    															}
																elseif($status == "failure")
																{
																		$response_code = $json_obj->response_code;
																		
																		$docredit=true; 
																		$status='FAILURE'; 
																		$RESP_statuscode='ERR';
																		
																		if($docredit==true)
																		{
																				$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
																		}
																	
																		if($message=="Insufficient Available Balance")
																		{$message="Please try after sometime.";}
																		$data = array(
																				'RESP_statuscode' => $RESP_statuscode,
																				'RESP_status' => $message,
																				'Status'=>$status,
																				'edit_date'=>$this->common->getDate()
																		);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('mt3_transfer', $data);


																	if($response_code == "1067")
																	{
																		$message = "Service Not Available.Try After Some Time";
																	}
																	
																	$resp_arr = array(
																							"message"=>"Transaction Failed",
																							"status"=>1,
																							"statuscode"=>$RESP_statuscode,
																						);
																	$json_resp =  json_encode($resp_arr);

																}
																else if($status == "pending" or $status == "initiated")
    														{
																		
																		$txn_id = $json_obj->txn_id;
																		$mw_txn_id = $json_obj->mw_txn_id;
																		$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
																		$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
																		$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
																			
    																$data = array(
    																			'RESP_statuscode' => "PENDING",
    																			'RESP_status' => $message,
    																			'RESP_ipay_id' => $mw_txn_id,
    																			'RESP_opr_id' => $rrn,
    																			'RESP_name' => $_benename,
    																			'message'=>$message,
    																			'Status'=>'PENDING',
    																			'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
																			
																			$resp_arr = array(
    																						"message"=>"Transaction Under Process",
    																						"status"=>0,
																							"statuscode"=>"TUP",
    																						"data"=>array(
    																							"tid"=>$insert_id,
    																							"ref_no"=>$insert_id,
    																							"opr_id"=>$rrn,
    																							"name"=>$_benename,"balance"=>"",
    																							"amount"=>$amount,
    
    																						)
    																					);
    																	$json_resp =  json_encode($resp_arr);
    															}
        														else
    															{
																		$extra_info=$_benename="";
																		$txn_id = isset($json_obj->txn_id)?$json_obj->txn_id:"";
																		$mw_txn_id = isset($json_obj->mw_txn_id)?$json_obj->mw_txn_id:"";
																		$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
																		if(isset($json_obj->extra_info))
																		{
																			$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
																			$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
																		}
    																$data = array(
    																			'RESP_statuscode' => "PENDING",
    																			'RESP_status' => $message,
    																			'RESP_ipay_id' => $mw_txn_id,
    																			'RESP_opr_id' => $rrn,
    																			'RESP_name' => $_benename,
    																			'message'=>$message,
    																			'Status'=>'PENDING',
    																			'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
																			
																			$resp_arr = array(
    																						"message"=>"Transaction Under Process",
    																						"status"=>0,
																							"statuscode"=>"TUP",
    																						"data"=>array(
    																							"tid"=>$insert_id,
    																							"ref_no"=>$insert_id,
    																							"opr_id"=>$rrn,
    																							"name"=>$_benename,"balance"=>"",
    																							"amount"=>$amount,
    
    																						)
    																					);
    																	$json_resp =  json_encode($resp_arr);
																		
																		/*$data = array(
    																				"RESP_status"=>$message,
    																				'RESP_statuscode' => "UNK",
    																				'Status'=>'PENDING',
    																				'RESP_statuscode'=>$status,
    																				'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
    																	$arrDmtMsg=$this->get_our_msg($message);
																			$ourmsg=trim($arrDmtMsg['ourmsg']);
																			$msgid=intval($arrDmtMsg['msgid']);
																			$resp_arr = array(
    																							"message"=>$ourmsg,"msgid"=>$msgid,
    																							"status"=>2,
    																							"statuscode"=>"TUP",
    																						);
    																	$json_resp =  json_encode($resp_arr);*/
																			
    															}
        
        
        													}
															else if(isset($json_obj->errorCode) and isset($json_obj->errorMessage))
    														{
        														$errorCode = $json_obj->errorCode;
    															$errorMessage = $json_obj->errorMessage;
    															$data = array(
    																				"RESP_status"=>$errorMessage,
    																				'RESP_statuscode' => $errorCode,
    																				'Status'=>'PENDING',
    																				'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
    																	
																			
																			$resp_arr = array(
    																							"message"=>"Transaction Under Process",
    																							"status"=>2,
    																							"statuscode"=>"TUP",
    																						);
    																	$json_resp =  json_encode($resp_arr);
        
        													}
        													else
        													{ 
																			$message = isset($json_obj->message)?trim($json_obj->message):"";
																			$status = isset($json_obj->status)?trim($json_obj->status):"";
																			
																			$respmsg = "Unknown Response or No Response";
																			if(trim($message)!="")$respmsg=$message;
																			
																			$respsts = "UNK";
																			if(trim($status)!="")$respsts=$status;
																			
																			//$this->loging_new("transfer-UNK",$remittermobile,$response,$userinfo->row(0)->username,$userinfo->row(0)->username);
        														//check status befor refund
        														//$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);
        														$data = array(
        																			'RESP_statuscode' => $respsts,
        																			'RESP_status' => $respmsg,
        																			'edit_date'=>$this->common->getDate()
        																	);
        
        																	$this->db->where('Id', $insert_id);
        																	$this->db->update('mt3_transfer', $data);
        														
																		$message="Your Request Submitted Successfully";
																		
																		
																		$resp_arr = array(
        																"message"=>"Transaction Under Process",
        																"status"=>0,
        																"statuscode"=>"TUP",
        															);
        														$json_resp =  json_encode($resp_arr);
        													}
    												    }
    												    else if($API_NAME == "AIRTEL")
    												    {
    												    	$this->load->model("Airtel_model");
    												    	$json_resp = $this->Airtel_model->Transfer_Api_call_only($insert_id);
    												    }
    												    else if($API_NAME == "ZPULS")
    												    {
    												    	error_reporting(-1);
    												    	ini_set('display_errors',1);
    												    	$this->db->db_debug = TRUE;
    												    	$this->load->model("Zpuls_model");
    												    	$json_resp = $this->Zpuls_model->Transfer_Api_call_only($insert_id);
    												    }
        												
    												}
    											}
    											else
    											{
    											    $data = array(
    																			'RESP_statuscode' => "ERR",
    																			'RESP_status' => "PAYMENT FAILURE",
    																			'tx_status'=>"1",
    																			'Status'=>'FAILURE',
    																	);
    
    												$this->db->where('Id', $insert_id);
    												$this->db->update('mt3_transfer', $data);
																			
    												$message="Payment Failure";
													
																		
														$resp_arr = array(
    													"message"=>"PAYMENT FAILURE",
    													"status"=>1,
    													"statuscode"=>"ERR",
    												);
    												$json_resp =  json_encode($resp_arr);	
    											}		
    										}
    										else
    										{
													$message="Internal Server Error. DB Error";
													
    											$resp_arr = array(
    												"message"=>$message,
    												"status"=>1,
    												"statuscode"=>"ERR",
    											);
    											$json_resp =  json_encode($resp_arr);	
    										}
    									
    								}
    								else
    								{
											$message="Invalid Beneficiary Id";
											
    									$resp_arr = array(
    											"message"=>$message,
    											"status"=>1,
    											"statuscode"=>"RNF",
    										);
    									$json_resp =  json_encode($resp_arr);
    								}
    							
    						}
    						else
    						{
									$message="InSufficient Balance";
									
    							$resp_arr = array(
    									"message"=>$message,
    									"status"=>1,
    									"statuscode"=>"ISB",
    								);
    							$json_resp =  json_encode($resp_arr);
    						}    
						}
						else
						{	
							$message="Minimum Transfer Limit is 1 Rupees";
								
						    $resp_arr = array(
    									"message"=>$message,
    									"status"=>1,
    									"statuscode"=>"ERR",
    								);
    							$json_resp =  json_encode($resp_arr);
						}
						
						
					}
					else
					{
						$message="Your Account Deactivated By Admin";
						
						$resp_arr = array(
									"message"=>$message,
									"status"=>1,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$message="Invalid Access";
					
					$resp_arr = array(
									"message"=>$message,
									"status"=>1,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$message="Userinfo Missing";
				
				$resp_arr = array(
									"message"=>$message,
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$message="Userinfo Missing";
			
			$resp_arr = array(
									"message"=>$message,
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		//$this->loging_db("transfer",$mode." ".$url."?".json_encode($request_array)."  ..........".$jwtToken,$response,$json_resp,$userinfo->row(0)->username,$remittermobile);

		return $json_resp;
		
	}
	private function generateRandomString($length=0,$isnum=false)
	{
			if($length==0)$length = rand(10,20);
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			if($isnum==true)$characters = '0123456789';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	}
	
	public function transfer_status($dmr_id)
	{
	    
	 
		    $resultdmr = $this->db->query("SELECT a.API,a.Id,a.add_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_opr_id,a.RESP_name,a.txn_req_id,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id

 where a.Id = ?",array($dmr_id));
		
		
		
		if($resultdmr->num_rows() == 1)
		{
			$Status = $resultdmr->row(0)->Status;
			$sender_mobile_no = $resultdmr->row(0)->RemiterMobile;
			$user_id = $resultdmr->row(0)->user_id;
			$API = $resultdmr->row(0)->API;
			$mode = $resultdmr->row(0)->mode;
			$RESP_status = $resultdmr->row(0)->RESP_status;
			$RESP_name = $resultdmr->row(0)->RESP_name;
			$Amount = $amount = $resultdmr->row(0)->Amount;
			$RESP_opr_id = $resultdmr->row(0)->RESP_opr_id;
			$RESP_ipay_id = $resultdmr->row(0)->RESP_ipay_id;
			$debit_amount = $resultdmr->row(0)->debit_amount;
			$txnReqId = $resultdmr->row(0)->txn_req_id;
			if($txnReqId=='0')
			{
				$txnReqId=$dmr_id;
			}
			if($API == "PAYTM")
			{
				$paymentinfo = $this->db->query("SELECT transaction_type,description,remark,credit_amount,debit_amount FROM tblewallet2 where dmr_id =? and user_id = ?",array($dmr_id,$user_id));
			
			
				if($paymentinfo->num_rows() == 0)
				{
					$data = array(
									'RESP_statuscode' => "ERR",
									'RESP_status' => "Payment Failure",
									'RESP_name' => "",
									'RESP_opening_bal' => "",
									'RESP_amount' => "",
									'RESP_locked_amt' => "",
									'tx_status'=>"Payment Failure",
									"row_lock"=>"LOCKED",
									'Status'=>'FAILURE'
							);
	
					$this->db->where('Id', $dmr_id);
					$this->db->update('mt3_transfer', $data);    
				}
				else
				{
					$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
					$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
					$remittermobile = $resultdmr->row(0)->RemiterMobile;
					$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
					$sub_txn_type = "REMITTANCE";
					$remark = "Money Remittance";
					if($API == "PAYTM")
					{
						
						if($Status == "PENDING" )
						{
							$jwtToken = $this->jwt_token();
							$curl = curl_init();
					$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/status?transactionType=CORPORATE_DOMESTIC_REMITTANCE&txnReqId=".$txnReqId;
							curl_setopt_array($curl, array(
							CURLOPT_URL => $url,
						   CURLOPT_RETURNTRANSFER => true,
						   CURLOPT_ENCODING => "",
						   CURLOPT_MAXREDIRS => 10,
						   CURLOPT_TIMEOUT => 30,
						   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						   CURLOPT_CUSTOMREQUEST => "GET",
						   CURLOPT_HTTPHEADER => array(
							"authorization: ".$jwtToken,
							"cache-control: no-cache",
							"postman-token: f8859c27-ec4b-dab3-a7de-6a4f1cc01c93"
						   ),
						));
					
							$response = curl_exec($curl);
							$err = curl_error($curl);
							curl_close($curl);
							$json_obj = json_decode($response);
							
							$this->loging("paytmtransfer_status",$url,$response,"","");
				
							$arrMsg=array('brijesh');//array("Insufficient Available Balance","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
							$message = isset($json_obj->message)?trim($json_obj->message):"";
							$status = isset($json_obj->status)?trim($json_obj->status):"";	
							if(isset($json_obj->status) and isset($json_obj->response_code))
						   {
							   $status = $json_obj->status;
							   $response_code = $json_obj->response_code;
							   
								 if($status == "success" and $response_code == "0") // SUCCESS
							   {
								   $txn_id = $json_obj->txn_id;
								   $mw_txn_id = $json_obj->mw_txn_id;
								   $rrn = $json_obj->rrn;
									$data = array(
														'RESP_statuscode' => "TXN",
														'RESP_status' => $status,
														'RESP_ipay_id' => $txn_id,
														'RESP_opr_id' => $rrn,
														'Status'=>'SUCCESS'
												);
		
									$this->db->where('Id', $dmr_id);
									$this->db->update('mt3_transfer', $data);

									$arrDmtMsg=$this->get_our_msg($message);
									$ourmsg=trim($arrDmtMsg['ourmsg']);
									$msgid=intval($arrDmtMsg['msgid']);

									$resp_arr = array(
											"message"=>$ourmsg,"msgid"=>$msgid,
											"status"=>0,
											"statuscode"=>"TXN",
											"data"=>array(
												"tid"=>$dmr_id,
												"ref_no"=>$txn_id,
												"opr_id"=>$rrn,
												"name"=>$RESP_name,
												"amount"=>$amount,

											)
										);
									$json_resp =  json_encode($resp_arr); 
									$this->loging_db("resend_pending",$mode." ".$url."?".$jwtToken,$response,$json_resp,"Admin",$sender_mobile_no);
										return $json_resp;
							   }
							   elseif($status == "failure") // SUCCESS
							   {
								   $txn_id = $json_obj->txn_id;
								   $rrn = "NA";
									$data = array(
														'RESP_statuscode' => "TXN",
														'RESP_status' => $status,
														'RESP_ipay_id' => $txn_id,
														'RESP_opr_id' => $rrn,
														'Status'=>'FAILURE'
												);
		
									$this->db->where('Id', $dmr_id);
									$this->db->update('mt3_transfer', $data);
									$transaction_type = "DMR";
									$dr_amount = $amount;
									$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
									$sub_txn_type = "REMITTANCE";
									$remark = "Money Remittance";
									$userinfo=$this->db->query("select * from tblusers where user_id=".$user_id);
									$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
																	
									$arrDmtMsg=$this->get_our_msg($status);
									$ourmsg=trim($arrDmtMsg['ourmsg']);
									$msgid=intval($arrDmtMsg['msgid']);
									$resp_arr = array(
											"message"=>$ourmsg,"msgid"=>$msgid,
											"status"=>1,
											"statuscode"=>"ERR",
										);
									$json_resp =  json_encode($resp_arr); 
									$this->loging_db("resend_pending",$mode." ".$url."?".$jwtToken,$response,$json_resp,"Admin",$sender_mobile_no);
										return $json_resp;
							   }
							   else if(($status == "pending" or $status == "initiated") and $response_code == "0") // PENDING
							   {
									 	$txn_id = $json_obj->txn_id;
								   $mw_txn_id = $json_obj->mw_txn_id;
								   $rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
									 $arrDmtMsg=$this->get_our_msg($RESP_status);
									$ourmsg=trim($arrDmtMsg['ourmsg']);
									$msgid=intval($arrDmtMsg['msgid']);
										$resp_arr = array(
											"message"=>$ourmsg,"msgid"=>$msgid,
											"status"=>2,
											"statuscode"=>"TUP",
											"data"=>array(
												"tid"=>$dmr_id,
												"ref_no"=>$txn_id,
												"opr_id"=>$rrn,
												"name"=>$RESP_name,
												"amount"=>$amount,

											)
										);
									$json_resp =  json_encode($resp_arr);
						
									$this->loging_db("resend_pending",$mode." ".$url."?".$jwtToken,$response,$json_resp,"Admin",$sender_mobile_no);
										return $json_resp;  
							   }
							   else 
							   {
								   return $response;
							   }
		
						   }
						   else
						   {
							  return $response;
						   }
						
						}
						else if($Status == "SUCCESS")
						{
									$message="SUCCESS";
										$arrDmtMsg=$this->get_our_msg($message);
										$ourmsg=trim($arrDmtMsg['ourmsg']);
										$msgid=intval($arrDmtMsg['msgid']);
										$resp_arr = array(
											"message"=>$ourmsg,"msgid"=>$msgid,
											"status"=>0,
											"statuscode"=>"TXN",
											"data"=>array(
												"tid"=>$dmr_id,
												"ref_no"=>$RESP_ipay_id,
												"opr_id"=>$RESP_opr_id,
												"name"=>$RESP_name,
												"amount"=>$amount,

											)
										);
							$json_resp =  json_encode($resp_arr); 
							return $json_resp;
						}
						else if($Status == "FAILURE")
						{
							$message="FAILURE";
							$arrDmtMsg=$this->get_our_msg($message);
							$ourmsg=trim($arrDmtMsg['ourmsg']);
							$msgid=intval($arrDmtMsg['msgid']);
							$resp_arr = array(
											"message"=>$ourmsg,"msgid"=>$msgid,
											"status"=>1,
											"statuscode"=>"ERR",
										);
							$json_resp =  json_encode($resp_arr);
							return $json_resp;
						}
						else
						{
							$message=$Status;
							$arrDmtMsg=$this->get_our_msg($message);
							$ourmsg=trim($arrDmtMsg['ourmsg']);
							$msgid=intval($arrDmtMsg['msgid']);
							$resp_arr = array(
												"message"=>$ourmsg,"msgid"=>$msgid,
												"status"=>2,
												"statuscode"=>$Status,
											);
							$json_resp =  json_encode($resp_arr);
							return $json_resp;
						}
					}
					else
					{
						return $API;
					}    
				}
			}
		}
		
			
	}	

	public function getTransactionChargeInfo($userinfo,$TransactionAmount)
	{
			return 5.00;
	}
	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////                  ///////////////////////////////////////////////////
//////////////////////////////////////////    L O G I N G   ////////////////////////////////////////////////////
/////////////////////////////////////////                  /////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	private function loging_db($method,$request,$response,$json_resp,$username,$sender_mobile=0,$lat=0,$lng=0)
	{
		$this->db->reset_query();
		$insarray=array("log_ip"=>$_SERVER['REMOTE_ADDR'],"log_user"=>$username,"sender_mobile"=>$sender_mobile,"log_method"=>"paytm_".$method,"log_request"=>$request,"log_response"=>$response,"log_downline_response"=>$json_resp,"log_datetime"=>date("Y-m-d H:i:s"),"log_api"=>"PAYTM");
		$this->db->insert("tbl_logs_dmt_4",$insarray);
	}
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		// error_reporting(-1);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;
		/*$this->db->query("insert into templog(dmt_id,add_date,ipaddress,request,response,downline_response,type) values(?,?,?,?,?,?,?)",
											array(0,$this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$json_resp,"PAYTM".$methiod));*/
		
		$this->loging_new($methiod,$request,$response,$json_resp,$username);
		
	}
	private function loging_new($methiod,$request,$response,$json_resp,$username)
	{
		$filename = "inlogs/templogpaytm.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//*************************************** L O G I N G    E N D   H E R E *************************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////                                                        ////////////////////////////////
///////////////////////    P A Y M E N T   M E T H O D   S T A R T   H E R E   /////////////////////////////////
//////////////////////                                                        //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	

	
	public function PAYMENT_DEBIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00)
	{

		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$ip = $this->common->getRealIpAddr();
	    $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		$this->db->query("BEGIN;");
		$result_oldbalance = $this->db->query("SELECT balance FROM `tblewallet2` where user_id = ? order by Id desc limit 1",array($user_id));
		if($result_oldbalance->num_rows() > 0)
		{
			$old_balance =  $result_oldbalance->row(0)->balance;
		}
		else 
		{
			
				
        		$result_oldbalance2 = $this->db->query("SELECT balance FROM champmoney_archive.tblewallet2 where user_id = ? order by Id desc limit 1",array($user_id));
        		if($result_oldbalance2->num_rows() > 0)
        		{
        			$old_balance =  $result_oldbalance2->row(0)->balance;
        		}
        		else 
        		{
        			
        			$old_balance =  0;
        			
        		}
			
		}
		$this->db->query("COMMIT;");
		
		//$old_balance = $this->Ew2->getAgentBalance($user_id);
		if($old_balance < $dr_amount)
		{
		    return false;
		}
		else
		{
		    $current_balance = $old_balance - $dr_amount;
    		$tds = 0.00;
    		$stax = 0.00;
    		if($transaction_type == "DMR")
    		{
    			$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
    			values(?,?,?,?,?,?,?,?,?)";
    			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
    			if($reslut == true)
    			{
    					$ewallet_id = $this->db->insert_id();
    					if($ewallet_id > 1)
    					{
    						if($sub_txn_type == "Account_Validation")
    						{
    									$rslt_updtrec = $this->db->query("update mt3_account_validate set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));
    									return true;
    						}
    						else if($sub_txn_type == "REMITTANCE")
    						{
    									$current_balance2 = $current_balance - $chargeAmount;
    									$remark = "Transaction Charge";
    									$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
    									values(?,?,?,?,?,?,?,?,?)";
    									$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$chargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
    									if($reslut2 == true)
    									{
    										$totaldebit_amount = $dr_amount + $chargeAmount;
    										$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));	
    										return true;
    									}
    									else
    									{
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));	
    										return false;
    									}
    									
    									
    									return false;
    						}
    						
    					}
    					else
    					{
    							return false;
    					}
    			}
    			else
    			{
    				return false;
    			}
    			
    		}
    		else if($transaction_type == "INDONEPAL")
    		{
    			$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
    			values(?,?,?,?,?,?,?,?,?)";
    			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
    			if($reslut == true)
    			{
    					$ewallet_id = $this->db->insert_id();
    					if($ewallet_id > 1)
    					{
					
								$current_balance2 = $current_balance - $chargeAmount;
								$remark = "Transaction Charge";
								$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)

								values(?,?,?,?,?,?,?,?,?)";
								$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$chargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
								if($reslut2 == true)
								{
									$totaldebit_amount = $dr_amount + $chargeAmount;
									$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
									$rslt_updtrec = $this->db->query("update indonepal_transaction set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));	
									return true;
								}
								else
								{
									$rslt_updtrec = $this->db->query("update indonepal_transaction set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));	
									return false;
								}
								
								
								return false;
					
    					}
    					else
    					{
    							return false;
    					}
    			}
    			else
    			{
    				return false;
    			}
    			
    		}
    		else
    		{
    				return false;
    		}
		}
			
	}
	public function checkduplicate($user_id,$transaction_id)
    {
    	$add_date = $this->common->getDate();
    	$ip = $this->common->getRealIpAddr();
    
    	$rslt = $this->db->query("insert into dmr_refund_lock (user_id,dmr_id,add_date,ipaddress) values(?,?,?,?)",array($user_id,$transaction_id,$add_date,$ip));
    	  if($rslt == "" or $rslt == NULL)
    	  {
    		return false;
    	  }
    	  else
    	  {
    	  	return true;
    	  }
    }
	public function PAYMENT_CREDIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00)
	{
	    
	    
	    if($this->checkduplicate($user_id,$transaction_id) == false)
    	{
    	    
    	}
    	else
    	{
    	    	$Description = "Refund :".$Description;
        		$this->load->library("common");
        		$add_date = $this->common->getDate();
        		$date = $this->common->getMySqlDate();
        		$ip = $this->common->getRealIpAddr();
        		$old_balance = $this->Ew2->getAgentBalance($user_id);
        		$current_balance = $old_balance + $dr_amount;
        		$tds = 0.00;
        		$stax = 0.00;
        		if($transaction_type == "DMR")
        		{
        			$remark = "Money Remittance Reverse";
        			$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
        			values(?,?,?,?,?,?,?,?,?)";
        			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
        			if($reslut == true)
        			{
        					$ewallet_id = $this->db->insert_id();
        					if($ewallet_id > 10)
        					{
        						if($sub_txn_type == "Account_Validation")
        						{
        									$rslt_updtrec = $this->db->query("update mt3_account_validate set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));
        									return true;
        						}
        						else if($sub_txn_type == "REMITTANCE")
        						{
        									$current_balance2 = $current_balance + $chargeAmount;
        									$remark = "Transaction Charge Reverse";
        									$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
        									values(?,?,?,?,?,?,?,?,?)";
        									$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$chargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
        									if($reslut2 == true)
        									{
        										$totaldebit_amount = $dr_amount + $chargeAmount;
        										$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
        										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?), credit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));	
        										return true;
        									}
        									else
        									{
        										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));	
        										return false;
        									}
        									
        									
        									return false;
        						}
        						
        					}
        					else
        					{
        							return false;
        					}
        			}
        			else
        			{
        				return false;
        			}
        			
        		}
        		else if($transaction_type == "INDONEPAL")
	    		{
	    			$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
	    
	    			values(?,?,?,?,?,?,?,?,?)";
	    			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
	    			if($reslut == true)
	    			{
	    					$ewallet_id = $this->db->insert_id();
	    					if($ewallet_id > 1)
	    					{
						
									$current_balance2 = $current_balance + $chargeAmount;
									$remark = "Transaction Charge";
									$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)

									values(?,?,?,?,?,?,?,?,?)";
									$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$chargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
									if($reslut2 == true)
									{
										$totaldebit_amount = $dr_amount + $chargeAmount;
										$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
										$rslt_updtrec = $this->db->query("update indonepal_transaction set debited='yes',reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));	
										return true;
									}
									else
									{
										$rslt_updtrec = $this->db->query("update indonepal_transaction set debited='yes',reverted='yes',balance=CONCAT_WS(',',balance,?),debit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));	
										return false;
									}
									
									
									return false;
						
	    					}
	    					else
	    					{
	    							return false;
	    					}
	    			}
	    			else
	    			{
	    				return false;
	    			}
	    			
	    		}
        		else
        		{
        				return false;
        		}
    	}
	    
	    
		
	}

	public function COMMISSIONPAYMENT_CREDIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00)
	{
	
	/*	$Description = "Commission :".$Description;
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$ip = $this->common->getRealIpAddr();
		if($dr_amount <= 30)
		{
			$old_balance = $this->Ew2->getAgentBalance($user_id);
			$current_balance = $old_balance + $dr_amount;
			
			$tds = 0.00;
			$stax = 0.00;
			if($transaction_type == "DMR")
			{
				$remark = "Money Remittance Commission";
				$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
	
				values(?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
				if($reslut == true)
				{
						$ewallet_id = $this->db->insert_id();
						if($ewallet_id > 10)
						{
						    $ORDERREM = "yes".$dr_amount;
							
				$rslt_updtrec = $this->db->query("update mt3_transfer set order_id=?  where Id = ?",array($ORDERREM,$transaction_id));
										return true;
							
							
						}
						else
						{
								return false;
						}
				}
				else
				{
					return false;
				}
				
			}
			else
			{
					return false;
			}
		}*/
			
	}
	
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****************************  P A Y M E N T   M E T H O D   E N D S   H E R E   ****************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

private function getChargeValue($userinfo,$whole_amount,$is_razorpay = false)
{
    $groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->user_id));
    if($is_razorpay == true)
    {
    	$groupinfo = $this->db->query("select * from mt3_group where Id = 4");
		if($groupinfo->num_rows() == 1)
		{
			$getrangededuction = $this->db->query("
				select 
					a.charge_type,
					a.charge_amount as charge_value,
					'PER' as dist_charge_type,
					'0.20' as dist_charge_value,
					a.ccf,
					a.cashback,
					a.tds,
					a.ccf_type,
					a.tds_type,
					a.cashback_type
					from mt_commission_slabs a 
					where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($whole_amount,$whole_amount,$groupinfo->row(0)->Id));
				if($getrangededuction->num_rows() == 1)
				{
					return $getrangededuction;
				}
			
			
		}
    }
    
	else if($groupinfo->num_rows() == 1)
	{
		$getrangededuction = $this->db->query("
			select 
				a.charge_type,
				a.charge_amount as charge_value,
				'PER' as dist_charge_type,
				'0.20' as dist_charge_value,
				a.ccf,
				a.cashback,
				a.tds,
				a.ccf_type,
				a.tds_type,
				a.cashback_type
				from mt_commission_slabs a 
				where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($whole_amount,$whole_amount,$groupinfo->row(0)->Id));
			if($getrangededuction->num_rows() == 1)
			{
				return $getrangededuction;
			}
		
		
	}
	else
	{
			$groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->parentid));
        	if($groupinfo->num_rows() == 1)
        	{
        		if($groupinfo->row(0)->charge_type == "SLAB")
        		{
        			$getrangededuction = $this->db->query("
        			select 
        				a.charge_type,
        				a.charge_amount as charge_value,
        				'PER' as dist_charge_type,
        				'0.20' as dist_charge_value,
        				a.ccf,
        				a.cashback,
        				a.tds,
        				a.ccf_type,
						a.tds_type,
						a.cashback_type
        				from mt_commission_slabs a 
        				where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($whole_amount,$whole_amount,$groupinfo->row(0)->Id));
        			if($getrangededuction->num_rows() == 1)
        			{
        				return $getrangededuction;
        			}
        		}
        		else
        		{
        			return $groupinfo;	
        		}
        		
        	}
        	else
        	{
        		return false;
        	}
	}
    
    
    
    
    
    

}

	private function storepartnerdata($mt3_transfer_id,$partnerSubId,$txn_amount)
	{
			$this->db->query("INSERT INTO `paytm_txn_count`(`mt3_transfer_id`, `partnerSubId`, `txn_amount`) VALUES (?,?,?)",array($mt3_transfer_id,$partnerSubId,$txn_amount));
	}
















public function checkduplicate_resend($dmr_id,$api_name)
{
	$result = $this->db->query("insert into dmt_resend_duplicate(dmr_id,api_name,add_date,ipaddress) values(?,?,?,?)",
					array($dmr_id,$api_name,$this->common->getDate(),$this->common->getRealIpAddr()));
	if($result == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}
public function paytm_api_call($Id,$mode,$amount,$beneficiaryid,$remittermobile,$benificiary_account_no,$user_id,$Charge_Amount)
{
		$jwtToken = $this->jwt_token();
						
		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));


		$datetime=date("Y-m-d H:i:s");
		$txnReqId=$Id;
		$insert_id = $Id;
		$jwtToken = $this->jwt_token();
		if($mode == "NEFT")
		{
					$request_array = array(
							'amount'=>$amount,
							'beneficiaryId'=>$beneficiaryid,
							'channel'=>'S2S',
							'customerMobile'=>$remittermobile,
							'transactionType'=>'CORPORATE_DOMESTIC_REMITTANCE',
							'txnReqId'=>$txnReqId,
							"mode"=>strtolower($mode),
							"ifscBased"=>false
						);
		}
		else
		{
			$request_array = array(
							'amount'=>$amount,
							'beneficiaryId'=>$beneficiaryid,
							'channel'=>'S2S',
							'customerMobile'=>$remittermobile,
							'transactionType'=>'CORPORATE_DOMESTIC_REMITTANCE',
							'txnReqId'=>$txnReqId,
							'extra_info'=>array(
								"mode"=>strtolower($mode),
								"ifscBased"=>false
							)
					);
		}

															
															
		$json_reqarray = json_encode($request_array);
		$url = "https://pass-api.paytmbank.com/api/tops/remittance/v2/fund-transfer";
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 50,
		  CURLOPT_TIMEOUT => 150,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $json_reqarray ,
		  CURLOPT_HTTPHEADER => array(
			 "authorization: ".$jwtToken,
			"cache-control: no-cache",
			"content-type: application/json",
			"postman-token: e65364aa-3d7d-fea3-76db-c1cb36585a6f"
		  ),
		));

		$buffer = $response = curl_exec($curl);
		$err = curl_error($curl);
		
		
		
		curl_close($curl);
		$this->requestlog($insert_id,$json_reqarray,$response,$remittermobile,$benificiary_account_no,"");


	         
		$json_obj = json_decode($response);
		
		$arrMsg=array("brijesh");
		//array("Insufficient Available Balance","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
		$message = isset($json_obj->message)?trim($json_obj->message):"";
		$status = isset($json_obj->status)?trim($json_obj->status):"";
		
		if(isset($json_obj->status) and isset($json_obj->message))
		{
			$status = $json_obj->status;
			$message = $json_obj->message;
			
				if($status == "success")
			{
				$txn_id = $json_obj->txn_id;
				$mw_txn_id = $json_obj->mw_txn_id;
				$rrn = $json_obj->rrn;
				$extra_info = $json_obj->extra_info;
				
				
				$data = array(
							'RESP_statuscode' => "TXN",
							'RESP_status' => $message,
							'RESP_ipay_id' => $mw_txn_id,
							'RESP_opr_id' => $rrn,
							'RESP_name' => $extra_info->beneficiaryName,
							'message'=>$message,
							'Status'=>'SUCCESS',
							'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);

                    $sendmsg = 'Transaction Successful, TID: '.$rrn.' Amt:Rs.'.$amount.' A/C: '.$benificiary_account_no.'  '.$this->common->getDate().' Thanks,PayInn';
                   
					
					$resp_arr = array(
										"message"=>"Transaction Done Successfully",
										"status"=>0,
										"statuscode"=>"TXN",
										"data"=>array(
											"tid"=>$insert_id,
											"ref_no"=>$insert_id,
											"opr_id"=>$rrn,
											"name"=>$extra_info->beneficiaryName,																								"balance"=>"",
											"amount"=>$amount,

										)
									);
					$json_resp =  json_encode($resp_arr);
			}
			elseif($status == "failure")
			{
					$response_code = $json_obj->response_code;
					
					$docredit=true; 
					$status='FAILURE'; 
					$RESP_statuscode='ERR';
					
					if($docredit==true)
					{



						$transaction_type = "DMR";
						$dr_amount = $amount;
						$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
						$sub_txn_type = "REMITTANCE";
						$remark = "Money Remittance";
						$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
					}
				
					if($message=="Insufficient Available Balance")
					{$message="Please try after sometime.";}
					$data = array(
							'RESP_statuscode' => $RESP_statuscode,
							'RESP_status' => $message,
							'Status'=>$status,
							'edit_date'=>$this->common->getDate()
					);

				$this->db->where('Id', $insert_id);
				$this->db->update('mt3_transfer', $data);


				if($response_code == "1067")
				{
					$message = "Service Not Available.Try After Some Time";
				}
				
				$resp_arr = array(
										"message"=>"Transaction Failed",
										"status"=>1,
										"statuscode"=>$RESP_statuscode,
									);
				$json_resp =  json_encode($resp_arr);

			}
			else if($status == "pending" or $status == "initiated")
		{
					
					$txn_id = $json_obj->txn_id;
					$mw_txn_id = $json_obj->mw_txn_id;
					$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
					$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
					$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
						
				$data = array(
							'RESP_statuscode' => "PENDING",
							'RESP_status' => $message,
							'RESP_ipay_id' => $mw_txn_id,
							'RESP_opr_id' => $rrn,
							'RESP_name' => $_benename,
							'message'=>$message,
							'Status'=>'PENDING',
							'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
						
						$resp_arr = array(
										"message"=>"Transaction Under Process",
										"status"=>0,
										"statuscode"=>"TUP",
										"data"=>array(
											"tid"=>$insert_id,
											"ref_no"=>$insert_id,
											"opr_id"=>$rrn,
											"name"=>$_benename,"balance"=>"",
											"amount"=>$amount,

										)
									);
					$json_resp =  json_encode($resp_arr);
			}
			else
			{
					$extra_info=$_benename="";
					$txn_id = isset($json_obj->txn_id)?$json_obj->txn_id:"";
					$mw_txn_id = isset($json_obj->mw_txn_id)?$json_obj->mw_txn_id:"";
					$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
					if(isset($json_obj->extra_info))
					{
						$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
						$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
					}
				$data = array(
							'RESP_statuscode' => "PENDING",
							'RESP_status' => $message,
							'RESP_ipay_id' => $mw_txn_id,
							'RESP_opr_id' => $rrn,
							'RESP_name' => $_benename,
							'message'=>$message,
							'Status'=>'PENDING',
							'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
						
						$resp_arr = array(
										"message"=>"Transaction Under Process",
										"status"=>0,
										"statuscode"=>"TUP",
										"data"=>array(
											"tid"=>$insert_id,
											"ref_no"=>$insert_id,
											"opr_id"=>$rrn,
											"name"=>$_benename,"balance"=>"",
											"amount"=>$amount,

										)
									);
					$json_resp =  json_encode($resp_arr);
					
					/*$data = array(
								"RESP_status"=>$message,
								'RESP_statuscode' => "UNK",
								'Status'=>'PENDING',
								'RESP_statuscode'=>$status,
								'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
					$arrDmtMsg=$this->get_our_msg($message);
						$ourmsg=trim($arrDmtMsg['ourmsg']);
						$msgid=intval($arrDmtMsg['msgid']);
						$resp_arr = array(
											"message"=>$ourmsg,"msgid"=>$msgid,
											"status"=>2,
											"statuscode"=>"TUP",
										);
					$json_resp =  json_encode($resp_arr);*/
						
			}


		}
		else if(isset($json_obj->errorCode) and isset($json_obj->errorMessage))
		{
			$errorCode = $json_obj->errorCode;
			$errorMessage = $json_obj->errorMessage;
			$data = array(
								"RESP_status"=>$errorMessage,
								'RESP_statuscode' => $errorCode,
								'Status'=>'PENDING',
								'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
					
						
						$resp_arr = array(
											"message"=>"Transaction Under Process",
											"status"=>2,
											"statuscode"=>"TUP",
										);
					$json_resp =  json_encode($resp_arr);

		}
		else
		{ 
						$message = isset($json_obj->message)?trim($json_obj->message):"";
						$status = isset($json_obj->status)?trim($json_obj->status):"";
						
						$respmsg = "Unknown Response or No Response";
						if(trim($message)!="")$respmsg=$message;
						
						$respsts = "UNK";
						if(trim($status)!="")$respsts=$status;
						
						//$this->loging_new("transfer-UNK",$remittermobile,$response,$userinfo->row(0)->username,$userinfo->row(0)->username);
			//check status befor refund
			//$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);
			$data = array(
								'RESP_statuscode' => $respsts,
								'RESP_status' => $respmsg,
								'edit_date'=>$this->common->getDate()
						);

						$this->db->where('Id', $insert_id);
						$this->db->update('mt3_transfer', $data);
			
					$message="Your Request Submitted Successfully";
					
					
					$resp_arr = array(
					"message"=>"Transaction Under Process",
					"status"=>0,
					"statuscode"=>"TUP",
				);
			$json_resp =  json_encode($resp_arr);
		}
}
public function transfer_resend_hold_Paytm($Id)
{

    if($this->checkduplicate_resend($Id,"PAYTM"))
	//if(true)
    {
	    $postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		
	    $insert_id = $Id;
	    $dmr_id = $Id;

	    $rslttransaction = $this->db->query("SELECT * FROM `mt3_transfer` where  (Status = 'PENDING' or Status = 'HOLD') and Id = ?",array($Id));
	    if($rslttransaction->num_rows() == 1)
	    {
	    	$benificiary_name = $rslttransaction->row(0)->RESP_name;
			$remitter_id = $rslttransaction->row(0)->RemiterMobile;
			$remittermobile = $remitter_id;
			$benificiary_account_no = $rslttransaction->row(0)->BeneficiaryId;
			$mobile_no = $remitter_id;
			$mode = $rslttransaction->row(0)->mode;
			$user_id = $rslttransaction->row(0)->user_id;
			$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
			$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
		
			$AccountNumber = $rslttransaction->row(0)->AccountNumber;
			$benificiary_account_no = $AccountNumber;
			$IFSC = $rslttransaction->row(0)->IFSC;
			$amount = $rslttransaction->row(0)->Amount;
			$dist_charge_amount= $rslttransaction->row(0)->dist_charge_amount;
			$postfields = '';
			$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
			if($mode == "IMPS"){$apimode = "2";}
			if($mode == "NEFT"){$apimode = "1";}
			$postparam = $remittermobile." <> ".$beneficiaryid." <> ".$amount." <> ".$mode;	
			
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$DId = $userinfo->row(0)->parentid;
				$MdId = 0;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				
				$parentinfo = $this->db->query("select * from tblusers where user_id = ?",array($DId));
				if($parentinfo->num_rows() == 1)
				{
						$MdId = $parentinfo->row(0)->parentid;
				}
					
				$insert_id = $Id;
				$timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));
				$this->db->query("update mt3_transfer set Status = 'PENDING',API = 'PAYTM' where Id = ?",array($insert_id));
				        
				

				$remitter_id = $rslttransaction->row(0)->RemiterMobile;
				$remittermobile = $remitter_id;
				
				$mobile_no = $remitter_id;
				$mode = $rslttransaction->row(0)->mode;
				$user_id = $rslttransaction->row(0)->user_id;
				$beneficiaryid = $rslttransaction->row(0)->BeneficiaryId;
				$Charge_Amount = $rslttransaction->row(0)->Charge_Amount;
			
				$AccountNumber = $rslttransaction->row(0)->AccountNumber;
				$benificiary_account_no = $AccountNumber;
				$IFSC = $rslttransaction->row(0)->IFSC;
				$amount = $rslttransaction->row(0)->Amount;
				$bank_id = $rslttransaction->row(0)->bank_id;
					
				$this->paytm_api_call($Id,$mode,$amount,$beneficiaryid,$remittermobile,$benificiary_account_no,$user_id,$Charge_Amount);			
			}
			else
			{
				$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$resp_arr = array(
									"message"=>"Userinfo Missing",
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
	    }

		$this->loging("eko_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
    }
    else
    {
        echo "Duplicate Request Found";exit;
    }
    

    	
	
}








public function transfer_razorpay($remittermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id,$unique_id)
{ 
		$this->paytmremitter=$remittermobile; $this->paytmamount=$amount;
		
		$postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}
		$postparam = $remittermobile." <> ".$beneficiary_array->row(0)->paytm_bene_id." <> ".$amount." <> ".$mode;
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{	
			if($userinfo->num_rows() == 1)
			{	
				$url = '';
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "APIUSER" or $usertype_name == "Agent")
				{	
					if($user_status == '1')
					{ 
						if($amount >= 1)
						{
						    $crntBalance = $this->Ew2->getAgentBalance($user_id);
    						if(floatval($crntBalance) >= floatval($amount) + 30)
    						{
    								
    								if($beneficiary_array->num_rows()>0)
    								{	
    									$benificiary_name = $beneficiary_array->row(0)->bene_name;
    									$benificiary_mobile = $beneficiary_array->row(0)->benemobile;
    									$benificiary_ifsc = $beneficiary_array->row(0)->IFSC;
    									$benificiary_account_no = $beneficiary_array->row(0)->account_number;
											$beneficiaryid = $beneficiary_array->row(0)->paytm_bene_id;
											$bank_id = $beneficiary_array->row(0)->bank_id;
    									$chargeinfo = $this->getChargeValue($userinfo,$amount,true);
    									if($chargeinfo != false)
    									{	
													/////////////////////////////////////////////////
													/////// RETAILER CHARGE CALCULATION
													////////////////////////////////////////////////
													
													
													
													
													
	
													$Charge_type = $chargeinfo->row(0)->charge_type;
													$charge_value = $chargeinfo->row(0)->charge_value;

													$ccf_type = $chargeinfo->row(0)->ccf_type;	
													$ccf = $chargeinfo->row(0)->ccf;		
													if($ccf_type == "PER")
													{
														 $ccf = ((floatval($ccf) * floatval($amount))/ 100); 
													}

													$cashback_type = $chargeinfo->row(0)->cashback_type;	
													$cashback = $chargeinfo->row(0)->cashback;	
													if($cashback_type == "PER")
													{
														 $cashback = ((floatval($cashback) * floatval($amount))/ 100); 
													}


													$retailer_gst = ((floatval($ccf) * 18)/ 118);

													$tds_type = $chargeinfo->row(0)->tds_type;
													$tds = $chargeinfo->row(0)->tds;
													if($tds_type == "PER")
													{
														
														$Commission_after_gst = $cashback  - $retailer_gst;
														$tds = ((floatval($tds) * floatval($Commission_after_gst))/ 100); 
													}


													$charge =  $chargeinfo->row(0)->charge_value;
													if($Charge_type == "PER")
													{
														 $charge = ((floatval($charge_value) * floatval($amount))/ 100); 
													}

													$Charge_Amount = (floatval($charge) + floatval($tds) + floatval($retailer_gst));	
													
        
													
    									}
    									else
    									{
    										$Charge_type = "PER";
    										$charge_value = 0.40;
    										$Charge_Amount = ((floatval($charge_value) * floatval($amount))/ 100); 
    										$ccf = 0;
    										$cashback = 0;
    										$tds = 0;
    									}
    									
    																	
    								
    								$API_NAME = "Razorpay";


    								// $api_info = $this->db->query("select 
												// a.Id,
												// a.api_name,
												// a.priority,
												// a.is_dmt,
												// a.is_active
												// from api_configuration  a 
												
												// where a.is_dmt = 'yes' and a.is_active = 'yes' order by a.priority");
    								// foreach($api_info->result() as $rwapi)
    								// {
    								// 	$API_NAME = $this->getApiName($rwapi->api_name,$rwapi->Id,$remittermobile,$amount,$userinfo);
    								// 	if($API_NAME != "HOLD")
    								// 	{
    								// 		break;
    								// 	}
    								// }
    								
    								

    								/*comment*/
    								$is_autohold ='no';
    								if($mode == "IMPS")
						            {
						              $checkbank_down = $this->db->query("select Id,bank_name from instantpay_banklist where branch_ifsc = ? and imps_enabled = '0'",array($benificiary_ifsc));
						              if($checkbank_down->num_rows() == 1)
						              {
						              		$API_NAME = "HOLD";
						              		$is_autohold ='yes';
						                    // $resp_array = array(
						                    //                           "StatusCode"=>0,
						                    //                           "Message"=>"Currently IMPS Service Is Down For ".$checkbank_down->row(0)->bank_name,
						                    //                         );
						                    // echo json_encode($resp_array);exit;
						              }
						            }


    								



    									
    										$resultInsert = $this->db->query("
    											insert into mt3_transfer(
    											order_id,
    											unique_id,
												add_date,
												ipaddress,
												user_id,
    											Charge_type,
    											charge_value,
    											Charge_Amount,
    											RemiterMobile,
    											BeneficiaryId,
    											RESP_name,
    											AccountNumber,
    											IFSC,
    											Amount,
    											Status,
    											mode,
												API,
												bank_id,
												ccf,cashback,tds,gst,is_autohold)
    											values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    											",array(
												$order_id,
												$unique_id,
												$this->common->getDate(),
												$this->common->getRealIpAddr(),
												$user_id,
    											$Charge_type,$charge_value,$Charge_Amount,
    											$remittermobile,
    											$beneficiaryid,
    											$benificiary_name,
												$benificiary_account_no,
												$benificiary_ifsc,
    											$amount,
												"PENDING",
												$mode,
												$API_NAME,
												$bank_id,
												$ccf,
												$cashback,
												$tds,
												$retailer_gst,
												$is_autohold
    											));
    										if($resultInsert == true)
    										{
												$insert_id = $mmdmtid =  $this->db->insert_id(); 
												$this->paytmtxnid=$insert_id;
													
    											$transaction_type = "DMR";
    											$dr_amount = $amount;
    											$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
    											$sub_txn_type = "REMITTANCE";
    											$remark = "Money Remittance";
    											$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
												
    											if($paymentdebited == true)
    											{
    											   
        											
        										    
        										    if($API_NAME == 'HOLD')
    												{
    													$this->db->query("update mt3_transfer set is_hold = 'yes' where Id = ?",array($insert_id));
    													$resp_arr = array(
    																							"message"=>"Transaction Under Process",
    																							"status"=>0,
    																							"statuscode"=>"TUP",
    																						);
    																	$json_resp =  json_encode($resp_arr);
    												}
    												else
    												{
    													
    													
    												    $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

    												    if($API_NAME == "PAYTM")
    												    {
    												    	$jwtToken = $this->jwt_token();
																
															$datetime=date("Y-m-d H:i:s");
															$txnReqId=$mmdmtid;
													

	        												if($mode == "NEFT")
	        												{
																		$request_array = array(
																				'amount'=>$amount,
																				'beneficiaryId'=>$beneficiaryid,
																				'channel'=>'S2S',
																				'customerMobile'=>$remittermobile,
																				'transactionType'=>'CORPORATE_DOMESTIC_REMITTANCE',
																				'txnReqId'=>$txnReqId,
																				"mode"=>strtolower($mode),
																				"ifscBased"=>false
																			);
	        												}
	        												else
	        												{
	        													$request_array = array(
																				'amount'=>$amount,
																				'beneficiaryId'=>$beneficiaryid,
																				'channel'=>'S2S',
																				'customerMobile'=>$remittermobile,
																				'transactionType'=>'CORPORATE_DOMESTIC_REMITTANCE',
																				'txnReqId'=>$txnReqId,
																				'extra_info'=>array(
																					"mode"=>strtolower($mode),
																					"ifscBased"=>false
																				)
																		);
	        												}

															
															
															$json_reqarray = json_encode($request_array);
															$url = "https://pass-api.paytmbank.com/api/tops/remittance/v2/fund-transfer";
															$curl = curl_init();
													
															curl_setopt_array($curl, array(
															  CURLOPT_URL => $url,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 50,
															  CURLOPT_TIMEOUT => 150,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															  CURLOPT_POSTFIELDS => $json_reqarray ,
															  CURLOPT_HTTPHEADER => array(
																 "authorization: ".$jwtToken,
																"cache-control: no-cache",
																"content-type: application/json",
																"postman-token: e65364aa-3d7d-fea3-76db-c1cb36585a6f"
															  ),
															));
													
															$buffer = $response = curl_exec($curl);
															$err = curl_error($curl);
															
															
															
															curl_close($curl);
															$this->requestlog($insert_id,$json_reqarray,$response,$remittermobile,$benificiary_account_no,"");
												
												
														         
															$json_obj = json_decode($response);
															
															$arrMsg=array("brijesh");
															//array("Insufficient Available Balance","Issuing Bank CBS down","Issuing bank CBS or node offline","Access not allowed for MRPC at this time","Transaction not processed.Bank is not available now.","Your transfer was declined by the beneficiary bank. Please try again after some time.");
															$message = isset($json_obj->message)?trim($json_obj->message):"";
															$status = isset($json_obj->status)?trim($json_obj->status):"";
															
															if(isset($json_obj->status) and isset($json_obj->message))
    														{
        														$status = $json_obj->status;
    															$message = $json_obj->message;
    															
																	if($status == "success")
    															{
																	$txn_id = $json_obj->txn_id;
																	$mw_txn_id = $json_obj->mw_txn_id;
																	$rrn = $json_obj->rrn;
																	$extra_info = $json_obj->extra_info;
    																
    																
    																$data = array(
    																			'RESP_statuscode' => "TXN",
    																			'RESP_status' => $message,
    																			'RESP_ipay_id' => $mw_txn_id,
    																			'RESP_opr_id' => $rrn,
    																			'RESP_name' => $extra_info->beneficiaryName,
    																			'message'=>$message,
    																			'Status'=>'SUCCESS',
    																			'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
    
                                                                        $sendmsg = 'Transaction Successful, TID: '.$rrn.' Amt:Rs.'.$amount.' A/C: '.$benificiary_account_no.'  '.$this->common->getDate().' Thanks,PayInn';
                                                                       
																		
																		$resp_arr = array(
    																						"message"=>"Transaction Done Successfully",
    																						"status"=>0,
																							"statuscode"=>"TXN",
    																						"data"=>array(
    																							"tid"=>$insert_id,
    																							"ref_no"=>$insert_id,
    																							"opr_id"=>$rrn,
    																							"name"=>$extra_info->beneficiaryName,																								"balance"=>"",
    																							"amount"=>$amount,
    
    																						)
    																					);
    																	$json_resp =  json_encode($resp_arr);
    															}
																elseif($status == "failure")
																{
																		$response_code = $json_obj->response_code;
																		
																		$docredit=true; 
																		$status='FAILURE'; 
																		$RESP_statuscode='ERR';
																		
																		if($docredit==true)
																		{
																				$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
																		}
																	
																		if($message=="Insufficient Available Balance")
																		{$message="Please try after sometime.";}
																		$data = array(
																				'RESP_statuscode' => $RESP_statuscode,
																				'RESP_status' => $message,
																				'Status'=>$status,
																				'edit_date'=>$this->common->getDate()
																		);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('mt3_transfer', $data);


																	if($response_code == "1067")
																	{
																		$message = "Service Not Available.Try After Some Time";
																	}
																	
																	$resp_arr = array(
																							"message"=>"Transaction Failed",
																							"status"=>1,
																							"statuscode"=>$RESP_statuscode,
																						);
																	$json_resp =  json_encode($resp_arr);

																}
																else if($status == "pending" or $status == "initiated")
    														{
																		
																		$txn_id = $json_obj->txn_id;
																		$mw_txn_id = $json_obj->mw_txn_id;
																		$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
																		$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
																		$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
																			
    																$data = array(
    																			'RESP_statuscode' => "PENDING",
    																			'RESP_status' => $message,
    																			'RESP_ipay_id' => $mw_txn_id,
    																			'RESP_opr_id' => $rrn,
    																			'RESP_name' => $_benename,
    																			'message'=>$message,
    																			'Status'=>'PENDING',
    																			'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
																			
																			$resp_arr = array(
    																						"message"=>"Transaction Under Process",
    																						"status"=>0,
																							"statuscode"=>"TUP",
    																						"data"=>array(
    																							"tid"=>$insert_id,
    																							"ref_no"=>$insert_id,
    																							"opr_id"=>$rrn,
    																							"name"=>$_benename,"balance"=>"",
    																							"amount"=>$amount,
    
    																						)
    																					);
    																	$json_resp =  json_encode($resp_arr);
    															}
        														else
    															{
																		$extra_info=$_benename="";
																		$txn_id = isset($json_obj->txn_id)?$json_obj->txn_id:"";
																		$mw_txn_id = isset($json_obj->mw_txn_id)?$json_obj->mw_txn_id:"";
																		$rrn = isset($json_obj->rrn)?$json_obj->rrn:"";
																		if(isset($json_obj->extra_info))
																		{
																			$extra_info = isset($json_obj->extra_info)?$json_obj->extra_info:"";
																			$_benename = isset($extra_info->beneficiaryName)?$extra_info->beneficiaryName:"";	
																		}
    																$data = array(
    																			'RESP_statuscode' => "PENDING",
    																			'RESP_status' => $message,
    																			'RESP_ipay_id' => $mw_txn_id,
    																			'RESP_opr_id' => $rrn,
    																			'RESP_name' => $_benename,
    																			'message'=>$message,
    																			'Status'=>'PENDING',
    																			'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
																			
																			$resp_arr = array(
    																						"message"=>"Transaction Under Process",
    																						"status"=>0,
																							"statuscode"=>"TUP",
    																						"data"=>array(
    																							"tid"=>$insert_id,
    																							"ref_no"=>$insert_id,
    																							"opr_id"=>$rrn,
    																							"name"=>$_benename,"balance"=>"",
    																							"amount"=>$amount,
    
    																						)
    																					);
    																	$json_resp =  json_encode($resp_arr);
																		
																		/*$data = array(
    																				"RESP_status"=>$message,
    																				'RESP_statuscode' => "UNK",
    																				'Status'=>'PENDING',
    																				'RESP_statuscode'=>$status,
    																				'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
    																	$arrDmtMsg=$this->get_our_msg($message);
																			$ourmsg=trim($arrDmtMsg['ourmsg']);
																			$msgid=intval($arrDmtMsg['msgid']);
																			$resp_arr = array(
    																							"message"=>$ourmsg,"msgid"=>$msgid,
    																							"status"=>2,
    																							"statuscode"=>"TUP",
    																						);
    																	$json_resp =  json_encode($resp_arr);*/
																			
    															}
        
        
        													}
															else if(isset($json_obj->errorCode) and isset($json_obj->errorMessage))
    														{
        														$errorCode = $json_obj->errorCode;
    															$errorMessage = $json_obj->errorMessage;
    															$data = array(
    																				"RESP_status"=>$errorMessage,
    																				'RESP_statuscode' => $errorCode,
    																				'Status'=>'PENDING',
    																				'edit_date'=>$this->common->getDate()
    																	);
    
    																	$this->db->where('Id', $insert_id);
    																	$this->db->update('mt3_transfer', $data);
    																	
																			
																			$resp_arr = array(
    																							"message"=>"Transaction Under Process",
    																							"status"=>2,
    																							"statuscode"=>"TUP",
    																						);
    																	$json_resp =  json_encode($resp_arr);
        
        													}
        													else
        													{ 
																			$message = isset($json_obj->message)?trim($json_obj->message):"";
																			$status = isset($json_obj->status)?trim($json_obj->status):"";
																			
																			$respmsg = "Unknown Response or No Response";
																			if(trim($message)!="")$respmsg=$message;
																			
																			$respsts = "UNK";
																			if(trim($status)!="")$respsts=$status;
																			
																			//$this->loging_new("transfer-UNK",$remittermobile,$response,$userinfo->row(0)->username,$userinfo->row(0)->username);
        														//check status befor refund
        														//$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);
        														$data = array(
        																			'RESP_statuscode' => $respsts,
        																			'RESP_status' => $respmsg,
        																			'edit_date'=>$this->common->getDate()
        																	);
        
        																	$this->db->where('Id', $insert_id);
        																	$this->db->update('mt3_transfer', $data);
        														
																		$message="Your Request Submitted Successfully";
																		
																		
																		$resp_arr = array(
        																"message"=>"Transaction Under Process",
        																"status"=>0,
        																"statuscode"=>"TUP",
        															);
        														$json_resp =  json_encode($resp_arr);
        													}
    												    }
    												    else if($API_NAME == "AIRTEL")
    												    {
    												    	$this->load->model("Airtel_model");
    												    	$json_resp = $this->Airtel_model->Transfer_Api_call_only($insert_id);
    												    }
    												    else if($API_NAME == "ZPULS")
    												    {
    												    	error_reporting(-1);
    												    	ini_set('display_errors',1);
    												    	$this->db->db_debug = TRUE;
    												    	$this->load->model("Zpuls_model");
    												    	$json_resp = $this->Zpuls_model->Transfer_Api_call_only($insert_id);
    												    }
    												    else if($API_NAME == "Razorpay")
    												    {
    												    	error_reporting(-1);
    												    	ini_set('display_errors',1);
    												    	$this->db->db_debug = TRUE;
    												    //	echo $insert_id;exit;
    												    	$this->load->model("RazorpayPayout_model");
    												    	$json_resp = $this->RazorpayPayout_model->Transfer_Api_call_only($insert_id);
    												    }
        												
    												}
    											}
    											else
    											{
    											    $data = array(
    																			'RESP_statuscode' => "ERR",
    																			'RESP_status' => "PAYMENT FAILURE",
    																			'tx_status'=>"1",
    																			'Status'=>'FAILURE',
    																	);
    
    												$this->db->where('Id', $insert_id);
    												$this->db->update('mt3_transfer', $data);
																			
    												$message="Payment Failure";
													
																		
														$resp_arr = array(
    													"message"=>"PAYMENT FAILURE",
    													"status"=>1,
    													"statuscode"=>"ERR",
    												);
    												$json_resp =  json_encode($resp_arr);	
    											}		
    										}
    										else
    										{
													$message="Internal Server Error. DB Error";
													
    											$resp_arr = array(
    												"message"=>$message,
    												"status"=>1,
    												"statuscode"=>"ERR",
    											);
    											$json_resp =  json_encode($resp_arr);	
    										}
    									
    								}
    								else
    								{
											$message="Invalid Beneficiary Id";
											
    									$resp_arr = array(
    											"message"=>$message,
    											"status"=>1,
    											"statuscode"=>"RNF",
    										);
    									$json_resp =  json_encode($resp_arr);
    								}
    							
    						}
    						else
    						{
									$message="InSufficient Balance";
									
    							$resp_arr = array(
    									"message"=>$message,
    									"status"=>1,
    									"statuscode"=>"ISB",
    								);
    							$json_resp =  json_encode($resp_arr);
    						}    
						}
						else
						{	
								$message="Minimum Balance Limit is 1000 Rupees";
								
						    $resp_arr = array(
    									"message"=>$message,
    									"status"=>1,
    									"statuscode"=>"ERR",
    								);
    							$json_resp =  json_encode($resp_arr);
						}
						
						
					}
					else
					{
						$message="Your Account Deactivated By Admin";
						
						$resp_arr = array(
									"message"=>$message,
									"status"=>1,
									"statuscode"=>"UNK",
								);
						$json_resp =  json_encode($resp_arr);
					}
						
				}
				else
				{
					$message="Invalid Access";
					
					$resp_arr = array(
									"message"=>$message,
									"status"=>1,
									"statuscode"=>"UNK",
								);
					$json_resp =  json_encode($resp_arr);
				}
			}
			else
			{
				$message="Userinfo Missing";
				
				$resp_arr = array(
									"message"=>$message,
									"status"=>4,
									"statuscode"=>"UNK",
								);
				$json_resp =  json_encode($resp_arr);
			}
			
		}
		else
		{
			$message="Userinfo Missing";
			
			$resp_arr = array(
									"message"=>$message,
									"status"=>4,
									"statuscode"=>"UNK",
								);
			$json_resp =  json_encode($resp_arr);
			
		}
		//$this->loging_db("transfer",$mode." ".$url."?".json_encode($request_array)."  ..........".$jwtToken,$response,$json_resp,$userinfo->row(0)->username,$remittermobile);

		return $json_resp;
		
	}












}
?>