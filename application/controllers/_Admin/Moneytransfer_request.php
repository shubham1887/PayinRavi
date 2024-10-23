<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Moneytransfer_request extends CI_Controller { 
 	
		
		
	public function index() 
	{  	  
		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			//print_r($this->input->post());exit;
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('AgentUserType');			
			if(trim($user) == 'Agent')
			{
				$this->view_data['message']='';
				$this->load->view('Retailer/moneytransfer_request_view',$this->view_data);
			} 
			else
			{					
				redirect(base_url().'login');
			}
		}
	}
	
	public function billpay()
	{
		$user_id = $this->session->userdata("AgentId");
		$bankid = $this->input->post("ddlutilitybil_operator");
		$accountName = $this->input->post("txtCustName");
		$accountNo = $this->input->post("txtAccountNo");
		$ifsccode = $this->input->post("txtIfscCode");
		$amount = $this->input->post("txtTrAmount");
		$mobile = $this->input->post("txtMobileNo");
		$sendername = $this->input->post("txtSenderName");
		$remark = $this->input->post("txtRemarks");
		$date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$dr_amount = $amount + ($amount*0.007);
		$str_query = "select * from tblbank where bank_id=?";
		$result = $this->db->query($str_query,$bankid);	
		$bank_name = $result->row(0)->bank_name;
		//echo $bank_name;exit;
		$balance = $this->Common_methods->getAgentBalance($user_id);
		if($balance >= $dr_amount)
		{
			$transaction_type = "MoneyTransfer";
			$Description = "MoneyTransfer : Account Number : ".$accountNo."  | Transfer Amount :".$amount." | Debit Amount :".$dr_amount."  | Account Name : ".$accountName." | Bank Name : ".$bank_name;
			
			$str_query = "INSERT INTO `tblmoneytransfer` (`user_id`, `bank_id`, `bank_name`, `account_nanme`,  `account_no`, `IFSCode`, `mobile_no`, `sender_name`, `transfer_amount`, `remark`, `debit_amount`, `status`, `ipaddress`, `add_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$this->db->query($str_query,array($user_id,$bankid,$bank_name,$accountName,$accountNo,$ifsccode,$mobile,$sendername,$amount,$remark,$dr_amount,'Pending',$ipaddress,$date));	
	
			$transfer_id = $this->db->insert_id();
			$this->Insert_model->tblewallet_MoneyTransfer_DrEntry($user_id,$transfer_id,$transaction_type,$dr_amount,$Description);	
			echo "Money Transfer Request Send Successful.";
			//$this->session->set_flashdata('message', "Money Transfer Request Send Successful.");
			//redirect(base_url()."Retailer/moneytransfer_request");	
		}
		else
		{
			echo "Insufficient Balance";
			//$this->session->set_flashdata('message', "Insufficient Balance");
			//redirect(base_url()."Retailer/moneytransfer_request");	
		}
		
		
		
		
	}
	
	
	private function ProcessBill($user_id,$ddlbiller,$txtCustName,$txtMobileNo,$txtAmount,$txtCustAccNo)
	{
		$add_date = $this->common->getDate();
		$ip = $this->common->getRealIpAddr();
		$this->db->query("insert into tblbillpay(cust_name,commission,add_date,ipaddress,status,user_id,company_name,cust_mob_no,amount,cust_acc_no) values (?,?,?,?,?,?,?,?,?,?)",array($txtCustName,"5",$add_date,$ip,"Pending",$user_id,$ddlbiller,$txtMobileNo,$txtAmount,$txtCustAccNo));
		$id = $this->db->insert_id();
		$Description = "BILL PAYMENT :: ".$ddlbiller." | ".$txtAmount." | ".$txtCustName." | BILL ID = ".$id;
		$dr_amount = $txtAmount + 10;
		$this->tblewallet_DrEntry($user_id,$id,$dr_amount,$Description);
		return "Request Submited Successfully";
	}
	private function checkpending($user_id,$ddlbiller,$txtAmount,$txtCustAccNo)
	{
		$rslt = $this->db->query("select * from tblbillpay where user_id = ? and company_name = ? and amount = ? and cust_acc_no = ? and status = 'Pending'",array($user_id,$ddlbiller,$txtAmount,$txtCustAccNo));	
		if($rslt->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	private function tblewallet_DrEntry($user_id,$billid,$dr_amount,$Description)
	{
		$transaction_type = "PAYMENT";
		$str_checkdebited = $this->db->query("select debited from tblbillpay where Id = ?",array($billid));
		if($str_checkdebited->row(0)->debited == "yes")
		{
			return true;
		}
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();

		$old_balance = $this->Common_methods->getCurrentBalance($user_id);
		$current_balance = $old_balance - $dr_amount;
		
		$str_query = "insert into  tblewallet(user_id,transaction_type,debit_amount,balance,description,add_date)
		values(?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date));
		$ewallet_id = $this->db->insert_id();
		$rslt_updtrec = $this->db->query("update tblbillpay set debited='yes',reverted='no', debitid = CONCAT_WS(',',debitid,?) where Id = ?",array($ewallet_id,$billid));
		return true;
	}
}	