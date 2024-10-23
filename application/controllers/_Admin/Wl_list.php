<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wl_list extends CI_Controller {
	
	
	private $msg='';
	public function pageview()
	{ 
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$start_row = $this->uri->segment(4);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		
		$result = $this->db->query("select user_id from tblusers where usertype_name = 'WL'");
		$total_row = $result->num_rows();
		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/wl_list/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_dealer'] = $this->db->query("select tblusers.*,(select state_name from tblstate where tblstate.state_id = tblusers.state_id) as state_name,(select state_name from tblcity where tblcity.city_id = tblusers.city_id) as city_name from tblusers where usertype_name = 'WL' order by businessname limit ?,?",array($start_row,$per_page));
$this->view_data['txtAGENTName'] ="";
		$this->view_data['txtAGENTId'] ="";
		$this->view_data['txtMOBILENo'] ="";
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/wl_list_view',$this->view_data);		
	}
	
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
			
				$txtAGENTName = $this->input->post("txtAGENTName",TRUE);
				$txtAGENTId = $this->input->post("txtAGENTId",TRUE);		
				$txtMOBILENo = $this->input->post("txtMOBILENo",TRUE);	
				if($txtMOBILENo != "")							
				{
					$result = $this->Search("Mobile",$txtMOBILENo);	
				
				}
				else if($txtAGENTId != "")							
				{
					$result = $this->Search("UserID",$txtMOBILENo);	
				}
				else if($txtAGENTName != "")							
				{
					$result = $this->Search("Agent",$txtMOBILENo);	
				}
				else
				{
					$result = $this->Search("",$txtMOBILENo);	
				}
					
				$this->view_data['result_dealer'] = $result;
				$this->view_data['message'] =$this->msg;
				$this->view_data['txtAGENTName'] =$txtAGENTName;
				$this->view_data['txtAGENTId'] =$txtAGENTId;
				$this->view_data['txtMOBILENo'] =$txtMOBILENo;
				$this->view_data['pagination'] = NULL;
				$this->load->view('_Admin/wl_list_view',$this->view_data);						
			}
			else if($this->input->post('hidaction') == "StartStop")
			{								
				$status = $this->input->post("hidserstatus",TRUE);
				$user_id = $this->input->post("hiduserid",TRUE);
				$start_page = $this->input->post("startpage",TRUE);
				$this->load->model('Agent_list_model');
				$result = $this->Agent_list_model->updateServiceAction($status,$user_id);
				if($result == true)
				{
					$this->msg="Action Submit Successfully.";
					redirect(base_url()."_Admin/wl_list");
				}
			}	
			
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin' or trim($user) == 'EMP')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}	
private function Search($SearchBy,$SearchWord)
	{
		if($SearchBy == "Mobile")
		{
		$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Wl' and mobile_no like '".$SearchWord."%' order by username";
		$result = $this->db->query($str_query);
		return $result;	
		}		
		if($SearchBy == "Agent")
		{
		$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Wl' and businessname like '".$SearchWord."%' order by username";
		$result = $this->db->query($str_query);
		return $result;	
		}		
		if($SearchBy == "UserID")
		{
		$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,(select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Wl' and username like '".$SearchWord."%' order by username";
		$result = $this->db->query($str_query);
		return $result;	
		}	
		else
		{
		$str_query = "select tblusers.*, (select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,(select businessname from tblusers a where a.user_id = tblusers.parentid) as parent_name,tblusers.businessname,(select city_name from tblcity where tblcity.city_id=tblusers.city_id) as city_name,(select state_name from tblstate where tblstate.state_id 	=tblusers.state_id) as state_name,tblusers.mobile_no,tblusers.emailid from tblusers where tblusers.usertype_name='Wl'  order by username";
		$result = $this->db->query($str_query);
		return $result;	
		}				
	}
}