<?php
class Common_method_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getsworldProvider($provider)
	{
		$str_query = "select sworld_provider from tblcompany where provider=?";
		$result = $this->db->query($str_query,array($provider));
		return $result->row(0)->sworld_provider;
	}
	public function getRechargeDuniaProvider($provider)
	{
		$str_query = "select recDumiaProvider from tblcompany where provider=?";
		$result = $this->db->query($str_query,array($provider));
		return $result->row(0)->recDumiaProvider;
	}
	public function getsworldCircle($circle_code)
	{
		$str_query = "select sworld_cirle from tblstate where circle_code=?";
		$result = $this->db->query($str_query,array($circle_code));
		return $result->row(0)->sworld_cirle;
	}
	public function getMarsProvider($provider)
	{
		$str_query = "select long_code_format from tblcompany where provider=?";
		$result = $this->db->query($str_query,array($provider));
		return $result->row(0)->long_code_format;
	}
	public function getUserId($username,$password)
	{
		$rslt = $this->db->query("select * from tblusers where username = '".$username."' and password = '".$password."'");
		if($rslt->num_rows() > 0)
		{
			return $rslt->row(0)->user_id;
		}
		else 
		{
			return false;
		}
		
	}
	public function checkChildOf($parent,$child)
	{
		$parentInfo  = $this->Userinfo_methods->getUserInfo($parent);
		$parent_type = $parentInfo->row(0)->usertype_name;
		
		$chileInfo  = $this->Userinfo_methods->getUserInfo($child);
		$chile_type = $chileInfo->row(0)->usertype_name;
		
		
		if(($parent_type == "Distributor" and $chile_type == "Agent") or ($parent_type == "Distributor" and $chile_type == "FOS")  or ($parent_type == "MasterDealer" and ($chile_type == "Distributor" or $chile_type == "APIUSER")) or ($parent_type == "Distributor" and $chile_type == "Distributor"))
		{
			if($parent_type == "Distributor" and $chile_type == "Distributor")
			{
				return true;
			}
			else
			{
				$rlst = $this->db->query("select * from tblusers where parentid = ? and user_id = ?",array($parent,$child));
				if($rlst->num_rows() > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}

			
		}
		else if($parent_type == "MasterDealer" and $chile_type == "Agent")
		{
			$rlst = $this->db->query("select * from tblusers where parentid in (select user_id from tblusers where parentid = ?)  and user_id = ?",array($parent,$child));
			if($rlst->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else if($parent_type == "SuperDealer" and ($chile_type == "Agent"  or $chile_type == "Distributor"  or $chile_type == "MasterDealer"))
		{
			$rlst = $this->db->query("select host_id from tblusers where   user_id = ? and host_id = ?",array($child,$parent));
			if($rlst->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else if($parent_type == "FOS" and $chile_type == "Agent")
		{
			$rlst = $this->db->query("select * from tblusers where fos_id = '$parent' and user_id = '$child'");
			if($rlst->num_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	public function getUserIdByUserName($otherUname)
	{
		$rlst = $this->db->query("select * from tblusers where username = '$otherUname'");
		if($rlst->num_rows() > 0)
		{
			return $rlst->row(0)->user_id;
		}
		else
		{
			return false;
		}
	}
}

?>