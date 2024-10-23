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
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
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
		
		$start_row = $this->uri->segment(3);
		$per_page = $this->common_value->getPerPage();
		if(trim($start_row) == ""){$start_row = 0;}
		$result = $this->db->query("select count(Id) as total from tblgroup where user_id = ?",array($this->session->userdata("SdId")));
		$total_row = $result->row(0)->total;		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."SuperDealer/group/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_group'] = $this->db->query("select * from tblgroup where user_id = ? order by group_name limit ?,?",array($this->session->userdata("SdId"),$start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->load->view('SuperDealer/group_view',$this->view_data);		
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
			$data['message']='';		
			//print_r($this->input->post());exit;
			if($this->input->post("HIDACTION") == "INSERT")
			{
				$GroupName = $this->input->post("txtGroupName",TRUE);
				$GroupDesc = $this->input->post("txtGroupName",TRUE);
				$ddlgroupfor = $this->input->post("ddlgroupfor",TRUE);
				$txtMinBal = 0;
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblgroup where group_name = ? and user_id = ?",array($GroupName,$this->session->userdata("SdId")));
				if($check->num_rows() < 1)
				{
					$this->db->query("insert into tblgroup(group_name,description,add_date,groupfor,min_balance,user_id ) values(?,?,?,?,?,?)",array($GroupName,$GroupDesc,$add_date,$ddlgroupfor,$txtMinBal,$this->session->userdata("SdId")));
				}
				
				
				
				$this->pageview();
			}
			else if($this->input->post("HIDACTION") == "UPDATE")
			{
				$hidPrimaryId = $this->input->post("hidPrimaryId",TRUE);
				$GroupName = $this->input->post("txtGroupName",TRUE);
				$GroupDesc = $this->input->post("txtGroupName",TRUE);
				$ddlgroupfor = $this->input->post("ddlgroupfor",TRUE);
				//echo $hidPrimaryId;exit;
				$txtMinBal = 0;
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblgroup where Id = ? and user_id = ?",array($hidPrimaryId,$this->session->userdata("SdId")));
				if($check->num_rows() == 1)
				{
					$this->db->query("update tblgroup set group_name = ? where Id = ? and user_id = ?",array($GroupName,$hidPrimaryId,$this->session->userdata("SdId")));
				}
				$this->pageview();
			}
			else if($this->input->post("HIDACTION") == "DELETE")
			{
			    $hidPrimaryId = $this->input->post("hidPrimaryId",TRUE);
				$GroupName = $this->input->post("txtGroupName",TRUE);
				$GroupDesc = $this->input->post("txtGroupName",TRUE);
				$ddlgroupfor = $this->input->post("ddlgroupfor",TRUE);
				//echo $hidPrimaryId;exit;
				$txtMinBal = 0;
				$add_date = $this->common->getDate();
				$check = $this->db->query("select * from tblgroup where Id = ? and user_id = ?",array($hidPrimaryId,$this->session->userdata("SdId")));
				if($check->num_rows() == 1)
				{
					$this->db->query("delete from tblgroup where Id = ? and user_id = ?",array($hidPrimaryId,$this->session->userdata("SdId")));
				}
				
				
				
				$this->pageview();
			}
			else
			{
				
				$this->pageview();
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