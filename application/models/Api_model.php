<?php
class Api_model extends CI_Model 
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
    public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
    public function getBalance($api_id)
    { 
        $ApiInfo = $this->db->query("select a.* from api_configuration a   where a.Id = ? and a.enable_balance_check = 'yes'",array($api_id));
    	if($ApiInfo->num_rows()  == 1)
		{
		    //print_r($ApiInfo->result());exit;
		    $apiinfo = $ApiInfo;
            $api_id = $apiinfo->row(0)->Id;
	        $api_name = $apiinfo->row(0)->api_name;

	        if($api_name == "PAYTM")
	        {
	        	$this->load->model("Paytm");
	        	return $this->Paytm->getBalance();
	        }
	        else if($api_name == "AIRTEL")
	        {
	        	$this->load->model("Airtel_model");
	        	return $this->Airtel_model->getBalance();
	        }
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
	        $balance_check_start_word = $apiinfo->row(0)->balance_check_start_word;
	        $balance_check_end_word = $apiinfo->row(0)->balance_check_end_word;
	        
	        
	        
	        
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
    	         
    	           
    	            
    	            
    	          
    	            $response = $this->common->callurl_timeout(trim($url),0);  
    	        
    	           
    	        }
    	        if($balance_check_api_method == "POST")
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
    	         
    	          
    	            
    	            //echo $url;exit;
    	            
    	            $postdata = explode("?",$url)[1];
    	            $url = explode("?",$url)[0];
    	            //echo $url."  >> ".$postdata;exit;
    	            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
    	            //echo $response;exit;
    	        }
    	       //echo $balnace_check_response_type;exit;
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
                    if(isset($obj[$balnace_check_response_balfieldName]))
                    {
                    	$balance = $obj[$balnace_check_response_balfieldName];
                    	return $balance;	
                    }
                    return "";
                }
                else if($balnace_check_response_type == "CSV")
                {
                    $saprater = substr($balnace_check_response_balfieldName,0,1);
                    $balnace_check_response_balfieldName = substr($balnace_check_response_balfieldName,1);
                    
                    $obj = explode($saprater,$response);
                    $balance = $obj[$balnace_check_response_balfieldName];
                    return $balance;
                }
                else if($balnace_check_response_type == "PARSER")
                {
                    $balance = $this->get_string_between($response,$balance_check_start_word,$balance_check_end_word);

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


	
	public function smslog($data)
	{
		$filename = "inlogs/smslog.txt";
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
	public function getApiListForDropdownList_whereapi_id_not_equelto($api_id,$api_id2 = false,$api_id3 = false)
	{
	    $ddloptions = '';
	    $rsltpai = $this->db->query("
	        select 
	            a.Id,a.api_name 
	            from api_configuration a 
	            where 
	            a.is_active = 'yes' and a.enable_recharge = 'yes' 
	            and a.Id != ?  and
	            if(? != false,a.Id != ?,true) and
	            if(? != false,a.Id != ?,true) 
	            order by a.api_name",array($api_id,$api_id2,$api_id2,$api_id3,$api_id3));
	    foreach($rsltpai->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->Id.'">'.$rw->api_name.'</option>';
	    }
	    return $ddloptions;
	}
	
	public function getApiListForRechargeDropdownList_whereapi_id_not_equelto($api_id,$api_id2 = false,$api_id3 = false)
	{
	    $ddloptions = '';
	    $rsltpai = $this->db->query("
	        select 
	            a.Id,a.api_name 
	            from api_configuration a 
	            where 
	            a.is_active = 'yes' and a.enable_recharge = 'yes' 
	            and a.Id != ?  and
	            if(? != false,a.Id != ?,true) and
	            if(? != false,a.Id != ?,true) 
	            order by a.api_name",array($api_id,$api_id2,$api_id2,$api_id3,$api_id3));
	    foreach($rsltpai->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->api_name.'">'.$rw->api_name.'</option>';
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