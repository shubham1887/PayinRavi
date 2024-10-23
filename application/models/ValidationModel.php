<?php
class ValidationModel extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	
	public function validateMobile($mobile_no)
	{
	    if(strlen($mobile_no) == 10)
	    {
	    	return true;
	    }
	    return false;;
	}
	public function validatePassword($password)
	{
	    if(strlen($password) <= 20)
	    {
	    	return true;
	    }
	    return false;;
	}
	
}

?>