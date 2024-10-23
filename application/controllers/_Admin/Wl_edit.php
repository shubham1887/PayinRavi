<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wl_edit extends CI_Controller {
	
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
				$Parent_id = 1;		
				$Address = $this->input->post("txtPostalAddr",TRUE);				
				$Pin = $this->input->post("txtPin",TRUE);
				$State = $this->input->post("ddlState",TRUE);
				$City = $this->input->post("ddlCity",TRUE);				
				$MobNo = $this->input->post("txtMobNo",TRUE);
				$LandNo = $this->input->post("txtLandNo",TRUE);
				$RetType = $this->input->post("ddlRetType",TRUE);
				$Email = $this->input->post("txtEmail",TRUE);				
				$stateCode = $this->input->post("hidStateCode",TRUE);
				$Scheme_id = $this->input->post("ddlSchDesc",TRUE);																
				$Scheme_amt = $this->input->post("hid_scheme_amount",TRUE);
				$SmsCode = $this->input->post("txtSmsCode",TRUE);
				$User_id = $this->input->post("hiduserid",TRUE);				
				
				$this->load->model('Distributer_edit_model');
				$user_info = $this->Userinfo_methods->getUserInfo($User_id);
				if($user_info->row(0)->mobile_no != $MobNo)
				{
					$mobrslt = $this->db->query("select * from tblusers where mobile_no = ?",array($MobNo));
					if($mobrslt->num_rows() > 0)
					{
						$this->session->set_flashdata('message', 'Mobile Number Already Exist, Please Enter Another Mobile Number.');
						$user_id = $this->Common_methods->encrypt($User_id);
						
						redirect(base_url()."_Admin/wl_edit/process/".$user_id);
						return;
					}
				}
				
				$this->load->library('common');
				$ip = $this->common->getRealIpAddr();
				$date = $this->common->getDate();				
				$str_query = "update tblusers  set businessname=?,parentid=?,postal_address=?,pincode=?,state_id=?,city_id=?,mobile_no=?, landline=?,retailer_type_id=?,emailid=?,edit_date=?,ipaddress=?,scheme_id=?,scheme_amount=?,pan_no=?,contact_person=?,smskeyword=? where user_id=?";
				$result = $this->db->query($str_query,array($Dealername,$Parent_id,$Address,$Pin,$State,$City,$MobNo,$LandNo,$RetType,$Email,$date,$ip,$Scheme_id,$Scheme_amt,$pan_no,$con_per,$SmsCode,$User_id));	
				$this->session->set_flashdata('message', 'Dealer Account details updated successfully.');
						redirect(base_url()."_Admin/wl_list");		
			}
			else
			{
					$this->load->view('_Admin/wl_edit_view',$data);
			}
		} 			
	}
}
