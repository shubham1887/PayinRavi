<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bankentry extends CI_Controller {
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
		//print_r($this->input->post());exit;
			if($this->input->post("ddlcashtransactiontype") and $this->input->post("txtAmount") and $this->input->post("ddlBankAccount") and $this->input->post("ddlPayee"))
			{
				$ddlcashtransactiontype = $this->input->post("ddlcashtransactiontype");
				$transaction_date = $this->input->post("txtDate");
				$txtAmount = $this->input->post("txtAmount");
				$ddlmode = $this->input->post("ddlmode");
				$bankaccount_id = $this->input->post("ddlBankAccount");
				//echo $this->getBankalance($bankaccount_id);exit;
				$ddlPayee = $this->input->post("ddlPayee");
				$user_id =$ddlPayee; 
				$description = $this->input->post("txtDesc");
				$remark = $description;
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				$rsltpayee = $this->db->query("select * from ACCOUNTING_DEBTORS_ACCOUNT where USER_ID = ?",array($ddlPayee));
				if($rsltpayee->num_rows() >= 1)
				{
					$rsltacc = $this->db->query("select tbluser_bank.*,bank_name from tbluser_bank,tblbank where tblbank.bank_id = tbluser_bank.bank_id and user_bank_Id = ?",array($bankaccount_id));
					//print_r($rsltacc->result());exit;
					if($rsltacc->num_rows() == 1)
					{
						
						
						if($ddlcashtransactiontype == "CashIN")
						{
							$credit_amount = $txtAmount;
							$debit_amount = 0;
						
							$this->accounting_entry_cashbank($user_id,$remark,$credit_amount,"","BANK",$bankaccount_id,$ddlmode);
							
							$this->view_data["message"] = "Insertion Successful";
							$this->view_data["date"] = $this->common->getMySqlDate();
							$this->load->view('Account/bankentry_view',$this->view_data);	
						}
						else if($ddlcashtransactiontype == "CashOut")
						{
							$credit_amount = 0;
							$debit_amount = $txtAmount;
							$balance = $balance - $debit_amount;
							$userbalance = $userbalance + $debit_amount;
							$transaction_type = "bank";
							
							$this->db->query("insert into tblbankentryes(description,bankaccount_id,credit_amount,debit_amount,balance,add_date,ipaddress,transaction_date) values( ?,?,?,?,?,?,?,?)",array($description,$bankaccount_id,$credit_amount,$debit_amount,$balance,$add_date,$ipaddress,$transaction_date));
							$ref_id = $this->db->insert_id();
							
							$this->db->query("insert into tblusercreditdebit(user_id,credit_amount,debit_amount,balance,	transaction_type,add_date,ipaddress,remark,ref_id) values( ?,?,?,?,?,?,?,?,?)",array($user_id,$debit_amount,$credit_amount,$userbalance,$transaction_type,$add_date,$ipaddress," ".$remark,$ref_id,$user_id));
							$this->view_data["message"] = "Insertion Successful";
							$this->view_data["date"] = $this->common->getMySqlDate();
							$this->load->view('Account/bankentry_view',$this->view_data);	
						}
				
					
					}
					else
					{
						$this->view_data["message"] = "Invalid Bank";
						$this->view_data["date"] = $this->common->getMySqlDate();
						$this->load->view('Account/bankentry_view',$this->view_data);		
					}
						
				}
				else
				{
					$this->view_data["message"] = "Invalid User";
					$this->view_data["date"] = $this->common->getMySqlDate();
					$this->load->view('Account/bankentry_view',$this->view_data);		
				}
				
			}
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->load->view('Account/bankentry_view',$this->view_data);		 		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
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
	private function getBankalance($bankaccount_id)	
	{
		$rsltopeningcash = $this->db->query("select REMAINING_BALANCE from ACCOUNT_BANKFLOW where BANK_ID = ? order by Id desc limit 1 ",array($bankaccount_id));
		if($rsltopeningcash->num_rows() == 1)
		{
			$balance = $rsltopeningcash->row(0)->REMAINING_BALANCE;
			return $balance;
		}
		else
		{
			return 0;
		}
	}
	private function accounting_entry_cashbank($user_id,$txtRemark,$txtAmount,$ewid,$transaction_type,$bank_id,$ddlmode)
	{
					
					$balance = $this->getbalance($user_id);
					$USER_ID = $user_id;
					$TRANSACTION_TYPE = $transaction_type;
					$DESCRIPTION=$ddlmode."  ".$this->getbankname($bank_id);
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
					$this->cashreceiveentry($RECEIVED_CASH,$USER_ID,$REMARK,$bank_id,$ddlmode);
	}
	private function cashreceiveentry($RECEIVED_CASH,$ddluser,$txtRemark,$bank_id,$ddlmode)
	{
					$Bankalance = $this->getBankalance($bank_id);
					$USER_ID=$ddluser;
					$BANK_ID = $bank_id;
					$TRANSACTION_TYPE = $ddlmode;
			
					$ACC_TYPE = "SALE";
					$SOURCE = "CASH_COLLECTION";
					$CASH_IN=$RECEIVED_CASH;
					$CASH_OUT=0;
					$REMAINING_BALANCE = $Bankalance + $RECEIVED_CASH;
					$REMARK=$txtRemark;
					$DESCRIPTION="CASH_COLLECTION :".$ddlmode;
					$ADD_DATE = $EDIT_DATE = $this->common->getDate();
					$IPADDRESS = $this->common->getRealIpAddr();
					
					
					$this->db->query("insert into ACCOUNT_BANKFLOW(USER_ID,BANK_ID,TRANSACTION_TYPE,	CASH_IN,CASH_OUT,REMAINING_BALANCE,REMARK,DESCRIPTION,ADD_DATE,EDIT_DATE,IPADDRESS) values(?,?,?,?,?,?,?,?,?,?,?) ",array($USER_ID,$BANK_ID,$TRANSACTION_TYPE,	$CASH_IN,$CASH_OUT,$REMAINING_BALANCE,$REMARK,$DESCRIPTION,$ADD_DATE,$EDIT_DATE,$IPADDRESS));
					return $this->db->insert_id();
	}
	private function getbankname($bank_id)
	{
		$rsltacc = $this->db->query("select tbluser_bank.*,bank_name from tbluser_bank,tblbank where tblbank.bank_id = tbluser_bank.bank_id and user_bank_Id = ?",array($bank_id));
		if($rsltacc->num_rows() == 1)
		{
			return $rsltacc->row(0)->bank_name;
		}
		else
		{
			return "";
		}
	}
}
