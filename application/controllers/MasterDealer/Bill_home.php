<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bill_home extends CI_Controller {
 	
		
		
	public function index()
	{	
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			//print_r($this->input->post());exit;
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('DistUserType');			
			if(trim($user) == 'Distributor')
			{
				if($this->input->post("hidSubmitRecharge") == "Success")				
				{
					//print_r($this->input->post());exit;
					$user_id = $this->session->userdata("MdId");
					$ddlbiller =	$this->input->post("ddlbiller",true);
					$txtCustName = $this->input->post("txtCustName",true);
					$txtMobileNo=$this->input->post("txtMobileNo",true);	
					$txtAmount =	$this->input->post("txtAmount",true);
					$txtCustAccNo = $this->input->post("txtCustAccNo",true);
					
					$current_bal = $this->Common_methods->getAgentBalance($user_id);
					if($txtAmount < 10)
					{	
						$this->session->set_flashdata('message', 'Minimum amount 10 INR For Recharge.');
						redirect(base_url()."MasterDealer/bill_home");			
					}
				
					$user_info = $this->Userinfo_methods->getUserInfo($user_id);	
					if($current_bal >= $txtAmount)
					{				
						if($this->checkpending($user_id,$ddlbiller,$txtAmount,$txtCustAccNo) == true)
						{
							$response = $this->ProcessBill($user_id,$ddlbiller,$txtCustName,$txtMobileNo,$txtAmount,$txtCustAccNo);
							$this->session->set_flashdata('message', $response);
							redirect(base_url()."MasterDealer/bill_home");	
						}												
						else
						{
							$this->session->set_flashdata('message', "Already In Pending");
							redirect(base_url()."MasterDealer/bill_home");	
						}
						
					
					}
					else
					{
						$this->session->set_flashdata('message', 'Insufficient Balance');
						redirect(base_url()."MasterDealer/recharge_home");	
					}
				
				}
				else
				{					
						$this->view_data['message'] ="";
						$this->load->view('MasterDealer/bill_home_view',$this->view_data);
				}
			} 
		}
	}
	private function ProcessBill($user_id,$ddlbiller,$txtCustName,$txtMobileNo,$txtAmount,$txtCustAccNo)
	{
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		$add_date = $this->common->getDate();
		$ip = $this->common->getRealIpAddr();
		$this->db->query("insert into tblbillpay(cust_name,commission,add_date,ipaddress,status,user_id,company_name,cust_mob_no,amount,cust_acc_no) values (?,?,?,?,?,?,?,?,?,?)",array($txtCustName,"5",$add_date,$ip,"Pending",$user_id,$ddlbiller,$txtMobileNo,$txtAmount,$txtCustAccNo));
		$id = $this->db->insert_id();
		$Description = "BILL PAYMENT :: ".$ddlbiller." | ".$txtAmount." | ".$txtCustName." | BILL ID = ".$id;
		$dr_amount = $txtAmount + 5;
		$this->tblewallet_DrEntry($user_id,$id,$dr_amount,$Description);
		return "Request Submited Successfully";
	}
	private function checkpending($user_id,$ddlbiller,$txtAmount,$txtCustAccNo)
	{
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		$rslt = $this->db->query("select * from tblbillpay where user_id = ? and company_name = ? and amount = ? and cust_acc_no = ? and status = 'Pending'",array($user_id,$ddlbiller,$txtAmount,$txtCustAccNo));	
		if($rslt->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	private function tblewallet_DrEntry($user_id,$billid,$dr_amount,$Description)
	{
		if ($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		$transaction_type = "PAYMENT";
		$str_checkdebited = $this->db->query("select debited from tblbillpay where Id = ?",array($billid));
		if($str_checkdebited->row(0)->debited == "yes")
		{
			return true;
		}
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();

		$old_balance = $this->Common_methods->getCurrentBalance($user_id);
		$current_balance = $old_balance - $dr_amount;
		
		$str_query = "insert into  tblewallet(user_id,transaction_type,debit_amount,balance,description,add_date)
		values(?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date));
		$ewallet_id = $this->db->insert_id();
		$rslt_updtrec = $this->db->query("update tblbillpay set debited='yes',reverted='no', debitid = CONCAT_WS(',',debitid,?) where Id = ?",array($ewallet_id,$billid));
		return true;
	}
}	