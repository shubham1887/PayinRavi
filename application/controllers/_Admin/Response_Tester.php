<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Response_Tester extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function index()  
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Submit")
			{
				$api_id = intval(trim($this->input->post("ddlapi")));
				$response = $this->input->post("txtResponse");
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
            	         $operator_id = "";
            	         $status = "";
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
                            if(isset($obj[$recharge_response_status_field]))
                            {
                                $statusvalue = $obj[$recharge_response_status_field];
                                $operator_id = json_encode($obj[$recharge_response_opid_field]);
                                $lapubalance = "";
                                
                                $success_key_array = explode(",",$RecRespSuccessKey);
                                $failure_key_array = explode(",",$RecRespFailureKey);
                                $pending_key_array = explode(",",$RecRespPendingKey);
                                
                               
                                if (in_array($statusvalue, $success_key_array)) 
                                {
                                    $status = 'Success';
                                }
                                else if (in_array($statusvalue, $failure_key_array)) 
                                {
                                    $status = 'Failure';                                }
                                else  if (in_array($statusvalue, $pending_key_array)) 
                                {
                                    $status = 'Pending';
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
                                $lapubalance = "";
                                
                                $success_key_array = explode(",",$RecRespSuccessKey);
                                $failure_key_array = explode(",",$RecRespFailureKey);
                                $pending_key_array = explode(",",$RecRespPendingKey);
                                
                               
                                if(in_array($statusvalue, $success_key_array)) 
                                {
                                    $status = 'Success';
                                }
                                else if (in_array($statusvalue, $failure_key_array)) 
                                {
                                    $status = 'Failure';
                                }
                                else  if (in_array($statusvalue, $pending_key_array)) 
                                {
                                    $status = 'Pending';
                                }
                            }
                            else
                            {
                                $status = 'Pending';
                            }
                            
                        }
                        else if($recharge_response_type == "CSV")
                        {
                            $obj = explode($response_separator,$response);
                            if(isset($obj[$recharge_response_status_field]))
                            {
                                $statusvalue = $obj[$recharge_response_status_field];
                                $operator_id = json_encode($obj[$recharge_response_opid_field]);
                                $lapubalance = "";
                                
                                $success_key_array = explode(",",$RecRespSuccessKey);
                                $failure_key_array = explode(",",$RecRespFailureKey);
                                $pending_key_array = explode(",",$RecRespPendingKey);
                                
                               
                                if (in_array($statusvalue, $success_key_array)) 
                                {
                                    $status = 'Success';
                                }
                                else if (in_array($statusvalue, $failure_key_array)) 
                                {
                                    $status = 'Failure';
                                }
                                else  if (in_array($statusvalue, $pending_key_array)) 
                                {
                                    $status = 'Pending';
                                }
                            }
                            else
                            {
                                $status = 'Pending';
                            }
                            
                        }
                        
                    $this->view_data['ddlapi']  = $api_id;
    				$this->view_data['status']  = $status;
    				$this->view_data['response']  = $response;
    				$this->view_data['operator_id']  = $operator_id;
    				$this->load->view('_Admin/Response_Tester_view',$this->view_data);	 
            	         
    			}
				
				
				
			}					
			else
			{
			    $this->view_data['ddlapi']  = "ALL";
				$this->view_data['status']  = "";
				$this->view_data['response']  = "";
				$this->view_data['operator_id']  = "";
				$this->load->view('_Admin/Response_Tester_view',$this->view_data);																						
			}
		} 
	}	
}