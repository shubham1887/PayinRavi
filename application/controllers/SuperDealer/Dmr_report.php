<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_report extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
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

		if($this->session->userdata('SdUserType') != "SuperDealer") 
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
			    $user_id = $this->session->userdata("SdId");
				echo $user_id;exit;
				$this->view_data['pagination'] = NULL;
				
				    
    				    $this->view_data['result_all'] = $this->db->query("SELECT a.retry,a.done_by,a.API,a.unique_id,a.Id,a.add_date,a.edit_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
    a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
    a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
    a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
    b.businessname,b.username
    
    
    FROM `mt3_transfer` a
    left join tblusers b on a.user_id = b.user_id
    left join tblusers parent on b.parentid = parent.user_id
     where 
     b.host_id = ? and 
     Date(a.add_date) >= ? and Date(a.add_date) <= ? and
     if( ? != 'ALL',a.Status = ?,true) and
     if(? != '',a.RemiterMobile = ?, true) 
     
    
     
     order by Id desc limit 50",array($from,$to,$ddlstatus,$ddlstatus,$txtRemitter,$txtRemitter,$user_id));    
    				
				
				
				
				
					
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
				$this->load->view('SuperDealer/dmr_report_view',$this->view_data);		
			}	
			else
			{
				
					$date = $this->common->getMySqlDate();
					$ddldb = "LIVE";
					$this->view_data['pagination'] = NULL;
					
					$user_id = $this->session->userdata("SdId");
					$this->view_data['result_all'] = $this->db->query("SELECT a.retry,a.done_by,a.API,a.unique_id,a.Id,a.add_date,a.edit_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.username


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
 where Date(a.add_date) >= ? and Date(a.add_date) <= ? and b.host_id = ? order by Id desc limit 50",array($date,$date,$user_id));
					
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
					$this->load->view('SuperDealer/dmr_report_view',$this->view_data);	
																										
			}
		} 
	}	
	public function getTotalDMRValues($from,$to,$ddlapi)
	{
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		$total_hold = 0;
		
		
		$total_success_count = 0;
		$total_failure_count = 0;
		$total_pending_count = 0;
		$total_hold_count = 0;
		
		
		$rslt = $this->db->query("select IFNULL(Sum(Amount),0) as total,count(Id) as totalcount,Status from mt3_transfer where Date(add_date) >= ? and Date(add_date) <= ? and if(? != 'ALL',API =?,true) group by Status",array($from,$to,$ddlapi,$ddlapi));
		
		foreach($rslt->result() as $rw)
		{
			//echo  $rw->Status."  ".$rw->total;exit;
			if($rw->Status == "SUCCESS")
			{
				$total_success += $rw->total;
				$total_success_count += $rw->totalcount;
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
			);
		return $arr;
	}

	public function dataexport()
	{
	   exit;
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
			a.unique_id,
			a.retry,
			a.done_by,
			a.Id,
			a.add_date,a.edit_date,
			a.ipaddress,
			a.user_id,
			a.DId,
			a.MdId,
			a.Charge_type,
			a.charge_value,
			a.Charge_Amount,
			a.RemiterMobile,
			a.debit_amount,
			a.credit_amount,
			a.remitter_id,
			a.BeneficiaryId,
			a.AccountNumber,
			a.IFSC,
			a.Amount,
			a.Status,
			a.debited, 
			a.ewallet_id,
			a.balance,
			a.remark,
			a.mode,
			a.RESP_statuscode,
			a.RESP_status,
			a.RESP_ipay_id,
			a.RESP_ref_no,
			a.RESP_opr_id,
			a.RESP_name,
			a.RESP_opening_bal,
			b.businessname,
			b.username,
			b.mobile_no,
			parent.businessname as parent_businessname,
			parent.username as parent_username,
			parent.mobile_no as parent_mobile_no,
			fos.businessname as fos_businessname,
			fos.username as fos_username,
			fos.mobile_no as fos_mobile_no


FROM dhanpayc_archive.mt3_transfer a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
left join tblusers fos on b.fos_id = fos.user_id

 where Date(a.add_date) >= ? and Date(a.add_date) <= ? 
 
 order by Id desc",array($from,$to));
			}
			else
			{
			    $rslt = $this->db->query("SELECT 
			a.API,
			a.unique_id,
			a.retry,
			a.done_by,
			a.Id,
			a.add_date,a.edit_date,
			a.ipaddress,
			a.user_id,
			a.DId,
			a.MdId,
			a.Charge_type,
			a.charge_value,
			a.Charge_Amount,
			a.RemiterMobile,
			a.debit_amount,
			a.credit_amount,
			a.remitter_id,
			a.BeneficiaryId,
			a.AccountNumber,
			a.IFSC,
			a.Amount,
			a.Status,
			a.debited, 
			a.ewallet_id,
			a.balance,
			a.remark,
			a.mode,
			a.RESP_statuscode,
			a.RESP_status,
			a.RESP_ipay_id,
			a.RESP_ref_no,
			a.RESP_opr_id,
			a.RESP_name,
			a.RESP_opening_bal,
			b.businessname,
			b.username,
			b.mobile_no,
			parent.businessname as parent_businessname,
			parent.username as parent_username,
			parent.mobile_no as parent_mobile_no,
			fos.businessname as fos_businessname,
			fos.username as fos_username,
			fos.mobile_no as fos_mobile_no


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
left join tblusers fos on b.fos_id = fos.user_id

 where Date(a.add_date) >= ? and Date(a.add_date) <= ? 
 
 order by Id desc",array($from,$to));
			}
			
			
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"API" => $rw->API, 
									"unique_id" => $rw->unique_id, 
									"Id" => $rw->Id, 
									"add_date" =>$rw->add_date, 
									
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"AgentMobileNo" =>$rw->mobile_no, 
									
				
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
									"INSTAPAY_opening_bal" =>$rw->RESP_opening_bal, 
									
									"RESP_statuscode" =>$rw->RESP_statuscode, 
									"RESP_status" =>$rw->RESP_status, 
									"RESP_ipay_id" =>$rw->RESP_ipay_id, 
									"RESP_ref_no" =>$rw->RESP_ref_no, 
									"RESP_opr_id" =>$rw->RESP_opr_id, 
									
									
									"ipaddress" =>$rw->ipaddress, 
									"remark" =>$rw->remark, 
				
									"ParentName" =>$rw->parent_businessname, 
									"Parentusername" =>$rw->parent_username, 
									"ParentMobileNo" =>$rw->parent_mobile_no,
									
									"FOSName" =>$rw->fos_businessname, 
									"FOSusername" =>$rw->fos_username, 
									"FOSMobileNo" =>$rw->fos_mobile_no, 
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