<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Creditor_list extends CI_Controller {

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
		if($this->input->post("Id") and $this->input->post("did") and $this->input->post("class") )
		{
			
			$Id = trim($this->input->post("Id"));
			$did = trim($this->input->post("did"));
			$class = trim($this->input->post("class"));
			$Remark = trim($this->input->post("Remark"));
			if($class == "row2")
			{
				$this->db->query("update tblBankLedger set debtor_id = ?,Remark = ? where Id = ?",array($did,$Remark,$Id));
			}
			else
			{
				$this->db->query("update tblBankLedger set creditor_id = ?,Remark = ? where Id = ?",array($did,$Remark,$Id));
			}
			
			echo "Success";exit;
		}
		else if($this->input->post("btnSearch"))
		{
			$ddldebtor = $this->input->post("ddldebtor");
			$txtFromDate = $this->input->post("txtFromDate");
			$txtToDate = $this->input->post("txtToDate");
			
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				b.Account_Name as accountName,
				exp.Name as exp_name
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id where a.debtor_id = ?
	order by Date(a.transaction_date)
	",array($ddldebtor));
	
	
	$totalsums = $this->db->query("SELECT IFNULL(Sum(a.Deposit),0) as total
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id where a.debtor_id = ?
	order by Date(a.transaction_date)
	",array($ddldebtor));
	$totaldeposit = 0.00;
	if($totalsums->num_rows() == 1)
	{
		$totaldeposit = $totalsums->row(0)->total;
	}
			$this->view_data["totaldeposit"] = $totaldeposit;
			$this->view_data["data"] = $rslt_bank_ledger;
			$this->view_data["from"] = $txtFromDate;
			$this->view_data["to"] = $txtToDate;
			$this->view_data["ddldebtor"] = $ddldebtor;

			$this->load->view("Admin/debtor_ledger_view",$this->view_data);	
			
		}
		else
		{
			$debtorrslt = $this->db->query("SELECT a.Id,a.Name,a.ref_username,a.add_date,a.mobile_no,a.Address,a.user_id,
			b.opening_outstanding,
			b.opening_date,
			(select IFNULL(Sum(sales.credit_amount),0)   from tblpurchase sales where sales.creditor_id = a.Id ) as totalcredit,
			(select IFNULL(Sum(sales_d.debit_amount),0)   from tblpurchase sales_d where sales_d.creditor_id = a.Id ) as totaldebit,
			(select IFNULL(Sum(bank.Withdrawal),0)   from tblBankLedger bank where bank.creditor_id = a.Id and bank.transaction_date >='2018-01-01' ) as totaldeposit,
			(select IFNULL(Sum(bank.Deposit),0)   from tblBankLedger bank where bank.creditor_id = a.Id and bank.transaction_date >='2018-01-01' ) as totaldeposit_reverse
			
			FROM tblcreditors a 
			left join drcropening b on a.Id = b.crdruser_id and b.user_type = 'CREDITOR'
			
			ORDER BY a.Id");
			$this->view_data["data"] = $debtorrslt;
		
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["description"] = "";
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/creditor_list_view",$this->view_data);
		}
		
	}
	
}

