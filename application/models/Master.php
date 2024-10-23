<?php
class Master extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
		  
	}
	
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//////////////////
//////////////////  B A L A N C E    A P I   C O D E
/////////////////
/////////////////////////////////////////////////////////////

    public function getBalance($api_id)
    { 
        $ApiInfo = $this->db->query("select a.* from api_configuration a   where a.Id = ? and a.enable_balance_check = 'yes'",array($api_id));
    	if($ApiInfo->num_rows()  == 1)
		{
		    //print_r($ApiInfo->result());exit;
		    $apiinfo = $ApiInfo;
            $api_id = $apiinfo->row(0)->Id;
	        $api_name = $apiinfo->row(0)->api_name;
	        $api_type = $apiinfo->row(0)->api_type;
	        $is_active = $apiinfo->row(0)->is_active;
	        
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
	        $balnace_check_response_type = $apiinfo->row(0)->balnace_check_response_type;
	        $balnace_check_response_balfieldName = $apiinfo->row(0)->balnace_check_response_balfieldName;
	        $api_call_done = false;
	        if($balance_check_api_method == "GET" or $balance_check_api_method == "POST" )
	        {
	           
	            if($balance_check_api_method == "GET")
    	        {
    	            $api_call_done = true;
    	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
    	            $balance_ceck_api  = str_replace("@param1",$param1, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param2",$param2, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param3",$param3, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param4",$param4, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param5",$param5, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param6",$param6, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param7",$param7, $balance_ceck_api);
    	            
    	            $url = $hostname."".$balance_ceck_api;
    	         
    	            $url  = str_replace("@opparam1",$OpParam1, $url);
    	            $url  = str_replace("@opparam2",$OpParam2, $url);
    	            $url  = str_replace("@opparam3",$OpParam3, $url);
    	            $url  = str_replace("@opparam4",$OpParam4, $url);
    	            $url  = str_replace("@opparam5",$OpParam5, $url);
    	            $response = $this->common->callurl(trim($url),0);  
    	        
    	           
    	        }
    	        if($transaction_api_method == "POST")
    	        {
    	            $api_call_done = true;
    	            $balance_ceck_api  = str_replace("@param1",$param1, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param2",$param2, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param3",$param3, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param4",$param4, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param5",$param5, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param6",$param6, $balance_ceck_api);
    	            $balance_ceck_api  = str_replace("@param7",$param7, $balance_ceck_api);
    	            
    	            $url = $hostname."".$balance_ceck_api;
    	         
    	            $url  = str_replace("@opparam1",$OpParam1, $url);
    	            $url  = str_replace("@opparam2",$OpParam2, $url);
    	            $url  = str_replace("@opparam3",$OpParam3, $url);
    	            $url  = str_replace("@opparam4",$OpParam4, $url);
    	            $url  = str_replace("@opparam5",$OpParam5, $url);
    	            
    	            
    	            
    	            $postdata = explode("?",$url)[1];
    	            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
    	        }
    	       
    	        if($balnace_check_response_type == "XML")
                {
                    
                    $obj = (array)simplexml_load_string( $response);
                   $balnace_check_response_balfieldName = str_replace("<","",$balnace_check_response_balfieldName);
                   $balnace_check_response_balfieldName = str_replace(">","",$balnace_check_response_balfieldName);
                    $balance = $obj[$balnace_check_response_balfieldName];
                    return $balance;
                }
                else if($balnace_check_response_type == "JSON")
                {
                    $obj = (array)json_decode($response);
                    $balance = $obj[$balnace_check_response_balfieldName];
                    return $balance;
                }
                else
                {
                    return "";
                }
	        }
	        else
	        {
	            return "";
	        }
	        
		}
		else
		{
		    return "";
		}
    }

    public function getApiDropdown()
    {
         $masterdb = $this->load->database('master', TRUE); 
        $ddloptions = '';
	    $rsltpai = $masterdb->query("select a.Id,a.api_name from api_configuration a where a.is_active = 'yes' and a.enable_recharge = 'yes' and is_random = 'no' order by a.api_name");
	    foreach($rsltpai->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->Id.'">'.$rw->api_name.'</option>';
	    }
	    return $ddloptions;
    }
    public function getApiSettings($api_id)
    {
     $data_array = array();
      $masterdb = $this->load->database('master', TRUE); 
      $rsltpai = $masterdb->query("
            SELECT 
                a.Id, a.api_name, a.api_type, a.is_active, a.is_random, a.enable_recharge, a.enable_balance_check, 
                a.enable_status_check, a.hostname, a.param1, a.param2, a.param3, a.param4, a.param5, a.param6, a.param7, 
                a.header_key1, a.header_value1, a.header_key2, a.header_value2, a.header_key3, a.header_value3, a.header_key4, 
                a.header_value4, a.header_key5, a.header_value5, a.balance_check_api_method, a.balance_ceck_api, a.status_check_api_method, 
                a.status_check_api, a.validation_api_method, a.validation_api, a.transaction_api_method, a.api_prepaid, a.api_dth, a.api_postpaid, 
                a.api_electricity, a.api_gas, a.api_insurance, a.dunamic_callback_url, a.response_parser, a.balnace_check_response_type, 
                a.balnace_check_response_balfieldName, a.recharge_response_type, a.response_separator, a.recharge_response_status_field, 
                a.recharge_response_opid_field, a.recharge_response_apirefid_field, a.recharge_response_balance_field, 
                a.recharge_response_remark_field, a.recharge_response_stat_field, a.recharge_response_fos_field, a.recharge_response_otf_field, 
                a.recharge_response_lapunumber_field, a.recharge_response_message_field, a.pendingOnEmptyTxnId, a.RecRespSuccessKey, a.RecRespPendingKey, a.RecRespFailureKey,

                s.response_type as stc_response_type, 
                s.status_field as stc_status_field, 
                s.opid_field as stc_opid_field, 
                s.state_field as stc_state_field, 
                s.fos_field as stc_fos_field, 
                s.otf_field as stc_otf_field, 
                s.lapunumber_field as stc_lapunumber_field, 
                s.message_field  as stc_message_field, 
                s.success_key as stc_success_key, 
                s.pending_key as stc_pending_key, 
                s.failure_key  as stc_failure_key, 
                s.refund_key  as stc_refund_key, 
                s.notfound_key   as stc_notfound_key,
                
                c.reqid_name as cb_reqid_name,
                c.apirefid_name as cb_apirefid_name,
                c.check_through_reqid as cb_check_through_reqid,
                c.status_name as cb_status_name,
                c.opid_name as cb_opid_name,
                c.success_key as cb_success_key,
                c.pending_key as cb_pending_key,
                c.failure_key as cb_failure_key,
                c.refund_key as cb_refund_key


 FROM api_configuration a 
left join status_api_configuration s on a.Id = s.api_id
left join callback_settings c on a.Id = c.api_id
WHERE a.Id = ?",array($api_id));
	    if($rsltpai->num_rows() == 1)
	    {
	        $Id = $rsltpai->row(0)->Id;
            $api_name = $rsltpai->row(0)->api_name;
            $api_type = $rsltpai->row(0)->api_type;
            $is_active = $rsltpai->row(0)->is_active;
            $is_random = $rsltpai->row(0)->is_random;
            $enable_recharge = $rsltpai->row(0)->enable_recharge;
            $enable_balance_check = $rsltpai->row(0)->enable_balance_check;
            $enable_status_check = $rsltpai->row(0)->enable_status_check;
            $hostname = $rsltpai->row(0)->hostname;
            $param1 = $rsltpai->row(0)->param1;
            $param2 = $rsltpai->row(0)->param2;
            $param3 = $rsltpai->row(0)->param3;
            $param4 = $rsltpai->row(0)->param4;
            $param5 = $rsltpai->row(0)->param5;
            $param6 = $rsltpai->row(0)->param6;
            $param7 = $rsltpai->row(0)->param7;
            $header_key1 = $rsltpai->row(0)->header_key1;
            $header_value1 = $rsltpai->row(0)->header_value1;
            $header_key2 = $rsltpai->row(0)->header_key2;
            $header_value2 = $rsltpai->row(0)->header_value2;
            $header_key3 = $rsltpai->row(0)->header_key3;
            $header_value3 = $rsltpai->row(0)->header_value3;
            $header_key4 = $rsltpai->row(0)->header_key4;
            $header_value4 = $rsltpai->row(0)->header_value4;
            $header_key5 = $rsltpai->row(0)->header_key5;
            $header_value5 = $rsltpai->row(0)->header_value5;
            $balance_check_api_method = $rsltpai->row(0)->balance_check_api_method;
            $balance_ceck_api = $rsltpai->row(0)->balance_ceck_api;
            $status_check_api_method = $rsltpai->row(0)->status_check_api_method;
            $status_check_api = $rsltpai->row(0)->status_check_api;
            $validation_api_method = $rsltpai->row(0)->validation_api_method;
            $validation_api = $rsltpai->row(0)->validation_api;
            $transaction_api_method = $rsltpai->row(0)->transaction_api_method;
            $api_prepaid = $rsltpai->row(0)->api_prepaid;
            $api_dth = $rsltpai->row(0)->api_dth;
            $api_postpaid = $rsltpai->row(0)->api_postpaid;
            $api_electricity = $rsltpai->row(0)->api_electricity;
            $api_gas = $rsltpai->row(0)->api_gas;
            $api_insurance = $rsltpai->row(0)->api_insurance;
            $dunamic_callback_url = $rsltpai->row(0)->dunamic_callback_url;
            $response_parser = $rsltpai->row(0)->response_parser;
            $balnace_check_response_type = $rsltpai->row(0)->balnace_check_response_type;
            $balnace_check_response_balfieldName = $rsltpai->row(0)->balnace_check_response_balfieldName;
            $recharge_response_type = $rsltpai->row(0)->recharge_response_type;
            $response_separator = $rsltpai->row(0)->response_separator;
            $recharge_response_status_field = $rsltpai->row(0)->recharge_response_status_field;
            $recharge_response_opid_field = $rsltpai->row(0)->recharge_response_opid_field;
            $recharge_response_apirefid_field = $rsltpai->row(0)->recharge_response_apirefid_field;
            $recharge_response_balance_field = $rsltpai->row(0)->recharge_response_balance_field;
            $recharge_response_remark_field = $rsltpai->row(0)->recharge_response_remark_field;
            $recharge_response_stat_field = $rsltpai->row(0)->recharge_response_stat_field;
            $recharge_response_fos_field = $rsltpai->row(0)->recharge_response_fos_field;
            $recharge_response_otf_field = $rsltpai->row(0)->recharge_response_otf_field;
            $recharge_response_lapunumber_field = $rsltpai->row(0)->recharge_response_lapunumber_field;
            $recharge_response_message_field = $rsltpai->row(0)->recharge_response_message_field;
            $pendingOnEmptyTxnId = $rsltpai->row(0)->pendingOnEmptyTxnId;
            $RecRespSuccessKey = $rsltpai->row(0)->RecRespSuccessKey;
            $RecRespPendingKey = $rsltpai->row(0)->RecRespPendingKey;
            $RecRespFailureKey = $rsltpai->row(0)->RecRespFailureKey;
            
            $data_array = array("Id" => $Id,
                    "api_name" => $api_name,
                    "api_type" => $api_type,
                    "is_active" => $is_active,
                    "is_random" => $is_random,
                    "enable_recharge" => $enable_recharge,
                    "enable_balance_check" => $enable_balance_check,
                    "enable_status_check" => $enable_status_check,
                    "hostname" => $hostname,
                    "param1" => $param1,
                    "param2" => $param2,
                    "param3" => $param3,
                    "param4" => $param4,
                    "param5" => $param5,
                    "param6" => $param6,
                    "param7" => $param7,
                    "header_key1" => $header_key1,
                    "header_value1" => $header_value1,
                    "header_key2" => $header_key2,
                    "header_value2" => $header_value2,
                    "header_key3" => $header_key3,
                    "header_value3" => $header_value3,
                    "header_key4" => $header_key4,
                    "header_value4" => $header_value4,
                    "header_key5" => $header_key5,
                    "header_value5" => $header_value5,
                    "balance_check_api_method" => $balance_check_api_method,
                    "balance_ceck_api" => $balance_ceck_api,
                    "status_check_api_method" => $status_check_api_method,
                    "status_check_api" => $status_check_api,
                    "validation_api_method" => $validation_api_method,
                    "validation_api" => $validation_api,
                    "transaction_api_method" => $transaction_api_method,
                    "api_prepaid" => $api_prepaid,
                    "api_dth" => $api_dth,
                    "api_postpaid" => $api_postpaid,
                    "api_electricity" => $api_electricity,
                    "api_gas" => $api_gas,
                    "api_insurance" => $api_insurance,
                    "dunamic_callback_url" => $dunamic_callback_url,
                    "response_parser" => $response_parser,
                    "balnace_check_response_type" => $balnace_check_response_type,
                    "balnace_check_response_balfieldName" => $balnace_check_response_balfieldName,
                    "recharge_response_type" => $recharge_response_type,
                    "response_separator" => $response_separator,
                    "recharge_response_status_field" => $recharge_response_status_field,
                    "recharge_response_opid_field" => $recharge_response_opid_field,
                    "recharge_response_apirefid_field" => $recharge_response_apirefid_field,
                    "recharge_response_balance_field" => $recharge_response_balance_field,
                    "recharge_response_remark_field" => $recharge_response_remark_field,
                    "recharge_response_stat_field" => $recharge_response_stat_field,
                    "recharge_response_fos_field" => $recharge_response_fos_field,
                    "recharge_response_otf_field" => $recharge_response_otf_field,
                    "recharge_response_lapunumber_field" => $recharge_response_lapunumber_field,
                    "recharge_response_message_field" => $recharge_response_message_field,
                    "pendingOnEmptyTxnId" => $pendingOnEmptyTxnId,
                    "RecRespSuccessKey" => $RecRespSuccessKey,
                    "RecRespPendingKey" => $RecRespPendingKey,
                    "RecRespFailureKey" => $RecRespFailureKey,
                    );
                    $resp_array = array(
	                                "status"=>0,
	                                "statuscode"=>"TXN",
	                                "message"=>"Success",
	                                "data"=>$data_array
	                        );
	             return json_encode($resp_array); 
	    }
	    else
	    {
	        $resp_array = array(
	                                "status"=>1,
	                                "statuscode"=>"ERR",
	                                "message"=>"Failure",
	                        );
	        return json_encode($resp_array);    
	    }
	    
    }
	
	public function smslog($data)
	{
		/*$filename = "smslog.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');*/
	}
	public function sendResponse($user_id,$response)
	{
		$urlinfo = $this->db->query("select api_execution_url from tblusers where user_id = ?",array($user_id));
		if($urlinfo->num_rows() == 1)
		{
			$resp_url = trim($urlinfo->row(0)->api_execution_url);
			$this->load->model("Errorlog");
			$this->Errorlog->logentry($resp_url."?".$response);
			file_get_contents($resp_url."?".$response);
		}
		
	}
	public	function add($ApiName,$UserName,$Password,$Ipaddr)
	{
		$this->load->library('common');
		$ip = $this->common->getRealIpAddr();
		$date = $this->common->getDate();
		$str_query = "insert into tblapi(api_name,username,password,static_ip,add_date,ipaddress) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($ApiName,$UserName,$Password,$Ipaddr,$date,$ip));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function getsmsapiurl($apiname)
	{
		$rslt = $this->db->query("select url from smsapi where apiname = ?",array($apiname));
		return $rslt->row(0)->url;
	}	
	public	function delete($apiID)
	{	
		$str_query = "delete from tblapi where api_id=?";
		$result = $this->db->query($str_query,array($apiID));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}	
	
	public	function update($apiID,$ApiName,$UserName,$Password,$Ipaddr)
	{	
		$str_query = "update tblapi set api_name=?,username=?,password=?,static_ip=? where api_id=?";
		$result = $this->db->query($str_query,array($ApiName,$UserName,$Password,$Ipaddr,$apiID));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}	
	public function get_api()
	{
		$str_query = "select * from  tblapi order by api_name";
		$result = $this->db->query($str_query);
		return $result;
	}
	public function get_api_limited($start_row,$per_page)
	{
		$str_query = "select * from  tblapi order by api_name limit $start_row,$per_page";
		$result = $this->db->query($str_query);
		return $result;
	}	
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function GetAPIInfo($company_id)
	{		
	$str_query = "select * from tblapi where tblapi.api_id = (select api_id from tblcompany where tblcompany.company_id = '$company_id')";
	$result = $this->db->query($str_query);		
	return $result;	
	}
	public function GetAPIInfoByAPIName($api_name)
	{		
	$str_query = "select * from tblapi where api_name = '$api_name'";
	$result = $this->db->query($str_query);		
	return $result;	
	}
	
	public function getsmsapi()
	{
		$rslt = $this->db->query("select * from common where param = 'smsapi'");
		return $rslt->row(0)->value;
	}
	
	public function getApiListForDropdownList()
	{
	    $ddloptions = '';
	    $rsltpai = $this->db->query("select a.Id,a.api_name from api_configuration a where a.is_active = 'yes' and a.enable_recharge = 'yes' order by a.api_name");
	    foreach($rsltpai->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->Id.'">'.$rw->api_name.'</option>';
	    }
	    return $ddloptions;
	}
	public function getApiListForDropdownList_notrouterapi()
	{
	    $ddloptions = '';
	    $rsltpai = $this->db->query("select a.Id,a.api_name from api_configuration a where a.is_active = 'yes' and a.enable_recharge = 'yes' and is_random = 'no' order by a.api_name");
	    foreach($rsltpai->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->Id.'">'.$rw->api_name.'</option>';
	    }
	    return $ddloptions;
	}
}

?>