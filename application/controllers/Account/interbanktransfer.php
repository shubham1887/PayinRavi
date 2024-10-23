<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Interbanktransfer extends CI_Controller {
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
			if($this->input->post("ddlFromBankAccount") and $this->input->post("ddlToBankAccount") and $this->input->post("txtAmount"))
			{
				$ddlFromBankAccount = $this->input->post("ddlFromBankAccount");
				$ddlToBankAccount = $this->input->post("ddlToBankAccount");
				$txtAmount = $this->input->post("txtAmount");
				$description = $this->input->post("txtDesc");
				$remark = $description;
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				
				
					$rsltfrombank = $this->db->query("select tbluser_bank.*,bank_name from tbluser_bank,tblbank where tblbank.bank_id = tbluser_bank.bank_id and user_bank_Id = ?",array($ddlFromBankAccount));
					if($rsltfrombank->num_rows() == 1)
					{
					
						$rslttobank = $this->db->query("select tbluser_bank.*,bank_name from tbluser_bank,tblbank where tblbank.bank_id = tbluser_bank.bank_id and user_bank_Id = ?",array($ddlToBankAccount));
						if($rslttobank->num_rows() == 1)
						{
							$rslt_frombank_opening = $this->db->query("select balance from tblbankentryes where bankaccount_id = ? order by Id desc limit 1",array($ddlFromBankAccount));
							if($rslt_frombank_opening->num_rows() == 1)
							{$From_balance = $rslt_frombank_opening->row(0)->balance;}
							else
							{$From_balance = 0;}
							
							
							$rslt_tobank_opening = $this->db->query("select balance from tblbankentryes where bankaccount_id = ? order by Id desc limit 1",array($ddlToBankAccount));
							if($rslt_tobank_opening->num_rows() == 1)
							{$To_balance = $rslt_tobank_opening->row(0)->balance;}
							else
							{$To_balance = 0;}
							
							
							//credit bank entry
							$description = "Inter Bank Transfer From ".$rsltfrombank->row(0)->bank_name."  TO ".$rslttobank->row(0)->bank_name;
							$bankaccount_id = $ddlToBankAccount;
							$credit_amount = $txtAmount;
							$debit_amount = "0";
							$balance = $To_balance + $txtAmount;
							$transaction_date = "INTERBANKTRANSFER";
							$this->db->query("insert into tblbankentryes(description,bankaccount_id,credit_amount,debit_amount,balance,add_date,ipaddress,transaction_date) values( ?,?,?,?,?,?,?,?)",array($description,$bankaccount_id,$credit_amount,$debit_amount,$balance,$add_date,$ipaddress,$transaction_date));
							$ref_id = $this->db->insert_id();
							
							//debit bank entry
							$description = "Inter Bank Transfer From ".$rsltfrombank->row(0)->bank_name."  TO ".$rslttobank->row(0)->bank_name;
							$bankaccount_id = $ddlFromBankAccount;
							$credit_amount = $txtAmount;
							$debit_amount = "0";
							$balance = $From_balance - $txtAmount;
							$transaction_date = "INTERBANKTRANSFER";
							$this->db->query("insert into tblbankentryes(description,bankaccount_id,credit_amount,debit_amount,balance,add_date,ipaddress,transaction_date) values( ?,?,?,?,?,?,?,?)",array($description,$bankaccount_id,$credit_amount,$debit_amount,$balance,$add_date,$ipaddress,$transaction_date));
							$ref_id = $this->db->insert_id();
							redirect("Account/interbanktransfer");
						}
						
						
				
					
					}
					else
					{
						$this->view_data["message"] = "Invalid Bank";
						$this->view_data["date"] = $this->common->getMySqlDate();
						$this->load->view('Account/interbanktransfer_view',$this->view_data);		
					}
						
				
				
			}
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->load->view('Account/interbanktransfer_view',$this->view_data);		 		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
	}
}
