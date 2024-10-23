<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loginhistory extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{

		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$user_id = $this->session->userdata("DistId");
		$scheme_id = $this->session->userdata("AgentSchemeId");
		
	

		$myhistory = $this->db->query("
		SELECT history_id,user_id,date_login,time_login,ip_address FROM tbllogin_history where date_login = ? order by history_id desc limit 50",array($this->common->getDate()));
		//print_r($mycomm->result());exit;
		$this->view_data['myhistory'] = $myhistory;
		$this->view_data['message'] =$this->msg;
		$this->view_data['pagination'] = "";
		$this->view_data['cmpl_flag'] =0;
		
		$this->load->view('Distributor_new/Loginhistory_view',$this->view_data);		
	}
	
	public function index() 
	{
	
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	
			if($this->input->post('btnSubmit'))
			{
			
				$Fromdate = $this->input->post('txtFromDate',true);
				$Todate = $this->input->post('txtToDate',true);
				$txtNumId = $this->input->post('txtNumId',true);
				$this->session->set_userdata("FromDate",$Fromdate);
				$this->session->set_userdata("ToDate",$Todate);
				$this->session->set_userdata("txtNumId",$txtNumId);
				$this->pageview();
									
			}
			else
			{
				$user=$this->session->userdata('DistUserType');
				if(trim($user) == 'Distributor')
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