<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mycommission extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$user_id = $this->session->userdata("SdId");
			
		$scheme_id = $this->session->userdata("SdSchemeId");
		
	

		$mycomm = $this->db->query("
		select 
		    a.company_name,
		    IFNULL(b.commission,0) as commission,
		    b.commission_type 
		    from tblcompany a 
		    left join tblgroupapi b on a.company_id = b.company_id  and b.group_id=?
		    where   (a.service_id = 1 or a.service_id = 2 or a.service_id = 3)  order by a.service_id,a.company_name",array($scheme_id));
		//print_r($mycomm->result());exit;
		$this->view_data['mycomm'] = $mycomm;
		$this->view_data['message'] =$this->msg;
		$this->view_data['pagination'] = "";
		$this->view_data['cmpl_flag'] =0;
		
		$this->load->view('SuperDealer/mycommission_view',$this->view_data);		
	}
	
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
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
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