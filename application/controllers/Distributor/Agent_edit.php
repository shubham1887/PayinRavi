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
		if ($this->session->userdata('DistUserType') != "Distributor") 
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

		if ($this->session->userdata('DistUserType') != "Distributor") 
		{ 
			redirect(base_url().'login'); 
		}	
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit"))
			{				
				$Dealername = $this->input->post("txtDistname",TRUE);
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$con_per = $this->input->post("txtConPer",TRUE);		
				$Parent_id = $this->session->userdata("DistId");
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
				$user_info = $this->db->query("select * from tblusers where user_id = ? and parentid = ?",array($User_id,$Parent_id));
				if($user_info->num_rows() == 1)
				{
				    
				    $groupinfo = $this->db->query("select * from tblgroup where user_id = ? and Id = ?",array($Parent_id,$Scheme_id));
				    if($groupinfo->num_rows() == 1)
				    {
				        $fosinfo = $this->db->query("select user_id,usertype_name,parentid from tblusers where user_id = ? and parentid = ? and usertype_name = 'FOS'",array($fos_id,$this->session->userdata("DistId")));
        				if($fosinfo->num_rows() == 0)
        				{
        					$fos_id = 0;
        				}
        				$parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ?",array(intval($Parent_id)));
        				if($parent_info->num_rows() ==1 )
        				{
        					if($parent_info->row(0)->usertype_name == "Distributor")
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
        										$this->session->set_flashdata('message', 'Retailer Account details updated successfully.');
        										redirect(base_url()."Distributor/agent_list");
        									}
        									else
        									{
        										$this->session->set_flashdata('message', 'Retailer Account details updated successfully.');
        										redirect(base_url()."Distributor/agent_list");
        									}
        								
        							
        					}
        					else
        					{
        						$this->session->set_flashdata('message', 'Invalid Parent Selection.');
        						redirect(base_url()."Distributor/agent_list");
        					}
        				}
        				else
        				{
        					$this->session->set_flashdata('message', 'Invalid Parent Selection.');
        					redirect(base_url()."Distributor/agent_list");
        				}
				    }
				    else
				    {
				        $this->session->set_flashdata('message', 'Invalid Group.');
						redirect(base_url()."Distributor/agent_list");
				    }
				}
				else
				{
				    $this->session->set_flashdata('message', 'Invalid User.');
					redirect(base_url()."Distributor/agent_list");
				}
				
			}
			else
			{
					$this->load->view('Distributor/agent_edit_view',$data);
			}
		} 			
	}
	
	
	public function change_commission()
	{
	   if(isset($_POST["user_id"]) and isset($_POST["company_id"]) and isset($_POST["commission"]))
	   {
	       $user_id = trim($this->input->post("user_id"));
	       $company_id = trim($this->input->post("company_id"));
	       $commission = floatval(trim($this->input->post("commission")));
	      
	        if( $commission > 0 and $commission < 4)
	        {
	            $userinfo = $this->db->query("select user_id from tblusers where user_id = ? and usertype_name = 'Agent' and parentid = ?",array(intval($user_id),$this->session->userdata("DistId")));
	            if($userinfo->num_rows() == 1)
    	       {
    	           
    	           $dist_commissioninfo = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($this->session->userdata("DistId"),intval($company_id)));
    	           if($dist_commissioninfo->num_rows() == 1)
    	           {
    	               $dist_commission = floatval($dist_commissioninfo->row(0)->commission);
    	               if($dist_commission > $commission)
    	               {
    	                   $getcommissioninfo = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array(intval($user_id),intval($company_id)));
            	           if($getcommissioninfo->num_rows() == 1)
            	           {
            	               $this->db->query("update tbluser_commission set commission = ? where user_id = ? and company_id = ?",array($commission,intval($user_id),intval($company_id)));
            	               echo "done";exit;
            	           }
            	           else
            	           {
            	               $this->db->query("insert into tbluser_commission(user_id,company_id,commission_type,commission,add_date,ipaddress) values(?,?,?,?,?,?)",
            	               array($user_id,$company_id,"PER",$commission,$this->common->getDate(),$this->common->getRealIpAddr()));
            	               echo "done";exit;
            	           } 
    	               }
    	               else
    	               {
    	                   echo "You Cant Set Commission Grater Than You Receive";exit;
    	               } 
    	           }
    	           else
    	           {
    	               echo "Your Commission Not Configured. Contact Administrator";exit;
    	           }
    	       }   
	        }
	   }
	}
}
