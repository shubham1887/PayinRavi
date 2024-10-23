<?php
class Reroot_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	
    public function doReroot($recharge_id,$api_id,$reroot_api_index,$callback = false)
    {
        $this->Update_methods->templog($recharge_id,"Reroot_start",$recharge_id,"","","","");
        $recharge_info = $this->db->query("
                                            select 
                                                a.recharge_id,
                                                a.company_id,
                                                a.user_id,
                                                a.mobile_no,
                                                a.amount,
                                                a.status,
                                                a.api_id,
                                                a.add_date
                                                from tblpendingrechares a
                                                where 
                                                    a.recharge_id = ?
                                         ",array($recharge_id));
        if($recharge_info->num_rows() == 1)
        {
            $recharge_id =  $recharge_info->row(0)->recharge_id;
            $company_id =  $recharge_info->row(0)->company_id;
            $user_id =  $recharge_info->row(0)->user_id;
            $Mobile =  $recharge_info->row(0)->mobile_no;
            $Amount =  $recharge_info->row(0)->amount;
            $status =  $recharge_info->row(0)->status;
           
           
            $this->Update_methods->templog($recharge_id,"Reroot_Step1",$recharge_id,$status,"","","");
            
           $apiinfo = $this->db->query("select * from api_configuration where Id = ?",array($api_id));
		   if($apiinfo->num_rows() == 1)
		   {
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
        	          
        	         ///////////////////////////////////////////
        	         ////////////////////////////////////////
        	         ///////////////////////
        	         ///////////////////////////////////////////
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
                        	    order by service_id",array($apiinfo->row(0)->Id,$company_id));
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
                   
	            if($reroot_api_index == 1 )
	            {
	               //echo $apiinfo->row(0)->Id."    ".$recharge_id;exit;
	                $this->db->query("update reroot_count set api_1_status = 'done',last_retry_api = ? where recharge_id = ? ",array($apiinfo->row(0)->Id,$recharge_id)); 
	                $this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id)); 
	            }
	            else if($reroot_api_index == 2 )
	            {
	                $this->db->query("update reroot_count set  api_2_status = 'done',last_retry_api = ? where recharge_id = ?",array($apiinfo->row(0)->Id,$recharge_id)); 
	                $this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
	            }
	            else if($reroot_api_index == 3 )
	            {
	                $this->db->query("update reroot_count set  api_3_status = 'done',last_retry_api = ? where recharge_id = ?",array($apiinfo->row(0)->Id,$recharge_id)); 
	                $this->db->query("update tblpendingrechares set ishold = 'no' where recharge_id = ?",array($recharge_id));
	            }
	       
	               $do_api_call = false;
	                
        	        if($transaction_api_method == "GET")
        	        {
        	            $do_api_call = true;
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
        	            $response = $this->common->callurl(trim($url),$recharge_id);  
        	        }
        	        if($transaction_api_method == "POST")
        	        {
        	            $do_api_call = true;
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
        	            
        	            
        	            $postdata = explode("?",$url)[1];
        	            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
        	        }
        	        
        	        
        	        $this->Update_methods->templog($recharge_id,"Reroot_response",$response,$api_name,"","","");
        	        if($do_api_call == true)
        	        {
        	            if($recharge_response_type == "XML")
                        {
                            $obj = (array)simplexml_load_string( $response);
                           
                            $recharge_response_status_field = str_replace("<","",$recharge_response_status_field);
                            $recharge_response_status_field = str_replace(">","",$recharge_response_status_field);
                            
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
                                $lapubalance = 0;
                                if(isset($obj[$recharge_response_balance_field]))
                                {
                                    $lapubalance = $obj[$recharge_response_balance_field];    
                                }
                                
                                $success_key_array = explode(",",$RecRespSuccessKey);
                                $failure_key_array = explode(",",$RecRespFailureKey);
                                $pending_key_array = explode(",",$RecRespPendingKey);
                                
                               
                                if (in_array($statusvalue, $success_key_array)) 
                                {
                                    $this->Update_methods->templog($recharge_id,"Reroot_response_in_success",$statusvalue,"","","","");
                                    $status = 'Success';
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                				    return $status;
                                }
                                else if (in_array($statusvalue, $failure_key_array)) 
                                {
                                    $this->Update_methods->templog($recharge_id,"Reroot_response_in_failure",$statusvalue,"","","","");
                                    $status = 'Failure';
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                				    return $status;
                                }
                                else  if (in_array($statusvalue, $pending_key_array)) 
                                {
                                    $this->Update_methods->templog($recharge_id,"Reroot_response_in_pending",$statusvalue,"","","","");
                                    $status = 'Pending';
                                    $operator_id = "";
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                                    return $status;
                                }   
                            }
                            else
                            {
                                $status = 'Pending';
                                return $status;
                            }
                        }
                        else if($recharge_response_type == "JSON")
                        {
                            $obj = (array)json_decode($response);
                           
                            if(isset($obj[$recharge_response_status_field]))
                            {
                                $statusvalue = $obj[$recharge_response_status_field];
                                $operator_id = json_encode($obj[$recharge_response_opid_field]);
                                $lapubalance = 0;
                                if(isset($obj[$recharge_response_balance_field]))
                                {
                                    $lapubalance = $obj[$recharge_response_balance_field];    
                                }
                                
                                $success_key_array = explode(",",$RecRespSuccessKey);
                                $failure_key_array = explode(",",$RecRespFailureKey);
                                $pending_key_array = explode(",",$RecRespPendingKey);
                                
                               
                                if(in_array($statusvalue, $success_key_array)) 
                                {
                                    $status = 'Success';
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                				    return $status;
                                }
                                else if (in_array($statusvalue, $failure_key_array)) 
                                {
                                    $status = 'Failure';
                                    
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                				    return $status;
                                }
                                else  if (in_array($statusvalue, $pending_key_array)) 
                                {
                                    $status = 'Pending';
                                    $operator_id = "";
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                                    return $status;
                                }
                            }
                            else
                            {
                                $status = 'Pending';
                                $operator_id = "";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                                return $status;
                            }
                            
                        }
                        else if($recharge_response_type == "CSV")
                        {
                            $obj = explode($response_separator,$response);
                            if(isset($obj[$recharge_response_status_field]))
                            {
                                $statusvalue = $obj[$recharge_response_status_field];
                                $operator_id = json_encode($obj[$recharge_response_opid_field]);
                                $lapubalance = 0;
                                if(isset($obj[$recharge_response_balance_field]))
                                {
                                    $lapubalance = $obj[$recharge_response_balance_field];    
                                }
                                
                                $success_key_array = explode(",",$RecRespSuccessKey);
                                $failure_key_array = explode(",",$RecRespFailureKey);
                                $pending_key_array = explode(",",$RecRespPendingKey);
                                
                               
                                if (in_array($statusvalue, $success_key_array)) 
                                {
                                    $status = 'Success';
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                				    return $status;
                                }
                                else if (in_array($statusvalue, $failure_key_array)) 
                                {
                                    $status = 'Failure';
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                				    return $status;
                                }
                                else  if (in_array($statusvalue, $pending_key_array)) 
                                {
                                    $status = 'Pending';
                                    $operator_id = "";
                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                                    return $status;
                                }
                            }
                            else
                            {
                                $status = 'Pending';
                                $operator_id = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,$callback,$lapubalance);
                                return $status;
                            }
                            
                        }
        	        }
        	        else
        	        {
        	            $status  = "Pending";
        	            return $status;
        	        }
                   
        	      
			}
			        
        }
    }
    public function check_status($recharge_info)
    {
        $recharge_id = $recharge_info->row(0)->recharge_id;
        $company_id = $recharge_info->row(0)->company_id;
        $Mobile = $recharge_info->row(0)->mobile_no;
        $Amount = $recharge_info->row(0)->amount;
        $apiinfo = $this->db->query("select * from api_configuration where Id = ?",array($recharge_info->row(0)->api_id));
        
		if($apiinfo->num_rows() == 1)
		{
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
    	          
    	         ///////////////////////////////////////////
    	         ////////////////////////////////////////
    	         ///////////////////////
    	         ///////////////////////////////////////////
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
                $url = $hostname;
    	        if($status_check_api_method == "GET")
    	        {
    	            
    	           
    	            $status_check_api  = str_replace("@param1",$param1, $status_check_api);
    	            $status_check_api  = str_replace("@param2",$param2, $status_check_api);
    	            $status_check_api  = str_replace("@param3",$param3, $status_check_api);
    	            $status_check_api  = str_replace("@param4",$param4, $status_check_api);
    	            $status_check_api  = str_replace("@param5",$param5, $status_check_api);
    	            $status_check_api  = str_replace("@param6",$param6, $status_check_api);
    	            $status_check_api  = str_replace("@param7",$param7, $status_check_api);
    	            
    	            $url = $hostname.$status_check_api;
    	           
    	            
    	            $url  = str_replace("@mn",$Mobile, $url);
    	            $url  = str_replace("@amt",$Amount, $url);
    	            $url  = str_replace("@opparam1",$OpParam1, $url);
    	            $url  = str_replace("@opparam2",$OpParam2, $url);
    	            $url  = str_replace("@opparam3",$OpParam3, $url);
    	            $url  = str_replace("@opparam4",$OpParam4, $url);
    	            $url  = str_replace("@opparam5",$OpParam5, $url);
    	            $url  = str_replace("@reqid",$recharge_id, $url);
    	            $response = $this->common->callurl(trim($url),$recharge_id);  
    	           // echo $response;
    	           // echo "<br>";
    	        }
    	       
    	        if($status_check_api_method == "POST")
    	        {
    	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
    	            $status_check_api  = str_replace("@param1",$param1, $status_check_api);
    	            $status_check_api  = str_replace("@param2",$param2, $status_check_api);
    	            $status_check_api  = str_replace("@param3",$param3, $status_check_api);
    	            $status_check_api  = str_replace("@param4",$param4, $status_check_api);
    	            $status_check_api  = str_replace("@param5",$param5, $status_check_api);
    	            $status_check_api  = str_replace("@param6",$param6, $status_check_api);
    	            $status_check_api  = str_replace("@param7",$param7, $status_check_api);
    	            
    	            $url = $hostname.$status_check_api;
    	           
    	            
    	            $url  = str_replace("@mn",$Mobile, $url);
    	            $url  = str_replace("@amt",$Amount, $url);
    	            $url  = str_replace("@opparam1",$OpParam1, $url);
    	            $url  = str_replace("@opparam2",$OpParam2, $url);
    	            $url  = str_replace("@opparam3",$OpParam3, $url);
    	            $url  = str_replace("@opparam4",$OpParam4, $url);
    	            $url  = str_replace("@opparam5",$OpParam5, $url);
    	            $url  = str_replace("@reqid",$recharge_id, $url);
    	            
    	            
    	            $postdata = explode("?",$url)[1];
    	            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
    	        }
    	        
    	        
    	        
    	      
    	        $status_api_configuration = $this->db->query("select * from status_api_configuration where api_id = ?",array($api_id));
    	        if($status_api_configuration->num_rows() == 1)
    	        {
    	            $api_id = trim($status_api_configuration->row(0)->api_id);
                    $response_type = trim($status_api_configuration->row(0)->response_type);
                    $status_field = trim($status_api_configuration->row(0)->status_field);
                    $opid_field = trim($status_api_configuration->row(0)->opid_field);
                    $state_field = trim($status_api_configuration->row(0)->state_field);
                    $fos_field = trim($status_api_configuration->row(0)->fos_field);	
                    $otf_field = trim($status_api_configuration->row(0)->otf_field);
                    $lapunumber_field = trim($status_api_configuration->row(0)->lapunumber_field);
                    $message_field = trim($status_api_configuration->row(0)->message_field);
                    $success_key = trim($status_api_configuration->row(0)->success_key);
                    $pending_key = trim($status_api_configuration->row(0)->pending_key);
                    $failure_key = trim($status_api_configuration->row(0)->failure_key);
                    $refund_key = trim($status_api_configuration->row(0)->refund_key);
                    $notfound_key = trim($status_api_configuration->row(0)->notfound_key);
                   
                    if(strtoupper($response_type) == "XML")
                    {
                        $obj = (array)simplexml_load_string( $response);
                       
                       
                        $status_field = str_replace("<","",$status_field);
                        $status_field = str_replace(">","",$status_field);
                        
                      
                        
                        $opid_field = str_replace("<","",$opid_field);
                        $opid_field = str_replace(">","",$opid_field);
                        
                        $statusvalue = $obj[$status_field];
                        
                        $operator_id = json_encode($obj[$opid_field]);
                        $operator_id = str_replace('"','', $operator_id);
                        
                        
                        $lapubalance = "";
                        
                        $success_key_array = explode(",",$success_key);
                        $failure_key_array = explode(",",$failure_key);
                        $pending_key_array = explode(",",$pending_key);
                        $refund_key_array = explode(",",$refund_key);
                        
                       
                       
                       
                        if (in_array($statusvalue, $success_key_array)) 
                        {
                            $status = 'Success';
                            $lapubalance = "";
                            $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                            return $status;
        					
                        }
                        else if (in_array($statusvalue, $failure_key_array)) 
                        {
                            $status = "Failure";
                            return $status;
                        }
                        else if (in_array($statusvalue, $refund_key_array)) 
                        {
                            $status = "Failure";
                            return $status;
                        }
                        else  if (in_array($statusvalue, $pending_key_array)) 
                        {
                            $status = 'Pending';
                            return $status;
                        }
                    } 
                    else if(strtoupper($response_type) == "JSON")
                    {
                        $obj = (array)json_decode( $response);
                        if(isset($obj[$status_field]))
                        {
                            $statusvalue = $obj[$status_field];
                        
                            $operator_id = json_encode($obj[$opid_field]);
                            $operator_id = str_replace('"','', $operator_id);
                            
                            
                            $lapubalance = "";
                            
                            $success_key_array = explode(",",$success_key);
                            $failure_key_array = explode(",",$failure_key);
                            $pending_key_array = explode(",",$pending_key);
                            $refund_key_array = explode(",",$refund_key);
                            
                           
                           
                           
                            if (in_array($statusvalue, $success_key_array)) 
                            {
                                $status = 'Success';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                return $status;
                            }
                            else if (in_array($statusvalue, $failure_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                return $status;
                            }
                            else if (in_array($statusvalue, $refund_key_array)) 
                            {
                                $status = "Failure";
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                return $status;
                            }
                            else  if (in_array($statusvalue, $pending_key_array)) 
                            {
                                $status = 'Pending';
                                $lapubalance = "";
                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
                                return $status;
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
}

?>