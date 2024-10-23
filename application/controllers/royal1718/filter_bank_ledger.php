<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Filter_bank_ledger extends CI_Controller {

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
			$ddlType = $this->input->post("ddlType");
			$txtFromDate = $this->input->post("txtFromDate");
			$txtToDate = $this->input->post("txtToDate");
			$ddlaccount = trim($this->input->post("ddlaccount"));
			$ddldebtcrdexp_id = explode("_",$this->input->post("ddldebtcrdexp"))[1];
			$debtcrd_type = explode("_",$this->input->post("ddldebtcrdexp"))[0];
			
			if($debtcrd_type == "DEBT")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name,
				b.Account_Name
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id 
	where 
	Date(a.transaction_date) >= ? and 
	Date(a.transaction_date) <= ? and
	a.debtor_id = ?
	
	order by Date(a.transaction_date)
	",array($txtFromDate,$txtToDate,$ddldebtcrdexp_id));
			}
			else if($debtcrd_type == "CRED")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name,
				b.Account_Name
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id 
	where 
	Date(a.transaction_date) >= ? and 
	Date(a.transaction_date) <= ? and
	a.creditor_id = ?
	
	order by Date(a.transaction_date)
	",array($txtFromDate,$txtToDate,$ddldebtcrdexp_id));
			}
			else if($debtcrd_type == "EXP")
			{
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name,
				b.Account_Name
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id 
	where 
	Date(a.transaction_date) >= ? and 
	Date(a.transaction_date) <= ? and
	a.expence_id = ?
	
	order by Date(a.transaction_date)
	",array($txtFromDate,$txtToDate,$ddldebtcrdexp_id));
			}
			else
			{
					
				$rslt_bank_ledger = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name,
				b.Account_Name
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id 
	where 
	Date(a.transaction_date) >= ? and 
	Date(a.transaction_date) <= ? 
	
	order by Date(a.transaction_date)
	",array($txtFromDate,$txtToDate));
			
			}
			
			
				
				
			
			
			
			
			$this->view_data["data"] = $rslt_bank_ledger;
			$this->view_data["from"] = $txtFromDate;
			$this->view_data["to"] = $txtToDate;
			$this->view_data["ddlType"] = $ddlType;
			$this->view_data["ddlaccount"] = $ddlaccount;
		    $this->view_data["ddldebtcrdexp_id"] = $ddldebtcrdexp_id;
			
			$this->view_data["description"] = $txtDescription;
			$this->load->view("Admin/filter_bank_ledger_view",$this->view_data);	
			
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
	order by transaction_date",array(0));
			$this->view_data["data"] = $rslt_bank_ledger;
			$this->view_data["from"] = "";
			$this->view_data["to"] = "";
			$this->view_data["description"] = "";
			$this->view_data["ddlaccount"] = "";
			$this->view_data["ddlType"] = "ALL";
			$this->load->view("Admin/filter_bank_ledger_view",$this->view_data);
		}
		
	}
	public function dataexport()
	{
	   
		
		if(isset($_GET["from"]) and isset($_GET["to"]))
		{
			ini_set('memory_limit', '-1');
			$from = trim($_GET["from"]);
			$to = trim($_GET["to"]);
		
			$ddldebtcrdexp_id = explode("_",$this->input->get("debtcrdexp_id"))[1];
			$debtcrd_type = explode("_",$this->input->post("debtcrdexp_id"))[0];
			
			
		//	echo $ddldebtcrdexp_id ;exit;
		//	echo $ddldebtcrdexp_id;exit;
			$data = array();
			
			$rslt = $this->db->query("SELECT a.creditor_id,a.debtor_id,c.Name,a.Id,a.transaction_date,a.Withdrawal,a.Deposit,a.Balance,a.Narration,a.Details,a.Remark,a.expence_id,
				d.Name as DebtorName,
				e.Name as creditor_name,
				exp.Name as exp_name,
				b.Account_Name
				
				 FROM `tblBankLedger` a
	left join tblbankdetail b on a.bank_account_id = b.Id
	left join tbldebtors d on a.debtor_id = d.Id
	left join tblcreditors e on a.creditor_id = e.Id
	left join tblexpences exp on a.expence_id = exp.Id
	left join tblbankName c on b.bank_id = c.Id 
	where 
	Date(a.transaction_date) >= ? and 
	Date(a.transaction_date) <= ? and
	a.creditor_id = ?
	
	order by Date(a.transaction_date)
	",array($from,$to,$ddldebtcrdexp_id));
	//	print_r($rslt->result());exit;	
				
		$i = 1;
		foreach($rslt->result() as $rw)
		{
			
			
			
			$temparray = array(
			
									"Sr" =>  $i, 
									"Account_Name" => $rw->Account_Name, 
									"Remark" => $rw->Remark, 
									"creditor_name" =>$rw->creditor_name, 
									"Id" =>$rw->Id, 
									"transaction_date" =>$rw->transaction_date, 
									"Withdrawal" =>$rw->Withdrawal, 
									"Deposit" =>$rw->Deposit, 
									"Balance" =>$rw->Balance, 
									"Details" => $rw->Details, 
									"Narration" =>$rw->Narration, 
									
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
    $fileName = "banl ledger From ".$from." To  ".$to.".xls";
    
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
	
}

