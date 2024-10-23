<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends CI_Controller {
			
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				if($this->session->userdata('ReadOnly') == true)
				{
					$this->session->set_flashdata('message', 'Read Only Mode Enabled');	
					redirect("MasterDealer/change_password");
				}
				$oldPwd = $this->input->post("txtOldPassword",TRUE);
				$newPwd = $this->input->post("txtNewPassword",TRUE);								
				$user_id = $this->session->userdata("DistId",TRUE);
				$this->load->model('Change_password_model');
				if($this->Change_password_model->update($oldPwd,$newPwd,$user_id) == true)
				{
					$this->view_data['message'] ="Password change successfully.";
					$this->load->view('MasterDealer/change_password_view',$this->view_data);		
				}
				else
				{
					$this->view_data['message'] ="Old password does not match. Try Again!";
					$this->load->view('MasterDealer/change_password_view',$this->view_data);		
				}
			}
			else
			{
				$user=$this->session->userdata('MdUserType');
				if(trim($user) == 'MasterDealer')
				{
					$this->view_data['message'] ="";
					$this->load->view('MasterDealer/change_password_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}