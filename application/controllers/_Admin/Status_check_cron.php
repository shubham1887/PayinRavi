<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_check_cron extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
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
		
		if ($ini == 0) {return '';}
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
    public function checkduplicate($recharge_id,$API)
    {
    	
    	$rslt = $this->db->query("insert into remove_queue_duplication_retry (recharge_id,add_date,ipaddress,API) values(?,?,?,?)",array($recharge_id,$this->common->getDate(),$this->common->getRealIpAddr(),$API));
    	  if($rslt == "" or $rslt == NULL)
    	  {
    		return false;
    	  }
    	  else
    	  {
    	  	return true;
    	  }
    }
    
	public function index()  
	{
	  
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache"); 
           // $this->db->query("insert into deleteme(datetime) values(?)",array($this->common->getDate()));
            
            
                $this->load->model("Update_methods");
                $resp = '';
                 $rslt = $this->db->query("
                 SELECT 
    				 a.user_id,
    				 a.recharge_id,
    				 a.api_id,
    				 a.mobile_no,
    				 a.amount,
    				 a.company_id,
    				 a.status,
    				 r.ExecuteBy,
    				 r.add_date
    				 FROM `tblpendingrechares` a 
    				 left join tblrecharge r on a.recharge_id = r.recharge_id
    				where 
    				(a.status = 'Pending' or a.status = 'InProcess')
            order by a.recharge_id limit 10");

                foreach($rslt->result() as $rw)
                {
                    
                     $resp.=$rw->api_id."  ".$rw->mobile_no."  ,";  

                     $company_id = $rw->company_id;
                     $Mobile = $rw->mobile_no;
                     $Amount = $rw->amount;
                     $recharge_id = $rw->recharge_id;
                     $api_id = $rw->api_id;
                     $api_name = $rw->ExecuteBy;
                     $rec_date = $rw->add_date;
                     $cdate = $this->common->getDate();
                     $diff = $this->Update_methods->gethoursbetweentwodates($rec_date,$cdate);
                     if($diff >= 2)
                     {

                     		$apiinfo = $this->db->query("select * from api_configuration where api_name = ?",array($api_name));
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
		        	         



		        	         if($enable_status_check == "yes")
		        	         { 
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
		        	           // echo $url;exit;
		        	            $response = $this->common->callurl(trim($url),$recharge_id);  
		        	            //echo $response;
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
		                        $str_separator = trim($status_api_configuration->row(0)->str_separator);
		                      
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
		                            
		                           
		                           if($statusvalue != "")
		                           {
		                           		//check success
		                           		foreach($success_key_array as $success_key)
		                           		{
		                           			$statusvalue = trim($statusvalue);
		                           			$success_key = trim($success_key);
		                           			if($statusvalue == $success_key)
		                           			{
		                           				$status = 'Success';
				                                $lapubalance = "";
				                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
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
		                           				$status = "Failure";
				                                $lapubalance = "";
				                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
				                                break;
		                           			}
		                           		}
		                           }
		                           
		                            // if (in_array($statusvalue, $success_key_array)) 
		                            // {
		                            //     $status = 'Success';
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                            //     $resparray = array(
			                           //      "message"=>"Recharge Success With Operator Id ".$operator_id ,
			                           //      "status"=>0,
			                           //      "statuscode"=>"Success",
			                           //      "data"=>array
			                           //              (
			                           //                  "url"=>$url,
			                           //                  "Response"=>$response
			                           //              )
			                           //     );
		            	               //  echo json_encode($resparray);exit;
		            					
		                            // }
		                            // else if (in_array($statusvalue, $failure_key_array)) 
		                            // {
		                            //     $status = "Failure";
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                               
		                            // }
		                            // else if (in_array($statusvalue, $refund_key_array)) 
		                            // {
		                            //     $status = "Failure";
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                
		                            // }
		                            // else  if (in_array($statusvalue, $pending_key_array)) 
		                            // {
		                            //     $status = 'Pending';
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                
		                               
		                            // }
		                        } 
		                        else if(strtoupper($response_type) == "JSON")
		                        {


		                            $obj = (array)json_decode( $response);

		                            $statusvalue = $obj[$status_field];
		                            
		                            $operator_id = json_encode($obj[$opid_field]);
		                            $operator_id = str_replace('"','', $operator_id);
		                            
		                            
		                            $lapubalance = "";
		                            
		                            $success_key_array = explode(",",$success_key);
		                            $failure_key_array = explode(",",$failure_key);
		                            $pending_key_array = explode(",",$pending_key);
		                            $refund_key_array = explode(",",$refund_key);
		                            
		                           
		                           if($statusvalue != "")
		                           {
		                           		//check success
		                           		foreach($success_key_array as $success_key)
		                           		{
		                           			$statusvalue = trim($statusvalue);
		                           			$success_key = trim($success_key);
		                           			if($statusvalue == $success_key)
		                           			{
		                           				$status = 'Success';
				                                $lapubalance = "";
				                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
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
		                           				$status = "Failure";
				                                $lapubalance = "";
				                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
				                                break;
		                           			}
		                           		}
		                           }
		                           
		                            // if (in_array($statusvalue, $success_key_array)) 
		                            // {
		                            //     $status = 'Success';
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                
		            					
		                            // }
		                            // if (in_array($statusvalue, $failure_key_array)) 
		                            // {
		                            //     $status = "Failure";
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                               
		                            // }
		                            
		                            // else  if (in_array($statusvalue, $pending_key_array)) 
		                            // {
		                            //     $status = 'Pending';
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                
		                               
		                            // }
		                        }
		                        else if(strtoupper($response_type) == "CSV")
		                        {
		                            $obj = explode($str_separator, $response);
		                            $statusvalue = $obj[$status_field];
		                            
		                            $operator_id = json_encode($obj[$opid_field]);
		                            $operator_id = str_replace('"','', $operator_id);
		                            
		                            
		                            $lapubalance = "";
		                            
		                            $success_key_array = explode(",",$success_key);
		                            $failure_key_array = explode(",",$failure_key);
		                            $pending_key_array = explode(",",$pending_key);
		                            $refund_key_array = explode(",",$refund_key);
		                            
		                           
		                          	if($statusvalue != "")
		                           {
		                           		//check success
		                           		foreach($success_key_array as $success_key)
		                           		{
		                           			$statusvalue = trim($statusvalue);
		                           			$success_key = trim($success_key);
		                           			if($statusvalue == $success_key)
		                           			{
		                           				$status = 'Success';
				                                $lapubalance = "";
				                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
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
		                           				$status = "Failure";
				                                $lapubalance = "";
				                                $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
				                                break;
		                           			}
		                           		}
		                           } 
		                           
		                            // if (in_array($statusvalue, $success_key_array)) 
		                            // {
		                            //     $status = 'Success';
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                
		            					
		                            // }
		                            // else if (in_array($statusvalue, $failure_key_array)) 
		                            // {
		                            //     $status = "Failure";
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                               
		                            // }
		                            // else if (in_array($statusvalue, $refund_key_array)) 
		                            // {
		                            //     $status = "Failure";
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                
		                            // }
		                            // else  if (in_array($statusvalue, $pending_key_array)) 
		                            // {
		                            //     $status = 'Pending';
		                            //     $lapubalance = "";
		                            //     $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true,$lapubalance);
		                                
		                               
		                            // }
		                        } 
		                        else
		                        {
		                            
		                        }
		        	        }
		        	        else
		        	        {
		        	            
		        	        }
		        	    }//status check if condition end
		        	      
					}
                     }	
            	}
                
              
	}
	private function loging($recharge_id,$actionfrom,$remark)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into tbllogs(recharge_id,add_date,ipaddress,actionfrom,remark) values(?,?,?,?,?)",
						array($recharge_id,$add_date,$ipaddress,$actionfrom,$remark));
	}
	public function ExecuteAPI($url)
	{	
	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
}