<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apiswitchonfailure extends CI_Controller {	
		private $msg='';
	public function pageview()
	{
		$rslt = $this->db->query("select * from common where param = 'APIOnFailure'");
		
		
		$apionfailure = $rslt->row(0)->value;
		
		
		$this->view_data['message'] ="";
		$this->view_data['apionfailure'] =$apionfailure;
		
		$this->load->view('_Admin/apiswitchonfailure_view',$this->view_data);		
	}

	public function index() 
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
		
			$data['message']='';				
			if($this->input->post("hidtype") == "Set")
			{
				$hidvalue = $this->input->post("hidvalue",TRUE);
				
					$rslt = $this->db->query("update common set value =? where param = 'APIOnFailure'",array($hidvalue));
					$this->session->set_flashdata('message', ' API Change Successful.');
					redirect('_Admin/apiswitchonfailure');
				
				
			}		
							
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		}
	}		
	}				
?>