<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	
	public function index()
	{ 
		
#$rslt = $this->db->query("select * from tblusers");
//print_r($this->input->post());exit;		
if($this->input->post("MobileNumber"))
		{
			$MobileNumber  = trim($this->input->post("MobileNumber"));
			if(strlen($MobileNumber) == 10)
			{
				$rsltuserinfo = $this->db->query("select a.password,a.username,a.txn_password,a.user_id,a.businessname,a.usertype_name,a.mobile_no,a.status ,a.mt_access,a.balance,info.pincode,
				info.emailid,info.postal_address,info.aadhar_number,info.pan_no,info.gst_no,g.group_name
				from tblusers a 
				left join tblusers_info info on a.user_id = info.user_id
				left join tblgroup g on a.scheme_id = g.Id
				where a.mobile_no = ?",array($MobileNumber));
				if($rsltuserinfo->num_rows() == 1)
				{
					$user_mobile = $rsltuserinfo->row(0)->mobile_no;
					$smsMessage = "Dear ".$rsltuserinfo->row(0)->businessname." Your Login Detail User Id : ".$rsltuserinfo->row(0)->username."  Password : ".$rsltuserinfo->row(0)->password." Transaction Password : ".$rsltuserinfo->row(0)->txn_password."";
					//echo $smsMessage;exit;
				$this->load->model("Sms");
				$result_sms = $this->common->ExecuteSMSApi($user_mobile,$smsMessage);

				$this->session->set_flashdata("MESSAGEBOXTYPE","SUCCESS");
				$this->session->set_flashdata("MESSAGEBOX","Password Sent To Your Registered Mobile Number");
					redirect(base_url()."login");
				}
				else
				{
					redirect(base_url()."login");
				}
			}
		}
		else
		{
			$this->load->view("Forgot_password");
		}
	}	
}
