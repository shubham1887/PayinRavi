<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Arrangebankwiseentry extends CI_Controller {

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
		else if($this->input->post("btnAdd"))
		{
			$ddlaccount = $this->input->post("ddlaccount");
			$txtKeyword = $this->input->post("txtKeyword");
			$ddldebtorcreditor = explode("_",$this->input->post("ddldebtorcreditor"))[1];
			$txtRemark = $this->input->post("txtRemark");
			$type = explode("_",$this->input->post("ddldebtorcreditor"))[0];
			if($type == "DEBT")
			{
				$debtor_id = $ddldebtorcreditor;
				$entry_type = "deposit";
				$creditor_id = 0;
				$expence_id = 0;
			}
			if($type == "CRED")
			{
				$debtor_id = 0;
				$expence_id = 0;
				$entry_type = "withdrawal";
				$creditor_id = $ddldebtorcreditor;
			}
			if($type == "EXP")
			{
				$debtor_id = 0;
				$creditor_id = 0;
				$entry_type = "expanse";
				$expence_id = $ddldebtorcreditor;
			}
			
			$this->db->query("insert into tblkeyfilter(bank_account_id,keyword,type,debtor_id,creditor_id,expence_id,add_date,ipaddress,host_name,user_id) values(?,?,?,?,?,?,?,?,?,?)",array($ddlaccount,$txtKeyword,$entry_type,$debtor_id,$creditor_id,$expence_id,$this->common->getDate(),$this->common->getRealIpAddr(),"account.quickapp.in",1));
			
			redirect(base_url()."Admin/arrangebankwiseentry");
			
		}
		else
		{
			$rslt_keyfilter = $this->db->query("SELECT a.Id,a.bank_account_id,a.keyword,a.type,a.debtor_id,a.creditor_id,a.add_date,a.ipaddress,a.host_name,a.user_id,b.Account_Name as BankAccountName,d.Name as DebtorName,e.Name as CreditorName,exp.Name as exp_name FROM `tblkeyfilter` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	 order by a.Id");
			$this->view_data["data"] = $rslt_keyfilter;
		
		
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/arrangebankwiseentry_view",$this->view_data);
		}
		
	}
	
}

