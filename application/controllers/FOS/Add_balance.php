<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_balance extends CI_Controller {
	

	private $msg='';
	public function process()
	{  
		if($this->session->userdata("FOSUserType") != "FOS")
		{
			redirect("login");exit;
		}
		
		if($this->Common_methods->decrypt($this->uri->segment(6)) == "Add")
		{
			
			if($this->input->post('btnSubmit'))
			{
				
			$redirect_flag = $this->Common_methods->decrypt($this->uri->segment(5));
			
			if($this->session->userdata('ReadOnly') == true)
			{
				$this->session->set_flashdata('message', 'Read Only Mode Enabled');	
				redirect("FOS/".$redirect_flag);
			}
			
			$amount = $this->input->post('txtAmount');
			if($amount <= 0)
			{
				$this->session->set_flashdata('message', 'Invalid Amount.');	
				redirect("FOS/".$redirect_flag);
			}
			
			$cr_user_id = $this->input->post('hidUserID');
			$userinfo = $this->Userinfo_methods->getUserInfo($cr_user_id);
			if($userinfo->num_rows() == 0)
			{
				$this->session->set_flashdata('message', 'User Not Exists.');	
				redirect("FOS/".$redirect_flag);
			}
			
			$this->load->model('Add_balance_model');	
			$payment_type= $this->input->post('hidpaymentType');
			$remark = $this->input->post('txtRemark');
			$transaction_type = "PAYMENT";
			$dr_user_id  = $this->session->userdata("FOSId");
			$description =  $this->Insert_model->getCreditPaymentDescription($cr_user_id, $dr_user_id,$amount);
			
			if($this->Common_methods->CheckBalance($dr_user_id,$amount) == false)
			{
				$this->session->set_flashdata('message', 'You Dont Have Sufficient Balance .');	
				redirect("FOS/".$redirect_flag);			
					
			}
			$this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
			$this->load->model("Sms");
			$bal = $this->Common_methods->getBalanceByUserType($cr_user_id,$userinfo->row(0)->usertype_name);
			$this->Sms->receiveBalance($userinfo,$amount,$bal);
			$this->session->set_flashdata('message', 'Balance Add Successfull.');	
			redirect("FOS/".$redirect_flag);	
		}	
			else
			{
		
		$user_id = $this->Common_methods->decrypt($this->uri->segment(4));
	
		$action =  $this->Common_methods->decrypt($this->uri->segment(5));
		$this->load->model('Add_balance_model');
		$this->view_data['result_users'] =$this->db->query("
			select 
		a.user_id,
		a.parentid,
		a.businessname,
		a.mobile_no,
		a.usertype_name,
		a.add_date,
		a.status,
		a.username,
		a.password,
		a.txn_password,
		state.state_name,
		city.city_name,
		p.businessname as parent_name,
		p.username as parent_username,
		a.grouping,
		a.mt_access,
		a.dmr_group,
		g.group_name,
		info.emailid,
		info.pan_no,
		info.postal_address,
		info.landline,
		info.contact_person,
		info.pincode
		from tblusers a 
		left join tblstate state on a.state_id = state.state_id
		left join tblcity city on a.city_id = city.city_id
		left join tblusers p on a.parentid = p.user_id
		left join tblgroup	g on a.scheme_id = g.Id
		left join tblusers_info info on a.user_id = info.user_id
		where 
		a.user_id = ?
			",array($user_id));				
		$this->load->model('recharge_home_model');
		$this->view_data['BalanceAmount'] = $this->Common_methods->getCurrentBalance($user_id);
		
		
		$this->view_data['message'] =$this->msg;
		$this->load->view('FOS/add_balance_view',$this->view_data);	
		}
		}
		else if($this->Common_methods->decrypt($this->uri->segment(6)) == "Revert")
		{
			if($this->input->post('btnSubmit'))
			{
			$redirect_flag = $this->Common_methods->decrypt($this->uri->segment(5));
			
			
			if($this->session->userdata('ReadOnly') == true)
			{
				$this->session->set_flashdata('message', 'Read Only Mode Enabled');	
				redirect("FOS/".$redirect_flag);
			}
			
			$amount = $this->input->post('txtAmount');
			$Otp = $this->input->post('txtOtp');
			
			$dr_user_id = $this->Common_methods->decrypt($this->uri->segment(4));
			if($this->checkOtp($dr_user_id,$Otp)== false)
			{
				$this->session->set_flashdata('message', 'Invalid Otp.');	
				redirect("FOS/".$redirect_flag);exit;
			}
			
			
			$retbal = $this->Common_methods->getAgentBalance($dr_user_id);
			if($retbal < $amount)
			{
				$this->session->set_flashdata('message', 'Insufficient  Amount.');	
				redirect("FOS/".$redirect_flag);exit;
			}
			
			$this->load->model('Add_balance_model');	
			$payment_type= $this->input->post('hidpaymentType');
			$remark = $this->input->post('txtRemark');
			$transaction_type = "REVERT_PAYMENT";
			$cr_user_id  =  $this->session->userdata("FOSId");
			$description =  $this->Insert_model->getRevertPaymentDescription($cr_user_id, $dr_user_id,$amount);
			
			if($amount <= 0)
			{
				$this->session->set_flashdata('message', 'Invalid Amount.');	
				redirect("FOS/".$redirect_flag);exit;
			}
			$userinfo = $this->Userinfo_methods->getUserInfo($dr_user_id);
			if($userinfo->num_rows() == 0)
			{
				$this->session->set_flashdata('message', 'User Not Exists.');	
				redirect("FOS/".$redirect_flag);
			}
			
			$this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
			$this->load->model("Sms");
			$bal = $this->Common_methods->getBalanceByUserType($dr_user_id,$userinfo->row(0)->usertype_name);
			$this->Sms->revertBalance($userinfo,$amount,$bal);
			$newotp = $this->common->getOTP();
			$this->db->query("update tblusers set otp = ? where user_id = ?",array($newotp,$dr_user_id));
			
			$this->session->set_flashdata('message', 'Balance Revert Successfull.');	
			
			redirect("FOS/".$redirect_flag);
		}	
			else
			{
				$user_id = $this->Common_methods->decrypt($this->uri->segment(4));
				$userinfo = $this->Userinfo_methods->getUserInfo($user_id);
				if($userinfo->num_rows() == 0)
				{
					$this->session->set_flashdata('message', 'User Not Exists.');	
					redirect("FOS/".$redirect_flag);
				}
				$this->load->model('Add_balance_model');
				$this->view_data['result_users'] =$this->Add_balance_model->GetUserInfo($user_id);		
				$this->load->model('recharge_home_model');
				$this->view_data['BalanceAmount'] = $this->Common_methods->getCurrentBalance($user_id);
				$this->view_data['message'] =$this->msg;
				$this->load->view('FOS/add_balance_view',$this->view_data);	
			}
		}
	}
	
	public function checkOtp($dr_user_id,$Otp)
	{
		$rslt = $this->db->query("select otp from tblusers where user_id = ?",array($dr_user_id));
		if($Otp == $rslt->row(0)->otp)
		{
			return true;
		}
		else
		{
			return true;	
		}
	}
	
	public function index() 
	{
			
	}	
}