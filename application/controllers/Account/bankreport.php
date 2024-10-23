<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bankreport extends CI_Controller {
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
			if($this->input->post("ddlbank") and $this->input->post("txtFrom") and $this->input->post("txtTo"))
			{
				$ddlbank = $this->input->post("ddlbank");
				$txtFrom = $this->input->post("txtFrom");
				$txtTo = $this->input->post("txtTo");
				
				
					$bankrslt = $this->db->query("select tblbankentryes.*,bank_name from tblbankentryes,tbluser_bank,tblbank where tblbank.bank_id = tbluser_bank.bank_id and tbluser_bank.user_bank_id = tblbankentryes.bankaccount_id and tblbankentryes.bankaccount_id = ? and Date(tblbankentryes.add_date) >= ? and Date(tblbankentryes.add_date) <= ?   order by tblbankentryes.Id",array($ddlbank,$txtFrom,$txtTo));
					//print_r($bankrslt->result());exit;
					$this->view_data["data"] = $bankrslt;
					$this->view_data["message"] = "";
					$this->view_data["ddlbank"] = $ddlbank;
					$this->view_data["txtFrom"] = $txtFrom;
					$this->view_data["txtTo"] = $txtTo;
					$this->load->view('Account/bankreport_view',$this->view_data);	
						
				
				
			}
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->view_data["data"] = "";
					$this->view_data["ddlbank"] = "";
					$this->view_data["txtFrom"] = "";
					$this->view_data["txtTo"] = "";
					$this->load->view('Account/bankreport_view',$this->view_data);		 		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
	}
}
