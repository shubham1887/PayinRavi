<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_history extends CI_Controller {
	
	
	private $msg='';
	
	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}					
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Search")
			{
			
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$ddlstatus = $this->input->post("ddlstatus",TRUE);
				$ddlWallet = $this->input->post("ddlWallet",TRUE);
				$ddlMode = $this->input->post("ddlMode",TRUE);
				$txtAgentNumber = $this->input->post("txtAgentNumber",TRUE);
				$txtAmount = $this->input->post("txtAmount",TRUE);
				$txtRemark = $this->input->post("txtRemark",TRUE);
				$ddlAgent_type = $this->input->post("ddlAgent_type",TRUE);
				$ddltype = $this->input->post("ddltype",TRUE);

				$this->view_data['from'] = $from_date;
				$this->view_data['to'] = $to_date;
				$this->view_data['ddlstatus'] = $ddlstatus;
				$this->view_data['ddlWallet'] = $ddlWallet;
				$this->view_data['ddlMode'] = $ddlMode;
				$this->view_data['txtAgentNumber'] = $txtAgentNumber;
				$this->view_data['txtAmount'] = $txtAmount;
				$this->view_data['txtRemark'] = $txtRemark;
				$this->view_data['ddlAgent_type'] = $ddlAgent_type;
				$this->view_data['type'] = $ddltype;

				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->db->query("
				select a.Id,a.add_date,a.payment_type,a.amount,a.status,a.transaction_id,a.wallet_type,a.admin_remark,a.client_remark,
				b.businessname,b.username,b.usertype_name,
				bank.account_name,
				bank.account_number,
				bank.ifsc,
				bn.bank_name
				from tblautopayreq a
				left join tblusers b on a.user_id = b.user_id
				left join creditmaster_banks bank on a.admin_bank_account_id = bank.Id
				left join tblbank bn on bank.bank_id = bn.bank_id
				where 
			
				Date(a.add_date) >= ? and Date(a.add_date) <= ? and
     				if( ? != 'ALL',a.status = ?,true) and
     				if( ? != 'ALL',a.wallet_type = ?,true) and
     				if( ? != 'ALL',a.payment_type = ?,true) and
     				if( ? != '',b.username = ?,true) and 
     				if( ? != '',a.amount = ?,true) and
     				if( ? != '',a.admin_remark = ?,true) and
     				if( ? != 'ALL',b.usertype_name = ?,true) 

				ORDER BY Id DESC",array($from_date,$to_date,$ddlstatus,$ddlstatus,$ddlWallet,$ddlWallet,$ddlMode,$ddlMode,$txtAgentNumber,$txtAgentNumber,$txtAmount,$txtAmount,$txtRemark,$txtRemark,$ddlAgent_type,$ddlAgent_type));
				
				
				
				$this->view_data['flagopenclose'] =1;
				$this->view_data['summary_array'] = $this->getTotalValues($from_date,$to_date,$ddlstatus,$ddlWallet,$ddlMode,$txtAgentNumber,$txtAmount,$txtRemark,$ddlAgent_type);
				$this->view_data['message'] =$this->msg;
				$this->load->view('_Admin/payment_history_view',$this->view_data);		
			}					
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				
					$from_date = $to_date = $this->common->getMySqlDate();
				
			
					
					$this->view_data['from'] = $from_date;
					$this->view_data['search'] = "";
					$this->view_data['type'] = "";
					$this->view_data['to'] = $to_date;
					$this->view_data['pagination'] = NULL;
					
					
					$this->view_data['result_mdealer'] = $this->db->query("
				select a.Id,a.add_date,a.payment_type,a.amount,a.status,a.transaction_id,a.wallet_type,a.admin_remark,a.client_remark,
				b.businessname,b.username,b.usertype_name,
				bank.account_name,
				bank.account_number,
				bank.ifsc,
				bn.bank_name

				from tblautopayreq a
				left join tblusers b on a.user_id = b.user_id
				left join creditmaster_banks bank on a.admin_bank_account_id = bank.Id
				left join tblbank bn on bank.bank_id = bn.bank_id 
				where 
			
				Date(a.add_date) >= ? and Date(a.add_date) <= ?
				ORDER BY Id DESC",array($from_date,$to_date));
					$this->view_data['flagopenclose'] =1;


					$this->view_data['summary_array'] = $this->getTotalValues($from_date,$to_date);

					$this->view_data['message'] =$this->msg;
					$this->load->view('_Admin/payment_history_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function getTotalValues($from_date,$to_date,$ddlstatus="ALL",$ddlWallet="ALL",$ddlMode="ALL",$txtAgentNumber="",$txtAmount="",$txtRemark="",$ddlAgent_type="ALL")
	{
		$total_success = 0;
		$total_success_count = 0;

		$total_failure = 0;
		$total_failure_count = 0;

		$total_pending = 0;
		$total_pending_count = 0;
		$rslt = $this->db->query("
		select 
		IFNULL(Sum(a.amount),0) as Total,
		count(Id) as totalcount,
		a.status 
		from tblautopayreq  a
		left join tblusers b on a.user_id = b.user_id
		where 
		Date(a.add_date) BETWEEN ? and ? and 
		if( ? != 'ALL',a.status = ?,true) and
     	if( ? != 'ALL',a.wallet_type = ?,true) and
     	if( ? != 'ALL',a.payment_type = ?,true) and
     	if( ? != '',b.username = ?,true) and 
     	if( ? != '',a.amount = ?,true) and
     	if( ? != '',a.admin_remark = ?,true) and
     	if( ? != 'ALL',b.usertype_name = ?,true) 
		group by a.status",array($from_date,$to_date,$ddlstatus,$ddlstatus,$ddlWallet,$ddlWallet,$ddlMode,$ddlMode,$txtAgentNumber,$txtAgentNumber,$txtAmount,$txtAmount,$txtRemark,$txtRemark,$ddlAgent_type,$ddlAgent_type));
		
		
		foreach($rslt->result() as $rw)
		{
			//echo  $rw->Status."  ".$rw->total;exit;
			if($rw->status == "Approve")
			{
				$total_success += $rw->Total;
			
			}
			else if($rw->status == "Reject")
			{
				$total_failure += $rw->Total;
				
			}
			else if($rw->status == "Pending")
			{
				$total_pending += $rw->Total;
				
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
				"Pending_Count"=>$total_pending_count
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
			
			if($db == "ARCHIVE")
			{
			    $str_query = "select 
		
        		a.id,a.add_date,a.payment_type,a.amount,a.status,a.transaction_id,a.wallet_type,a.admin_remark,
				b.businessname,b.username,b.usertype_name,
				bank.account_name,
				bank.account_number,
				bank.ifsc,
				bn.bank_name

				from tblautopayreq a
				left join tblusers b on a.user_id = b.user_id
				left join creditmaster_banks bank on a.admin_bank_account_id = bank.Id
				left join tblbank bn on bank.bank_id = bn.bank_id
				where 
			
				Date(a.add_date) >= ? and Date(a.add_date) <= ?
				
			";
		        $rslt = $this->db->query($str_query,array($from,$to));
			}
			else
			{
			    $str_query = "select 
		
        	    
        		a.id,a.add_date,a.payment_type,a.amount,a.status,a.transaction_id,a.wallet_type,a.admin_remark,
				b.businessname,b.username,b.usertype_name,
				bank.account_name,
				bank.account_number,
				bank.ifsc,
				bn.bank_name
 			
				from tblautopayreq a
				left join tblusers b on a.user_id = b.user_id
				left join creditmaster_banks bank on a.admin_bank_account_id = bank.Id
				left join tblbank bn on bank.bank_id = bn.bank_id
				where 
			
				Date(a.add_date) >= ? and Date(a.add_date) <= ?
				
				";
		       
		$rslt = $this->db->query($str_query,array($from,$to));
			}
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"payment_id" => $rw->Id, 
									"add_date" => $rw->add_date, 
									"username" => $rw->username,
									"usertype_name" =>$rw->usertype_name, 
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"bank_name" =>$rw->bank_name,  
									"payment_type" => $rw->payment_type,
									"wallet_type" => $rw->wallet_type,
									"transaction_id" => $rw->transaction_id,
									"admin_remark" => $rw->admin_remark,
									"amount" =>$rw->amount,
									"status" =>$rw->status


								
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
    $fileName = "Account Ledger Report From ".$from." To  ".$to.".xls";
    
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