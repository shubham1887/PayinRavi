<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends CI_Controller {
			
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
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
					redirect("/change_password");
				}
				
				
				$oldPwd = $this->input->post("txtOldPassword",TRUE);
				$newPwd = $this->input->post("txtNewPassword",TRUE);								
				$user_id = $this->session->userdata("SdId",TRUE);
		
			   
				$rsltcheck = $this->db->query("select * from tblusers where user_id = ? and password = ?",array($user_id,$oldPwd));
				if($rsltcheck->num_rows() == 1)
				{
				    $result = $this->db->query("update tblusers set password = ? where user_id = ? ",array($newPwd,$user_id));    
				    $this->view_data['message'] ="Password change successfully.";
				    $this->load->view('SuperDealer/change_password_view',$this->view_data);		
				}
				else
				{
				    redirect(base_url()."SuperDealer/change_password");
				}
				
			
				
				
			}
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
				{
					$this->view_data['message'] ="";
					$this->load->view('SuperDealer/change_password_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}