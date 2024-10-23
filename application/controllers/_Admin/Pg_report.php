<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pg_report extends CI_Controller {
	
	  
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
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
		
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
		   
			if($this->input->post('btnSearch') == "Search")
			{
				
				$from = $this->input->post("txtFrom",TRUE);
				$to = $this->input->post("txtTo",TRUE);
				$ddlstatus = $this->input->post("ddlstatus",TRUE);
				$ddloperator = $this->input->post("ddloperator",TRUE);
				$txtRemitter = $this->input->post("txtRemitter",TRUE);
				$txtcustomer_params = $this->input->post("txtcustomer_params",TRUE);
				$txtAmount = $this->input->post("txtAmount",TRUE);
				$ddldb = $this->input->post("ddldb",TRUE);
				
				$this->view_data['pagination'] = NULL;
				
				
				    if($ddlstatus == "PENDING")
    				{
					
    				   $this->view_data['result_all'] = $this->db->query("SELECT 
                           SELECT a.Id, a.user_id, a.razorpay_payment_id, a.order_id, a.txnid, a.amount, a.credit_amount, a.charges, a.gst, a.status, a.method, a.card_type, a.card_last4, a.card_name, a.card_network, a.vpa, a.bank, a.wallet, a.email, a.phone, a.payment_from, a.add_date, a.ipaddress,
                         p.businessname as dist_businessname,
                        p.username as dist_username,
                        p.mobile_no as dist_mobile_no
                        FROM tbl_razorpay a
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers p on b.parentid = p.user_id
						where  Date(a.add_date) >= ? and Date(a.add_date) <= ? and
     					if( ? != 'ALL',a.status = ?,true) and
                        if(? != '',a.phone = ?, true)  and
                        if( ? != 'ALL',a.method = ?,true) and
                        if(? != '',a.order_id = ?, true)  and
                        if(? != '',a.amount = ?, true)

                       
     					
    					
     					order by Id desc",array($from,$to,$ddlstatus,$ddlstatus,$txtRemitter,$txtRemitter,$ddloperator,$ddloperator,$txtcustomer_params,$txtcustomer_params,$txtAmount,$txtAmount));
    				}
    				else
    				{
					
    				     $this->view_data['result_all'] = $this->db->query("  SELECT a.Id, a.user_id, a.razorpay_payment_id, a.order_id, a.txnid, a.amount, a.credit_amount, a.charges, a.gst, a.status, a.method, a.card_type, a.card_last4, a.card_name, a.card_network, a.vpa, a.bank, a.wallet, a.email, a.phone, a.payment_from, a.add_date, a.ipaddress,b.businessname,b.username, b.mobile_no,
                         p.businessname as dist_businessname,
                        p.username as dist_username,
                        p.mobile_no as dist_mobile_no
                        FROM tbl_razorpay a
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers p on b.parentid = p.user_id
 						where  Date(a.add_date) >= ? and Date(a.add_date) <= ? and
     					if( ? != 'ALL',a.status = ?,true) and
                        if(? != '',a.phone = ?, true)  and
                        if( ? != 'ALL',a.method = ?,true) and
                        if(? != '',a.order_id = ?, true)  and
                        if(? != '',a.amount = ?, true)


     					
                       
     					order by Id desc limit 50",array($from,$to,$ddlstatus,$ddlstatus,$txtRemitter,$txtRemitter,$ddloperator,$ddloperator,$txtcustomer_params,$txtcustomer_params,$txtAmount,$txtAmount));    
     				
    				}	
				$this->view_data['message'] =$this->msg;
				
				$this->view_data['from'] =$from;
				$this->view_data['to'] =$to;
                $this->view_data['ddlstatus'] =$ddlstatus;
                $this->view_data['txtRemitter'] =$txtRemitter;
                $this->view_data['ddloperator'] =$ddloperator;
                $this->view_data['txtcustomer_params'] =$txtcustomer_params;
                $this->view_data['txtAmount'] =$txtAmount;
                $this->view_data['ddldb'] =$ddldb;

				
				$this->view_data["summary_array"] = $this->getTotalPGValues($from,$to,$ddlstatus,$ddloperator,$txtRemitter,$txtcustomer_params,$txtAmount);
				$this->load->view('_Admin/Pg_report_view',$this->view_data);	
			}
			else if(isset($_POST["hidId"]) and isset($_POST["hidstatus"]) and isset($_POST["hidaction"]))
			{
			  

//				print_r($this->input->post());exit;

				error_reporting(-1);
				ini_set('display_errors',1);
				$this->db->db_debug = TRUE;	
				$hidId  = trim($_POST["hidId"]);
				$hidstatus  = trim($_POST["hidstatus"]);
				$hidaction  = trim($_POST["hidaction"]);
				$OpId = trim($_POST["hidstsupdopid"]);
				if($hidaction == "STATUSUPDATE")
				{
					$rslttxncheck = $this->db->query("
					 SELECT a.Id, a.user_id, a.razorpay_payment_id, a.order_id, a.txnid, a.amount, a.credit_amount, a.charges, a.gst, a.status, a.method, a.card_type, a.card_last4, a.card_name, a.card_network, a.vpa, a.bank, a.wallet, a.email, a.phone, a.payment_from, a.add_date, a.ipaddress,b.businessname,b.username, b.mobile_no,
					 p.businessname as dist_businessname,
                        p.username as dist_username,
                        p.mobile_no as dist_mobile_no
                        FROM tbl_razorpay a
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers p on b.parentid = p.user_id
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers p on b.parentid = p.user_id
 						where  a.Id = ? order by Id desc",array($hidId));
   
				
					if($rslttxncheck->num_rows() == 1)
					{
					   
						
						$Status = $rslttxncheck->row(0)->cb_status;
						$API = $rslttxncheck->row(0)->outlet_mobile;
						$dmr_id = $rslttxncheck->row(0)->Id;
						$user_id = $rslttxncheck->row(0)->customer_params;
						$Amount = $rslttxncheck->row(0)->amount;
						$Charge_Amount = $rslttxncheck->row(0)->response_msg;
						$ccf = $rslttxncheck->row(0)->request_id;
						//echo $Status;exit;
						if($Status == strtoupper($hidstatus))
						{
							redirect(base_url()."_Admin/Pg_report?crypt=".$this->Common_methods->encrypt("MyData"));
						}
					
						else if(($Status == "PENDING" or $Status == "SUCCESS") and $hidstatus == "FAILED")
						{
							
							
                            
		
							redirect(base_url()."_Admin/Pg_report?crypt=".$this->Common_methods->encrypt("MyData"));
						}
						else if(($Status == "PENDING" or  $Status == "HOLD" or  $Status == "") and $hidstatus == "Success")
						{
							$this->db->query("update aeps_transactions2 set cb_status = 'SUCCESS' where Id = ?",array($Id));


							redirect(base_url()."_Admin/Pg_report?crypt=".$this->Common_methods->encrypt("MyData"));
						}
						
					
					}
				
				}
			}	
			
				
				
			
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$date = $this->common->getMySqlDate();
					$ddldb = "LIVE";
					$this->view_data['pagination'] = NULL;
					
					
					$this->view_data['result_all'] = $this->db->query(" SELECT a.Id, a.user_id, a.razorpay_payment_id, a.order_id, a.txnid, a.amount, a.credit_amount, a.charges, a.gst, a.status, a.method, a.card_type, a.card_last4, a.card_name, a.card_network, a.vpa, a.bank, a.wallet, a.email, a.phone, a.payment_from, a.add_date, a.ipaddress,b.businessname,b.username, b.mobile_no,
					 p.businessname as dist_businessname,
                        p.username as dist_username,
                        p.mobile_no as dist_mobile_no
                        FROM tbl_razorpay a
                
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers p on b.parentid = p.user_id
 						where Date(a.add_date) >= ? and Date(a.add_date) <= ? order by Id desc limit 50",array($date,$date));
					$this->view_data['message'] =$this->msg;
				
				$this->view_data['from'] =$date;
				$this->view_data['to'] =$date;
				$this->view_data['ddlstatus'] =="ALL";
				$this->view_data['ddloperator'] ="ALL";
				$this->view_data['txtRemitter'] ="";
				$this->view_data['txtcustomer_params'] ="";
				$this->view_data['txtAmount'] = "";
				$this->view_data['ddldb'] ="LIVE";
				$this->view_data["summary_array"] = $this->getTotalPGValues($from,$to,$ddlstatus,$ddloperator,$txtRemitter,$txtcustomer_params,$txtAmount);
				$this->load->view('_Admin/Pg_report_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function getTotalPGValues($from,$to,$ddlstatus="",$ddloperator="",$txtRemitter="",$txtcustomer_params="",$txtAmount="")
	{
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		
		$total_ccf = 0;
		$total_cashback = 0;
		$total_tds = 0;
		
		
		$total_hold = 0;
		
		
		$total_success_count = 0;
		$total_failure_count = 0;
		$total_pending_count = 0;
		$total_hold_count = 0;

		//$Remitter,$AccNo,$status,$UserId
		

		$rslt = $this->db->query("
		select 
		IFNULL(Sum(a.payment_amount),0) as total,
		a.payment_status 
		from cashfree_callbackdata  a
		left join tblusers b on a.user_id = b.user_id
		where 
		Date(a.add_date) BETWEEN ? and ? and 
		if( ? != 'ALL',a.payment_status = ?,true) and
     	if( ? != 'ALL',a.payment_group = ?,true) and
     	if(? != '',a.customer_phone = ?, true) and
     	if(? != '',a.cf_payment_id = ?, true) and  
     	if(? != '',a.payment_amount = ?, true)
		group by a.payment_status",array($from,$to,$ddlstatus,$ddlstatus,$ddloperator,$ddloperator,$txtRemitter,$txtRemitter,$txtcustomer_params,$txtcustomer_params,$txtAmount,$txtAmount));
                         
                        
             
		foreach($rslt->result() as $rw)
		{
			//echo  $rw->Status."  ".$rw->total;exit;
			if($rw->payment_status == "SUCCESS")
			{
				$total_success += $rw->total;
				
			}
			else if($rw->payment_status == "FAILED")
			{
				$total_failure += $rw->total;
				
			}
			
		
		}
		//echo $total_success;exit;
		$arr = array(
				"Success"=>$total_success,
				"Failure"=>$total_failure,
				"Pending"=>$total_pending,
				
			);
		return $arr;
	}
	

	

	public function dataexport()
	{
	   
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "session expired"; exit;
		}
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
			$db = trim($_GET["db"]);
			$data = array();
			
			
			
			    $rslt = $this->db->query("SELECT 
                            a.Id,a.add_date,a.ipaddress,a.user_id,a.event_time,a.webhook_type,a.order_id,a.order_amount,a.order_currency,a.order_tags,a.cf_payment_id,a.payment_status,a.payment_amount,a.payment_currency,a.payment_message,a.payment_time,a.bank_reference,a.auth_id,a.payment_method,a.payment_group,a.card_number,a.card_network,a.card_type,a.card_country,a.card_bank_name,a.customer_name,a.customer_id,a.customer_email,a.customer_phone,b.businessname,b.mobile_no,
                         p.businessname as dist_businessname,
                        p.username as dist_username,
                        p.mobile_no as dist_mobile_no
                        FROM cashfree_callbackdata a
                        left join tblusers b on a.user_id = b.user_id
                        left join tblusers p on b.parentid = p.user_id
 where Date(a.add_date) >= ? and Date(a.add_date) <= ? 
 
 order by Id desc",array($from,$to));
			
			
			
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									
  "add_date"=>$rw->add_date,
  "ipaddress"=>$rw->ipaddress,
  "user_id"=>$rw->user_id,
  "event_time"=>$rw->event_time,
  "webhook_type"=>$rw->webhook_type,
  "order_id"=>$rw->order_id,
  "order_amount"=>$rw->order_amount,
  "order_currency"=>$rw->order_currency,
  "order_tags"=>$rw->order_tags,
  "cf_payment_id"=>$rw->cf_payment_id,
  "payment_status"=>$rw->payment_status,
  "payment_amount"=>$rw->payment_amount,
  "payment_currency"=>$rw->payment_currency,
  "payment_message"=>$rw->payment_message,
  "payment_time"=>$rw->payment_time,
  "bank_reference"=>$rw->bank_reference,
  "auth_id"=>$rw->auth_id,
  "payment_method"=>$rw->payment_method,
  "payment_group"=>$rw->payment_group,
  "card_number"=>$rw->card_number,
  "card_network"=>$rw->card_network,
  "card_type"=>$rw->card_type,
  "card_country"=>$rw->card_country,
  "card_bank_name"=>$rw->card_bank_name,
  "customer_name"=>$rw->customer_name,
  "customer_id"=>$rw->customer_id,
  "customer_email"=>$rw->customer_email,
  "customer_phone"=>$rw->customer_phone,
  "businessname"=>$rw->businessname,
  "mobile_no"=>$rw->mobile_no,

								);
					
					
					
					array_push( $data,$temparray);
					$i++;
	}
	function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
    
    // file name for download
    $fileName = "PG REPORT From ".$from." To  ".$to.".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");
    
    $flag = false;
    foreach($data as $row) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        // filter data
        array_walk($row, 'filterData');
        echo implode("\t", array_values($row)) . "\n";
    }
    
    exit;				
		}
		else
		{
			echo "parameter missing";exit;
		}
	}
}