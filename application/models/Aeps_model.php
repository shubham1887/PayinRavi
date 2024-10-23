<?php
class Aeps_model extends CI_Model 
{ 
   
	function _construct()
	{
	   
		  // Call the Model constructor
		  parent::_construct();
	}
	public function getAepsCommissionOld($amount,$userinfo)
	{
		$RCommAmt = 0;
		$DCommAmt = 0;
		$rslt = $this->db->query("
			SELECT Id, range_from, range_to, commission_type, commission, max_commission_amount FROM aeps_commission_slabs 
				where a.range_from <= ? and a.range_to >= ? ",array($amount,$amount));
		if($getrangededuction->num_rows() == 1)
		{
			$commission =  $rslt->row(0)->commission;
			$commission_type =  $rslt->row(0)->commission_type;
			$max_commission_amount =  $rslt->row(0)->max_commission_amount;
			$DComm =  0;//$rslt->row(0)->DComm;
			$DComm_type =  "PER";//$rslt->row(0)->DComm_type;
			$MaxDComm =  0;//$rslt->row(0)->MaxDComm;


			///retailer commission calculation
			if($commission_type == "PER")
			{
				$RCommAmt = (($amount * $commission)/100);
			}
			else
			{
				$RCommAmt = $commission;	
			}
			if($RCommAmt > $max_commission_amount)
			{
				$RCommAmt = $max_commission_amount;		
			}




			///Distributor commission calculation
			if($DComm_type == "PER")
			{
				$DCommAmt = (($amount * $DComm)/100);
			}
			else
			{
				$DCommAmt = $DComm;	
			}
			if($DCommAmt > $MaxDComm)
			{
				$DCommAmt = $MaxDComm;		
			}




		}
		else
		{
			$RCommAmt = 0;
			$DCommAmt = 0;
		}


		$resp_array = array(
			"RCommAmt"=>$RCommAmt,
			"DCommAmt"=>$DCommAmt,
		);

		return $resp_array;

	}
	public function getAepsCommission($amount,$userinfo)
  {
    
    
    $groupinfo = $this->db->query("select * from tblgroup where Id = ?",array($userinfo->row(0)->scheme_id));
  if($groupinfo->num_rows() == 1)
  {
    $getrangededuction = $this->db->query("
      select 
        a.commission_type,
        a.commission,
        a.max_commission
        from aeps_slab a 
        where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($amount,$amount,$groupinfo->row(0)->Id));
      if($getrangededuction->num_rows() == 1)
      {
        $commission_type = $getrangededuction->row(0)->commission_type;
        $commission = $getrangededuction->row(0)->commission;
        $max_commission = $getrangededuction->row(0)->max_commission;
        if($commission_type == "PER")
        {
          $commission = (($amount * $commission)/100);
        }
        if($commission > $max_commission)
        {
          $commission = $max_commission;
        }
     

        $resp_array = array(
			"RCommAmt"=>$commission,
			"DCommAmt"=>0,
		);
		return $resp_array;

      }
    
    
  }
    
    
    
    
    
    

}
	
}

?>