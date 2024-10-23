<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class retry_processor extends CI_Controller {
	
	
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
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;
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
    				 a.status
    				 FROM `tblpendingrechares` a 
    				 left join tblrecharge r on a.recharge_id = r.recharge_id
    				where 
    				(a.status = 'Pending' or a.status = 'InProcess') and 
    				r.retry = 'yes'
            order by a.recharge_id limit 10");

                foreach($rslt->result() as $rw)
                {
                    
                     $resp.=$rw->api_id."  ".$rw->mobile_no."  ,";   
                     $company_id = $rw->company_id;
                     $Mobile = $rw->mobile_no;
                     $Amount = $rw->amount;
                     $recharge_id = $rw->recharge_id;
					
					$rslt_reroot_values = $this->db->query("SELECT 
				                                recharge_id, 
				                                allowed_retry, 
				                                retry_count, 
				                                last_retry_priority, 
				                                last_retry_api, 
				                                recharge_api, 
				                                retry_api_1, 
				                                retry_api_2,
				                                retry_api_3 ,
				                                api_1_status,
    			                                api_2_status,
    			                                api_3_status,
    			                                current_retry_api
				                                FROM reroot_count 
				                                WHERE recharge_id = ?  and api_1_status = 'open' and retry_api_1 > 0",array($recharge_id));
				        if($rslt_reroot_values->num_rows() == 1)
				        {
				            $retry_api_1 = $rslt_reroot_values->row(0)->retry_api_1;   
				            $apiinfo = $this->db->query("select * from api_configuration where Id = ?",array($retry_api_1));
				            if($apiinfo->num_rows() == 1)
				            {
				                if($this->checkduplicate($recharge_id,$retry_api_1))
				                //if(true)
				                {
				                    $this->db->query("update reroot_count set retry_count = retry_count + 1,api_1_status = 'done',last_retry_api = ? where recharge_id = ?",array($retry_api_1,$recharge_id)); 
				                   // $this->db->query("update tblpendingrechares set api_id = ?,ishold = 'no' where recharge_id = ?",array($retry_api_1,$recharge_id));    
				                   
				                  
				                    $this->load->model("Reroot_model");
				                    $this->Reroot_model->doReroot($recharge_id,$retry_api_1,1,true);    
				                }
				                
				            }
				            
				        }
            	}
                
                echo $resp;exit;
            
            
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