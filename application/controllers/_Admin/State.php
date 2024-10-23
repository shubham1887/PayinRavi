<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
        class State extends CI_Controller {
        
    	    public function index()  
    	    {
    		    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    		    $this->output->set_header("Pragma: no-cache"); 		
    		if ($this->session->userdata("aloggedin") != TRUE) 
    		{ 
    			redirect(base_url()."login"); 
    		}			
					
    		else 		
    		{	if($this->input->post('HIDACTION') == "INSERT")
			{	$StateName = $this->input->post("txtStateName");	$this->db->query("insert into tblstate(state_name,add_date,ipaddress) values(?,?,?)",array($StateName,$this->common->getDate(),$this->common->getRealIpAddr()));
    		
    			
    				
    			
    				redirect(base_url()."_Admin/State");
    				
    			}	else if($this->input->post('HIDACTION') == "UPDATE")
			{
				$StateName = $this->input->post("txtStateName");$Id = $this->input->post("hidPrimaryId");
				$this->db->query("update tblstate  set state_name = ?,  = ?,edit_date = ?,ipaddress = ? where Id = ?",array($StateName,$StateName,$this->common->getDate(),$this->common->getRealIpAddr(),$Id));
				redirect(base_url()."_Admin/State");
			}else if($this->input->post('HIDACTION') == "DELETE")
			{
				$Id = $this->input->post("hidPrimaryId");
				$this->db->query("delete from tblstate  where Id = ?",array($Id));
				redirect(base_url()."_Admin/State");
			} else
			{
				$this->view_data["message"]  = "";	$this->view_data["data"]  = $this->db->query("select a.* from tblstate a "); $this->load->view("_Admin/State_view",$this->view_data);
			}}}}