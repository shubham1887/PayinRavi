<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_report extends CI_Controller {
	
	
	private $msg='';	
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
        error_reporting(E_ALL);
		ini_set('display_errors', 1);
		$this->db->db_debug = TRUE;
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ausertype') != "Admin") 
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

		if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		} 			
		else if($this->input->post('btnSearch'))
		{
			$from = $this->input->post('txtFrom',true);
			
			
			$to = $this->input->post('txtTo',true);
			
			$ddlstatus = $this->input->post("ddlstatus");
			$txtNumber = $this->input->post("txtNumber");
			$ddlmode = $this->input->post("ddlmode");
			
			$this->session->set_userdata("from",$from);
			$this->session->set_userdata("to",$to);
			$this->session->set_userdata("status",$ddlstatus);
			$this->session->set_userdata("txtNumber",$txtNumber);
			$this->session->set_userdata("ddlmode",$ddlmode);
			$this->session->set_userdata("ADMIN_BILL_REPORT_DATEFLAG","SET");
			
	
			
			$status = $this->input->post('ddlType',true);			
		
			$this->view_data['result_all'] = $this->db->query("SELECT a.mode,a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,b.company_name,c.businessname,c.username FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where 
Date(a.add_date) >= ? and 
Date(a.add_date) <= ?  and
if(? != 'ALL',a.Status = ?,true) and
if(? != '',(a.service_no = ? or a.customer_mobile = ?),true) and
if(? != 'ALL',(a.mode = ?),true)

order by a.Id desc ",array($from,$to,$ddlstatus,$ddlstatus,$txtNumber,$txtNumber,$txtNumber,$ddlmode,$ddlmode));
		
			$this->view_data['message'] =$this->msg;
			$this->view_data['from'] =$from;
			$this->view_data['to'] =$to;
			$this->view_data['status'] =$ddlstatus;
			$this->view_data['mode'] =$ddlmode;
			$this->view_data['txtNumber'] =$txtNumber;
			$this->view_data["summary_array"] = $this->getTotalBillValues($from,$to);
			$this->load->view('_Admin/bill_report_view',$this->view_data);								
		}
		else if($this->input->post('hidaction') == "Set")
		{	
			error_reporting(-1);
			ini_set('display_errors',1);
			$this->db->db_debug = TRUE;
			//print_r($this->input->post());exit;
				$status = $this->input->post("hidstatus",TRUE);

				$bill_id = $this->input->post("hidid",TRUE);

				$opr_id = $this->input->post("hidOprId");
			//	$hidCustName = $this->input->post("hidCustName");
					$bill_info = $this->db->query("SELECT a.mode,a.commission,a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,b.company_name,c.businessname,c.username FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where a.Id = ?",array($bill_id));
				//	echo $bill_info->num_rows();exit;
					if($bill_info->num_rows() == 1)
					{
						
						$user_id = $bill_info->row(0)->user_id;
						$insert_id = $bill_info->row(0)->Id;
						$transaction_type = "BILL";
						$dr_amount = $bill_info->row(0)->bill_amount;
						$debit_amount = $bill_info->row(0)->debit_amount;
						$credit_amount = $bill_info->row(0)->credit_amount;
						$Description = "Service No.  ".$bill_info->row(0)->service_no." Bill Amount : ".$bill_info->row(0)->bill_amount;
						$sub_txn_type = "BILL";
						$remark = "Bill PAYMENT";
						
						//$Charge_Amount = (($bill_info->row(0)->bill_amount * 0.50)/100);
						$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
						
						$Charge_Amount = $bill_info->row(0)->bill_amount - $debit_amount;
						
						$oldStatus = $bill_info->row(0)->status;
					//	echo $oldStatus;exit;



						if($status > 1)
						{
							$this->load->model("BillPayment");
							$api_id = $status;
							$resp = $this->BillPayment->bill_resend($bill_id,$api_id);
						}

						else if($oldStatus == "Pending" or $oldStatus == "" or $oldStatus == "Success")
						{
                            
							if($status == "Failure" )
							{
							   //echo $status;exit;
							    $dr_amount = $dr_amount - $Charge_Amount;
								$statuscode = "MANUAL";
								$message = "Manual Failed";
								$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
								$this->load->model("Mastermoney");
								$this->Mastermoney->PAYMENT_CREDIT_ENTRY_bill($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,0,0);
								$this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$statuscode,$message,$insert_id));
							}
							else if($status == "Success")
							{
								$ipay_id = "";
								
								$statuscode = "MANUAL";
								$message = "Bill Payment Success";
								
								$trans_amt = $bill_info->row(0)->bill_amount;
								$charged_amt = $Charge_Amount;
								$opening_bal = "";
								$datetime = $this->common->getDate();
								$res_status = "SUCCESS";
								$statuscode = "MANUAL";
								$res_msg = "Bill Payment Success";
								
								
								
								
								
								$this->db->query("update tblbills set status = 'Success',ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",
								array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$res_status,$statuscode,$res_msg,$insert_id));
							}
							
						}
						else if($oldStatus == "Failure" )
						{
                            
							if($status == "Rollback" )
							{
							   
							    $dr_amount = $debit_amount;
								$statuscode = "MANUAL";
								$message = "Manual Rollback";
								$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));


								


								
								$this->load->model("Mastermoney");
								$this->Mastermoney->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);

								//$this->load->model("Instapay");
								//$this->Instapay->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
								$this->db->query("update tblbills set status = 'Success',resp_status=?,res_code=?,res_msg=? where Id = ?",array("SUCCESS",$statuscode,$message,$insert_id));
							}
							
						}

						
					}
				 
					

					
						$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Action Submitted Successfully");
					    redirect(base_url()."_Admin/bill_report?crypt=".$this->Common_methods->encrypt("MyData"));
				
			}
		else 
		{ 						
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{										
				    $status = "ALL";
				    $txtNumber = "";
				    $from = $this->session->userdata("from");
        			$to = $this->session->userdata("to");
        			$ddlmode = $this->session->userdata("ddlmode");
        			
        			$ADMIN_BILL_REPORT_DATEFLAG = $this->session->userdata("ADMIN_BILL_REPORT_DATEFLAG");
        			if($ADMIN_BILL_REPORT_DATEFLAG == "SET")
        			{
        			    $from = $from;
					    $to = $to;
					    $ddlmode = $ddlmode;
					    $status = $this->session->userdata("status");
					    $txtNumber = 	$this->session->userdata("txtNumber");
        			}
        			else
        			{
        			    $from = $this->common->getMySqlDate();
					    $to = $from;
					    $ddlmode = "ALL";
        			}
				    
					
				
					$user_id = $this->session->userdata('AgentId');			
					
					$this->view_data['result_all'] = $this->db->query("SELECT a.mode,a.Id,a.user_id,a.add_date,a.service_no,a.customer_mobile,a.customer_name,a.dueamount,a.duedate,a.billnumber,a.billdate,a.billperiod,a.company_id,a.bill_amount,a.status,a.opr_id,a.charged_amt,a.resp_status,a.res_code,a.debit_amount,a.credit_amount,a.option1,b.company_name,c.businessname,c.username FROM `tblbills` a left join tblcompany b on a.company_id = b.company_id
left join tblusers c on a.user_id = c.user_id
where 
Date(a.add_date) >= ? and
Date(a.add_date) <= ? and
if(? != 'ALL',a.status = ?,true)  and
if(? != '',(a.service_no = ? or a.customer_mobile = ?),true)

order by a.Id desc ",array($from,$to,$status,$status,$txtNumber,$txtNumber,$txtNumber));
					


					//print_r($this->view_data['result_all']->num_rows());exit;

					$this->view_data['message'] =$this->msg;
					$this->view_data['from'] =$from;
					$this->view_data['to'] =$from;
					$this->view_data['status'] =$status;
					$this->view_data['mode'] =$ddlmode;
					$this->view_data['txtNumber'] =$txtNumber;
					$this->view_data["summary_array"] = $this->getTotalBillValues($from,$to);
					$this->load->view('_Admin/bill_report_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}
	public function setvalues()
	{
		if(isset($_GET["field"]) and isset($_GET["val"]))
		{
			$field = trim($_GET["field"]);
			$val = trim($_GET["val"]);
			if($field == "HOLD")
			{
				$this->db->query("update common set value = ? where param = 'BILLHOLD'",array($val));
				echo "OK";
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
			$status = trim($_GET["status"]);
			$mode = trim($_GET["mode"]);
		    
			
		
		
			$data = array();
			
			
			
				$str_query = "SELECT 
				a.Id,
				a.API,
				a.mode,
				a.user_id,
				a.add_date,
				a.service_no,
				a.customer_mobile,
				a.customer_name,
				a.dueamount,
				a.duedate,
				a.billnumber,
				a.billdate,
				a.billperiod,
				a.company_id,
				a.bill_amount,
				a.status,
				a.opr_id,
				a.ipay_id,
				a.charged_amt,
				a.resp_status,
				a.res_code,
				a.debit_amount,
				a.credit_amount,
				a.option1,
				b.company_name,
				c.businessname,c.username,c.mobile_no as AgentMobileNo,
				parent.businessname as parent_businessname,
				parent.username as parent_username,
				parent.mobile_no as parent_mobile_no,
    			fos.businessname as fos_businessname,
    			fos.username as fos_username,
    			fos.mobile_no as fos_mobile_no
				FROM `tblbills` a 
				left join tblcompany b on a.company_id = b.company_id
				left join tblusers c on a.user_id = c.user_id
				left join tblusers parent on c.parentid = parent.user_id
				left join tblusers fos on c.fos_id = fos.user_id
				where 
				Date(a.add_date) >= ? and 
				Date(a.add_date) <= ? and
				if(? != 'ALL',a.Status = ?,true) and
				if(? != 'ALL',(a.mode = ?),true)
				order by a.Id";
				
			$rslt = $this->db->query($str_query,array($from,$to,$status,$status,$mode,$mode));
			
				
		$i = 0;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"Id" => $rw->Id, 

									"mode" => $rw->mode, 
									"API" => $rw->API, 

									"add_date" =>$rw->add_date, 
									"AgentMobile" =>$rw->AgentMobileNo, 
									"businessname" =>$rw->businessname, 
									"username" =>$rw->username, 
									"company_name" => $rw->company_name, 
									"service_no" =>$rw->service_no, 
									"Option1" =>$rw->option1, 
									"Amount" =>$rw->bill_amount, 
									"dueamount" =>$rw->dueamount, 
									"duedate"=>$rw->duedate, 
									"billnumber"=>$rw->billnumber, 
									"billdate"=>$rw->billdate, 
									"billperiod"=>$rw->billperiod, 
									"customer_mobile" =>$rw->customer_mobile, 
									"customer_name" =>$rw->customer_name, 
									"status"=>$rw->status, 
									"opr_id"=>$rw->opr_id, 
									"ipay_id"=>$rw->ipay_id, 
									"resp_status"=>$rw->resp_status,
									"debit_amount" =>$rw->debit_amount, 
									"credit_amount" =>$rw->credit_amount, 
									
									"ParentName" =>$rw->parent_businessname, 
									"ParentUserId" =>$rw->parent_username, 
									"ParentMobile" =>$rw->parent_mobile_no, 
										
									
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
    $fileName = "billreport From ".$from." To  ".$to.".xls";
    
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
	public function getTotalBillValues($from,$to)
	{
		$total_success = 0;
		$total_failure = 0;
		$total_pending = 0;
		
		$total_commission = 0;
		
		
		$rslt = $this->db->query("
		select 
		IFNULL(Sum(bill_amount),0) as total,
		IFNULL(Sum(charged_amt),0) as total_commission,
		status 
		from tblbills 
		where 
		Date(add_date) >= ? and 
		Date(add_date) <= ? 
	    group by status",array($from,$to));
		
		foreach($rslt->result() as $rw)
		{
			//echo  $rw->Status."  ".$rw->total;exit;
			if($rw->status == "Success")
			{
				$total_success += $rw->total;
				$total_commission += $rw->total_commission;
			}
			else if($rw->status == "Failure")
			{
				$total_failure += $rw->total;
			}
			else if($rw->status == "Pending")
			{
				$total_pending += $rw->total;
			}
			
		}
		//echo $total_success;exit;
		$arr = array(
				"Success"=>$total_success,
				"Failure"=>$total_failure,
				"Pending"=>$total_pending,
				"commission"=>$total_commission,
			);
		return $arr;
	}
}