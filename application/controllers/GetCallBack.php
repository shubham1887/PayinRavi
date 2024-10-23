<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class GetCallBack extends CI_Controller {
    public function encrtest()
    {
       
	    $plaintext = "Ravikant";
	    $encrypted_text = $this->Encr->encrypt($plaintext);
	    $decrypted_text = $this->Encr->decrypt($encrypted_text);
	    echo $encrypted_text."    ".$decrypted_text;exit;
    }
	public function logentry($data)
	{

		$filename = "resp.txt";
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
    public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	//
	public function test()
	{
	    
	   $response = '{"status":"true","coupon":"6PJGG709SXL3GWYX","client_id":"26172","amount":"10"}';
	   
	   // $this->logentry($response);
	    $api_id = $this->Encr->decrypt($this->uri->segment(3)); 
	   echo $api_id;exit;
	    if($api_id > 0)
	    {
	        
	        $api_info = $this->db->query("SELECT a.*,b.api_name FROM callback_settings a left join api_configuration b on a.api_id = b.Id where a.api_id = ?",array( $api_id));
	        if($api_info->num_rows() == 1)
	        {
	            $api_name = $api_info->row(0)->api_name;
	            $reqid_name = $api_info->row(0)->reqid_name;
	            $apirefid_name = $api_info->row(0)->apirefid_name;
	            $check_through_reqid = $api_info->row(0)->check_through_reqid;
	            $status_name = $api_info->row(0)->status_name;
	            $opid_name = $api_info->row(0)->opid_name;
	            $success_key = $api_info->row(0)->success_key;
	            $pending_key = $api_info->row(0)->pending_key;
	            $failure_key = $api_info->row(0)->failure_key;
	            $refund_key = $api_info->row(0)->refund_key;
	            $obj = (array)json_decode($response);
	            if(isset($obj[$reqid_name]) and isset($obj[$status_name]))
	            {
	                $recharge_id =  trim($obj[$reqid_name]);
	                $statusvalue =  trim($obj[$status_name]);
	                $operator_id =  trim($obj[$opid_name]);
	                
	                
	             	if(preg_match("/BBPS/", $recharge_id)) 
	             	{
	             		$bill_id = str_replace("BBPS", "", $recharge_id);
	             		echo $bill_id;exit;
	             		echo $bill_id;exit;
	             		$rlstbill_info = $this->db->query("select * from tblbills where Id = ? and status = 'Pending'",array($bill_id));
	             		if($rlstbill_info->num_rows() == 1)
	             		{
	             			$success_key_array = explode(",",$success_key);
                            $failure_key_array = explode(",",$failure_key);
                            $pending_key_array = explode(",",$pending_key);
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $statuscode = "CLLBACK";
								$message = "Bill Payment Success";
								
								$trans_amt = $rlstbill_info->row(0)->bill_amount;
								$charged_amt = "";
								$opening_bal = "";
								$datetime = $this->common->getDate();
								$res_status = "SUCCESS";
								$res_msg = "Bill Payment Success";


                                $this->db->query("update tblbills set status = 'Success',opr_id=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",
								array($opr_id,$datetime,$res_status,$statuscode,$res_msg,$bill_id));
								echo "DONE";exit;
                            }
	             		}
	             	}
	             	else
	             	{
	             		$rlstrecharge_info = $this->db->query("select ExecuteBy,recharge_status from tblrecharge where recharge_id = ?",array($recharge_id));
		                if($rlstrecharge_info->num_rows() == 1)
		                {
		                    //$this->Errorlog->httplog("Callback From ".$api_name,$response,$recharge_id);
		                    
		                    $ExecuteBy = $rlstrecharge_info->row(0)->ExecuteBy;
		                    $recharge_status = $rlstrecharge_info->row(0)->recharge_status;
		                   
		                  
		                    if($ExecuteBy ==$api_name )
		                    {
		                        
		                        $success_key_array = explode(",",$success_key);
	                            $failure_key_array = explode(",",$failure_key);
	                            $pending_key_array = explode(",",$pending_key);
	                           
	                            if (in_array($statusvalue, $success_key_array)) 
	                            {
	                                $status = 'Success';
	                                $lapubalance = "";
	                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
	            				    echo "DONE";exit;
	                            }
	                            else if (in_array($statusvalue, $failure_key_array)) 
	                            {
	                                $status = 'Failure';
	                                $lapubalance = "";
	                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
	                                echo "DONE";exit;
	                            }
		                    }
		                    else
		                    {
		                        echo "OK 003";exit;
		                    }
		                }
		                else
		                {
		                    $this->Errorlog->httplog("Callback From Unknown ",$response);
		                     echo "OK 001";exit;
		                }
	             	}	
	            }
	            else
	            {
	                $this->Errorlog->httplog("Callback From Unknown ",$response);
	                echo "Callback Configuration Missing";exit;
	            }
	            
	        }
	        else
	        {
	            $this->Errorlog->httplog("Callback From Unknown ",$response);
	             echo "OK 002";exit;
	        }
	    }
	    else
	    {
	        $this->Errorlog->httplog("Callback From Unknown ",$response);
	        echo "UNKNOWN PROVIDER RESPONSE";exit;
	    }
    }
	


	public function index()
	{
	    

	   // $response = '{"reqid":"2237","status":"SUCCESS","remark":"SUCCESS","balance":"0","mn":"9586907242","amt":"149","field1":"BH0531155925000076","ec":"1000"}';
	    $response = json_encode($this->input->get());

	     $this->logentry($this->uri->segment(1));
	     $this->logentry($this->uri->segment(2));
	     $this->logentry($this->uri->segment(3));
	     $this->logentry($this->uri->segment(4));
	    

	    $this->Errorlog->httplog("Callback From get : ",$response,0);
	    $this->Errorlog->httplog("Callback From post : ",json_encode($this->input->post()),0);
	    
	    $this->logentry($response);
	    $api_id = $this->Encr->decrypt($this->uri->segment(3)); 
	   
	    // if($api_id == 16)
	    // {
	    // 	header('Content-Type: application/json');
	    // 	$resparray = array(
	    // 		"ResponseCode"=>"000",
	    // 		"status"=>"SUCCESS"
	    // 	);
	    // 	echo json_encode($resparray);exit;
	    // }

	    if($api_id > 0)
	    {
	        $api_info = $this->db->query("SELECT a.*,b.api_name FROM callback_settings a left join api_configuration b on a.api_id = b.Id where a.api_id = ?",array( $api_id));
	        if($api_info->num_rows() == 1)
	        {
	            $api_name = $api_info->row(0)->api_name;
	            $reqid_name = $api_info->row(0)->reqid_name;
	            $apirefid_name = $api_info->row(0)->apirefid_name;
	            $check_through_reqid = $api_info->row(0)->check_through_reqid;
	            $status_name = $api_info->row(0)->status_name;
	            $opid_name = $api_info->row(0)->opid_name;
	            $success_key = $api_info->row(0)->success_key;
	            $pending_key = $api_info->row(0)->pending_key;
	            $failure_key = $api_info->row(0)->failure_key;
	            $refund_key = $api_info->row(0)->refund_key;
	            $response_type = $api_info->row(0)->response_type;


	            if($response_type == "get" or $response_type == "GET" or  $response_type == "post" or $response_type == "POST")
	            {

	            	if($response_type == "post")
	            	{
	            		$response = json_encode($this->input->post());
	            	}
	            	$obj = (array)json_decode($response);
		            if(isset($obj[$reqid_name]) and isset($obj[$status_name]))
		            {
		                $recharge_id =  trim($obj[$reqid_name]);
		                $statusvalue =  trim($obj[$status_name]);
		                $operator_id =  trim($obj[$opid_name]);
		                

		                if(preg_match("/BBPS/", $recharge_id)) 
	             		{
	             		$bill_id = str_replace("BBPS", "", $recharge_id);
	             		//echo $bill_id;exit;
	             		
	             		$rlstbill_info = $this->db->query("select * from tblbills where Id = ? and status = 'Pending'",array($bill_id));
	             		if($rlstbill_info->num_rows() == 1)
	             		{

	             			$Charge_Amount = $rlstbill_info->row(0)->commission;
	             			$dr_amount = $rlstbill_info->row(0)->bill_amount;
	             			$user_id = $rlstbill_info->row(0)->user_id;

	             			$insert_id = $bill_id;


	             			$success_key_array = explode(",",$success_key);
                            $failure_key_array = explode(",",$failure_key);
                            $pending_key_array = explode(",",$pending_key);
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $statuscode = "CLLBACK";
								$message = "Bill Payment Success";
								
								$trans_amt = $rlstbill_info->row(0)->bill_amount;
								$charged_amt = "";
								$opening_bal = "";
								$datetime = $this->common->getDate();
								$res_status = "SUCCESS";
								$res_msg = "Bill Payment Success";


                                $this->db->query("update tblbills set status = 'Success',opr_id=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",
								array($operator_id,$datetime,$res_status,$statuscode,$res_msg,$bill_id));
								echo "DONE";exit;
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = 'Failure';
                                $statuscode = "CLLBACK";
								$message = "Bill Payment Failure";
								$transaction_type = "BILL";
								$sub_txn_type = "BILL";
								$remark = "Bill Payment Refund";
								
								$trans_amt = $rlstbill_info->row(0)->bill_amount;
								$charged_amt = "";
								$opening_bal = "";
								$datetime = $this->common->getDate();
								$res_status = "FAILURE";
								$res_msg = "Bill Payment Failure";
								$Description = "Bill Refund : Id : ".$bill_id;

                                $this->db->query("update tblbills set status = 'Failure',opr_id=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",
								array($operator_id,$datetime,$res_status,$statuscode,$res_msg,$bill_id));

                                $dr_amount = $dr_amount - $Charge_Amount;
								$statuscode = "MANUAL";
								$message = "Manual Failed";
								$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
								$this->load->model("Mastermoney");
								$this->Mastermoney->PAYMENT_CREDIT_ENTRY_bill($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,0,0);






								echo "DONE";exit;
                            }
	             		}
	             	}
		             	else
		             	{
		             		$rlstrecharge_info = $this->db->query("select ExecuteBy,recharge_status from tblrecharge where recharge_id = ?",array($recharge_id));
			                if($rlstrecharge_info->num_rows() == 1)
			                {
			                    
			                   $this->Errorlog->httplog("Callback From ".$api_name,$response,$recharge_id);
			                    
			                    $ExecuteBy = $rlstrecharge_info->row(0)->ExecuteBy;
			                    $recharge_status = $rlstrecharge_info->row(0)->recharge_status;
			                    if($ExecuteBy ==$api_name )
			                    {
			                        
			                        $success_key_array = explode(",",$success_key);
		                            $failure_key_array = explode(",",$failure_key);
		                            $pending_key_array = explode(",",$pending_key);
		                            
		                           
		                            if (in_array($statusvalue, $success_key_array)) 
		                            {
		                                $status = 'Success';
		                                $lapubalance = "";
		                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		            				    echo "DONE";exit;
		                            }
		                            else if (in_array($statusvalue, $failure_key_array)) 
		                            {
		                                $status = 'Failure';
		                                $lapubalance = "";
		                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                echo "DONE";exit;
		                            }
			                    }
			                    else
			                    {
			                        echo "OK 003";exit;
			                    }
			                }
			                else
			                {
			                    $this->Errorlog->httplog("Callback From Unknown ",$response);
			                     echo "OK 001";exit;
			                }	
		             	}

		                
		            }	
	            }
	            else if($response_type == "PARSER")
	            {

			    	$rsltmessagesettings = $this->db->query("select * from message_setting where api_id = ?",array($api_id));
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
	    				$update_by = $r->update_by;
	    				$ref_id_start = $r->ref_id_start;
	    				$ref_id_end = $r->ref_id_end;



	    				if($update_by == "REFID")
					    {
					    	if (preg_match("/".$status_word."/",$response) == 1)
					    	{
					    		$recharge_id = $this->get_string_between($response, $ref_id_start, $ref_id_end);
		    					$operator_id = $this->get_string_between($response, $operator_id_start, $operator_id_end);
		    					$lapubalance = $this->get_string_between($response, $balance_start, $balance_end);
		    					$operator_id = str_replace("\n","",$operator_id);
		    					$mobile_no = str_replace("\n","",$mobile_no);
		    				    
		    				    $this->Errorlog->httplog("Callback From ".$api_name,$response,$recharge_id);



		    					$rsltrec = $this->db->query("select recharge_id,ExecuteBy from tblrecharge where recharge_id = ? and recharge_status = 'Pending' and Date(add_date) = ?",array(trim($recharge_id),$this->common->getMySqlDate()));
		    					//print_r($rsltrec->result());exit;
		    					if($rsltrec->num_rows() == 1)
		    					{
							     	$this->load->model("Update_methods");
	    							$this->Update_methods->updateRechargeStatus($rsltrec->row(0)->recharge_id,$operator_id,$status,true,$lapubalance);
	    							echo $status."  ".$operator_id;exit;  		
		    					}
					    	}
					    }
	    				else
	    				{
	    					if (preg_match("/".$status_word."/",$response) == 1)
		    				{
		    				    $mobile_no = $this->get_string_between($response, $num_start, $num_end);
		    					$operator_id = $this->get_string_between($response, $operator_id_start, $operator_id_end);
		    					$lapubalance = $this->get_string_between($response, $balance_start, $balance_end);
		    					$operator_id = str_replace("\n","",$operator_id);
		    					$mobile_no = str_replace("\n","",$mobile_no);
		    				//	echo $mobile_no."  ".$operator_id;exit;
		    					$rsltrec = $this->db->query("select recharge_id,ExecuteBy from tblrecharge where mobile_no = ? and recharge_status = 'Pending' and Date(add_date) = ?",array(trim($mobile_no),$this->common->getMySqlDate()));
		    					//print_r($rsltrec->result());exit;
		    					if($rsltrec->num_rows() == 1)
		    					{
		    						$recharge_id = $rsltrec->row(0)->recharge_id;
		    						$this->Errorlog->httplog("Callback From ".$api_name,$response,$recharge_id);
    					    		$this->load->model("Update_methods");
        							$this->Update_methods->updateRechargeStatus($rsltrec->row(0)->recharge_id,$operator_id,$status,true,$lapubalance);
        							echo $status."  ".$operator_id;exit;	
		    					}	
		    				}	
	    				}
	    				//echo $status_word;exit;
	    				
	    			
	    			}
			    
	            }
	           
	            
	            
	            else
	            {
	                $this->Errorlog->httplog("Callback From Unknown ",$response);
	                echo "Callback Configuration Missing invalid params";exit;
	            }
	            
	        }
	        else
	        {
	            $this->Errorlog->httplog("Callback From Unknown ",$response);
	             echo "OK 002";exit;
	        }
	    }
	    else
	    {
	        $this->Errorlog->httplog("Callback From Unknown ",$response);
	        echo "UNKNOWN PROVIDER RESPONSE";exit;
	    }
    }
}