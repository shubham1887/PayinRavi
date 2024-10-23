<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distributer_edit extends CI_Controller {
	
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
			if($this->input->post("btnSubmit"))
			{	
			    $host_id = $this->session->userdata("SdId");
				$Dealername = $this->input->post("txtDistname",TRUE);
				$pan_no = $this->input->post("txtpanNo",TRUE);	
				$con_per = $this->input->post("txtConPer",TRUE);		
				$Parent_id = $this->input->post("ddlparent",TRUE);		
				$Address = $this->input->post("txtPostalAddr",TRUE);				
				$Pin = $this->input->post("txtPin",TRUE);
				$State = $this->input->post("ddlState",TRUE);
				$City = $this->input->post("ddlCity",TRUE);				
				$MobNo = $this->input->post("txtMobNo",TRUE);
				
				
				$Email = $this->input->post("txtEmail",TRUE);				
				$stateCode = $this->input->post("hidStateCode",TRUE);
				
				$Scheme_id = $this->input->post("ddlSchDesc",TRUE);		
				$ddlDownSchDesc = $this->input->post("ddlDownSchDesc",TRUE);
				
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
				
				$User_id = $this->input->post("hiduserid",TRUE);		
				
				$aadhar_number =$this->input->post("txtAadhar",TRUE);
				
				$gst_no =$this->input->post("txtgst",TRUE);
				$contact_person = $this->input->post("txtConPer",TRUE);
				$landline = "";
				
				//print_r($this->input->post());exit;
			
				$user_info = $this->Userinfo_methods->getUserInfo($User_id);
				$parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ? and host_id = ?",array(intval($Parent_id),$host_id));
				if($parent_info->num_rows() ==1 )
				{
				    if($parent_info->row(0)->usertype_name == "MasterDealer")
					{
						$groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($Scheme_id));
						
						if($groupinfo->num_rows() == 1)
						{
							if($groupinfo->row(0)->groupfor == "Distributor" or $groupinfo->row(0)->groupfor == "ALL")
							{
								    if($user_info->row(0)->mobile_no != $MobNo)
									{
										$mobrslt = $this->db->query("select count(user_id) as total from tblusers where mobile_no = ? and host_id = ?",array($MobNo,$host_id));
										if($mobrslt->row(0)->total >=  1)
										{

											$this->session->set_flashdata('message', 'Mobile Number Already Exist, Please Enter Another Mobile Number.');
											$user_id = $this->Common_methods->encrypt($User_id);

											redirect(base_url()."SuperDealer/distributer_edit/process/".$user_id);
											return;
										}
										$userrslt = $this->db->query("select count(user_id) as total from tblusers where username = ? and host_id = ?",array($MobNo,$host_id));
										if($userrslt->row(0)->total >=  1)
										{

											$this->session->set_flashdata('message', 'Mobile Number Already Exist, Please Enter Another Mobile Number.');
											$user_id = $this->Common_methods->encrypt($User_id);

											redirect(base_url()."SuperDealer/distributer_edit/process/".$user_id);
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
											downline_scheme = ?,
											flatcomm = ?,
											flatcomm2= ?
											where user_id = ? and host_id = ?

										",array($MobNo,$Dealername,$Parent_id,$State,$City,$MobNo,$Scheme_id,$ddlDownSchDesc,$txtW1FlatComm,$txtW2FlatComm,$User_id,$host_id));	
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
											$this->session->set_flashdata('message', 'Distributor Account details updated successfully.');
											redirect(base_url()."SuperDealer/dist_list");
										}
										else
										{
											$this->session->set_flashdata('message', 'Distributor Account details updated successfully.');
											redirect(base_url()."SuperDealer/dist_list");
										}
									
									
							}
							else
							{
								$this->session->set_flashdata('message', 'Invalid Group Selection.');
								redirect(base_url()."SuperDealer/dist_list");
							}
							
						}
						else
						{
							$this->session->set_flashdata('message', 'Invalid Group Selection.');
							redirect(base_url()."SuperDealer/dist_list");
						}
						
					}
					else
					{
						$this->session->set_flashdata('message', 'Invalid Parent Selection.');
						redirect(base_url()."SuperDealer/dist_list");
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'Invalid Parent Selection.');
					redirect(base_url()."SuperDealer/dist_list");
				}
				
				
				
			}
			else
			{
					$this->load->view('SuperDealer/distributer_edit_view',$data);
			}
		} 			
	}
}
