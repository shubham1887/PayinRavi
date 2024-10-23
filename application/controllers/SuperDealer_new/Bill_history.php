<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_history extends CI_Controller {
	
	
	private $msg='';	
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else if($this->input->post('btnSearch'))
		{
		
			$from = $this->input->post('txtFrom',true);
			$to = $this->input->post('txtTo',true);
			$user_id = $this->session->userdata('SdId');			
			$this->load->model('Agent_report_model');
			if($this->session->userdata("SdUserType") == "MasterDealer")
			{
				$this->view_data['result_all'] = $this->db->query("select * from tblbillpay where user_id = ? order by Id desc",array($user_id));
			}
			$this->view_data['message'] =$this->msg;
			$this->view_data['from'] =$from;
			$this->view_data['to'] =$to;
			$this->load->view('SuperDealer_new/bill_history_view',$this->view_data);								
		}
		else 
		{ 						
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'MasterDealer')
				{	
					$date = $this->common->getMySqlDate();									
					$this->view_data['message']='';
					$this->view_data['from'] =$date;
					$this->view_data['to'] =$date;
					$this->load->view('SuperDealer_new/bill_history_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}	
}