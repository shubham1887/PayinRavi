<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aeps_group extends CI_Controller {
	
	
	
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
		
		$resulttotal = $this->db->query("select count(Id) as total from aeps_group");
		$total_row = $resulttotal->row(0)->total;		
		$this->load->library('pagination');
		$config['base_url'] = base_url()."_Admin/Aeps_group/pageview";
		$config['total_rows'] = $total_row;
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config); 
		$this->view_data['pagination'] = $this->pagination->create_links();
		$this->view_data['result_api'] = $this->db->query("select * from aeps_group order by Name",array($start_row,$per_page));
		$this->view_data['message'] =$this->msg;
		$this->load->view('_Admin/Aeps_group_view',$this->view_data);		
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
			if($this->input->post("btnSubmit") == "Submit")
			{
				$txtGroupName = $this->input->post("txtGroupName",TRUE);
				$ddlretChargeType = $this->input->post("ddlretChargeType",TRUE);
				$txtRetailerCharge = $this->input->post("txtRetailerCharge",TRUE);
				$ddldistChargeType = $this->input->post("ddldistChargeType",TRUE);	
				$txtDistCharge = $this->input->post("txtDistCharge",TRUE);	
				if($txtGroupName != "")
				{
					$result = $this->db->query("insert into mt3_group(Name,add_date,ipaddress,charge_type,charge_value,dist_charge_type,dist_charge_value) values(?,?,?,?,?,?,?)",array($txtGroupName,$this->common->getDate(),$this->common->getRealIpAddr(),$ddlretChargeType,$txtRetailerCharge,$ddldistChargeType,$txtDistCharge));	
					redirect(base_url()."_Admin/Aeps_group?crypt=".$this->Common_methods->encrypt("MyData"));
					
				}
				else
				{
						redirect(base_url()."_Admin/Aeps_group?crypt=".$this->Common_methods->encrypt("MyData"));
				}
				
				
				
				
				
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{	
				$hidId = $this->input->post("hidID",TRUE);
				$txtGroupName = $this->input->post("txtGroupName",TRUE);
				$ddlretChargeType = $this->input->post("ddlretChargeType",TRUE);
				$txtRetailerCharge = $this->input->post("txtRetailerCharge",TRUE);
				$ddldistChargeType = $this->input->post("ddldistChargeType",TRUE);	
				$txtDistCharge = $this->input->post("txtDistCharge",TRUE);	
				
				$result = $this->db->query("update mt3_group set Name=?,charge_type=?,charge_value=?,dist_charge_type=?,dist_charge_value=? where Id=?",array($txtGroupName,$ddlretChargeType,$txtRetailerCharge,$ddldistChargeType,$txtDistCharge,$hidId));		
				
				$this->msg ="Group Update Successfully.";
				$this->pageview();
							
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$groupId = $this->input->post("hidValue",TRUE);
				$this->db->query("delete from mt3_group where Id = ?",array($groupId));
				$this->msg ="Group Delete Successfully.";
				$this->pageview();				
			}
			else if(isset($_GET["crypt1"]) and isset($_GET["crypt2"]))
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$this->view_data['result_slabs'] = $this->db->query("select a.*,b.Name from aeps_slab a left join aeps_group b on a.group_id = b.Id where a.group_id = ? order by a.range_from",array($this->Common_methods->decrypt($this->input->get("crypt2"))));
					$this->view_data['message'] =$this->msg;
					$this->load->view('_Admin/Aeps_margin_slabs_view',$this->view_data);		
				}
				else
				{redirect(base_url().'adminlogin');}																					
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
}