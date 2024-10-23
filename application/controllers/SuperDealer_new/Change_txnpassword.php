<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_txnpassword extends CI_Controller {
			
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
			if(isset($_POST["CurrentTPIN"]) and isset($_POST["NewTPIN"]) and isset($_POST["ConfirmTPIN"]))
			{
				//CurrentTPIN,NewTPIN,ConfirmTPIN
				$oldPwd = $this->input->post("CurrentTPIN",TRUE);
				$newPwd = trim($this->input->post("NewTPIN",TRUE));
				$newCPwd = trim($this->input->post("ConfirmTPIN",TRUE));
				if($newPwd == $newCPwd)
				{
				    $user_id = $this->session->userdata("SdId",TRUE);
    				if(is_numeric($newPwd) == true and strlen($newPwd) == 4)
    				{
    					
    					$rsltuser = $this->db->query("select txn_password from  tblusers  where user_id = ?",array($user_id));
    					if($rsltuser->row(0)->txn_password == $oldPwd)
    					{
    						$this->db->query("update tblusers set txn_password = ?  where user_id = ?",array($newPwd,$user_id));
    						$this->view_data['message'] ="Transaction Password change successfully.";
    						$this->view_data['MESSAGEBOXTYPE'] ="success";
        				    $this->view_data['MESSAGEBOX'] ="Transaction Pin change successfully.";
    						$this->load->view('SuperDealer_new/change_txn_password_view',$this->view_data);		
    					}
    					else
    					{
    					    $this->view_data['MESSAGEBOXTYPE'] ="error";
        				    $this->view_data['MESSAGEBOX'] ="Old Transaction Pin does not match. Try Again!";
    						$this->view_data['message'] ="Old Transaction Pin does not match. Try Again!";
    						$this->load->view('SuperDealer_new/change_txn_password_view',$this->view_data);		
    					}	
    				}
    				else
    				{
    					$this->view_data['MESSAGEBOXTYPE'] ="error";
        				$this->view_data['MESSAGEBOX'] ="Transaction password  Must Be Numeric and 4 Digit";
    					$this->view_data['message'] ="Transaction password  Must Be Numeric and 4 Digit";
    					$this->load->view('SuperDealer_new/change_txn_password_view',$this->view_data);		
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
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'MasterDealer')
				{
					$this->view_data['message'] ="";
					$this->load->view('SuperDealer_new/change_txn_password_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}