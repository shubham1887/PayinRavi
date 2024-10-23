<?php
class Credit_master extends CI_Model 
{
	function _construct()
	{
	   
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getcredit($parentid,$user_id)
	{
		$rslt = $this->db->query("select outstanding from creditmaster where parent_id = ? and chield_id = ? order by Id desc limit 1",array($parentid,$user_id));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->outstanding;
		}
		return 0;
	}

	public function credit_entry($parentid,$user_id,$credit_amount,$creditrevert,$payment_received,$remark,$transaction_date,$payment_type = "")
	{
		$old_outstanding = $this->getcredit($parentid,$user_id);
		$new_outstanding = $old_outstanding - $credit_amount + $creditrevert + $payment_received;
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$insert_rslt = $this->db->query("insert into creditmaster(parent_id,chield_id,credit_amount,creditrevert,payment_received,outstanding,remark,add_date,ipaddress,transaction_date,payment_type)
			values(?,?,?,?,?,?,?,?,?,?,?)",
			array($parentid,$user_id,$credit_amount,$creditrevert,$payment_received,$new_outstanding,$remark,$add_date,$ipaddress,$transaction_date,$payment_type));
		if($insert_rslt == true)
		{
			return true;
		}
	}

}
