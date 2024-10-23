<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetRechargeValues extends CI_Controller {
	
	 

	public function index() 
	{
		if($this->session->userdata("MdUserType") == "")
		{
			echo $this->getvalues();
		}	
		else
		{
			echo "";exit;
		}
	}	
	private function getvalues()
	{
		return $this->session->userdata("MdUserName")."#".$this->session->userdata("MdBusinessName")."#0#".$this->Common_methods->getAgentBalance($this->session->userdata("SdId"))."#".$this->Ew2->getAgentBalance($this->session->userdata("SdId"));
	}
	private function getTotalSuccessRecahrge()
	{
		$rslt = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where Date(add_date) = ? and recharge_status = 'Success' and user_id = ?",array($this->common->getMySqlDate(),$this->session->userdata("SdId")));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->total;
		}
		return "0";
	}
	private function getTotalFailureRecahrge()
	{
		$rslt = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where Date(add_date) = ? and recharge_status = 'Failure' and user_id = ?",array($this->common->getMySqlDate(),$this->session->userdata("SdId")));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->total;
		}
		return "0";
	}
	private function getTotalPendingRecahrge()
	{
		$rslt = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where Date(add_date) = ? and recharge_status = 'Pending' and user_id = ?",array($this->common->getMySqlDate(),$this->session->userdata("SdId")));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->total;
		}
		return "0";
	}
}