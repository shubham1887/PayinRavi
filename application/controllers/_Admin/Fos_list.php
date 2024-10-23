<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fos_list extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('ausertype') != "Admin") 
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
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}	
		
		$start_row = $this->uri->segment(4);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$userrows = $this->db->query("select count(user_id) as total from tblusers where usertype_name = 'FOS'");
		
		$total_row = $userrows->row(0)->total;
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/fos_list/pageview";
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
		a.usertype_name = 'FOS' 
		order by a.businessname limit ?,?",array(intval($start_row),intval($per_page)));
		$this->view_data['message'] =$this->msg;
		$this->view_data['txtAGENTName'] ="";
		$this->view_data['txtAGENTId'] ="";
		$this->view_data['txtMOBILENo'] ="";
		$this->load->view('_Admin/fos_list_view',$this->view_data);		
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
				$this->load->view('_Admin/fos_list_view',$this->view_data);						
			}					
			else if($this->input->post('hidaction') == "Set")
			{							
			
				$status = $this->input->post("hidstatus",TRUE);
				$user_id = $this->input->post("hiduserid",TRUE);
				$start_page = $this->input->post("startpage",TRUE);
				$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
				if($userinfo->num_rows() == 1)
				{
					if($userinfo->row(0)->status == 0)
					{
						$password = $this->common->GetPassword();
						$this->db->query("update tblusers set status = 1,password = ? where user_id = ?",array($password,$user_id));
						$this->load->model('Sms');
						$this->Sms->passwordreset($userinfo->row(0)->username,$password,$userinfo->row(0)->mobile_no,$userinfo->row(0)->emailid,$userinfo->row(0)->businessname);
						$this->msg="Action Submit Successfully.";
						redirect(base_url()."_Admin/fos_list");
					}
					else if($userinfo->row(0)->status == 1)
					{
						//$password = $this->common->GetPassword();
						$this->db->query("update tblusers set status = 0 where user_id = ?",array($user_id));
						//$this->load->model('Sms');
						//$this->Sms->passwordreset($userinfo->row(0)->username,$password,$userinfo->row(0)->mobile_no,$userinfo->row(0)->emailid,$userinfo->row(0)->businessname);
						$this->msg="Action Submit Successfully.";
						redirect(base_url()."_Admin/fos_list");
					}
					
			
				}
				else
				{
					$this->msg="Invalid Action.";
						redirect(base_url()."_Admin/fos_list");
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
    		a.usertype_name = 'FOS' and
    		a.mobile_no = '".$SearchWord."'
    		order by a.username");
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
		a.dmr_group,
		g.group_name
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		where 
		a.usertype_name = 'FOS' and
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
		a.usertype_name = 'FOS' and
		a.username like '".$SearchWord."%'
		order by a.username");
		return $result;	
		}
		else
		{
			redirect(base_url()."_Admin/fos_list?crypt=".$this->Common_methods->encrypt("MyData"));
		}				
	}
	public function minRechargeLimit()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$minreclimit = $_GET["minrechargelimit"];
		$user_id = $_GET["id"];
		$rslt = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
		if($rslt->num_rows() == 1)
		{
			$this->db->query("update tblusers set min_bal_limit = ? where user_id = ?",array($minreclimit,$user_id));
		}
	}
	public function changedmrgroup()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		}
		$id = $_GET["id"];
		$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($id));
		$field = $_GET["field"];
		if($userinfo->num_rows() == 1)
		{
		
			$this->db->query("update tblusers set dmr_group = ? where user_id = ?",array($field,$id));
			echo $field;
		}
	}
	public function  togglegroup()
	{
		if(isset($_GET["id"]) and isset($_GET["sts"]))
		{
			$id = trim($_GET["id"]);
			$sts = trim($_GET["sts"]);
			$this->db->query("update tblusers set 	grouping=? where user_id = ?",array($sts,$id));
			echo "Success";exit;
		}
	}
	public function getbalance()
	{
		
		$id = $_GET["id"];
	   echo $id."#".$this->Common_methods->getAgentBalance($id)."#".$this->Ew2->getAgentBalance($id);exit;
		
		
	}
	public function setvalues()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			echo "";exit;
		}
		$id = $_GET["Id"];
		$val= $_GET["val"];
		$userinfo = $this->db->query("select user_id from tblusers where user_id = ?",array($id));
		$field = $_GET["field"];
		
		if($userinfo->num_rows() == 1)
		{
			
			if($field == "MT")
			{
					
				$this->db->query("update tblusers set mt_access = ? where user_id = ?",array($val,$id));
				echo $val;	
			}
			
		}
	}
}