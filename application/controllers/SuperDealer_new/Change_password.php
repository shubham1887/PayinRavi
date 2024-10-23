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
			
			
			if(isset($_POST["CurrentPassword"]) and isset($_POST["NewPassword"]) and isset($_POST["ConfirmPassword"]))
			{
			   // print_r($this->input->post());exit;
			    /*
			    Array ( [hidID] => [txtOldPassword] => 123456 [txtNewPassword] => 123456 [txtCNewPassword] => 123456 [btnSubmit] => Submit )
			    */
				$oldPwd = trim($this->input->post("CurrentPassword",TRUE));
				$newPwd = $this->input->post("NewPassword",TRUE);
				$newCPwd = $this->input->post("ConfirmPassword",TRUE);
				
				if($newPwd == $newCPwd)
				{
				    if(strlen($newPwd) <= 20 and strlen($newPwd) >= 4)
        			{
        			    $user_id = $this->session->userdata("SdId",TRUE);
    				   
    				    $old_password_info = $this->db->query("select password from tblusers where user_id = ?",array($user_id));
    				    
    				    if($old_password_info->row(0)->password == $oldPwd)
    				    {
    				        $this->db->query("update tblusers set password = ? where  user_id = ?",array($newPwd,$user_id));
    				       
        				    $this->view_data['MESSAGEBOXTYPE'] ="success";
        				    $this->view_data['MESSAGEBOX'] ="Password change successfully.";
        					$this->view_data['message'] ="Password change successfully.";
        					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);		
            			
    				    }
    				    else
    				    {
    				        $this->view_data['MESSAGEBOXTYPE'] ="error";
        				    $this->view_data['MESSAGEBOX'] ="Old password does not match. Try Again!";
        					$this->view_data['message'] ="Old password does not match. Try Again!";
        					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);
    				    }    
        			}
        			else
        			{
        			    $this->view_data['MESSAGEBOXTYPE'] ="error";
    				    $this->view_data['MESSAGEBOX'] ="Too Long Password";
    					$this->view_data['message'] ="Too Long Password";
    					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);
        			}
				    
				}
				else
				{
				    $this->view_data['MESSAGEBOXTYPE'] ="error";
				    $this->view_data['MESSAGEBOX'] ="New Password and Comfirm Password does not match. Try Again!";
					$this->view_data['message'] ="Old password does not match. Try Again!";
					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);
				}
				
			}
			else if(isset($_POST["Item2_OldPin"]) and isset($_POST["Item2_NewPin"]) and isset($_POST["Item2_ConfirmPin"]))
			{
			   // print_r($this->input->post());exit;
			    /*
			    Array ( [hidID] => [txtOldPassword] => 123456 [txtNewPassword] => 123456 [txtCNewPassword] => 123456 [btnSubmit] => Submit )
			    */
				$oldPwd = trim($this->input->post("Item2_OldPin",TRUE));
				$newPwd = $this->input->post("Item2_NewPin",TRUE);
				$newCPwd = $this->input->post("Item2_ConfirmPin",TRUE);
				
				if($newPwd == $newCPwd)
				{
				    if(strlen($newPwd) <= 8 and strlen($newPwd) >= 4)
        			{
        			    $user_id = $this->session->userdata("SdId",TRUE);
    				   
    				    $old_password_info = $this->db->query("select txn_password from tblusers where user_id = ?",array($user_id));
    				    
    				    if($old_password_info->row(0)->txn_password == $oldPwd)
    				    {
    				        $this->db->query("update tblusers set txn_password = ? where  user_id = ?",array($newPwd,$user_id));
    				       
        				    $this->view_data['MESSAGEBOXTYPE'] ="success";
        				    $this->view_data['MESSAGEBOX'] ="Pin change successfully.";
        					$this->view_data['message'] ="Pin change successfully.";
        					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);		
            			
    				    }
    				    else
    				    {
    				        $this->view_data['MESSAGEBOXTYPE'] ="FAILURE";
        				    $this->view_data['MESSAGEBOX'] ="Old Pin does not match. Try Again!";
        					$this->view_data['message'] ="Old password does not match. Try Again!";
        					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);
    				    }    
        			}
        			else
        			{
        			    $this->view_data['MESSAGEBOXTYPE'] ="FAILURE";
    				    $this->view_data['MESSAGEBOX'] ="Too Long Pin";
    					$this->view_data['message'] ="Too Long Pin";
    					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);
        			}
				    
				}
				else
				{
				    $this->view_data['MESSAGEBOXTYPE'] ="FAILURE";
				    $this->view_data['MESSAGEBOX'] ="New Password and Comfirm Password does not match. Try Again!";
					$this->view_data['message'] ="Old password does not match. Try Again!";
					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);
				}
				
			}
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'MasterDealer')
				{
					$this->view_data['message'] ="";
					$this->load->view('SuperDealer_new/change_password_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}