<?php

class Bankit extends CI_Model 
{ 
   
	function _construct()
	{
		  parent::_construct();
		
//        $this->load->model("");
        header('Content-Type: application/json');
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
	
	
	public function getBalance()
	{
		

		$curl = curl_init();
		curl_setopt_array($curl, array(
			  CURLOPT_PORT => "8443",
			  CURLOPT_URL => "https://services.bankit.in:8443/DMRV1.1/generic/balance",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
				"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			if ($err) 
			{
			  echo "cURL Error #:" . $err;
			} 
			else 
			{
			  echo $response;
			}
	}
	public function BankList()
	{


		$curl = curl_init();
		curl_setopt_array($curl, array(
			  CURLOPT_PORT => "8443",
			  CURLOPT_URL => "https://services.bankit.in:8443/DMRV1.1/generic/bankList",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_HTTPHEADER => array(
				"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
			  ),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			
			curl_close($curl);
			
			$json_obj = json_decode($response);
			if(isset($json_obj->errorMsg) and isset($json_obj->errorCode))
			{
				$errorMsg = $json_obj->errorMsg;
				$errorCode = $json_obj->errorCode;
				if($errorMsg  == "SUCCESS")
				{
					$data = $json_obj->data;
					$bankList = $data->bankList;
					foreach($bankList as $bankrw)
					{
						$bankCode = $bankrw->bankCode;
						$bankName = $bankrw->bankName;
						$channelsSupported = $bankrw->channelsSupported;
						$accVerAvailabe = $bankrw->accVerAvailabe;
						$ifsc = $bankrw->ifsc;
						$ifscStatus = $bankrw->ifscStatus;
						$this->db->query("insert into bankit_banklist(Id,bankName,channelsSupported,accVerAvailabe,ifsc,ifscStatus) values(?,?,?,?,?,?)",array($bankCode,$bankName,$channelsSupported,$accVerAvailabe,$ifsc,$ifscStatus));
					}
				}
			}
			
	}
	
	public function remitter_details_limit($mobile_no,$firstName,$lastName,$userinfo) // done
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

							$remitterinfo = $this->db->query("SELECT * FROM `mt3_remitter_registration` where mobile = ? and BANKIT = 'yes'",array($mobile_no));
							if($remitterinfo->num_rows() == 0)
							{
								$this->remitter_registration_auto($mobile_no,$firstName,$lastName,$userinfo) ;
							}

							$reqarr = array(				   				   
								   "agentCode"       => 1,
								   "customerId"      => $mobile_no
								   );
							$req = json_encode($reqarr);
							//$otprsp = $this->remitter_registration_getotp($mobile_no,$userinfo,"beneficiaryOtp");
							//echo $otprsp;exit;
							$url="https://services.bankit.in:8443/DMRV1.1/customer/fetch";
							$curl = curl_init();
							curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8443",
								  CURLOPT_URL => $url,
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => $req,
								  CURLOPT_HTTPHEADER => array(
								  "Content-Type: application/json",
									"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
								  ),
								));
								
							$response = curl_exec($curl);
							$err = curl_error($curl);
							curl_close($curl);
							/*
{"errorMsg":"SUCCESS","errorCode":"00","data":{"customerId":"8238232303","name":"Ravikant","kycstatus":0,"walletbal":24773.00,"dateOfBirth":"1997-09-26"}}
							*/
							$json_resp = json_decode($response);
					
							
							if(isset($json_resp->errorMsg) and isset($json_resp->errorCode))
							{
									$errorMsg = trim((string)$json_resp->errorMsg);
									$errorCode = trim((string)$json_resp->errorCode);
								
									if($errorMsg == "SUCCESS" and  $errorCode == "00" )
									{

										$limit = trim((string)$json_resp->data->walletbal);
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
				if($usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						
							$url = "https://pass-api.paytmbank.com/api/tops/remittance/v1/user/pre-validate?customerMobile=".$mobile_no;
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
							$json_resp = json_decode($response);
						
						/*
						
						{"status":"success","response_code":1032}
						
						 {"STATUS":1,"MESSAGE":"Sender detail retrieved successfully!","DATA":{"mobileno":"9924160199","senderpin":"123456","name":"KAMLESH","lastname":"SONI","kycflag":"PENDINGKYC","address":"ahmedabad","city":"Ahmedabad","state":"Gujarat","pincode":"380001","impslimit":25000.0,"neftlimit":25000.0}}
						*/
						
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
											"firstName"=>$firstName,
											"lastName"=>$lastName,
											"customerMobile"=>$customerMobile,
											"limitLeft"=>$limitLeft,
										);
										$resp_arr = array(
																"message"=>$status,
																"status"=>0,
																"statuscode"=>"TXN",
																"data"=>$temparray,
															);
										$json_resp =  json_encode($resp_arr);
									}
									
									else
									{
										$resp_arr = array(
																"message"=>$status,
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
		$this->loging("paytm_remitter_details",$url,$response,$json_resp,$userinfo->row(0)->mobile_no);
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
				if($usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						$reqarr = array(				   				   
								   "agentCode"       => 1,
								   "customerId"      => $mobile_no,
								   );
							$req = json_encode($reqarr);
							//$otprsp = $this->remitter_registration_getotp($mobile_no,$userinfo,"beneficiaryOtp");
							//echo $otprsp;exit;
							$url="https://services.bankit.in:8443/DMRV1.1/recipient/fetchAll";
							$curl = curl_init();
							curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8443",
								  CURLOPT_URL => $url,
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => $req,
								  CURLOPT_HTTPHEADER => array(
								  "Content-Type: application/json",
									"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
								  ),
								));
								
							$response = curl_exec($curl);
							$err = curl_error($curl);
							curl_close($curl);
							echo $response;exit;
						
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
										$bankName = "";
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
	
	
	
	public function remitter_registration_auto($mobile_no,$name,$lname,$userinfo) //bankit customer reg
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
				
				if($usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
					
						$rsltcheck = $this->db->query("select Id from mt3_remitter_registration where mobile = ?",array($mobile_no));
						if($rsltcheck->num_rows() == 0)
						{
							$this->db->query("insert into mt3_remitter_registration(user_id,add_date,ipaddress,mobile,name,lastname,pincode) values(?,?,?,?,?,?,?)",array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$name,$lname,$pincode));
							$insert_id = $this->db->insert_id();
						}
						else
						{
							$insert_id = $rsltcheck->row(0)->Id;
						}
						$insert_id = $this->db->insert_id();
						$reqarr = array(				   				   
									   "agentCode"       => 1,
									   "customerId"      => $mobile_no,
									   "name"            =>$name,
									   "address"		 =>"Rajkot",
									   "dateOfBirth"	 =>"1997-09-26",
									   );
						$req = json_encode($reqarr);
						$url="https://services.bankit.in:8443/DMRV1.1/customer/create";
						$curl = curl_init();
						curl_setopt_array($curl, array(
							  CURLOPT_PORT => "8443",
							  CURLOPT_URL => $url,
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 120,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "POST",
			  				  CURLOPT_POSTFIELDS => $req,
							  CURLOPT_HTTPHEADER => array(
   							  "Content-Type: application/json",
								"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
							  ),
							));
							
						$response = curl_exec($curl);
						$err = curl_error($curl);
						curl_close($curl);
						/*
						{"errorMsg":"SUCCESS","errorCode":"00","data":{"customerId":"8238232303"}}

						{"errorMsg":"Customer Id is already present.","errorCode":"V0003","data":{}}
						*/
						$json_resp = json_decode($response);

						if(isset($json_resp->errorMsg) and isset($json_resp->errorCode))
						{
							// user not exist
							// redirect to registration form
							$errorCode = trim($json_resp->errorCode);
							$errorMsg = trim($json_resp->errorMsg);
							if($errorMsg == "SUCCESS")
							{
								
								$this->db->query("update mt3_remitter_registration set BANKIT = 'yes' where mobile = ?",array($mobile_no));
								$resp_arr = array(
												"message"=>$errorMsg,
												"status"=>0,
												"statuscode"=>"TXN",
												"remitter_id"=>$mobile_no
											);
								$json_resp =  json_encode($resp_arr);		
							}
							else if($errorCode == "V0003")
							{
								
								$this->db->query("update mt3_remitter_registration set BANKIT = 'yes' where mobile = ?",array($mobile_no));
								$resp_arr = array(
												"message"=>$errorMsg,
												"status"=>0,
												"statuscode"=>"TXN",
												"remitter_id"=>$mobile_no
											);
								$json_resp =  json_encode($resp_arr);		
							}
							else
							{
								$resp_arr = array(
												"message"=>$errorMsg,
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
		
		$this->loging("bankit_customer_registration",$url."?".$req,$response,$json_resp,$userinfo->row(0)->username,0,"BANKIT_SENDER_REG");
		return $json_resp;
		
	}
	

	public function add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$bank,$userinfo)//bankit add bene
	{
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   $bankinfo = $this->db->query("SELECT bankit_id FROM `dezire_banklist` where Id = ? and bankit_id > 0",array($bank));
			   if($bankinfo->num_rows() == 1)
			   {
			   	
					$user_id = $userinfo->row(0)->user_id;
					$usertype_name = $userinfo->row(0)->usertype_name;
					$user_status = $userinfo->row(0)->status;
					if($usertype_name == "APIUSER")
					{
						if($user_status == '1')
						{
							
							$checkbeneexist = $this->db->query("select * from beneficiaries where sender_mobile = ? and account_number = ? and IFSC = ? order by Id desc limit 1",array($mobile_no,$acc_no,$ifsc));
							if($checkbeneexist->num_rows() ==  1)
							{
								$is_bankit = $checkbeneexist->row(0)->is_bankit;
								$Id = $checkbeneexist->row(0)->Id;
							
								if($is_bankit == "yes")
								{
									$resp_arr = array(
															"message"=>"Beneficiary Already Registered",
															"status"=>1,
															"statuscode"=>"ERR",
														);
									$json_resp =  json_encode($resp_arr);
									return $json_resp;
									
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
												bene_name,account_number,IFSC,benemobile,
												sender_mobile,is_verified,paytm_bene_id,is_paytm,bank_name,dezire_bank_id
												) values(?,?,?,?,?,?,?,?,?,?)",
												array($bene_name,$acc_no,$ifsc,0,$mobile_no,false,"",'no',"",$bank) );
								if($insertrslt == true)		
								{
									$insert_id = $this->db->insert_id();
								}
							}
							
							
							
							$reqarr = array(				   				   
								   "agentCode"       => 1,
								   "bankName"        => $bankinfo->row(0)->bankit_id,
								   "customerId"      => $mobile_no,
								   "accountNo"       => $acc_no,
								   "ifsc"            => $ifsc,
								   "mobileNo"        => $mobile_no,
								   "recipientName"    => $bene_name
								   );
							$req = json_encode($reqarr);
							//$otprsp = $this->remitter_registration_getotp($mobile_no,$userinfo,"beneficiaryOtp");
							//echo $otprsp;exit;
							$url="https://services.bankit.in:8443/DMRV1.1/recipient/add";
							$curl = curl_init();
							curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8443",
								  CURLOPT_URL => $url,
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => $req,
								  CURLOPT_HTTPHEADER => array(
								  "Content-Type: application/json",
									"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
								  ),
								));
								
							$response = curl_exec($curl);
							$err = curl_error($curl);
							curl_close($curl);
							/*
							
							
{
"errorMsg":"Success",
"errorCode":"00",
"data":
	{
	"customerId":"8000012334",
	"recipientId":"AES_21110679",
	"name":"Nirmal",
	"kycstatus":0,
	"walletbal":25000.0000,
	"dateOfBirth":"1997-09-26",
	"recipientName":"CHAMPION SOFTWARE TE",
	"mobileNo":"8000012334"
	}
}
							
							
							{"errorMsg":"Recipient Id is already present.","errorCode":"V0006","data":{"recipientId":"AES_21110678"}}
							
							
							{"errorMsg":"Customer Id is not Registered with us.","errorCode":"V0002","data":{}}
							*/
							$json_resp = json_decode($response);
							if(isset($json_resp->errorMsg) and isset($json_resp->errorCode))
							{
								$errorMsg = trim($json_resp->errorMsg);
								$errorCode = trim($json_resp->errorCode);
								if($errorCode == "00")
								{
									$data = $json_resp->data;
									$recipient_id = $data->recipientId;
									
									$this->db->query("update beneficiaries set 
									is_bankit = 'yes',
									bankit_id=?
									where Id = ?",array($recipient_id,intval($insert_id)));
										$resp_arr = array(
																"message"=>$errorMsg,
																"status"=>0,
																"statuscode"=>"TXN",
																"data"=>$insert_id,
															);
										$json_resp =  json_encode($resp_arr);
									}
								else if($errorCode == "V0006")
								{
									$data = $json_resp->data;
									$recipient_id = $data->recipientId;//recipientId
									
									$this->db->query("update beneficiaries set 
									is_bankit = 'yes',
									bankit_id=?
									where Id = ?",array($recipient_id,intval($insert_id)));
$tempstr = "update beneficiaries set 
									is_bankit = 'yes',
									bankit_id=".$recipient_id."
									where Id = ".$insert_id;
$this->loging("BANKIT","",$tempstr,"",$userinfo->row(0)->username,0,"BANKIT_BENE_REG");

										$resp_arr = array(
																"message"=>$errorMsg,
																"status"=>0,
																"statuscode"=>"TXN",
																"data"=>$insert_id,
															);
										$json_resp =  json_encode($resp_arr);
									}
								else
								{
									
										$resp_arr = array(
																"message"=>$errorMsg,
																"status"=>1,
																"statuscode"=>"ERR",
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
		$this->bankitlog($url."?".$req,$response,"BANKIT_BENE_REG",$mobile_no,$acc_no,$ifsc);
		//$this->loging("Shootcase_set_beneficiary",$url."?".$req,$response,$json_resp,$userinfo->row(0)->username,0,"BANKIT_BENE_REG");
		return $json_resp;
		
	}
	
	
	public function verify_bene($mobile_no,$acc_no,$ifsc,$userinfo)
	{
	$req= '';
	$response ='';
	$insert_id = 0;
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
						
						$accval_resultcheck = $this->db->query("SELECT RESP_benename FROM `mt3_account_validate` where account_no = ? and remitter_mobile = ? and user_id = ? and status = 'SUCCESS' and API = 'BANKIT' order by Id desc limit 1",
						array($acc_no,$mobile_no,$user_id));
						if($accval_resultcheck->num_rows() == 1)
						{
						    $resp_arr = array(
													"message"=>"Beneficiary Already Validated ".$accval_resultcheck->row(0)->RESP_benename,
													"status"=>1,
													"statuscode"=>"ERR",
													"recipient_name"=>$accval_resultcheck->row(0)->RESP_benename
												);
							$json_resp =  json_encode($resp_arr); 

						}
						else
						{
						    $crntBalance = $this->Common_methods->getAgentBalance($user_id);

    						if(floatval($crntBalance) < 3)
    						{
    							$resp_arr = array(
    													"message"=>"InSufficient Balance",
    													"status"=>1,
    													"statuscode"=>"ISB",
    												);
    							$json_resp =  json_encode($resp_arr);
    							echo $json_resp;exit;
    						}
    						$rsltinsert = $this->db->query("insert into mt3_account_validate(user_id,add_date,edit_date,ipaddress,remitter_id,remitter_mobile,account_no,IFSC,status,API) values(?,?,?,?,?,?,?,?,?,?)",array(
    							$user_id,$this->common->getDate(),$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$mobile_no,$acc_no,$ifsc,"PENDING","BANKIT"
    						));
    						if($rsltinsert == true)
    						{
    							$insert_id = $this->db->insert_id();
    							$transaction_type = "DMR";
    							$sub_txn_type = "Account_Validation";
    							$charge_amount = 3.00;
    							$Description = "Valid.Charge : ".$acc_no;
    							$remark = $mobile_no."  Acc NO :".$acc_no;
    							$debitpayment = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
    
    							if($debitpayment == true)
    							{
    								$unique_id = $insert_id;
									$ddbit_amount_a = 1;
									
									$reqarr = array(				   				   
										   "agentCode"       => 10076,				   				 
										   "customerId"      => $mobile_no,
										   "amount"          =>'1.0',				   
										   "clientRefId"	 =>	"10076".$insert_id,
										   "udf1"	         =>$acc_no,
										   "udf2"            =>$ifsc
										   );
									$req = json_encode($reqarr);
									$url="https://services.bankit.in:8443/DMRV1.1/transact/IMPS/accountverification";
									$curl = curl_init();
									curl_setopt_array($curl, array(
										  CURLOPT_PORT => "8443",
										  CURLOPT_URL => $url,
										  CURLOPT_RETURNTRANSFER => true,
										  CURLOPT_ENCODING => "",
										  CURLOPT_MAXREDIRS => 10,
										  CURLOPT_TIMEOUT => 30,
										  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										  CURLOPT_CUSTOMREQUEST => "POST",
										  CURLOPT_POSTFIELDS => $req,
										  CURLOPT_HTTPHEADER => array(
										  "Content-Type: application/json",
											"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
										  ),
										));
										
									$response = curl_exec($curl);
									$err = curl_error($curl);
									curl_close($curl);
									//echo $response;exit;
									//$this->loging("bankit_bene_verification",$url,$response,"",$userinfo->row(0)->username);
									/*
										{"errorMsg":"SUCCESS","errorCode":"00","data":{"customerId":"7016515852","name":"RAVIKANT LAXMANBHAI","bankName":"Punjab National Bank","clientRefId":"VER1","txnId":"924200584318","impsRespCode":"00","txnStatus":"00"},"Reason":"SUCCESS"}
										
										
										{"errorMsg":"SUCCESS","errorCode":"00","data":{"customerId":"8238232303","name":"Mr  RAVIKANT LAXMANB","bankName":"State Bank of India","clientRefId":"VER4","txnId":"924201584357","impsRespCode":"00","txnStatus":"00"},"Reason":"SUCCESS"}
										
										{"errorMsg":"SUCCESS","errorCode":"00","data":{"customerId":"8238232303","name":"Mr  RAVIKANT LAXMANB","bankName":"State Bank of India","clientRefId":"VER5","txnId":"924201584360","impsRespCode":"00","txnStatus":"00"},"Reason":"SUCCESS"}

										{"errorMsg":"Failure","errorCode":"02","data":{"customerId":"7374074033","name":"","clientRefId":"100013595","txnId":""},"Reason":"Transaction Failed due to duplicate transaction Id."}


										{"errorMsg":"Success","errorCode":"00","data":{"customerId":"9560640891","name":"Mr. VIJAY MAHTO","bankName":"CENTRAL BANK OF INDIA","clientRefId":"10076100058573","txnId":"927517829081","impsRespCode":"00"},"Reason":"Success"}
									*/
									
									$recipient_name = "";
									$json_resp = json_decode($response);
									if(isset($json_resp->errorMsg) and isset($json_resp->errorCode))
									{
										// user not exist
										// redirect to registration form
										$message = $errorMsg = trim($json_resp->errorMsg);
										$errorCode = trim($json_resp->errorCode);
										if($errorCode == "00")
										{
											if(isset($json_resp->data))
											{
												$DATA = $json_resp->data;
												if(isset($DATA->name) and isset($DATA->txnId) )
												{
													$recipient_name = $DATA->name;
													$txnId = $DATA->txnId;
													$txnStatus = "";
													$resp_arr = array(
        																	"message"=>$message."  Name : ".$recipient_name,
        																	"status"=>0,
        																	"statuscode"=>"TXN",
        																	"recipient_name"=>$recipient_name
        																);
        											$json_resp =  json_encode($resp_arr);
        											$this->db->query("update mt3_account_validate 
    																						set RESP_statuscode = ?,
    																							RESP_status = ?,
    																							RESP_benename = ?,
																								RESP_bankrefno = ?,
    																							verification_status = ?,
    																							status = 'SUCCESS'
    																							where 	Id = ?",
    																							array
    																							(
    																								$txnStatus,
    																								$message,
    																								$recipient_name,
																									$txnId,
    																							    "VERIFIED",
    																								$insert_id
    																							)
    																						);
												}
											}
										}
										else if($errorCode == "02")
										{

											if(isset($json_resp->Reason))
											{
												$Reason = $json_resp->Reason;
												$resp_arr = array(
        																	"message"=>$Reason,
        																	"status"=>1,
        																	"statuscode"=>"ERR",
        																	
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
																								$Reason,
																								"FAILURE",
																								$insert_id
																							)
																						);
												
											}
										}
										else
										{
											$resp_arr = array(
        																	"message"=>$message,
        																	"status"=>1,
        																	"statuscode"=>"TUP",
        																	"recipient_name"=>""
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
		$this->loging("bankitverify_bene",$url."?".$req,$response,$json_resp,$userinfo->row(0)->username,$insert_id,"BANKIT_ACC_VER");
		return $json_resp;
		
	}
	
	public function transfer($remittermobile,$beneficiary_array,$amount,$mode,$userinfo,$order_id)
	{
	//$beneficiary_array->row(0)->bankit_id
		$postfields = '';
		$insert_id = 0;
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
				if($usertype_name == "APIUSER")
				{
					if($user_status == '1')
					{
						if($amount >= 100)
						{
						    $crntBalance = $this->Common_methods->getAgentBalance($user_id);
    						if(floatval($crntBalance) >= floatval($amount) + 30)
    						{
    						
    								if($beneficiary_array->num_rows() >= 1)
    								{
    									$benificiary_name = $beneficiary_array->row(0)->bene_name;
    									$benificiary_mobile = $beneficiary_array->row(0)->benemobile;
    									$benificiary_ifsc = $beneficiary_array->row(0)->IFSC;
    									$benificiary_account_no = $beneficiary_array->row(0)->account_number;
										$beneficiaryid = $beneficiary_array->row(0)->bankit_id;


    									$checkbeneexist = $this->db->query("select * from beneficiaries where sender_mobile = ? and account_number = ? and IFSC = ? order by Id desc limit 1",array($remittermobile,$benificiary_account_no,$benificiary_ifsc));
										if($checkbeneexist->num_rows() ==  1)
										{
											$is_bankit = $checkbeneexist->row(0)->is_bankit;
											$Id = $checkbeneexist->row(0)->Id;
										
											if($is_bankit == "no")
											{
												$req = "isbankit no for ".$remittermobile."  accno : ".$benificiary_account_no."  ifsc :".$benificiary_ifsc;
												$this->bankitlog($req,"","checkbeneexist",$remittermobile,$benificiary_account_no,$benificiary_ifsc);


												$fields_for_reg = "Remitter :".$remittermobile."  bene_name : ".$benificiary_name." bene Mobile : ".$benificiary_mobile."    accno : ".$benificiary_account_no."  IFSC : ".$benificiary_ifsc."    DEZIRE BANK ID : ".$beneficiary_array->row(0)->dezire_bank_id;

												$this->bankitlog($fields_for_reg,"","checkbeneexist",$remittermobile,$benificiary_account_no,$benificiary_ifsc);

												$this->add_benificiary($remittermobile,$benificiary_name,$benificiary_mobile,$benificiary_account_no,$benificiary_ifsc,$beneficiary_array->row(0)->dezire_bank_id,$userinfo);



												$$beneficiary_array = $this->db->query("select * from beneficiaries where sender_mobile = ? and account_number = ? and IFSC = ? order by Id desc limit 1",array($remittermobile,$benificiary_account_no,$benificiary_ifsc));

											}
										}






    									$benificiary_name = $beneficiary_array->row(0)->bene_name;
    									$benificiary_mobile = $beneficiary_array->row(0)->benemobile;
    									$benificiary_ifsc = $beneficiary_array->row(0)->IFSC;
    									$benificiary_account_no = $beneficiary_array->row(0)->account_number;
										$beneficiaryid = $beneficiary_array->row(0)->bankit_id;

										//check for bankit bene exists
										





	    									$chargeinfo = $this->getChargeValue($userinfo,$amount);
	    									if($chargeinfo != false)
	    									{
	    										/////////////////////////////////////////////////
	    										/////// RETAILER CHARGE CALCULATION
	    										////////////////////////////////////////////////
	    										$ccf = $chargeinfo->row(0)->ccf;		
	    										$tds = $chargeinfo->row(0)->tds;
	    										$ccf_type = $chargeinfo->row(0)->ccf_type;	
	    										$tds_type = $chargeinfo->row(0)->tds_type;

												$Charge_type = $chargeinfo->row(0)->charge_type;
	    										$charge_value = $chargeinfo->row(0)->charge_value;


	    										if($ccf_type == "PER")
	                                            {
	                                               $ccf = ((floatval($ccf) * floatval($amount))/ 100); 
	                                            }
	                                            $gst = (($ccf * 18)/118);
	                                            $charge =  $charge_value;
	                                            $cashback = $ccf - ($gst + $charge); 
	                                            if($tds_type == "PER")
	                                            {
	                                               $tds = ((floatval($tds) * floatval($cashback))/ 100); 
	                                            }

	                                            
												$Charge_Amount = $gst + $tds +  $charge;	
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
    									
    									
    									
    										
    									
    										$resultInsert = $this->db->query("
    											insert into mt3_transfer(
    											order_id,
												add_date,
												ipaddress,
												user_id,
    											Charge_type,
    											charge_value,
    											Charge_Amount,
    											RemiterMobile,
    											BeneficiaryId,
    											AccountNumber,
    											IFSC,
    											Amount,
    											Status,
    											mode,
												API,
												ccf,cashback,tds)
    											values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    											",array(
												$order_id,
												$this->common->getDate(),
												$this->common->getRealIpAddr(),
												$user_id,
    											$Charge_type,$charge_value,$Charge_Amount,
    											$remittermobile,
    											$beneficiaryid,
												$benificiary_account_no,
												$benificiary_ifsc,
    											$amount,
												"PENDING",
												$mode,
												"BANKIT",
												$ccf,
												$cashback,
												$tds
    											));
    										if($resultInsert == true)
    										{
    											$insert_id = $this->db->insert_id();
    											$transaction_type = "DMR";
    											$dr_amount = $amount;
    											$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
    											$sub_txn_type = "REMITTANCE";
    											$remark = "Money Remittance";
    											$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
												
    											if($paymentdebited == true)
    											{
    											    
														//$mode
    													//bankit code start here
														$reqarr = array(				   				   
															   "agentCode"       => 10076,				   
															   "recipientId"	 => $beneficiary_array->row(0)->bankit_id,
															   "customerId"      => $remittermobile,
															   "amount"          =>intval($amount),
															   "clientRefId"	 =>	"10076".$insert_id	   
															   );
														$req = json_encode($reqarr);
														$url="https://services.bankit.in:8443/DMRV1.1/transact/".$mode."/remit";
														$curl = curl_init();
														curl_setopt_array($curl, array(
															  CURLOPT_PORT => "8443",
															  CURLOPT_URL => $url,
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => "",
															  CURLOPT_MAXREDIRS => 10,
															  CURLOPT_TIMEOUT => 30,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => "POST",
															  CURLOPT_POSTFIELDS => $req,
															  CURLOPT_HTTPHEADER => array(
															  "Content-Type: application/json",
																"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
															  ),
														));
															
														$response = curl_exec($curl);
														curl_close($curl);


														$this->bankitlog($url."?".$req,$response,"REMIT",$remittermobile,$benificiary_account_no,$benificiary_ifsc);


														//$this->loging("paytm_transfer",$mode." ".$url."?".$req,$response,"",$userinfo->row(0)->username,$insert_id,"REMITBANKIT");
														//var_dump($response);exit;
														/*  
														{"errorMsg":"SUCCESS","errorCode":"00","data":{"customerId":"8866628967","name":"Mr KEYUR PRAFULBHAI","bankName":"State Bank of India","clientRefId":"708526","txnId":"924113520817","impsRespCode":"00","accountNumber":"34966017049","ifscCode":"SBIN0001266","txnStatus":"00"},"Reason":"SUCCESS"}
														
														
														
														
														failure
														
														{"errorMsg":"Failure","errorCode":"02","data":{"customerId":"8318849064","name":"","clientRefId":"721206","txnId":""},"Reason":"Sender Limit Exceeded"}
														
														
														{"errorMsg":"Failure","errorCode":"02","data":{"customerId":"7487831424","clientRefId":"721381","txnId":""},"Reason":"Customer Id does not match to specified Recipient."}
														*/
											
														       
															$json_obj = json_decode($response);
															if(isset($json_obj->errorMsg) and isset($json_obj->errorCode))
    														{
        														$errorMsg = strtoupper($json_obj->errorMsg);
    															$errorCode = $json_obj->errorCode;
    															if($errorCode == "00" and  $errorMsg == "SUCCESS")
    															{
																	$data = $json_obj->data;
																	$Reason = $json_obj->Reason;
																	$customerId = $data->customerId;
																	$name = $data->name;
																	$bankName = $data->bankName;
																	$clientRefId = $data->clientRefId;
																	$txnId = $data->txnId;
																	$impsRespCode = $data->impsRespCode;
																	$accountNumber = $data->accountNumber;
																	$ifscCode = $data->ifscCode;
																	$txnStatus  = "";
																	if(isset($data->txnStatus))
																	{
																	 $txnStatus = $data->txnStatus;
																	}
																	
																	
    																if($txnStatus  == "00")
																	{
																		$data = array(
																					'RESP_statuscode' => "TXN",
																					'RESP_status' => $errorMsg,
																					'RESP_ipay_id' => $txnId,
																					'RESP_opr_id' => $txnId,
																					'RESP_name' => $name,
																					'message'=>$errorMsg,
																					'Status'=>'SUCCESS',
																					'edit_date'=>$this->common->getDate()
																			);
		
																			$this->db->where('Id', $insert_id);
																			$this->db->update('mt3_transfer', $data);
		
																			$sendmsg = 'Transaction Successful, TID: '.$txnId.' Amt:Rs.'.$amount.' A/C: '.$benificiary_account_no.'  '.$this->common->getDate().' Thanks,mastermoney';
																			$this->db->query("insert into tempsms(message,to_mobile) values(?,?)",array($sendmsg,$remittermobile));
																			$resp_arr = array(
																								"message"=>$errorMsg,
																								"status"=>0,
																								"statuscode"=>"TXN",
																								"data"=>array(
																									"tid"=>$insert_id,
																									"ref_no"=>$txnId,
																									"opr_id"=>$txnId,
																									"name"=>$name,																										
																									"balance"=>"",
																									"amount"=>$amount,
		
																								)
																							);
																			$json_resp =  json_encode($resp_arr);
																	}
																	else
																	{
																		
																		$data = array(
																					'RESP_statuscode' => "TXN",
																					'RESP_status' => $errorMsg,
																					'RESP_ipay_id' => $txnId,
																					'RESP_opr_id' => $txnId,
																					'RESP_name' => $name,
																					'message'=>$errorMsg,
																					'Status'=>'SUCCESS',
																					'edit_date'=>$this->common->getDate()
																			);
		
																			$this->db->where('Id', $insert_id);
																			$this->db->update('mt3_transfer', $data);
		
																			$sendmsg = 'Transaction Successful, TID: '.$txnId.' Amt:Rs.'.$amount.' A/C: '.$benificiary_account_no.'  '.$this->common->getDate().' Thanks,mastermoney';
																			$this->db->query("insert into tempsms(message,to_mobile) values(?,?)",array($sendmsg,$remittermobile));
																			$resp_arr = array(
																								"message"=>$errorMsg,
																								"status"=>0,
																								"statuscode"=>"TXN",
																								"data"=>array(
																									"tid"=>$insert_id,
																									"ref_no"=>$txnId,
																									"opr_id"=>$txnId,
																									"name"=>$name,																										
																									"balance"=>"",
																									"amount"=>$amount,
		
																								)
																							);
																			$json_resp =  json_encode($resp_arr);
																	
																	}
    																
    															}
																else if($errorCode == "02" and  $errorMsg == "FAILURE")
    															{
																	
																	$Reason = $json_obj->Reason;
																	$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
																	
																	

																	$data = array(
																			'RESP_statuscode' => "ERR",
																			'RESP_status' => $Reason,
																			'Status'=>'FAILURE',
																			'edit_date'=>$this->common->getDate()
																	);

																	$this->db->where('Id', $insert_id);
																	$this->db->update('mt3_transfer', $data);
																	$resp_arr = array(
																							"message"=>$Reason,
																							"status"=>1,
																							"statuscode"=>"ERR",
																						);
																	$json_resp =  json_encode($resp_arr);
    															}
																else
																{
																echo $response;exit;
																}
        													}
															else
        													{ 
        														//check status befor refund
        														//$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);
        														$data = array(
        																			'RESP_statuscode' => "UNK",
        																			'RESP_status' => "Unknown Response or No Response",
        																			'edit_date'=>$this->common->getDate()
        																	);
        
        																	$this->db->where('Id', $insert_id);
        																	$this->db->update('mt3_transfer', $data);
        														$resp_arr = array(
        																"message"=>"Your Request Submitted Successfully",
        																"status"=>0,
        																"statuscode"=>"TUP",
        															);
        														$json_resp =  json_encode($resp_arr);
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
    												$resp_arr = array(
    													"message"=>"Payment Failure",
    													"status"=>1,
    													"statuscode"=>"ERR",
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
    											);
    											$json_resp =  json_encode($resp_arr);	
    										}
    									
    								}
								else
								{
									$resp_arr = array(
											"message"=>"Invalid Beneficiary Id",
											"status"=>1,
											"statuscode"=>"RNF",
										);
									$json_resp =  json_encode($resp_arr);
								}
    							
    						}
    						else
    						{
    							$resp_arr = array(
    									"message"=>"InSufficient Balance",
    									"status"=>1,
    									"statuscode"=>"ISB",
    								);
    							$json_resp =  json_encode($resp_arr);
    						}    
						}
						else
						{
						    $resp_arr = array(
    									"message"=>"Minimum Balance Limit is 1000 Rupees",
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
		$this->bankitlog($url."?".$req,$response,"REMIT",$remittermobile,$benificiary_account_no,$benificiary_ifsc);
		//$this->loging("paytm_transfer",$mode." ".$url."?".$req,$response,$json_resp,$userinfo->row(0)->username,$insert_id,"REMIT");
		return $json_resp;
		
	}

	public function bankitlog($request,$response,$type,$mobile_no,$acc_no,$ifsc)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into bankitlog(request,response,add_date,ipaddress,type,sender_mobile,accno,ifsc) values(?,?,?,?,?,?,?,?)",array($request,$response,$add_date,$ipaddress,$type,$mobile_no,$acc_no,$ifsc));
	}
	
	public function transfer_resend_hold($Id)
	{
	    $insert_id = $Id;
	    $rslttransaction = $this->db->query("SELECT * FROM `mt3_transfer` where Status = 'HOLD' and Id = ?",array($Id));
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
		
		
		if($mode == "NEFT" or $mode == "1")
		{
		    $transtype = "NEFT";
		    $mode = "NEFT";
			$apimode = "1";
		}
		
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
					
					
				$this->db->query("update mt3_transfer set Status = 'PENDING',API = 'SHOOTCASE' where Id = ?",array($Id));
					
				$PIN = $this->getpin($remitter_id);
			    $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));
				$data = array(
					"sendermobile"=>$remitter_id,
					"senderpinno"=>$PIN,
					"beneficiaryid"=>$beneficiaryid,
					"remark"=>urlencode($remark),
					"transtype"=>$transtype,
					"transamount"=>$amount,
					"agentmerchantid"=>$insert_id,
					);
					
						$url = 'http://www.deziremoney.co.in/apis/v1/dmr?action=paynow&authKey='.$this->getdauthKey().'&clientId='.$this->getClientId().'&userId='.$this->getUserId().'&data='.json_encode($data);
						

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_TIMEOUT, 60);
						$response = $buffer = curl_exec($ch);
						curl_close($ch);
						$json_obj = json_decode($response);

						if(isset($json_obj->STATUS) and isset($json_obj->MESSAGE))
						{
							$status = $json_obj->STATUS;
							$message = $json_obj->MESSAGE;
							if($status == "1")
							{
								$tid = "";
								if(isset($json_obj->DATA))
								{
									$tid = $json_obj->DATA;	
								}
								$fee = "";
								$collectable_amount = "";
								$utility_acc_no = "";
								$sender_name = "";
								$balance = "";
								$recipient_name = "";
								$data = array(
											'RESP_statuscode' => "TXN",
											'RESP_status' => $message,
											'RESP_ipay_id' => $tid,
											'RESP_ref_no' => "",
											'RESP_opr_id' => $tid,
											'RESP_name' => $benificiary_name,
											'RESP_opening_bal' => "",
											'RESP_amount' => "",
											'RESP_locked_amt' => "",
											'tx_status'=>$message,
											"row_lock"=>"LOCKED",
											'Status'=>'SUCCESS'
									);

									$this->db->where('Id', $insert_id);
									$this->db->update('mt3_transfer', $data);
                                    
                                    $sendmsg = 'Transaction Successful, TID: '.$tid.' Amt:Rs.'.$amount.' A/C: '.$benificiary_account_no.'  '.$this->common->getDate().' Thanks,masterpay';
                                    $this->common->ExecuteSMSApi($remittermobile,$sendmsg);
                                    $this->COMMISSIONPAYMENT_CREDIT_ENTRY($DId,$insert_id,$transaction_type,$dist_charge_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00);
									$resp_arr = array(
														"message"=>$message,
														"status"=>0,
														"data"=>array(
															"tid"=>$tid,
															"ref_no"=>$insert_id,
															"opr_id"=>$tid,
															"name"=>$benificiary_name,
															"balance"=>"",
															"amount"=>$amount,

														)
													);
									$json_resp =  json_encode($resp_arr);
							}
							else if($status == "4")
							{
								
								$tid = "";
								if(isset($json_obj->DATA))
								{
									$tid = $json_obj->DATA;	
								}
									$fee = "";
									$collectable_amount = "";
									$utility_acc_no = "";
									$sender_name = "";
									$balance = "";
									$recipient_name = "";
									$data = array(
												'RESP_statuscode' => "TUP",
												'RESP_status' => $message,
												'RESP_ipay_id' => $tid,
												'RESP_ref_no' => $insert_id,
												'RESP_opr_id' => $tid,
												'RESP_name' => $benificiary_name,
												'RESP_opening_bal' => "",
												'RESP_amount' => $amount,
												'RESP_locked_amt' => "",
												'tx_status'=>$message,
												"row_lock"=>"OPEN",
												'Status'=>'PENDING'
										);

										$this->db->where('Id', $insert_id);
										$this->db->update('mt3_transfer', $data);
										$resp_arr = array(
															"message"=>$message,
															"status"=>0,
															"data"=>array(
																"tid"=>$tid,
																"ref_no"=>$insert_id,
																"opr_id"=>$tid,
																"name"=>$benificiary_name,
																"balance"=>"",
																"amount"=>"",

															)
														);
										$json_resp =  json_encode($resp_arr);	

								
							}
							else if($status == "2")
							{
								    $transaction_type = "DMR";
									$dr_amount = $amount;
									$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
									$sub_txn_type = "REMITTANCE";
									$remark = "Money Remittance";
								    $this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
									$data = array(
												'RESP_statuscode' => $status,
												'RESP_status' => $message,
												'tx_status'=>$message,
												'Status'=>'FAILURE',
												"row_lock"=>"LOCKED",
										);

									$this->db->where('Id', $insert_id);
									$this->db->update('mt3_transfer', $data);
									$resp_arr = array(
															"message"=>$message,
															"status"=>1,
															"statuscode"=>$status,
														);
									$json_resp =  json_encode($resp_arr);   
								
							}
							else
							{
								$data = array(
												"RESP_status"=>$message,
												'RESP_statuscode' => "UNK",
												'RESP_status' => "Unknown Response",
												'Status'=>'PENDING',
												'RESP_statuscode'=>$status,
												'tx_status'=>message,
									);

									$this->db->where('Id', $insert_id);
									$this->db->update('mt3_transfer', $data);
									$resp_arr = array(
															"message"=>"Unknown Response",
															"status"=>$status,
															"statuscode"=>"UNK",
														);
									$json_resp =  json_encode($resp_arr);
							}


						}
						else
						{ 
							//check status befor refund
							//$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);
							$data = array(
												'RESP_statuscode' => "UNK",
												'RESP_status' => "Unknown Response or No Response"
										);

										$this->db->where('Id', $insert_id);
										$this->db->update('mt3_transfer', $data);
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
		$this->loging("shootcase_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	
	
	
	
	
	
	public function transfer_status($dmr_id)
	{
	    
	 
		    $resultdmr = $this->db->query("SELECT a.API,a.Id,a.add_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_opr_id,a.RESP_name,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id

 where a.Id = ?",array($dmr_id));
		
		
		
		if($resultdmr->num_rows() == 1)
		{
			$Id = $resultdmr->row(0)->Id;
		    $clientRefId = "10076".$Id;
			$Status = $resultdmr->row(0)->Status;
			$user_id = $resultdmr->row(0)->user_id;
			$API = $resultdmr->row(0)->API;
			$RESP_status = $resultdmr->row(0)->RESP_status;
			$RESP_name = $resultdmr->row(0)->RESP_name;
			$Amount = $amount = $resultdmr->row(0)->Amount;
			$RESP_opr_id = $resultdmr->row(0)->RESP_opr_id;
			$RESP_ipay_id = $resultdmr->row(0)->RESP_ipay_id;
			$debit_amount = $resultdmr->row(0)->debit_amount;
			if($API == "BANKIT")
			{
				$paymentinfo = $this->db->query("SELECT transaction_type,description,remark,credit_amount,debit_amount FROM tblewallet where dmr_id =? and user_id = ?",array($dmr_id,$user_id));
			
			
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
					if($API == "BANKIT")
					{
						
						if($Status == "PENDING" )
						{
							$reqarr = array(				   				   
								  "clientRefId"        => $clientRefId,
								   );
							$req = json_encode($reqarr);
							
							$url="https://services.bankit.in:8443/DMRV1.1/transact/searchtxn";
							$curl = curl_init();
							curl_setopt_array($curl, array(
								  CURLOPT_PORT => "8443",
								  CURLOPT_URL => $url,
								  CURLOPT_RETURNTRANSFER => true,
								  CURLOPT_ENCODING => "",
								  CURLOPT_MAXREDIRS => 10,
								  CURLOPT_TIMEOUT => 30,
								  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								  CURLOPT_CUSTOMREQUEST => "POST",
								  CURLOPT_POSTFIELDS => $req,
								  CURLOPT_HTTPHEADER => array(
								  "Content-Type: application/json",
									"authorization: Basic Q0hBTVBJT04gU09GVFdBUkUgVEVDSE5PTE9HSUVTIExJTUlURUQtUklURVNIMjAyNDQ1OnltMnEwbG1xazA=",
								  ),
								));
								
							$response = curl_exec($curl);
							
							$err = curl_error($curl);
							curl_close($curl);
					        $json_obj = json_decode($response);

					       // echo $req."<br><br>";
					        //echo $response;exit;
					       
					    /*
					    {"errorMsg":"Pending","errorCode":"01","data":{"clientRefId":"101016546789","txnId":"928812630674","transactionDate":"2019-10-15","amount":5000.00}}
					    {"message":"SUCCESS","status":0,"statuscode":"TXN","data":{"tid":"1093992","ref_no":"929816700783","opr_id":"929816700783","name":"Mr PRADEEP KUMAR P","amount":"5000"}}
					    */
					        if(isset($json_obj->errorMsg) and isset($json_obj->errorCode))
					        {
					           
					            $errorMsg = strtoupper($json_obj->errorMsg);
					            $errorCode = $json_obj->errorCode;
								if($errorCode == "00" and  ($errorMsg == "SUCCESS" or $errorMsg == "Success"))
								{
									$clientRefId = $data->clientRefId;
									$txnId = $data->txnId;
									$RESP_amount = $data->amount;
									
									$data = array(
							                            'RESP_statuscode' => "TXN",
							                            'RESP_status' => $status,
							                            'RESP_ipay_id' => $txnId,
							                            'RESP_opr_id' => $txnId,
							                            'Status'=>'SUCCESS'
							                    );

							        $this->db->where('Id', $dmr_id);
							        $this->db->update('mt3_transfer', $data);
									$resp_arr = array(
							                "message"=>$errorMsg,
							                "status"=>0,
							                "statuscode"=>"TXN",
							                "data"=>array(
							                    "tid"=>$dmr_id,
							                    "ref_no"=>$txnId,
							                    "opr_id"=>$txnId,
							                    "name"=>$RESP_name,
							                    "amount"=>$amount,

							                )
							            );
							        $json_resp =  json_encode($resp_arr); 
									
					        	}
					            else if($errorCode == "02" and  ($errorMsg == "FAILURE" or $errorMsg == "failure" or $errorMsg == "Failure" ))
								{





									$data = array(
							                            'RESP_statuscode' => "TXN",
							                            'RESP_status' => $errorMsg,
							                            'RESP_ipay_id' => "",
							                            'RESP_opr_id' => "",
							                            'Status'=>'FAILURE'
							                    );

							        $this->db->where('Id', $dmr_id);
							        $this->db->update('mt3_transfer', $data);
							        $transaction_type = "DMR";
							        $dr_amount = $amount;
							        $Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
							        $sub_txn_type = "REMITTANCE";
							        $remark = "Money Remittance";
							        $this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
							                                        
							        
							        $resp_arr = array(
							                "message"=>$errorMsg,
							                "status"=>1,
							                "statuscode"=>"ERR",
							            );
							        $json_resp =  json_encode($resp_arr); 
							        return $json_resp;
					            }
					            else if($errorCode == "01" and  ($errorMsg == "PENDING" or $errorMsg == "Pending"))
								{
									$resparray = array(
							            "message"=>"Transaction In Pending Process",
							            "status"=>2,
							            "statuscode"=>"TUP"
							            );
							        return json_encode($resparray); 
					            }
    					        else
    					        {
    					            echo $response;exit;
    					        }
				            
					
				            }
				            else
				            {
				                 echo $response;exit;
				            }
						  
						
						}
						else if($Status == "SUCCESS")
						{
				
							$resp_arr = array(
											"message"=>"SUCCESS",
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
					
							$resp_arr = array(
											"message"=>"FAILURE",
											"status"=>1,
											"statuscode"=>"ERR",
										);
							$json_resp =  json_encode($resp_arr); 
							return $json_resp;
						}
						else
						{
							return $Status;
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
	
	private function loging($methiod,$request,$response,$json_resp,$username,$dmt_id = 0,$type="")
	{
	
		$this->db->query("insert into templog(dmt_id,add_date,ipaddress,request,response,downline_response,type) values(?,?,?,?,?,?,?)",
											array($dmt_id,$this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$json_resp,$type));
		//**return "";
		//**echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		"username: ".$username.PHP_EOL.
		"Request: ".$request.PHP_EOL.
        "Response: ".$response.PHP_EOL.
		"Downline Response: ".$json_resp.PHP_EOL.
        "Method: ".$methiod.PHP_EOL.
        "-------------------------".PHP_EOL;
		
		
		//echo $log;exit;
	//	$filename ='inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt';
	//	if (!file_exists($filename)) 
	//	{
	//		file_put_contents($filename, '');
	//	} 
		
//Save string to log, use FILE_APPEND to append.
	//	file_put_contents('inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
		
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
		$result_oldbalance = $this->db->query("SELECT balance FROM `tblewallet` where user_id = ? order by Id desc limit 1",array($user_id));
		if($result_oldbalance->num_rows() > 0)
		{
			$old_balance =  $result_oldbalance->row(0)->balance;
		}
		else 
		{
			
				
        		$result_oldbalance2 = $this->db->query("SELECT balance FROM masterpa_archive.tblewallet where user_id = ? order by Id desc limit 1",array($user_id));
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
		
		//$old_balance = $this->Common_methods->getAgentBalance($user_id);
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
    			$str_query = "insert into  tblewallet(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
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
    									$str_query_charge = "insert into  tblewallet(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
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
        		$old_balance = $this->Common_methods->getAgentBalance($user_id);
        		$current_balance = $old_balance + $dr_amount;
        		$tds = 0.00;
        		$stax = 0.00;
        		if($transaction_type == "DMR")
        		{
        			$remark = "Money Remittance Reverse";
        			$str_query = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
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
        									$str_query_charge = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
        
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
			$old_balance = $this->Common_methods->getAgentBalance($user_id);
			$current_balance = $old_balance + $dr_amount;
			
			$tds = 0.00;
			$stax = 0.00;
			if($transaction_type == "DMR")
			{
				$remark = "Money Remittance Commission";
				$str_query = "insert into  tblewallet(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
	
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

private function getChargeValue($userinfo,$whole_amount)
{
    
    
    $groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->user_id));
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

	
}

?>
