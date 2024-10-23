<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mesage_setting extends CI_Controller {
	
	
	
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
				$txtStatusWord = trim($this->input->post("txtStatusWord",TRUE));
				$txtOpStart = trim($this->input->post("txtOpStart",TRUE));
				$txtOpIdEnd = trim($this->input->post("txtOpIdEnd",TRUE));
				$txtNumStart = trim($this->input->post("txtNumStart",TRUE));
				$txtNumEnd = trim($this->input->post("txtNumEnd",TRUE));
				$txtBalStart = trim($this->input->post("txtBalStart",TRUE));
				$txtBalEnd = trim($this->input->post("txtBalEnd",TRUE));
				$ddlapi = trim($this->input->post("ddlapi",TRUE));
				$txtRefStart = trim($this->input->post("txtRefStart",TRUE));
				$txtRefIdEnd = trim($this->input->post("txtRefIdEnd",TRUE));
				$ddlupdateBy = trim($this->input->post("ddlupdateBy",TRUE));
				
				$ddlstatus = trim($this->input->post("ddlstatus",TRUE));		
				if($ddlstatus == "Success" or $ddlstatus == "Failure")
				{
					$this->db->query("insert into message_setting
					(add_date,ipaddress,status_word,operator_id_start,operator_id_end,number_start,number_end,balance_start,balance_end,status,api_id,ref_id_start,ref_id_end,update_by) 
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
					array($this->common->getDate(),$this->common->getRealIpAddr(),$txtStatusWord,$txtOpStart,$txtOpIdEnd,$txtNumStart,$txtNumEnd,$txtBalStart,$txtBalEnd,$ddlstatus,$ddlapi,$txtRefStart,$txtRefIdEnd,$ddlupdateBy));
				}
				redirect(base_url()."_Admin/mesage_setting?crypt=".$this->Common_methods->encrypt("MyData"));
						
				
			}
			else if($this->input->post("btnSubmit") == "Update")
			{				
				$Id = $this->input->post("hidID",TRUE);
				$txtStatusWord = trim($this->input->post("txtStatusWord",TRUE));
				$txtOpStart = trim($this->input->post("txtOpStart",TRUE));
				$txtOpIdEnd = trim($this->input->post("txtOpIdEnd",TRUE));
				$txtNumStart = trim($this->input->post("txtNumStart",TRUE));
				$txtNumEnd = trim($this->input->post("txtNumEnd",TRUE));
				$txtBalStart = trim($this->input->post("txtBalStart",TRUE));
				$txtBalEnd = trim($this->input->post("txtBalEnd",TRUE));
				$ddlstatus = trim($this->input->post("ddlstatus",TRUE));
				$ddlapi = trim($this->input->post("ddlapi",TRUE));
				$txtRefStart = trim($this->input->post("txtRefStart",TRUE));
				$txtRefIdEnd = trim($this->input->post("txtRefIdEnd",TRUE));
				$ddlupdateBy = trim($this->input->post("ddlupdateBy",TRUE));
				
				
				$rslt = $this->db->query("select * from message_setting where Id = ?",array($Id));
				if($rslt->num_rows() == 1)
				{
					$this->db->query("update message_setting set 
					api_id = ?,status_word = ?,operator_id_start = ?,operator_id_end = ?,
					number_start = ?,number_end = ?,balance_start= ?,balance_end = ?,status=?,
					ref_id_start = ?,ref_id_end = ?,update_by = ?
					where Id = ?",
					array($ddlapi,$txtStatusWord,$txtOpStart,$txtOpIdEnd,$txtNumStart,$txtNumEnd,$txtBalStart,$txtBalEnd,$ddlstatus,$txtRefStart,$txtRefIdEnd,$ddlupdateBy,$Id));
					
				}
				
				redirect(base_url()."_Admin/mesage_setting?crypt=".$this->Common_methods->encrypt("MyData"));			
			}
			else if( $this->input->post("hidValue") && $this->input->post("action") ) 
			{				
				$Id = $this->input->post("hidValue",TRUE);
				$action = $this->input->post("action",TRUE);
				if($action == "delete")			
				{
					$rslt = $this->db->query("select * from message_setting where Id = ?",array($Id));
					if($rslt->num_rows() == 1)
					{
						$this->db->query("delete from  message_setting  where Id = ?",array($Id));
						
					}
				}
				redirect(base_url()."_Admin/mesage_setting?crypt=".$this->Common_methods->encrypt("MyData"));		
			}
			else
			{
				$user=$this->session->userdata('ausertype');
				if(trim($user) == 'Admin')
				{
					$this->view_data["message"] = "";
					$this->view_data["data"] = $this->db->query("select a.*,b.api_name from message_setting a left join api_configuration b on a.api_id = b.Id order by b.api_name");
					$this->load->view("_Admin/mesage_setting_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																					
			}
		} 
	}	
}