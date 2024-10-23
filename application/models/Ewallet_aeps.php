<?php
class Ewallet_aeps extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
		  error_reporting(-1);
		  ini_set('display_errors',1);
		  $this->db->db_debug = TRUE;
	}
	public function getAgentBalance($user_id)
	{
		$rsltuserbalance = $this->db->query("select balance3 from tbluserbalance where user_id = ?",array(intval($user_id)));
		if($rsltuserbalance->num_rows() == 1)
		{
			return $rsltuserbalance->row(0)->balance3;
		}
		return 0;
	}
	







	public function AepsCreditEntry($user_id,$amount,$commission_amount,$aeps_id,$description)
	{	
		
		$payment_type = "AEPS";
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "AEPS";
		$remark = "AEPS : Id".$aeps_id." | Amount : ".$amount." | Commission : ".$commission_amount;
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	

		$cr_user_id = $user_id;
		$dr_user_id = 1;

		$credit_amount = $amount;
		$debit_amount = $amount;
		$recharge_id = 0;
		$payment_id = 0;

		$dr = $this->debit_entry($dr_user_id,$debit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id);
		if($dr == true)
		{
			$cr = $this->credit_entry($cr_user_id,$credit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id);
			if($cr == true)
			{
				$transaction_type = "AEPS_COMMISSION";
				$dr_comm = $this->debit_entry($dr_user_id,$commission_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id);
				if($dr_comm == true)
				{
					$cr_comm = $this->credit_entry($cr_user_id,$commission_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id);
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}







	public function PayoutDebitEntry($user_id,$amount,$transaction_charge,$payout_id,$description)
	{	
		$aeps_id = 0;
		$payment_type = "PAYOUT";
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "PAYOUT";
		$remark = "PAYOUT : Id".$payout_id." | Amount : ".$amount." | Charge : ".$transaction_charge;
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	

		$cr_user_id = 1;
		$dr_user_id = $user_id;

		$credit_amount = $amount;
		$debit_amount = $amount;
		$recharge_id = 0;
		$payment_id = 0;

		$dr = $this->debit_entry($dr_user_id,$debit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
		if($dr == true)
		{
			$cr = $this->credit_entry($cr_user_id,$credit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
			if($cr == true)
			{
				$transaction_type = "PAYOUT_CHARGE";
				$dr_comm = $this->debit_entry($dr_user_id,$transaction_charge,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
				if($dr_comm == true)
				{
					$cr_comm = $this->credit_entry($cr_user_id,$transaction_charge,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}


	public function PayoutCreditEntry($user_id,$amount,$transaction_charge,$payout_id,$description)
	{	
		$aeps_id = 0;
		$payment_type = "PAYOUT";
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "PAYOUT";
		$remark = "PAYOUT : Id".$payout_id." | Amount : ".$amount." | Charge : ".$transaction_charge;
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	

		$cr_user_id = $user_id;
		$dr_user_id = 1;

		$credit_amount = $amount;
		$debit_amount = $amount;
		$recharge_id = 0;
		$payment_id = 0;

		$dr = $this->debit_entry($dr_user_id,$debit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
		if($dr == true)
		{
			$cr = $this->credit_entry($cr_user_id,$credit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
			if($cr == true)
			{
				$transaction_type = "PAYOUT_CHARGE";
				$dr_comm = $this->debit_entry($dr_user_id,$transaction_charge,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$ref_id);
				if($dr_comm == true)
				{
					$cr_comm = $this->credit_entry($cr_user_id,$transaction_charge,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$ref_id);
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}




	public function AdhharVerificationDebitEntry($user_id,$transaction_charge,$ref_id,$description)
	{	
		$aeps_id = 0;
		$payment_type = "ADHAAR";
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "ADHAAR";
		$remark = "ADHAAR : Id".$ref_id." | Charge : ".$transaction_charge;
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	

		$cr_user_id = 1;
		$dr_user_id = $user_id;

		$credit_amount = $transaction_charge;
		$debit_amount = $transaction_charge;
		$recharge_id = 0;
		$payment_id = 0;

		$dr = $this->debit_entry($dr_user_id,$debit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$ref_id);
		if($dr == true)
		{
			$cr = $this->credit_entry($cr_user_id,$credit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$ref_id);
			if($cr == true)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}






	public function MoveToMainWalletDebitEntry($user_id,$amount,$transaction_charge,$payout_id,$description)
	{	
		$aeps_id = 0;
		$payment_type = "WALLET";
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "PAYOUT";
		$remark = "PAYOUT TO MAIN WALLET : Id".$payout_id." | Amount : ".$amount." | Charge : ".$transaction_charge;
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	

		$cr_user_id = 1;
		$dr_user_id = $user_id;

		$credit_amount = $amount;
		$debit_amount = $amount;
		$recharge_id = 0;
		$payment_id = 0;

		$dr = $this->debit_entry($dr_user_id,$debit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
		if($dr == true)
		{
			$cr = $this->credit_entry($cr_user_id,$credit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
			if($cr == true)
			{
				if($transaction_charge > 0)
				{
					$transaction_type = "PAYOUT_CHARGE";
					$dr_comm = $this->debit_entry($dr_user_id,$transaction_charge,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
					if($dr_comm == true)
					{
						$cr_comm = $this->credit_entry($cr_user_id,$transaction_charge,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id,$payout_id);
					}	
				}
				
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}

	




	private function credit_entry($cr_user_id,$credit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id = 0,$ref_id = 0)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();


		$this->db->query("update tbluserbalance set balance3 = balance3 + ? where user_id = ?",array($credit_amount,$cr_user_id));

		
		$new_balance = $this->getAgentBalance($cr_user_id);
		$str_query = "insert into  aeps_tblewallet(user_id,payment_id,recharge_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,ref_id)
		values(?,?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($cr_user_id,$payment_id,$recharge_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$new_balance,$ipaddress,$payment_type,$ref_id ));
		if($reslut == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	private function debit_entry($dr_user_id,$debit_amount,$payment_id,$recharge_id,$transaction_type,$remark,$description,$payment_type,$aeps_id = 0,$ref_id = 0)
	{

		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();

		

		$this->db->query("update tbluserbalance set balance3 = balance3 - ? where user_id = ?",array($debit_amount,$dr_user_id));

		
		$new_balance = $this->getAgentBalance($dr_user_id);
		$str_query = "insert into  aeps_tblewallet(user_id,payment_id,recharge_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,ref_id)
		values(?,?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($dr_user_id,$payment_id,$recharge_id,$transaction_type,$remark,$description,$add_date,$debit_amount,$new_balance,$ipaddress,$payment_type,$ref_id ));
		if($reslut == true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	private function getDescription($transaction_type,$cr_user_id,$dr_user_id,$amount,$mcode,$Mobile,$recharge_id)
	{
			if($transaction_type == "PAYMENT")
			{
				return $transaction_type."@".$amount;
			}
			else if($transaction_type == "RECHARGE")
			{
				return $transaction_type."@".$mcode.$Mobile."A".$amount."REF".$recharge_id;
			}
	}
}

?>