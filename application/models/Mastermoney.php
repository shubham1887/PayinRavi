<?php
class Mastermoney extends CI_Model 
{ 
   
	function _construct()
	{
	   
		  // Call the Model constructor
		  parent::_construct();
	}
	private function getLiveUrl($type)
	{	
	}
	
	private function getUsername()
	{
		return "9820458677";
	}
	private function getPassword()
	{
		return "214141";
	}
	private function getdeveloper_key()
	{
		return "68342634381756390386552033936549";
	}

	
	
	
	
	
	
	public function requestlog($request,$response,$sender_mobile,$account_no,$dmt_id,$downline_response)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into dmt_reqresp(add_date,ipaddress,request,response,sender_mobile,account_no,dmt_id,downline_response) values(?,?,?,?,?,?,?,?)",array());
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
	

	public function PAYMENT_DEBIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$ChargeAmount,$userinfo)
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
        	$old_balance =  0;
		}
		$this->db->query("COMMIT;");
		
	
		if($old_balance < $dr_amount)
		{
		    return false;
		}
		else
		{
		    $current_balance = $old_balance - $dr_amount;
    	//	$tds = 0.00;
    		$stax = 0.00;
    		if($transaction_type == "DMR")
    		{
    			$str_query = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)
    
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
    						    
    						    //ccf deduction code
								$current_balance2 = $current_balance - $ChargeAmount;
								$remark = "Transaction Charge";
								$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,remark)

								values(?,?,?,?,?,?,?,?,?)";
								$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$ChargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
								if($reslut2 == true)
								{
									$totaldebit_amount = $dr_amount + $ChargeAmount;
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
    		else if($transaction_type == "BILL")
			{
				$str_query = "insert into  tblewallet2(user_id,bill_id,transaction_type,debit_amount,balance,description,add_date,ipaddress)

				values(?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip));
				
				if($reslut == true)
				{
						$ewallet_id = $this->db->insert_id();
					
						$rslt_updtrec = $this->db->query("update tblbills set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
	
	
	public function fetchbill($userinfo,$spkey,$company_id,$Mobile,$CustomerMobile,$option1 = "")
{
	//echo $option1;exit;
	//echo $Mobile."   ".$CustomerMobile;exit;
	$ipaddress = $this->common->getRealIpAddr();
	$payment_mode = "CASH";
	$payment_channel = "AGT";
	$url= '';
	$buffer = '';

	if($spkey == "TYE")
	{
		$option1  = "Ahmedabad";
	}
	if($spkey == "TZE")
	{
		$option1  = "Agra";
	}
	if($spkey == "TXE")
	{
		$option1  = "Bhiwandi";
	}
	if($spkey == "TWE")
	{
		$option1  = "Surat";
	}
	if($spkey == "TPS")
	{
		$option1  = "";
	}

	if($userinfo != NULL)
	{
		if($userinfo->num_rows() == 1)
		{
			
			$user_id = $userinfo->row(0)->user_id;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$user_status = $userinfo->row(0)->status;
			if($usertype_name == "Agent" or $usertype_name == "APIUSER")
			{
				if($user_status == '1')
				{
					
						$insert_rslt = $this->db->query("insert into tblbillcheck(add_date,ipaddress,user_id,mobile,customer_mobile,company_id) values(?,?,?,?,?,?)",array($this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id));
						if($insert_rslt == true)
						{
							$insert_id = $this->db->insert_id();
							$transaction_type = "BILL";
							$Description = "Service No.  ".$Mobile;
							$sub_txn_type = "BILL";
							$remark = "Bill PAYMENT";
							$Charge_Amount = 0.00;
							
							
								$headers = array();
								$headers[] = 'Accept: application/json';
								$headers[] = 'Content-Type: application/json';

								
								$url = "http://primepay.co.in/webapi/getBillAmount?username=".$this->getUsername()."&pwd=".$this->getPassword()."&mcode=".$spkey."&serviceno=".$Mobile."&customer_mobile=".$CustomerMobile."&option1=".$option1."&option2=";
							//echo $url;exit;
								$ch = curl_init();
								curl_setopt($ch,CURLOPT_URL,$url);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	
								$buffer = curl_exec($ch);
								curl_close($ch);
								//echo $buffer;exit;
							$this->loging("MMBILL",$url,$buffer,"",$userinfo->row(0)->username);
								//str_replace("particulars", "data", $buffer);
								$json_resp =  $buffer;
								$json_obj = json_decode($buffer);
								/*

{"statuscode":"TXN","status":"0","message":"BILL FETCH SUCCESSFUL",
	"particulars":
	{
		"dueamount":64,
		"duedate":"",
		"customername":"NEHABEN DIPAKBHAI JOSHI",
		"billnumber":"",
		"billdate":"",
		"billperiod":"",
		"reference_id":493250
	}
}
								*/
								if(isset($json_obj->status) and isset($json_obj->statuscode) and isset($json_obj->message))
								{
									$status = trim($json_obj->status);
									$statuscode = trim($json_obj->statuscode);
									$message = trim($json_obj->message);
									if($status == '0')
									{
										$particulars = $json_obj->particulars;

										$dueamount = 0;
										$duedate = "";
										$customername = "";
										$billnumber = "";
										$billdate = "";
										$billperiod = "";
										$reference_id = "";
										if(isset($particulars->dueamount))
										{
											$dueamount = trim($particulars->dueamount);
										}
										if(isset($particulars->duedate))
										{
											$duedate = trim($particulars->duedate);
										}
										if(isset($particulars->customername))
										{
											$customername = trim($particulars->customername);
										}
										if(isset($particulars->billnumber))
										{
											$billnumber = trim($particulars->billnumber);
										}
										if(isset($particulars->billdate))
										{
											$billdate = trim($particulars->billdate);
										}
										if(isset($particulars->billperiod))
										{
											$billperiod = trim($particulars->billperiod);
										}
										if(isset($particulars->reference_id))
										{
											$reference_id = trim($particulars->reference_id);
										}

										$this->db->query("update tblbillcheck set check_dueamount = ?,check_duedate=?,check_customername=?,check_billnumber=?,check_billdate=?,check_billperiod=?,check_reference_id = ? where Id = ?",array($dueamount,$duedate,$customername,$billnumber,$billdate,$billperiod,$reference_id,$insert_id ));

										return $buffer;
									}
									else
									{
										$resp_arr = array(
										"message"=>$message,
										"status"=>$status,
										"statuscode"=>$statuscode,
										);
										$json_resp =  json_encode($resp_arr);
										return $json_resp;
									}
									
									
								}
								else
								{
									$resp_arr = array(
										"message"=>"Internal Server Error Occured",
										"status"=>1,
										"statuscode"=>"ERR",
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
								"statuscode"=>"UNK",
							);
					$json_resp =  json_encode($resp_arr);
					return $json_resp;
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
				return $json_resp;
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
			return $json_resp;
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
		return $json_resp;
		
	}
	$this->loging("MMBILL",$url." ?".json_encode($request_array),$buffer,$json_resp,$userinfo->row(0)->username);
	return $json_resp;
	
}


	public function bill_logs($user_id,$request,$response,$bill_id)
	{
		$this->db->query("insert into tblreqresp_bills(user_id,add_date,ipaddress,request,response,bill_id) values(?,?,?,?,?,?)",
							array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$bill_id));
	}
	public function recharge_transaction2($userinfo,$spkey,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$ref_id,$particulars,$option2="",$option3="",$done_by = "WEB",$payment_mode = "Express")
{
   

   		// error_reporting(-1);
   		// ini_set('display_errors',1);
   		// $this->db->db_debug = TRUE;
	    $api_name = "";
	    
	    
	    
	    if($spkey == "TYE")
		{
			$option1  = "Ahmedabad";
		}
	    $company_info = $this->db->query("select a.company_id,a.company_name,b.api_name,a.minamt,a.mxamt,a.service_id from tblcompany a left join tblapi b on a.api_id = b.api_id where a.company_id = ?",array($company_id));
	   if($company_info->num_rows() == 1)
	   {
	       $api_name = $company_info->row(0)->api_name;
	   }
	   $service_id = $company_info->row(0)->service_id;



	   if($Amount < $company_info->row(0)->minamt )
	    {
	        $resp_arr = array(
								"message"=>"You can only pay between  ".$company_info->row(0)->minamt."-".$company_info->row(0)->mxamt,
								"status"=>1,
								"statuscode"=>"ERR",
							);
			$json_resp =  json_encode($resp_arr);
			echo $json_resp;exit;
	    }
	    else if($Amount > $company_info->row(0)->mxamt )
	    {
	        $resp_arr = array(
								"message"=>"You can only pay between  ".$company_info->row(0)->minamt."-".$company_info->row(0)->mxamt,
								"status"=>1,
								"statuscode"=>"ERR",
							);
			$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
	    }
	    else if($userinfo->row(0)->service == 'no' )
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

	        $this->loging("RECHARGE","step2","","",$userinfo->row(0)->username);
	       // if($this->bill_checkduplicate($userinfo->row(0)->user_id,$Mobile,$Amount) == false)
	        if(false)
        	{
        	    $resp_arr = array(
								"message"=>"Please Try Later",
								"status"=>1,
								"statuscode"=>"ERR",
							);
			    $json_resp =  json_encode($resp_arr);
			    	$this->loging("RECHARGE","","",$json_resp,$userinfo->row(0)->username);
        		return $json_resp;   
        	}
        	else
        	{

        	    $this->loging("RECHARGE","step3","","",$userinfo->row(0)->username);
        	    $rsltcheck = $this->db->query("SELECT Id FROM `tblbills`  where service_no = ? and user_id = ? and status != 'Failure' and Date(add_date) = ?
ORDER BY `tblbills`.`Id`  DESC",array($Mobile,$userinfo->row(0)->user_id,$this->common->getMySqlDate()));
                //if($rsltcheck->num_rows() == 1)
                if(false)
                {
                    $resp_arr = array(
								"message"=>"Duplicate Request Found.",
								"status"=>1,
								"statuscode"=>"ERR",
							);
			        $json_resp =  json_encode($resp_arr);
                }
                else
                {
                	$this->loging("RECHARGE","step4","","",$userinfo->row(0)->username);
                    $Amount = intval($Amount);
            		$ipaddress = $this->common->getRealIpAddr();
            		
            		$payment_channel = "AGT";
            		
            		if($spkey == "TPE" )
            		{
            			$payment_mode = "";
            			$payment_channel = "";
            		}
            		$url= '';
            		$buffer = '';
            		if($userinfo != NULL)
            		{
            		 
            			if($userinfo->num_rows() == 1)
            			{
            				
            				$user_id = $userinfo->row(0)->user_id;
            				$usertype_name = $userinfo->row(0)->usertype_name;
            				$user_status = $userinfo->row(0)->status;
            				if($usertype_name == "Agent" or $usertype_name == "APIUSER")
            				{
            					if($user_status == '1')
            					{
            			
            						/*
            						
            		{"statuscode":"TXN","status":"Transaction Successful","data":{"dueamount":"140.00","duedate":"04-02-2019","customername":"NISHAT","billnumber":"055440619012212","billdate":"22-01-2019","billperiod":"NA","billdetails":[],"customerparamsdetails":[{"Name":"CA Number","Value":"103761766"}],"additionaldetails":[],"reference_id":46731}}
            		*/

            						$crntBalance = $this->Ew2->getAgentBalance($user_id);

$this->loging("RECHARGE_REQ_",$url,"CurrentBalance:".$crntBalance,"RechAmount:".$Amount."---Mobile:".$Mobile."---CustomerMobile:".$CustomerMobile,$userinfo->row(0)->username);
            						if(trim($crntBalance) >= trim($Amount))
            						{
            						   
            								$dueamount = "";
            								$duedate = "";
            								$billnumber = "";
            								$billdate = "";
            								$billperiod = "";
            								$custname = "";
            								$insta_ref = 0;
            							//print_r($particulars);exit;
            							if($particulars != false)
            							{
            								$custname = $particulars->customername;
            								$dueamount = $particulars->dueamount;
            								$duedate = $particulars->duedate;
            								$billnumber = $particulars->billnumber;
            								$billdate = $particulars->billdate;
            								$billperiod = $particulars->billperiod;
            								$insta_ref = $particulars->reference_id;
            							}
            							else
            							{
            								$billcheck_rslt = $this->db->query("select * from tblbillcheck where mobile=? and user_id = ? order by Id desc limit 1",array($Mobile,$user_id));
            								if($billcheck_rslt->num_rows() == 1)
            								{
            									$custname = $billcheck_rslt->row(0)->check_customername;
	            								$dueamount = $billcheck_rslt->row(0)->check_dueamount;
	            								$duedate = $billcheck_rslt->row(0)->check_duedate;
	            								$billnumber = $billcheck_rslt->row(0)->check_billnumber;
	            								$billdate = $billcheck_rslt->row(0)->check_billdate;
	            								$billperiod = $billcheck_rslt->row(0)->check_billperiod;
	            								$insta_ref = $billcheck_rslt->row(0)->check_reference_id;
            								}
            							}


            					// error_reporting(-1);
            					// ini_set('display_errors',1);
            					// $this->db->db_debug = TRUE;
                                    //print_r($billcheck_rslt->result());exit;
            							
            							$insert_rslt = $this->db->query("insert into tblbills(mode,add_date,ipaddress,user_id,service_no,customer_mobile,company_id,bill_amount,paymentmode,payment_channel,status,customer_name,dueamount,duedate,billnumber,billdate,billperiod,option1,done_by,API)
            							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            							array($payment_mode,$this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id,$Amount,$payment_mode,$payment_channel,"Pending",$custname,$dueamount,$duedate,$billnumber,$billdate,$billperiod,$option1,$done_by,"MM"));
            							if($insert_rslt == true)
            							{
            								
            								$insert_id = $this->db->insert_id();

            								$transaction_type = "BILL";
            								if($service_id == 31)
            								{
            										$Charge_Amount = -10;
            								}
            								else
            								{
            									$Charge_Amount =0.0;
            									if($Amount > 100000)
	            								{
		                                            $Charge_Amount =0.0;
	            								}
	            								else
	            								{
	            								    //$Charge_Amount = (($Amount * 0.15)/100);
	            								}
            								}
            								
            								
            							
            								$dr_amount = $Amount - $Charge_Amount;
            								$Description = "Service No.  ".$Mobile." Bill Amount : ".$Amount;
            								$sub_txn_type = "BILL";
            								$remark = "Bill PAYMENT";
            								$Charge_Amount = $Charge_Amount;
            								
            								$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
            								if($paymentdebited == true)
            								{
            								    $otoamount = 2000;
            								    $rsltcommon_otoamt = $this->db->query("select * from common where param = 'BILLAMT_OTOMAX'");
            								    if($rsltcommon_otoamt->num_rows() == 1)
            								    {
            								        $otoamount = $rsltcommon_otoamt->row(0)->value;
            								    }
            								    $dohold = 'no';
											    $rsltcommon = $this->db->query("select * from common where param = 'BILLHOLD'");
											    if($rsltcommon->num_rows() == 1)
											    {
											        $is_hold = $rsltcommon->row(0)->value;
											    	if($is_hold == 1)
											    	{
											    	    $dohold = 'yes';
											    	}
											    }


											    //if($dohold == 'yes')
											    if($payment_mode == "Normal" or $dohold == "yes")
												{
													$this->db->query("update tblbills set API = 'MANUAL' where Id = ?",array($insert_id));
													$resp_arr = array(
																			"message"=>"Bill Request Submitted Successfully",
																			"status"=>0,
																			"statuscode"=>"TUP",
																			"StatusCode"=>"1",
																			"Data"=>array(
																				"Rechargeid"=>$insert_id,
																				"Message"=>"Bill Request Submitted Successfully",
																			),
																			"data"=>array(

																				"ipay_id"=>"",
																				"opr_id"=>"",
																				"status"=>"Pending",
																				"res_msg"=>"Bill Request Submitted Successfully",
																			)
																		);
													$json_resp =  json_encode($resp_arr);	
												}
												else
												{
													$this->db->query("update tblbills set API = 'PRIMEPAY' where Id = ?",array($insert_id));
													$headers = array();
	            									$headers[] = 'Accept: application/json';
	            									$headers[] = 'Content-Type: application/json';
	            
											    	if($spkey == "TPE" and $option1 == "Ahmedabad")
													{
														$spkey  = "TYE";
													}
	    
	    											$url = "http://primepay.co.in/webapi/doBillrecharge?username=".$this->getUsername()."&pwd=".$this->getPassword()."&mcode=".$spkey."&serviceno=".$Mobile."&customer_mobile=".$CustomerMobile."&option1=".$option1."&Amount=".$Amount."&RefId=".$insta_ref;
	    											
	    										
	    											$request_array = array();
	    										//	$mainreq_array["token"]=$this->getToken();
	    
	    											
	    											$ch = curl_init();
	    											curl_setopt($ch,CURLOPT_URL,$url);
	    											curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    											curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    											curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    											curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    
	    											$buffer = curl_exec($ch);
	    											curl_close($ch);
	    
	    											$json_resp =  $buffer;
	    											//echo $url."<br><br>";
	    											//var_dump( $buffer);exit;
	    											$this->bill_logs($userinfo->row(0)->user_id,$url,$buffer,$insert_id);
	    											//$this->loging("MMBBPS",$url,$buffer,"",$userinfo->row(0)->username);
	    										
	    									//	$this->loging("RECHARGE",$url,$json_resp,json_encode($request_array),$userinfo->row(0)->username);
	    										
	    											
	            									/*
	            									{"ipay_id":"1180518152856NUHHQ","agent_id":"1235","opr_id":"1805181529230004","account_no":"8238232303","sp_key":"VFP","trans_amt":10,"charged_amt":9.93,"opening_bal":"18066.10","datetime":"2018-05-18 15:29:14","status":"SUCCESS","res_code":"TXN","res_msg":"Transaction Successful"}
	    											
	    											
	    											new response 
	    											{"statuscode":"TXN","status":"Transaction Successful",
	    											"data":{
	    												"ipay_id":"1190122152826GSQYX",
	    												"agent_id":"14",
	    												"opr_id":"TJ0100953330",
	    												"account_no":"103761766",
	    												"sp_key":"BYE",
	    												"trans_amt":"140",
	    												"charged_amt":139.05,
	    												"opening_bal":"23927.70",
	    												"datetime":"2019-01-22 15:28:28",
	    												"status":"SUCCESS"
	    											}}

	    											 {"message":"SUCCESS","status":0,"statuscode":"TXN","data":{"ipay_id":"O022098801","opr_id":"CC01ABU31654","status":"Successful","res_msg":"000"}}
	    											
	            									*/
	            									$json_obj = json_decode($buffer);
	            									if(isset($json_obj->statuscode) and isset($json_obj->status))
	            									{
	    													$statuscode = trim((string)$json_obj->statuscode);
	    													$status = trim((string)$json_obj->status);
	    													$message = trim((string)$json_obj->message);
	    												
	    													if($statuscode == "TXN")
	    													{
	    														$data = $json_obj->data;
	    														$ipay_id = $data->ipay_id;
	    														$agent_id = "";
	    														$opr_id = $data->opr_id;
	    														$sp_key = "";
	    														$trans_amt = "";
	    														$charged_amt = "";
	    														$opening_bal = "";
	    														$datetime = "";
	    														$status = $data->status;
	    														
	    															$this->db->query("update tblbills set status = 'Success',ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$status,$statuscode,$status,$insert_id));
	    
	    														
	    
	    
	    															 $resp_arr = array(
	    															 						"message"=>$message,
	    															 						"status"=>0,
	    															 						"statuscode"=>$statuscode,
	    															 						"StatusCode"=>1,
	    															 						"Message"=>$message,
	    															 						"Data"=>array(
	    															 							"Rechargeid"=>$insert_id,
	    															 						"Message"=>$message,
	    															 					),
	    															 						"data"=>array(
	    
	    															 							"ipay_id"=>$ipay_id,
	    															 							"opr_id"=>$opr_id,
	    															 							"status"=>$status,
	    															 							"res_msg"=>$status,
	    															 						)
	    															 					);
	    															 $json_resp =  json_encode($resp_arr);	

	    															// $resparray = array(
																    //                         "status"=>"Success",
																    //                         "tid"=>$insert_id,
																    //                         "order_id"=>"",
																    //                         "mobile"=>$Mobile,
																    //                         "amount"=>$Amount,
																    //                         "operator_id"=>$opr_id,
																    //                 );
																    // return json_encode($resparray);



	    													}
	    													else if($statuscode == "TUP")
	    													{
	    														$data = $json_obj->data;
	    														$ipay_id = $data->ipay_id;
	    														$agent_id = $data->agent_id;
	    														$opr_id = $data->opr_id;
	    														$sp_key = $data->sp_key;
	    														$trans_amt = $data->trans_amt;
	    														$charged_amt = $data->charged_amt;
	    														$opening_bal = $data->opening_bal;
	    														$datetime = $data->datetime;
	    														$status = $data->status;
	    														
	    														$this->db->query("update tblbills set status = 'Pending',ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$status,$statuscode,$status,$insert_id));
	    
	    														
	    														$resp_arr = array(
	    															 						"message"=>$message,
	    															 						"status"=>0,
	    															 						"statuscode"=>$statuscode,
	    															 						"StatusCode"=>1,
	    															 						"Message"=>$message,
	    															 						"Data"=>array("Rechargeid"=>$insert_id),
	    															 						"data"=>array(
	    
	    															 							"ipay_id"=>$ipay_id,
	    															 							"opr_id"=>$opr_id,
	    															 							"status"=>$status,
	    															 							"res_msg"=>$status,
	    															 						)
	    															 					);
	    														$json_resp =  json_encode($resp_arr);
	    
	    															

	    													}
	    													else if($statuscode == "IRA" or $statuscode == "UAD" or $statuscode == "IAC"  or $statuscode == "IAT"  or $statuscode == "AAB" or $statuscode == "ISP"  or $statuscode == "DID"  or $statuscode == "SPD" )
	    													{
	            												$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
	            												
	            												$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$statuscode,$status,$insert_id));
	            												

	            												$resp_arr = array(
	    															 						"message"=>$message,
	    															 						"status"=>1,
	    															 						"statuscode"=>$statuscode,
	    															 						"StatusCode"=>0,
	    															 						"Message"=>$message,
	    															 						"Data"=>array("Rechargeid"=>$insert_id),
	    															 						"data"=>array(
	    
	    															 							"ipay_id"=>$ipay_id,
	    															 							"opr_id"=>"",
	    															 							"status"=>$status,
	    															 							"res_msg"=>$status,
	    															 						)
	    															 					);
	    														$json_resp =  json_encode($resp_arr);


	            											}
	    													else if($statuscode == "IAB" )
	    													{
	            												$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
	            												
	    														$status = "Internal Server Error";
	    														$statuscode = "ERR";
	            												$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$statuscode,$status,$insert_id));
	            												
	            												$resp_arr = array(
	    															 						"message"=>"Internal Server Error",
	    															 						"status"=>1,
	    															 						"statuscode"=>$statuscode,
	    															 						"StatusCode"=>0,
	    															 						"Message"=>"Internal Server Error",
	    															 						"Data"=>array("Rechargeid"=>$insert_id),
	    															 						"data"=>array(
	    
	    															 							"ipay_id"=>$ipay_id,
	    															 							"opr_id"=>"",
	    															 							"status"=>$status,
	    															 							"res_msg"=>$status,
	    															 						)
	    															 					);
	    														$json_resp =  json_encode($resp_arr);
	            											}
	                
	                
	                									}
	            									else 
	            									{
	            										$resparray = array(
																                            "status"=>"Failure",
																                            "tid"=>"",
																                            "order_id"=>"",
																                            "mobile"=>$Mobile,
																                            "amount"=>$Amount,
																                            "operator_id"=>"",
																                    );
													    echo json_encode($resparray);exit;


	            										// $resp_arr = array(
	            										// 		"message"=>"Some Error Occure",
	            										// 		"status"=>10,
	            										// 		"statuscode"=>"UNK",
	            										// 	);
	            										// $json_resp =  json_encode($resp_arr);
	            									}
												}
            								}
            								else
            								{
            									$resp_arr = array(
            									"message"=>"Payment Error. Please Try Again",
            									"status"=>1,
            									"statuscode"=>"ERR",
            									"StatusCode"=>"0",
            									"Message"=>"Payment Error. Please Try Again"
            								);
            								$json_resp =  json_encode($resp_arr);
            								}
            							}
            						}
            						else
            						{
            							$resp_arr = array(
            									"message"=>"InSufficient Balance 2",
            									"status"=>1,
            									"statuscode"=>"ISB",
            									"StatusCode"=>"0",
            									"Message"=>"InSufficient Balance"
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
            									"StatusCode"=>"0",
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
            									"statuscode"=>"UNK",
            									"StatusCode"=>"0",
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
            									"statuscode"=>"UNK",
            									"StatusCode"=>"0",
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
            									"statuscode"=>"UNK",
            									"StatusCode"=>"0",
            									"Message"=>"Userinfo Missing"
            								);
            			$json_resp =  json_encode($resp_arr);
            			
            		}  
                }
        		//$this->loging("MMBILL",$url,$buffer,$json_resp,$userinfo->row(0)->username);
        		return $json_resp;   
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
	public function PAYMENT_CREDIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$ChargeAmount)
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
                		$old_balance = $this->Ew2->getAgentBalance($user_id);
                		$current_balance = $old_balance + $dr_amount;
                		//$tds = 0.00;
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
                									$rslt_updtrec = $this->db->query("update mt3_account_validate set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
                									return true;
                						}
                						else if($sub_txn_type == "REMITTANCE")
                						{
                									$current_balance2 = $current_balance + $ChargeAmount;
                									$remark = "Transaction Charge Reverse";
                									$str_query_charge = "insert into  tblewallet2(user_id,dmr_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,remark)
                
                									values(?,?,?,?,?,?,?,?,?)";
                									$reslut2 = $this->db->query($str_query_charge,array($user_id,$transaction_id,$transaction_type,$ChargeAmount,$current_balance2,$Description,$add_date,$ip,$remark));
                									if($reslut2 == true)
                									{
                										$totaldebit_amount = $dr_amount + $ChargeAmount;
                										$ewallet_id2 = $ewallet_id.",".$this->db->insert_id();
                										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance2,$ewallet_id2,$totaldebit_amount,$transaction_id));
                									    return true;
                									}
                									else
                									{
                										$rslt_updtrec = $this->db->query("update mt3_transfer set reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
                		else if($transaction_type == "BILL")
                		{
                			$str_query = "insert into  tblewallet2(user_id,bill_id,transaction_type,credit_amount,balance,description,add_date,ipaddress)
                
                			values(?,?,?,?,?,?,?,?)";
                			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip));
                
                			if($reslut == true)
                			{
                					$ewallet_id = $this->db->insert_id();
                
                					$rslt_updtrec = $this->db->query("update tblbills set debited='yes',reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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
	
	
	
	
	public function checkduplicate_bill($user_id,$transaction_id)
    {
    	$add_date = $this->common->getDate();
    	$ip = $this->common->getRealIpAddr();
    
    	$rslt = $this->db->query("insert into bill_refund_lock (user_id,dmr_id,add_date,ipaddress) values(?,?,?,?)",array($user_id,$transaction_id,$add_date,$ip));
    	  if($rslt == "" or $rslt == NULL)
    	  {
    		return false;
    	  }
    	  else
    	  {
    	  	return true;
    	  }
    }
	public function PAYMENT_CREDIT_ENTRY_bill($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$ccf,$cashback,$tds)
	{
	    
				if($this->checkduplicate_bill($user_id,$transaction_id) == false)
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
                		$old_balance = $this->Ew2->getAgentBalance($user_id);
                		$current_balance = $old_balance + $dr_amount;
                		//$tds = 0.00;
                		$stax = 0.00;
                		if($transaction_type == "BILL")
                		{
                			$str_query = "insert into  tblewallet2(user_id,bill_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)
                
                			values(?,?,?,?,?,?,?,?,?,?,?)";
                			$reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$tds,$stax,$remark));
                
                			if($reslut == true)
                			{
                					$ewallet_id = $this->db->insert_id();
                
                					$rslt_updtrec = $this->db->query("update tblbills set debited='yes',reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
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

private function getChargeValue($userinfo,$whole_amount)
{
    
    
    $groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->parentid));
   // $groupinfo = $this->db->query("select * from mt3_group where Id =3");
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
				a.cashback_type,
				a.tds_type
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
        				'0.20' as dist_charge_value ,
        				a.ccf,
        				a.cashback,
        				a.tds,
        				a.ccf_type,
        				a.cashback_type,
        				a.tds_type
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