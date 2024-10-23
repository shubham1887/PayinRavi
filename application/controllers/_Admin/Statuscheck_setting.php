<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statuscheck_setting extends CI_Controller {
	
	
	
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
			
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{
				$txtUrl = trim($this->input->post("txtUrl",TRUE));
				$txtParams = trim($this->input->post("txtParams",TRUE));
				$ddlapi = trim($this->input->post("ddlapi",TRUE));
				
				$checkapi = $this->db->query("select api_id from apistatuscheck_settings where api_id = ?",array($ddlapi));
				if($checkapi->num_rows() == 0)
				{
					$this->db->query("insert into apistatuscheck_settings(api_id,status_url,parameters,add_date,ipaddress) values(?,?,?,?,?)",
					array($ddlapi,$txtUrl,$txtParams,$this->common->getDate(),$this->common->getRealIpAddr()));	
				}
				redirect(base_url()."_Admin/statuscheck_setting?crypt=".$this->Common_methods->encrypt("MyData"));
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{				
				
				$txtUrl = trim($this->input->post("txtUrl",TRUE));
				$txtParams = trim($this->input->post("txtParams",TRUE));
				$ddlapi = trim($this->input->post("ddlapi",TRUE));
				$rslt = $this->db->query("select * from apistatuscheck_settings where api_id = ?",array($ddlapi));
				if($rslt->num_rows() == 1)
				{
					$this->db->query("update apistatuscheck_settings set api_id = ?,status_url = ?,parameters = ?,update_datetime = ?  where api_id = ?",
					array($ddlapi,$txtUrl,$txtParams,$this->common->getDate(),$this->common->getRealIpAddr(),$ddlapi));
					
				}
				
				redirect(base_url()."_Admin/statuscheck_setting?crypt=".$this->Common_methods->encrypt("MyData"));			
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
			   
				$Id = $this->input->post("hidValue",TRUE);
				$action = $this->input->post("action",TRUE);
				if($action == "delete")			
				{
					$rslt = $this->db->query("select * from apistatuscheck_settings where api_id = ?",array($Id));
					if($rslt->num_rows() == 1)
					{
						$this->db->query("delete from  apistatuscheck_settings  where api_id = ?",array($Id));
						
					}
				}
				redirect(base_url()."_Admin/statuscheck_setting?crypt=".$this->Common_methods->encrypt("MyData"));		
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->view_data["data"] = $this->db->query("select a.*,b.api_name from apistatuscheck_settings a left join tblapi b on a.api_id = b.api_id order by b.api_name");
					$this->load->view("_Admin/statuscheck_setting_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}
	
}