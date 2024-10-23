<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
        class Dmt_slabs extends CI_Controller {
        
    	    public function index()  
    	    {
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
				$ddlgroup = $this->input->post("ddlgroup");	
				$AmountFrom = $this->input->post("txtAmountFrom");	
				$AmountTo = $this->input->post("txtAmountTo");	
				$charge_type = $this->input->post("txtcharge_type");	
				$charge_amount = $this->input->post("txtcharge_amount");	
				$this->db->query("insert into mt_commission_slabs(group_id,range_from,range_to,charge_type,charge_amount,add_date,ipaddress) values(?,?,?,?,?,?,?)",array($ddlgroup,$AmountFrom,$AmountTo,$charge_type,$charge_amount,$this->common->getDate(),$this->common->getRealIpAddr()));
    		
    			
    				
    			
    				redirect(base_url()."_Admin/Dmt_slabs");
    				
    			}	
			else if($this->input->post('HIDACTION') == "UPDATE")
			{
			
				$ddlgroup = $this->input->post("ddlgroup");	
				$groupinfo = $this->db->query("select * from mt3_group where Id = ?",array($ddlgroup));
				if($groupinfo->num_rows() == 1)
				{
					$AmountFrom = $this->input->post("txtAmountFrom");	
					$AmountTo = $this->input->post("txtAmountTo");
					$Id = $this->input->post("hidPrimaryId");
					$txtcharge_type = $this->input->post("txtcharge_type");
					$txtcharge_amount = $this->input->post("txtcharge_amount");
					$this->db->query("update mt_commission_slabs  set range_from = ?, range_to = ?,charge_type = ?,charge_amount=?,edit_date = ?,ipaddress = ? where Id = ?",array($AmountFrom,$AmountTo,$txtcharge_type,$txtcharge_amount,$this->common->getDate(),$this->common->getRealIpAddr(),$Id));
				}
				
				redirect(base_url()."_Admin/Dmt_slabs?crypt1=".$this->Common_methods->encrypt($groupinfo->row(0)->Name)."&crypt2=".$this->Common_methods->encrypt($ddlgroup));
			}
			else if($this->input->post('HIDACTION') == "DELETE")
			{
				$Id = $this->input->post("hidPrimaryId");
				$this->db->query("delete from mt_commission_slabs  where Id = ?",array($Id));
				redirect(base_url()."_Admin/Dmt_slabs");
			} 
			else
			{
			
				if(isset($_GET["crypt1"]) and isset($_GET["crypt2"]))
				{
					$user=$this->session->userdata('ausertype');
					if(trim($user) == 'Admin')
					{
						$this->view_data['data'] = $this->db->query("select a.*,b.Name from mt_commission_slabs a left join mt3_group b on a.group_id = b.Id where a.group_id = ? order by a.range_from",array($this->Common_methods->decrypt($this->input->get("crypt2"))));
						$this->view_data['message'] ="";
						$this->load->view('_Admin/Dmt_slabs_view',$this->view_data);		
					}
					else
					{redirect(base_url().'adminlogin');}																					
				}
				else
				{
					$this->view_data["message"]  = "";	
					$this->view_data['data'] = $this->db->query("select a.*,b.Name from mt_commission_slabs a left join mt3_group b on a.group_id = b.Id  order by a.range_from");
					$this->load->view("_Admin/Dmt_slabs_view",$this->view_data);
				}
			
				
			}}}}