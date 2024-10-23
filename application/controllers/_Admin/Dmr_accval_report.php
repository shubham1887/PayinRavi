<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_accval_report extends CI_Controller {
	
	
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
        
        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
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
				
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_all'] = $this->db->query("SELECT 
				a.Id,
				a.API,
				a.add_date,
				a.user_id,
				a.remitter_mobile,
				a.debit_amount,
				a.credit_amount,
				a.remitter_id,
				a.account_no,
				a.IFSC,
				a.status,
				
				a.RESP_statuscode,
				a.RESP_status,
				a.RESP_benename,
				a.RESP_remarks,
				a.RESP_bankrefno,
				a.RESP_ipay_id,
				a.RESP_charged_amt,
				
				b.businessname,
				b.username,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				parent.mobile_no as parent_mobile_no
				


FROM `mt3_account_validate` a
left join tblusers b on a.user_id = b.user_id
left join tblusers parent on b.parentid = parent.user_id
 where Date(a.add_date) >= ? and Date(a.add_date) <= ? and
 if( ? != 'ALL',a.Status = ?,true) and
 if(? != '',a.remitter_mobile = ?, true) and 
 if(? != '',a.account_no = ?, true) and 
 if(? >= 100,(b.username = ? or b.mobile_no = ? or parent.username = ? or parent.mobile_no = ?),true)
 
 order by Id desc",array($from,$to,$ddlstatus,$ddlstatus,$txtRemitter,$txtRemitter,$txtAccNo,$txtAccNo,$txtUserId,$txtUserId,$txtUserId,$txtUserId,$txtUserId));
					
				$this->view_data['message'] =$this->msg;
				
				$this->view_data['from'] =$from;
				$this->view_data['to'] =$to;
				$this->view_data['txtRemitter'] =$txtRemitter;
				$this->view_data['txtAccNo'] =$txtAccNo;
				$this->view_data['ddlstatus'] =$ddlstatus;
				$this->view_data['txtUserId'] =$txtUserId;
				$this->view_data["summary_array"] = $this->getTotalDMRValues($from,$to);
				$this->load->view('_Admin/dmr_accval_report_view',$this->view_data);		
			}	
		    else if(isset($_POST["hidId"]) and isset($_POST["hidstatus"]) and isset($_POST["hidaction"]))
			{
			  
				
				$hidId  = trim($_POST["hidId"]);
				$hidstatus  = trim($_POST["hidstatus"]);
				$hidaction  = trim($_POST["hidaction"]);
				if($hidaction == "STATUSUPDATE")
				{
					$rslttxncheck = $this->db->query("SELECT *

FROM `mt3_account_validate` a
left join tblusers b on a.user_id = b.user_id
 where a.Id = ? order by Id desc",array($hidId));
   
				
					if($rslttxncheck->num_rows() == 1)
					{
					    
						$Status = $rslttxncheck->row(0)->Status;
						$API = $rslttxncheck->row(0)->API;
						$dmr_id = $rslttxncheck->row(0)->Id;
						$user_id = $rslttxncheck->row(0)->user_id;
						$debit_amount = $rslttxncheck->row(0)->debit_amount;
						$credit_amount = $rslttxncheck->row(0)->credit_amount;
						$remitter_mobile = $rslttxncheck->row(0)->remitter_mobile;
						$account_no = $rslttxncheck->row(0)->account_no;
						//echo $Status;exit;
						if($Status == strtoupper($hidstatus))
						{
							redirect(base_url()."_Admin/dmr_accval_report?crypt=".$this->Common_methods->encrypt("MyData"));
						}
					
						else if(($Status == "SUCCESS" or $Status == "PENDING" or  $Status == "") and $hidstatus == "Failure")
						{
							    if($API == "EKO")
							    {
							        $Amount = 3;
    								$difference = $debit_amount - $credit_amount;
    							   
    								if($difference == $Amount)
    								{
    									$transaction_type = "DMR";
            							$sub_txn_type = "Account_Validation";
            							$charge_amount = 3.00;
            							$Description = "Account Validation Charge";
            							$remark = $remitter_mobile."  Acc NO :".$account_no;
    									$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
    									$sub_txn_type = "Account_Validation";
    									$this->db->query("update mt3_account_validate set Status = 'FAILURE' where Id = ?",array($dmr_id));
    									
    									$this->load->model("Eko");
    									$this->Eko->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,0);
    								
    								}    
							    }
							    
							    else if($API == "MASTERMONEY")
							    {
							        $Amount = 3;
    								$difference = $debit_amount - $credit_amount;
    							   
    								if($difference == $Amount)
    								{
    									$transaction_type = "DMR";
            							$sub_txn_type = "Account_Validation";
            							$charge_amount = 3.00;
            							$Description = "Account Validation Charge";
            							$remark = $remitter_mobile."  Acc NO :".$account_no;
    									$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
    									$sub_txn_type = "Account_Validation";
    									$this->db->query("update mt3_account_validate set Status = 'FAILURE' where Id = ?",array($dmr_id));
    									
    									$this->load->model("Eko");
    									$this->Eko->PAYMENT_CREDIT_ENTRY($user_id,$dmr_id,$transaction_type,$Amount,$Description,$sub_txn_type,$remark,0);
    								
    								}    
							    }
							    
								
								
							
							redirect(base_url()."_Admin/dmr_accval_report?crypt=".$this->Common_methods->encrypt("MyData"));
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
					
					
					$this->view_data['result_all'] = $this->db->query("
					select
					a.Id,
					a.API,
					a.add_date,
					a.user_id,
					a.remitter_mobile,
					a.debit_amount,
					a.credit_amount,
					a.remitter_id,
					a.account_no,
					a.IFSC,
					a.status,

					a.RESP_statuscode,
					a.RESP_status,
					a.RESP_benename,
					a.RESP_remarks,
					a.RESP_bankrefno,
					a.RESP_ipay_id,
					a.RESP_charged_amt,

					b.businessname,
					b.username,
					parent.businessname as parent_businessname,
					parent.username as parent_username,
					parent.mobile_no as parent_mobile_no
				


					FROM `mt3_account_validate` a
					left join tblusers b on a.user_id = b.user_id
					left join tblusers parent on b.parentid = parent.user_id
					 where Date(a.add_date) >= ? and Date(a.add_date) <= ? order by Id desc limit 100",array($date,$date));
					
					
					$this->view_data['message'] =$this->msg;
					$this->view_data['ddlstatus'] ="ALL";
					$this->view_data['from'] =$date;
					$this->view_data['to'] =$date;
					$this->view_data['ddldb'] ="LIVE";
					$this->view_data['txtRemitter'] ="";
					$this->view_data['txtAccNo'] ="";
					$this->view_data['txtUserId'] ="";
					$this->view_data["summary_array"] = $this->getTotalDMRValues($date,$date);
					$this->load->view('_Admin/dmr_accval_report_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function getTotalDMRValues($from,$to)
	{
		$total_credit = 0;
		$total_debit = 0;
		
		
		$rslt = $this->db->query("select IFNULL(Sum(debit_amount),0) as totaldebit,IFNULL(Sum(credit_amount),0) as totalcredit from mt3_account_validate where Date(add_date) >= ? and Date(add_date) <= ?",array($from,$to));
		
		foreach($rslt->result() as $rw)
		{
			$total_credit += $rw->totalcredit;
			$total_debit += $rw->totaldebit;
				
			
		}
		//echo $total_success;exit;
		$arr = array(
				"total_credit"=>$total_credit,
				"total_debit"=>$total_debit
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
				$this->db->query("update common set value = ? where param = 'DMRHOLD'",array($val));
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
			
			$data = array();
			
			
			
			$rslt = $this->db->query("select
					a.Id,
					a.API,
					a.add_date,
					a.ipaddress,
					a.user_id,
					a.remitter_mobile,
					a.debit_amount,
					a.credit_amount,
					a.remitter_id,
					a.account_no,
					a.IFSC,
					a.status,

					a.RESP_statuscode,
					a.RESP_status,
					a.RESP_benename,
					a.RESP_remarks,
					a.RESP_bankrefno,
					a.RESP_ipay_id,
					a.RESP_charged_amt,

					b.businessname,
					b.username,
					b.mobile_no,
					parent.businessname as parent_businessname,
					parent.username as parent_username,
					parent.mobile_no as parent_mobile_no
				


					FROM `mt3_account_validate` a
					left join tblusers b on a.user_id = b.user_id
					left join tblusers parent on b.parentid = parent.user_id
					 where Date(a.add_date) >= ? and Date(a.add_date) <= ? order by Id desc",array($from,$to));
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
									
				
									"RESP_name" =>$rw->RESP_benename, 
									"AccountNumber" =>$rw->account_no, 
									"IFSC" =>$rw->IFSC, 
									"status" =>$rw->status, 
									"remitter_mobile" =>$rw->remitter_mobile, 
									"debit_amount" =>$rw->debit_amount, 
									"credit_amount" =>$rw->credit_amount, 
									
									"RESP_statuscode" =>$rw->RESP_statuscode, 
									"RESP_status" =>$rw->RESP_status, 
									"RESP_ipay_id" =>$rw->RESP_ipay_id, 
									"RESP_opr_id" =>$rw->RESP_bankrefno, 
									
									
									"ipaddress" =>$rw->ipaddress, 
									"remark" =>$rw->RESP_remarks, 
				
									"ParentName" =>$rw->parent_businessname, 
									"Parentusername" =>$rw->parent_username, 
									"ParentMobileNo" =>$rw->parent_mobile_no, 
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

	public function dmr_accval_report_data()
{

		$txtFrom =date('Y-m-d 00:00:00', strtotime($this->input->post('txtFrom')));
		$txtTo = date('Y-m-d 23:59:59', strtotime($this->input->post('txtTo')));
		$ddlstatus = $this->input->post('ddlstatus');
		$txtRemitter = $this->input->post('txtRemitter');
		$txtAccNo = $this->input->post('txtAccNo');
		$txtUserId = $this->input->post('txtUserId');
		$userdata = $this->dmr_accval_report_model->get_datatables($txtFrom,$txtTo,$ddlstatus,$txtRemitter,$txtAccNo,$txtUserId);
		$data = array();
		$no = $_POST['start'];
		foreach ($userdata as $udt) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $udt->API;
			$row[] = $udt->Id;
			$row[] = $udt->add_date;
			$row[] = $udt->businessname.' '.'['.$udt->username.']';
			$row[] = $udt->remitter_mobile;
			$row[] = $udt->account_no;
			$row[] = $udt->IFSC;
			$row[] = $udt->RESP_benename;
			$row[] = $udt->debit_amount;
			$row[] = $udt->credit_amount;
			$row[] = $udt->RESP_bankrefno.''.$udt->RESP_status;
			$status='';
			if($udt->status == "PENDING" || $udt->status == "HOLD")
			{
				$status= '<span id="db_status"'.$udt->$i."' class='label label-primary' onclick='checkstatus('".$udt->Id."')'>".$udt->status."</span>";
			}	
			if($udt->status == "SUCCESS" || $udt->status == "FAILURE")
			{
				$status= '<span id="db_status"'.$udt->$i."' class='label label-success'>".$udt->status."</span>";
			}
			if($udt->status == "FAILED" || $udt->status == "FAILURE")
			{
				$status= '<span id="db_status"'.$udt->$i."' class='label label-warning'>".$udt->status."</span>";
			}


			$row[] = $status;
			$row[] = '
						<select id="ddlstatus'.$udt->Id.'" name="ddlstatus" class="form-control" style="width: 80px;font-size: 12px;font-weight: bold;height: 30px;">
						<option value="0">Select Action</option>
						<option value="Success">Success</option>
						<option value="Failure">Failure</option>
					</select>
					<input type="button" id="btnstatuschange" class="btn btn-primary btn-mini" style="width: 60px;font-size: 10px;font-weight: bold" value="Submit" onClick="doaction('.$udt->Id.')">
					';
			 // $totaldr += $udt->debit_amount;
			 // $totalcr += $udt->credit_amount;				
			 // $row[] = $totaldr;
		  //    $row[] = $totalcr;		

			$data[] = $row;

		}
		return $data;
		$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->dmr_accval_report_model->count_all($txtFrom,$txtTo,$ddlstatus,$txtRemitter,$txtAccNo,$txtUserId),
				"recordsFiltered" => $this->dmr_accval_report_model->count_filtered($txtFrom,$txtTo,$ddlstatus,$txtRemitter,$txtAccNo,$txtUserId),
				"data" => $data,
		);
		echo json_encode($output);
	}

	public function getDmrTotal()
{
		$txtFrom =date('Y-m-d 00:00:00', strtotime($this->input->post('txtFrom')));
		$txtTo = date('Y-m-d 23:59:59', strtotime($this->input->post('txtTo')));
		$ddlstatus = $this->input->post('ddlstatus');
		$txtRemitter = $this->input->post('txtRemitter');
		$txtAccNo = $this->input->post('txtAccNo');
		$txtUserId = $this->input->post('txtUserId');
		$total_credit = 0;
		$total_debit = 0;
		
		// $rslt = $this->db->query("select IFNULL(Sum(debit_amount),0) as totaldebit,IFNULL(Sum(credit_amount),0) as totalcredit
		// 						 from mt3_account_validate where Date(add_date) >= ? and Date(add_date) <= ? ",array($from,$to));

		$str_query = 'SELECT IFNULL(Sum(debit_amount),0) as totaldebit,IFNULL(Sum(credit_amount),0) as totalcredit FROM mt3_account_validate WHERE DATE(add_date) >= "'.$txtFrom.'" AND DATE(add_date) <= "'.$txtTo.'" ';

		if($ddlstatus!='ALL'){		
			$str_query.= " and status ='".$ddlstatus."' ";
		}
		if($txtRemitter!=''){		
			$str_query.= " and remitter_mobile ='".$txtRemitter."' ";
		}
		if($txtAccNo!=''){		
			$str_query.= " and account_no ='".$txtAccNo."' ";
		}
		if($txtUserId!=''){		
			$str_query.= " and Id ='".$txtUserId."' ";
		}

		$rslt = $this->db->query($str_query);		
		foreach($rslt->result() as $rw)
		// foreach ($rslt->result as $value)
		{	
			$data["summary_array_cr"] = $total_credit 	+= 	$rw->totalcredit;
			$data["summary_array_dr"] = $total_debit 	+= 	$rw->totaldebit;			
		}
		echo json_encode($data);
	}

/////////////// End Datatable  ///////////////////

}