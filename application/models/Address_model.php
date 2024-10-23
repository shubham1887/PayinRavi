<?php
class Address_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	

	
	public function getStateDropdownList()
	{
	    $ddloptions = '';
	    $rsltstate = $this->db->query("select a.circleMasterId,a.circleName from freecharge_circlemaster a order by a.circleName");
	    foreach($rsltstate->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->circleMasterId.'">'.$rw->circleName.'</option>';
	    }
	    return $ddloptions;
	}
	
	
	public function getCircleDropdownList()
	{
	    $ddloptions = '';
	    $rsltstate = $this->db->query("select a.state_id,a.state_name from tblstate a order by a.state_name");
	    foreach($rsltstate->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->state_id.'">'.$rw->state_name.'</option>';
	    }
	    return $ddloptions;
	}
	
	public function getApiListForDropdownList_whereapi_id_not_equelto($api_id,$api_id2 = false,$api_id3 = false)
	{
	    $ddloptions = '';
	    $rsltpai = $this->db->query("
	        select 
	            a.Id,a.api_name 
	            from api_configuration a 
	            where 
	            a.is_active = 'yes' and a.enable_recharge = 'yes' 
	            and a.Id != ?  and
	            if(? != false,a.Id != ?,true) and
	            if(? != false,a.Id != ?,true) 
	            order by a.api_name",array($api_id,$api_id2,$api_id2,$api_id3,$api_id3));
	    foreach($rsltpai->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->Id.'">'.$rw->api_name.'</option>';
	    }
	    return $ddloptions;
	}
	public function getApiListForDropdownList_notrouterapi()
	{
	    $ddloptions = '';
	    $rsltpai = $this->db->query("select a.Id,a.api_name from api_configuration a where a.is_active = 'yes' and a.enable_recharge = 'yes' and is_random = 'no' order by a.api_name");
	    foreach($rsltpai->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->Id.'">'.$rw->api_name.'</option>';
	    }
	    return $ddloptions;
	}
}

?>