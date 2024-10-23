<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	
	
	
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
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug  = TRUE;
    }
    public function copyapi()
    {
    	$api_id = $this->input->get("id");
    	$api_name = $this->input->get("name");

    	

    	$rsltapiinsert = $this->db->query("INSERT INTO `api_configuration`(`api_name`, `api_type`, `is_active`, `is_random`, `enable_recharge`, `enable_balance_check`, `enable_status_check`, `hostname`, `param1`, `param2`, `param3`, `param4`, `param5`, `param6`, `param7`, `header_key1`, `header_value1`, `header_key2`, `header_value2`, `header_key3`, `header_value3`, `header_key4`, `header_value4`, `header_key5`, `header_value5`, `balance_check_api_method`, `balance_ceck_api`, `status_check_api_method`, `status_check_api`, `validation_api_method`, `validation_api`, `transaction_api_method`, `api_prepaid`, `api_dth`, `api_postpaid`, `api_electricity`, `api_gas`, `api_insurance`, `dunamic_callback_url`, `response_parser`, `balnace_check_response_type`, `balnace_check_response_balfieldName`, `recharge_response_type`, `response_separator`, `recharge_response_status_field`, `recharge_response_opid_field`, `recharge_response_apirefid_field`, `recharge_response_balance_field`, `recharge_response_remark_field`, `recharge_response_stat_field`, `recharge_response_fos_field`, `recharge_response_otf_field`, `recharge_response_lapunumber_field`, `recharge_response_message_field`, `pendingOnEmptyTxnId`, `RecRespSuccessKey`, `RecRespPendingKey`, `RecRespFailureKey`, `api_time_from`, `api_time_to`, `min_balance_limit`, `balance_check_start_word`, `balance_check_end_word`)
select ?, `api_type`, `is_active`, `is_random`, `enable_recharge`, `enable_balance_check`, `enable_status_check`, `hostname`, `param1`, `param2`, `param3`, `param4`, `param5`, `param6`, `param7`, `header_key1`, `header_value1`, `header_key2`, `header_value2`, `header_key3`, `header_value3`, `header_key4`, `header_value4`, `header_key5`, `header_value5`, `balance_check_api_method`, `balance_ceck_api`, `status_check_api_method`, `status_check_api`, `validation_api_method`, `validation_api`, `transaction_api_method`, `api_prepaid`, `api_dth`, `api_postpaid`, `api_electricity`, `api_gas`, `api_insurance`, `dunamic_callback_url`, `response_parser`, `balnace_check_response_type`, `balnace_check_response_balfieldName`, `recharge_response_type`, `response_separator`, `recharge_response_status_field`, `recharge_response_opid_field`, `recharge_response_apirefid_field`, `recharge_response_balance_field`, `recharge_response_remark_field`, `recharge_response_stat_field`, `recharge_response_fos_field`, `recharge_response_otf_field`, `recharge_response_lapunumber_field`, `recharge_response_message_field`, `pendingOnEmptyTxnId`, `RecRespSuccessKey`, `RecRespPendingKey`, `RecRespFailureKey`, `api_time_from`, `api_time_to`, `min_balance_limit`, `balance_check_start_word`, `balance_check_end_word` from api_configuration where Id = ?",array($api_name,$api_id));
    
    	if($rsltapiinsert == true)
    	{
    		$insert_id = $this->db->insert_id();
    		$this->db->query("insert INTO `status_api_configuration`(`api_id`, `response_type`, `status_field`, `opid_field`, `state_field`, `fos_field`, `otf_field`, `lapunumber_field`, `message_field`, `success_key`, `pending_key`, `failure_key`, `refund_key`, `notfound_key`, `str_separator`)
select ?, `response_type`, `status_field`, `opid_field`, `state_field`, `fos_field`, `otf_field`, `lapunumber_field`, `message_field`, `success_key`, `pending_key`, `failure_key`, `refund_key`, `notfound_key`, `str_separator` from status_api_configuration where api_id = ?",array($insert_id,$api_id));



    		$this->db->query("insert INTO `callback_settings`(`api_id`, `reqid_name`, `apirefid_name`, `check_through_reqid`, `status_name`, `opid_name`, `success_key`, `pending_key`, `failure_key`, `refund_key`, `response_type`)

SELECT ? , `reqid_name`, `apirefid_name`, `check_through_reqid`, `status_name`, `opid_name`, `success_key`, `pending_key`, `failure_key`, `refund_key`, `response_type` from callback_settings where api_id = ?",array($insert_id,$api_id));


    		$this->db->query("INSERT into  `tbloperatorcodes`(`company_id`, `api_id`, `code`, `commission`, `commission_type`, `commission_slab`, `OpParam1`, `OpParam2`, `OpParam3`, `OpParam4`, `OpParam5`)

select `company_id`, ?, `code`, `commission`, `commission_type`, `commission_slab`, `OpParam1`, `OpParam2`, `OpParam3`, `OpParam4`, `OpParam5` 
from tbloperatorcodes where api_id = ?",array($insert_id,$api_id));


    	}
    	else
    	{
    		echo "error";exit;
    	}


    }
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		
		$this->view_data['pagination'] = "";
		$this->view_data['result_api'] = $this->db->query("
		select a.*
		from api_configuration a
		where a.Id > 3 
		order by a.api_name desc");
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/api_view',$this->view_data);		
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
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				$ApiName = $this->input->post("txtAPIName",TRUE);
				$UserName = $this->input->post("txtUserName",TRUE);
				$Password = $this->input->post("txtPassword",TRUE);
				$Ip = $this->input->post("txtIp",TRUE);	
				$Token = $this->input->post("txtToken",TRUE);	
				$httpmethod = $this->input->post("ddlhttpmethod",TRUE);				
				$parameters = str_replace(" ","%20",$this->input->post("txtparameters",TRUE));	
				$txtMinBalanceLimit = $this->input->post("txtMinBalanceLimit",TRUE);	
				$apigroup = $this->input->post("ddlapigroup",TRUE);	
				
				$this->load->model('Api_model');
				
				$result = $this->db->query("insert into tblapi(api_name,username,password,static_ip,apitocken,add_date,ipaddress,httpmethod,params,status,minbalance_limit,apigroup) values(?,?,?,?,?,?,?,?,?,?,?,?)",array($ApiName,$UserName,$Password,$Ip,$Token,$this->common->getDate(),$this->common->getRealIpAddr(),$httpmethod,$parameters,1,$txtMinBalanceLimit,$apigroup));		
				
				
				$this->msg ="Api Add Successfully.";
				$this->pageview();
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{				
				$apiID = $this->input->post("hidID",TRUE);
				$ApiName = $this->input->post("txtAPIName",TRUE);
				$UserName = $this->input->post("txtUserName",TRUE);
				$Password = $this->input->post("txtPassword",TRUE);
				$Ip = $this->input->post("txtIp",TRUE);			
				$Token = $this->input->post("txtToken",TRUE);	
				$httpmethod = $this->input->post("ddlhttpmethod",TRUE);				
				$parameters = str_replace(" ","%20",$this->input->post("txtparameters",TRUE));
				$ddlstatus = $this->input->post("ddlstatus",TRUE);	
				$txtMinBalanceLimit = $this->input->post("txtMinBalanceLimit",TRUE);	
				$apigroup = $this->input->post("ddlapigroup",TRUE);	
				//echo $parameters ;exit;
				
				
				$Status = $this->input->post("hidStatus",TRUE);					
				$this->load->model('Api_model');
				$result = $this->db->query("update tblapi set api_name=?,username=?,password=?,static_ip=?,apitocken=?,httpmethod=?,params = ?,status = ?,minbalance_limit = ?,apigroup = ? where api_id=?",array($ApiName,$UserName,$Password,$Ip,$Token,$httpmethod,$parameters,$ddlstatus,$txtMinBalanceLimit,$apigroup,$apiID));		
				
				$this->msg ="Api Update Successfully.";
				$this->pageview();
							
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$apiID = $this->input->post("hidValue",TRUE);
				$this->load->model('Api_model');
				if($this->Api_model->delete($apiID) == true)
				{
					$this->msg ="Api Delete Successfully.";
					$this->pageview();
				}
				else
				{
					
				}				
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}
	public function getapibalance()
	{
		if(isset($_GET["id"]))
		{
		    $id = $_GET["id"];
	        echo $id."#".$this->Api_model->getBalance($id)."#";exit;	    
		}
		
	}
}