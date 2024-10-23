<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dist_list extends CI_Controller {

	

	

	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function pageview()
	{ 
	     //error_reporting(E_ALL);
	    //ini_set("display_errors",1);
	    //$this->db->db_debug = TRUE;
		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		$start_row = $this->uri->segment(4);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$user_id = $this->session->userdata("SdId");
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
		$result = $this->db->query("select user_id from tblusers where usertype_name = 'Distributor' and host_id = ?",array($user_id));
		$total_row = $result->num_rows();
		$this->load->library('pagination');
		$config['base_url'] = base_url()."SuperDealer/dist_list/pageview";
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
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'Distributor'  and a.host_id = ?
		order by a.businessname limit ?,? ",array($user_id,intval($start_row),intval($per_page)));
        $this->view_data['txtAGENTName'] ="";
		$this->view_data['txtAGENTId'] ="";
		$this->view_data['txtMOBILENo'] ="";
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/dist_list_view',$this->view_data);		

	}

	

	public function index() 
	{
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache"); 
        if($this->session->userdata('SdUserType') != "SuperDealer") 
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
				$this->load->view('SuperDealer/dist_list_view',$this->view_data);						
			}	
			else
			{
                    $this->pageview();
			}

		} 

	}	
	public function Search($SearchBy,$SearchWord)
	{
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
		$user_id = $this->session->userdata("SdId");
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
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		where 
		a.usertype_name = 'Distributor' and  a.host_id = ? and
		a.mobile_no = ?
		order by a.username",array($host_id,$SearchWord));
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
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		where 
		a.usertype_name = 'Distributor' and 
		a.host_id = ? and
		a.businessname like '".$SearchWord."%'
		order by a.username",array($user_id));
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
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group 
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		where 
		a.usertype_name = 'Distributor' and
		a.host_id = ? and
		a.username like '".$SearchWord."%'
		order by a.username",array($user_id));
		return $result;	
		}
		else
		{
			redirect(base_url()."SuperDealer/dist_list?crypt=".$this->Common_methods->encrypt("MyData"));
		}				
	}
}