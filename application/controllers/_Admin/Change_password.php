<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends CI_Controller {
			
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ausertype') != "Admin") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				$oldPwd = $this->input->post("txtOldPassword",TRUE);
				$newPwd = $this->input->post("txtNewPassword",TRUE);								
				$user_id = $this->session->userdata("adminid",TRUE);
				$this->load->model('Change_password_model');
				if($this->Change_password_model->update($oldPwd,$newPwd,$user_id) == true)
				{
					$this->view_data['message'] ="Password change successfully.";
					$this->load->view('Distributor/change_password_view',$this->view_data);		
				}
				else
				{
					$this->view_data['message'] ="Old password does not match. Try Again!";
					$this->load->view('_Admin/change_password_view',$this->view_data);		
				}
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$this->view_data['message'] ="";
					$this->load->view('_Admin/change_password_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}