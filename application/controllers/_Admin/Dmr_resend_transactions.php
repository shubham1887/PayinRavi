<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_resend_transactions extends CI_Controller {
	
	  
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
				$txtRemitter = $this->input->post("txtRemitter",TRUE);
				$txtAccNo = $this->input->post("txtAccNo",TRUE);
				$txtUserId = $this->input->post("txtUserId",TRUE);
				$ddlapi = $this->input->post("ddlapi",TRUE);
				$ddldb = $this->input->post("ddldb",TRUE);
				
				$this->view_data['pagination'] = NULL;
				
				
				
    				    $this->view_data['result_all'] = $this->db->query("SELECT bank.bank_name,a.unique_id,
    				    a.retry,a.API,a.Id,a.order_id,a.add_date,a.edit_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
    				    a.ccf,a.cashback,a.tds,
    a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
    a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,
    a.RESP_statuscode,a.RESP_opr_id,a.RESP_status,a.RESP_name,
    b.businessname,b.mobile_no
    
    
    FROM `dmt_resend_duplicate` z
	left join mt3_transfer a on a.Id = z.dmr_id
    left join tblusers b on a.user_id = b.user_id
    left join dezire_banklist bank on a.bank_id = bank.Id
   
     where Date(a.add_date) >= ? and Date(a.add_date) <= ? and
     if( ? != 'ALL',a.Status = ?,true) and
     if(? != '',a.RemiterMobile = ?, true) and 
     if(? != '',a.AccountNumber = ?, true) and 
     
     if( ? != 'ALL',a.API = ?,true)
     
     order by Id desc limit 50",array($from,$to,$ddlstatus,$ddlstatus,$txtRemitter,$txtRemitter,$txtAccNo,$txtAccNo,$ddlapi,$ddlapi));    
    				
				
				
				
				
					
				$this->view_data['message'] =$this->msg;
				
				$this->view_data['from'] =$from;
				$this->view_data['to'] =$to;
				$this->view_data['txtRemitter'] =$txtRemitter;
				$this->view_data['txtAccNo'] =$txtAccNo;
				$this->view_data['ddlstatus'] =$ddlstatus;
				$this->view_data['txtUserId'] =$txtUserId;
				$this->view_data['ddlapi'] =$ddlapi;
				$this->view_data['ddldb'] =$ddldb;
				$this->view_data["summary_array"] = $this->getTotalDMRValues($from,$to,$ddlapi);
				$this->load->view('_Admin/dmr_resend_transactions_view',$this->view_data);		
			}	
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$date = $this->common->getMySqlDate();
					$ddldb = "LIVE";
					$this->view_data['pagination'] = NULL;
					
					
					$this->view_data['result_all'] = $this->db->query("SELECT bank.bank_name,a.unique_id,a.retry,a.API,a.Id,a.order_id,a.add_date,a.edit_date,
					a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,a.ccf,a.cashback,a.tds,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited,a.balance,a.mode,
a.RESP_statuscode,a.RESP_opr_id,a.RESP_status,a.RESP_name,
b.businessname,b.mobile_no


FROM `dmt_resend_duplicate` z
left join mt3_transfer a on a.Id = z.dmr_id
left join tblusers b on a.user_id = b.user_id
left join dezire_banklist bank on a.bank_id = bank.Id
 where Date(a.add_date) >= ? and Date(a.add_date) <= ? order by Id desc limit 50",array($date,$date));
					
					$this->view_data['message'] =$this->msg;
					$this->view_data['ddlstatus'] ="ALL";
					$this->view_data['from'] =$date;
					$this->view_data['to'] =$date;
					$this->view_data['ddldb'] ="LIVE";
					$this->view_data['txtRemitter'] ="";
					$this->view_data['txtAccNo'] ="";
					$this->view_data['txtUserId'] ="";
					$this->view_data['ddlapi'] ="ALL";
					$this->view_data["summary_array"] = $this->getTotalDMRValues($date,$date,"ALL");
					$this->load->view('_Admin/dmr_resend_transactions_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function getTotalDMRValues($from,$to,$ddlapi)
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
		
		
		$rslt = $this->db->query("
		select 
		IFNULL(Sum(Amount),0) as total,
		IFNULL(Sum(ccf),0) as total_ccf,
		IFNULL(Sum(cashback),0) as total_cashback,
		IFNULL(Sum(tds),0) as total_tds,
		count(Id) as totalcount,
		Status 
		from mt3_transfer 
		where 
		Date(add_date) >= ? and 
		Date(add_date) <= ? and
		if(? != 'ALL',API =?,true) 
		group by Status",array($from,$to,$ddlapi,$ddlapi));
		
		foreach($rslt->result() as $rw)
		{
			//echo  $rw->Status."  ".$rw->total;exit;
			if($rw->Status == "SUCCESS")
			{
				$total_success += $rw->total;
				$total_success_count += $rw->totalcount;
				$total_ccf += $rw->total_ccf;
				$total_cashback += $rw->total_cashback;
				$total_tds += $rw->total_tds;
			}
			else if($rw->Status == "FAILURE")
			{
				$total_failure += $rw->total;
				$total_failure_count += $rw->totalcount;
			}
			else if($rw->Status == "PENDING")
			{
				$total_pending += $rw->total;
				$total_pending_count += $rw->totalcount;
			}
			else if($rw->Status  == "HOLD")
			{
				$total_hold += $rw->total;
				$total_hold_count += $rw->totalcount;
			}
		}
		//echo $total_success;exit;
		$arr = array(
				"Success"=>$total_success,
				"Failure"=>$total_failure,
				"Pending"=>$total_pending,
				"hold"=>$total_hold,
				"Success_Count"=>$total_success_count,
				"Failure_Count"=>$total_failure_count,
				"Pending_Count"=>$total_pending_count,
				"hold_Count"=>$total_hold_count,
				
				"total_ccf"=>$total_ccf,
				"total_cashback"=>$total_cashback,
				"total_tds"=>$total_tds,
			);
		return $arr;
	}
	public function setvalues()
	{
		if(isset($_GET["field"]) and isset($_GET["val"]))
		{
			$field = trim($_GET["field"]);
			$val = trim($_GET["val"]);
			if($field == "HOLD")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set hold_neft = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			if($field == "Status")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set status = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			if($field == "RangeStatus")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set range_status = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			if($field == "RANGE")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set range_values = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			if($field == "Reroot")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set reroot = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			
			if($field == "RerootApi")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set reroot_api = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			if($field == "NEFT")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set neft = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			if($field == "IMPS")
			{
				$api_id = trim($_GET["api_id"]);
				$this->db->query("update tblapi set imps = ? where Id = ?",array($val,$api_id));
				echo "OK";
			}
			
		}
	}
	public function getStatus()
	{
		if(isset($_POST["Id"]))
		{
			$Id = trim($_POST["Id"]);

			$rsltchec = $this->db->query("SELECT * FROM `mt3_transfer` where Id = ? ORDER BY `mt3_transfer`.`Id` ASC",array($Id));
			if($rsltchec->num_rows() == 1 )
			{
				$status = $rsltchec->row(0)->Status;
				
				if($status == "PENDING")
				{
					$ipayid = $rsltchec->row(0)->RESP_ipay_id;
					$user_id = $rsltchec->row(0)->user_id;
					$userinfo  = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
					$this->load->model("Instapay");
					$resp = $this->Instapay->transfer_status($Id,$ipayid,$userinfo);
					print_r($resp);exit;
				}
			}
		}
	}
	public function gethoursbetweentwodates($fromdate,$todate)
	{
		 $now_date = strtotime (date ($todate)); // the current date 
		$key_date = strtotime (date ($fromdate));
		$diff = $now_date - $key_date;
		return round(abs($diff) / 60,2);
	}
	public function checkstatus()
	{
	    //error_reporting(-1);
	    //ini_set('display_errors',1);
	    //$this->db->db_debug = TRUE;
		if(isset($_GET["id"]))
		{
			$Id = $_GET["id"];
			$result= $this->db->query("SELECT a.Id,a.order_id,a.add_date,a.edit_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.balance,a.mode,
a.RESP_statuscode,a.RESP_opr_id,a.RESP_status,a.RESP_name,a.API


FROM `mt3_transfer` a where a.Id = ? order by Id desc",array($Id));
			if($result->num_rows() == 1)
			{
			  
			    $recdt = $result->row(0)->add_date;
        		$recdatetime =date_format(date_create($recdt),'Y-m-d h:i:s');
        		$cdate =date_format(date_create($this->common->getDate()),'Y-m-d h:i:s');
        	
        		$diff = $this->gethoursbetweentwodates($recdatetime,$cdate);
        		if($diff < 3)
        		{
        		    $resparray = array(
        		        "message"=>"Click After 3 Minutes",
        		        "status"=>1
        		        );
        			echo json_encode($resparray);exit;
        		}
        		else
        		{
        			
        		    if($result->row(0)->API == "AIRTEL")
        		    {
        		        $this->load->model("Airtel_model");
				        echo $this->Airtel_model->transfer_status($Id);exit;        
        		    }
        		    if($result->row(0)->API == "BANKIT")
        		    {
        		       // echo "asdfsadf";exit;
        		        $this->load->model("Bankit");
				        echo $this->Bankit->transfer_status($Id);exit;        
        		    }
        		    
        		}
				
			}
			else
			{
			   
			    $result= $this->db->query("SELECT a.retry,a.Id,a.order_id,a.add_date,a.edit_date,a.user_id,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, ,a.balance,a.mode,
a.RESP_statuscode,a.RESP_opr_id,a.RESP_status,a.RESP_name,a.row_lock,a.API


FROM jantrech_archive.mt3_transfer a where a.Id = ? order by Id desc",array($Id));
		
			if($result->num_rows() == 1)
			{
			   
			    //echo $result->row(0)->RESP_ipay_id;exit;
			    $recdt = $result->row(0)->add_date;
        		$recdatetime =date_format(date_create($recdt),'Y-m-d h:i:s');
        		$cdate =date_format(date_create($this->common->getDate()),'Y-m-d h:i:s');
        		$diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
        		if($diff < 3)
        		{
        		    $resparray = array(
        		        "message"=>"Click After 3 Minutes",
        		        "status"=>1
        		        );
        			echo json_encode($resparray);exit;
        		}
        		else
        		{
        		    if($result->row(0)->API == "EKO")
        		    {
        		        $this->load->model("Eko");
				        echo $this->Eko->transfer_status($Id);exit;        
        		    }
        		    if($result->row(0)->API == "SHOOTCASE")
        		    {
        		        echo "asdfsadf";exit;
        		        $this->load->model("Shootcase");
				        echo $this->Shootcase->transfer_status($Id);exit;        
        		    }
        		    
        		}
				
			}
			}
			
			
		}
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
			
			if($db == "ARCHIVE")
			{
			    $rslt = $this->db->query("SELECT 
			a.API,
			a.retry,
			a.Id,
			a.add_date,a.edit_date,
			a.ipaddress,
			a.user_id,
			a.Charge_type,
			a.charge_value,
			a.Charge_Amount,
			a.RemiterMobile,
			a.debit_amount,
			a.credit_amount,
			a.BeneficiaryId,
			a.AccountNumber,
			a.IFSC,
			a.Amount,
			a.Status,
			a.debited, 
			a.balance,
			
			a.mode,
			a.RESP_statuscode,
			a.RESP_status,
			a.RESP_ipay_id,
			a.RESP_opr_id,a.RESP_status,
			a.RESP_name,
			
			b.businessname,
			b.username,
			b.mobile_no
		


FROM jantrech_archive.mt3_transfer a
left join tblusers b on a.user_id = b.user_id

 where Date(a.add_date) >= ? and Date(a.add_date) <= ? 
 
 order by Id desc",array($from,$to));
			}
			else
			{
			    $rslt = $this->db->query("SELECT 
			a.API,
			a.retry,
			a.Id,
			a.add_date,a.edit_date,
			a.ipaddress,
			a.user_id,
			a.Charge_type,
			a.charge_value,
			a.Charge_Amount,
			a.RemiterMobile,
			a.debit_amount,
			a.credit_amount,
			
			a.BeneficiaryId,
			a.AccountNumber,
			a.IFSC,
			a.Amount,
			a.Status,
			a.debited, 
			a.balance,
			
			a.mode,
			a.RESP_statuscode,
			a.RESP_status,
			a.RESP_ipay_id,
			a.RESP_opr_id,
			a.RESP_status,
			a.RESP_name,
			
			b.businessname,
			b.username,
			b.mobile_no,
		    
		    p.businessname as dist_businessname,
			p.username as dist_username,
			p.mobile_no as dist_mobile_no


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers p on b.parentid = p.user_id


 where Date(a.add_date) >= ? and Date(a.add_date) <= ? 
 
 order by Id desc",array($from,$to));
			}
			
			
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"API" => $rw->API, 
								
									"Id" => $rw->Id, 
									"add_date" =>$rw->add_date, 
									
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"AgentMobileNo" =>$rw->mobile_no, 
									"Distributor Name" =>$rw->dist_businessname, 
									"Distributor Mobile" =>$rw->dist_mobile_no, 
									
				
									"RESP_name" =>$rw->RESP_name, 
									"AccountNumber" =>$rw->AccountNumber, 
									"IFSC" =>$rw->IFSC, 
									"mode" =>$rw->mode, 
									"Amount" =>$rw->Amount, 
									"Status" =>$rw->Status, 
									"Charge_Amount" =>$rw->Charge_Amount, 
									"RemiterMobile" =>$rw->RemiterMobile, 
									"debit_amount" =>$rw->debit_amount, 
									"credit_amount" =>$rw->credit_amount, 
									
									
									"RESP_statuscode" =>$rw->RESP_statuscode, 
									"RESP_status" =>$rw->RESP_status, 
									"RESP_ipay_id" =>$rw->RESP_ipay_id, 
									
									"RESP_opr_id" =>$rw->RESP_opr_id, 
									
									
									"ipaddress" =>$rw->ipaddress, 
									
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
    $fileName = "DMR REPORT From ".$from." To  ".$to.".xls";
    
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