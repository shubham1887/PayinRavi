<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Certificate extends CI_Controller {
	
	
	private $msg='';
	
	
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
			$userinfo = $this->db->query("
			SELECT businessname,user_id,Date(add_date) as add_date,mobile_no,status,kyc FROM tblusers where user_id = ?",array($this->session->userdata("MdId")));
		//print_r($mycomm->result());exit;
		$this->view_data['myinfo'] = $userinfo;
		$this->view_data['message'] =$this->msg;
		
		
		$this->load->view('MasterDealer_new/Certificate_view',$this->view_data);	
		}
				
	}	
	
}