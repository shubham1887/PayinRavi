<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mycommission extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$user_id = $this->session->userdata("AgentId");
			
		
	

		$mycomm = $this->db->query("select tbluser_commission.*,company_name from `tbluser_commission`,tblcompany  where tblcompany.company_id = tbluser_commission.company_id and user_id=? ",array($user_id));
		$this->view_data['mycomm'] = $mycomm;
		$this->view_data['message'] =$this->msg;
		$this->view_data['pagination'] = "";
		$this->view_data['cmpl_flag'] =0;
		
		$this->load->view('Retailer/mycommission_view',$this->view_data);		
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