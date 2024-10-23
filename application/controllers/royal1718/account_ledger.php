<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account_ledger extends CI_Controller {

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
			

			
			
			$user_id = $ddldebtor;
			$rslt_bank_ledger = $this->db->query("SELECT a.Id,a.EwId,a.payment_id,a.remark,a.description,a.Ew_add_date,a.credit_amount,a.debit_amount,a.balance,a.ew_user_id,
			d.Name as DebtorName
			FROM `tblsales` a
	left join tbldebtors d on a.ew_user_id = d.user_id
	
	where d.Id = ? and Date(a.Ew_add_date) >= ? and Date(a.Ew_add_date) <= ? and a.remark NOT LIKE  'Flat Commission%'
	order by a.payment_id",array($user_id,$txtFromDate,$txtToDate));
			$this->view_data["data"] = $rslt_bank_ledger;
			
			
			$totalcredit  = 0.00;
			$totaldebit = 0.00;
			
			
			$rsltsummation = $this->db->query("select Sum(a.credit_amount) as totalcredit ,Sum(a.debit_amount) as totaldebit from tblsales a
			left join tbldebtors d on a.Ew_user_id = d.user_id  
			where d.Id = ?  and Date(a.Ew_add_date) >= ? and Date(a.Ew_add_date) <= ? and a.remark NOT LIKE  'Flat Commission%'",array($user_id,$txtFromDate,$txtToDate));
			//print_r(	$rsltsummation->result());exit;
			if($rsltsummation->num_rows() == 1)
			{
				$totalcredit = $rsltsummation->row(0)->totalcredit;
				$totaldebit = $rsltsummation->row(0)->totaldebit;
			}
		
			$this->view_data["totalcredit"] = $totalcredit;
			$this->view_data["totaldebit"] = $totaldebit;
			
			$this->view_data["from"] = $txtFromDate;
			$this->view_data["to"] = $txtToDate;
			$this->view_data["ddldebtor"] = $ddldebtor;
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/account_ledger_view",$this->view_data);
			
		}
		else
		{
			
			$today_date = $this->common->getMySqlDate();
			$rslt_bank_ledger = $this->db->query("SELECT a.Id,a.EwId,a.payment_id,a.remark,a.description,a.Ew_add_date,a.credit_amount,a.debit_amount,a.balance,a.ew_user_id,
			d.Name as DebtorName
			FROM `tblsales` a
	left join tbldebtors d on a.ew_user_id = d.user_id
	
	where Date(a.Ew_add_date) = ?
	order by a.payment_id",array($today_date));
			$this->view_data["data"] = $rslt_bank_ledger;
			
			
			$totalcredit  = 0.00;
			$totaldebit = 0.00;
			
			
			$rsltsummation = $this->db->query("select Sum(credit_amount) as totalcredit ,Sum(debit_amount) as totaldebit from tblsales where Date(Ew_add_date) = ?",array($today_date));
			if($rsltsummation->num_rows() == 1)
			{
				$totalcredit = $rsltsummation->row(0)->totalcredit;
				$totaldebit = $rsltsummation->row(0)->totaldebit;
			}
		
			$this->view_data["totalcredit"] = $totalcredit;
			$this->view_data["totaldebit"] = $totaldebit;
			
			$this->view_data["from"] = $today_date;
			$this->view_data["to"] = $today_date;
			$this->view_data["ddldebtor"] = 'ALL';
			
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/account_ledger_view",$this->view_data);
		}
		
	}
	
}

