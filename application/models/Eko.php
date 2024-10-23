<?php
class Eko extends CI_Model 
{ 
   
	function _construct()
	{
	   
		  // Call the Model constructor
		  parent::_construct();
	}
	private function getLiveUrl($type)
	{	
	}
	private function getToken()
	{
		return "dfdsfdsfff";
	}
	private function getUsername()
	{
		return "110018";
	}
	private function getPassword()
	{
		return "n01w1bbx";
	}
	private function getinitiator_id()
	{
		return "8849972833";
	}
	private function getdeveloper_key()
	{
		return "7ec8954aeab13e8ff55942a60c6a2b74";
	}
	
	
	public function bank_details($ifsc)
	{
	    
			   
						$initiator_id = $this->getinitiator_id();
						
						$developer_key= $this->getdeveloper_key();

                        //banks?bank_code=KKBK&initiator_id=mobile_number:9910028267
						$url = 'https://api.eko.co.in:25002/ekoicici/v1/banks?ifsc='.$ifsc.'&initiator_id=' . $initiator_id ;
						//echo $url;exit;
						 $ch = curl_init();
						curl_setopt($ch, CURLOPT_HEADER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
						curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Accept: application/json',
							'developer_key: '.$this->getdeveloper_key()
						));
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL, $url);
						$response = curl_exec($ch);
						curl_close($ch);
						
					    echo $response;exit;
							
					
	}
	
	public function remitter_details2($mobile_no,$userinfo,$reqfrom = false)
	{
	    /*$resp_arr = array(
										"message"=>"We are under maintanance in DMT. Please try after some time.",
										"status"=>10,
										"statuscode"=>"UNK",
									);
		$json_resp =  json_encode($resp_arr);
		echo $json_resp;exit;*/
	    
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$initiator_id = $this->getinitiator_id();
						
						$developer_key= $this->getdeveloper_key();

						$url = 'https://api.eko.co.in:25002/ekoicici/v1/customers/mobile_number:' . $mobile_no . '?initiator_id=' . $initiator_id ;
						 $ch = curl_init();
						curl_setopt($ch, CURLOPT_HEADER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
						curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Accept: application/json',
							'developer_key: '.$this->getdeveloper_key()
						));
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL, $url);
						$response = curl_exec($ch);
						curl_close($ch);
						
							
							$json_obj = json_decode($response);
						
							if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
									$response_status_id = trim((string)$json_obj->response_status_id);
									$response_type_id = trim((string)$json_obj->response_type_id);
									$message = trim((string)$json_obj->message);
									$status = trim((string)$json_obj->status);
									if($status == "463")
									{
										$resp_arr = array(
																	"message"=>"Record Not Found",
																	"status"=>1,
																	"statuscode"=>"RNF",
																);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "0" and $response_type_id == "37")
									{
										$resp_arr = array(
																"message"=>"Validation Pending",
																"status"=>1,
																"statuscode"=>"37",
															);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "323")
									{
										$resp_arr = array(
																"message"=>$message,
																"status"=>1,
																"statuscode"=>"323",
															);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "0" )
									{
										$data =  $json_obj->data;
										
										
										$this->load->model("Shootcase");
								        $resp =  $this->Shootcase->remitter_registration_auto($data->mobile,$data->name,"Kumar",$userinfo);
									    //return $resp;
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
		$this->loging("remitter_details",$url,$response,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	public function remitter_details($mobile_no,$userinfo,$reqfrom = false)
	{
	   // print_r($userinfo->result());exit;
	    /*$resp_arr = array(
										"message"=>"We are under maintanance in DMT. Please try after some time.",
										"status"=>10,
										"statuscode"=>"UNK",
									);
		$json_resp =  json_encode($resp_arr);
		echo $json_resp;exit;*/
	    
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
						$initiator_id = $this->getinitiator_id();
						
						$developer_key= $this->getdeveloper_key();

						$url = 'https://api.eko.co.in:25002/ekoicici/v1/customers/mobile_number:' . $mobile_no . '?initiator_id=' . $initiator_id ;
						 $ch = curl_init();
						curl_setopt($ch, CURLOPT_HEADER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
						curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Accept: application/json',
							'developer_key: '.$this->getdeveloper_key()
						));
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL, $url);
						$response = curl_exec($ch);
						curl_close($ch);
						//echo $response;exit;
							
							$json_obj = json_decode($response);
						
							if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
									$response_status_id = trim((string)$json_obj->response_status_id);
									$response_type_id = trim((string)$json_obj->response_type_id);
									$message = trim((string)$json_obj->message);
									$status = trim((string)$json_obj->status);
									if($status == "463")
									{
										$resp_arr = array(
																	"message"=>"Record Not Found",
																	"status"=>1,
																	"statuscode"=>"RNF",
																);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "0" and $response_type_id == "37")
									{
										$resp_arr = array(
																"message"=>"Validation Pending",
																"status"=>1,
																"statuscode"=>"37",
															);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "323")
									{
										$resp_arr = array(
																"message"=>$message,
																"status"=>1,
																"statuscode"=>"323",
															);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "0" )
									{
										$data =  $json_obj->data;
										
										$rsndnum = rand(1,20);
										//if($rsndnum % 2 == 0)
									/*	if(true)
										{
										    $checkremitterexist = $this->db->query("SELECT Id FROM `mt3_remitter_registration` where mobile = ? and API = 'SHOOTCASE' and status = 'SUCCESS'",array($mobile_no));
    										if($checkremitterexist->num_rows() == 0)
    										{
    										    $this->load->model("Shootcase");
    								            $resp =  $this->Shootcase->remitter_registration_auto($data->mobile,$data->name,"Kumar",$userinfo);    
    										}    
										}
										*/
										
										//$this->load->model("Shootcase");
								        //$resp =  $this->Shootcase->remitter_registration_auto($data->mobile,$data->name,"Kumar",$userinfo);
										/*
										{
										    "response_status_id":0,
										    "data":{
										    "customer_id_type":"mobile_number",
										    "bc_available_limit":35000.0,
										    "mobile":"9896758487",
										    "used_limit":15000.0,
										    "total_limit":50000.0,
										    "available_limit":35000.0,
										    "balance":"0.0",
										    "state_desc":"Non-Kyc",
										    "name":"mukesh",
										    "limit":[{"name":"BC_Pipe4","pipe":"1","used":"0.0","priority":null,"remaining":"25000.0","status":"0"},
										    {"name":"BC_Pipe3","pipe":"3","used":"0.0","priority":null,"remaining":"25000.0","status":"0"},
										    {"name":"BC_Pipe2","pipe":"4","used":"0.0","priority":null,"remaining":"25000.0","status":"0"},
										    {"name":"Pipe5","pipe":"5","used":"15000.0","priority":2,"remaining":"10000.0","status":"1"},
										    {"name":"Pipe6","pipe":"7","used":"0.0","priority":null,"remaining":"25000.0","status":"1"},
										    {"name":null,"pipe":"8","used":"0.0","priority":3,"remaining":"25000.0","status":"1"}],
										    "currency":"INR","state":"2","wallet_available_limit":0.0,"customer_id":"9896758487"},
										    "response_type_id":33,"message":"Non-KYC active","status":0}
										*/
										$customerMobile = $mobile_no;
										$checkremitterexist = $this->db->query("select Id from mt3_remitter_registration where mobile = ?",array($customerMobile));
										if($checkremitterexist->num_rows() == 0)
										{
											$this->db->query("insert into mt3_remitter_registration(user_id,add_date,ipaddress,mobile,name,lastname,pincode,status,EKO)
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
											$this->db->query("update mt3_remitter_registration set EKO = 'yes' where mobile = ?",array($customerMobile));
										}
										    $resp_arr = array(
																"message"=>$message,
																"status"=>0,
																"statuscode"=>"33",
																"data"=>$data,
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
		$this->loging("remitter_details",$url,$response,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	public function delete_bene($mobile_no,$benecode,$userinfo)
	{
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
				
			$url ="https://api.eko.co.in:25002/ekoicici/v1/customers/mobile_number:".$mobile_no."/recipients/recipient_id:".$benecode;
						
						$request = array(
						  'initiator_id' => '9910028267',
						);

						$ch = curl_init($url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Accept: application/json',
							'developer_key: '.$this->getdeveloper_key()
						));
						curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));

						$buffer = $response = curl_exec($ch);
						
						$json_obj = json_decode($buffer);
						
						/*{"response_status_id":0,"response_type_id":27,"message":"DELETED!","status":0}*/
							
							if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
								
									$response_status_id = trim((string)$json_obj->response_status_id);
									$response_type_id = trim((string)$json_obj->response_type_id);
									$message = trim((string)$json_obj->message);
									$status = trim((string)$json_obj->status);
								
									if($status == "0")
									{
										
	
										$resp_arr = array(
																"message"=>$message,
																"status"=>0,
																"statuscode"=>$response_type_id,
															);
										$json_resp =  json_encode($resp_arr);
									}
									else
									{
										
											$resp_arr = array(
																	"message"=>$message,
																	"status"=>"1",
																	"statuscode"=>$response_type_id,
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
		$this->loging("eko_deletebene",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	public function get_sender_bene($mobile_no,$userinfo)
	{
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						$initiator_id = $this->getinitiator_id();
						$developer_key= $this->getdeveloper_key();
						 $url ="https://api.eko.co.in:25002/ekoicici/v1/customers/mobile_number:".$mobile_no."/recipients?initiator_id=".$this->getinitiator_id();
						 $ch = curl_init();
						curl_setopt($ch, CURLOPT_HEADER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
						curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
						curl_setopt($ch, CURLOPT_HTTPHEADER, array(
							'Accept: application/json',
							'developer_key: '.$this->getdeveloper_key()
						));
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL, $url);
						$response = $buffer = curl_exec($ch);
						curl_close($ch);
						$json_obj = json_decode($buffer);
						//echo $response;exit;
							if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
								
									$response_status_id = trim((string)$json_obj->response_status_id);
									$response_type_id = trim((string)$json_obj->response_type_id);
									$message = trim((string)$json_obj->message);
									$status = trim((string)$json_obj->status);
									if($status == "463")
									{
										$resp_arr = array(
																	"message"=>"Record Not Found",
																	"status"=>1,
																	"statuscode"=>"RNF",
																);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "0" and $response_type_id == "22")
									{
										$resp_arr = array(
																"message"=>$message,
																"status"=>0,
																"statuscode"=>"22",
															);
										$json_resp =  json_encode($resp_arr);
									}
									else if($status == "0" )
									{
										$data =  $json_obj->data;
										
										$resp_arr = array(
																"message"=>$message,
																"status"=>0,
																"statuscode"=>$response_type_id,
																"data"=>$data,
															);
										$json_resp =  json_encode($resp_arr);
										
										if(isset($data->recipient_list))
										{
											
											foreach($data->recipient_list  as $bne)
											{
											    
											    
											    if(true)
											    {
											        $rsltcheckshootcase = $this->db->query("select count(Id) as total from mt3_beneficiary_register_temp where remitterid = ? and benificiary_account_no = ? and benificiary_ifsc = ? and API = 'SHOOTCASE'",
                                        		    array($mobile_no,$bne->account,$bne->ifsc));
                                        		    if($rsltcheckshootcase->row(0)->total == 0)
                                        		    {
                                        		        
                                        		        
                                        		        $mobile_no = $mobile_no;
                                        		        $bene_mobile = $mobile_no;
                                        		        $bene_name = $bne->recipient_name;
                                        		        $acc_no = $bne->account;
                                        		        $ifsc = $bne->ifsc;
                                        		        
                                        		        $this->load->model("Shootcase");
                                        				$this->Shootcase->add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$userinfo);
                                        		    }
                                        		    
											    }
												
												$checkbeneexist = $this->db->query("select count(Id) as total from mt3_beneficiary_register_temp 
																	where remitterid = ? and RESP_beneficiary_id = ? and status = 'SUCCESS'  and API = 'EKO'
																	order by Id desc limit 1",array(
																	$mobile_no,$bne->recipient_id));
												if($checkbeneexist->row(0)->total == 0)
												{
													$this->db->query("insert into mt3_beneficiary_register_temp(user_id,add_date,ipaddress,remitterid,remitter_mobile,benificiary_name,benificiary_mobile,benificiary_ifsc,benificiary_account_no,status,RESP_remitter_id,RESP_beneficiary_id,API) values(?,?,?,?,?,?,?,?,?,?,?,?,?)",
													array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$mobile_no,$mobile_no,$bne->recipient_name,"",$bne->ifsc,$bne->account,"SUCCESS",$mobile_no,$bne->recipient_id,'EKO'));
												}
											}
										}
										
										
										
									}
								else
								{
									$data =  $json_obj->data;
										$resp_arr = array(
																"message"=>$message,
																"status"=>0,
																"statuscode"=>$response_type_id,
																"data"=>$data,
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
		$this->loging("eko_bene_list",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	public function verify_bene($mobile_no,$acc_no,$ifsc,$bank_code,$userinfo)
	{
	    
	    
	   
	    //echo $mobile_no."  ".$acc_no."  ".$ifsc."  ".$bank_code;exit;
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			    $user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						$accval_resultcheck = $this->db->query("SELECT RESP_benename FROM `mt3_account_validate` where account_no = ? and remitter_mobile = ? and user_id = ? and status = 'SUCCESS' and API = 'EKO' order by Id desc limit 1",
						array($acc_no,$mobile_no,$user_id));
						
						if($accval_resultcheck->num_rows() == 1)
						{
						    $resp_arr = array(
													"message"=>"Beneficiary Already Validated ".$accval_resultcheck->row(0)->RESP_benename,
													"status"=>0,
													"statuscode"=>"TXN",
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
    					//echo 	$mobile_no."  ".$mobile_no."  ".$acc_no."  ".$ifsc;exit;
    						$rsltinsert = $this->db->query("insert into mt3_account_validate(user_id,add_date,edit_date,ipaddress,remitter_mobile,remitter_id,account_no,IFSC,status,API) 
    						values(?,?,?,?,?,?,?,?,?,?)",array(
    							$user_id,$this->common->getDate(),1,$this->common->getRealIpAddr(),$mobile_no,$mobile_no,$acc_no,$ifsc,"PENDING","EKO"
    						));
    					//	var_dump($rsltinsert);exit;
    						if($rsltinsert == true)
    						{
    							$insert_id = $this->db->insert_id();
    							$transaction_type = "DMR";
    							$sub_txn_type = "Account_Validation";
    							$charge_amount = 3.00;
    							$Description = "Account Validation Charge";
    							$remark = $mobile_no."  Acc NO :".$acc_no;
    							$debitpayment = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
    
    							if($debitpayment == true)
    							{
    								
    								
    							
    						
    								//echo $url;exit;
    								
    								$initiator_id = $this->getinitiator_id();
    								$developer_key= $this->getdeveloper_key();
    								if($bank_code == "VIJB" or $bank_code == "SCBL" )
    								{
    								    $url = 'https://api.eko.co.in:25002/ekoicici/v1/banks/ifsc:'.$ifsc.'/accounts/'.$acc_no;    
    								}
    								else if($bank_code == "ALLA" or $bank_code == "UTBI" or $bank_code == "BKDN")
    								{
    								    $url = 'https://api.eko.co.in:25002/ekoicici/v1/banks/bank_code:'.$bank_code.'/accounts/'.$acc_no;
    								}
    								else
    								{
    								    $url = 'https://api.eko.co.in:25002/ekoicici/v1/banks/ifsc:'.$ifsc.'/accounts/'.$acc_no;
    								}
    								
    								 $ch = curl_init();
    								curl_setopt($ch, CURLOPT_HEADER, false);
    								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    								curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
    								curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    								curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    									'Accept: application/json',
    									'developer_key: '.$this->getdeveloper_key()
    								));
    								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    								curl_setopt($ch, CURLOPT_POST,1);
    								curl_setopt($ch, CURLOPT_POSTFIELDS, "initiator_id=".$initiator_id."&customer_id=".$mobile_no);
    								curl_setopt($ch, CURLOPT_URL, $url);
    								$buffer = $response = $buffer = curl_exec($ch);
    								curl_close($ch);
    								//echo $buffer;exit; 
    								$json_obj = json_decode($buffer);
            						/*
            						
            						
            						{"response_status_id":1,"invalid_params":{"account":"Enter a\/c number in correct format"},"response_type_id":-1,"message":"Invalid account details","status":46}
            						
            						
            						{"response_status_id":-1,
            						"data":{
            						    "client_ref_id":"","bank":"Punjab National Bank","amount":"0.00",
            						    "is_name_editable":"0","fee":"2.00","verification_failure_refund":"","aadhar":"",
            						    "recipient_name":"RAVIKANT LAXMANBHAI","is_Ifsc_required":"0","account":"0964000102016012",
            						    "tid":"1193478104"
            						    
            						},
            						"response_type_id":61,"message":"Success! Account details found..","status":0}
            						*/
    								/*{"response_status_id":1,"data":{"is_Ifsc_required":"0"},"response_type_id":350,"message":"Verification failed.Recipient name not found.","status":350}*/
    							
    								if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
    								{
    
    										$recipient_name = "";
    										$response_status_id = trim((string)$json_obj->response_status_id);
    										$response_type_id = trim((string)$json_obj->response_type_id);
    										$message = trim((string)$json_obj->message);
    										$status = trim((string)$json_obj->status);
    										$recipient_id = 0;
    										if(isset($json_obj->data))
    										{
    											$data = $json_obj->data;	
    											$recipient_name = "";
                                                if(isset($data->recipient_name))
                                                {
                                                    $recipient_name = $data->recipient_name;    
                                                }
                                                if($status == "0")
                                                {
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
    																							verification_status = ?,
    																							status = 'SUCCESS'
    																							where 	Id = ?",
    																							array
    																							(
    																								"TXN",
    																								$message,
    																								$recipient_name,
    																							    "SUCCESS",
    																								$insert_id
    																							)
    																						);
                                                }
                                                else if($status == "350" or $status == "46"  or $status == "44" or $status == "344"  or $status == "544" or $status == "540")
                                                {
                                                    $this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
                                                    
        											$resp_arr = array(
        																	"message"=>$message,
        																	"status"=>1,
        																	"statuscode"=>"ERR",
        																	"recipient_name"=>$recipient_name
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
        																	"message"=>$message,
        																	"status"=>1,
        																	"statuscode"=>"ERR",
        																	"recipient_name"=>""
        																);
        											$json_resp =  json_encode($resp_arr);
                                                }	
    										}
    
    										else
    										{
    											
    											    $this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$charge_amount,$Description,$sub_txn_type,$remark,0);
                                                    
        											$resp_arr = array(
        																	"message"=>$message,
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
    																								$message,
    																							    "FAILURE",
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
		$this->loging("verify_bene",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	
	//https://staging.eko.co.in:25004/ekoapi/v1/customers/mobile_number:3000000026/recipients/acc_ifsc:32100000000_SBIN0008441
	
	public function add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$bank_code,$bank_id,$userinfo)
	{
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						
						$rsltinsert = $this->db->query("insert into mt3_beneficiary_register_temp(user_id,add_date,edit_date,ipaddress,remitterid,remitter_mobile,benificiary_name,benificiary_mobile,benificiary_ifsc,benificiary_account_no,status,API) values(?,?,?,?,?,?,?,?,?,?,?,?)",array(
							$user_id,$this->common->getDate(),$this->common->getDate(),$this->common->getRealIpAddr(),"",$mobile_no,$bene_name,$bene_name,$ifsc,$acc_no,"PENDING","EKO"
						));
						if($rsltinsert == true)
						{
							$insert_id = $this->db->insert_id();
							if($bank_code == "BKDN" or $bank_code == "UTBI" )
							{
							    $url ="https://api.eko.co.in:25002/ekoicici/v1/customers/mobile_number:".$mobile_no."/recipients/acc_bankcode:".$acc_no."_".$bank_code; 
							}
							else
							{
							    $url ="https://api.eko.co.in:25002/ekoicici/v1/customers/mobile_number:".$mobile_no."/recipients/acc_ifsc:".$acc_no."_".strtoupper($ifsc);    
							}
							
							$request = array(
							  'initiator_id' => $this->getinitiator_id(),
							  'recipient_name' =>$bene_name,
							  'recipient_mobile' =>$bene_mobile,
							  'bank_id' =>$bank_id,
							  'recipient_type' =>'3',
								
							);

							$ch = curl_init($url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
							curl_setopt($ch, CURLOPT_HTTPHEADER, array(
								'Accept: application/json',
								'developer_key: '.$this->getdeveloper_key()
							));
							curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));

							$buffer = $response = curl_exec($ch);
							$json_obj = json_decode($buffer);
							
						/*{"response_status_id":0,"data":{"initiator_id":"","recipient_mobile":"","recipient_id_type":"acc_bankcode","customer_id":"8238232303","pipes":{},"recipient_id":40699557},"response_type_id":43,"message":"Success!Please transact using Recipientid","status":0}*/
							
							if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
								
									$response_status_id = trim((string)$json_obj->response_status_id);
									$response_type_id = trim((string)$json_obj->response_type_id);
									$message = trim((string)$json_obj->message);
									$status = trim((string)$json_obj->status);
									$recipient_id = 0;
									if(isset($json_obj->data))
									{
										$data = $json_obj->data;	
									//	$recipient_id = $data->recipient_id;
									}
									if($status == "0")
									{
										$this->db->query("update mt3_beneficiary_register_temp set status = 'SUCCESS',RESP_statuscode=?,RESP_status=?,RESP_beneficiary_id=? where Id = ?",array($status,$message,$recipient_id,$insert_id));
									
										$this->load->model("Shootcase");
										$this->Shootcase->add_benificiary($mobile_no,$bene_name,$bene_mobile,$acc_no,$ifsc,$userinfo);
										$data =  $json_obj->data;
										$resp_arr = array(
																"message"=>$message,
																"status"=>0,
																"statuscode"=>$response_type_id,
																"data"=>$data,
															);
										$json_resp =  json_encode($resp_arr);
									}
								else
								{
									    $this->db->query("update mt3_beneficiary_register_temp set status = 'FAILED',RESP_statuscode=?,RESP_status=?,RESP_beneficiary_id=? where Id = ?",array($status,$message,"",$insert_id));
									    $data =  $json_obj->data;
										$resp_arr = array(
																"message"=>$message,
																"status"=>$status,
																"statuscode"=>$response_type_id,
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
		$this->loging("set_beneficiary",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	
	
	public function transfer($remittermobile,$beneficiaryid,$amount,$mode,$userinfo,$unique_id,$done_by = "WEB")
	{
		$remitter_id = $remittermobile;
		$mobile_no = $remittermobile;
		$postfields = '';
		$postparam = $remittermobile." <> ".$beneficiaryid." <> ".$amount." <> ".$mode;
		$buffer = "No Api Call";
		$url = "";
		if($amount < 10)
		{
		    $resp_arr = array(
									"message"=>"Invalid Amount",
									"status"=>1,
									"statuscode"=>"ERR",
								);
			$json_resp =  json_encode($resp_arr);
		}
		else
		{
		    if($mode == "IMPS")
    		{
    			$apimode = "2";
    		}
    		if($mode == "NEFT")
    		{
    			$apimode = "1";
    		}
    		
    		if($userinfo->row(0)->service == 'no' )
    	//if(false)
    		{
    		    $resp_arr = array(
    									"message"=>"Userinfo Missing",
    									"status"=>4,
    									"statuscode"=>"UNK",
    								);
    			$json_resp =  json_encode($resp_arr);
    		}
    		else
    		{
    		    if($userinfo != NULL )
        		{
        			if($userinfo->num_rows() == 1)
        			{
        				$url = '';
        				$user_id = $userinfo->row(0)->user_id;
        				$DId = $userinfo->row(0)->parentid;
        				$MdId = 0;
        				$usertype_name = $userinfo->row(0)->usertype_name;
        				$user_status = $userinfo->row(0)->status;
        				if($usertype_name == "Agent")
        				{
        					$parentinfo = $this->db->query("select * from tblusers where user_id = ?",array($DId));
        					if($parentinfo->num_rows() == 1)
        					{
        							$MdId = $parentinfo->row(0)->parentid;
        					}
        					if($user_status == '1')
        					{
        						
        						$crntBalance = $this->Common_methods->getAgentBalance($user_id);
        						if(floatval($crntBalance) >= floatval($amount) + 30)
        						{
        						
        								
        								$checkbeneexist = $this->db->query("select benificiary_name,benificiary_mobile,benificiary_ifsc,benificiary_account_no from mt3_beneficiary_register_temp 
        																	where remitterid = ? and RESP_beneficiary_id = ? and status = 'SUCCESS' and API = 'EKO' ",
        																	array($remittermobile,$beneficiaryid));
        							
        								if($checkbeneexist->num_rows() >= 1)
        								{
        									$benificiary_name = $checkbeneexist->row(0)->benificiary_name;
        									$benificiary_mobile = $checkbeneexist->row(0)->benificiary_mobile;
        									$benificiary_ifsc = $checkbeneexist->row(0)->benificiary_ifsc;
        									$benificiary_account_no = $checkbeneexist->row(0)->benificiary_account_no;
        									
        									
        									$chargeinfo = $this->getChargeValue($userinfo,$amount);
        									$dist_charge_type = "AMOUNT";
        									$dist_charge_value = "0";
        									$dist_charge_amount="0";
        
        
        
        
        
        
        									if($userinfo->row(0)->usertype_name == "APIUSER")
        									{
        										$Charge_type = "AMOUNT";
        										$charge_value = 4.5;
        										$Charge_Amount = 4.5;
        									}
        									else if($chargeinfo != false)
        									{
        										/////////////////////////////////////////////////
        										/////// RETAILER CHARGE CALCULATION
        										////////////////////////////////////////////////
        										$Charge_type = $chargeinfo->row(0)->charge_type;
        										$charge_value = $chargeinfo->row(0)->charge_value;
        										if($Charge_type == "PER")
        										{
        											$Charge_Amount = ((floatval($charge_value) * floatval($amount))/ 100); 
        										}
        										else
        										{
        											$Charge_Amount = $chargeinfo->row(0)->charge_value;	
        										}
        										$ccf = $chargeinfo->row(0)->ccf;	
        										$cashback = $chargeinfo->row(0)->cashback;	
        										$tds = $chargeinfo->row(0)->tds;
        
        										/////////////////////////////////////////////////
        										/////// DISTRIBUTOR CHARGE CALCULATION
        										////////////////////////////////////////////////
        										$dist_charge_type = $chargeinfo->row(0)->dist_charge_type;
        										$dist_charge_value = $chargeinfo->row(0)->dist_charge_value;
        										if($dist_charge_type == "PER")
        										{
        											$dist_charge_amount = ((floatval($dist_charge_value) * floatval($amount))/ 100); 
        										}
        										else
        										{
        											$dist_charge_amount = $chargeinfo->row(0)->dist_charge_value;	
        										}
        
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
        											add_date,ipaddress,user_id,DId,MdId,
        											Charge_type,
        											charge_value,
        											Charge_Amount,
        											dist_charge_type,
        											dist_charge_value,
        											dist_charge_amount,
        											RemiterMobile,
        											remitter_id,
        											BeneficiaryId,
        											AccountNumber,
        											IFSC,
        											Amount,
        											Status,
        											mode,unique_id,API,done_by,ccf,cashback,tds)
        											values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        											",array($this->common->getDate(),$this->common->getRealIpAddr(),$user_id,$DId,$MdId,
        											$Charge_type,$charge_value,$Charge_Amount,
        											$dist_charge_type,$dist_charge_value,$dist_charge_amount,
        											$remittermobile,$remitter_id,
        											$beneficiaryid,$benificiary_account_no,$benificiary_ifsc,
        											$amount,"PENDING",$mode,$unique_id,"EKO",$done_by,$ccf,$cashback,$tds
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
        											    
        											    
        											    $dohold = 'no';
        											    $rsltcommon = $this->db->query("select * from common where param = 'DMRHOLD'");
    												    if($rsltcommon->num_rows() == 1)
    												    {
    												        $is_hold = $rsltcommon->row(0)->value;
    												    	if($is_hold == 1)
    												    	{
    												    	    $dohold = 'yes';
    												    	}
    												    }
        											    
        												//if($mode == "NEFT")
        											    if($dohold == 'yes' and $mode == "NEFT")
        												{
        													$this->db->query("update mt3_transfer set Status = 'HOLD' where Id = ?",array($insert_id));
        													$resp_arr = array(
        																							"message"=>"Transaction Under Process",
        																							"status"=>0,
        																							"statuscode"=>"TXN",
        																						);
        													$json_resp =  json_encode($resp_arr);
        												}
        												else
        												{
        												     $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));
            												$initiator_id = $this->getinitiator_id();
            												$developer_key= $this->getdeveloper_key();
            												$url = 'https://api.eko.co.in:25002/ekoicici/v1/transactions';
            												
            												
            												$postfields = "initiator_id=".$initiator_id."&customer_id=".$mobile_no."&recipient_id=".$beneficiaryid."&amount=".$amount."&channel=".$apimode."&state=1&timestamp=".$timestamp."&currency=INR&hold_timeout=&merchant_document_id_type=1&merchant_document_id=AAFCC5212L&pincode=360005&latlong=22.3039,70.8022,500&client_ref_id=".$insert_id;
            												
            												
            												
            												 $ch = curl_init();
            												curl_setopt($ch, CURLOPT_HEADER, false);
            												curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            												curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
            												curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            												curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            													'Accept: application/json',
            													'developer_key: '.$this->getdeveloper_key()
            												));
            												curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            												curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            												curl_setopt($ch, CURLOPT_POST,1);
            												curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            												//channel 2 = imps
            												//channel 1 = neft
            												
            												
            												//state
            												//1 - Commit, 2- Hold ( Send the value as 1 if you want to directly commit the transaction)
            												
            												
            												curl_setopt($ch, CURLOPT_URL, $url);
            												$buffer = $response = $buffer = curl_exec($ch);
            												curl_close($ch);
            
            												$json_obj = json_decode($buffer);
            												/*
            												{"response_status_id":1,"data":{"last_used_okekey":""},"response_type_id":477,"message":"Failed!bank not live on imps","status":477}
            												*/
            													if(isset($json_obj->response_status_id) and isset($json_obj->data) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
            													{
            															$response_status_id = $json_obj->response_status_id;
            															$status = $json_obj->status;
            															$response_type_id = $json_obj->response_type_id;
            															$data = $json_obj->data;
            															$message = $json_obj->message;
            
            															if(isset($data->tx_status) and isset($data->txstatus_desc))
            															{
            																$tx_status = trim((string)$data->tx_status);
            																$txstatus_desc = trim((string)$data->txstatus_desc);
            																$tid = trim((string)$data->tid);
            
            																$client_ref_id = trim((string)$data->client_ref_id);
            																$bank_ref_num = trim((string)$data->bank_ref_num);
            																$RESP_amount = trim((string)$data->amount);
            
            
            
            																if($txstatus_desc == "Response Awaited")
            																{
            
            																	$fee = trim((string)$data->fee);
            																	$collectable_amount = trim((string)$data->collectable_amount);
            																	$utility_acc_no = trim((string)$data->utility_acc_no);
            																	$sender_name = trim((string)$data->sender_name);
            																	$balance = trim((string)$data->balance);
            																	$recipient_name = trim((string)$data->recipient_name);
            																	$data = array(
            																				'RESP_statuscode' => "TUP",
            																				'RESP_status' => $txstatus_desc,
            																				'RESP_ipay_id' => $tid,
            																				'RESP_ref_no' => $client_ref_id,
            																				'RESP_opr_id' => $bank_ref_num,
            																				'RESP_name' => $recipient_name,
            																				'RESP_opening_bal' => $balance,
            																				'RESP_amount' => $RESP_amount,
            																				'RESP_locked_amt' => "",
            																				'tx_status'=>$tx_status,
            																				"row_lock"=>"OPEN",
            																				'Status'=>'PENDING',
            																				'edit_date'=>$this->common->getDate()
            																		);
            
            																		$this->db->where('Id', $insert_id);
            																		$this->db->update('mt3_transfer', $data);
            																		$resp_arr = array(
            																							"message"=>"Transaction Under Process Ref Id :".$txstatus_desc,
            																							"status"=>0,
            																							"data"=>array(
            																								"tid"=>$tid,
            																								"ref_no"=>$client_ref_id,
            																								"opr_id"=>$opr_id,
            																								"name"=>$recipient_name,
            																								"balance"=>$balance,
            																								"amount"=>$RESP_amount,
            
            																							)
            																						);
            																		$json_resp =  json_encode($resp_arr);	
            
            																}
            																else if($txstatus_desc == "Success")
            																{
            
            
            																	$fee = trim((string)$data->fee);
            																	$collectable_amount = trim((string)$data->collectable_amount);
            																	$utility_acc_no = trim((string)$data->utility_acc_no);
            																	$sender_name = trim((string)$data->sender_name);
            																	$balance = trim((string)$data->balance);
            																	$recipient_name = trim((string)$data->recipient_name);
            																	$data = array(
            																				'RESP_statuscode' => "TUP",
            																				'RESP_status' => $txstatus_desc,
            																				'RESP_ipay_id' => $tid,
            																				'RESP_ref_no' => $client_ref_id,
            																				'RESP_opr_id' => $bank_ref_num,
            																				'RESP_name' => $recipient_name,
            																				'RESP_opening_bal' => $balance,
            																				'RESP_amount' => $RESP_amount,
            																				'RESP_locked_amt' => "",
            																				'tx_status'=>$tx_status,
            																				"row_lock"=>"LOCKED",
            																				'Status'=>'SUCCESS',
            																				'edit_date'=>$this->common->getDate()
            																		);
            
            																		$this->db->where('Id', $insert_id);
            																		$this->db->update('mt3_transfer', $data);
            																		
            																		
            																		$this->COMMISSIONPAYMENT_CREDIT_ENTRY($DId,$insert_id,$transaction_type,$dist_charge_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00);
            																		$resp_arr = array(
            																							"message"=>$txstatus_desc,
            																							"status"=>0,
            																							"data"=>array(
            																								"tid"=>$tid,
            																								"ref_no"=>$client_ref_id,
            																								"opr_id"=>$tid,
            																								"name"=>$recipient_name,
            																								"balance"=>$balance,
            																								"amount"=>$RESP_amount,
            
            																							)
            																						);
            																		$json_resp =  json_encode($resp_arr);
            
            																}
            																else if($txstatus_desc == "Initiated")
            																{
            
            
            																	$fee = trim((string)$data->fee);
            																	$collectable_amount = trim((string)$data->collectable_amount);
            																	$utility_acc_no = trim((string)$data->utility_acc_no);
            																	$sender_name = trim((string)$data->sender_name);
            																	$balance = trim((string)$data->balance);
            																	$recipient_name = trim((string)$data->recipient_name);
            																	$data = array(
            																				'RESP_statuscode' => "TUP",
            																				'RESP_status' => $txstatus_desc,
            																				'RESP_ipay_id' => $tid,
            																				'RESP_ref_no' => $client_ref_id,
            																				'RESP_opr_id' => $bank_ref_num,
            																				'RESP_name' => $recipient_name,
            																				'RESP_opening_bal' => $balance,
            																				'RESP_amount' => $RESP_amount,
            																				'RESP_locked_amt' => "",
            																				'tx_status'=>$tx_status,
            																				
            																				'Status'=>'PENDING',
            																				'edit_date'=>$this->common->getDate()
            																		);
            
            																		$this->db->where('Id', $insert_id);
            																		$this->db->update('mt3_transfer', $data);
            																		$resp_arr = array(
            																							"message"=>$txstatus_desc,
            																							"status"=>0,
            																							"data"=>array(
            																								"tid"=>$tid,
            																								"ref_no"=>$client_ref_id,
            																								"opr_id"=>$tid,
            																								"name"=>$recipient_name,
            																								"balance"=>$balance,
            																								"amount"=>$RESP_amount,
            
            																							)
            																						);
            																		$json_resp =  json_encode($resp_arr);
            
            																}
            																else if($txstatus_desc == "Failed")
            																{
            																	
            																	$reason = trim((string)$data->reason);
            																	
            																	if($tx_status == "1")
            																	{
            																		$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
            																	}
            																	
            
            																	$data = array(
            																			'RESP_statuscode' => $statuscode,
            																			'RESP_status' => $reason,
            																			'tx_status'=>$tx_status,
            																			'Status'=>'FAILURE',
            																			"row_lock"=>"LOCKED",
            																			'edit_date'=>$this->common->getDate()
            																	);
            
            																	$this->db->where('Id', $insert_id);
            																	$this->db->update('mt3_transfer', $data);
            																	$resp_arr = array(
            																							"message"=>$reason,
            																							"status"=>1,
            																							"statuscode"=>$statuscode,
            																						);
            																	$json_resp =  json_encode($resp_arr);
            
            																}
            																else
            																{
             
            
            																	$data = array(
            																				"message"=>$reason,
            																				'RESP_statuscode' => "UNK",
            																				'RESP_status' => "Unknown Response",
            																				'status'=>'PENDING',
            																				'statuscode'=>$statuscode,
            																				'tx_status'=>$tx_status,
            																				'edit_date'=>$this->common->getDate()
            																	);
            
            																	$this->db->where('Id', $insert_id);
            																	$this->db->update('mt3_transfer', $data);
            																	$resp_arr = array(
            																							"message"=>"Unknown Response",
            																							"status"=>2,
            																							"statuscode"=>"UNK",
            																						);
            																	$json_resp =  json_encode($resp_arr);
            
            																}
            															}
            															else if($status == "544" or $status == "577")
            															{
             																	$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
            																	$data = array(
            																			'RESP_statuscode' => $status,
            																			'RESP_status' => $message,
            																			'Status'=>'FAILURE',
            																			"row_lock"=>"LOCKED",
            																			'edit_date'=>$this->common->getDate()
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
            															else if($status == "592")
            															{
             																	$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
            																	$data = array(
            																			'RESP_statuscode' => $status,
            																			'RESP_status' => $message,
            																			'Status'=>'FAILURE',
            																			"row_lock"=>"LOCKED",
            																			'edit_date'=>$this->common->getDate()
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
            
            
            													}
            													else if(isset($json_obj->response_status_id) and isset($json_obj->invalid_params) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
            													{
            													    $response_status_id = $json_obj->response_status_id;
            															$status = $json_obj->status;
            															$response_type_id = $json_obj->response_type_id;
            															$invalid_params = $json_obj->invalid_params;
            															$message = $json_obj->message;
            															if($response_status_id == '1' and $status == '314')
            															{
            															    $reason = $message;
            																$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
            																
            																	$data = array(
            																			'RESP_statuscode' => "ERR",
            																			'RESP_status' => $reason,
            																			'tx_status'=>2,
            																			'Status'=>'FAILURE',
            																			"row_lock"=>"LOCKED",
            																			'edit_date'=>$this->common->getDate()
            																	);
            
            																	$this->db->where('Id', $insert_id);
            																	$this->db->update('mt3_transfer', $data);
            																	
            																	$this->remitter_details2($mobile_no,$userinfo);
            																	
            																	$this->load->model("Shootcase");
										                                        $this->Shootcase->add_benificiary($mobile_no,$benificiary_name,$mobile_no,$benificiary_account_no,$benificiary_ifsc,$userinfo);
            																	$resp_arr = array(
            																							"message"=>$reason,
            																							"status"=>1,
            																							"statuscode"=>"ERR",
            																						);
            																	$json_resp =  json_encode($resp_arr);
            															}
            													}
            													else if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
            													{
            													    $response_status_id = $json_obj->response_status_id;
            															$status = $json_obj->status;
            															$response_type_id = $json_obj->response_type_id;
            															$message = $json_obj->message;
            															if($response_status_id == '1' and $status == '477')
            															{
            															    $reason = $message;
            																$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
            																
            																	$data = array(
            																			'RESP_statuscode' => "ERR",
            																			'RESP_status' => $reason,
            																			'tx_status'=>2,
            																			'Status'=>'FAILURE',
            																			"row_lock"=>"LOCKED",
            																			'edit_date'=>$this->common->getDate()
            																	);
            
            																	$this->db->where('Id', $insert_id);
            																	$this->db->update('mt3_transfer', $data);
            																	
            																	$this->remitter_details2($mobile_no,$userinfo);
            																	
            																	$this->load->model("Shootcase");
										                                        $this->Shootcase->add_benificiary($mobile_no,$benificiary_name,$mobile_no,$benificiary_account_no,$benificiary_ifsc,$userinfo);
            																	
            																	$resp_arr = array(
            																							"message"=>$reason,
            																							"status"=>1,
            																							"statuscode"=>"ERR",
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
            																			'RESP_status' => "Unknown Response or No Response",
            																			'edit_date'=>$this->common->getDate()
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
        											}
        											else
        											{
        											    	$data = array(
        																			'RESP_statuscode' => "ERR",
        																			'RESP_status' => "PAYMENT FAILURE",
        																			'tx_status'=>"1",
        																			'Status'=>'FAILURE',
        																			"row_lock"=>"LOCKED",
        																			'edit_date'=>$this->common->getDate()
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
    		}   
		}
		$this->loging("ekotransfer",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
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
					
					
					$this->db->query("update mt3_transfer set Status = 'PENDING' where Id = ?",array($Id));
					
					$timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));
    				$initiator_id = $this->getinitiator_id();
    				$developer_key= $this->getdeveloper_key();
    				$url = 'https://api.eko.co.in:25002/ekoicici/v1/transactions';
    				
    				
    				$postfields = "initiator_id=".$initiator_id."&customer_id=".$mobile_no."&recipient_id=".$beneficiaryid."&amount=".$amount."&channel=".$apimode."&state=1&timestamp=".$timestamp."&currency=INR&hold_timeout=&merchant_document_id_type=1&merchant_document_id=AAFCC5212L&pincode=360005&latlong=22.3039,70.8022,500&client_ref_id=".$insert_id;
    				
    				
    				
    				 $ch = curl_init();
    				curl_setopt($ch, CURLOPT_HEADER, false);
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    				curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
    				curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    					'Accept: application/json',
    					'developer_key: '.$this->getdeveloper_key()
    				));
    				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    				curl_setopt($ch, CURLOPT_POST,1);
    				curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
					//channel 2 = imps
					//channel 1 = neft
					
					
					//state
					//1 - Commit, 2- Hold ( Send the value as 1 if you want to directly commit the transaction)
					
					
					curl_setopt($ch, CURLOPT_URL, $url);
					$buffer = $response = $buffer = curl_exec($ch);
					curl_close($ch);

					$json_obj = json_decode($buffer);
    												
					if(isset($json_obj->response_status_id) and isset($json_obj->data) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
					{
							$response_status_id = $json_obj->response_status_id;
							$status = $json_obj->status;
							$response_type_id = $json_obj->response_type_id;
							$data = $json_obj->data;
							$message = $json_obj->message;

							if(isset($data->tx_status) and isset($data->txstatus_desc))
							{
								$tx_status = trim((string)$data->tx_status);
								$txstatus_desc = trim((string)$data->txstatus_desc);
								$tid = trim((string)$data->tid);

								$client_ref_id = trim((string)$data->client_ref_id);
								$bank_ref_num = trim((string)$data->bank_ref_num);
								$RESP_amount = trim((string)$data->amount);



								if($txstatus_desc == "Response Awaited")
								{

									$fee = trim((string)$data->fee);
									$collectable_amount = trim((string)$data->collectable_amount);
									$utility_acc_no = trim((string)$data->utility_acc_no);
									$sender_name = trim((string)$data->sender_name);
									$balance = trim((string)$data->balance);
									$recipient_name = trim((string)$data->recipient_name);
									$data = array(
												'RESP_statuscode' => "TUP",
												'RESP_status' => $txstatus_desc,
												'RESP_ipay_id' => $tid,
												'RESP_ref_no' => $client_ref_id,
												'RESP_opr_id' => $bank_ref_num,
												'RESP_name' => $recipient_name,
												'RESP_opening_bal' => $balance,
												'RESP_amount' => $RESP_amount,
												'RESP_locked_amt' => "",
												'tx_status'=>$tx_status,
												"row_lock"=>"OPEN",
												'Status'=>'PENDING',
												'edit_date'=>$this->common->getDate()
										);

										$this->db->where('Id', $insert_id);
										$this->db->update('mt3_transfer', $data);
										$resp_arr = array(
															"message"=>"Transaction Under Process Ref Id :".$txstatus_desc,
															"status"=>0,
															"data"=>array(
																"tid"=>$tid,
																"ref_no"=>$client_ref_id,
																"opr_id"=>$opr_id,
																"name"=>$recipient_name,
																"balance"=>$balance,
																"amount"=>$RESP_amount,

															)
														);
										$json_resp =  json_encode($resp_arr);	

								}
								else if($txstatus_desc == "Success")
								{


									$fee = trim((string)$data->fee);
									$collectable_amount = trim((string)$data->collectable_amount);
									$utility_acc_no = trim((string)$data->utility_acc_no);
									$sender_name = trim((string)$data->sender_name);
									$balance = trim((string)$data->balance);
									$recipient_name = trim((string)$data->recipient_name);
									$data = array(
												'RESP_statuscode' => "TUP",
												'RESP_status' => $txstatus_desc,
												'RESP_ipay_id' => $tid,
												'RESP_ref_no' => $client_ref_id,
												'RESP_opr_id' => $bank_ref_num,
												'RESP_name' => $recipient_name,
												'RESP_opening_bal' => $balance,
												'RESP_amount' => $RESP_amount,
												'RESP_locked_amt' => "",
												'tx_status'=>$tx_status,
												"row_lock"=>"LOCKED",
												'Status'=>'SUCCESS',
												'edit_date'=>$this->common->getDate()
										);

										$this->db->where('Id', $insert_id);
										$this->db->update('mt3_transfer', $data);
										
										
										//$this->COMMISSIONPAYMENT_CREDIT_ENTRY($DId,$insert_id,$transaction_type,$dist_charge_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00);
										$resp_arr = array(
															"message"=>$txstatus_desc,
															"status"=>0,
															"data"=>array(
																"tid"=>$tid,
																"ref_no"=>$client_ref_id,
																"opr_id"=>$tid,
																"name"=>$recipient_name,
																"balance"=>$balance,
																"amount"=>$RESP_amount,

															)
														);
										$json_resp =  json_encode($resp_arr);

								}
								else if($txstatus_desc == "Initiated")
								{


									$fee = trim((string)$data->fee);
									$collectable_amount = trim((string)$data->collectable_amount);
									$utility_acc_no = trim((string)$data->utility_acc_no);
									$sender_name = trim((string)$data->sender_name);
									$balance = trim((string)$data->balance);
									$recipient_name = trim((string)$data->recipient_name);
									$data = array(
												'RESP_statuscode' => "TUP",
												'RESP_status' => $txstatus_desc,
												'RESP_ipay_id' => $tid,
												'RESP_ref_no' => $client_ref_id,
												'RESP_opr_id' => $bank_ref_num,
												'RESP_name' => $recipient_name,
												'RESP_opening_bal' => $balance,
												'RESP_amount' => $RESP_amount,
												'RESP_locked_amt' => "",
												'tx_status'=>$tx_status,
												
												'Status'=>'PENDING',
												'edit_date'=>$this->common->getDate()
										);

										$this->db->where('Id', $insert_id);
										$this->db->update('mt3_transfer', $data);
										$resp_arr = array(
															"message"=>$txstatus_desc,
															"status"=>0,
															"data"=>array(
																"tid"=>$tid,
																"ref_no"=>$client_ref_id,
																"opr_id"=>$tid,
																"name"=>$recipient_name,
																"balance"=>$balance,
																"amount"=>$RESP_amount,

															)
														);
										$json_resp =  json_encode($resp_arr);

								}
								else if($txstatus_desc == "Failed")
								{
									
									$reason = trim((string)$data->reason);
									
									if($tx_status == "1")
									{
									    $transaction_type = "DMR";
										$dr_amount = $amount;
										$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
										$sub_txn_type = "REMITTANCE";
										$remark = "Money Remittance";
									    
										$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
									}
									

									$data = array(
											'RESP_statuscode' => $statuscode,
											'RESP_status' => $reason,
											'tx_status'=>$tx_status,
											'Status'=>'FAILURE',
											"row_lock"=>"LOCKED",
											'edit_date'=>$this->common->getDate()
									);

									$this->db->where('Id', $insert_id);
									$this->db->update('mt3_transfer', $data);
									$resp_arr = array(
															"message"=>$reason,
															"status"=>1,
															"statuscode"=>$statuscode,
														);
									$json_resp =  json_encode($resp_arr);

								}
								else
								{


									$data = array(
												"message"=>$reason,
												'RESP_statuscode' => "UNK",
												'RESP_status' => "Unknown Response",
												'status'=>'PENDING',
												'statuscode'=>$statuscode,
												'tx_status'=>$tx_status,
												'edit_date'=>$this->common->getDate()
									);

									$this->db->where('Id', $insert_id);
									$this->db->update('mt3_transfer', $data);
									$resp_arr = array(
															"message"=>"Unknown Response",
															"status"=>2,
															"statuscode"=>"UNK",
														);
									$json_resp =  json_encode($resp_arr);

								}
							}
							else if($status == "544")
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
											'Status'=>'FAILURE',
											"row_lock"=>"LOCKED",
											'edit_date'=>$this->common->getDate()
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
							else if($status == "592")
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
											'Status'=>'FAILURE',
											"row_lock"=>"LOCKED",
											'edit_date'=>$this->common->getDate()
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


					}
					else if(isset($json_obj->response_status_id) and isset($json_obj->invalid_params) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
					{
					    $response_status_id = $json_obj->response_status_id;
							$status = $json_obj->status;
							$response_type_id = $json_obj->response_type_id;
							$invalid_params = $json_obj->invalid_params;
							$message = $json_obj->message;
							if($response_status_id == '1' and $status == '314')
							{
							     $transaction_type = "DMR";
								$dr_amount = $amount;
								$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
								$sub_txn_type = "REMITTANCE";
								$remark = "Money Remittance";
							    $reason = $message;
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
								
									$data = array(
											'RESP_statuscode' => "ERR",
											'RESP_status' => $reason,
											'tx_status'=>2,
											'Status'=>'FAILURE',
											"row_lock"=>"LOCKED",
											'edit_date'=>$this->common->getDate()
									);

									$this->db->where('Id', $insert_id);
									$this->db->update('mt3_transfer', $data);
									$resp_arr = array(
															"message"=>$reason,
															"status"=>1,
															"statuscode"=>"ERR",
														);
									$json_resp =  json_encode($resp_arr);
							}
					}
					else if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
					{
					    $response_status_id = $json_obj->response_status_id;
							$status = $json_obj->status;
							$response_type_id = $json_obj->response_type_id;
							$message = $json_obj->message;
							if($response_status_id == '1' and $status == '477')
							{
							     $transaction_type = "DMR";
										$dr_amount = $amount;
										$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
										$sub_txn_type = "REMITTANCE";
										$remark = "Money Remittance";
							    $reason = $message;
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
								
									$data = array(
											'RESP_statuscode' => "ERR",
											'RESP_status' => $reason,
											'tx_status'=>2,
											'Status'=>'FAILURE',
											"row_lock"=>"LOCKED",
											'edit_date'=>$this->common->getDate()
									);

									$this->db->where('Id', $insert_id);
									$this->db->update('mt3_transfer', $data);
									$resp_arr = array(
															"message"=>$reason,
															"status"=>1,
															"statuscode"=>"ERR",
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
											'RESP_status' => "Unknown Response or No Response",
											'edit_date'=>$this->common->getDate()
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
		$this->loging("eko_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	
	
	public function transfer_status($dmr_id)
	{
	    
	    
	    $rsltdmrslave = $this->db->query("select * from common where param = 'DMTSLAVE'");
		if($rsltdmrslave->num_rows() == 1)
		{
			$dmrslave = $rsltdmrslave->row(0)->value;
		}
		
		if($dmrslave == "UP")
		{
		    $otherdb = $this->load->database('otherdb', TRUE); 
		    $resultdmr = $otherdb->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.dist_charge_amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where a.Id = ?",array($dmr_id));
		}
		else
		{
		    $resultdmr = $this->db->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.dist_charge_amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where a.Id = ?",array($dmr_id));
		}
		
		
		if($resultdmr->num_rows() == 1)
		{
			$Status = $resultdmr->row(0)->Status;
			$user_id = $resultdmr->row(0)->user_id;
			$DId = $resultdmr->row(0)->DId;
			$API = $resultdmr->row(0)->API;
			$RESP_status = $resultdmr->row(0)->RESP_status;
			$Amount = $resultdmr->row(0)->Amount;
			$debit_amount = $resultdmr->row(0)->debit_amount;
			if($debit_amount < $Amount)
			{
			    echo "some problem found";exit;
			}
			
			$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
			$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
			$remittermobile = $resultdmr->row(0)->RemiterMobile;
			
			$dist_charge_amount= $resultdmr->row(0)->dist_charge_amount;
			$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
			$sub_txn_type = "REMITTANCE";
			$remark = "Money Remittance";
			if($API == "EKO")
			{
				
				if($Status == "PENDING" )
				{
					$url = "https://api.eko.co.in:25002/ekoicici/v1/transactions/client_ref_id:".$dmr_id."?initiator_id=" . $this->getinitiator_id();	
			        
	
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
					curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Accept: application/json',
						'developer_key: '.$this->getdeveloper_key()
					));
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_URL, $url);
					$response = curl_exec($ch);
					curl_close($ch);
					//echo $response;exit;
					/*
					{"response_status_id":1,
					"invalid_params":{"tid":"please provide the valid TId."},
					"response_type_id":-1,"message":"No Transaction found in the system","status":69}
					*/
					$this->loging("ekotransfer_status",$url,$response,"","");
					$json_obj = json_decode($response);
					
				  
					if(isset($json_obj->response_status_id))
					{
						$response_status_id = $json_obj->response_status_id;
						if($response_status_id == 0)
						{
							
							if(isset($json_obj->data))
							{
								$data = $json_obj->data;
								if(isset($data->tx_status) and isset($data->amount) and  isset($data->txstatus_desc) and isset($data->tds) and isset($data->fee) and isset($data->tds) and isset($data->tid) and isset($data->tx_desc) and isset($data->client_ref_id) and isset($data->service_tax) and isset($data->commission)  and isset($data->customer_id) and isset($data->bank_ref_num) and isset($data->recipient_id))
								{
									$tx_status = $data->tx_status;
									$amount = $data->amount;
									$txstatus_desc = $data->txstatus_desc;
									$tds = $data->tds;
									$fee = $data->fee;
									$tds = $data->tds;
									$tid = $data->tid;
									$tx_desc = $data->tx_desc;
									$client_ref_id = $data->client_ref_id;
									$service_tax = $data->service_tax;
									$commission = $data->commission;
									$bank_ref_num = $data->bank_ref_num;
									$recipient_id = $data->recipient_id;
									
									/*
									
0 Success
1 Fail
2 Response Awaited/Initiated (in case of NEFT)
3 Refund Pending
4 Refunded 
5 Hold ( Please re-inquiry)
									*/
									
									if($tx_status == "0")
									{
										if($txstatus_desc == "Success")
										{
											$data = array(
												'RESP_statuscode' => "TXN",
												'RESP_status' => $txstatus_desc,
												'RESP_ipay_id' => $tid,
												'RESP_ref_no' => $client_ref_id,
												'RESP_opr_id' => $bank_ref_num,
												'RESP_name' => "",
												'RESP_opening_bal' => "",
												'RESP_amount' => $amount,
												'RESP_locked_amt' => "",
												'tx_status'=>$tx_status,
												"row_lock"=>"LOCKED",
												'Status'=>'SUCCESS'
										);

											$this->db->where('Id', $dmr_id);
											$this->db->update('mt3_transfer', $data);
											
											
											$transaction_type = "DMR";
											$this->COMMISSIONPAYMENT_CREDIT_ENTRY($DId,$dmr_id,$transaction_type,$dist_charge_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00);
											
											$resparray = array(
											"message"=>"Transaction Success Bank Ref Id : ".$bank_ref_num,
											"status"=>0,
											);
											return json_encode($resparray);
										}
									}
									else if($tx_status == "1")
									{
										if($txstatus_desc == "Failed")
										{
										   if($tx_status == "1")
											{
											    $transaction_type = "DMR";
												$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
											}
											

											$data = array(
													'RESP_statuscode' => "RF",
													'RESP_status' => "Transaction Failed",
													'tx_status'=>$tx_status,
													'Status'=>'FAILURE',
													"row_lock"=>"LOCKED",
											);

											$this->db->where('Id', $dmr_id);
											$this->db->update('mt3_transfer', $data);
											//return $client_ref_id."  ".$txstatus_desc." Bank Ref Id : ".$bank_ref_num;
											$resparray = array(
											"message"=>"Transaction Filed .".$txstatus_desc,
											"status"=>1,
											);
											return json_encode($resparray);
										}
									}
									else if($tx_status == "3")
									{
										
										if($txstatus_desc == "Refund Pending")
										{
										   
										

											$data = array(
													'RESP_statuscode' => "PRF",
													'RESP_status' => "Refund Pending",
													'RESP_ipay_id' => $tid,
													'tx_status'=>$tx_status,
													'Status'=>'PENDING',
													"row_lock"=>"OPEN",
											);

											$this->db->where('Id', $dmr_id);
											$this->db->update('mt3_transfer', $data);
											
											$resparray = array(
											"message"=>"Transaction Filed .".$txstatus_desc,
											"status"=>3,
											);
											return json_encode($resparray);
											
										}
									}
									else if($tx_status == "2")
									{
										$resparray = array(
											"message"=>"Transaction Initiated",
											"status"=>2,
										);
										return json_encode($resparray);
											
										
									}
									else if($tx_status == "4")
									{
										if($txstatus_desc == "Failed" or $txstatus_desc == "Refunded")
										{
										   
											    $transaction_type = "DMR";
												$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
										
											

											$data = array(
													'RESP_statuscode' => "RF",
													'RESP_status' => "Transaction Failed",
													'tx_status'=>$tx_status,
													'Status'=>'FAILURE',
													"row_lock"=>"LOCKED",
											);

											$this->db->where('Id', $dmr_id);
											$this->db->update('mt3_transfer', $data);
											//return $client_ref_id."  ".$txstatus_desc." Bank Ref Id : ".$bank_ref_num;
											$resparray = array(
											"message"=>"Transaction Filed .".$txstatus_desc,
											"status"=>1,
											);
											return json_encode($resparray);
										}
									}




								}
								else
								{
								    print_r($json_obj);
								}
							}
							else
							{
								print_r($json_obj);
							}

						}
						else if($response_status_id == 1)
						{
						    if($json_obj->status == "69") 
						    {
						        
							    $transaction_type = "DMR";
								$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
								$data = array(
										'RESP_statuscode' => "RF",
										'RESP_status' => "Transaction Failed",
										'tx_status'=>"Transaction Failed",
										'Status'=>'FAILURE',
										"row_lock"=>"LOCKED",
								);

								$this->db->where('Id', $dmr_id);
								$this->db->update('mt3_transfer', $data);
								//return $client_ref_id."  ".$txstatus_desc." Bank Ref Id : ".$bank_ref_num;
								$resparray = array(
								"message"=>"Transaction Filed .".$json_obj->message,
								"status"=>1,
								);
								return json_encode($resparray);
						    }
						}
						else
						{
							print_r($json_obj);
						}
					}
					else
					{
					    print_r(	$json_obj);
					}
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
		else
		{
		    $resultdmr = $this->db->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.dist_charge_amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM masterpa_archive.mt3_transfer a
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
			$Amount = $resultdmr->row(0)->Amount;
			$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
			$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
			$remittermobile = $resultdmr->row(0)->RemiterMobile;
			
			$dist_charge_amount= $resultdmr->row(0)->dist_charge_amount;
			$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
			$sub_txn_type = "REMITTANCE";
			$remark = "Money Remittance";
			if($API == "EKO")
			{
				
				if($Status == "PENDING" )
				{
					$url = "https://api.eko.co.in:25002/ekoicici/v1/transactions/client_ref_id:".$dmr_id."?initiator_id=" . $this->getinitiator_id();	
			        
	
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
					curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'Accept: application/json',
						'developer_key: '.$this->getdeveloper_key()
					));
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_URL, $url);
					$response = curl_exec($ch);
					curl_close($ch);
					//echo $response;exit;
					/*
					{"response_status_id":1,
					"invalid_params":{"tid":"please provide the valid TId."},
					"response_type_id":-1,"message":"No Transaction found in the system","status":69}
					*/
					$this->loging("ekotransfer_status",$url,$response,"","");
					$json_obj = json_decode($response);
					
				  
					if(isset($json_obj->response_status_id))
					{
						$response_status_id = $json_obj->response_status_id;
						if($response_status_id == 0)
						{
							
							if(isset($json_obj->data))
							{
								$data = $json_obj->data;
								if(isset($data->tx_status) and isset($data->amount) and  isset($data->txstatus_desc) and isset($data->tds) and isset($data->fee) and isset($data->tds) and isset($data->tid) and isset($data->tx_desc) and isset($data->client_ref_id) and isset($data->service_tax) and isset($data->commission)  and isset($data->customer_id) and isset($data->bank_ref_num) and isset($data->recipient_id))
								{
									$tx_status = $data->tx_status;
									$amount = $data->amount;
									$txstatus_desc = $data->txstatus_desc;
									$tds = $data->tds;
									$fee = $data->fee;
									$tds = $data->tds;
									$tid = $data->tid;
									$tx_desc = $data->tx_desc;
									$client_ref_id = $data->client_ref_id;
									$service_tax = $data->service_tax;
									$commission = $data->commission;
									$bank_ref_num = $data->bank_ref_num;
									$recipient_id = $data->recipient_id;
									
									/*
									
0 Success
1 Fail
2 Response Awaited/Initiated (in case of NEFT)
3 Refund Pending
4 Refunded 
5 Hold ( Please re-inquiry)
									*/
									
									if($tx_status == "0")
									{
										if($txstatus_desc == "Success")
										{
										    
										    $this->db->query("
										    update 
										    masterpa_archive.mt3_transfer 
										    set 
										        RESP_statuscode = 'TXN',
												RESP_status = ?,
												RESP_ipay_id = ?,
												RESP_ref_no = ?,
												RESP_opr_id = ?,
												RESP_name = '',
												RESP_opening_bal = '',
												RESP_amount = ?,
												RESP_locked_amt = '',
												tx_status=?,
												row_lock='LOCKED',
												Status='SUCCESS' where Id = ?
										    
										    
										    ",array($txstatus_desc,$tid,$client_ref_id,$bank_ref_num,$amount,$tx_status,$dmr_id));
											
											$transaction_type = "DMR";
											$this->COMMISSIONPAYMENT_CREDIT_ENTRY($DId,$dmr_id,$transaction_type,$dist_charge_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00);
											
											$resparray = array(
											"message"=>"Transaction Success Bank Ref Id : ".$bank_ref_num,
											"status"=>0,
											);
											return json_encode($resparray);
										}
									}
									else if($tx_status == "1")
									{
										if($txstatus_desc == "Failed")
										{
										   if($tx_status == "1")
											{
											    $transaction_type = "DMR";
												$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
											}
											
											
											$this->db->query("
										    update 
										    masterpa_archive.mt3_transfer 
										    set 
										        RESP_statuscode = 'RF',
												RESP_status = ?,
												tx_status=?,
												row_lock='LOCKED',
												Status='FAILURE' where Id = ?
										    
										    
										    ",array("Transaction Failed",$tx_status,$dmr_id));

											
											$resparray = array(
											"message"=>"Transaction Filed .".$txstatus_desc,
											"status"=>1,
											);
											return json_encode($resparray);
										}
									}
									else if($tx_status == "3")
									{
										
										if($txstatus_desc == "Refund Pending")
										{
										   
										
                                            $this->db->query("
										    update 
										    masterpa_archive.mt3_transfer 
										    set 
										        RESP_statuscode = 'PRF',
												RESP_status = 'Refund Pending',
												RESP_ipay_id = ?
												tx_status=?,
												row_lock='OPEN',
												Status='PENDING' where Id = ?
										    
										    
										    ",array($tid,$tx_status,$dmr_id));
											
											$resparray = array(
											"message"=>"Transaction Filed .".$txstatus_desc,
											"status"=>3,
											);
											return json_encode($resparray);
											
										}
									}
									else if($tx_status == "2")
									{
										$resparray = array(
											"message"=>"Transaction Initiated",
											"status"=>2,
										);
										return json_encode($resparray);
											
										
									}
									else if($tx_status == "4")
									{
										if($txstatus_desc == "Failed" or $txstatus_desc == "Refunded")
										{
										   
											    $transaction_type = "DMR";
												$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
										
											

											$this->db->query("
										    update 
										    masterpa_archive.mt3_transfer 
										    set 
										        RESP_statuscode = 'RF',
												RESP_status = ?,
												tx_status=?,
												row_lock='LOCKED',
												Status='FAILURE' where Id = ?
										    
										    
										    ",array("Transaction Failed",$tx_status,$dmr_id));
											//return $client_ref_id."  ".$txstatus_desc." Bank Ref Id : ".$bank_ref_num;
											$resparray = array(
											"message"=>"Transaction Filed .".$txstatus_desc,
											"status"=>1,
											);
											return json_encode($resparray);
										}
									}




								}
								else
								{
								    print_r($json_obj);
								}
							}
							else
							{
								print_r($json_obj);
							}

						}
						else if($response_status_id == 1)
						{
						    if($json_obj->status == "69") 
						    {
						        
							    $transaction_type = "DMR";
								$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
								$this->db->query("
										    update 
										    masterpa_archive.mt3_transfer 
										    set 
										        RESP_statuscode = 'RF',
												RESP_status = ?,
												tx_status=?,
												row_lock='LOCKED',
												Status='FAILURE' where Id = ?
										    
										    
										    ",array("Transaction Failed",$tx_status,$dmr_id));
								//return $client_ref_id."  ".$txstatus_desc." Bank Ref Id : ".$bank_ref_num;
								$resparray = array(
								"message"=>"Transaction Filed .".$json_obj->message,
								"status"=>1,
								);
								return json_encode($resparray);
						    }
						}
						else
						{
							print_r($json_obj);
						}
					}
					else
					{
					    print_r(	$json_obj);
					}
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function remitter_registration($mobile_no,$name,$userinfo)
	{
		
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						
						
						$authenticator_key ='11a5d10f-58b2-449f-9377-52d1cd935a7d';
						$encodedKey = base64_encode($authenticator_key);
						$secret_key_timestamp = "".round(microtime(true) * 1000);

						$signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
						$secret_key = base64_encode($signature);
						//echo $secret_key;exit;
						
							$url ="https://api.eko.co.in:25002/ekoicici/v1/customers/mobile_number:".$mobile_no;
							$request = array(
								  'initiator_id' => $this->getinitiator_id(),
								  'name' =>$name,
								);

							$ch = curl_init($url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
							curl_setopt($ch, CURLOPT_HTTPHEADER, array(
								
								'cache-control: no-cache',
								'secret-key-timestamp: '.$secret_key_timestamp,
								'secret-key: '.$secret_key,
								'content-type: application/x-www-form-urlencoded',
								'developer_key: '.$this->getdeveloper_key()
							));
							curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));

							$buffer = $response = $response = curl_exec($ch);
						//echo $buffer;exit;
							$json_obj = json_decode($buffer);
						
							//$this->loging("customer_registration",$response);
							if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
								$response_status_id = trim((string)$json_obj->response_status_id);
								$response_type_id = trim((string)$json_obj->response_type_id);
								$message = trim((string)$json_obj->message);
								$status = trim((string)$json_obj->status);
								if($response_type_id == "327")
								{
								    
								    
								    $this->load->model("Shootcase");
								    $resp =  $this->Shootcase->remitter_registration_auto($mobile_no,$name,"Kumar",$userinfo);
									$this->session->set_userdata("SenderMobile",$mobile_no);
									$this->session->set_userdata("MT_USER_ID",$user_id);
									
									$resp_arr = array(
																	"message"=>$message,
																	"status"=>0,
																	"statuscode"=>$status,
																	"response_status_id"=>$response_status_id,
																	"response_type_id"=>$response_type_id,
																);
									$json_resp =  json_encode($resp_arr);
									
								}
								else
								{
									$resp_arr = array(
																"message"=>$message,
																"status"=>1,
																"statuscode"=>$status,
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
		
		$this->loging("eko_customer_registration",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	public function remitter_validate_otp($mobile_no,$otp,$userinfo)
	{
		
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$authenticator_key ='11a5d10f-58b2-449f-9377-52d1cd935a7d';
						$encodedKey = base64_encode($authenticator_key);
						$secret_key_timestamp = "".round(microtime(true) * 1000);

						$signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
						$secret_key = base64_encode($signature);
						
						
							$url ="https://api.eko.co.in:25002/ekoicici/v1/customers/verification/otp:".$otp;
							$request = array(
								  'initiator_id' => $this->getinitiator_id(),
								  'id_type' => 'mobile_number',
  								  'id' => $mobile_no
								);

							$ch = curl_init($url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
							curl_setopt($ch, CURLOPT_HTTPHEADER, array(
								'postman-token:89ce1baf-531e-e42b-dbf8-102be0d9e5a1',
								'cache-control: no-cache',
								'secret-key-timestamp: '.$secret_key_timestamp,
								'secret-key: '.$secret_key,
								'content-type: application/x-www-form-urlencoded',
								'developer_key: '.$this->getdeveloper_key()
							));
							curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));

							$buffer = $response = $response = curl_exec($ch);
							$json_obj = json_decode($buffer);
							//print_r($json_obj);exit;
							if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
									$response_status_id = trim((string)$json_obj->response_status_id);
									$response_type_id = trim((string)$json_obj->response_type_id);
									$message = trim((string)$json_obj->message);
									$status = trim((string)$json_obj->status);
									//echo $status."  ".$response_type_id;exit;
									
										$resp_arr = array(
																	"message"=>$message,
																	"status"=>$status,
																	"statuscode"=>$status,
																);
										$json_resp =  json_encode($resp_arr);
									
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
		
		$this->loging("verify_RegOtp",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	
	
	
	
	
	//live method
	public function refund_transaction($dmr_id,$otp,$userinfo)
	{
		$archive = false;
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			    $user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$initiator_id = $this->getinitiator_id();
						
						$developer_key= $this->getdeveloper_key();
						$authenticator_key ='11a5d10f-58b2-449f-9377-52d1cd935a7d';
						$encodedKey = base64_encode($authenticator_key);
						$secret_key_timestamp = "".round(microtime(true) * 1000);

						$signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
						$secret_key = base64_encode($signature);
						
						$resultdmr = $this->db->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where a.Id = ? and a.user_id = ?",array($dmr_id,$user_id));
		if($resultdmr->num_rows() == 0)
		{
		    $archive = true;
		    $resultdmr = $this->db->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM masterpa_archive.mt3_transfer a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where a.Id = ? and a.user_id = ?",array($dmr_id,$user_id));
		}
		if($resultdmr->num_rows() == 1)
		{
			$Status = $resultdmr->row(0)->Status;
			$user_id = $resultdmr->row(0)->user_id;
			$API = $resultdmr->row(0)->API;
			$RESP_status = $resultdmr->row(0)->RESP_status;
			$Amount = $resultdmr->row(0)->Amount;
			$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
			$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
			
			$RESP_ipay_id = $resultdmr->row(0)->RESP_ipay_id;
			
			$remittermobile = $resultdmr->row(0)->RemiterMobile;
			$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
			$url = 'https://api.eko.co.in:25002/ekoicici/v1/transactions/'.$RESP_ipay_id.'/refund';
			//"otp=1754627962&initiator_id=9910028267&state=1&client_ref_id=9076868"
						$request = array(
						  'initiator_id' => $this->getinitiator_id(),
						  'otp' => $otp,
						  'state'=>1,
						  'client_ref_id'=>$dmr_id
						);
			
			
			 $ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
								
								'cache-control: no-cache',
								'secret-key-timestamp: '.$secret_key_timestamp,
								'secret-key: '.$secret_key,
								'content-type: application/x-www-form-urlencoded',
								'developer_key: '.$this->getdeveloper_key()
							));
			//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			$response = curl_exec($ch);
			curl_close($ch);
			$this->loging("remitter_details",$url,$response,"",$userinfo->row(0)->username);
			/*
			{
   "response_status_id": 0,
   "data": {
       "refund_tid": "13192705",
       "amount": "5000.00",
       "tds": "7.1",
       "balance": "2.22263731286E9",
       "fee": "50.0",
       "currency": "INR",
       "commission_reverse": "28.38",
       "tid": "13192443",
       "timestamp": "2018-10-30T12:00:14.058Z",
       "refunded_amount": "5050.00"
   },
   "response_type_id": 74,
   "message": "Refund done",
   "status": 0
}
			*/

				$json_obj = json_decode($response);

				if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
				{
						$response_status_id = trim((string)$json_obj->response_status_id);
						$response_type_id = trim((string)$json_obj->response_type_id);
						$message = trim((string)$json_obj->message);
						$status = trim((string)$json_obj->status);
					
					
						$this->loging("remitter_details",$url,$response,"setp1",$userinfo->row(0)->username);
						if($status == "0")
						{
							$this->loging("remitter_details",$url,$response,"status = 0",$userinfo->row(0)->username);
							if(isset($json_obj->data))
							{
								$this->loging("remitter_details",$url,$response,"data found",$userinfo->row(0)->username);
								$data = $json_obj->data;
								
								$refund_tid = "";
								$rsp_amount = "";
								$tds = "";
								$balance = "";
								$fee = "";
								$commission_reverse = "";
								$currency = "";
								$tid = "";
								$timestamp = "";
								$refunded_amount = "";
								if(isset($data->refund_tid)){$refund_tid = $data->refund_tid;}
								if(isset($data->amount)){$amount = $data->amount;}
								if(isset($data->tds)){$tds = $data->tds;}
								if(isset($data->balance)){$balance = $data->balance;}
								if(isset($data->fee)){$fee = $data->fee;}
								if(isset($data->commission_reverse)){$commission_reverse = $data->commission_reverse;}
								if(isset($data->currency)){$currency = $data->currency;}
								if(isset($data->tid)){$tid = $data->tid;}
								
								
								$this->loging("remitter_details",$url,$response,"before insert",$userinfo->row(0)->username);
								$rsinsert = $this->db->query("insert into dmr3_refundrequests(add_date,ipaddress,user_id,dmr_id,tid,otp,RESP_refund_tid,amount,tds,balance,fee,commission_reverse,RESP_tid,timestamp,refunded_amount,response_type_id,message) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($this->common->getDate(),$this->common->getRealIpAddr(),$user_id,$dmr_id,$RESP_ipay_id,$otp,$refund_tid,$rsp_amount,$tds,$balance,$fee,$commission_reverse,$tid,$timestamp,$refunded_amount,$response_type_id,$message));
								if($rsinsert == true)
								{
									$this->loging("remitter_details",$url,$response,"insert done",$userinfo->row(0)->username);
									if($message == "Refund done")
									{
										$this->loging("remitter_details",$url,$response,"refund done found",$userinfo->row(0)->username);
										   $sub_txn_type = "REMITTANCE";
											$remark = "Money Remittance";
											    $transaction_type = "DMR";
												$this->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
											
											
											if($archive == true)
											{
											    $this->db->query("update masterpa_archive.mt3_transfer set RESP_statuscode = 'RF',RESP_status = 'Transaction Failed',tx_status = 4,Status = 'FAILURE',row_lock = 'LOCKED' where Id = ?",array($dmr_id));
											}
											else
											{
											    $data = array(
													'RESP_statuscode' => "RF",
													'RESP_status' => "Transaction Failed",
													'tx_status'=>4,
													'Status'=>'FAILURE',
													"row_lock"=>"LOCKED",
											);

											$this->db->where('Id', $dmr_id);
											$this->db->update('mt3_transfer', $data);
											}
											
											
											
										$resp_arr = array(
												"message"=>$message,
												"status"=>0,
												"statuscode"=>"RF",
											);
										$json_resp =  json_encode($resp_arr);
									}
									else
									{
										$resp_arr = array(
												"message"=>$message,
												"status"=>1,
												"statuscode"=>"ERR",
											);
										$json_resp =  json_encode($resp_arr);
										$this->loging("remitter_details",$url,$response,"refund done not found",$userinfo->row(0)->username);
									}
									
								}
								
								
								
							}
							
						}
					else
					{
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
					$resp_arr = array(
							"message"=>"Internal Server Error, Please Try Later",
							"status"=>10,
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
		$this->loging("ekorefund",$url,$response,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	//live method
	public function refund_otp_resend($dmr_id,$userinfo)
	{
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
			   
				
				$user_id = $userinfo->row(0)->user_id;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					if($user_status == '1')
					{
						$initiator_id = $this->getinitiator_id();
						
						$developer_key= $this->getdeveloper_key();
						$authenticator_key ='11a5d10f-58b2-449f-9377-52d1cd935a7d';
						$encodedKey = base64_encode($authenticator_key);
						$secret_key_timestamp = "".round(microtime(true) * 1000);

						$signature = hash_hmac('SHA256', $secret_key_timestamp, $encodedKey, true);
						$secret_key = base64_encode($signature);
						
						$resultdmr = $this->db->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where a.Id = ? and a.user_id = ?",array($dmr_id,$user_id));
		if($resultdmr->num_rows() == 0)
		{
		    $resultdmr = $this->db->query("SELECT a.API,a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM masterpa_archive.mt3_transfer a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where a.Id = ? and a.user_id = ?",array($dmr_id,$user_id));
		}
		if($resultdmr->num_rows() == 1)
		{
			$Status = $resultdmr->row(0)->Status;
			$user_id = $resultdmr->row(0)->user_id;
			$API = $resultdmr->row(0)->API;
			$RESP_status = $resultdmr->row(0)->RESP_status;
			$Amount = $resultdmr->row(0)->Amount;
			$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
			$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
			
			$RESP_ipay_id = $resultdmr->row(0)->RESP_ipay_id;
			
			$remittermobile = $resultdmr->row(0)->RemiterMobile;
			$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
			$url = 'https://api.eko.co.in:25002/ekoicici/v1/transactions/'.$RESP_ipay_id.'/refund/otp';
			//var_dump($url);exit;
			
			
						$request = array(
						  'initiator_id' => $this->getinitiator_id(),
						);
			
			
			 $ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
								
								'cache-control: no-cache',
								'secret-key-timestamp: '.$secret_key_timestamp,
								'secret-key: '.$secret_key,
								'content-type: application/x-www-form-urlencoded',
								'developer_key: '.$this->getdeveloper_key()
							));
			//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			$response = curl_exec($ch);
			curl_close($ch);
			/*
			{"response_status_id":-1,"data":{"tid":"1143420344"},"response_type_id":169,"message":"OTP for failed transaction has been sent to customers mobile. Either you can retry the transaction or Use this otp for refunding the transaction {2} {3}","status":0}
			*/

				$json_obj = json_decode($response);

				if(isset($json_obj->response_status_id) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
				{
						$response_status_id = trim((string)$json_obj->response_status_id);
						$response_type_id = trim((string)$json_obj->response_type_id);
						$message = trim((string)$json_obj->message);
						$status = trim((string)$json_obj->status);
						if($status == "0")
						{
							$status = "3";
						}
							$resp_arr = array(
														"message"=>$message,
														"status"=>$status ,
													);
							$json_resp =  json_encode($resp_arr);
						
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
		$this->loging("eko_refundotp",$url,$response,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function resend_otp_refund($Id,$tid,$userinfo)
	{
		
		$postparam = "";
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				
				$user_id = $userinfo->row(0)->user_id;
				$DId = $userinfo->row(0)->parentid;
				$MdId = 0;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					$parentinfo = $this->db->query("select parentid from tblusers where user_id = ?",array($DId));
					if($parentinfo->num_rows() == 1)
					{
							$MdId = $parentinfo->row(0)->parentid;
					}
					if($user_status == '1')
					{
							$url = 'http://emarks.co.in/portal/icici/dmr_api/resend_otp_refund?username='.$this->getUsername().'&pwd='.$this->getPassword().'&tid='.$tid.'&security_key='.$this->getToken();
						
							$headers = array();
							$headers[] = 'Accept: application/json';
							$headers[] = 'Content-Type: application/json';

							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($ch, CURLOPT_POST,1);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							$buffer = curl_exec($ch);
							curl_close($ch);
							//return $buffer;
							//var_dump($buffer);exit;
							$json_obj = json_decode($buffer);
						
							if(isset($json_obj->response_status_id) and isset($json_obj->data) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
									$response_status_id = $json_obj->response_status_id;
									$status = $json_obj->status;
									$response_type_id = $json_obj->response_type_id;
									$data = $json_obj->data;
									$message = $json_obj->message;
									if($response_type_id == "169")
									{
										$resp_arr = array(
													"message"=>$message,
													"status"=>0,
													"statuscode"=>$response_type_id,
													"tid"=>$this->Common_methods->encrypt($data->tid)
												);
										$json_resp =  json_encode($resp_arr);
									}
									else
									{
										$resp_arr = array(
													"message"=>$message,
													"status"=>1,
													"statuscode"=>$response_type_id,
												);
										$json_resp =  json_encode($resp_arr);
									}
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
		$this->loging("refund_otp",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
	}	
	public function do_refund($Id,$tid,$otp,$userinfo)
	{
		
		$postparam = "";
		$buffer = "No Api Call";
		if($userinfo != NULL)
		{
			if($userinfo->num_rows() == 1)
			{
				
				$user_id = $userinfo->row(0)->user_id;
				$DId = $userinfo->row(0)->parentid;
				$MdId = 0;
				$usertype_name = $userinfo->row(0)->usertype_name;
				$user_status = $userinfo->row(0)->status;
				if($usertype_name == "Agent")
				{
					$parentinfo = $this->db->query("select * from tblusers where user_id = ?",array($DId));
					if($parentinfo->num_rows() == 1)
					{
							$MdId = $parentinfo->row(0)->parentid;
					}
					if($user_status == '1')
					{
						$txn_info = $this->db->query("select * from mt3_transfer where id = ? and user_id = ?",array($Id,$user_id));
						if($txn_info->num_rows() == 1)
						{
							$url = 'http://emarks.co.in/portal/icici/dmr_api/refund?username='.$this->getUsername().'&pwd='.$this->getPassword().'&txn_id='.$tid.'&otp='.$otp.'&security_key='.$this->getToken();
						
							
						
							$headers = array();
							$headers[] = 'Accept: application/json';
							$headers[] = 'Content-Type: application/json';

							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($ch, CURLOPT_POST,1);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							$buffer = curl_exec($ch);
							curl_close($ch);
							//return $buffer;
							//var_dump($buffer);exit;
							$json_obj = json_decode($buffer);
						
							if(isset($json_obj->response_status_id) and isset($json_obj->data) and isset($json_obj->response_type_id) and isset($json_obj->message) and isset($json_obj->status))
							{
									$response_status_id = $json_obj->response_status_id;
									$status = $json_obj->status;
									$response_type_id = $json_obj->response_type_id;
									$data = $json_obj->data;
									$message = $json_obj->message;
									if($response_type_id == "74")
									{
										//REFUND
										$transaction_type = "DMR";
										$dr_amount = $data->amount;
										$Description = "DMR ".$txn_info->row(0)->RemiterMobile." Acc No : ".$txn_info->row(0)->AccountNumber;
										$sub_txn_type = "REMITTANCE";
										$remark = "Money Remittance";
										$Charge_Amount = $txn_info->row(0)->Charge_Amount;
										$this->PAYMENT_CREDIT_ENTRY($user_id,$Id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount);

																	$data = array(
																			'RESP_statuscode' => $response_status_id,
																			'RESP_status' => $status,
																			'Status'=>'REFUND',
																			"row_lock"=>"LOCKED",
																	);

																	$this->db->where('Id', $Id);
																	$this->db->update('mt3_transfer', $data);
										$resp_arr = array(
													"message"=>$message,
													"status"=>0,
													"statuscode"=>$response_type_id,
												);
										$json_resp =  json_encode($resp_arr);
									}
									else
									{
										$resp_arr = array(
													"message"=>$message,
													"status"=>1,
													"statuscode"=>$response_type_id,
												);
										$json_resp =  json_encode($resp_arr);
									}
							}
						}
						else
						{
							
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
		$this->loging("refund_otp",$url,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
		
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
	
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		//return "";
		//echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		"username: ".$username.PHP_EOL.
		"Request: ".$request.PHP_EOL.
        "Response: ".$response.PHP_EOL.
		"Downline Response: ".$json_resp.PHP_EOL.
        "Method: ".$methiod.PHP_EOL.
        "-------------------------".PHP_EOL;
		
		
		//echo $log;exit;
		$filename ='inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt';
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		
//Save string to log, use FILE_APPEND to append.
		file_put_contents('inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
		
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
	
	public function PAYMENT_DEBIT_ENTRY_OLD($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00)
	{

		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$ip = $this->common->getRealIpAddr();
		$old_balance = $this->Common_methods->getAgentBalance($user_id);
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
    					if($ewallet_id > 10)
    					{
    						if($sub_txn_type == "Account_Validation")
    						{
    									$rslt_updtrec = $this->db->query("update mt3_account_validate set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance2,$ewallet_id2,$totaldebit_amount,$transaction_id));	
    										return true;
    									}
    									else
    									{
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));	
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
	
	
	
	
	public function REAL_PAYMENT_DEBIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$remark)
	{

		
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
		
		
		//$old_balance = $this->Common_methods->getAgentBalance($user_id);
		if($old_balance < $dr_amount)
		{
		    $this->db->query("COMMIT;");
		    return false;
		}
		else
		{
		    $current_balance = $old_balance - $dr_amount;
    		$tds = 0.00;
    		$stax = 0.00;
    		
			$str_query = "insert into  tblewallet(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)

			values(?,?,?,?,?,?,?,?,?)";
			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$remark));
			if($reslut == true)
			{
					$ewallet_id = $this->db->insert_id();
					if($ewallet_id > 10)
					{
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
			
	}
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
    					if($ewallet_id > 10)
    					{
    						if($sub_txn_type == "Account_Validation")
    						{
    									$rslt_updtrec = $this->db->query("update mt3_account_validate set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance2,$ewallet_id2,$totaldebit_amount,$transaction_id));	
    										return true;
    									}
    									else
    									{
    										$rslt_updtrec = $this->db->query("update mt3_transfer set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));	
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
        	    //if(false)
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
                									$rslt_updtrec = $this->db->query("update mt3_account_validate set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
                										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));
                										$rslt_updtrec = $this->db->query("update champmoney_archive.mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance2,$totaldebit_amount,$transaction_id));	
                										return true;
                									}
                									else
                									{
                										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));
                										$rslt_updtrec = $this->db->query("update masterpa_archive.mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?),credit_amount = ? where Id = ?",array($current_balance,$dr_amount,$transaction_id));	
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
				a.tds
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
        				'0.20' as dist_charge_value ,
        				a.ccf,
        				a.cashback,
        				a.tds
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