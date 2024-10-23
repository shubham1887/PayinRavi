<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mycommission extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{

		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$user_id = $this->session->userdata("AgentId");


		$userinfo = $this->db->query("select scheme_id from tblusers where user_id = ?",array($user_id));

		$scheme_id = $userinfo->row(0)->scheme_id;
		
	

		$mycomm = $this->db->query("
		select 
		    a.company_name,
		    IFNULL(b.commission,0) as commission,
		    b.commission_type,
		    s.service_name
		    from tblcompany a 
		    left join tblservice s on a.service_id = s.service_id
		    left join tblgroupapi b on a.company_id = b.company_id  and b.group_id=?
		      order by a.service_id,a.company_name",array($scheme_id));
		//print_r($mycomm->result());exit;
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