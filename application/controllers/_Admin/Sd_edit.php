<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sd_edit extends CI_Controller {
	
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
        $this->load->model("Service_model");
        $this->load->model("User_update_model");

        $this->load->model("Api_model");
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;
    }
	public function process()
	{
		$this->index();
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
			if($this->input->post("btnSubmit"))
			{				
				$Dealername = $this->input->post("txtDistname",TRUE);
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$con_per = $this->input->post("txtConPer",TRUE);		
				$Parent_id = $this->input->post("ddlparent",TRUE);		
				$Address = $this->input->post("txtPostalAddr",TRUE);				
				$Pin = $this->input->post("txtPin",TRUE);
				$State = $this->input->post("ddlState",TRUE);
				$City = $this->input->post("ddlCity",TRUE);				
				$MobNo = $this->input->post("txtMobNo",TRUE);
				$txtW1FlatComm = $this->input->post("txtW1FlatComm",TRUE);
				$txtW2FlatComm = $this->input->post("txtW2FlatComm",TRUE);
				if($txtW1FlatComm > 5)
				{
				    $txtW1FlatComm = 0;
				}
				if($txtW2FlatComm > 5)
				{
				    $txtW2FlatComm = 0;
				}
				
				
				$Email = $this->input->post("txtEmail",TRUE);				
				$stateCode = $this->input->post("hidStateCode",TRUE);
				
				$Scheme_id = $this->input->post("ddlSchDesc",TRUE);																
				$User_id = $this->input->post("hiduserid",TRUE);				
				$aadhar_number =$this->input->post("txtAadhar",TRUE);
				$hostlimit = $this->input->post("txtLimit",TRUE);
				$gst_no =$this->input->post("txtgst",TRUE);
				$contact_person = $this->input->post("txtConPer",TRUE);
				$landline = "";
				
				//print_r($this->input->post());exit;
			
				$user_info = $this->db->query("select a.mobile_no from tblusers a where a.user_id = ? and a.usertype_name = 'SuperDealer'",array($User_id));
				if($user_info->num_rows() == 1)
				{
				    $hostlimit_info = $this->db->query("select * from tblhostlimit where host_id = ?",array($User_id));
				    if($hostlimit_info->num_rows() == 1)
				    {
				        $this->db->query("update tblhostlimit set hostlimit = ? where host_id = ?",array($hostlimit,$User_id));
				    }
				    else
				    {
				        $this->db->query("insert into tblhostlimit(host_id,hostlimit,add_date) values(?,?,?)",array($User_id,$hostlimit,$this->common->getDate()));
				    }
				}
				
				
						$groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($Scheme_id));
						if($groupinfo->num_rows() == 1)
						{
							if($groupinfo->row(0)->groupfor == "SuperDealer" or $groupinfo->row(0)->groupfor == "ALL")
							{
								if($user_info->row(0)->mobile_no != $MobNo)
								{
									$mobrslt = $this->db->query("select * from tblusers where mobile_no = ? ",array($MobNo));
									if($mobrslt->num_rows() > 0)
									{
										
										$this->session->set_flashdata('message', 'Mobile Number Already Exist, Please Enter Another Mobile Number.');
										$user_id = $this->Common_methods->encrypt($User_id);

										redirect(base_url()."_Admin/sd_edit/process/".$user_id);
										return;
									}
									$userrslt = $this->db->query("select * from tblusers where username = ? ",array($MobNo));
									if($userrslt->num_rows() > 0)
									{
										
										$this->session->set_flashdata('message', 'Mobile Number Already Exist, Please Enter Another Mobile Number.');
										$user_id = $this->Common_methods->encrypt($User_id);

										redirect(base_url()."_Admin/sd_edit/process/".$user_id);
										return;
									}
								}

								
								
								
									$rsltupdate = $this->db->query("update tblusers 
										set 
										username = ?,
										businessname = ?,
										parentid = ?,
										state_id = ?,
										city_id = ?,
										mobile_no = ?,
										scheme_id = ?,
										flatcomm = ?,
										flatcomm2= ?
										where user_id = ?

									",array($MobNo,$Dealername,$Parent_id,$State,$City,$MobNo,$Scheme_id,$txtW1FlatComm,$txtW2FlatComm,$User_id));	
									if($rsltupdate == true)
									{
										$rsltupdate = $this->db->query("update tblusers_info 
										set 
										postal_address = ?,
										pincode = ?,
										aadhar_number = ?,
										pan_no = ?,
										gst_no = ?,
										contact_person = ?,
										landline = ?,
										emailid = ?
										where user_id = ?

									",array($Address,$Pin,$aadhar_number,$pan_no,$gst_no,$contact_person,$landline,$Email,$User_id));	
										$this->session->set_flashdata('message', 'SuperDistributor Account details updated successfully.');
										redirect(base_url()."_Admin/sd_list");
									}
									else
									{
										$this->session->set_flashdata('message', 'SuperDistributor Account details updated successfully.');
										redirect(base_url()."_Admin/sd_list");
									}
								
							}
							else
							{
								$this->session->set_flashdata('message', 'Invalid Group Selection.');
								redirect(base_url()."_Admin/sd_list");
							}
							
						}
						else
						{
							$this->session->set_flashdata('message', 'Invalid Group Selection.');
							redirect(base_url()."_Admin/md_list");
						}
						
					
				
				
				
				
				
			}
			else
			{
					$this->load->view('_Admin/sd_edit_view',$data);
			}
		} 			
	}
}
