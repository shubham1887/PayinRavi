<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bank_ledger extends CI_Controller {

    function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if($this->session->userdata('Adminusertype') != "ADMIN") 
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
		if($this->input->post("ddlpopupdebtorcreditor") and $this->input->post("txtPRemark") and $this->input->post("hidpopupid") )
		{
			
			$Id = trim($this->input->post("hidpopupid"));
			$ddldebtorcreditor = explode("_",$this->input->post("ddlpopupdebtorcreditor"))[1];
			$type = explode("_",$this->input->post("ddlpopupdebtorcreditor"))[0];
			
			
			$Remark = trim($this->input->post("txtPRemark"));
			if($type == "DEBT")
			{
				$debtor_id = $ddldebtorcreditor;
				$entry_type = "deposit";
				$creditor_id = 0;
				$expence_id = 0;
				$this->db->query("update tblBankLedger set debtor_id = ?,creditor_id=?,expence_id=?,Remark = ? where Id = ?",array($debtor_id,$creditor_id,$expence_id,$Remark,$Id));
			}
			if($type == "CRED")
			{
				$debtor_id = 0;
				$expence_id = 0;
				$entry_type = "withdrawal";
				$creditor_id = $ddldebtorcreditor;
				$this->db->query("update tblBankLedger set debtor_id = ?,creditor_id=?,expence_id=?,Remark = ? where Id = ?",array($debtor_id,$creditor_id,$expence_id,$Remark,$Id));
			}
			if($type == "EXP")
			{
				$debtor_id = 0;
				$creditor_id = 0;
				$entry_type = "expanse";
				$expence_id = $ddldebtorcreditor;
				$this->db->query("update tblBankLedger set debtor_id = ?,creditor_id=?,expence_id=?,Remark = ? where Id = ?",array($debtor_id,$creditor_id,$expence_id,$Remark,$Id));
			}
			echo "Success";
		}
		else if($this->input->post("btnSearch"))
		{
			$ddlType = $this->input->post("ddlType");
			$txtFromDate = $this->input->post("txtFromDate");
			$txtToDate = $this->input->post("txtToDate");
			$ddlaccount = trim($this->input->post("ddlaccount"));
			$txtDescription = $this->input->post("txtDescription");
			
			if($ddlType == "DEPOSIT")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id 
	where 
	(a.Deposit > 0 and a.expence_id <=0)  and 
	b.Id = ? and
	Date(a.transaction_date) >= ? and Date(a.transaction_date) <= ?
	order by a.Id,Date(a.transaction_date)
	",array($ddlaccount,$txtFromDate,$txtToDate));
				
			}
			else if($ddlType == "WITHDRAWAL")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Details,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id where a.Withdrawal > 0 and a.expence_id <=0  
	and b.Id = ?
	 and
	Date(a.transaction_date) >= ? and Date(a.transaction_date) <= ?
	order by a.Id,Date(a.transaction_date)
	",array($ddlaccount,$txtFromDate,$txtToDate));
			
			}
			else if($ddlType == "EXPANSE")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Details,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id where  a.expence_id > 0  and b.Id = ?
	order by a.Id,a.transaction_date",array($ddlaccount));
			
			}
			
			else if($ddlType == "ALL")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Details,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name
				FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblbankName c on b.bank_id = c.Id  
	left join tblexpences exp on a.expence_id = exp.Id
	where
	 b.Id = ?  and
	Date(a.transaction_date) >= ? and Date(a.transaction_date) <= ?
	order by a.Id,Date(a.transaction_date)
	",array($ddlaccount,$txtFromDate,$txtToDate));
				
			}
			else if($ddlType == "BLANK")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Details,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name
				FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblbankName c on b.bank_id = c.Id  
	left join tblexpences exp on a.expence_id = exp.Id
	where
	 b.Id = ?  and 
	Date(a.transaction_date) >= ? and Date(a.transaction_date) <= ?
	and a.debtor_id <= 0 and a.creditor_id <= 0  and a.expence_id <= 0
	order by a.Id,Date(a.transaction_date)
	",array($ddlaccount,$txtFromDate,$txtToDate));
				
			}
			
			
			$this->view_data["data"] = $rslt_bank_ledger;
			$this->view_data["from"] = $txtFromDate;
			$this->view_data["to"] = $txtToDate;
			$this->view_data["ddlType"] = $ddlType;
			$this->view_data["ddlaccount"] = $ddlaccount;
			
			$this->view_data["description"] = $txtDescription;
			$this->load->view("Admin/bank_ledger_view",$this->view_data);	
			
		}
		else
		{
			$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Details,a.Remark,a.expence_id,
			d.Name as DebtorName,
			e.Name as creditor_name,
			exp.Name as exp_name
			FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblbankName c on b.bank_id = c.Id
	left join tblexpences exp on a.expence_id = exp.Id
	where b.Id = ?
	order by a.Id,transaction_date",array(0));
			$this->view_data["data"] = $rslt_bank_ledger;
		
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["description"] = "";
			$this->view_data["ddlaccount"] = "";
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/bank_ledger_view",$this->view_data);
		}
		
	}
	
}

