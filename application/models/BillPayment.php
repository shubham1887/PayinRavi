<?php
class BillPayment extends CI_Model 
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
		return "";
	}
	private function getPassword()
	{
		return "";
	}
	private function getdeveloper_key()
	{
		return "";
	}

	



	public function fetchbill($userinfo,$company_info,$service_no,$CustomerMobile,$option1 = "",$option2 = "")
	{
		$json_resp = "";

		// error_reporting(-1);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;
		$api_id = false;
		if($company_info->num_rows() == 1)
		{
			$validation_api = $company_info->row(0)->validation_api;
			if($validation_api > 0)
			{
				$api_id = $validation_api;
			}



			$ipaddress = $this->common->getRealIpAddr();
			$payment_mode = "CASH";
			$payment_channel = "AGT";
			$url= '';
			$buffer = '';

			$ApiInfo = $this->db->query("select * from api_configuration where Id = ?",array($api_id));
			if($ApiInfo->num_rows() == 1)
			{
				$api_id = $ApiInfo->row(0)->Id;
				

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
								
									$insert_rslt = $this->db->query("insert into tblbillcheck(add_date,ipaddress,user_id,mobile,customer_mobile,company_id) values(?,?,?,?,?,?)",array($this->common->getDate(),$ipaddress,$user_id,$service_no,$CustomerMobile,$company_id));
									if($insert_rslt == true)
									{
										$insert_id = $this->db->insert_id();
										$transaction_type = "BILL";
										$Description = "Service No.  ".$service_no;
										$sub_txn_type = "BILL";
										$remark = "Bill PAYMENT";
										$Charge_Amount = 0.00;
										
										



										$operatorcode_rslt = $this->db->query("
			                                                	    select 
			                                                	    a.company_id,
			                                                	    a.company_name,
			                                                	    a.mcode,
			                                                	    a.service_id,
			                                                	    b.service_name,
			                                                	    g.commission,
			                                                	    g.commission_type,
			                                                	    g.commission_slab,
			                                                	    g.OpParam1,
			                                                	    g.OpParam2,
			                                                	    g.OpParam3,
			                                                	    g.OpParam4,
			                                                	    g.OpParam5
			                                                	    
			                                                	    from tblcompany a 
			                                                	    left join tblservice b on a.service_id = b.service_id 
			                                                	    left join tbloperatorcodes g on g.api_id = ? and a.company_id = g.company_id
			                                                	    where a.company_id = ?
			                                                	    order by service_id",array($api_id,$company_id));
			                                                	    $OpParam1 = '';
			                                                	    $OpParam2 = '';
			                                                	    $OpParam3 = '';
			                                                	    $OpParam4 = '';
			                                                	    $OpParam5 = '';
			                                            if($operatorcode_rslt->num_rows() == 1)
			                                            {
			                                                $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
			                                                $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
			                                                $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
			                                                $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
			                                                $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
			                                            }
		if($ApiInfo->row(0)->api_name == "SWIFT")
		{
			$request_array = array(

				"ClientRefId"=>$insert_id,
				"Number"=>$service_no,
				"SPKey"=>$OpParam1,
				"TelecomCircleID"=>"0",
				"Optional1"=>"",
				"Optional2"=>"",
				"Optional3"=>"",
				"Optional4"=>"",
				"Optional5"=>"",
				"Optional6"=>"",
				"Optional7"=>"",
				"Optional8"=>"",
				"Optional9"=>"",

		);

		//	print_r($request_array);exit;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://mswift.quicksekure.com/api/BBPS/BBPSBillFetch",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>json_encode($request_array),
		  CURLOPT_HTTPHEADER => array(
		  	 "Header: Content-Type: application/json",
		    "ClientID: ",
		    "SecretKey: ",
		    "TokenID: ",
		    "Accept: application/json",
		    "ContentType: application/json",
		    "Content-Type: application/json"
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$json_obj = json_decode($response);

		if(isset($json_obj->ResponseCode) and isset($json_obj->ResponseMessage))
		{
			$ResponseCode = trim($json_obj->ResponseCode);
			$ResponseMessage = trim($json_obj->ResponseMessage);
			
			if($ResponseCode == '000')
			{
				$dueamount = $json_obj->dueamount;
				$duedate = $json_obj->duedate;
				$customername = $json_obj->customername;
				$billnumber = $json_obj->billnumber;
				$billdate = $json_obj->billdate;
				$acceptPartPay = $json_obj->acceptPartPay;

				$BBPSCharges = $json_obj->BBPSCharges;
				$RequestID = $json_obj->RequestID;
				$ClientRefId = $json_obj->ClientRefId;





				

				$this->db->query("update tblbillcheck set check_dueamount = ?,check_duedate=?,check_customername=?,check_billnumber=?,check_billdate=?,check_billperiod=?,check_reference_id = ? where Id = ?",array($dueamount,$duedate,$customername,$billnumber,$billdate,"",$RequestID,$insert_id ));




				/*
				{"statuscode":"TXN","status":"0","message":"BILL FETCH SUCCESSFUL",
		"particulars":
		{
		    "dueamount":16960,"duedate":"2020-01-07","customername":"MR. BRIJ KISHORE SHARMA",
		    "billnumber":"150895735","billdate":"2019-12-20",
		    "billperiod":"JANUARY","reference_id":492751
		    
		}
		    
				*/
				$display_array = array(array(
										"label"=>"Customer Name",
										"value"=>"".$customername
									));

				$display_array = json_encode($display_array);
				$resparray = array(

					"statuscode"=>"TXN",
					"status"=>"0",
					"message"=>"BILL FETCH SUCCESSFUL",
					"particulars"=>array(
										"dueamount"=>(string)$dueamount,
										"duedate"=>$billdate,
										"customername"=>$customername,
										"billnumber"=>"",
										"billdate"=>"",
										"billperiod"=>"",
										"reference_id"=>""
					),

					"Response"=>"SUCCESS",
					"Price"=>(string)$dueamount,
					"billduedate"=>$billdate,
					"DisplayValues"=>$display_array
				);
				echo json_encode($resparray);exit;


				return $buffer;
			}
			else
			{
				$resp_arr = array(
				"Response"=>"ERROR",
				"Message"=>$ResponseMessage,
				"message"=>$ResponseMessage,
				"status"=>1,
				"statuscode"=>"ERR",
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
		else
		{
			$hostname = $ApiInfo->row(0)->hostname;
			$params= $ApiInfo->row(0)->validation_api;
		    		
			$params = str_replace("@param1",$ApiInfo->row(0)->param1,$params);
			$params = str_replace("@opparam1",$operatorcode_rslt->row(0)->OpParam1,$params);
			$params = str_replace("@mn",$service_no,$params);
			$params = str_replace("@custmn",$CustomerMobile,$params);
			$params = str_replace("@reqid",$insert_id,$params);
			$params = str_replace("@field1",$option1,$params);
			$params = str_replace("@field2",$option2,$params);
			
			$url = $hostname.$params;
			$response = $this->common->callurl($url);
			$rsltfetchparsing = $this->db->query('SELECT Id,api_id,customerNameStart,customerNameEnd,BillAmountStart,BillAmountEnd,DueDateStart,DueDateEnd FROM bill_fetch_parsing where api_id = ?',array($ApiInfo->row(0)->Id));
			foreach($rsltfetchparsing->result() as $rw)
			{
				$customerNameStart = $rw->customerNameStart;
				$customerNameEnd = $rw->customerNameEnd;
				$BillAmountStart = $rw->BillAmountStart;
				$BillAmountEnd = $rw->BillAmountEnd;
				$DueDateStart = $rw->DueDateStart;
				$DueDateEnd = $rw->DueDateEnd;

				$customerName = $this->get_string_between($response,$customerNameStart,$customerNameEnd);
				$BillAmount = $this->get_string_between($response,$BillAmountStart,$BillAmountEnd);
				$DueDate = $this->get_string_between($response,$DueDateStart,$DueDateEnd);




				$display_array = array(array(
																	"label"=>"Customer Name",
																	"value"=>"".$customerName
																));

				$display_array = json_encode($display_array);
				$resparray = array(

					"statuscode"=>"TXN",
					"status"=>"0",
					"message"=>"BILL FETCH SUCCESSFUL",
					"particulars"=>array(
										"dueamount"=>(string)$BillAmount,
										"duedate"=>$DueDate,
										"customername"=>$customerName,
										"billnumber"=>"",
										"billdate"=>"",
										"billperiod"=>"",
										"reference_id"=>""
					),

					"Response"=>"SUCCESS",
					"Price"=>(string)$BillAmount,
					"billduedate"=>$DueDate,
					"DisplayValues"=>$display_array
				);
				echo json_encode($resparray);exit;



				echo "CustName : ".$customerName."   BillAmount : ".$BillAmount."    DueDate : ".$DueDate;exit;


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
			}
		}
		return $json_resp;
	}
	public function get_string_between($string, $start, $end)
	{ 
		$string = ' ' . $string;
		if(strlen($start) > 0 )
		{
		    $ini = strpos($string, $start);    
		}
		else
		{
		    $ini = 0;
		}
		if ($ini == 0) return '';
		$ini += strlen($start);
		if($end == "")
		{
		    $len = strlen($string);
		}
		else
		{
		   $len = strpos($string, $end, $ini) - $ini;    
		}
		return substr($string, $ini, $len);
	}
	public function checkpendinglimit($api_id,$company_id)
	{
		return true;
	    $rslt = $this->db->query("select pendinglimit,failurelimit,totalpending,failurecount from pf_values where api_id = ? and company_id = ?",array($api_id,$company_id));
	    if($rslt->num_rows() == 1)
	    {
	        $pendinglimit = $rslt->row(0)->pendinglimit;
	        $failurelimit = $rslt->row(0)->failurelimit;
	        $totalpending = $rslt->row(0)->totalpending;
	        $failurecount = $rslt->row(0)->failurecount;
	        if($pendinglimit >= $totalpending or  $pendinglimit == 0)
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
	        return true;
	    }
	}

	public function recharge_transaction2($userinfo,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$ref_id,$particulars,$option2="",$option3="",$done_by = "WEB",$payment_mode = "EXPRESS",$order_id = 0)
	{
	   

		$ipaddress = $this->common->getRealIpAddr();
		$payment_mode = "CASH";
		$payment_channel = "AGT";
		$url= '';
		$buffer = '';

		$company_info = $this->db->query("select * from tblcompany where company_id = ?",array($company_id));
























	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////// A P I   S W I T C H I N G ///////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////	
	$api_name = "SWIFT";
	$api_id = false;
	$recharge_api  = false;
		
	     $ApiInfo = $this->db->query("SELECT a.company_id,a.api_id,a.amountrange,a.priority,a.status,api.api_name
	FROM `operatorpendinglimit` a
	left join api_configuration api on a.api_id = api.Id
	where a.company_id = ? and api.enable_recharge = 'yes' and a.status = 'active' and a.api_id > 0 order by a.priority",array($company_id));

	    
	    if($ApiInfo->num_rows() == 0)
	    {
	         $ApiInfo = $this->db->query("select api_name,Id from api_configuration where api_name = 'HOLD'");
	   		 $api_id = $ApiInfo->row(0)->Id; 
	    }
	    
	    else
	    {
	     
	        $k=0;
	        foreach($ApiInfo->result() as $apirw)
	        {
	            $temp_api_id = $apirw->api_id;
	            $temp_api_name = $apirw->api_name;
	            if($temp_api_name == "Random")
	            {
	        		$randomapi = $this->db->query("SELECT api_id FROM `tblrandomapirouting` where company_id = ? order by Rand() limit 1",array($company_id));
			        if($randomapi->num_rows() == 1)
			        {
			        	$pendinglimit_check = $this->checkpendinglimit($randomapi->row(0)->api_id,$company_id);
			        	if($pendinglimit_check == true )
			        	{
			        		$api_id = $randomapi->row(0)->api_id;
			        		break;	
			        	}
			        }
	            }
	            else if($temp_api_name == "Denomination_wise")
			    {
				  
			       $amountapi = $this->db->query("
			                            SELECT 
			                                a.check_offer,a.api_id,a.amounts,a.company_id,a.circle_id,a.code,b.api_name 
			                                FROM amountwiseapi a 
			                                left join api_configuration b on a.api_id = b.Id 
			                                left join operatorpendinglimit op on a.company_id = op.company_id and a.api_id = op.api_id
			                                where a.company_id = ? and b.enable_recharge = 'yes' and (b.is_active = 'yes' or a.api_id <= 3)  order by a.amounts desc",array($company_id));
		       
		           $amount_api_name = "";
		           
		           foreach($amountapi->result() as $amtrw)//main row loop
		           {
		          	   $amount_api_found = false;
		               $amount_api_name = "";
		               $amount_api_tempid = 0;
	                  
		               if (preg_match('/,/',$amtrw->amounts) == 1 ) 
		               {
		                   
							$amounts_array = explode(",",$amtrw->amounts);
							if(in_array($amount,$amounts_array))
			                {
			                	
			                	$amount_api_name = $amtrw->api_name;
			                   	$amount_api_tempid = $amtrw->api_id;
			                   	$code2 = $amtrw->code;
			                   	$amount_api_found = true;	
		                	}
		               }
		               else if (preg_match('/<->/',$amtrw->amounts) == 1 )
		               {
		                 	$amt_range = explode("<->",$amtrw->amounts);
	    	                $min_amt = $amt_range[0];
	    	                $max_amt = $amt_range[1];

	    	                if($amount >= $min_amt and $amount <= $max_amt)
	    	                {
	    	                	
		                	   $amount_api_name = $amtrw->api_name;
			                   $amount_api_tempid = $amtrw->api_id;
			                   $code2 = $amtrw->code;
			                   $amount_api_found = true;	
			                	
	    	                }
		               }

		               if($amount_api_found == true and $amount_api_tempid > 0 )
		               {

		               		if($amount_api_name == "Random")
				            {
				               $randomapi = $this->db->query("SELECT a.api_id,b.api_name FROM `tblrandomapirouting` a left join api_configuration b on a.api_id = b.Id where a.company_id = ? order by Rand() limit 1",array($company_id));
				                if($randomapi->num_rows() == 1)
				                {
				                	$pendinglimit_check = $this->checkpendinglimit($randomapi->row(0)->api_id,$company_id);
			                   		if($pendinglimit_check == true)	
			                   		{
			                   			$api_id = $randomapi->row(0)->api_id;
				                    	break 2;
			                   		}  
				                }
				            }
				            else if($amount_api_tempid > 3)
				            {
				            
				            	$pendinglimit_check = $this->checkpendinglimit($amount_api_tempid,$company_id);
		                   		if($pendinglimit_check == true)	
		                   		{
		                   			$api_id = $amount_api_tempid;
				                	break 2;
		                   		}
				            }
		               }
		           }   
			    }
			    
			    else
			    {
			    	$pendinglimit_check = $this->checkpendinglimit($apirw->api_id,$company_id);
	        		if($pendinglimit_check == true )
	        		{
	        			$api_id = $apirw->api_id;
	        			break;
	        		}
			    }
	            
	            $k++;
	        }
	    }
	    /////////////////////////////////////////////////////////////////////////////
	    ////xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx///
	    /////////////////////////////////////////////////////////////////////////////	








	   $ApiInfo = $this->db->query("select * from api_configuration where Id = ?",array($api_id));
	   if($ApiInfo->num_rows() == 0)
	   {

	   		$ApiInfo = $this->db->query("select * from api_configuration where api_name = 'HOLD'");
	   		$api_id = $ApiInfo->row(0)->Id; 
	   		$api_name =  $ApiInfo->row(0)->api_name;
	   }
	   else
	   {
	   		$api_name =  $ApiInfo->row(0)->api_name;
	   		$api_id = $ApiInfo->row(0)->Id; 
	   }


















	    
		if($ApiInfo->num_rows() == 1)
		{
			$api_id = $ApiInfo->row(0)->Id;
			$api_name = $ApiInfo->row(0)->api_name;
			if($userinfo != NULL)
			{
				if($userinfo->num_rows() == 1)
				{
					
					$user_id = $userinfo->row(0)->user_id;
					$parentid = $userinfo->row(0)->parentid;
					$usertype_name = $userinfo->row(0)->usertype_name;
					$user_status = $userinfo->row(0)->status;
					$utility_group = $userinfo->row(0)->utility_group;
					if($usertype_name == "Agent" or $usertype_name == "APIUSER")
					{
						if($Amount < $company_info->row(0)->minamt )
					    {

					    	$status = "FAILED";
							$opr_id = "";
							$StatusCode = "0";
							$Message = "You can only pay between  ".$company_info->row(0)->minamt."-".$company_info->row(0)->mxamt;
							return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
					    }
					    else if($Amount > $company_info->row(0)->mxamt )
					    {
							$status = "FAILED";
							$opr_id = "";
							$StatusCode = "0";
							$Message = "You can only pay between  ".$company_info->row(0)->minamt."-".$company_info->row(0)->mxamt;
							return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
					    }
					    else if($userinfo->row(0)->service == 'no' )
					    {
					    	$status = "FAILED";
							$opr_id = "";
							$StatusCode = "0";
							$Message = "Userinfo Missing";
							return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
					    }
					     $rsltcheck = $this->db->query("SELECT Id FROM  tblbills  where service_no = ? and user_id = ? and Status != 'FAILURE' and Date(add_date) = ?
	ORDER BY Id  DESC",array($Mobile,$userinfo->row(0)->user_id,$this->common->getMySqlDate()));
		                if($rsltcheck->num_rows() == 1)
		                //if(false)
		                {
		                	$status = "FAILED";
							$opr_id = "";
							$StatusCode = "0";
							$Message = "Duplicate Request Found";
							return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
		                }
						else if($user_status == '1')
						{
								$crntBalance = $this->Ew2->getAgentBalance($user_id);
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


	    					error_reporting(-1);
	    					ini_set('display_errors',1);
	    					$this->db->db_debug = TRUE;
	                            //print_r($billcheck_rslt->result());exit;
	    							
	    							// $insert_rslt = $this->db->query("insert into tblbills(add_date,ipaddress,user_id,service_no,customer_mobile,company_id,bill_amount,paymentmode,payment_channel,status,customer_name,dueamount,duedate,billnumber,billdate,billperiod,option1,done_by,API)
	    							// values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
	    							// array($this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id,$Amount,$payment_mode,$payment_channel,"Pending",$custname,$dueamount,$duedate,$billnumber,$billdate,$billperiod,$option1,$done_by,$api_name));
	    						$operatorcode_rslt = $this->db->query("
		                                                	    select 
		                                                	    a.company_id,
		                                                	    a.company_name,
		                                                	    a.mcode,
		                                                	    a.service_id,
		                                                	    b.service_name,
		                                                	    g.commission,
		                                                	    g.commission_type,
		                                                	    g.commission_slab,
		                                                	    g.OpParam1,
		                                                	    g.OpParam2,
		                                                	    g.OpParam3,
		                                                	    g.OpParam4,
		                                                	    g.OpParam5
		                                                	    
		                                                	    from tblcompany a 
		                                                	    left join tblservice b on a.service_id = b.service_id 
		                                                	    left join tbloperatorcodes g on g.api_id = ? and a.company_id = g.company_id
		                                                	    where a.company_id = ?
		                                                	    order by service_id",array($api_id,$company_id));
		                                                	    $OpParam1 = '';
		                                                	    $OpParam2 = '';
		                                                	    $OpParam3 = '';
		                                                	    $OpParam4 = '';
		                                                	    $OpParam5 = '';
		                                            if($operatorcode_rslt->num_rows() == 1)
		                                            {
		                                                $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
		                                                $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
		                                                $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
		                                                $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
		                                                $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
		                                            }





















	    							$MdId = 0;
	    							$dist_info = $this->db->query("select * from tblusers where user_id = ?",array($userinfo->row(0)->parentid));
	    							if($dist_info->num_rows() == 1)
	    							{
	    								$MdId = $dist_info->row(0)->parentid;
	    							}

	    							$status = "Pending";

	    							$commission_amount = 0;
	    							$commission_per = 0;
	    							$dist_commission_amount = 0;
	    							$dist_commission_per = 0;
	    							$md_commission_amount = 0;
	    							$md_commission_per = 0;
	    							$DId = $userinfo->row(0)->parentid;
	    							
	    							$ExecuteBy = $api_name;
	    							$state_id = 0;
	    							$adminComPer = 0;
	    							$adminCom = 0;
	    							$host_id = 1;
	    							$flatcomm = 0;


	    							$RComm = 0;
	    							$SdComm = 0;
									$MdComm = 0;
									$DComm = 0;
									$RComm = 0;
	    							$commission_type = "PER";
	    							//////////////////////commission calculation
	    							$company_info = $this->db->query("select service_id from tblcompany where company_id = ?",array($company_id));
									if($company_info->num_rows() == 1)
									{
										$service_id = $company_info->row(0)->service_id;
										
										
												$commission_info = $this->db->query("select SdComm,MdComm,DComm,RComm,commission_type from tblutilitycommission where group_id = (select Id from utility_group where Name = 'Default_utility_group') and service_id = ?",array($service_id));
												if($commission_info->num_rows() == 1)
												{
													$SdComm = $commission_info->row(0)->SdComm;
													$MdComm = $commission_info->row(0)->MdComm;
													$DComm = $commission_info->row(0)->DComm;
													$RComm = $commission_info->row(0)->RComm;
													$commission_type = $commission_info->row(0)->commission_type;	
												}
												

											

										
									}













									//retailer charge
									$Charge_Amount =$RComm;
									if($commission_type == "PER")
									{
										$Charge_Amount =(($Amount * $RComm) / 100);
									}	



									$commission_amount =$RComm;
									if($commission_type == "PER")
									{
										$commission_amount =(($Amount * $RComm) / 100);
									}	



									$dist_commission_per = $commission_type;
									$dist_commission_amount =$DComm;
									if($dist_commission_per == "PER")
									{
										$dist_commission_amount =(($Amount * $DComm) / 100);
									}	


									$md_commission_per = $commission_type;
									$md_commission_amount =$MdComm;
									if($md_commission_per == "PER")
									{
										$md_commission_amount =(($Amount * $MdComm) / 100);
									}	





	    							$insert_rslt = $this->db->query("insert into tblbills(mode,add_date,ipaddress,user_id,service_no,customer_mobile,company_id,bill_amount,paymentmode,payment_channel,status,customer_name,dueamount,duedate,billnumber,billdate,billperiod,option1,done_by,API,order_id)
            							values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            							array($payment_mode,$this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id,$Amount,$payment_mode,$payment_channel,"Pending",$custname,$dueamount,$duedate,$billnumber,$billdate,$billperiod,$option1,$done_by,$api_name,$order_id));

	    							if($insert_rslt == true)
	    							{
	    								
	    								$insert_id = $this->db->insert_id();

	    								$recharge_id = $insert_id;

	    								$transaction_type = "BILL";







	    								
	    								$dr_amount = $Amount - $commission_amount;
	    								$Description = "Service No.  ".$Mobile." Bill Amount : ".$Amount;
	    								$sub_txn_type = "BILL";
	    								$remark = "Bill PAYMENT";
	    								$Charge_Amount = $commission_amount;
	    								
	    								$paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
	    								if($paymentdebited == true)
	    								{
	    								    
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
										    if($payment_mode == "Normal" or $dohold == 'yes')
											{
												$this->db->query("update tblbills set API  = 'HOLD' where Id = ?",array($insert_id));
												$resp_array = array(
															"Message"=>$ResponseMessage,
															"Response"=>"PENDING",
															"StatusCode"=>"1"
														);
												echo json_encode($resp_array);exit;
											}
											else
											{
												

	////////////////////////////////////////////////////////////////////////////////////////
	///***********************************************************************************//
	///***********************************************************************************//
	///***********************************************************************************//
	///*********************** A P I    R O U T I N G   S T A R T*************************//
	///***********************************************************************************//
	///***********************************************************************************//
	////////////////////////////////////////////////////////////////////////////////////////											

	if($api_name == "SWIFT")
	{
		$request_array = array(

					"ClientRefId"=>"FETCH".$insert_id,
					"Number"=>$Mobile,
					"SPKey"=>$OpParam1,
					"TelecomCircleID"=>"0",
					"Amount"=>$Amount,
					"Optional1"=>$option1,
					"Optional2"=>"",
					"Optional3"=>"",
					"Optional4"=>"",
					"Optional5"=>"",
					"Optional6"=>"",
					"Optional7"=>"",
					"Optional8"=>"",
					"Optional9"=>"",

			);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://mswift.quicksekure.com/api/BBPS/BBPSPayment",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>json_encode($request_array),
		  CURLOPT_HTTPHEADER => array(
		    "Header: Content-Type: application/json",
		    "ClientID: ",
		    "SecretKey: ",
		    "TokenID: ",
		    "Accept: application/json",
		    "ContentType: application/json",
		    "Content-Type: application/json"
		  ),
		));
		$url = "http://mswift.quicksekure.com/api/BBPS/BBPSPayment";
		$response = curl_exec($curl);


		$this->db->query("insert into tblreqresp(recharge_id,request,response,add_date,ipaddress)
													values(?,?,?,?,?)",array($insert_id,$url,$response,$this->common->getDate(),$this->common->getRealIpAddr()));

		$this->loging("SWIFT_BILL",$url." ?".json_encode($request_array),$response,"",$userinfo->row(0)->username);
		$this->loging("BILL",json_encode($request_array),$response,"",$userinfo->row(0)->username);
		$json_obj = json_decode($response);

		if(isset($json_obj->ResponseCode) and isset($json_obj->ResponseMessage))
		{
			$ResponseCode = trim($json_obj->ResponseCode);
			$ResponseMessage = trim($json_obj->ResponseMessage);
			$TransactionId  = $json_obj->TransactionId;
			$AvailableBalance  = $json_obj->AvailableBalance;
			$ClientRefId  = $json_obj->ClientRefId;
			
			if($ResponseCode == '000')//success
			{
				$opr_id = $json_obj->OperatorTransactionId;
				$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($TransactionId,$opr_id,$ResponseMessage,$insert_id));
				

				$this->load->model("Commission");
				$this->Commission->ParentCommission($insert_id);


				$resp_array = array(
					"statuscode"=>"TXN",
					"status"=>"0",
					"message"=>$ResponseMessage,
					"data"=>array(
									"ipay_id"=>$insert_id,
									"opr_id"=>$opr_id,
									"status"=>"Success"
									),
					"Message"=>$ResponseMessage,
					"Response"=>"SUCCESS"
				);
				echo json_encode($resp_array);exit;
			}
			else if($ResponseCode == '999')//pending
			{
				$opr_id = $json_obj->OperatorTransactionId;
				$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($TransactionId,$ResponseMessage,$insert_id));
				

				$resp_array = array(
					"statuscode"=>"TXN",
					"status"=>"0",
					"message"=>$ResponseMessage,
					"data"=>array(
									"ipay_id"=>$insert_id,
									"opr_id"=>$opr_id,
									"status"=>"Pending"
									),
					"Message"=>$ResponseMessage,
					"Response"=>"PENDING"
				);
				echo json_encode($resp_array);exit;

			}
			else //failure
			{
				$this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($TransactionId,$ResponseMessage,$insert_id));
				$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
					
				$resp_array = array(
					"statuscode"=>"ERR",
					"status"=>"1",
					"message"=>$ResponseMessage,
					"Message"=>$ResponseMessage,
					"Response"=>"FAILED"
				);
				echo json_encode($resp_array);exit;
			}
		}
		else
		{
			$resp_array = array(
					"statuscode"=>"ERR",
					"status"=>"1",
					"message"=>"Your Request Under Process",
					"Message"=>"Your Request Under Process",
					"Response"=>"PENDING"
				);
			echo json_encode($resp_array);exit;
		}
	}
	else
	{
		if($ApiInfo->num_rows() == 1)
	    {
	        $apiinfo = $ApiInfo;
	        $api_id = $apiinfo->row(0)->Id;
	        $api_name = $apiinfo->row(0)->api_name;
	        $api_type = $apiinfo->row(0)->api_type;
	        $is_active = $apiinfo->row(0)->is_active;
	        $enable_recharge = $apiinfo->row(0)->enable_recharge;
	        $enable_balance_check = $apiinfo->row(0)->enable_balance_check;
	        $enable_status_check = $apiinfo->row(0)->enable_status_check;
	        $hostname = $apiinfo->row(0)->hostname;
	        $param1 = $apiinfo->row(0)->param1;
	        $param2 = $apiinfo->row(0)->param2;
	        $param3 = $apiinfo->row(0)->param3;
	        $param4 = $apiinfo->row(0)->param4;
	        $param5 = $apiinfo->row(0)->param5;
	        $param6 = $apiinfo->row(0)->param6;
	        $param7 = $apiinfo->row(0)->param7;
	        
	        $header_key1 = $apiinfo->row(0)->header_key1;
	        $header_key2 = $apiinfo->row(0)->header_key1;
	        $header_key3 = $apiinfo->row(0)->header_key1;
	        $header_key4 = $apiinfo->row(0)->header_key1;
	        $header_key5 = $apiinfo->row(0)->header_key1;
	        $header_value1 = $apiinfo->row(0)->header_value1;
	        $header_value2 = $apiinfo->row(0)->header_value2;
	        $header_value3 = $apiinfo->row(0)->header_value3;
	        $header_value4 = $apiinfo->row(0)->header_value4;
	        $header_value5 = $apiinfo->row(0)->header_value5;
	        
	        $balance_check_api_method = $apiinfo->row(0)->balance_check_api_method;
	        $balance_ceck_api = $apiinfo->row(0)->balance_ceck_api;
	        $status_check_api_method = $apiinfo->row(0)->status_check_api_method;
	        $status_check_api = $apiinfo->row(0)->status_check_api;
	        $validation_api_method = $apiinfo->row(0)->validation_api_method;
	        $validation_api = $apiinfo->row(0)->validation_api;
	        $transaction_api_method = $apiinfo->row(0)->transaction_api_method;
	        $api_prepaid = $apiinfo->row(0)->api_prepaid;
	        $api_dth = $apiinfo->row(0)->api_dth;
	        $api_postpaid = $apiinfo->row(0)->api_postpaid;
	        
	        $api_electricity = $apiinfo->row(0)->api_electricity;
	        $api_gas = $apiinfo->row(0)->api_gas;
	        $api_insurance = $apiinfo->row(0)->api_insurance;
	        $dunamic_callback_url = $apiinfo->row(0)->dunamic_callback_url;
	        $response_parser = $apiinfo->row(0)->response_parser;
	        
	        
	        $recharge_response_type = $apiinfo->row(0)->recharge_response_type;
	        $response_separator = $apiinfo->row(0)->response_separator;
	        
	        $recharge_response_status_field = $apiinfo->row(0)->recharge_response_status_field;
	        $recharge_response_opid_field = $apiinfo->row(0)->recharge_response_opid_field;
	        $recharge_response_apirefid_field = $apiinfo->row(0)->recharge_response_apirefid_field;
	        
	        $recharge_response_balance_field = $apiinfo->row(0)->recharge_response_balance_field;
	        $recharge_response_remark_field = $apiinfo->row(0)->recharge_response_remark_field;
	        $recharge_response_stat_field = $apiinfo->row(0)->recharge_response_stat_field;
	        
	        $recharge_response_fos_field = $apiinfo->row(0)->recharge_response_fos_field;
	        $recharge_response_otf_field = $apiinfo->row(0)->recharge_response_otf_field;
	        
	         $recharge_response_lapunumber_field = $apiinfo->row(0)->recharge_response_lapunumber_field;
	         $recharge_response_message_field = $apiinfo->row(0)->recharge_response_message_field;
	         $pendingOnEmptyTxnId = $apiinfo->row(0)->pendingOnEmptyTxnId;
	         $RecRespSuccessKey = $apiinfo->row(0)->RecRespSuccessKey;
	         $RecRespPendingKey = $apiinfo->row(0)->RecRespPendingKey;
	         $RecRespFailureKey = $apiinfo->row(0)->RecRespFailureKey;
	         $RecRespFailureText = $apiinfo->row(0)->RecRespFailureText;
	          
	         ///////////////////////////////////////////
	         ////////////////////////////////////////
	         ///////////////////////
	         ///////////////////////////////////////////
	            	         
		    $OpParam1 = '';
		    $OpParam2 = '';
		    $OpParam3 = '';
		    $OpParam4 = '';
		    $OpParam5 = '';
	        if($operatorcode_rslt->num_rows() == 1)
	        {
	            $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
	            $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
	            $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
	            $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
	            $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
	        }
	        $url = $hostname;
	        
	        if($company_info->row(0)->service_id == 1)
	        {
	        	$api_prepaid = $api_prepaid;
	        }
	        if($company_info->row(0)->service_id == 2)
	        {
	        	$api_prepaid = $api_dth;
	        }
	        if($company_info->row(0)->service_id == 3)
	        {
	        	$api_prepaid = $api_postpaid;
	        }
	        if($company_info->row(0)->service_id == 16)
	        {
	        	$api_prepaid = $api_electricity;
	        }
	        if($company_info->row(0)->service_id == 17)
	        {
	        	$api_prepaid = $api_gas;
	        }
	        

	        if($transaction_api_method == "GET")
	        {
	            ///$userinfo,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$ref_id,$particulars,$option2="",$option3="",$done_by = "WEB",$order_id = 0
	            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
	            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
	            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
	            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
	            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
	            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
	            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);



	            
	            $url = $hostname.$api_prepaid;
	            $url  = str_replace("@mn",$Mobile, $url);
	            $url  = str_replace("@amt",$Amount, $url);
	            $url  = str_replace("@opparam1",$OpParam1, $url);
	            $url  = str_replace("@opparam2",$OpParam2, $url);
	            $url  = str_replace("@opparam3",$OpParam3, $url);
	            $url  = str_replace("@opparam4",$OpParam4, $url);
	            $url  = str_replace("@opparam5",$OpParam5, $url);
	            $url  = str_replace("@reqid",$insert_id, $url);


	            $url  = str_replace("@option1",$option1, $url);
	            $url  = str_replace("@option2",$option2, $url);
	            $url  = str_replace("@custmn",$CustomerMobile, $url);

	            $response = $this->common->callurl(trim($url),"BBPS".$recharge_id);  
	        }
	        if($transaction_api_method == "POST")
	        {
	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
	            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
	            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
	            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
	            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
	            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
	            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
	            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);
	            
	            $url = $hostname.$api_prepaid;
	            $url  = str_replace("@mn",$Mobile, $url);
	            $url  = str_replace("@amt",$Amount, $url);
	            $url  = str_replace("@opparam1",$OpParam1, $url);
	            $url  = str_replace("@opparam2",$OpParam2, $url);
	            $url  = str_replace("@opparam3",$OpParam3, $url);
	            $url  = str_replace("@opparam4",$OpParam4, $url);
	            $url  = str_replace("@opparam5",$OpParam5, $url);
	            $url  = str_replace("@reqid",$recharge_id, $url);
	            $url  = str_replace("@option1",$option1, $url);
	            $url  = str_replace("@option2",$option2, $url);
	            $url  = str_replace("@custmn",$CustomerMobile, $url);
	            //$url = explode("?",$url)[0];
	            $postdata = explode("?",$url)[1];
	            $response = $this->common->callurl_post(trim($url),$postdata,"BBPS".$recharge_id);  
	        }
	        
	        
	        if($recharge_response_type == "XML")
	        {
	            $obj = (array)simplexml_load_string( $response);
	           
	            $recharge_response_status_field = str_replace("<","",$recharge_response_status_field);
	            $recharge_response_status_field = str_replace(">","",$recharge_response_status_field);
	            
	            
	             $recharge_response_otf_field = str_replace("<","",$recharge_response_otf_field);
	            $recharge_response_otf_field = str_replace(">","",$recharge_response_otf_field);
	            
	            // echo $recharge_response_status_field;
	            // echo "<br><br>";
	            // print_r($obj);exit;
	            
	            $recharge_response_opid_field = str_replace("<","",$recharge_response_opid_field);
	            $recharge_response_opid_field = str_replace(">","",$recharge_response_opid_field);
	            
	            
	            $recharge_response_balance_field = str_replace("<","",$recharge_response_balance_field);
	            $recharge_response_balance_field = str_replace(">","",$recharge_response_balance_field);
	            
	            if(isset($obj[$recharge_response_status_field]))
	            {
	                $statusvalue = $obj[$recharge_response_status_field];
	            
	                $operator_id = json_encode($obj[$recharge_response_opid_field]);
	                $operator_id = str_replace('"','',$operator_id);
	                $lapubalance = 0;
	                if(isset($obj[$recharge_response_balance_field]))
	                {
	                    $lapubalance = $obj[$recharge_response_balance_field];    
	                }
	                
	                
	                
	                $roffer = 0;
	                if(isset($obj[$recharge_response_otf_field]))
	                {
	                    $roffer = $obj[$recharge_response_otf_field];    
	                }
	                
	                $success_key_array = explode(",",$RecRespSuccessKey);
	                $failure_key_array = explode(",",$RecRespFailureKey);
	                $pending_key_array = explode(",",$RecRespPendingKey);
	                
	               
	                if (in_array($statusvalue, $success_key_array)) 
	                {
	                	$ResponseMessage = "Transaction Success";
	                    $status = 'Success';
	                    $opr_id = $operator_id;
						$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
						

						$StatusCode = "1";
						$Message = "Transaction Success";
						return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                }
	                else if (in_array($statusvalue, $failure_key_array)) 
	                {
	                	$ResponseMessage = "Transaction Failed";
	                    $status = 'Failure';
	                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
						$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
						
						$opr_id = "";	
						$StatusCode = "0";
						$Message = "Transaction Failure";
						return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                }
	                else  if (in_array($statusvalue, $pending_key_array)) 
	                {
	                    $status = 'Pending';
	                    $operator_id = "";
	                    $opr_id = $operator_id;
	                    $ResponseMessage = "Transaction In Pending Process";
						$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
						

						$StatusCode = "1";
						$Message = "Transaction Success";
						return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                }   
	            }
	            else
	            {
	                $status = 'Pending';
	                $operator_id = "";
	                $opr_id = $operator_id;
	                $ResponseMessage = "Transaction In Pending Process";
					$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
					

					$StatusCode = "1";
					$Message = "Transaction Success";
					return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	            }
	        }
	        else if($recharge_response_type == "JSON")
	        {
	            $obj = (array)json_decode($response);
	           
	            
	            
	            if(isset($obj[$recharge_response_status_field]))
	            {
	            	$statusvalue = "";
	            	if(isset($obj[$recharge_response_status_field]))
	            	{
	            		$statusvalue = $obj[$recharge_response_status_field];	
	            	}
	                





	                $operator_id = "";
	                $first_recharge_response_opid_field = false;
					$second_recharge_response_opid_field = false;
			    	if(preg_match("/./", $recharge_response_opid_field))
			    	{
			    		$firstsecond_array = explode(".",$recharge_response_opid_field);
			    		if(count($firstsecond_array) == 2)
			    		{
			    			$first_recharge_response_opid_field = (string)$firstsecond_array[0];
			    				$second_recharge_response_opid_field = (string)$firstsecond_array[1];	
			    		}
			    		
			    		//echo $first_param."   ".$second_param;exit;
			    	}

			    	if($first_recharge_response_opid_field != false and $second_recharge_response_opid_field != false)
			    	{
			    		if(isset($obj[$first_recharge_response_opid_field]->$second_recharge_response_opid_field))
			            {
			            	$operator_id = $obj[$first_recharge_response_opid_field]->$second_recharge_response_opid_field;	
			            }
			    	}
			    	else
			    	{
			    		if(isset($obj[$recharge_response_opid_field]))
			            {
			            	$operator_id = $obj[$recharge_response_opid_field];	
			            }
			    	}
	                $roffer = 0;
	                if(isset($obj[$recharge_response_otf_field]))
	                {
	                    $roffer = $obj[$recharge_response_otf_field];    
	                }
	                
	                $lapubalance = 0;
	                if(isset($obj[$recharge_response_balance_field]))
	                {
	                    $lapubalance = $obj[$recharge_response_balance_field];    
	                }
	            
	                $success_key_array = explode(",",$RecRespSuccessKey);
	                $failure_key_array = explode(",",$RecRespFailureKey);
	                $pending_key_array = explode(",",$RecRespPendingKey);
	                $failure_text_array = explode(",",$RecRespFailureText);
	                
	               
	                if($statusvalue != "")
	                {
	                	foreach($success_key_array as $success_key)
	           			{
	               			$statusvalue = trim($statusvalue);
	               			$success_key = trim($success_key);
	               			if($statusvalue == $success_key)
	               			{
	               				$ResponseMessage = "Transaction Success";
			                    $status = 'Success';
			                    $opr_id = $operator_id;
								$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
								

								$StatusCode = "1";
								$Message = "Transaction Success";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			}
	               		}

	               		///check pending
	               		foreach($pending_key_array as $pending_key)
	               		{
	               			$statusvalue = trim($statusvalue);
	               			$pending_key = trim($pending_key);
	               			if($statusvalue == $pending_key)
	               			{
	               				$status = 'Pending';
			                    $operator_id = "";
			                    $opr_id = $operator_id;
			                    $ResponseMessage = "Transaction In Pending Process";
								$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								
								$StatusCode = "1";
								$Message = "Transaction Success";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			}
	               		}
	               
	               		///check failure
	               		foreach($failure_key_array as $failure_key)
	               		{
	               			$statusvalue = trim($statusvalue);
	               			$failure_key = trim($failure_key);
	               			if($statusvalue == $failure_key)
	               			{
	               				$ResponseMessage = "Transaction Failed";
			                    $status = 'Failure';
			                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
									
								$opr_id = "";
								$StatusCode = "0";
								$Message = "Transaction Failure";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			}
	               		}

	               		///// check failurekeytet
	               		foreach($failure_text_array as $failure_text)
	               		{
	               			if(strlen($failure_text) >= 6)
	               			{
	               				if (preg_match("/".$failure_text."/",$response)  == 1)
			               		{

		               				$status = 'Failure';
		                        	$ResponseMessage = "Transaction Failed";
				                    $status = 'Failure';
				                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
									$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
										
									$opr_id = "";
									$StatusCode = "0";
									$Message = "Transaction Failure";
									return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
		                            break;
		               			
			               		}	
	               			}
	               		}
	                }
	                else
	               {
	               		$response_send = false;
	               		///// check failurekeytet
	               		foreach($failure_text_array as $failure_text)
	               		{
	               			if(strlen($failure_text) >= 6)
	               			{
	               				if (preg_match("/".$failure_text."/",$response)  == 1)
			               		{

		               				$status = 'Failure';
		                        	$ResponseMessage = "Transaction Failed";
				                    $status = 'Failure';
				                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
									$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
										
									$opr_id = "";
									$StatusCode = "0";
									$Message = "Transaction Failure";
									return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
		                            break;
		               			
			               		}	
	               			}
	               		}
				   } 
	            }
	            else
	            {
	                $status = 'Pending';
	                $operator_id = "";
	                $opr_id = $operator_id;
	                $ResponseMessage = "Transaction In Pending Process";
					$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
					


					$StatusCode = "1";
					$Message = "Transaction Success";
					return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	            }
	        }
	        else if($recharge_response_type == "CSV")
	        {
	            $obj = explode($response_separator,$response);
	           
	            if(isset($obj[$recharge_response_status_field]))
	            {
	            	$statusvalue = "";
	            	if(isset($obj[$recharge_response_status_field]))
	            	{
	            		$statusvalue = $obj[$recharge_response_status_field];	
	            	}

	                $operator_id = "";
	                if(isset($obj[$recharge_response_opid_field]))
	                {
	                	$operator_id = json_encode($obj[$recharge_response_opid_field]);	
	                }
	                
	                
	                $roffer = 0;
	                if(isset($obj[$recharge_response_otf_field]))
	                {
	                    $roffer = $obj[$recharge_response_otf_field];   
	                }
	                
	               $lapubalance = 0;
	               if(isset($obj[$recharge_response_balance_field]))
	               {
	                 $lapubalance = $obj[$recharge_response_balance_field];    
	               }
	                
	                $success_key_array = explode(",",$RecRespSuccessKey);
	                $failure_key_array = explode(",",$RecRespFailureKey);
	                $pending_key_array = explode(",",$RecRespPendingKey);
	                $failure_text_array = explode(",",$RecRespFailureText);


	                //echo "START : ".$RecRespFailureText;

	               if($statusvalue != "")
	               {


	               		foreach($success_key_array as $success_key)
	           			{
	               			$statusvalue = trim($statusvalue);
	               			$success_key = trim($success_key);
	               			if($statusvalue == $success_key)
	               			{
	               				$ResponseMessage = "Transaction Success";
			                    $status = 'Success';
			                    $opr_id = $operator_id;
								$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
								

								$StatusCode = "1";
								$Message = "Transaction Success";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			}
	               		}

	               		///check failure
	               		foreach($pending_key_array as $pending_key)
	               		{
	               			$statusvalue = trim($statusvalue);
	               			$pending_key = trim($pending_key);
	               			if($statusvalue == $pending_key)
	               			{
	               				$status = 'Pending';
			                    $operator_id = "";
			                    $opr_id = $operator_id;
			                    $ResponseMessage = "Transaction In Pending Process";
								$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								

								$StatusCode = "1";
								$Message = "Transaction In Pending Process";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			}
	               		}
	               
	               		///check failure
	               		foreach($failure_key_array as $failure_key)
	               		{
	               			$statusvalue = trim($statusvalue);
	               			$failure_key = trim($failure_key);
	               			if($statusvalue == $failure_key)
	               			{
	               				$status = 'Failure';
	                        	
			                    $ResponseMessage = "Transaction Failed";
			                    $status = 'Failure';
			                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
									
								$opr_id = "";
								$StatusCode = "0";
								$Message = "Transaction Failed";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			}
	               		}

	               		
	               		   
	               }
	               else
	               {
	               		$response_send = false;
	               		///// check failurekeytet
	               		foreach($failure_text_array as $failure_text)
	               		{
	               			if(strlen($failure_text) >= 6)
	               			{
	               				if (preg_match("/".$failure_text."/",$response)  == 1)
			               		{

		               				$status = 'Failure';
		                        	$ResponseMessage = "Transaction Failed";
				                    $status = 'Failure';
				                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
									$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
										
									$opr_id = "";
									$StatusCode = "0";
									$Message = "Transaction Failed";
									return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
		                            break;
		               			
			               		}	
	               			}
	               		}   	
				   }
	            }
	            else
	            {
	                $status = 'Pending';
	                $operator_id = "";
	                $opr_id = $operator_id;
	                $ResponseMessage = "Transaction In Pending Process";
					$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
					

					$StatusCode = "1";
					$Message = "Transaction In Pending Process";
					return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	            }
	        }  
	        else if($recharge_response_type == "PARSER")
	        {
	            $rsltmessagesettings = $this->db->query("select * from message_setting where api_id = ?",array($ApiInfo->row(0)->Id));
	            if($rsltmessagesettings->num_rows() >= 1)
	            {
	                foreach($rsltmessagesettings->result() as $r)
					{
						$status_word = $r->status_word;
						$num_start = $r->number_start;
						$num_end = $r->number_end;
						
						$balance_start = $r->balance_start;
						$balance_end = $r->balance_end;
						
						$operator_id_start = $r->operator_id_start;
						$operator_id_end = $r->operator_id_end;
						$status = $r->status;
						$api_id = $r->api_id;
						//echo $status_word;exit;
	                    
						if (preg_match("/".$status_word."/",$response) == 1 and preg_match("/".$operator_id_start."/",$response) == 1)
						{
	                        
							$mobile_no = $this->get_string_between($response, $num_start, $num_end);
							$operator_id = $this->get_string_between($response, $operator_id_start, $operator_id_end);
							
							$lapubalance = $this->get_string_between($response, $balance_start, $balance_end);

							$operator_id = str_replace("\n","",$operator_id);
							$mobile_no = str_replace("\n","",$mobile_no);
	                    	
							$this->load->model("Update_methods");
							if($status == "Success" or $status == "Failure")
							{
								if($status == "Failure")
								{
									$status = 'Failure';
	                                $ResponseMessage = "Transaction Failed";
				                    $status = 'Failure';
				                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
									$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
										
									$StatusCode = "0";
									$Message = "Transaction Failed";
									return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
								}
								else
								{
									$ResponseMessage = "Transaction Success";
				                    $status = 'Success';
				                    $opr_id = $operator_id;
									$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
									$StatusCode = "1";
									$Message = "Transaction Success";
									return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);		
								}	
							}
							else
							{
								$status = 'Pending';
			                    $operator_id = "";
			                    $opr_id = $operator_id;
			                    $ResponseMessage = "Transaction In Pending Process";
								$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								$StatusCode = "1";
								$Message = "Transaction In Pending Process";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);		
							}
						}
						else
						{
							$status = 'Pending';
		                    $operator_id = "";
		                    $opr_id = $operator_id;
		                    $ResponseMessage = "Transaction In Pending Process";
							$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
							$StatusCode = "1";
							$Message = "Transaction In Pending Process";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);		
						}
					}
	            }
	            else
	            {
	                $status = 'Pending';
	                $operator_id = "";
	                $opr_id = $operator_id;
	                $ResponseMessage = "Transaction In Pending Process";
					$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
					
					$StatusCode = "1";
					$Message = "Transaction In Pending Process";
					return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	            }     
	        } 
		}
	    else
	    {
					        $status = 'Pending';
		                    $operator_id = "";
		                    $opr_id = $operator_id;
		                    $ResponseMessage = "Transaction In Pending Process";
							$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
							$StatusCode = "1";
							$Message = "Transaction In Pending Process";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
		}
	}	



	//A P I    R O U T I N G   E N D
	////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
	////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
	////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
	////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
	////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
	////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
	////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////




												
											}
	    								}
	    								else
	    								{
	    									$this->db->query("update tblbills set Status = 'Failure' where Id = ?",array($insert_id));


	    									$status = "Failure";
	    									$opr_id = "";
	    									$StatusCode = "0";
											$Message = "Payment Failure";
											return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	    								}
	    							}
	    						}
	    						else
	    						{
	    							$status = "Failure";
									$opr_id = "";
									$StatusCode = "0";
									$Message = "InSufficient Balance";
									return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
	    						}
						}
						else
						{
							$status = "Failure";
							$opr_id = "";
							$StatusCode = "0";
							$Message = "Internal Server Error";
							return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);

						}
							
					}
					else
					{
						$status = "Failure";
						$opr_id = "";
						$StatusCode = "0";
						$Message = "Internal Server Error";
						return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
					}
				}
				else
				{

					$status = "Failure";
					$opr_id = "";
					$StatusCode = "0";
					$Message = "Internal Server Error";
					return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
				}
				
			}
			else
			{
				$status = "Failure";
				$opr_id = "";
				$StatusCode = "0";
				$Message = "Internal Server Error";
				return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
				
			}
		}	
	}





	public function bill_resend($bill_id,$api_id)
	{
	   

		
		$bill_info = $this->db->query("select Id, mode, add_date, ipaddress, user_id, service_no, customer_mobile, customer_name, dueamount, duedate, billnumber, billdate, billperiod, company_id, bill_amount, paymentmode, payment_channel, status, ipay_id, opr_id, trans_amt, charged_amt, opening_bal, datetime, resp_status, res_code, res_msg, debited, reverted, commission, debit_amount, credit_amount, balance, ewallet_id, option1, host_id, done_by, API from tblbills where  status = 'Pending' and Id = ?",array($bill_id));

		if($bill_info->num_rows() == 1)
		{
			$user_id = $bill_info->row(0)->user_id;

			$Mobile = $bill_info->row(0)->service_no;
			$Amount = $bill_info->row(0)->bill_amount;
			$option1 = $bill_info->row(0)->option1;
			//echo $option1;exit;
			$option2 = "";
			$CustomerMobile = $bill_info->row(0)->customer_mobile;


			$company_id = $bill_info->row(0)->company_id;
			$company_info = $this->db->query("select * from tblcompany where company_id = ?",array($company_id));
			 $ApiInfo = $this->db->query("select * from api_configuration where Id = ?",array($api_id));
		   if($ApiInfo->num_rows() == 1)
		   {

		   		$api_id = $ApiInfo->row(0)->Id; 
		   		$api_name =  $ApiInfo->row(0)->api_name;
		   		if($ApiInfo->num_rows() == 1)
				{
					$api_id = $ApiInfo->row(0)->Id;
					$api_name = $ApiInfo->row(0)->api_name;
					
							
							$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
							$parentid = $userinfo->row(0)->parentid;
							$usertype_name = $userinfo->row(0)->usertype_name;
							$user_status = $userinfo->row(0)->status;
							$utility_group = $userinfo->row(0)->utility_group;
							if($usertype_name == "Agent" or $usertype_name == "APIUSER")
							{
								$operatorcode_rslt = $this->db->query("
		                                                	    select 
		                                                	    a.company_id,
		                                                	    a.company_name,
		                                                	    a.mcode,
		                                                	    a.service_id,
		                                                	    b.service_name,
		                                                	    g.commission,
		                                                	    g.commission_type,
		                                                	    g.commission_slab,
		                                                	    g.OpParam1,
		                                                	    g.OpParam2,
		                                                	    g.OpParam3,
		                                                	    g.OpParam4,
		                                                	    g.OpParam5
		                                                	    
		                                                	    from tblcompany a 
		                                                	    left join tblservice b on a.service_id = b.service_id 
		                                                	    left join tbloperatorcodes g on g.api_id = ? and a.company_id = g.company_id
		                                                	    where a.company_id = ?
		                                                	    order by service_id",array($api_id,$company_id));
		                                                	    $OpParam1 = '';
		                                                	    $OpParam2 = '';
		                                                	    $OpParam3 = '';
		                                                	    $OpParam4 = '';
		                                                	    $OpParam5 = '';
		                                            if($operatorcode_rslt->num_rows() == 1)
		                                            {
		                                                $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
		                                                $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
		                                                $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
		                                                $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
		                                                $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
		                                            }

									$MdId = 0;
	    							$dist_info = $this->db->query("select * from tblusers where user_id = ?",array($userinfo->row(0)->parentid));
	    							if($dist_info->num_rows() == 1)
	    							{
	    								$MdId = $dist_info->row(0)->parentid;
	    							}

	    							$insert_id = $bill_id;
	    							$recharge_id = $insert_id;
	    							$transaction_type = "BILL";

										
											

////////////////////////////////////////////////////////////////////////////////////////
///***********************************************************************************//
///***********************************************************************************//
///***********************************************************************************//
///*********************** A P I    R O U T I N G   S T A R T*************************//
///***********************************************************************************//
///***********************************************************************************//
////////////////////////////////////////////////////////////////////////////////////////											



	if($ApiInfo->num_rows() == 1)
    {
        $apiinfo = $ApiInfo;
        $api_id = $apiinfo->row(0)->Id;
        $api_name = $apiinfo->row(0)->api_name;
        $api_type = $apiinfo->row(0)->api_type;
        $is_active = $apiinfo->row(0)->is_active;
        $enable_recharge = $apiinfo->row(0)->enable_recharge;
        $enable_balance_check = $apiinfo->row(0)->enable_balance_check;
        $enable_status_check = $apiinfo->row(0)->enable_status_check;
        $hostname = $apiinfo->row(0)->hostname;
        $param1 = $apiinfo->row(0)->param1;
        $param2 = $apiinfo->row(0)->param2;
        $param3 = $apiinfo->row(0)->param3;
        $param4 = $apiinfo->row(0)->param4;
        $param5 = $apiinfo->row(0)->param5;
        $param6 = $apiinfo->row(0)->param6;
        $param7 = $apiinfo->row(0)->param7;
        
        $header_key1 = $apiinfo->row(0)->header_key1;
        $header_key2 = $apiinfo->row(0)->header_key1;
        $header_key3 = $apiinfo->row(0)->header_key1;
        $header_key4 = $apiinfo->row(0)->header_key1;
        $header_key5 = $apiinfo->row(0)->header_key1;
        $header_value1 = $apiinfo->row(0)->header_value1;
        $header_value2 = $apiinfo->row(0)->header_value2;
        $header_value3 = $apiinfo->row(0)->header_value3;
        $header_value4 = $apiinfo->row(0)->header_value4;
        $header_value5 = $apiinfo->row(0)->header_value5;
        
        $balance_check_api_method = $apiinfo->row(0)->balance_check_api_method;
        $balance_ceck_api = $apiinfo->row(0)->balance_ceck_api;
        $status_check_api_method = $apiinfo->row(0)->status_check_api_method;
        $status_check_api = $apiinfo->row(0)->status_check_api;
        $validation_api_method = $apiinfo->row(0)->validation_api_method;
        $validation_api = $apiinfo->row(0)->validation_api;
        $transaction_api_method = $apiinfo->row(0)->transaction_api_method;
        $api_prepaid = $apiinfo->row(0)->api_prepaid;
        $api_dth = $apiinfo->row(0)->api_dth;
        $api_postpaid = $apiinfo->row(0)->api_postpaid;
        
        $api_electricity = $apiinfo->row(0)->api_electricity;
        $api_gas = $apiinfo->row(0)->api_gas;
        $api_insurance = $apiinfo->row(0)->api_insurance;
        $dunamic_callback_url = $apiinfo->row(0)->dunamic_callback_url;
        $response_parser = $apiinfo->row(0)->response_parser;
        
        
        $recharge_response_type = $apiinfo->row(0)->recharge_response_type;
        $response_separator = $apiinfo->row(0)->response_separator;
        
        $recharge_response_status_field = $apiinfo->row(0)->recharge_response_status_field;
        $recharge_response_opid_field = $apiinfo->row(0)->recharge_response_opid_field;
        $recharge_response_apirefid_field = $apiinfo->row(0)->recharge_response_apirefid_field;
        
        $recharge_response_balance_field = $apiinfo->row(0)->recharge_response_balance_field;
        $recharge_response_remark_field = $apiinfo->row(0)->recharge_response_remark_field;
        $recharge_response_stat_field = $apiinfo->row(0)->recharge_response_stat_field;
        
        $recharge_response_fos_field = $apiinfo->row(0)->recharge_response_fos_field;
        $recharge_response_otf_field = $apiinfo->row(0)->recharge_response_otf_field;
        
         $recharge_response_lapunumber_field = $apiinfo->row(0)->recharge_response_lapunumber_field;
         $recharge_response_message_field = $apiinfo->row(0)->recharge_response_message_field;
         $pendingOnEmptyTxnId = $apiinfo->row(0)->pendingOnEmptyTxnId;
         $RecRespSuccessKey = $apiinfo->row(0)->RecRespSuccessKey;
         $RecRespPendingKey = $apiinfo->row(0)->RecRespPendingKey;
         $RecRespFailureKey = $apiinfo->row(0)->RecRespFailureKey;
         $RecRespFailureText = $apiinfo->row(0)->RecRespFailureText;
          
         ///////////////////////////////////////////
         ////////////////////////////////////////
         ///////////////////////
         ///////////////////////////////////////////
            	         
	    $OpParam1 = '';
	    $OpParam2 = '';
	    $OpParam3 = '';
	    $OpParam4 = '';
	    $OpParam5 = '';
        if($operatorcode_rslt->num_rows() == 1)
        {
            $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
            $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
            $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
            $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
            $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
        }
        $url = $hostname;
        
        if($company_info->row(0)->service_id == 1)
        {
        	$api_prepaid = $api_prepaid;
        }
        if($company_info->row(0)->service_id == 2)
        {
        	$api_prepaid = $api_dth;
        }
        if($company_info->row(0)->service_id == 3)
        {
        	$api_prepaid = $api_postpaid;
        }
        if($company_info->row(0)->service_id == 16)
        {
        	$api_prepaid = $api_electricity;
        }
        if($company_info->row(0)->service_id == 17)
        {
        	$api_prepaid = $api_gas;
        }
        

        if($transaction_api_method == "GET")
        {
            ///$userinfo,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$ref_id,$particulars,$option2="",$option3="",$done_by = "WEB",$order_id = 0




            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);


            
            $url = $hostname.$api_prepaid;
            $url  = str_replace("@mn",$Mobile, $url);
            $url  = str_replace("@amt",$Amount, $url);
            $url  = str_replace("@opparam1",$OpParam1, $url);
            $url  = str_replace("@opparam2",$OpParam2, $url);
            $url  = str_replace("@opparam3",$OpParam3, $url);
            $url  = str_replace("@opparam4",$OpParam4, $url);
            $url  = str_replace("@opparam5",$OpParam5, $url);
            $url  = str_replace("@reqid",$insert_id, $url);


            $url  = str_replace("@option1",$option1, $url);
            $url  = str_replace("@option2",$option2, $url);
            $url  = str_replace("@custmn",$CustomerMobile, $url);
            //echo $url;exit;
            $response = $this->common->callurl(trim($url),"BBPS".$recharge_id);  
        }
        if($transaction_api_method == "POST")
        {
            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);
            
            $url = $hostname.$api_prepaid;
            $url  = str_replace("@mn",$Mobile, $url);
            $url  = str_replace("@amt",$Amount, $url);
            $url  = str_replace("@opparam1",$OpParam1, $url);
            $url  = str_replace("@opparam2",$OpParam2, $url);
            $url  = str_replace("@opparam3",$OpParam3, $url);
            $url  = str_replace("@opparam4",$OpParam4, $url);
            $url  = str_replace("@opparam5",$OpParam5, $url);
            $url  = str_replace("@reqid",$recharge_id, $url);
            $url  = str_replace("@option1",$option1, $url);
            $url  = str_replace("@option2",$option2, $url);
            $url  = str_replace("@custmn",$CustomerMobile, $url);
            //$url = explode("?",$url)[0];
            $postdata = explode("?",$url)[1];
            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
        }
        
        
        if($recharge_response_type == "XML")
        {
            $obj = (array)simplexml_load_string( $response);
           
            $recharge_response_status_field = str_replace("<","",$recharge_response_status_field);
            $recharge_response_status_field = str_replace(">","",$recharge_response_status_field);
            
            
             $recharge_response_otf_field = str_replace("<","",$recharge_response_otf_field);
            $recharge_response_otf_field = str_replace(">","",$recharge_response_otf_field);
            
            // echo $recharge_response_status_field;
            // echo "<br><br>";
            // print_r($obj);exit;
            
            $recharge_response_opid_field = str_replace("<","",$recharge_response_opid_field);
            $recharge_response_opid_field = str_replace(">","",$recharge_response_opid_field);
            
            
            $recharge_response_balance_field = str_replace("<","",$recharge_response_balance_field);
            $recharge_response_balance_field = str_replace(">","",$recharge_response_balance_field);
            
            if(isset($obj[$recharge_response_status_field]))
            {
                $statusvalue = $obj[$recharge_response_status_field];
            
                $operator_id = json_encode($obj[$recharge_response_opid_field]);
                $operator_id = str_replace('"','',$operator_id);
                $lapubalance = 0;
                if(isset($obj[$recharge_response_balance_field]))
                {
                    $lapubalance = $obj[$recharge_response_balance_field];    
                }
                
                
                
                $roffer = 0;
                if(isset($obj[$recharge_response_otf_field]))
                {
                    $roffer = $obj[$recharge_response_otf_field];    
                }
                
                $success_key_array = explode(",",$RecRespSuccessKey);
                $failure_key_array = explode(",",$RecRespFailureKey);
                $pending_key_array = explode(",",$RecRespPendingKey);
                
               
                if (in_array($statusvalue, $success_key_array)) 
                {
                	$ResponseMessage = "Transaction Success";
                    $status = 'Success';
                    $opr_id = $operator_id;
					$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
					

					$StatusCode = "1";
					$Message = "Transaction Success";
					return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                }
                else if (in_array($statusvalue, $failure_key_array)) 
                {
                	$ResponseMessage = "Transaction Failed";
                    $status = 'Failure';
                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
					$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
					
					$opr_id = "";	
					$StatusCode = "0";
					$Message = "Transaction Failure";
					return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                }
                else  if (in_array($statusvalue, $pending_key_array)) 
                {
                    $status = 'Pending';
                    $operator_id = "";
                    $opr_id = $operator_id;
                    $ResponseMessage = "Transaction In Pending Process";
					$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
					

					$StatusCode = "1";
					$Message = "Transaction Success";
					return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                }   
            }
            else
            {
                $status = 'Pending';
                $operator_id = "";
                $opr_id = $operator_id;
                $ResponseMessage = "Transaction In Pending Process";
				$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
				

				$StatusCode = "1";
				$Message = "Transaction Success";
				return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
            }
        }
        else if($recharge_response_type == "JSON")
        {
            $obj = (array)json_decode($response);
           
            
            
            if(isset($obj[$recharge_response_status_field]))
            {
            	$statusvalue = "";
            	if(isset($obj[$recharge_response_status_field]))
            	{
            		$statusvalue = $obj[$recharge_response_status_field];	
            	}
                





                $operator_id = "";
                $first_recharge_response_opid_field = false;
				$second_recharge_response_opid_field = false;
		    	if(preg_match("/./", $recharge_response_opid_field))
		    	{
		    		$firstsecond_array = explode(".",$recharge_response_opid_field);
		    		if(count($firstsecond_array) == 2)
		    		{
		    			$first_recharge_response_opid_field = (string)$firstsecond_array[0];
		    				$second_recharge_response_opid_field = (string)$firstsecond_array[1];	
		    		}
		    		
		    		//echo $first_param."   ".$second_param;exit;
		    	}

		    	if($first_recharge_response_opid_field != false and $second_recharge_response_opid_field != false)
		    	{
		    		if(isset($obj[$first_recharge_response_opid_field]->$second_recharge_response_opid_field))
		            {
		            	$operator_id = $obj[$first_recharge_response_opid_field]->$second_recharge_response_opid_field;	
		            }
		    	}
		    	else
		    	{
		    		if(isset($obj[$recharge_response_opid_field]))
		            {
		            	$operator_id = $obj[$recharge_response_opid_field];	
		            }
		    	}
                $roffer = 0;
                if(isset($obj[$recharge_response_otf_field]))
                {
                    $roffer = $obj[$recharge_response_otf_field];    
                }
                
                $lapubalance = 0;
                if(isset($obj[$recharge_response_balance_field]))
                {
                    $lapubalance = $obj[$recharge_response_balance_field];    
                }
            
                $success_key_array = explode(",",$RecRespSuccessKey);
                $failure_key_array = explode(",",$RecRespFailureKey);
                $pending_key_array = explode(",",$RecRespPendingKey);
                $failure_text_array = explode(",",$RecRespFailureText);
                
               
                if($statusvalue != "")
                {
                	foreach($success_key_array as $success_key)
           			{
               			$statusvalue = trim($statusvalue);
               			$success_key = trim($success_key);
               			if($statusvalue == $success_key)
               			{
               				$ResponseMessage = "Transaction Success";
		                    $status = 'Success';
		                    $opr_id = $operator_id;
							$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
							

							$StatusCode = "1";
							$Message = "Transaction Success";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                            break;
               			}
               		}

               		///check pending
               		foreach($pending_key_array as $pending_key)
               		{
               			$statusvalue = trim($statusvalue);
               			$pending_key = trim($pending_key);
               			if($statusvalue == $pending_key)
               			{
               				$status = 'Pending';
		                    $operator_id = "";
		                    $opr_id = $operator_id;
		                    $ResponseMessage = "Transaction In Pending Process";
							$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
							
							$StatusCode = "1";
							$Message = "Transaction Success";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                            break;
               			}
               		}
               
               		///check failure
               		foreach($failure_key_array as $failure_key)
               		{
               			$statusvalue = trim($statusvalue);
               			$failure_key = trim($failure_key);
               			if($statusvalue == $failure_key)
               			{
               				$ResponseMessage = "Transaction Failed";
		                    $status = 'Failure';
		                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
							$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
								
							$opr_id = "";
							$StatusCode = "0";
							$Message = "Transaction Failure";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                            break;
               			}
               		}

               		///// check failurekeytet
               		foreach($failure_text_array as $failure_text)
               		{
               			if(strlen($failure_text) >= 6)
               			{
               				if (preg_match("/".$failure_text."/",$response)  == 1)
		               		{

	               				$status = 'Failure';
	                        	$ResponseMessage = "Transaction Failed";
			                    $status = 'Failure';
			                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
									
								$opr_id = "";
								$StatusCode = "0";
								$Message = "Transaction Failure";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			
		               		}	
               			}
               		}
                }
                else
               {
               		$response_send = false;
               		///// check failurekeytet
               		foreach($failure_text_array as $failure_text)
               		{
               			if(strlen($failure_text) >= 6)
               			{
               				if (preg_match("/".$failure_text."/",$response)  == 1)
		               		{

	               				$status = 'Failure';
	                        	$ResponseMessage = "Transaction Failed";
			                    $status = 'Failure';
			                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
									
								$opr_id = "";
								$StatusCode = "0";
								$Message = "Transaction Failure";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			
		               		}	
               			}
               		}
			   } 
            }
            else
            {
                $status = 'Pending';
                $operator_id = "";
                $opr_id = $operator_id;
                $ResponseMessage = "Transaction In Pending Process";
				$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
				


				$StatusCode = "1";
				$Message = "Transaction Success";
				return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
            }
        }
        else if($recharge_response_type == "CSV")
        {
            $obj = explode($response_separator,$response);
           
            if(isset($obj[$recharge_response_status_field]))
            {
            	$statusvalue = "";
            	if(isset($obj[$recharge_response_status_field]))
            	{
            		$statusvalue = $obj[$recharge_response_status_field];	
            	}

                $operator_id = "";
                if(isset($obj[$recharge_response_opid_field]))
                {
                	$operator_id = json_encode($obj[$recharge_response_opid_field]);	
                }
                
                
                $roffer = 0;
                if(isset($obj[$recharge_response_otf_field]))
                {
                    $roffer = $obj[$recharge_response_otf_field];   
                }
                
               $lapubalance = 0;
               if(isset($obj[$recharge_response_balance_field]))
               {
                 $lapubalance = $obj[$recharge_response_balance_field];    
               }
                
                $success_key_array = explode(",",$RecRespSuccessKey);
                $failure_key_array = explode(",",$RecRespFailureKey);
                $pending_key_array = explode(",",$RecRespPendingKey);
                $failure_text_array = explode(",",$RecRespFailureText);


                //echo "START : ".$RecRespFailureText;

               if($statusvalue != "")
               {


               		foreach($success_key_array as $success_key)
           			{
               			$statusvalue = trim($statusvalue);
               			$success_key = trim($success_key);
               			if($statusvalue == $success_key)
               			{
               				$ResponseMessage = "Transaction Success";
		                    $status = 'Success';
		                    $opr_id = $operator_id;
							$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
							

							$StatusCode = "1";
							$Message = "Transaction Success";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                            break;
               			}
               		}

               		///check failure
               		foreach($pending_key_array as $pending_key)
               		{
               			$statusvalue = trim($statusvalue);
               			$pending_key = trim($pending_key);
               			if($statusvalue == $pending_key)
               			{
               				$status = 'Pending';
		                    $operator_id = "";
		                    $opr_id = $operator_id;
		                    $ResponseMessage = "Transaction In Pending Process";
							$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
							

							$StatusCode = "1";
							$Message = "Transaction In Pending Process";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                            break;
               			}
               		}
               
               		///check failure
               		foreach($failure_key_array as $failure_key)
               		{
               			$statusvalue = trim($statusvalue);
               			$failure_key = trim($failure_key);
               			if($statusvalue == $failure_key)
               			{
               				$status = 'Failure';
                        	
		                    $ResponseMessage = "Transaction Failed";
		                    $status = 'Failure';
		                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
							$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
								
							$opr_id = "";
							$StatusCode = "0";
							$Message = "Transaction Failed";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
                            break;
               			}
               		}

               		
               		   
               }
               else
               {
               		$response_send = false;
               		///// check failurekeytet
               		foreach($failure_text_array as $failure_text)
               		{
               			if(strlen($failure_text) >= 6)
               			{
               				if (preg_match("/".$failure_text."/",$response)  == 1)
		               		{

	               				$status = 'Failure';
	                        	$ResponseMessage = "Transaction Failed";
			                    $status = 'Failure';
			                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
									
								$opr_id = "";
								$StatusCode = "0";
								$Message = "Transaction Failed";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	                            break;
	               			
		               		}	
               			}
               		}   	
			   }
            }
            else
            {
                $status = 'Pending';
                $operator_id = "";
                $opr_id = $operator_id;
                $ResponseMessage = "Transaction In Pending Process";
				$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
				

				$StatusCode = "1";
				$Message = "Transaction In Pending Process";
				return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
            }
        }  
        else if($recharge_response_type == "PARSER")
        {
            $rsltmessagesettings = $this->db->query("select * from message_setting where api_id = ?",array($ApiInfo->row(0)->Id));
            if($rsltmessagesettings->num_rows() >= 1)
            {
                foreach($rsltmessagesettings->result() as $r)
				{
					$status_word = $r->status_word;
					$num_start = $r->number_start;
					$num_end = $r->number_end;
					
					$balance_start = $r->balance_start;
					$balance_end = $r->balance_end;
					
					$operator_id_start = $r->operator_id_start;
					$operator_id_end = $r->operator_id_end;
					$status = $r->status;
					$api_id = $r->api_id;
					//echo $status_word;exit;
                    
					if (preg_match("/".$status_word."/",$response) == 1 and preg_match("/".$operator_id_start."/",$response) == 1)
					{
                        
						$mobile_no = $this->get_string_between($response, $num_start, $num_end);
						$operator_id = $this->get_string_between($response, $operator_id_start, $operator_id_end);
						
						$lapubalance = $this->get_string_between($response, $balance_start, $balance_end);

						$operator_id = str_replace("\n","",$operator_id);
						$mobile_no = str_replace("\n","",$mobile_no);
                    	
						$this->load->model("Update_methods");
						if($status == "Success" or $status == "Failure")
						{
							if($status == "Failure")
							{
								$status = 'Failure';
                                $ResponseMessage = "Transaction Failed";
			                    $status = 'Failure';
			                    $this->db->query("update tblbills set status = 'Failure',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
								$this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
									
								$StatusCode = "0";
								$Message = "Transaction Failed";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
							}
							else
							{
								$ResponseMessage = "Transaction Success";
			                    $status = 'Success';
			                    $opr_id = $operator_id;
								$this->db->query("update tblbills set status = 'Success',opr_id=?,resp_status = ? where Id = ?",array($opr_id,$ResponseMessage,$insert_id));
								$StatusCode = "1";
								$Message = "Transaction Success";
								return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);		
							}	
						}
						else
						{
							$status = 'Pending';
		                    $operator_id = "";
		                    $opr_id = $operator_id;
		                    $ResponseMessage = "Transaction In Pending Process";
							$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
							$StatusCode = "1";
							$Message = "Transaction In Pending Process";
							return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);		
						}
					}
					else
					{
						$status = 'Pending';
	                    $operator_id = "";
	                    $opr_id = $operator_id;
	                    $ResponseMessage = "Transaction In Pending Process";
						$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
						$StatusCode = "1";
						$Message = "Transaction In Pending Process";
						return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);		
					}
				}
            }
            else
            {
                $status = 'Pending';
                $operator_id = "";
                $opr_id = $operator_id;
                $ResponseMessage = "Transaction In Pending Process";
				$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
				
				$StatusCode = "1";
				$Message = "Transaction In Pending Process";
				return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
            }     
        } 
	}
    else
    {
				        $status = 'Pending';
	                    $operator_id = "";
	                    $opr_id = $operator_id;
	                    $ResponseMessage = "Transaction In Pending Process";
						$this->db->query("update tblbills set status = 'Pending',resp_status = ? where Id = ?",array($ResponseMessage,$insert_id));
						$StatusCode = "1";
						$Message = "Transaction In Pending Process";
						return $this->responsetouser($Message,$StatusCode,$insert_id,$status,$opr_id);
	}
	



//A P I    R O U T I N G   E N D
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////
////XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX///////




											
										
    								
	    							
	    						
							
							}
							else
							{
								$status = "Failure";
								$opr_id = "";
								$StatusCode = "0";
								$Message = "Internal Server Error";
								return $this->responsetouser($Message,$StatusCode,0,$status,$opr_id);
							}
						
				}	
		   }
		   else
		   {
		   		//no api found
		   }	
		}
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
	

	public function bill_logs($user_id,$request,$response,$bill_id)
	{
		$this->db->query("insert into tblreqresp_bills(user_id,add_date,ipaddress,request,response,bill_id) values(?,?,?,?,?,?)",
							array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$request,$response,$bill_id));
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
	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****************************  P A Y M E N T   M E T H O D   E N D S   H E R E   ****************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////








private function responsetouser($message,$statuscode,$insert_id,$status,$opr_id)
{
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

	 							"ipay_id"=>$insert_id,
	 							"opr_id"=>$opr_id,
	 							"status"=>$status,
	 							"res_msg"=>$status,
	 						)
	 					);
	 $json_resp =  json_encode($resp_arr);	
	 return $json_resp;
}










//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//########################################## C O M M I S S I O N     D I S T R I B U T I O N ###########################//


public function getBillpaymentCommission($user_id,$company_id)
	{
		$company_info = $this->db->query("select service_id from tblcompany where company_id = ?",array($company_id));
		if($company_info->num_rows() == 1)
		{
			$service_id = $company_info->row(0)->service_id;
			$userinfo = $this->db->query("select user_id,scheme_id from tblusers where user_id = ?",array($user_id));
			if($userinfo->num_rows() == 1)
			{
				$scheme_id = $userinfo->row(0)->scheme_id;
				$commission_info = $this->db->query("select SdComm,MdComm,DComm,RComm from tblutilitycommission where group_id = ? and service_id = ?",array($scheme_id,$service_id));
				if($commission_info->num_rows() == 1)
				{
					$SdComm = $commission_info->row(0)->SdComm;
					$MdComm = $commission_info->row(0)->MdComm;
					$DComm = $commission_info->row(0)->DComm;
					$RComm = $commission_info->row(0)->RComm;

				}

			}
		}
	}
	
	
}

?>