<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distributor_ledger_report extends CI_Controller {
	
	
	private $msg='';
	
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
			if($this->input->post('btnSearch') == "Search")
			{
				$this->load->model("Report");
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$user_code = $this->input->post("txtAgentCode",TRUE);
				$user_info = $this->Userinfo_methods->getUserInfoByUsername($user_code);
				$user_id = $user_info->row(0)->user_id;
				$this->view_data['pagination'] = NULL;
				$this->view_data['result_mdealer'] = $this->Report->AccountLedger_getReport($user_id,$from_date,$to_date);
				$this->view_data['message'] =$this->msg;
				$this->load->view('_Admin/distributor_ledger_report_view',$this->view_data);		
			}					
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
					$this->view_data['pagination'] =NULL;
					$this->view_data['result_mdealer'] = false;
					$this->view_data['message'] =$this->msg;
					$this->load->view('_Admin/distributor_ledger_report_view',$this->view_data);	
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}