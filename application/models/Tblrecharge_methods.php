<?php
class Tblrecharge_methods extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getRechargeTblEntry($rechargeId)
	{
		$rlst = $this->db->query("select tblrecharge.*,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name,(select businessname from tblusers where tblusers.user_id = tblrecharge.user_id ) as businessname,(select businessname from tblusers where tblusers.user_id = (select parentid from tblusers where tblusers.user_id = tblrecharge.user_id ) ) as parent_name from tblrecharge where recharge_id = '".$rechargeId."'");
		return $rlst;
	}
	public function getcompany_id($recharge_id)
	{
		$rlst = $this->db->query("select company_id from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->company_id;
	}
	public function getamount($recharge_id)
	{
		$rlst = $this->db->query("select amount from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->amount;
	}
	public function getcommission_amount($recharge_id)
	{
		$rlst = $this->db->query("select commission_amount from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->commission_amount;
	}
	public function getcommission_per($recharge_id)
	{
		$rlst = $this->db->query("select commission_per from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->commission_per;
	}
	public function getmobile_no($recharge_id)
	{
		$rlst = $this->db->query("select mobile_no from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->mobile_no;
	}
	public function getuser_id($recharge_id)
	{
		$rlst = $this->db->query("select user_id from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->user_id;
	}
	public function getadd_date($recharge_id)
	{
		$rlst = $this->db->query("select add_date from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->add_date;
	}
	public function getservice_id($recharge_id)
	{
		$rlst = $this->db->query("select service_id from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->service_id;
	}
	public function getrecharge_type($recharge_id)
	{
		$rlst = $this->db->query("select recharge_type from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->recharge_type;
	}
	public function getrecharge_status($recharge_id)
	{
		$rlst = $this->db->query("select recharge_status from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->recharge_status;
	}
	public function gettransaction_id($recharge_id)
	{
		$rlst = $this->db->query("select transaction_id from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->transaction_id;
	}
	public function getrecharge_by($recharge_id)
	{
		$rlst = $this->db->query("select recharge_by from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->recharge_by;
	}
	public function getExecuteBy($recharge_id)
	{
		$rlst = $this->db->query("select ExecuteBy from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->ExecuteBy;
	}
	public function getdistributer_commission_amount($recharge_id)
	{
		$rlst = $this->db->query("select distributer_commission_amount from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->distributer_commission_amount;
	}
	public function getdistributer_commission_per($recharge_id)
	{
		$rlst = $this->db->query("select distributer_commission_per from tblrecharge where recharge_id = '".$recharge_id."'");
		return $rlst->row(0)->distributer_commission_per;
	}
	public function getCompanyName($recharge_id)
	{
		
		$company_id = $this->getcompany_id($recharge_id);
		$rslt = $this->db->query("select company_name	 from tblcompany where company_id = '".$company_id."'");
		return $rslt->row(0)->company_name;
	}
	public function getDistributerName($recharge_Id)
	{
		$rlst = $this->db->query("select businessname from tblusers where user_id = (select user_id from tblrecharge where tblrecharge.recharge_id = '".$recharge_Id."')");
		return $rlst->row(0)->businessname;
	}
}

?>