<?php
class Zpuls_model extends CI_Model 
{	
	protected $impsurl;
	protected $limiturl;
	protected $txnenqurl;
	protected $at_partnerid;
	protected $at_salt;
	protected $mt3_sender;
	protected $mt3_sender_info;
	protected $airtel_sender;
	protected $beneficiaries;
	protected $airtel_beneficiary;
	protected $mt3_bene_temp;
	protected $api;
	protected $arr_months;
	protected $arr_dates;
	protected $year_from;
	protected $year_to;
	protected $arrHoldMsg; protected $arr_F_Names; protected $arr_L_Names;
	function __construct()
	{
		  parent::__construct();
		 
	}
	public function requestlog($insert_id,$request,$response,$mobile_no,$account_number,$downline_response)
	{
		$this->db->query("insert into dmt_reqresp(add_date,ipaddress,request,response,sender_mobile,dmt_id) value(?,?,?,?,?,?)",
			array($this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$mobile_no,$insert_id));
	}

	public function getBalance()
	{}

	private function loging_db($method,$request,$response,$json_resp,$username,$sender_mobile=0,$lat=0,$lng=0)
	{
		$this->db->reset_query();
		$insarray=array("log_ip"=>$_SERVER['REMOTE_ADDR'],"log_user"=>$username,"sender_mobile"=>$sender_mobile,"log_method"=>"airteldmt_".$method,"log_request"=>$request,"log_response"=>$response,"log_downline_response"=>$json_resp,"log_datetime"=>date("Y-m-d H:i:s"),"log_api"=>"AIRTEL");
		$this->db->insert("tbl_logs_dmt_4",$insarray);
	}
	private function loging($methiod,$request,$response,$json_resp,$username)
	{
		
		return "";
		//**echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
		"username: ".$username.PHP_EOL.
		"Request: ".$request.PHP_EOL.
        "Response: ".$response.PHP_EOL.
		"Downline Response: ".PHP_EOL.
        "Method: ".$methiod.PHP_EOL.
        "-------------------------".PHP_EOL;
		
		
		//echo $log;exit;
		$filename ='inlogs/airtel.txt';
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		
		//Save string to log, use FILE_APPEND to append.
		file_put_contents('inlogs/airtel.txt', $log, FILE_APPEND);
		
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
public function Transfer_Api_call_only($Id)
{
	$req_fname = "Bhavesh";
	$req_lname = "ABCD";

    if(true)
    {
        $postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		
	    $insert_id = $Id;
	    $dmr_id = $Id;

	    $rslttransaction = $this->db->query("SELECT * FROM `mt3_transfer` where  (Status = 'PENDING' or Status = 'HOLD') and Id = ?",array($Id));


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
					
					
					$this->db->query("update mt3_transfer set Status = 'PENDING',API = 'ZPULS' where Id = ?",array($Id));
					$insert_id = $Id;
					 $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

			   				
	

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
		
		$ZMODE = "IMPSIFSC";
		if($mode == "NEFT")
		{
			$ZMODE = "NEFT";
		}
		$recipient_name = $benificiary_name;




$request_array = array(
		"sendermobile"=>$remittermobile,

		"firstname"=>$req_fname,
		"lastname"=>$req_lname,
		"beneficiaryname"=>$benificiary_name,
		"beneficiarymobileno"=>$remittermobile,

		"accountno"=>$benificiary_account_no,
		"ifsccode"=>$IFSC,
		"remark"=>$remittermobile,
		"transtype"=>$ZMODE,
		"transamount"=>$amount,
		"agentmerchantid"=>$Id
	);

$url = 'http://zpluscash.com/apis/v1/dmr?authKey=jsU37SHwRuiei23DS_sams&clientId=API_CLIENT86&userId=16&action=paynow&data='.urlencode(json_encode($request_array));

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
));
$buffer = $response = $buffer = curl_exec($curl);
curl_close($curl);



$this->requestlog($insert_id,json_encode($request_array),$response,$remittermobile,$benificiary_account_no,"");
$json_obj = json_decode($buffer);
							
if(isset($json_obj->MESSAGE) and isset($json_obj->STATUS))
{
		$message = $json_obj->MESSAGE;
		$status = $json_obj->STATUS;
		$statuscode =  "";
		
		

		if($status == "1")
		{
		    	$bank_ref_num = $json_obj->DATA;
				$data = array(
    					'RESP_statuscode' => "TXN",
    					'RESP_status' => $message,
    					'RESP_ipay_id' => $insert_id,
    					'RESP_opr_id' =>$bank_ref_num,
    					'RESP_name' => $benificiary_name,
    					'message'=>$benificiary_name,
    					'Status'=>'SUCCESS',
    					'edit_date'=>$this->common->getDate()
    		);
				

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
					

					$sms = 'Dear Customer, INR '.$amount.' To Ac No: '.$benificiary_account_no.' ,Beneficiary Name: '.$benificiary_name.' And Your '.$mode.' Ref No. is: '.$bank_ref_num.' is Successful.PAYIN';

					$this->common->ExecuteSMSApiWowSms($remittermobile,$sms);

					$resp_arr = array(
										"message"=>$message,
										"status"=>0,
										"statuscode"=>"TXN",
										"data"=>array(
											"tid"=>$insert_id,
											"ref_no"=>$insert_id,
											"opr_id"=>$bank_ref_num,
											"name"=>$recipient_name,
											"balance"=>0,
											"amount"=>$amount,

										)
									);
					$json_resp =  json_encode($resp_arr);

		}
		else if($status == "4")
		{
		   
          //if($message == "Thank You !!.We have received your request and It will be processed soon")
		  if(false)
          {
				$bank_ref_num = "11".rand(999999999,11111111111);
				$message = "Transaction done successfully!";

           
				$data = array(
							'RESP_statuscode' => "TXN",
							'RESP_status' => $message,
							'RESP_ipay_id' => $insert_id,
							'RESP_ref_no' => $insert_id,
							'RESP_opr_id' => $bank_ref_num,
							'Status'=>'SUCCESS',
							'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);

					$sms = 'Dear Customer, INR '.$amount.' To Ac No: '.$benificiary_account_no.' ,Beneficiary Name: '.$benificiary_name.' And Your '.$mode.' Ref No. is: '.$bank_ref_num.' is Successful.PAYIN';
					$this->common->ExecuteSmsApi($remittermobile,$sms);

					
					
					$resp_arr = array(
										"message"=>$message,
										"status"=>0,
										"statuscode"=>"TXN",
										"data"=>array(
											"tid"=>$insert_id,
											"ref_no"=>$insert_id,
											"opr_id"=>$bank_ref_num,
											"name"=>$recipient_name,
											"balance"=>0,
											"amount"=>$amount,

										)
									);
					$json_resp =  json_encode($resp_arr);
          }
          else
          {
          		$data = array(
							'RESP_statuscode' => "TUP",
							'RESP_status' => $message,
							'edit_date'=>$this->common->getDate()
					);

				$this->db->where('Id', $insert_id);
				$this->db->update('mt3_transfer', $data);
				
				$resp_arr = array(
									"message"=>$message,
									"status"=>0,
									"statuscode"=>$statuscode,
								);
			    $json_resp =  json_encode($resp_arr);
          }

		}
		else if($status == "2")
		{
		    
			//You do not have sufficient balance to perform this transaction!
			if(preg_match('/do not have sufficient balance/', $message) == 1)
			{
				$data = array(
						'RESP_statuscode' => "TUP",
						'RESP_status' => "Transaction Under Process",
						'Status'=>'PENDING',
						'edit_date'=>$this->common->getDate()
				);

				$this->db->where('Id', $insert_id);
				$this->db->update('mt3_transfer', $data);
				$resp_arr = array(
										"message"=>$message,
										"status"=>1,
										"statuscode"=>$statuscode,
									);
				$json_resp =  json_encode($resp_arr);
			}
			else if($message ==  "InSufficient Balance" or $message ==  "Internal Error")
		    {
		        $resp_arr = array(
						"message"=>"Your Transaction Submitted Successfully.",
						"status"=>0,
						"statuscode"=>"TUP",
					);
				$json_resp =  json_encode($resp_arr);
		    }
		    else
		    {
		    	
		    		$transaction_type = "DMR";
					$dr_amount = $amount;
					$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
					$sub_txn_type = "REMITTANCE";
					$remark = "Money Remittance";
					$this->load->model("Paytm");
					$this->Paytm->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
					$data = array(
							'RESP_statuscode' => $statuscode,
							'RESP_status' => $message,
							'Status'=>'FAILURE',
							'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
				
					$resp_arr = array(
											"message"=>$message,
											"status"=>1,
											"statuscode"=>"ERR"
										);
					$json_resp =  json_encode($resp_arr);
		    }
		}
		else
		{
			
		    
				$data = array(
						'RESP_statuscode' => "TUP",
						'RESP_status' => "Transaction Under Process",
						'Status'=>'PENDING',
						'edit_date'=>$this->common->getDate()
				);

				$this->db->where('Id', $insert_id);
				$this->db->update('mt3_transfer', $data);
				$resp_arr = array(
										"message"=>$message,
										"status"=>1,
										"statuscode"=>$statuscode,
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
		$this->loging("zpuls_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
    }
    else
    {
        echo "Duplicate Request Found";exit;
    }
    

    	
	
}



public function Resend_Api_call_only($Id)
{
	$req_fname = "Bhavesh";
	$req_lname = "ABCD";

    if($this->checkduplicate_resend($Id,"ZPLUS"))
	//if(true)
    {
        $postfields = '';
		$jwtToken = "";
		$transtype = "IMPSIFSC";
		$apimode = "2";
		
		
	    $insert_id = $Id;
	    $dmr_id = $Id;

	    $rslttransaction = $this->db->query("SELECT * FROM `mt3_transfer` where  (Status = 'PENDING' or Status = 'HOLD') and Id = ?",array($Id));


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
					
					
					$this->db->query("update mt3_transfer set Status = 'PENDING',API = 'ZPULS' where Id = ?",array($Id));
					$insert_id = $Id;
					 $timestamp = str_replace('+00:00', 'Z', gmdate('c', strtotime($this->common->getDate())));

			   				
	

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
		
		$ZMODE = "IMPSIFSC";
		if($mode == "NEFT")
		{
			$ZMODE = "NEFT";
		}
		$recipient_name = $benificiary_name;




$request_array = array(
		"sendermobile"=>$remittermobile,

		"firstname"=>$req_fname,
		"lastname"=>$req_lname,
		"beneficiaryname"=>$benificiary_name,
		"beneficiarymobileno"=>$remittermobile,

		"accountno"=>$benificiary_account_no,
		"ifsccode"=>$IFSC,
		"remark"=>$remittermobile,
		"transtype"=>$ZMODE,
		"transamount"=>$amount,
		"agentmerchantid"=>$Id
	);

$url = 'http://zpluscash.com/apis/v1/dmr?authKey=jsU37SHwRuiei23DS_sams&clientId=API_CLIENT86&userId=16&action=paynow&data='.urlencode(json_encode($request_array));

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
));
$buffer = $response = $buffer = curl_exec($curl);
curl_close($curl);



$this->requestlog($insert_id,json_encode($request_array),$response,$remittermobile,$benificiary_account_no,"");
$json_obj = json_decode($buffer);
							
if(isset($json_obj->MESSAGE) and isset($json_obj->STATUS))
{
		$message = $json_obj->MESSAGE;
		$status = $json_obj->STATUS;
		$statuscode =  "";
		
		

		if($status == "1")
		{
		    	$bank_ref_num = $json_obj->DATA;
				$data = array(
    					'RESP_statuscode' => "TXN",
    					'RESP_status' => $message,
    					'RESP_ipay_id' => $insert_id,
    					'RESP_opr_id' =>$bank_ref_num,
    					'RESP_name' => $benificiary_name,
    					'message'=>$benificiary_name,
    					'Status'=>'SUCCESS',
    					'edit_date'=>$this->common->getDate()
    		);
				

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
					

					$sms = 'Dear Customer, INR '.$amount.' To Ac No: '.$benificiary_account_no.' ,Beneficiary Name: '.$benificiary_name.' And Your '.$mode.' Ref No. is: '.$bank_ref_num.' is Successful.PAYIN';
					$this->common->ExecuteSmsApi($remittermobile,$sms);

					$resp_arr = array(
										"message"=>$message,
										"status"=>0,
										"statuscode"=>"TXN",
										"data"=>array(
											"tid"=>$insert_id,
											"ref_no"=>$insert_id,
											"opr_id"=>$bank_ref_num,
											"name"=>$recipient_name,
											"balance"=>0,
											"amount"=>$amount,

										)
									);
					$json_resp =  json_encode($resp_arr);

		}
		else if($status == "4")
		{
		   
          if($message == "Thank You !!.We have received your request and It will be processed soon")
          {
				$bank_ref_num = "11".rand(999999999,11111111111);
				$message = "Transaction done successfully!";

           
				$data = array(
							'RESP_statuscode' => "TXN",
							'RESP_status' => $message,
							'RESP_ipay_id' => $insert_id,
							'RESP_ref_no' => $insert_id,
							'RESP_opr_id' => $bank_ref_num,
							'Status'=>'SUCCESS',
							'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);

					$sms = 'Dear Customer, INR '.$amount.' To Ac No: '.$benificiary_account_no.' ,Beneficiary Name: '.$benificiary_name.' And Your '.$mode.' Ref No. is: '.$bank_ref_num.' is Successful.PAYIN';
					$this->common->ExecuteSmsApi($remittermobile,$sms);

					
					
					$resp_arr = array(
										"message"=>$message,
										"status"=>0,
										"statuscode"=>"TXN",
										"data"=>array(
											"tid"=>$insert_id,
											"ref_no"=>$insert_id,
											"opr_id"=>$bank_ref_num,
											"name"=>$recipient_name,
											"balance"=>0,
											"amount"=>$amount,

										)
									);
					$json_resp =  json_encode($resp_arr);
          }
          else
          {
          		$data = array(
							'RESP_statuscode' => "TUP",
							'RESP_status' => $message,
							'edit_date'=>$this->common->getDate()
					);

				$this->db->where('Id', $insert_id);
				$this->db->update('mt3_transfer', $data);
				
				$resp_arr = array(
									"message"=>$message,
									"status"=>0,
									"statuscode"=>$statuscode,
								);
			    $json_resp =  json_encode($resp_arr);
          }

		}
		else if($status == "2")
		{
		    
			//You do not have sufficient balance to perform this transaction!
			if(preg_match('/do not have sufficient balance/', $message) == 1)
			{
				$data = array(
						'RESP_statuscode' => "TUP",
						'RESP_status' => "Transaction Under Process",
						'Status'=>'PENDING',
						'edit_date'=>$this->common->getDate()
				);

				$this->db->where('Id', $insert_id);
				$this->db->update('mt3_transfer', $data);
				$resp_arr = array(
										"message"=>$message,
										"status"=>1,
										"statuscode"=>$statuscode,
									);
				$json_resp =  json_encode($resp_arr);
			}
			else if($message ==  "InSufficient Balance" or $message ==  "Internal Error")
		    {
		        $resp_arr = array(
						"message"=>"Your Transaction Submitted Successfully.",
						"status"=>0,
						"statuscode"=>"TUP",
					);
				$json_resp =  json_encode($resp_arr);
		    }
		    else
		    {
		    	
		    		$transaction_type = "DMR";
					$dr_amount = $amount;
					$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
					$sub_txn_type = "REMITTANCE";
					$remark = "Money Remittance";
					$this->load->model("Paytm");
					$this->Paytm->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);	
					$data = array(
							'RESP_statuscode' => $statuscode,
							'RESP_status' => $message,
							'Status'=>'FAILURE',
							'edit_date'=>$this->common->getDate()
					);

					$this->db->where('Id', $insert_id);
					$this->db->update('mt3_transfer', $data);
				
					$resp_arr = array(
											"message"=>$message,
											"status"=>1,
											"statuscode"=>"ERR"
										);
					$json_resp =  json_encode($resp_arr);
		    }
		}
		else
		{
			
		    
				$data = array(
						'RESP_statuscode' => "TUP",
						'RESP_status' => "Transaction Under Process",
						'Status'=>'PENDING',
						'edit_date'=>$this->common->getDate()
				);

				$this->db->where('Id', $insert_id);
				$this->db->update('mt3_transfer', $data);
				$resp_arr = array(
										"message"=>$message,
										"status"=>1,
										"statuscode"=>$statuscode,
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
		$this->loging("zpuls_hold_resend",$url."?".$postfields,$buffer,$json_resp,$userinfo->row(0)->username);
		return $json_resp;
    }
    else
    {
        echo "Duplicate Request Found";exit;
    }
    

    	
	
}




public function getsenderlimit($sender_no)
{
	$url = 'http://zpluscash.com/apis/v1/dmr?authKey=jsU37SHwRuiei23DS_sams&clientId=API_CLIENT86&userId=16&action=senderinfo&data={"sendermobile":"'.$sender_no.'"}';

		$resp_array = array();
		$response =  $this->common->callurl($url);
		$json_obj = json_decode($response);
		if(isset($json_obj->STATUS))
		{
			$STATUS = trim($json_obj->STATUS);
			if($STATUS == "1")
			{
				if(isset($json_obj->DATA))
				{
					$DATA = $json_obj->DATA;
					if(isset($DATA->impslimit))
					{
						$impslimit = $DATA->impslimit;
						return $impslimit;
					}
				}
			}
		}
		return 50000;
}
	


public function transfer_status_zpuls($dmr_id)
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
	
	
	
	if($resultdmr->num_rows() == 1)
	{
		$Status = $resultdmr->row(0)->Status;
		$user_id = $resultdmr->row(0)->user_id;
		$DId = $resultdmr->row(0)->DId;
		$API = $resultdmr->row(0)->API;
		$RESP_status = $resultdmr->row(0)->RESP_status;
		$Amount = $amount =  $resultdmr->row(0)->Amount;
		$debit_amount = $resultdmr->row(0)->debit_amount;
		
		$RESP_opr_id = $resultdmr->row(0)->RESP_opr_id;
		$RESP_name = $resultdmr->row(0)->RESP_name;

		$benificiary_account_no = $resultdmr->row(0)->AccountNumber;
		$benificiary_ifsc = $resultdmr->row(0)->IFSC;
		$Charge_Amount = $resultdmr->row(0)->Charge_Amount;
		$remittermobile = $resultdmr->row(0)->RemiterMobile;
		
		$dist_charge_amount= $resultdmr->row(0)->dist_charge_amount;
		$Description = "DMR ".$remittermobile." Acc No : ".$benificiary_account_no;
		$sub_txn_type = "REMITTANCE";
		$remark = "Money Remittance";
		

		if($Status == "SUCCESS")
		{
			$resp_status = "0";
			$RESP_statuscode = "TXN";
			$resp_arr = array(
							"message"=>$Status,
							"status"=>$resp_status,
							"statuscode"=>$RESP_statuscode,
							"data"=>array(
								"tid"=>$dmr_id,
								"ref_no"=>"",
								"opr_id"=>$RESP_opr_id,
								"name"=>$RESP_name,
								"balance"=>0,
								"amount"=>$Amount,

							)
						);
			$json_resp =  json_encode($resp_arr);
			echo $json_resp;exit;
		}
		else if($Status == "PENDING")
		{
			$request_array = array(
			"agentmerchantid"=>$dmr_id
			);


	$url = 'http://zpluscash.com/apis/v1/dmr?authKey=jsU37SHwRuiei23DS_sams&clientId=API_CLIENT86&userId=16&&action=checkpaymentstatus&data='.urlencode(json_encode($request_array));
	//echo $url;exit;
	//$url = 'http://zpluscash.com/apis/v1/dmr?authKey=12Sde4W8st6dfd_truepay&clientId=DMR_CLIENT85&userId=14&action=verifybene&data={"sendermobile":"8238232303","firstname":"Bhavesh","lastname":"bhai","beneficiaryname":"ABCDEFG","beneficiarymobileno":"8238232303","accountno":"0964000102016012","ifsccode":"PUNB0096400","remark":"8238232303","agentmerchantid":17}';

	

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	));

	$response = curl_exec($curl);

	curl_close($curl);

	$json_obj = json_decode($response);

	if(isset($json_obj->STATUS))
	{	

		$STATUS = (string)$json_obj->STATUS;
		$MESSAGE = (string)$json_obj->MESSAGE;

		$DATA = $json_obj->DATA;
	
		if(isset($DATA->transactionstatus) and isset($DATA->agentmerchantid) and isset($DATA->paymentid))
		{
			
			$transactionstatus = (string)$DATA->transactionstatus;
			
			$paymentid = (string)$DATA->paymentid;
			$bank_ref_num = "";
			$dmt_status = "";
			if($transactionstatus == "DONE")
			{
				$dmt_status = 'SUCCESS';
				$bank_ref_num = (string)$DATA->transactionid;
			}
			if($transactionstatus == "REQSENT")
			{
				$dmt_status = 'PENDING';
				$bank_ref_num = "";
			}

			if($dmt_status == "SUCCESS")
			{
				$data = array(
								'RESP_statuscode' => "TXN",
								'RESP_status' => $MESSAGE,
								'RESP_ipay_id' => $dmr_id,
								'RESP_ref_no' => $dmr_id,
								'RESP_opr_id' => $bank_ref_num,
								'Status'=>'SUCCESS',
								'edit_date'=>$this->common->getDate()
						);

				$this->db->where('Id', $dmr_id);
				$this->db->update('mt3_transfer', $data);
			}
			
			$resp_status = "1";
			$RESP_statuscode = "ERR";
			$resp_arr = array(
							"message"=>$transactionstatus."#".$bank_ref_num,
							"status"=>1,
							"statuscode"=>"TUP",
							"data"=>array(
								"tid"=>$dmr_id,
								"ref_no"=>"",
								"opr_id"=>$bank_ref_num,
								"name"=>"",
								"balance"=>0,
								"amount"=>"",

							)
						);
			$json_resp =  json_encode($resp_arr);
			echo $json_resp;exit;
		

		}
	}
	
		}
		else if($Status == "FAILURE")
		{
			$resp_status = "1";
			$RESP_statuscode = "ERR";
			$resp_arr = array(
							"message"=>$Status,
							"status"=>$resp_status,
							"statuscode"=>$RESP_statuscode,
							"data"=>array(
								"tid"=>$dmr_id,
								"ref_no"=>"",
								"opr_id"=>$RESP_opr_id,
								"name"=>$RESP_name,
								"balance"=>0,
								"amount"=>$Amount,

							)
						);
			$json_resp =  json_encode($resp_arr);
			echo $json_resp;exit;
		}


		
		
	}
	
}	




}

?>