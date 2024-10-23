<?php
class Service_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	
    
    public function getServices()
	{
	   
	    $rsltservice = $this->db->query("select a.service_id,a.service_name from tblservice a order by a.service_id");
	    return $rsltservice;
	}




    
	
	public function getService_modelServiceDropdownList()
	{
	    $ddloptions = '';
	    $rsltstate = $this->db->query("select a.service_id,a.service_name from tblservice a order by a.service_id");
	    foreach($rsltstate->result() as $rw)
	    {
	         $ddloptions.='<option value="'.$rw->service_id.'">'.$rw->service_name.'</option>';
	    }
	    return $ddloptions;
	}



	public function getAccessRights($usertype_name)
	{
	   
	    $rsltaccessrights = $this->db->query("SELECT a.Id,a.rights_for,a.rights_name FROM `access_rights` a 
		where a.rights_for = ? order by a.Id",array($usertype_name));
	    return $rsltaccessrights;
	}
	public function getAccessRights_checkboxHTMLTABLE($user_id,$usertype_name)
	{



		  $access_rights = $this->db->query("
		  	SELECT a.Id,a.rights_for,a.rights_name,a.status,a.controller_name,IFNULL(b.access_flag,'no') as access_flag FROM `access_rights` a 
		  	left join access_rights_alloted b on a.Id = b.rights_id and b.user_id = ?
		where a.rights_for = ? order by a.Id",array($user_id,$usertype_name));


		 $str_checkbox = '';
	    foreach($access_rights->result() as $rw)
	    {
	        
	        $user_ser = '';
	        $Id = $rw->Id;
	        $rights_for = $rw->rights_for;
	        $rights_name = $rw->rights_name;
	        $access_flag = $rw->access_flag;

	        $checkbox_flag = '';
	        if($access_flag == "yes")
	        {
	            $checkbox_flag = 'checked';
	        }
	         $str_checkbox.='<label class="ckbox ckbox-success mg-t-15">
                            <input type="checkbox" id="chk'.$rights_name.'" name="chk'.$rights_name.'" '.$checkbox_flag.'><span>'.$rights_name.'</span>
                          </label>';
	    }
	    return $str_checkbox;


	}


	public function getService_checkboxHTMLTABLE($user_id = false)
	{
	    $str_checkbox = '';
	    if($user_id == false)
	    {
	      
	        $rsltservice = $this->db->query("select 
	                                        a.service_id,a.service_name ,(select '') as user_id,(select 'off') as status
	                                    from tblservice a
	                                   
	                                    order by a.service_id");    
	    }
	    else
	    {
	        $rsltservice = $this->db->query("select 
	                                        a.service_id,a.service_name ,b.user_id,b.status
	                                    from tblservice a
	                                    left join active_services b on a.service_id = b.service_id    
	                                    and if(? != false,b.user_id = ?,true)
	                                   
	                                    order by a.service_id",array($user_id,$user_id));
	    }
	    
	    foreach($rsltservice->result() as $rw)
	    {
	        
	        $user_ser = '';
	        $status = $rw->status;
	        $service_name = $rw->service_name;
	        $service_id = $rw->service_id;
	        $user_id = $rw->user_id;
	        if($status == "on")
	        {
	            $user_ser = 'checked';
	        }
	         $str_checkbox.='<label class="ckbox ckbox-success mg-t-15">
                            <input type="checkbox" id="chk'.$service_name.'" name="chk'.$service_name.'" '.$user_ser.'><span>'.$service_name.'</span>
                          </label>';
	    }
	    return $str_checkbox;
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