<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loginhistory extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$user_id = $this->session->userdata("AgentId");
		$FromDate = $this->session->userdata("FromDate");
		$ToDate = $this->session->userdata("ToDate");
		
	
		
		$myhistory = $this->db->query("
		SELECT history_id,user_id,add_date,ipaddress FROM tbllogin_history where user_id = ? and Date(add_date) BETWEEN ? and ? order by history_id desc limit 50",array($user_id,$FromDate,$ToDate));
		//print_r($mycomm->result());exit;
		$this->view_data['myhistory'] = $myhistory;
		$this->view_data['message'] =$this->msg;
		$this->view_data['pagination'] = "";
		$this->view_data['cmpl_flag'] =0;
		
		$this->load->view('Retailer/Loginhistory_view',$this->view_data);		
	}
	
	public function index() 
	{
	
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if(isset($_POST['Fromdate']) and isset($_POST['Todate']))
			{
			
				$Fromdate = date_format(date_create($this->input->post('Fromdate')),'Y-m-d');
				$Todate =date_format(date_create($this->input->post('Todate')),'Y-m-d'); 
				
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->pageview();
									
			}
			else
			{
				$user=$this->session->userdata('AgentUserType');
				if(trim($user) == 'Agent')
				{
					$todaydate = $this->common->getMySqlDate();
					$this->session->set_userdata("FromDate",$todaydate);
					$this->session->set_userdata("ToDate",$todaydate);
					$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	
}