<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetRechargeValues extends CI_Controller {
	
	 

	public function index() 
	{
		if($this->session->userdata("AgentUserType") == "Agent")
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
		return $this->session->userdata("AgentUserName")."#".$this->session->userdata("AgentBusinessName")."#0#".round($this->Common_methods->getAgentBalance($this->session->userdata("AgentId")),2)."#".round($this->Ew2->getAgentBalance($this->session->userdata("AgentId")),2);
	}
	private function getTotalSuccessRecahrge()
	{
		$rslt = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where Date(add_date) = ? and recharge_status = 'Success' and user_id = ?",array($this->common->getMySqlDate(),$this->session->userdata("AgentId")));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->total;
		}
		return "0";
	}
	private function getTotalFailureRecahrge()
	{
		$rslt = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where Date(add_date) = ? and recharge_status = 'Failure' and user_id = ?",array($this->common->getMySqlDate(),$this->session->userdata("AgentId")));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->total;
		}
		return "0";
	}
	private function getTotalPendingRecahrge()
	{
		$rslt = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where Date(add_date) = ? and recharge_status = 'Pending' and user_id = ?",array($this->common->getMySqlDate(),$this->session->userdata("AgentId")));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->total;
		}
		return "0";
	}
}