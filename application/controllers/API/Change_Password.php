<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_Password extends CI_Controller {
	
	 
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function index()  
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}			
		else 		
		{ 	
			if($this->input->post('btnSearch') == "Submit")
			{
				$user_id = $this->session->userdata("ApiId");
				$OldPwd = trim($this->input->post("txtOldPassword",TRUE));
				$NewPwd = trim($this->input->post("txtNewPassword",TRUE));
				$CNewPwd = trim($this->input->post("txtCNewPassword",TRUE));
				
				$rslt = $this->db->query("select password from tblusers where user_id = ?",array($user_id));
				if($rslt->num_rows() == 1)
				{
					if($OldPwd == $rslt->row(0)->password)
					{
					
						$this->db->query("update tblusers set password = ? where user_id = ?",array($NewPwd,$user_id));
						$this->session->set_flashdata("MESSAGEBOXTYPE","SUCCESS");
						$this->session->set_flashdata("MESSAGEBOX","Password Changed Successfully");
					}
					else
					{
						$this->session->set_flashdata("MESSAGEBOXTYPE","FAILURE");
						$this->session->set_flashdata("MESSAGEBOX","Old Password Not Match");
					}
				}
				else
				{
					$this->session->set_flashdata("MESSAGEBOXTYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX","Internal Server Error");
				}
				
				redirect(base_url()."API/Change_Password?crypt=".$this->Common_methods->encrypt("myData"));	
			}					
			else
			{
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER')
				{
					$this->view_data['message']  = "";
					$this->load->view('API/change_password_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}