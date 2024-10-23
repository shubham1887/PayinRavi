<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cashentry extends CI_Controller {
	public function index()
	{	
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('alogged_in') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			if($this->input->post("txtDesc") and $this->input->post("txtAmount") and $this->input->post("ddlcashtransactiontype"))
			{
				$ddlcashtransactiontype = $this->input->post("ddlcashtransactiontype");
				$txtAmount = $this->input->post("txtAmount");
				$txtDesc = $this->input->post("txtDesc");
				$bankaccount_id = $this->input->post("ddlBankAccount");
				$remark = $txtDesc;
				$ddlPayee = $this->input->post("ddlPayee");
				$user_id = $ddlPayee;
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				$rsltpayee = $this->db->query("select * from ACCOUNTING_DEBTORS_ACCOUNT where USER_ID = ?",array($ddlPayee));
				if($rsltpayee->num_rows() >= 1)
				{
					$cashbalance = $this->getCashOnHand($user_id);
					$userbalance = $this->getbalance($user_id);
					
					
					
					if($ddlcashtransactiontype == "CashIN")
					{
						$credit_amount = $txtAmount;
						$debit_amount = 0;
						$this->accounting_entry_cashbank($user_id,$remark,$credit_amount,"","CASH","");
						$this->session->set_flashdata("mesage","Action Sutbmited Successfully");
						redirect("Account/cashentry");	
					}
					else if($ddlcashtransactiontype == "CashOut")
					{
						$credit_amount = 0;
						$debit_amount = $txtAmount;
						$balance = $balance - $debit_amount;
					}
					
					
					
				}
				else if($ddlcashtransactiontype == "BANKDEPO")
				{
					$rsltopeningcash = $this->db->query("select balance from tblcashentry order by Id desc limit 1");
					if($rsltopeningcash->num_rows() == 1)
					{$balance = $rsltopeningcash->row(0)->balance;}
					else
					{$balance = 0;}
						$debit_amount = $txtAmount;
						$credit_amount = 0;
						$balance = $balance - $debit_amount;
						$this->db->query("insert into tblcashentry(description,credit_amount,debit_amount,balance,add_date,ipaddress) values( ?,?,?,?,?,?)",array($txtDesc,$credit_amount,$debit_amount,$balance,$add_date,$ipaddress));
						$ref_id = $this->db->insert_id();
						
						$rsltacc = $this->db->query("select tbluser_bank.*,bank_name from tbluser_bank,tblbank where tblbank.bank_id = tbluser_bank.bank_id and user_bank_Id = ?",array($bankaccount_id));
					if($rsltacc->num_rows() == 1)
					{
						$rsltopeningcash = $this->db->query("select balance from tblbankentryes where bankaccount_id = ? order by Id desc limit 1",array($bankaccount_id));
						if($rsltopeningcash->num_rows() == 1)
						{$balance = $rsltopeningcash->row(0)->balance;}
						else
						{$balance = 0;}
						
						$credit_amount = $txtAmount;
						$debit_amount = 0;
						$balance = $balance + $credit_amount;
						$this->db->query("insert into tblbankentryes(description,bankaccount_id,credit_amount,debit_amount,balance,add_date,ipaddress,transaction_date,user_id) values( ?,?,?,?,?,?,?,?,?)",array($txtDesc,$bankaccount_id,$credit_amount,$debit_amount,$balance,$add_date,$ipaddress,$ddlcashtransactiontype,$user_id));
							$ref_id = $this->db->insert_id();
						
						
					
					}
						$this->session->set_flashdata("mesage","Action Sutbmited Successfully");
						redirect("Account/cashentry");	
					}
				
				
			}
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->load->view('Account/cashentry_view',$this->view_data);		 		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
	}
	
	private function accounting_entry_cashbank($user_id,$txtRemark,$txtAmount,$ewid,$transaction_type,$ddlbank)
	{
					$balance = $this->getbalance($user_id);
					$USER_ID = $user_id;
					$TRANSACTION_TYPE = $transaction_type;
					$DESCRIPTION=$transaction_type;
					$REMARK = $txtRemark;
					$RECEIVED_CASH=floatval($txtAmount);
					$GIVEN_DEBT = 0;
					$REMAINING_DEBT = $balance + $RECEIVED_CASH;
					$DEBT_GIVEN_DATE = $this->common->getDate();
					$CASH_RECEIVED_DATE = "";
					$ADD_DATE =$this->common->getDate();
					$IPADDRESS = $this->common->getRealIpAddr();
					$this->db->query("insert into ACCOUNTING_DEBTORS_ACCOUNT(USER_ID,TRANSACTION_TYPE,DESCRIPTION,REMARK,RECEIVED_CASH,GIVEN_DEBT,REMAINING_DEBT,DEBT_GIVEN_DATE,CASH_RECEIVED_DATE,ADD_DATE,IPADDRESS) values (?,?,?,?,?,?,?,?,?,?,?)",array($USER_ID,$TRANSACTION_TYPE,$DESCRIPTION,$REMARK,$RECEIVED_CASH,$GIVEN_DEBT,$REMAINING_DEBT,$DEBT_GIVEN_DATE,$CASH_RECEIVED_DATE,$ADD_DATE,$IPADDRESS));
						$newid = $this->db->insert_id();
						$this->cashreceiveentry($RECEIVED_CASH,$USER_ID,$REMARK);
	}
	private function getbalance($user_id)	
	{
		$rslt = $this->db->query("select REMAINING_DEBT from ACCOUNTING_DEBTORS_ACCOUNT where USER_ID = ? order by Id desc limit 1",array($user_id));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->REMAINING_DEBT;
		}
		else
		{
			return 0;
		}
	}
	private function cashreceiveentry($RECEIVED_CASH,$ddluser,$txtRemark)
	{
		$cashOnHand = $this->getCashOnHand();
					$ACC_TYPE = "SALE";
					$SOURCE = "CASH_COLLECTION";
					$CASH_IN=$RECEIVED_CASH;
					$CASH_OUT=0;
					$REMAINING_CASH = $cashOnHand + $RECEIVED_CASH;
					$ADD_DATE = $this->common->getDate();
					$IPADDRESS = $this->common->getRealIpAddr();
					$DESCRIPTION="CASH_COLLECTION";
					$USER_ID=$ddluser;
					$REMARK=$txtRemark;
					$REFLECTING_DATE = $this->common->getDate();
					$this->db->query("insert into ACCOUNTING_CASHFLOW(ACC_TYPE,SOURCE,CASH_IN,CASH_OUT,REMAINING_CASH,ADD_DATE,IPADDRESS,DESCRIPTION,USER_ID,REMARK,REFLECTING_DATE) values(?,?,?,?,?,?,?,?,?,?,?) ",array($ACC_TYPE,$SOURCE,$CASH_IN,$CASH_OUT,$REMAINING_CASH,$ADD_DATE,$IPADDRESS,$DESCRIPTION,$USER_ID,$REMARK,$REFLECTING_DATE));
					return $this->db->insert_id();
	}
	private function getCashOnHand()	
	{
		$rslt = $this->db->query("select REMAINING_CASH from ACCOUNTING_CASHFLOW order by ID desc limit 1");
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->REMAINING_CASH;
		}
		else
		{
			return 0;
		}
	}
}
