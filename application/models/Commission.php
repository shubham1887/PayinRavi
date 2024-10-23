<?php
class Commission extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getCommissionSlab_dropdown_options()
	{
	    $rsltslab = $this->db->query("select a.Id,a.Name from mt3_group a order by a.Name");
	    $ddloptions = '';
	    foreach($rsltslab->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->Id.'">'.$rw->Name.'</option>';
	    }
	    return $ddloptions;
	}
	public function getDate()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$date = date("Y-m-d");		
		return $date; 
	}
	public function checkduplicate($recharge_id,$user_id)
	{
		$add_date = $this->getDate();
		$ip =$this->common->getRealIpAddr();
		$rslt = $this->db->query("insert into locking_recharge_commission (recharge_id,user_id,add_date,ipaddress) values(?,?,?,?)",array($recharge_id,$user_id,$add_date,$ip));
	    if($rslt == true)
	    {
		  return true;
	    }
	    else
	    { 
	  	  return false;
	    }
	}
	public function ParentCommission($recharge_id)
	{
		$rsltrechargeinfo = $this->db->query("select 
		a.recharge_id,a.MdId,a.MdComm,a.MdCom_Given,a.DId,a.DComm,a.DCom_Given,a.recharge_status,a.mobile_no,a.amount,
		b.company_name,
		c.businessname,c.username
		from tblrecharge a 
		left join tblcompany b on a.company_id = b.company_id 
		left join tblusers c on a.user_id = c.user_id
		where a.recharge_id = ? and a.recharge_status = 'Success'",array($recharge_id));
		//echo $rsltrechargeinfo->num_rows();exit;
		if($rsltrechargeinfo->num_rows() == 1)
		{
			$recharge_status = $rsltrechargeinfo->row(0)->recharge_status;
			$company_name = $rsltrechargeinfo->row(0)->company_name;
			$mobile_no = $rsltrechargeinfo->row(0)->mobile_no;
			$amount = $rsltrechargeinfo->row(0)->amount;
			
			$Description = $company_name." Number : ".$mobile_no." Amount : ".$amount;
			$remark = $rsltrechargeinfo->row(0)->businessname."(".$rsltrechargeinfo->row(0)->username.")";
			
			$MdId = $rsltrechargeinfo->row(0)->MdId;
			$MdComm = $rsltrechargeinfo->row(0)->MdComm;
			$MdCom_Given = $rsltrechargeinfo->row(0)->MdCom_Given;
			
			$DId = $rsltrechargeinfo->row(0)->DId;
			$DComm = $rsltrechargeinfo->row(0)->DComm;
			$DCom_Given = $rsltrechargeinfo->row(0)->DCom_Given;
			
			$transaction_type = "PARENT_COMMISSION";
			$mdinfo = $this->db->query("select user_id from tblusers where user_id = ? and usertype_name = 'MasterDealer'",array($MdId));
			if($mdinfo->num_rows() == 1)
			{
				if($MdCom_Given == "no")
				{
					if($MdComm != 0)
					{
						if($this->checkduplicate($recharge_id,$MdId) == false)
						{
							return "";
						}
						//giv commission to masterdealer
						$this->db->query("update tblrecharge set MdCom_Given = 'yes' where recharge_id = ?",array($recharge_id));
						$this->tblewallet_RechargeCommission_CrEntry($MdId,$recharge_id,$transaction_type,$MdComm,$Description);	
					}
				}
			}
			$dinfo = $this->db->query("select user_id from tblusers where user_id = ? and usertype_name = 'Distributor'",array($DId));
			if($dinfo->num_rows() == 1)
			{
				if($DCom_Given == "no")
				{
					if($DComm != 0)
					{
						if($this->checkduplicate($recharge_id,$DId) == false)
						{
							return "";
						}
						//giv commission to distributor
						$this->db->query("update tblrecharge set DCom_Given = 'yes' where recharge_id = ?",array($recharge_id));
						$this->tblewallet_RechargeCommission_CrEntry($DId,$recharge_id,$transaction_type,$DComm,$Description);	
					}
				}
			}
		}
	}
	public function tblewallet_RechargeCommission_CrEntry($user_id,$recharge_id,$transaction_type,$cr_amount,$Description)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$old_balance = $this->Common_methods->getAgentBalance($user_id);
		$current_balance = $old_balance + $cr_amount;
		
		$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,credit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$cr_amount,$current_balance,$Description,$add_date));
		return $this->db->insert_id();
	}
	public function ParentCommission_reverse($recharge_id)
	{
		$rsltrechargeinfo = $this->db->query("select recharge_id,MdId,MdComm,MdCom_Given,DId,DComm,DCom_Given,FosId,FosComm,FosCom_Given,recharge_status from tblrecharge where recharge_id = ? and recharge_status = 'Failure'",array($recharge_id));
		if($rsltrechargeinfo->num_rows() == 1)
		{
			$MdId = $rsltrechargeinfo->row(0)->MdId;
			$MdComm = $rsltrechargeinfo->row(0)->MdComm;
			$MdCom_Given = $rsltrechargeinfo->row(0)->MdCom_Given;
			
			$DId = $rsltrechargeinfo->row(0)->DId;
			$DComm = $rsltrechargeinfo->row(0)->DComm;
			$DCom_Given = $rsltrechargeinfo->row(0)->DCom_Given;
			
			
			$FosId = $rsltrechargeinfo->row(0)->FosId;
			$FosComm = $rsltrechargeinfo->row(0)->FosComm;
			$FosCom_Given = $rsltrechargeinfo->row(0)->FosCom_Given;
			
			
			
			$transaction_type = "PARENT_COMMISSION";
			$mdinfo = $this->db->query("select user_id from tblusers where user_id = ? and usertype_name = 'MasterDealer'",array($MdId));
			if($mdinfo->num_rows() == 1)
			{
				if($MdCom_Given == "yes")
				{
					if($MdComm != 0)
					{
						//giv commission to masterdealer
						$this->db->query("update tblrecharge set MdCom_Given = 'no' where recharge_id = ?",array($recharge_id));
						$this->tblewallet_RechargeCommission_DrEntry($MdId,$recharge_id,$transaction_type,$MdComm,$transaction_type);	
					}
				}
			}
			$dinfo = $this->db->query("select user_id from tblusers where user_id = ? and usertype_name = 'Distributor'",array($DId));
			if($dinfo->num_rows() == 1)
			{
				if($DCom_Given == "yes")
				{
					if($DComm != 0)
					{
						//giv commission to distributor
						$this->db->query("update tblrecharge set DCom_Given = 'no' where recharge_id = ?",array($recharge_id));
						$this->tblewallet_RechargeCommission_DrEntry($DId,$recharge_id,$transaction_type,$DComm,$transaction_type);	
					}
				}
			}
			$fosinfo = $this->db->query("select user_id from tblusers where user_id = ? and usertype_name = 'FOS'",array($FosId));
			if($fosinfo->num_rows() == 1)
			{
				if($FosCom_Given == "yes")
				{
					if($FosComm != 0)
					{
						//giv commission to distributor
						$this->db->query("update tblrecharge set FosCom_Given = 'no' where recharge_id = ?",array($recharge_id));
						$this->tblewallet_RechargeCommission_DrEntry($FosId,$recharge_id,$transaction_type,$FosComm,$transaction_type);	
					}
				}
			}
		}
	}
	public function tblewallet_RechargeCommission_DrEntry($user_id,$recharge_id,$transaction_type,$cr_amount,$Description)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$old_balance = $this->Common_methods->getAgentBalance($user_id);
		$current_balance = $old_balance - $cr_amount;
		
		$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,debit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$cr_amount,$current_balance,$Description,$add_date));
		return $this->db->insert_id();
	}
	

}

?>