<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AEPS_Report extends CI_Controller {
	
	
	private $msg='';	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

	//print_r($this->input->post());exit;
		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		} 			
		else if($this->input->post('FromDate') and $this->input->post('ToDate'))
		{
		 

			error_reporting(-1);
			ini_set('display_errors',1);
			$this->db->db_debug = TRUE;

			$from = date_format(date_create($this->input->post('FromDate',true)),'Y-m-d');
			$to = date_format(date_create($this->input->post('ToDate',true)),'Y-m-d');
			$txtRemitter = "";//$this->input->post('txtRemitter',true);
			$txtAccNo = "";//$this->input->post('txtAccNo',true);
			$status = "";//$this->input->post('ddl_status',true);
			
		
			$user_id = $this->session->userdata('AgentId');			
			
			
			$this->view_data['result_all'] = $this->db->query("SELECT a.Id, a.add_date, a.ipaddress, a.request_id, a.session_id, a.app_id, a.outlet_mobile, a.sp_key, a.amount, a.order_id, a.customer_params, a.user_id, a.response_code, a.response_msg, a.balance, a.cb_ipay_id, a.cb_agent_id, a.cb_opr_id, a.cb_status, a.cb_res_code, a.cb_res_msg, a.debit_amount, a.credit_amount, a.commission, a.tds, a.action_by,
						b.businessname,b.mobile_no

						
						FROM aeps_transactions2 a
						left join tblusers b on a.user_id = b.user_id
						
where 
a.user_id = ? and 
Date(a.add_date) >= ? and 
Date(a.add_date) <= ? 
order by Id desc ",array($user_id,$from,$to));
		


			//print_r($this->view_data['result_all'] ->result());exit;

			$this->view_data['message'] =$this->msg;
			$this->view_data['from'] =$this->input->post('FromDate',true);
			$this->view_data['to'] =$this->input->post('ToDate',true);
			$this->view_data['txtRemitter'] =$txtRemitter;
			$this->view_data['txtAccNo'] =$txtAccNo;
			$this->view_data['type'] =$status;
			$this->view_data["summary_array"] = $this->getTotalDMRValues($from,$to,"");
			$this->load->view('Retailer/AEPS_Report_view',$this->view_data);								
		}
		else 
		{ 						
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{										
					$from = $this->common->getMySqlDate();
					$to = $from;
					
					$status = "ALL";
					$user_id = $this->session->userdata('AgentId');			
				
					$this->view_data['result_all'] = $this->db->query("SELECT a.Id, a.add_date, a.ipaddress, a.request_id, a.session_id, a.app_id, a.outlet_mobile, a.sp_key, a.amount, a.order_id, a.customer_params, a.user_id, a.response_code, a.response_msg, a.balance, a.cb_ipay_id, a.cb_agent_id, a.cb_opr_id, a.cb_status, a.cb_res_code, a.cb_res_msg, a.debit_amount, a.credit_amount, a.commission, a.tds, a.action_by,
						b.businessname,b.mobile_no

						
						FROM aeps_transactions2 a
						left join tblusers b on a.user_id = b.user_id
						
					where a.user_id = ? and Date(a.add_date) >= ? and Date(a.add_date) <= ? order by Id desc",array($user_id,$from,$to));
					$this->view_data['message'] =$this->msg;
					$this->view_data['from'] = date_format(date_create($this->common->getMySqlDate()),'m/d/Y');
					$this->view_data['to'] =date_format(date_create($this->common->getMySqlDate()),'m/d/Y');
					$this->view_data['type'] =$status;
					$this->view_data["summary_array"] = $this->getTotalDMRValues($from,$to,$ddlapi);
					$this->load->view('Retailer/AEPS_Report_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	private function getTotalDMRValues($from,$to)
	{
	    $user_id = $this->session->userdata("AgentId");
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		$total_hold = 0;
		
		
		$total_success_count = 0;
		$total_failure_count = 0;
		$total_pending_count = 0;
		$total_hold_count = 0;
		
		
				$rslt = $this->db->query("select IFNULL(Sum(bill_amount),0) as total,cb_status from aeps_transactions2 where Date(add_date) >= ? and Date(add_date) <= ? and user_id = ? group by cb_status",array($from,$to,$user_id));

		foreach($rslt->result() as $rw)
		{
			//echo  $rw->Status."  ".$rw->total;exit;
			if($rw->cb_status == "SUCCESS")
			{
				$total_success += $rw->total;
				
			}
			else if($rw->cb_status == "FAILED")
			{
				$total_failure += $rw->total;
				
			}
			else if($rw->cb_status == "PENDING")
			{
				$total_pending += $rw->total;
				
			}
			else if($rw->cb_status  == "HOLD")
			{
				$total_hold += $rw->total;
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
	   
	    $user_id = $this->session->userdata("AgentId");
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

 where Date(a.add_date) >= ? and Date(a.add_date) <= ? and a.user_id = ?
 
 order by Id desc",array($from,$to,$user_id));
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
			b.mobile_no


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id


 where Date(a.add_date) >= ? and Date(a.add_date) <= ?  and a.user_id = ?
 
 order by Id desc",array($from,$to,$user_id));
			}
			
			
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									
								
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
									"RESP_statuscode" =>$rw->RESP_statuscode, 
									"RESP_status" =>$rw->RESP_status, 
								
									
									"RESP_opr_id" =>$rw->RESP_opr_id, 
									
									
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