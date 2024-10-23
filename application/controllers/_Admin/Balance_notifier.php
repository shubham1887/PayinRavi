<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Balance_notifier extends CI_Controller {
	
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->common->getRealIpAddr() != "148.72.23.46") 
		{ 
			//echo "";exit;
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
private function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	private function getAllBalance($api_name)
	{
	        $total_balance = 0.00;
    		$apirslt = $this->db->query("select a.api_id,a.api_name,a.minbalance_limit,b.balance_url,b.is_message,b.balancebefore_text,b.balance_after_text from tblapi a  join r_api_getbalance_settings b on a.api_id = b.api_id where a.api_name = ?",array($api_name));
    		if($apirslt->num_rows()  == 1)
    		{ 
    		    $minbalance_limit = $apirslt->row(0)->minbalance_limit;
    		    $api_id = $apirslt->row(0)->api_id;
				$balance_url = $apirslt->row(0)->balance_url;
    			$is_message = $apirslt->row(0)->is_message;
    			$balancebefore_text = $apirslt->row(0)->balancebefore_text;
    			$balance_after_text = $apirslt->row(0)->balance_after_text;
    			if($balancebefore_text != "")
    			{
    				$balance = $this->get_string_between($this->common->callurl($balance_url),$balancebefore_text,$balance_after_text);
    				
    			}
    			else
    			{
    				$balance = $this->common->callurl($balance_url);
    				
    			}
    			
    			
    			if($balance < $minbalance_limit and $minbalance_limit > 0)
    			{
    			    $rsltchecknotified = $this->db->query("select * from notify_balance_flag where api_id = ?",array($api_id));
    			    if($rsltchecknotified->num_rows() == 1)
    			    {
    			        if($rsltchecknotified->row(0)->is_notified == 'no')
    			        {
    			            //do code for notify admin
    			            $this->db->query("update notify_balance_flag set is_notified = 'yes' where api_id = ?",array($api_id));
    			            $msg = 'Low Balance : '.$api_name.' : Balance '.$balance;
    			            $this->load->model("Notification");
    			            $this->Notification->send_wanotification("Admin",$msg);
    			            echo $msg."<br>";
    			        }
    			    }
    			    else
    			    {
    			        $this->db->query("insert into notify_balance_flag(api_id,is_notified,last_notify_datetime,ipaddress) values(?,?,?,?)",array($api_id,'yes',$this->common->getDate(),$this->common->getRealIpAddr()));
    			        //do code for notify admin
    			        $msg = 'Low Balance : '.$api_name.' : Balance '.$balance;
    			        $this->load->model("Notification");
    			       $this->Notification->send_wanotification("Admin",$msg);
    			       echo $msg."<br>";
    			    }
    			}
    			else if($balance > $minbalance_limit and $minbalance_limit > 0)
    			{
    			    $rsltchecknotified = $this->db->query("select * from notify_balance_flag where api_id = ?",array($api_id));
    			    if($rsltchecknotified->num_rows() == 1)
    			    {
    			        if($rsltchecknotified->row(0)->is_notified == 'yes')
    			        {
    			           $this->db->query("update notify_balance_flag set is_notified = 'no' where api_id = ?",array($api_id));
    			        }
    			    }
    			    else
    			    {
    			        $this->db->query("insert into notify_balance_flag(api_id,is_notified,last_notify_datetime,ipaddress) values(?,?,?,?)",array($api_id,'no',$this->common->getDate(),$this->common->etRealIpAddr()));
    			    }
    			}
    		}
	    
		
	}
	

	public function index() 
	{
	    
		$api_info = $this->db->query("select api_name from tblapi where minbalance_limit > 0");
		foreach($api_info->result() as $api)
		{
		    $this->getAllBalance($api->api_name);
		}
	}	
}