<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recharge_history extends CI_Controller {
	
	
	private $msg='';	
	public function index() 
	{
		// error_reporting(-1);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;


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
			$user_id = $this->session->userdata('MdId');			
			$this->load->model('Agent_report_model');

			if($this->session->userdata("MdUserType") == "")
			{
				$this->view_data['result_all'] = $this->Agent_report_model->get_recharge($from,$to,$user_id);
			}
			$this->view_data['message'] =$this->msg;
			$this->view_data['from'] =$from;
			$this->view_data['to'] =$to;
			$this->view_data['txtNumId'] ="";
			$this->load->view('SuperDealer/recharge_history_view',$this->view_data);								
		}
		else 
		{ 						
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
				{	
					$date = $this->common->getMySqlDate();									
					$this->view_data['message']='';
					$this->view_data['from'] =$date;
					$this->view_data['to'] =$date;
					$this->view_data['txtNumId'] ="";
					$this->load->view('SuperDealer/recharge_history_view',$this->view_data);		
				}
				else
				{redirect(base_url().'login');}																								
		} 
	}	
}