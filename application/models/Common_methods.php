<?php
class Common_methods extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getHostId($hostname)
	{
	return 1;
	    if($hostname == "MASTER.MAHARSHIMULTI.IN")
	    {
	        return 1;
	    }
	    if($hostname == "NEW.AONEMULTIRECHARGE.CO.IN")
	    {
	        return 27;
	    }
	    if($hostname == "PAYMYFAST.NET")
	    {
	        return 1626;
	    }
	    if($hostname == "HMONEY.IN")
	    {
	        return 2295;
	    }
	    if($hostname == "RAJ-PAY.COM")
	    {
	        return 2331;
	    }
	    if($hostname == "PAY2TOPUP.CO.IN")
	    {
	        return 2953;
	    }
	    if($hostname == "TARAGROUPS.CO.IN")
	    {
	        return 4381;
	    }
	    if($hostname == "NEXTPAY.IN")
	    {
	        return 5054;
	    }
	    if($hostname == "SHREEJEEPAY.COM")
	    {
	        return 5639;
	    }
	    if($hostname == "RAJROYAL.IN")
	    {
	        return 5683;
	    }
	    
	    
	    
	    
	    
	    
	    
	}
	public function getHostName($host_id)
	{
		return "PAYIN.LIVE";
		
	    if($host_id == "1")
	    {
	        return "MASTER.MAHARSHIMULTI.IN";
	    }
	    if($host_id == "27")
	    {
	        return "NEW.AONEMULTIRECHARGE.CO.IN";
	    }
	    if($host_id == "1448")
	    {
	        return "WL.TULSYANRECHARGE.COM";
	    }
	    if($host_id == "1626")
	    {
	        return "PAYMYFAST.NET";
	    }
	    if($host_id == "2295")
	    {
	        return "HMONEY.IN";
	    }
	    if($host_id == "2331")
	    {
	        return "RAJ-PAY.COM";
	    }
	    if($host_id == "2953")
	    {
	        return "PAY2TOPUP.CO.IN";
	    }
	    if($host_id == "5054")
	    {
	        return "NEXTPAY.IN";
	    }
	    if($host_id == "5639")
	    {
	        return "SHREEJEEPAY.COM";
	    }
	    if($host_id == "5639")
	    {
	        return "SHREEJEEPAY.COM";
	    }
	    
	    if($host_id == "5683")
	    {
	        return "RAJROYAL.IN";
	    }
	}
	public function getLogo($hostname)
	{
		
	    if($hostname == "JEETZ.IN")
	    {
	        return "logo_web.jpeg";
	    }
	    if($hostname == "NEW.AONEMULTIRECHARGE.CO.IN")
	    {
	        return "aonemulti.png";
	    }
	    if($hostname == "MDRECHARGE.CO.IN")
	    {
	        return "mdrecharge.jpeg";
	    }
	    if($hostname == "WL.TULSYANRECHARGE.COM")
	    {
	        return "";
	    }
	    if($hostname == "PAYMYFAST.NET")
	    {
	        return "PMF.png";
	    }
	    if($hostname == "HMONEY.IN")
	    {
	        return "hmoney_small.png";
	    }
	    if($hostname == "RAJ-PAY.COM")
	    {
	        return "rajpay_small.png";
	    }
	    if($hostname == "PAY2TOPUP.CO.IN")
	    {
	        return "pay2topup_small.png";
	    }
	    if($hostname == "NEXTPAY.IN")
	    {
	        return "nextpay.png";
	    }
	    if($hostname == "SHREEJEEPAY.COM")
	    {
	        return "shreejeepay_logo.png";
	    }
	    if($hostname == "RAJROYAL.IN")
	    {
	        return "rajroyal_logo.png";
	    }
	}
	public function getLogoSmall($hostname)
	{
	  
	    if($hostname == "MASTER.MAHARSHIMULTI.IN")
	    {
	        return "logo_web.jpeg";
	    }
	    if($hostname == "NEW.AONEMULTIRECHARGE.CO.IN")
	    {
	        return "aonemulti.png";
	    }
	    if($hostname == "MDRECHARGE.CO.IN")
	    {
	        return "mdrecharge.jpeg";
	    }
	    if($hostname == "WL.TULSYANRECHARGE.COM")
	    {
	        return "";
	    }
	    if($hostname == "PAYMYFAST.NET")
	    {
	        return "pmf_small.png";
	    }
	    if($hostname == "HMONEY.IN")
	    {
	      
	        return "hmoney_small_round.png";
	    }
	    if($hostname == "RAJ-PAY.COM")
	    {
	        return "rajpay_small.png";
	    }
	    if($hostname == "PAY2TOPUP.CO.IN")
	    {
	        return "pay2topup_small.png";
	    }
	    if($hostname == "NEXTPAY.IN")
	    {
	        return "nextpay.png";
	    }
	    if($hostname == "SHREEJEEPAY.COM")
	    {
	        return "shreejeepay_logo.png";
	    }
	    if($hostname == "RAJROYAL.IN")
	    {
	        return "rajroyal_logo.png";
	    }
	    
	    
	    
	}
	public function getCommissionPer($scheme_id,$company_id)
	{
		
			$commission_query = "SELECT tblcommission.*,tblcompany.company_name FROM `tblcommission`,tblcompany where tblcompany.company_id = tblcommission.company_id and tblcommission.company_id=? and scheme_id = ?  order by tblcompany.company_name";
			$result_commission = $this->db->query($commission_query,array($company_id,$scheme_id));		
			if($result_commission->num_rows()== 1)
			{
				return $result_commission->row(0)->commission_per;
			}
			else
			{
				return 0;
			}
		
	}
	public function getParentCommissionPer($commission_per,$user_id,$company_id)
	{
		$this->load->model("userinfo_methods");
		$parentid = $this->userinfo_methods->getParentId($user_id);
		$parent_type =  $this->userinfo_methods->getUserType($parentid);
		
		if(trim($parent_type) == 'Retailer' or trim($parent_type) == 'Distributer')
		{
			$parent_scheme_id = $this->userinfo_methods->getSchemeId($parentid);
			$parent_commission_per =  $this->getCommissionPer($parent_scheme_id,$company_id);
			if($parent_commission_per > $commission_per)
			{
				return ($parent_commission_per - $commission_per);
			}
			else
			{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}
	public function getCommissionAmount($commission_per,$amount)
	{
		return round((($amount * $commission_per) / 100),4);
	}
	public function GetAPIName($company_id,$scheme_id)
	{		
		$str_query = "select tblapi.* FROM `tblcommission`,`tblapi` WHERE tblapi.api_id=tblcommission.api_id
	and tblapi.status=1 and tblcommission.company_id=? and tblcommission.set_prority=1 and tblcommission.scheme_id =?";
		$result = $this->db->query($str_query,array($company_id,$scheme_id));
		if($result->num_rows() == 1)
		{		
			return $result->row(0)->api_name;	
		}
		else 
		{
			return "No Api";
		}
	}
	public function getServiceId($company_id)
	{
		$str_query = "select service_id from tblcompany where company_id = ?";
		$result = $this->db->query($str_query,array($company_id));
		return $result->row(0)->service_id;
	}
	public function getRechargeType($service_id)
	{
		$str_query = "select service_name from  tblservice where service_id = ?";
		$result = $this->db->query($str_query,array($service_id));
		if($result->num_rows() == 1)
		{
			return $result->row(0)->service_name;
		}
		else
		{
			return "";
		}
		
	}
	public function GetAPIInfo($company_id,$scheme_id)
	{		
		$str_query = "select tblapi.* FROM `tblcommission`,`tblapi` WHERE tblapi.api_id=tblcommission.api_id
	and tblapi.status=1 and tblcommission.company_id=? and tblcommission.set_prority=1 and tblcommission.scheme_id =?";
		$result = $this->db->query($str_query,array($company_id,$scheme_id));		
		return $result;	
	}
	public function CheckPendingResult($MobileNo,$Amount)
	{
		$this->load->library("common");
		$recharge_date = $this->common->getMySqlDate();
		$str_query = "select * from  tblrecharge where mobile_no=? and amount=? and recharge_status=? and recharge_date=?";
		$result = $this->db->query($str_query,array($MobileNo,$Amount,'Pending',$recharge_date));		
		if($result->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	
	
///////////////////////////////////// BALANCE //////////////////////////////////////////////////////////////

	public function geOpeningBalance($user_id)
	{
		$date  = $this->common->getMySqlDate();
    		$closingbalrslt = $this->db->query("select balance from tblewallet where user_id = '$user_id' and  Date(add_date) < '$date'  order by Id desc limit 1");
			if($closingbalrslt->num_rows() > 0)
			{
    			$openingbalance = $closingbalrslt->row(0)->balance;
    			return $openingbalance;
			}
			else
			{
				return 0;
			}
	}
	public function getAgentBalance($user_id)
	{
		$balance = $this->getCurrentBalance($user_id);
		//$pendingRec = $this->getTotalPandingRecharge($user_id);
		$AgentBalance = $balance;
		return $AgentBalance;
		
	}
	public function getTotalPandingRecharge($user_id)
	{
		$str_query = "select IFNULL(Sum(amount),0) as pendingRec from tblrecharge where user_id = '$user_id' and recharge_status = 'Pending'";
		$rslt = $this->db->query($str_query);
		return $rslt->row(0)->pendingRec;
	}
	public function getCurrentBalance($user_id)
	{
		$str_query = "SELECT * FROM `tblewallet` where user_id = ? order by Id desc limit 1";
		$result = $this->db->query($str_query,array($user_id));
		if($result->num_rows() > 0)
		{
			return $result->row(0)->balance;
		}
		else 
		{
			
				return 0;
			
		}
		return 0;
	}
	//payin old data
	public function getAgentBalancePayin($user_id)
	{
		$balance = $this->getCurrentBalancePayin($user_id);
		//$pendingRec = $this->getTotalPandingRecharge($user_id);
		$AgentBalance = $balance;
		return $AgentBalance;
		
	}
	public function getCurrentBalancePayin($user_id)
	{
		$str_query = "SELECT * FROM `payin_summary_feb` where user_id = ? AND transaction_date >='2/24/2022' AND transaction_date <='2/28/2022' order by balance_id desc limit 1 ";
		$result = $this->db->query($str_query,array($user_id));
		if($result->num_rows() > 0)
		{
			return $result->row(0)->new_bal;
		}
		else 
		{
			
				return 0;
			
		}
		return 0;
	}

	//
	public function getCurrentBalanceArray($user_id)
	{
		
			$str_query = "SELECT tblewallet.*,(select distributer_name from tblusers where user_id = tblewallet.user_id) as distributer_name FROM `tblewallet` where user_id = ? order by Id desc limit 1";
			$result = $this->db->query($str_query,array($user_id));
			
			return $result;
		
	}
	
	public function CheckBalance($user_id,$Amount)
	{
		$balance = $this->getAgentBalance($user_id);
		$minBalLimit = $this->getMinRecLimit($user_id);
		if($balance >= ($Amount + $minBalLimit))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function getMinRecLimit($user_id)
	{
		$str_query = "select min_bal_limit from tblusers where user_id = '$user_id'";
		$rslt = $this->db->query($str_query);	
		return $rslt->row(0)->min_bal_limit;
		
	}
	public function CheckAgentBalance($user_id,$Amount)
	{
		$balance = $this->getAgentBalance($user_id);
		if($balance >= $Amount)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getBalanceByUserType($user_id,$usertype)
	{
		if($usertype == "Agent")
		{
			$balance = $this->getCurrentBalance($user_id);
			
			$AgentBalance = $balance;
			return $AgentBalance;	
		}
		else if($usertype == "MasterDealer" or $usertype == "Distributor" )
		{
			$balance = $this->getCurrentBalance($user_id);
			return $balance;	
		}
		else
		{
			return false;
		}
		
		
	}
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////


	
	public function getChild($usertype,$user_id)
	{
		$str_query = "select * from tblusers where referer_id = ? and usertype_name=?";
		$rslt = $this->db->query($str_query,array($user_id,$usertype));
		if($rslt != NULL)
		{
			return $rslt->num_rows();
		}
		else
		{
			return 0;
		}
		return 0;
	}
	public function getChieldCount($user_id)
	{
		$str_query = "select * from tblusers where referer_id = ?";
		$rslt = $this->db->query($str_query,array($user_id));
		if($rslt != NULL)
		{
			return $rslt->num_rows();
		}
		else
		{
			return 0;
		}
		return 0;
	}
	public function encrypt($string)
	{
		$cipher = $this->encryption->encrypt($string);
		 return  strtr(
                    $cipher,
                    array(
                        '+' => '.',
                        '=' => '-',
                        '/' => '~'
                    )
                );
		
	}
	public function decrypt($string)
	{
		$url_safe = strtr(
                $string,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
            );
		return $this->encryption->decrypt($url_safe);
	
	}
	public function getNewUserId($usertype)
	{
		$str_query = "select username from tblusers where usertype_name = '$usertype' order by username desc limit 1";
		$rslt = $this->db->query($str_query);
		if($rslt->num_rows() > 0)
		{
			return $rslt->row(0)->username + 1;
		}
		else
		{
			if($usertype == "MasterDealer")
			{
				return "3001";
			}
			if($usertype == "Distributor")
			{
				return "200001";
			}
			if($usertype == "Agent")
			{
				return "110001";
			}
			if($usertype == "APIUSER")
			{
				return "7001";
			}
			if($usertype == "WL")
			{
				return "901";
			}
		}
	}
	public function Increment_id($usertype)
	{
		if($usertype == "MasterDealer")
		{
			$str_query = "update tblnew_ids set masterdealer_id=masterdealer_id+1 where Id = 1";
			$rslt  = $this->db->query($str_query);
			return true;
		}
		if($usertype == "Distributor")
		{
			$str_query = "update tblnew_ids set dealer_id=dealer_id+1 where Id = 1";
			$rslt  = $this->db->query($str_query);
			return true;
		}
		if($usertype == "Retailer")
		{
			$str_query = "update tblnew_ids set retailer_id=retailer_id+1 where Id = 1";
			$rslt  = $this->db->query($str_query);
			return true;
		}
		if($usertype == "APIUSER")
		{
			$str_query = "update tblnew_ids set apiuser_id=apiuser_id+1 where Id = 1";
			$rslt  = $this->db->query($str_query);
			return true;
		}
		
	}
	public function getPaymentInfo($payment_id)
	{
		$str_query = "select tblpayment.*,(select businessname from tblusers where tblusers.user_id = tblpayment.cr_user_id) as cr_bname,(select username from tblusers where tblusers.user_id = tblpayment.dr_user_id) as dr_usercode,(select username from tblusers where tblusers.user_id = tblpayment.cr_user_id) as cr_usercode,(select usertype_name from tblusers where tblusers.user_id = tblpayment.cr_user_id) as cr_usertype_name,(select usertype_name from tblusers where tblusers.user_id = tblpayment.dr_user_id) as dr_usertype_name from tblpayment where payment_id = '$payment_id'";
		$rslt = $this->db->query($str_query);
		return $rslt;
	}
	
///////////////////////////// FUND TRANSFER ///////////////////////////////////
	public function DealerAddBalance($dr_user_id,$cr_user_id,$amount,$remark,$done_by = "WEB")
	{
		$this->load->model("common_method_model");
			if($amount < 0)
			{
			    return $this->displaymessage(1,"Invalid Amount",$done_by);
				
			}
			$dr_user_info = $this->Userinfo_methods->getUserInfo($dr_user_id);
			$dr_user_type = $dr_user_info->row(0)->usertype_name;
			if($dr_user_type == "SuperDealer" or $dr_user_type == "MasterDealer" or $dr_user_type == "Distributor")
			{
				$cr_user_info = $this->Userinfo_methods->getUserInfo($cr_user_id);
				$scheme_info = $this->Userinfo_methods->getSchemeInfo($cr_user_id);
					
				if($this->Common_methods->CheckBalance($dr_user_id,$amount)== true)
				{
					if($this->common_method_model->checkChildOf($dr_user_id,$cr_user_id) == true)
					//if(true)
					{
						$description = $this->Insert_model->getCreditPaymentDescription($cr_user_id, $dr_user_id,$amount);
						$payment_type = "PAYMENT";
						$this->Insert_model->tblewallet_Payment_CrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
						$this->load->model("Sms");
            			$bal = $this->Common_methods->getBalanceByUserType($cr_user_id,$cr_user_info->row(0)->usertype_name);
            			$this->Sms->receiveBalance($cr_user_info,$amount,$bal);
						
						return $this->displaymessage(0,"Fund Transfer Successful",$done_by);
						//return "Fund Transfer Successful";
					}
					else
					{
					    return $this->displaymessage(1,"Invalid UserIdl",$done_by);
					}
				}
				else
				{
				    return $this->displaymessage(1,"Insufficient Balance",$done_by);
				}
			}
			else
			{
			    return $this->displaymessage(1,"Invalid User",$done_by);
				//return "Invalid User";
			}	
	}
	private function displaymessage($status,$message,$rechargeBy)
    {
        if($rechargeBy == "GPRS")
        {
            $resparray = array(
        				'status'=>$status,
        				'message'=>$message
    				);
    	    echo json_encode($resparray);exit;    
        }
        else
        {
            $resparray = array(
        				'status'=>$status,
        				'message'=>$message
    				);
    	    return json_encode($resparray);
        }
        
    }
	
	public function DealerRevertBalance($dr_user_id,$cr_user_id,$amount)
	{
	    error_reporting(-1);
	    ini_set('display_errors',1);
	    $this->db->db_debug = TRUE;
		$this->load->model("common_method_model");
		//if($amount < 0)
		if(true)
		{
			//return "Invalid Amount";
		}
		if(true)
		{
		    $cr_user_info = $this->Userinfo_methods->getUserInfo($cr_user_id);
			$cr_user_type = $cr_user_info->row(0)->usertype_name;
			if($cr_user_type == "MasterDealer" or $cr_user_type == "Distributor")
			{
				$dr_user_info = $this->Userinfo_methods->getUserInfo($dr_user_id);
			
				if($this->Common_methods->CheckBalance($dr_user_id,$amount)== true)
				{
					
					if($this->common_method_model->checkChildOf($cr_user_id,$dr_user_id) == true)
					{
						$scheme_info = $this->Userinfo_methods->getSchemeInfo($dr_user_id);
						$remark = "";
						$description = $this->Insert_model->getRevertPaymentDescription($cr_user_id, $dr_user_id,$amount);
						$payment_type = "REVERT_PAYMENT";
						$this->Insert_model->tblewallet_Payment_DrEntry($cr_user_id,$dr_user_id,$amount,$remark,$description,$payment_type);
						$this->load->model("Sms");
			$bal = $this->Common_methods->getBalanceByUserType($dr_user_id,$dr_user_info->row(0)->usertype_name);
			$this->Sms->revertBalance($dr_user_info,$amount,$bal);
						if($scheme_info->num_rows() == 1)
						{
							$schemeType = $scheme_info->row(0)->scheme_type;
							$flat_commPer = $scheme_info->row(0)->flat_commission;
						/*	if($schemeType == "flat")
							{	
								$payment_status = 'false';
								$flatdescription = "Revert Flat Commission ".$flat_commPer." %  On ".$amount." Rs.";
								
								$flatamount = ($amount * $flat_commPer)/100;
								$revFlatComm = -($flatamount);
								$this->Insert_model->tblflatcommissionEntry($cr_user_id,$amount,$revFlatComm,$flat_commPer,$flatdescription,"false");
								return "Revert Fund Transfer Successful";
							}
							*/
						}
						
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
			
			
		
	}
////////////////////////////////// *** END *** ////////////////////////
public function findMobileExists($mobile)
{
	$rslt = $this->db->query("select * from tblusers where mobile_no = ?",array($mobile));
	if($rslt->num_rows() > 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}
	


public function generateRandomString($length = 10) 
{
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

}

?>