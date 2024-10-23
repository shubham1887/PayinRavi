<?php
class Ew2 extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getAgentBalance($user_id)
	{
		$rsltbal = $this->db->query("SELECT balance FROM `tblewallet2` where user_id = ? order by Id desc limit 1",array($user_id));
		if($rsltbal->num_rows() == 1)
		{
			return $rsltbal->row(0)->balance;
		}
		else 
		{
			return 0;
		}
	}
	public function tblewallet_Payment_CrDrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$tds = 0)
	{	
				
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$credit_amount = $amount;
		$debit_amount = $amount;
		$transaction_type = "PAYMENT";
		$old_balance_credit_user_id = $this->getAgentBalance($credit_user_id);
		$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;

		
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		
		$reslut = $this->db->query("insert into  tblpayment2(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type)
		values(?,?,?,?,?,?,?,?,?)",array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type));
		$payment_id = $this->db->insert_id();
		if($payment_id > 0)
		{
			$old_balance_debit_user_id = $this->getAgentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			
			$reslut_debit = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
			values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));	
			
			$dr_insert_id = $this->db->insert_id();
			if($dr_insert_id > 1)
			{
					$reslut = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));
					$cr_insert_id = $this->db->insert_id();
					return $cr_insert_id;
			}
		}
		else
		{
			return true;
		}
		
		
		
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////PG EW2//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function tblewallet_Payment_CrDrPG($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$tds = 0)
	{	
				
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$credit_amount = $amount;
		$debit_amount = $amount;
		$transaction_type = "PG";
		$old_balance_credit_user_id = $this->getAgentBalance($credit_user_id);
		$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;

		
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		
		$reslut = $this->db->query("insert into  tblpayment2(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type)
		values(?,?,?,?,?,?,?,?,?)",array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type));
		$payment_id = $this->db->insert_id();
		if($payment_id > 0)
		{
			$old_balance_debit_user_id = $this->getAgentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			
			$reslut_debit = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
			values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));	
			
			$dr_insert_id = $this->db->insert_id();
			if($dr_insert_id > 1)
			{
					$reslut = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));
					$cr_insert_id = $this->db->insert_id();
					return $cr_insert_id;
			}
		}
		else
		{
			return true;
		}
		
		
		
	}


	public function tblewallet_Payment_AEPS($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$tds = 0)
	{	
				
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$credit_amount = $amount;
		$debit_amount = $amount;
		$transaction_type = "AEPS";
		$old_balance_credit_user_id = $this->getAgentBalance($credit_user_id);
		$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;

		
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		
		$reslut = $this->db->query("insert into  tblpayment2(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type)
		values(?,?,?,?,?,?,?,?,?)",array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type));
		$payment_id = $this->db->insert_id();
		if($payment_id > 0)
		{
			$old_balance_debit_user_id = $this->getAgentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			
			$reslut_debit = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
			values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));	
			
			$dr_insert_id = $this->db->insert_id();
			if($dr_insert_id > 1)
			{
					$reslut = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));
					$cr_insert_id = $this->db->insert_id();
					return $cr_insert_id;
			}
		}
		else
		{
			return true;
		}
		
		
		
	}
	public function tblewallet_Payment_CommissionEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$tds = 0)
	{	
				
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$credit_amount = $amount;
		$debit_amount = $amount;
		$transaction_type = "Commission";
		$old_balance_credit_user_id = $this->getAgentBalance($credit_user_id);
		$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;

		
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		
		$reslut = $this->db->query("insert into  tblpayment2(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type)
		values(?,?,?,?,?,?,?,?,?)",array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type));
		$payment_id = $this->db->insert_id();
		if($payment_id > 0)
		{
			$old_balance_debit_user_id = $this->getAgentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			
			$reslut_debit = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
			values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));	
			
			$dr_insert_id = $this->db->insert_id();
			if($dr_insert_id > 1)
			{
					$reslut = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));
					$cr_insert_id = $this->db->insert_id();
					return $cr_insert_id;
			}
		}
		else
		{
			return true;
		}
		
		
		
	}
	public function tblewallet_Payment_CrEntry_From_Admin($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$tds = 0)
	{	
				
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$credit_amount = $amount;
		$debit_amount = $amount;
		
		$transaction_type = "CRADIT";
		$old_balance_credit_user_id = $this->getAgentBalance($credit_user_id);
		$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;

		
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		
		$reslut = $this->db->query("insert into  tblpayment2(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type)
		values(?,?,?,?,?,?,?,?,?)",array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type));
		$payment_id = $this->db->insert_id();
		if($payment_id > 0)
		{
		$transaction_type1 = "DEBIT";

			$old_balance_debit_user_id = $this->getAgentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			
			$reslut_debit = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
			values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($debit_user_id,$payment_id,$transaction_type1,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));	
			
			$dr_insert_id = $this->db->insert_id();
			if($dr_insert_id > 1)
			{
					$reslut = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));
					$cr_insert_id = $this->db->insert_id();
					return $cr_insert_id;
			}
		}
		else
		{
			return true;
		}
		
		
		
	}
	public function tblewallet_Payment_DrEntry_From_Admin($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$tds = 0)
	{	
				
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$credit_amount = $amount;
		$debit_amount = $amount;
		
		$transaction_type = "DEBIT";
		$old_balance_credit_user_id = $this->getAgentBalance($credit_user_id);
		$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;

		
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		
		$reslut = $this->db->query("insert into  tblpayment2(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type)
		values(?,?,?,?,?,?,?,?,?)",array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type));
		$payment_id = $this->db->insert_id();
		if($payment_id > 0)
		{
			$old_balance_debit_user_id = $this->getAgentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			
			$reslut_debit = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
			values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));	
			
			$dr_insert_id = $this->db->insert_id();
			if($dr_insert_id > 1)
			{
				$transaction_type1 = "CRADIT";
					$reslut = $this->db->query("insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,cr_user_id,dr_user_id,admin_remark,tds)
					values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($credit_user_id,$payment_id,$transaction_type1,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$credit_user_id,$debit_user_id,$admin_remark,$tds));
					$cr_insert_id = $this->db->insert_id();
					return $cr_insert_id;
			}
		}
		else
		{
			return true;
		}
		
		
		
	}
	
	
	//////////////////////////////////////////////
	////////////////////////////Debit Recharge Amount From ewallet
	////////////////////////////////////////////
	public function tblewallet_Recharge_DrEntry($user_id,$recharge_id,$transaction_type,$dr_amount,$Description)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();

		$old_balance = $this->getAgentBalance($user_id);
		$current_balance = $old_balance - $dr_amount;
		
		$str_query = "insert into  tblewallet2(user_id,recharge_id,transaction_type,debit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date));
		$ewallet_id = $this->db->insert_id();
		return $ewallet_id;
	}
	public function DealerAddBalance($dr_user_id,$cr_user_id,$amount,$remark)
	{
			$this->load->model("common_method_model");
			if($amount < 0)
			{
				return "Invalid Amount";
			}
			$dr_user_info = $this->Userinfo_methods->getUserInfo($dr_user_id);
			$dr_user_type = $dr_user_info->row(0)->usertype_name;
			if($dr_user_type == "MasterDealer" or $dr_user_type == "Distributor" or $dr_user_type == "FOS")
			{
				$cr_user_info = $this->Userinfo_methods->getUserInfo($cr_user_id);
				$scheme_info = $this->Userinfo_methods->getSchemeInfo($cr_user_id);
				$balance = $this->getAgentBalance($dr_user_id);	
				if($balance >= $amount)
				{
					if($this->common_method_model->checkChildOf($dr_user_id,$cr_user_id) == true)
					//if(true)
					{
						$description = $this->Insert_model->getCreditPaymentDescription($cr_user_id, $dr_user_id,$amount);
						$payment_type = "PAYMENT";
						$this->tblewallet_Payment_CrEntry_From_Admin($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
						$this->load->model("Sms");
						$bal = $this->Common_methods->getBalanceByUserType($cr_user_id,$cr_user_info->row(0)->usertype_name);
						$this->Sms->receiveBalance($cr_user_info,$amount,$bal);
						
						
						return "Fund Transfer Successful";
					}
					else
					{
						return "Invalid UserId";
					}
				}
				else
				{
					return "Insufficient Balance";
				}
			}
			else
			{
				return "Invalid User";
			}	
	}
	
	public function DealerRevertBalance($dr_user_id,$cr_user_id,$amount)
	{
			$this->load->model("common_method_model");
			if($amount < 0)
			{
				return "Invalid Amount";
			}
			$cr_user_info = $this->Userinfo_methods->getUserInfo($cr_user_id);
			$cr_user_type = $cr_user_info->row(0)->usertype_name;
			if($cr_user_type == "MasterDealer" or $cr_user_type == "Distributor")
			{
				$dr_user_info = $this->Userinfo_methods->getUserInfo($dr_user_id);
				$balance = $this->getAgentBalance($dr_user_id);	
				if($balance >= $amount)
				{
					
					if($this->common_method_model->checkChildOf($cr_user_id,$dr_user_id) == true)
					{
						$scheme_info = $this->Userinfo_methods->getSchemeInfo($dr_user_id);
						$remark = "";
						$description = $this->Insert_model->getRevertPaymentDescription($cr_user_id, $dr_user_id,$amount);
						$payment_type = "DEBIT";
						
						$this->tblewallet_Payment_DrEntry_From_Admin($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
						$this->load->model("Sms");
						$bal = $this->Common_methods->getBalanceByUserType($dr_user_id,$dr_user_info->row(0)->usertype_name);
						$this->Sms->revertBalance($dr_user_info,$amount,$bal);
						
						
						return "Revert Fund Transfer Successful";
					}
					else
					{
						return "Invalid UserId";
					}
				}
				else
				{
					return "Insufficient Balance";
				}
			
			}
			else
			{
				return "Invalid User";
			}
			
		
	}




	////////////////////////////////////////////////////////////////
	///////////// payout debit entry
	////////////////////////////////////////////////////////////////
	public function PAYOUT_ENTRY($user_id,$payout_id,$amount,$transaction_charge,$Description,$remark,$mode)
	{

			
		$credit_user_id = 1;
		$debit_user_id = $user_id;
		
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$transaction_type = "PAYOUT";
		$payment_type = $mode;
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	

		$str_query = "insert into  tblpayment2(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type, 	payment_date,payment_time)
		values(?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type,$payment_date,$payment_time));
		$payment_id = $this->db->insert_id();
		if($payment_id > 1)
		{
			$dr_user_id = $user_id;
			$cr_user_id = 1;
			$debit = $this->PAYOUT_DEBIT_ENTRY($dr_user_id,$payout_id,$amount,$transaction_charge,$Description,$remark,$mode,$payment_id,"PAYOUT");
			if($debit == true)
			{
				$debit = $this->PAYOUT_DEBIT_ENTRY($dr_user_id,$payout_id,$transaction_charge,$transaction_charge,$Description,$remark,$mode,$payment_id,"PAYOUT_CHARGE");
				$cr = $this->PAYOUT_CREDIT_ENTRY($cr_user_id,$payout_id,$amount,$transaction_charge,$Description,$remark,$mode,$payment_id,$transaction_type,"PAYOUT");
				$cr = $this->PAYOUT_CREDIT_ENTRY($cr_user_id,$payout_id,$transaction_charge,$transaction_charge,$Description,$remark,$mode,$payment_id,"PAYOUT_CHARGE");
				return $cr;
			}	    
		}
	
	}
	public function PAYOUT_DEBIT_ENTRY($user_id,$payout_id,$amount,$transaction_charge,$description,$remark,$payment_type,$payment_id,$transaction_type)
	{

		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$payment_master_id =  0;
		$admin_remark = "";

		$old_balance_debit_user_id = $this->Ew2->getAgentBalance($user_id);
		$current_balance_debit_user_id = $old_balance_debit_user_id - $amount;

		$str_query = "insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,admin_remark,ref_id)
			values(?,?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$admin_remark,$payout_id));
		if($reslut == true)
		{
			return true;
		}
		
	
	}
	public function PAYOUT_CREDIT_ENTRY($user_id,$payout_id,$amount,$transaction_charge,$description,$remark,$payment_type,$payment_id,$transaction_type)
	{

		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$payment_master_id =  0;
		$admin_remark = "";
		$old_balance_debit_user_id = $this->Ew2->getAgentBalance($user_id);
		$current_balance_debit_user_id = $old_balance_debit_user_id + $amount;

		$str_query = "insert into  tblewallet2(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,admin_remark,ref_id)
			values(?,?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$admin_remark,$payout_id));
		if($reslut == true)
		{
			return true;
		}
	}
	
	
}

?>