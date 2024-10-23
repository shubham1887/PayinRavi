<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retailer_list extends CI_Controller {
	
	
	private $msg='';
	public function get_retailer()
	{
		$rslt = $this->db->query("select user_id from tblusers where usertype_name = 'Agent' and parentid = ?",array($this->session->userdata("SdId")));

		return $rslt; 
	}
	public function get_retailer_limited()
	{
		$rslt = $this->db->query("select tblusers.*,(select c.businessname from tblusers c where c.user_id = tblusers.parentid) as parent_name,(select state_name from tblstate where tblstate.state_id = tblusers.state_id) as state_name,(select city_name from tblcity where tblcity.city_id = tblusers.city_id) as city_name from tblusers where usertype_name = 'Agent' and parentid IN (select user_id from tblusers  where tblusers.parentid = ?) order by username",array($this->session->userdata("SdId")));
		return $rslt; 
	}
	public function pageview()
	{
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$this->view_data['result_dealer'] = $this->get_retailer_limited();
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/retailer_list_view',$this->view_data);		
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
		
		 	if($this->input->post("hidSearchFlag") && $this->input->post("hidSearchValue"))
			{
			
				$SearchBy = $this->input->post("hidSearchFlag",TRUE);
				$SearchWord = $this->input->post("hidSearchValue",TRUE);								
				$this->load->model('Md_dealer_list_model');
				$result = $this->Md_dealer_list_model->getMasterdealerFiltered("Distributo",$SearchBy,$SearchWord);		
				$this->view_data['result_dealer'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['pagination'] = NULL;
				$this->load->view('SuperDealer/agent_list_view',$this->view_data);			
			}
			else if($this->input->post('btnSearch') == "Search")
			{
				$SearchBy = $this->input->post("ddlSearchBy",TRUE);
				$SearchWord = $this->input->post("txtSearch_Word",TRUE);								
				$this->load->model('Agent_list_model');
				$result = $this->Agent_list_model->Search($SearchBy,$SearchWord);		
				$this->view_data['result_retailer'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['pagination'] = NULL;
				$this->load->view('SuperDealer/agent_list_view',$this->view_data);						
			}					
			else if($this->input->post('hidaction') == "Set")
			{							
			
				$status = $this->input->post("hidstatus",TRUE);
				$user_id = $this->input->post("hiduserid",TRUE);
				$start_page = $this->input->post("startpage",TRUE);
				$this->load->model('Agent_list_model');
				$result = $this->Agent_list_model->updateAction($status,$user_id);
				if($result == true)
				{
					$this->msg="Action Submit Successfully.";
					redirect(base_url()."/agent_list/pageview/".$start_page);
				}
			}
			else if($this->input->post('hidaddto') == "Addto")
			{								
				$usertype_name = $this->input->post("hidusertype",TRUE);
				$user_id = $this->input->post("hiduserid",TRUE);
				$this->load->model('Agent_list_model');
				$result = $this->Agent_list_model->updateUsertype($usertype_name,$user_id);
				if($result == true)
				{
					$this->msg="Action Submit Successfully.";
					$this->pageview();	
				}
			}
			else
			{
				$user=$this->session->userdata('SdUserType');
				if(trim($user) == 'SuperDealer')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
}