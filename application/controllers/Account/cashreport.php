<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cashreport extends CI_Controller {
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
		
			if($this->input->post("txtFrom") and $this->input->post("txtTo"))
			{
				$txtFrom = $this->input->post("txtFrom");
				$txtTo = $this->input->post("txtTo");
				
				
					$cashrslt = $this->db->query("select tblcashentry.* from tblcashentry where Date(tblcashentry.add_date) >= ? and Date(tblcashentry.add_date) <= ?   order by tblcashentry.Id",array($txtFrom,$txtTo));
					//print_r($bankrslt->result());exit;
					$this->view_data["data"] = $cashrslt;
					$this->view_data["message"] = "";
					$this->view_data["txtFrom"] = $txtFrom;
					$this->view_data["txtTo"] = $txtTo;
					$this->load->view('Account/cashreport_view',$this->view_data);	
						
				
				
			}
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->view_data["data"] = "";
					$this->view_data["txtFrom"] = "";
					$this->view_data["txtTo"] = "";
					$this->load->view('Account/cashreport_view',$this->view_data);		 		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
	}
}
