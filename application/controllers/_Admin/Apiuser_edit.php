<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apiuser_edit extends CI_Controller {
	
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
				
				
				$Email = $this->input->post("txtEmail",TRUE);				
				$stateCode = $this->input->post("hidStateCode",TRUE);
				
				$Scheme_id = $this->input->post("ddlSchDesc",TRUE);																
				$User_id = $this->input->post("hiduserid",TRUE);				
				$aadhar_number =$this->input->post("txtAadhar",TRUE);
				
				$gst_no =$this->input->post("txtgst",TRUE);
				$contact_person = $this->input->post("txtConPer",TRUE);
				
				
				
				$txtRespUrl = $this->input->post("txtRespUrl",TRUE);
				$txtIp1 = $this->input->post("txtIp1",TRUE);
				$txtIp2 = $this->input->post("txtIp2",TRUE);
				$txtIp3 = $this->input->post("txtIp3",TRUE);
				$txtIp4 = $this->input->post("txtIp4",TRUE);
				$txtIp5 = "";
				$landline = "";
				
				//print_r($this->input->post());exit;
			
				$user_info = $this->Userinfo_methods->getUserInfo($User_id);
				$groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($Scheme_id));
				if($groupinfo->num_rows() == 1)
				{
					if($groupinfo->row(0)->groupfor == "APIUSER")
					{
						if($user_info->row(0)->mobile_no != $MobNo)
						{
							$mobrslt = $this->db->query("select * from tblusers where mobile_no = ?",array($MobNo));
							if($mobrslt->num_rows() > 0)
							{
								
								$this->session->set_flashdata('message', 'Mobile Number Already Exist, Please Enter Another Mobile Number.');
								$user_id = $this->Common_methods->encrypt($User_id);

								redirect(base_url()."_Admin/apiuser_edit?id=".$this->Common_methods->encrypt($user_id));
								return;
							}
						}

						else
						{
							$rsltupdate = $this->db->query("update tblusers 
								set 
								businessname = ?,
								parentid = ?,
								state_id = ?,
								city_id = ?,
								mobile_no = ?,
								scheme_id = ?
								where user_id = ?

							",array($Dealername,$Parent_id,$State,$City,$MobNo,$Scheme_id,$User_id));	
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
								emailid = ?,
								call_back_url = ?,
								client_ip = ?,
								client_ip2 = ?,
								client_ip3 = ?,
								client_ip4 = ?,
								client_ip5 = ? 
								where user_id = ?
							",array($Address,$Pin,$aadhar_number,$pan_no,$gst_no,$contact_person,$landline,$Email,$txtRespUrl,$txtIp1,$txtIp2,$txtIp3,$txtIp4,$txtIp5,$User_id));	
								$this->session->set_flashdata('message', 'APIUSER Account details updated successfully.');
								redirect(base_url()."_Admin/apiuser_list");
							}
							else
							{
								$this->session->set_flashdata('message', 'APIUSER Account details updated successfully.');
								redirect(base_url()."_Admin/apiuser_list");
							}
						}
					}
					else
					{
						$this->session->set_flashdata('message', 'Invalid Group Selection.');
						redirect(base_url()."_Admin/apiuser_list");
					}
					
				}
				else
				{
					$this->session->set_flashdata('message', 'Invalid Group Selection.');
					redirect(base_url()."_Admin/apiuser_list");
				}
						
					
				
				
				
				
				
			}
			else
			{
					$this->load->view('_Admin/apiuser_edit_view',$data);
			}
		} 			
	}
}
