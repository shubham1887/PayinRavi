<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_edit extends CI_Controller {
	
	public function process()
	{
		$this->index();
	}
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
	public function index()
	{						
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		}	
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit"))
			{	
			    error_reporting(-1);
			    ini_set('display_errors',1);
			    $this->db->db_debug = TRUE;
				$Dealername = $this->input->post("txtDistname",TRUE);
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$con_per = $this->input->post("txtConPer",TRUE);		
				$Parent_id = $this->session->userdata("MdId");
				$fos_id = $this->input->post("ddlparent");
				$Address = $this->input->post("txtPostalAddr",TRUE);				
				$Pin = $this->input->post("txtPin",TRUE);
				$State = intval(trim($this->input->post("ddlState",TRUE)));
				$City = intval(trim($this->input->post("ddlCity",TRUE)));				
				$MobNo = $this->input->post("txtMobNo",TRUE);
				
				
				$Email = $this->input->post("txtEmail",TRUE);				
				$stateCode = $this->input->post("hidStateCode",TRUE);
				
				$Scheme_id = $this->input->post("ddlSchDesc",TRUE);																
				$User_id = $this->input->post("hiduserid",TRUE);				
				$aadhar_number =$this->input->post("txtAadhar",TRUE);
				
				$gst_no =$this->input->post("txtgst",TRUE);
				$contact_person = $this->input->post("txtConPer",TRUE);
				$landline = "";
				
				//print_r($this->input->post());exit;
				
				$user_info = $this->db->query("select * from tblusers where user_id = ? and parentid = ?",array($User_id,$Parent_id));
				if($user_info->num_rows() == 1)
				{
				    
				    $groupinfo = $this->db->query("select * from tblgroup where user_id = ? and Id = ?",array($Parent_id,$Scheme_id));
				    if($groupinfo->num_rows() == 1)
				    {
				        $fosinfo = $this->db->query("select user_id,usertype_name,parentid from tblusers where user_id = ? and parentid = ? and usertype_name = 'FOS'",array($fos_id,$this->session->userdata("MdId")));
        				if($fosinfo->num_rows() == 0)
        				{
        					$fos_id = 0;
        				}
        				$parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ?",array(intval($Parent_id)));
        				if($parent_info->num_rows() ==1 )
        				{
        					if($parent_info->row(0)->usertype_name == "MasterDealer")
        					{
        					
        									$rsltupdate = $this->db->query("update tblusers 
        										set 
        										
        										state_id = ?,
        										city_id = ?,
        										fos_id = ?,
        										scheme_id = ?
        										where user_id = ?
        
        									",array($State,$City,$fos_id,$Scheme_id,$User_id));	
        									if($rsltupdate == true)
        									{
        									    //echo $User_id;exit;
        										$rsltupdate = $this->db->query("update tblusers_info 
        										set 
        										postal_address = ?,
        										pincode = ?,
        										landline = ?,
        										emailid = ?
        										where user_id = ?
        
        									",array($Address,$Pin,$landline,$Email,$User_id));	
        										$this->session->set_flashdata('message', 'Distributor Account details updated successfully.');
        										redirect(base_url()."MasterDealer/agent_list");
        									}
        									else
        									{
        										$this->session->set_flashdata('message', 'Distributor Account details updated successfully.');
        										redirect(base_url()."MasterDealer/agent_list");
        									}
        								
        							
        					}
        					else
        					{
        						$this->session->set_flashdata('message', 'Invalid Parent Selection.');
        						redirect(base_url()."MasterDealer/agent_list");
        					}
        				}
        				else
        				{
        					$this->session->set_flashdata('message', 'Invalid Parent Selection.');
        					redirect(base_url()."MasterDealer/agent_list");
        				}
				    }
				    else
				    {
				        $this->session->set_flashdata('message', 'Invalid Group.');
						redirect(base_url()."MasterDealer/agent_list");
				    }
				}
				else
				{
				    $this->session->set_flashdata('message', 'Invalid User.');
					redirect(base_url()."MasterDealer/agent_list");
				}
			}
			else
			{
					$this->load->view('MasterDealer/agent_edit_view',$data);
			}
		} 			
	}
}
