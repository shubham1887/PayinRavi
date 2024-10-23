<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partner_list extends CI_Controller {
	
	
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
		
		 	 if($this->input->post('btnSubmit') == "Search")
			{
			
				$ddluser = $this->input->post("ddluser",TRUE);
				$result = $this->Search("PARTNER",$ddluser);	
				
					
				$this->view_data['result_dealer'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['pagination'] = NULL;
				$this->load->view('_Admin/partner_list_view',$this->view_data);						
			}					
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
						$this->view_data['result_dealer'] = NULL;
						$this->view_data['message'] =$this->msg;
						$this->view_data['pagination'] = NULL;
						$this->load->view("_Admin/partner_list_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
	public function Search($SearchBy,$SearchWord)
	{
		if($SearchBy == "Mobile")
		{
		$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Agent' and mobile_no like '".$SearchWord."%' order by username";
		$result = $this->db->query($str_query);
		return $result;	
		}		
		if($SearchBy == "Agent")
		{
		$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Agent' and businessname like '".$SearchWord."%' order by username";
		$result = $this->db->query($str_query);
		return $result;	
		}		
		if($SearchBy == "UserID")
		{
		$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,(select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Agent' and username like '".$SearchWord."%' order by username";
		$result = $this->db->query($str_query);
		return $result;	
		}
		if($SearchBy == "PARTNER")
		{
			$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,(select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Agent' and tblusers.parentid = ?  order by username";
		$result = $this->db->query($str_query,array($SearchWord));
		return $result;	
		}				
	}
}