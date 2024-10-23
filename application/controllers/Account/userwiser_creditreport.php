<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Userwiser_creditreport extends CI_Controller {
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
			if($this->input->post("ddluser") and $this->input->post("txtFrom") and $this->input->post("txtTo"))
			{
				$ddluser = $this->input->post("ddluser");
				$txtFrom = $this->input->post("txtFrom");
				$txtTo = $this->input->post("txtTo");
				
				$rsltpayee = $this->db->query("select * from tbldebtors where user_id = ?",array($ddluser));
				if($rsltpayee->num_rows() == 1)
				{
					
					
					$rsltuserbalance = $this->db->query("select tblusercreditdebit.* from tblusercreditdebit where user_id = ? order by Id ",array($ddluser));
					$this->view_data["data"] = $rsltuserbalance;
					$this->view_data["message"] = "";
					$this->load->view('Account/userwiser_creditreport_view',$this->view_data);	
						
				}
				
			}
			else
			{
				$user=$this->session->userdata('auser_type');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->view_data["data"] = "";
					$this->load->view('Account/userwiser_creditreport_view',$this->view_data);		 		
				}
				else
				{redirect(base_url().'login');}
			}
			
		} 
	}
}
