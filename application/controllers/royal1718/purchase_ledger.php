<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_ledger extends CI_Controller {

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
		if($this->input->post("btnSearch"))
		{
			$ddlcreditor = $this->input->post("ddlcreditor");
			$txtFromDate = $this->input->post("txtFromDate");
			$txtToDate = $this->input->post("txtToDate");
			
			
			$rslt_bank_ledger = $this->db->query("SELECT a.Id,a.EwId,a.payment_id,a.remark,a.description,a.Ew_add_date,a.credit_amount,a.debit_amount,a.balance,a.ew_user_id,a.creditor_id,
			d.Name as CreditorName
			FROM `tblpurchase` a
	left join tblcreditors d on a.creditor_id = d.Id
	
	where Date(a.Ew_add_date) >= ? and Date(a.Ew_add_date) <= ? 
	and 
	if(? != 'ALL',a.creditor_id = ?,true)
	order by a.payment_id",array($txtFromDate,$txtToDate,$ddlcreditor,$ddlcreditor));
			$this->view_data["data"] = $rslt_bank_ledger;
			
			
			$totalcredit  = 0.00;
			$totaldebit = 0.00;
			
			
			$rsltsummation = $this->db->query("select Sum(credit_amount) as totalcredit ,Sum(debit_amount) as totaldebit from tblpurchase where Date(Ew_add_date) >= ? and Date(Ew_add_date) <= ? and if(? != 'ALL',creditor_id = ?,true)",array($txtFromDate,$txtToDate,$ddlcreditor,$ddlcreditor));
			if($rsltsummation->num_rows() == 1)
			{
				$totalcredit = $rsltsummation->row(0)->totalcredit;
				$totaldebit = $rsltsummation->row(0)->totaldebit;
			}
		
			$this->view_data["totalcredit"] = $totalcredit;
			$this->view_data["totaldebit"] = $totaldebit;
			
			$this->view_data["from"] = $txtFromDate;
			$this->view_data["to"] = $txtToDate;
			
			$this->load->view("Admin/purchase_ledger_view",$this->view_data);
			
		}
		else
		{
			$today_date = $this->common->getMySqlDate();
			$rslt_bank_ledger = $this->db->query("SELECT a.Id,a.EwId,a.payment_id,a.remark,a.description,a.Ew_add_date,a.credit_amount,a.debit_amount,a.balance,a.ew_user_id,a.creditor_id,
			d.Name as CreditorName
			FROM `tblpurchase` a
	left join tblcreditors d on a.creditor_id = d.Id
	
	where Date(a.Ew_add_date) = ?
	order by a.payment_id",array($today_date));
			$this->view_data["data"] = $rslt_bank_ledger;
			
			
			$totalcredit  = 0.00;
			$totaldebit = 0.00;
			
			
			$rsltsummation = $this->db->query("select Sum(credit_amount) as totalcredit ,Sum(debit_amount) as totaldebit from tblpurchase where Date(Ew_add_date) = ?",array($today_date));
			if($rsltsummation->num_rows() == 1)
			{
				$totalcredit = $rsltsummation->row(0)->totalcredit;
				$totaldebit = $rsltsummation->row(0)->totaldebit;
			}
		
			$this->view_data["totalcredit"] = $totalcredit;
			$this->view_data["totaldebit"] = $totaldebit;
			
			$this->view_data["from"] = $today_date;
			$this->view_data["to"] = $today_date;
			
			$this->load->view("Admin/purchase_ledger_view",$this->view_data);
		}
		
	}
	
}

