<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Admin_banks extends CI_Controller {
    public function getBanks() 
	{
		//$stateID = $this->input->post("StateID",TRUE);
		$stateID = $this->uri->segment(4);
		$str_query = "select * from tblbanks where state_id = ? order by city_name";
		$result = $this->db->query($str_query,array($stateID));
		
		echo "<option value='0'>Select City</option>";	
		for($i=0; $i<$result->num_rows(); $i++)
		{
			echo "<option value='".$result->row($i)->city_id."'>".$result->row($i)->city_name."</option>";	
		}		
	}
	public function index()  
	{
	     error_reporting(E_ALL);
ini_set('display_errors', 1);
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 		
		if ($this->session->userdata("aloggedin") != TRUE) 
		{ 
			redirect(base_url()."login"); 
		}			
					
		else 		
		{
			if($this->input->post('HIDACTION') == "INSERT")
			{
			    $host_id = 1;
				$bank_id = $this->input->post("ddlbank");
				$account_name = $this->input->post("account_name");
				$account_number = $this->input->post("account_number");
				$ifsc = $this->input->post("ifsc");
				$branch = $this->input->post("branch");
				
				
				$this->db->query("insert into creditmaster_banks(bank_id,account_name,account_number,ifsc,branch,add_date,ipaddress,host_id) values(?,?,?,?,?,?,?,?)",
				array($bank_id,$account_name,$account_number,$ifsc,$branch,$this->common->getDate(),$this->common->getRealIpAddr(),1));
				
			
				redirect(base_url()."_Admin/admin_banks");
				
			}
			else if($this->input->post('HIDACTION') == "UPDATE")
			{
			    
			   
			    
				$host_id = 1;
				$bank_id = $this->input->post("ddlbank");
				$account_name = $this->input->post("account_name");
				$account_number = $this->input->post("account_number");
				$ifsc = $this->input->post("ifsc");
				$branch = $this->input->post("branch");
				$Id = $this->input->post("hidPrimaryId");
				$this->db->query("update creditmaster_banks  set bank_id = ?, account_name = ?,account_number = ?,ifsc = ?,branch = ?,edit_date = ?,ipaddress = ? where Id = ? ",array($bank_id,$account_name,$account_number,$ifsc,$branch,$this->common->getDate(),$this->common->getRealIpAddr(),$Id));
				redirect(base_url()."_Admin/admin_banks");
			}
			else if($this->input->post('HIDACTION') == "DELETE")
			{
				$Id = $this->input->post("hidPrimaryId");
				$this->db->query("delete from creditmaster_banks  where Id = ?",array($Id));
				redirect(base_url()."_Admin/admin_banks");
			} 	
			else
			{
				$this->view_data["message"]  = "";
				$this->view_data["data"]  = $this->db->query("select a.Id,a.bank_id,a.account_name,a.account_number,a.ifsc,branch,a.add_date,b.bank_name from creditmaster_banks a left join tblbank b on a.bank_id = b.bank_id order by a.Id");
				$this->load->view("_Admin/admin_banks_view",$this->view_data);
			}
		}
	}
}
