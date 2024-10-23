<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Md_list extends CI_Controller {

	

	

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
		$userrows = $this->db->query("select count(user_id) as total from tblusers where usertype_name = 'MasterDealer'");
		
		$total_row = $userrows->row(0)->total;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/md_list/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();

		$this->view_data['result_dealer'] = $this->db->query("
		select 
		a.user_id,
		a.parentid,
		a.businessname,
		a.mobile_no,
		a.usertype_name,
		a.add_date,
		a.status,
		a.username,
		a.password,
		a.txn_password,
		a.enabled,
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group ,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'MasterDealer' 
		order by a.username limit ?,?",array(intval($start_row),intval($per_page)));
        $this->view_data['txtAGENTName'] ="";
		$this->view_data['txtAGENTId'] ="";
		$this->view_data['txtMOBILENo'] ="";
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/md_list_view',$this->view_data);		

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
					$result = $this->Search("UserID",$txtAGENTId);	
				}
				else if($txtAGENTName != "")							
				{
					$result = $this->Search("Agent",$txtAGENTName);	
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
				$this->load->view('_Admin/md_list_view',$this->view_data);						
			}	
			if($this->input->post("action") == "delete")
			{
			    $mdid = $this->input->post("hidValue");
			    $userinfo = $this->db->query("select * from tblusers where user_id = ? and usertype_name = 'MasterDealer'",array($mdid));
			 
			    if($userinfo->num_rows() == 1)
			    {
			      
			        $rsltdownline = $this->db->query("select * from tblusers where parentid = ?",array($mdid));
			        if($rsltdownline->num_rows()  >= 1)
			        {
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","You Cant Delete This User");
			            redirect(base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"));
			        }
			        else
			        {
			            $this->db->query("delete from tblusers where user_id = ?",array($userinfo->row(0)->user_id));
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
			            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","User Deleted Successfully");
			            
			            redirect(base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"));
			        }
			    }
			    else
			    {
			        $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
		            $this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Some Error Occured");
		            redirect(base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"));
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
	public function getbalance()
	{
		
		$id = $_GET["id"];
	   echo $id."#".round($this->Common_methods->getAgentBalance($id),2)."#".round($this->Ew2->getAgentBalance($id),2);exit;
		
		
	}	
    public function Search($SearchBy,$SearchWord)
	{
		
		if($SearchBy == "Mobile")
		{
		
			$result = $this->db->query("
		select 
		a.user_id,
		a.parentid,
		a.businessname,
		a.mobile_no,
		a.usertype_name,
		a.add_date,
		a.status,
		a.username,
		a.password,
		a.txn_password,
		a.enabled,
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group ,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'MasterDealer' and
		a.mobile_no = '".$SearchWord."'
		order by a.username ");
		return $result;	
		}		
		if($SearchBy == "Agent")
		{
			
			$result = $this->db->query("
		select 
		a.user_id,
		a.parentid,
		a.businessname,
		a.mobile_no,
		a.usertype_name,
		a.add_date,
		a.status,
		a.username,
		a.password,
		a.txn_password,
		a.enabled,
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group ,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'MasterDealer' and
		a.businessname like '".$SearchWord."%'
		order by a.username");
		return $result;	
		}		
		if($SearchBy == "UserID")
		{
			
			$result = $this->db->query("
		select 
		a.user_id,
		a.parentid,
		a.businessname,
		a.mobile_no,
		a.usertype_name,
		a.add_date,
		a.status,
		a.username,
		a.password,
		a.txn_password,
		a.enabled,
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group ,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'MasterDealer' and
		a.username like '".$SearchWord."%'
		order by a.username");
		return $result;	
		}
		else
		{
			redirect(base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"));
		}				
	}
}