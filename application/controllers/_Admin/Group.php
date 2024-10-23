<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {
	
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
	private $msg='';
	public function pageview()
	{
		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$result = $this->db->query("select * from tblgroup where user_id = 1");
		$total_row = $result->num_rows();		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/group/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_group'] = $this->db->query("select * from tblgroup  order by group_name limit ?,?",array($start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/group_view',$this->view_data);		
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
		  
			$data['message']='';		
			if($this->input->post("HIDACTION") == "INSERT")
			{
				$GroupName = $this->input->post("txtGroupName",TRUE);
				$GroupDesc = "";
				$ddlgroupfor = $this->input->post("ddlgroupfor",TRUE);
				$txtMinBal = 0;
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblgroup where group_name = ?",array($GroupName));
			
				if($check->num_rows() < 1)
				{
					$this->db->query("insert into tblgroup(group_name,description,add_date,groupfor,min_balance,user_id ) values(?,?,?,?,?,?)",array($GroupName,$GroupDesc,$add_date,$ddlgroupfor,$txtMinBal,1));
				}
				
				
				
				$this->pageview();
			}
			else if($this->input->post("HIDACTION") == "DELETE")
			{
				$hidID = $this->input->post("hidPrimaryId",TRUE);
				$this->db->query("delete from  tblgroup where Id = ?",array($hidID));
				
				
				
				
				$this->pageview();
			}
			else if($this->input->post("btnSubmit") == "Update")
			{
				
				$GroupName = $this->input->post("txtGroupName",TRUE);
				$GroupDesc = $this->input->post("txtGroupDesc",TRUE);
				$ddlgroupfor = $this->input->post("ddlgroupfor",TRUE);
				$txtMinBal = $this->input->post("txtMinBal",TRUE);
				$hidID = $this->input->post("hidID",TRUE);
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblgroup where Id = ?",array($hidID));
				
				if($check->num_rows() == 1)
				{
					$this->db->query("update tblgroup set group_name = ?,description = ?,edit_date = ?,groupfor = ?,min_balance =? where Id = ?",array($GroupName,$GroupDesc,$this->common->getDate(),$ddlgroupfor,$txtMinBal,$hidID));
				}
				
				
				
				$this->pageview();
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
				$this->pageview();
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
	public function  togglegroup()
	{
		if(isset($_GET["id"]) and isset($_GET["sts"]))
		{
			$id = trim($_GET["id"]);
			$sts = trim($_GET["sts"]);
			$this->db->query("update tblgroup set service=? where Id = ?",array($sts,$id));
			echo "Success";exit;
		}
	}
}