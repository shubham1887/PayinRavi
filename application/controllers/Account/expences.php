<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expences extends CI_Controller {
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
			if($this->input->post("ddlExpType") and $this->input->post("txtAmount"))
			{
				$ddlExpType = $this->input->post("ddlExpType");
				$txtAmount = $this->input->post("txtAmount");
				$description = $this->input->post("txtDesc");
				$remark = $description;
				$add_date = $this->common->getDate();
				$ipaddress = $this->common->getRealIpAddr();
				
				
					$rsltexptype = $this->db->query("select * from expencetype where Id = ?",array($ddlExpType));
					if($rsltexptype->num_rows() == 1)
					{
						$rsltopeningcash = $this->db->query("select balance from tblcashentry order by Id desc limit 1");
						if($rsltopeningcash->num_rows() == 1)
						{$balance = $rsltopeningcash->row(0)->balance;}
						else
						{$balance = 0;}
						
						$credit_amount = 0;
						$debit_amount = $txtAmount;
						$balance = $balance - $debit_amount;
						$this->db->query("insert into tblcashentry(description,credit_amount,debit_amount,balance,add_date,ipaddress) values( ?,?,?,?,?,?) ",array($description,$credit_amount,$debit_amount,$balance,$add_date,$ipaddress));
						
						$this->db->query("insert into tblexpences(	exp_id,amount,add_date,ipaddress,description) values( ?,?,?,?,?)",array($ddlExpType,$txtAmount,$add_date,$ipaddress,$description));
						
						redirect("Account/expences");
					}
					else
					{
						$this->view_data["message"] = "Invalid Bank";
						$this->view_data["date"] = $this->common->getMySqlDate();
						$this->load->view('Account/expences_view',$this->view_data);		
					}
						
				
				
			}
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->load->view('Account/expences_view',$this->view_data);		 		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
	}
}
