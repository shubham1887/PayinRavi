<?php
class Locking_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function locking_reroot_api($recharge_id,$api_id)
	{
	    $rslt = $this->db->query("insert into locking_reroot(recharge_id,api_id,add_date,ipaddress) values(?,?,?,?)",array($recharge_id,$api_id,$this->common->getDate(),$this->common->getRealIpAddr()));
	    if($rslt == true)
	    {
	        return true;
	    }
	    else
	    {
	        return false;
	    }
	}
}

?>