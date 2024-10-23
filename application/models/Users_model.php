<?php
class Users_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//////////////////
//////////////////  B A L A N C E    A P I   C O D E
/////////////////
/////////////////////////////////////////////////////////////


	
	public function getDropdownOptions($usertype_name,$not_usertype = false)
	{
	    $ddloptions = '';
	    $rsltusers = $this->db->query("select a.user_id,a.businessname,a.mobile_no 
	    from tblusers a where 
	    if(? != false,a.usertype_name = ?,a.usertype_name != 'Admin') and
	    if(? != false,a.usertype_name != ?,true)
	    order by a.businessname",array($usertype_name,$usertype_name,$not_usertype,$not_usertype));
	    foreach($rsltusers->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->user_id.'">'.$rw->businessname.'('.$rw->mobile_no.')</option>';
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