<?php
class Do_recharge_model extends CI_Model 
{	
var $k=0;
function _construct()
{		  
	  parent::_construct();
}

public function getcircle($Mobile)
{
    $stateurl = 'https://www.freecharge.in/rest/operators/mapping/V/'.$Mobile;
	$data = $this->ExecuteAPI($stateurl);
	$dataarray = (array)json_decode($data);
    $state = 0;
	if(is_array($dataarray))
	{
		if(isset($dataarray["prefixData"]))
		{
			$state = trim($dataarray["prefixData"][0]->circleMasterId);
		}
	}
	return $state;
}
public function recharge_url_hit_checkduplicate($recharge_id,$API)
{
	
	 $rslt = $this->db->query("insert into remove_queue_duplication (recharge_id,add_date,ipaddress,API) values(?,?,?,?)",array($recharge_id,$this->common->getDate(),$this->common->getRealIpAddr(),$API));
	  if($rslt == "" or $rslt == NULL)
	  {
		return false;
	  }
	  else
	  {
		return true;
	  }
}
public function recharge_blank_checkduplicate($user_id,$type)
{
	
	 $rslt = $this->db->query("insert into ssremoveduplicate (user_id,recdate,type) values(?,?,?)",array($user_id,$this->common->getMySqlDate(),$type));
	  if($rslt == "" or $rslt == NULL)
	  {
		return false;
	  }
	  else
	  {
		return true;
	  }
}
public function doblankrecharge($user_id)
{
   						
}
public function donotifications($apiinfo,$company_info)
{
    $failurelimit = $apiinfo->row(0)->failurelimit;
    $failurecount = $apiinfo->row(0)->failurecount;
    if($failurecount > $failurelimit and $failurelimit > 0)
    {
        $msg = $apiinfo->row(0)->api_name." (".$company_info->row(0)->company_name." ) : ".$apiinfo->row(0)->failurecount;
        $mstlike = $apiinfo->row(0)->api_name." (".$company_info->row(0)->company_name." ) : ";
		$rsltcheck = $this->db->query("select count(Id) as total from tblnotification where message = ? and is_unread = 'yes'",array($msg));
		if($rsltcheck->row(0)->total >= 0)
		{
		    
		    $this->db->query("delete from tblnotification where message like '%".$mstlike."%' and title = 'FAILURE LIMIT'",array($msg));
		    $this->db->query("insert into tblnotification(title,message,messagefor,add_date,ipaddress) values(?,?,?,?,?)",array("FAILURE LIMIT",$msg,"Admin",$this->common->getDate(),$this->common->getRealIpAddr()));
		}
		else
		{
		    $this->load->model("Notification");
		    //$this->Notification->send_wanotification("Admin",$msg);
		     $this->db->query("delete from tblnotification where message like '%".$mstlike."%' and title = 'FAILURE LIMIT'",array($msg));
		      $this->db->query("insert into tblnotification(title,message,messagefor,add_date,ipaddress) values(?,?,?,?,?)",array("FAILURE LIMIT",$msg,"Admin",$this->common->getDate(),$this->common->getRealIpAddr()));
		}
    }
}

public function CheckPendingResult($mobile,$amount)
{	
	$this->load->library("common");
	$recharge_date = $this->common->getMySqlDate();
	$result = $this->db->query("select recharge_id from  tblpendingrechares where mobile_no=? and amount=?  order by recharge_id desc",array($mobile,$amount));		
	if($result->num_rows() == 1)
	{
		return true;
	}
	else
	{
		return false;
	}		
}
public function getCommissionRange($company_id,$userinfo)
{
	$user_id = $userinfo->row(0)->user_id;
	
	
	
		$str_query = "select * from  tbluser_commission where company_id = ? and user_id = ?";
		$rslt = $this->db->query($str_query,array($company_id,$user_id));
		if($rslt->num_rows() == 1)
		{
			if($rslt->row(0)->min_com_limit > 0 or $rslt->row(0)->max_com_limit > 0 )
			{
				$resparr = array(
					"min_com_limit"=>$rslt->row(0)->min_com_limit,
					"max_com_limit"=>$rslt->row(0)->max_com_limit,
					);
					return $resparr;	
			}
			else
			{
				$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
				$rslt = $this->db->query($str_query,array($company_id,$userinfo->row(0)->scheme_id));
				if($rslt->num_rows() == 1)
				{
					$resparr = array(
							"min_com_limit"=>$rslt->row(0)->min_com_limit,
							"max_com_limit"=>$rslt->row(0)->max_com_limit,
							);
					return $resparr;

				}
				else
				{
					$resparr = array(
							"min_com_limit"=>"0",
							"max_com_limit"=>"0",
							);
					return $resparr;
				}
			}
		}
		else
		{
			$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
			$rslt = $this->db->query($str_query,array($company_id,$userinfo->row(0)->scheme_id));
			if($rslt->num_rows() == 1)
			{
				$resparr = array(
						"min_com_limit"=>$rslt->row(0)->min_com_limit,
						"max_com_limit"=>$rslt->row(0)->max_com_limit,
						);
				return $resparr;

			}
			else
			{
				$resparr = array(
							"min_com_limit"=>"0",
							"max_com_limit"=>"0",
							);
				return $resparr;
			}
		}	
}	
public function getCommissionInfo($company_id,$userinfo,$Amount)
{
	    $user_id = $userinfo->row(0)->user_id;
	    
		if(true)
		{
			
				$str_query = "select IFNULL(commission_per,0) as commission_per,CommissionAmount,Charge_per,Charge_amount,commission_type from  tblgroupapi where company_id = ? and group_id = ?";
				$rslt = $this->db->query($str_query,array($company_id,$userinfo->row(0)->scheme_id));
				if($rslt->num_rows() == 1)
				{
					if($rslt->row(0)->commission_per > 0)
					{
						$resparr = array(
							"Commission_Type"=>"PER",
							"Commission_Per"=>$rslt->row(0)->commission_per,
							"TYPE"=>"GROUP",
							);
						return $resparr;
					}
					else if($rslt->row(0)->CommissionAmount > 0)
					{
						$resparr = array(
							"Commission_Type"=>"AMOUNT",
							"Commission_Per"=>$rslt->row(0)->CommissionAmount,
							"TYPE"=>"GROUP",
							);
						return $resparr;
					}
					else
					{
						$resparr = array(
							"Commission_Type"=>"PER",
							"Commission_Per"=>"0",
							"TYPE"=>"GROUP",
							);
						return $resparr;
					}

				}
				else
				{
					$resparr = array(
							"Commission_Type"=>"PER",
							"Commission_Per"=>0.00,
							"TYPE"=>"GROUP",
							);
							return $resparr;
				}
			
		}
		else
		{
			$str_query = "select commission,commission_type from  tblgroupapi where company_id = ? and group_id = ?";
			$rslt = $this->db->query($str_query,array($company_id,$userinfo->row(0)->scheme_id));
			if($rslt->num_rows() == 1)
			{
				$resparr = array(
						"Commission_Type"=>$rslt->row(0)->commission_type,
						"Commission_Per"=>$rslt->row(0)->commission,
						"TYPE"=>"GROUP",
						);
				return $resparr;

			}
			else
			{
				$resparr = array(
						"Commission_Type"=>"PER",
						"Commission_Per"=>0.00,
						"TYPE"=>"GROUP",
						);
						return $resparr;
			}
		}
	
	
}	
private function errorresponse($message,$status,$rechargeBy)
{
    if($status == "Failure" )
    {
    	if(strlen($message) <= 1)
    	{
    		$message = "Recharge Failed";
    	}
        
    }

    if($message == "{}" and $status == "Failure")
    {
    	$message = "Recharge Failed";
    }
    if($message == "{}" and $status == "Success")
    {
    	$message = "Recharge Submitted Successfully";
    }

	//if($rechargeBy == "GPRS")
	if(true)
	{
		$resparray = array(
		"status"=>$status,
		"message"=>$message,
		"Message"=>$message,
		"Response"=>strtoupper($status)
		);
		echo  json_encode($resparray);exit;
	}
	else
	{
		return $message;
	}
}
private function validateorderid($user_id,$order_id)
{
	$add_date = $this->common->getDate();
	$ipaddress = $this->common->getRealIpAddr();
	
	$rslt = $this->db->query("insert into locking_order_id (user_id,order_id,add_date,ipaddress) values(?,?,?,?)",array($user_id,$order_id,$add_date,$ipaddress));
  if($rslt == "" or $rslt == NULL)
  {
	return false;
  }
  else
  {
	return true;
  }
}



public function checkpendinglimit($api_id,$company_id)
{
    $rslt = $this->db->query("select pendinglimit,failurelimit,totalpending,failurecount from pf_values where api_id = ? and company_id = ?",array($api_id,$company_id));
    if($rslt->num_rows() == 1)
    {
        $pendinglimit = $rslt->row(0)->pendinglimit;
        $failurelimit = $rslt->row(0)->failurelimit;
        $totalpending = $rslt->row(0)->totalpending;
        $failurecount = $rslt->row(0)->failurecount;
        if($pendinglimit >= $totalpending or  $pendinglimit == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return true;
    }
}

public function ProcessRecharge($user_info,$circle_code,$company_id,$Amount,$Mobile,$recharge_type,$service_id,$rechargeBy,$custname,$is_check_api = false,$is_check_commission = false)
{

	$order_id = 0;
    $Amount = intval($Amount);
    //error_reporting(-1);
    //ini_set("display_errors",1);
    //$this->db->db_debug = TRUE;
    //print_r($user_info->result());exit;
    $host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
	
	$amount = $Amount;
	$response_type = "CSV";
	if($user_info->row(0)->usertype_name != "Agent" and $user_info->row(0)->usertype_name != "Distributor"  and $user_info->row(0)->usertype_name != "MasterDealer")
	{
		$msg =  "UnAuthorized Access. Only Retailer Can Do Recharges";
		return $this->errorresponse($msg,"Failure",$rechargeBy);
		
	}
	if($user_info->row(0)->status == 0)
	{
		$msg =  "ERROR::Your Activation disabled, Contact Administrator";
		return $this->errorresponse($msg,"Failure",$rechargeBy);
	}
	

	$this->load->model("Update_methods");
	$this->load->model("Insert_model");
	$mobile_no = $user_info->row(0)->mobile_no;
	$usermobile = $mobile_no;
	$usertype = $user_info->row(0)->usertype_name;
	$username = $user_info->row(0)->username;
	$grouping = $user_info->row(0)->grouping;
	$user_id = $user_info->row(0)->user_id;
	$parent_id = $user_info->row(0)->parentid;
	$scheme_id = $user_info->row(0)->scheme_id;
	
	$flatcomm = (($user_info->row(0)->flatcomm * $amount) / 100);
	$flatcommD = 0;
	$parentinfo = $this->db->query("select flatcomm from tblusers where user_id = ?",array($user_info->row(0)->parentid));
	if($parentinfo->num_rows() == 1)
	{
	    $flatcomm_per = $parentinfo->row(0)->flatcomm;
	    $flatcommD = (($amount * $flatcomm_per)/100);

	    $flatcomm = $flatcomm + $flatcommD;
	}
	
	
	$company_info = $this->db->query("select * from tblcompany where company_id = ? order by company_id",array($company_id));

	$company_name = $company_info->row(0)->company_name;


	$isqueue = $company_info->row(0)->isqueue;
	$amounts_api = $company_info->row(0)->amounts_api;
	$AmountRange=  $company_info->row(0)->AmountRange;
	$RANGE_API=  $company_info->row(0)->RANGE_API;
	$api_range_arr= explode("-",$AmountRange);
	$company_name = $company_info->row(0)->company_name;
	$minAmt =  $company_info->row(0)->minamt;
	$maxAmt =   $company_info->row(0)->mxamt;
	$allowed_retry = $company_info->row(0)->allowed_retry;
	
	$code2 = false;
	$state_id = 0;
	
	$api_id = false;
	$recharge_api  = false;
	
   $ApiInfo = $this->db->query("SELECT a.company_id,a.api_id,a.amountrange,a.priority,a.status,api.api_name
FROM `operatorpendinglimit` a
left join api_configuration api on a.api_id = api.Id
where a.company_id = ? and api.enable_recharge = 'yes' and a.status = 'active' and a.api_id > 0 order by a.priority",array($company_id));
   //print_r( $ApiInfo->result());exit;
    if($ApiInfo->num_rows() == 0)
    {
        $resp_status = "Failure";
        $resp_message = "Configuration Missing";
        $this->custom_response(0,$mobile_no,$amount,$resp_status,$resp_message,$order_id,$response_type,$rechargeBy,$user_id);
    }
    else if($ApiInfo->num_rows() == 1)
    {
        $api_id = $ApiInfo->row(0)->api_id;
        $recharge_api = $ApiInfo->row(0);
    }
    else
    {
     
        $k=0;
        foreach($ApiInfo->result() as $apirw)
        {
            $temp_api_id = $apirw->api_id;
            $temp_api_name = $apirw->api_name;
            if($temp_api_name == "Random")
            {
        		$randomapi = $this->db->query("SELECT api_id FROM `tblrandomapirouting` where company_id = ? order by Rand() limit 1",array($company_id));
		        if($randomapi->num_rows() == 1)
		        {
		        	$pendinglimit_check = $this->checkpendinglimit($randomapi->row(0)->api_id,$company_id);
		        	if($pendinglimit_check == true )
		        	{
		        		$api_id = $randomapi->row(0)->api_id;
		        		break;	
		        	}
		        }
            }
            else if($temp_api_name == "Denomination_wise")
		    {
				$circle_id = $this->getcircle($Mobile);
		      
		       $amountapi = $this->db->query("
		                            SELECT 
		                                a.api_id,a.amounts,a.company_id,a.circle_id,b.api_name 
		                                FROM amountwiseapi a 
		                                left join api_configuration b on a.api_id = b.Id 
		                                left join operatorpendinglimit op on a.company_id = op.company_id and a.api_id = op.api_id
		                                where a.company_id = ? and b.enable_recharge = 'yes' and (b.is_active = 'yes' or a.api_id <= 3)  order by a.amounts desc",array($company_id));
	       
	           $amount_api_name = "";
	           
	           foreach($amountapi->result() as $amtrw)//main row loop
	           {
	               $amount_api_found = false;
	               $amount_api_name = "";
	               $amount_api_tempid = 0;
                  
	               if (preg_match('/,/',$amtrw->amounts) == 1 ) 
	               {
	                   
						$amounts_array = explode(",",$amtrw->amounts);
						if(in_array($amount,$amounts_array))
		                {

		                	if($amtrw->circle_id > 0)
		                	{
		                		if($amtrw->circle_id == $circle_id)
		                		{
		                			$amount_api_name = $amtrw->api_name;
				                    $amount_api_tempid = $amtrw->api_id;
				                    $amount_api_found = true;			
		                		}
		                	}
		                	else
		                	{
		                	   $amount_api_name = $amtrw->api_name;
			                   $amount_api_tempid = $amtrw->api_id;
			                   $amount_api_found = true;	
		                	}

		                   
		                }
	               }
	               else if (preg_match('/<->/',$amtrw->amounts) == 1 )
	               {
	                 	$amt_range = explode("<->",$amtrw->amounts);
    	                $min_amt = $amt_range[0];
    	                $max_amt = $amt_range[1];

    	                if($amount >= $min_amt and $amount <= $max_amt)
    	                {
    	                	
    	                	if($amtrw->circle_id > 0)
		                	{
		                		if($amtrw->circle_id == $circle_id)
		                		{
		                			$amount_api_name = $amtrw->api_name;
				                    $amount_api_tempid = $amtrw->api_id;
				                    $amount_api_found = true;			
		                		}
		                	}
		                	else
		                	{
		                	   $amount_api_name = $amtrw->api_name;
			                   $amount_api_tempid = $amtrw->api_id;
			                   $amount_api_found = true;	
		                	}
    	                }
	               }

	               if($amount_api_found == true and $amount_api_tempid > 0 )
	               {

	               		if($amount_api_name == "Circle_wise")
			            {
			               $circle_id = $this->getcircle($Mobile);
			               if($circle_id > 0)
			               {
			                   $rlstseriesapi = $this->db->query("select * from serieswiseapi where state_id = ? and company_id = ?",array($circle_id,$company_id));
			                   if($rlstseriesapi->num_rows() == 1)
			                   {

			                   		$pendinglimit_check = $this->checkpendinglimit($rlstseriesapi->row(0)->api_id,$company_id);
			                   		if($pendinglimit_check == true)
			                   		{
			                   			$api_id = $rlstseriesapi->row(0)->api_id;
			                       		break 2;
			                   		}
			                   }
			               }
			            }
			            else if($amount_api_name == "Random")
			            {
			               $randomapi = $this->db->query("SELECT a.api_id,b.api_name FROM `tblrandomapirouting` a left join api_configuration b on a.api_id = b.Id where a.company_id = ? order by Rand() limit 1",array($company_id));
			                if($randomapi->num_rows() == 1)
			                {
			                	$pendinglimit_check = $this->checkpendinglimit($randomapi->row(0)->api_id,$company_id);
		                   		if($pendinglimit_check == true)	
		                   		{
		                   			$api_id = $randomapi->row(0)->api_id;
			                    	break 2;
		                   		}  
			                }
			            }
			            else if($amount_api_tempid > 3)
			            {
			            
			            	$pendinglimit_check = $this->checkpendinglimit($amount_api_tempid,$company_id);
	                   		if($pendinglimit_check == true)	
	                   		{
	                   			$api_id = $amount_api_tempid;
			                	break 2;
	                   		}
			            }
	               }
	           }   
		    }
		    else if($temp_api_name == "Circle_wise")
		    {
		       $circle_id = $this->getcircle($Mobile);
		       if($circle_id > 0)
		       {
		           $rlstseriesapi = $this->db->query("select * from serieswiseapi where state_id = ? and company_id = ?",array($circle_id,$company_id));
		           if($rlstseriesapi->num_rows() == 1)
		           {
		           		$pendinglimit_check = $this->checkpendinglimit($rlstseriesapi->row(0)->api_id,$company_id);
		        		if($pendinglimit_check == true )
		        		{
		        			$api_id = $rlstseriesapi->row(0)->api_id;	
		        			break;
		        		}
		               
		           }
		       }
		    }
		    else
		    {
		    	$pendinglimit_check = $this->checkpendinglimit($apirw->api_id,$company_id);
        		if($pendinglimit_check == true )
        		{
        			$api_id = $apirw->api_id;
        			break;
        		}
		    }
            
            $k++;
        }
    }
    
////////////////////////////////////
////////////// U S E R    W I S E    S W I T C H I N G
//////////////////////////////////////////////////////
    
    $userwise_switching = $this->db->query("select api_id,blocked_amounts from  tbluser_commission where company_id = ? and user_id = ?",array($company_id,$user_id));
    if($userwise_switching->num_rows() == 1)
    {
        $userwise_api_id = $userwise_switching->row(0)->api_id;
        $blocked_amounts = $userwise_switching->row(0)->blocked_amounts;
        $blocked_amounts_array = explode(",",$blocked_amounts);
        if(in_array($Amount,$blocked_amounts_array))
        {
            $msg =  "ERROR::This Amount";
		    return $this->custom_response(0,$Mobile,$Amount,"Failure","Invalid Amount",$order_id,$response_type,$rechargeBy,$user_id);
        }
        
        if($userwise_api_id > 0)
        {
            $userwise_api_info = $this->db->query("select api_name from api_configuration where Id = ?",array($userwise_api_id));
            if($userwise_api_info->num_rows() == 1)
            {
                $api_id = $userwise_api_id;
            }
        } 
    }
    
  
    
   $ApiInfo = $this->db->query("select api_name from api_configuration where Id = ?",array($api_id));
    
   
   
  
   
	$groupinfo = $this->db->query("select * from tblgroup where Id = ? ",array($user_info->row(0)->scheme_id));
	if($groupinfo->num_rows() == 1)
	{
// 		if($api_name == "STOP")
// 		{
// 			$msg =  "ERROR::Service Temporary Not Available.Please Try After Some Time";
// 			return $this->errorresponse($msg,"Failure",$rechargeBy);
// 		}
		
		
		$minBalLimit = $groupinfo->row(0)->min_balance;
		$service = $groupinfo->row(0)->service;
		if($service == 0)
		{
			$msg =  "ERROR::Your Service Is Deactivated. Please Contact Administration";
			return $this->errorresponse($msg,"Failure",$rechargeBy);
		}
		/*$apicommissioninfo = $this->db->query("select * from tblgroupapi where company_id = ? and group_id = ?",array($company_id,$scheme_id));
		if($apicommissioninfo->num_rows() == 1)
		{
			$newapiinfo = $this->db->query("select * from tblapi where api_id = ?",array($apicommissioninfo->row(0)->api_id));
			if($newapiinfo->num_rows() == 1)
			{
				$ApiInfo = $newapiinfo;
			}
		}
		else
		{
			$minBalLimit  = $user_info->row(0)->min_bal_limit;
		}*/
		
	
		
	/*	$str_amounts =  $company_info->row(0)->amounts;
		if($str_amounts != "")
		{
			$strarr = explode(",",$str_amounts);
			foreach($strarr as $r)
			{
				if($r == $Amount)
				{
					$newapiinfo=$this->db->query("select * from tblapi where api_id = ?",array($amounts_api));
					if($newapiinfo->num_rows() == 1)a
					{
						$ApiInfo = $newapiinfo;
					}
					break;	
				}
			}
		}*/
			
		// if($this->checkduplicate($Amount,$Mobile) == false)
		// {
		// 	$msg =  "Duplicate Recharge Entry";
		// 	return $this->errorresponse($msg,"Failure",$rechargeBy);	
		// }
		
		if(!$this->CheckTimeInterval($Mobile,$Amount))
		{
			$msg =  "You can't send same Recharge Request for 30 min";
			return $this->errorresponse($msg,"Failure",$rechargeBy);	
		}
		/*if($this->Tblcompany_methods->checkblocked($user_id,$parent_id,$company_id) == false)
		{
			$msg =  "This Operator Is Blocked For U";
			return $this->errorresponse($msg,$rechargeBy);	
		}
		*/
		//echo $Amount." > ".$minAmt;exit;
		if($Amount < $minAmt)
		{
			$msg =  "Minimum Amount For This Operator is : ".$minAmt;
			return $this->errorresponse($msg,"Failure",$rechargeBy);	
		}
		if($Amount > $maxAmt)
		{
			$msg =  "Maximum Amount For This Operator is : ".$maxAmt;
			return $this->errorresponse($msg,"Failure",$rechargeBy);	
		}
		if(ctype_digit($Mobile)){}
		else
		{
			$msg =  $Mobile."ERROR::Mobile Number Is Not Valid, Please enter valid mobile number";
			return $this->errorresponse($msg,"Failure",$rechargeBy);	
		}		
		if($service_id == 1)
		{
		    if(strlen(trim($Mobile)) != 10)
			{
				$msg =  'ERROR::Mobile number can not be less then 10 digit.';
				return $this->errorresponse($msg,"Failure",$rechargeBy);	
			}
		}
		
		
		if($service_id == "23")
		{
			if(strlen(trim($Mobile)) != 10)
			{
				$msg =  'ERROR::Mobile number can not be less then 10 digit.';
				return $this->errorresponse($msg,"Failure",$rechargeBy);	
			}
		}
	
		if($this->CheckPendingResult($Mobile,$Amount) != true) // Check pending result
		{
			$current_bal = $this->Common_methods->getAgentBalance($user_id);
			
			if($Amount >= 0)
			{	
					if($current_bal >= ($Amount + $minBalLimit))
					{
						
							
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////// S T A R T    R E C H A R G E    H O M E    M O D E L    C O D E
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

							$userinfo = $user_info;
							$ip = $this->common->getRealIpAddr();
							$date = $this->common->getDate();
							$recharge_date = $this->common->getMySqlDate();
							$recharge_time = $this->common->getMySqlTime();				
							$usertype = $userinfo->row(0)->usertype_name;
							
							
					//////////////////////////////////////////////////////////////////////////////////////////////////////////
					/////////////// R E T A I L E R      C O M M I S S I O N    S E T T I N G S
					////////////////////////////////////////////////////////////////////////////////////////////////////////////
							$commission_arr = $this->getCommissionInfo($company_id,$userinfo,$amount);
							//print_r($commission_arr);exit;
							$commission_type =$commission_arr["Commission_Type"];
							$commission_per =$commission_arr["Commission_Per"];
							
							
							if($commission_type == "PER")
							{
								$commission_amount =round((($amount * $commission_per)/100),4);
							}
							else
							{
								$commission_amount = $commission_per;
							}
							
							$flat_commission = "";
							
						
			
					//////////////////////////////////////////////////////////////////////////////////////////////////////////
					/////////////// D I S T R I B U T O R      C O M M I S S I O N    S E T T I N G S
					////////////////////////////////////////////////////////////////////////////////////////////////////////////	
					$dist_info = $this->db->query("select user_id,scheme_id,parentid,usertype_name from tblusers where user_id = ?",array($userinfo->row(0)->parentid));
					$dist_commission_arr = $this->getCommissionInfo($company_id,$dist_info,$amount);
					$dist_commission_type =$dist_commission_arr["Commission_Type"];
					
					$DId = $dist_info->row(0)->user_id;
					
					if($dist_commission_type == "PER")
					{
						$dist_commission_per =$dist_commission_arr["Commission_Per"] - $commission_per;

						if($dist_commission_per < 0)
						{
							$fos_commission_amount = 0;
							$fos_commission_per = 0;
							$dist_commission_per =$dist_commission_arr["Commission_Per"] - $commission_per;
						}



						$dist_commission_amount =round((($amount * $dist_commission_per)/100),4);
					}
					else
					{
						$dist_commission_per =$dist_commission_arr["Commission_Per"];
						$dist_commission_amount = $dist_commission_per;
					}
					//////////////////////////////////////////////////////////////////////////////////////////////////////////
					/////////////// M A S T E R     D I S T R I B U T O R      C O M M I S S I O N    S E T T I N G S
					////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					$md_info = $this->db->query("select user_id,scheme_id,usertype_name,flatcomm from tblusers where user_id = ?",array($dist_info->row(0)->parentid));
					$md_commission_arr = $this->getCommissionInfo($company_id,$md_info,$amount);
					$md_commission_type =$md_commission_arr["Commission_Type"];
					$MdId  = $md_info->row(0)->user_id;


					$flatcommMd =  (($md_info->row(0)->flatcomm * $amount) / 100);

					$flatcomm = $flatcomm + $flatcommMd;
					
					
					if($md_commission_type == "PER")
					{
						$md_commission_per =$md_commission_arr["Commission_Per"] - $dist_commission_arr["Commission_Per"];	
						$md_commission_amount =round((($amount * $md_commission_per)/100),4);
					}
					else
					{
						$md_commission_per =$md_commission_arr["Commission_Per"];	
						$md_commission_amount = $dist_commission_per;
						
					}
					
							
					$md_commission_per = 0;
                   $md_commission_amount = 0;
                   $dist_commission_per = 0;
                   $dist_commission_amount = 0;					
					if($is_check_api == true)
				    {
				        $Tempapiinfo = $this->db->query("select api_name from api_configuration where Id = ?",array($api_id));
				      echo $Amount."  ".$api_id."   ".$Tempapiinfo->row(0)->api_name."  company name ".$company_name."   Apiinfo : ".$ApiInfo->row(0)->api_name;exit;     
				    }
					
						
						if($ApiInfo->row(0)->api_name == "STOP")		
						{
						    $msg =  'ERROR::SERVICE NOT AVAILABLE';
			                return $this->errorresponse($msg,"Failure",$rechargeBy);	
						}
					
				
					
					
					$order_id = "";
					
					
					
					if(true)
						{
							$ExecuteBy = "";
						    $ApiInfo = $this->db->query("select * from api_configuration where Id = ?",array($api_id));
						    if($ApiInfo->num_rows() == 1)
						    {
						        $ExecuteBy = $ApiInfo->row(0)->api_name;    
						        
						        $reroot_api1_id = 0;
						        $reroot_api2_id = 0;
						        $reroot_api3_id = 0;
						        $reroot_apis = $this->db->query("SELECT * FROM operatorpendinglimit where company_id = ? and api_id > 3 and api_id != 9 and status = 'active' and api_id != ? order by priority limit 3",array($company_id,$api_id));
						        if($reroot_apis->num_rows() > 0)
						        {
						            if($reroot_apis->num_rows() == 1)
						            {
						                $reroot_api1_id =  $reroot_apis->row(0)->api_id;
						            }
						            if($reroot_apis->num_rows() == 2)
						            {
						                $reroot_api1_id =  $reroot_apis->row(0)->api_id;
						                $reroot_api2_id =  $reroot_apis->row(1)->api_id;
						            }
						            if($reroot_apis->num_rows() >= 3)
						            {
						                $reroot_api1_id =  $reroot_apis->row(0)->api_id;
						                $reroot_api2_id =  $reroot_apis->row(1)->api_id;
						                $reroot_api3_id =  $reroot_apis->row(2)->api_id;
						            }
						            
						            
						            
						        }
						        
						    }
						    else
						    {
						         $ApiInfo = $this->db->query("select * from api_configuration where Id = ?",array($company_info->row(0)->api_id));
						         $ExecuteBy = $ApiInfo->row(0)->api_name;    
						        
						         $reroot_api1_id = 0;
						         $reroot_api2_id = 0;
						         $reroot_api3_id = 0;
						       
						        $reroot_apis = $this->db->query("SELECT * FROM operatorpendinglimit where company_id = ? and api_id > 3 and api_id != 9 and status = 'active' and api_id != ? order by priority limit 3",array($company_id,$ApiInfo->row(0)->Id));
						        if($reroot_apis->num_rows() > 0)
						        {
						            if($reroot_apis->num_rows() == 1)
						            {
						                $reroot_api1_id =  $reroot_apis->row(0)->api_id;
						            }
						            if($reroot_apis->num_rows() == 2)
						            {
						                $reroot_api1_id =  $reroot_apis->row(0)->api_id;
						                $reroot_api2_id =  $reroot_apis->row(1)->api_id;
						            }
						            if($reroot_apis->num_rows() >= 3)
						            {
						                $reroot_api1_id =  $reroot_apis->row(0)->api_id;
						                $reroot_api2_id =  $reroot_apis->row(1)->api_id;
						                $reroot_api3_id =  $reroot_apis->row(2)->api_id;
						            }
						            
						            
						            
						        }
						    }
									
							
									
									
									
								////////////////////////////////////////////////////////////////////////////////
            					//////////////////admin commission settings////////////////////////////////////
            					$adminComPer = 0;
            					$operatorcode_rslt = $this->db->query("
                                                	    select 
                                                	    a.company_id,
                                                	    a.company_name,
                                                	    a.mcode,
                                                	    a.service_id,
                                                	    b.service_name,
                                                	    IFNULL(g.commission,0) as commission,
                                                	    g.commission_type,
                                                	    g.commission_slab,
                                                	    g.OpParam1,
                                                	    g.OpParam2,
                                                	    g.OpParam3,
                                                	    g.OpParam4,
                                                	    g.OpParam5
                                                	    
                                                	    from tblcompany a 
                                                	    left join tblservice b on a.service_id = b.service_id 
                                                	    left join tbloperatorcodes g on g.api_id = ? and a.company_id = g.company_id
                                                	    where a.company_id = ?
                                                	    order by service_id",array($ApiInfo->row(0)->Id,$company_id));
            					if($operatorcode_rslt->num_rows() == 1)
            					{
            						$adminComPer = $operatorcode_rslt->row(0)->commission;
            					}
            
            					$adminCom =round((($Amount * $adminComPer) / 100),4);
            
            					//$this->db->query("update tblrecharge set AdminCommPer=?,AdminComm=? where recharge_id = ?",array($adminComPer,$adminCom,$recharge_id));
            					
            					
							$str_query = "insert into tblrecharge(
								company_id,amount,mobile_no,user_id,recharge_by,
								recharge_status,add_date,ipaddress,
								commission_amount,commission_per,
								DId,DComm,DComPer,
            					MdId,MdComm,MdComPer,
								ExecuteBy,order_id,state_id,AdminCommPer,AdminComm,host_id,flat_commission) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							$recharge_status = "Pending";
							$result = $this->db->query($str_query,array(
								$company_id,$Amount,$Mobile,$user_id,
								$rechargeBy,$recharge_status,$date,$ip,
								$commission_amount,$commission_per,
								$DId,$dist_commission_amount,$dist_commission_per,
								$MdId,$md_commission_amount,$md_commission_per,
								$ExecuteBy,$order_id,$state_id,$adminComPer,$adminCom,$host_id,$flatcomm));	
							if($result > 0)
							{
								$recharge_id=$this->db->insert_id();
							
                                $this->db->query("insert into tblpendingrechares(recharge_id,company_id,api_id,mobile_no,amount,status,user_id,add_date,state_id) values(?,?,?,?,?,?,?,?,?)",
                                array($recharge_id,$company_id,$api_id,$Mobile,$Amount,"Pending",$user_id,$this->common->getDate(),$state_id));
								$this->db->query("update pf_values set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$api_id));

                                if($allowed_retry > 0)
                                {
                                    $this->db->query("insert into reroot_count(recharge_id,allowed_retry,recharge_api,retry_api_1,retry_api_2,retry_api_3) values(?,?,?,?,?,?)",
                                                        array($recharge_id,$allowed_retry,$api_id,$reroot_api1_id,$reroot_api2_id,$reroot_api3_id));    
                                }
                                
                                
                                

								$dr_amount = $Amount - $commission_amount;	
								$this->load->model("Update_methods");
								$transaction_type = "Recharge";
								
							    $Description = $company_info->row(0)->company_name." | ".$Mobile." | ".$Amount." | Id = ".$recharge_id;
							    $FS_FLAG = false;
							    $F_FLAG = false;
								$this->load->model("Insert_model");
								$ewid = $this->Insert_model->tblewallet_Recharge_DrEntry($user_id,$recharge_id,$transaction_type,$dr_amount,$Description);
								
								
								
								if(true)
								//if($ApiInfo->num_rows()== 1) 
								{

											
										
									if($ewid > 1)	
									{
									    if($ApiInfo->num_rows() == 1)
									    {
									        $apiinfo = $ApiInfo;
                                            $api_id = $apiinfo->row(0)->Id;
                                	        $api_name = $apiinfo->row(0)->api_name;
                                	        $api_type = $apiinfo->row(0)->api_type;
                                	        $is_active = $apiinfo->row(0)->is_active;
                                	        $enable_recharge = $apiinfo->row(0)->enable_recharge;
                                	        $enable_balance_check = $apiinfo->row(0)->enable_balance_check;
                                	        $enable_status_check = $apiinfo->row(0)->enable_status_check;
                                	        $hostname = $apiinfo->row(0)->hostname;
                                	        $param1 = $apiinfo->row(0)->param1;
                                	        $param2 = $apiinfo->row(0)->param2;
                                	        $param3 = $apiinfo->row(0)->param3;
                                	        $param4 = $apiinfo->row(0)->param4;
                                	        $param5 = $apiinfo->row(0)->param5;
                                	        $param6 = $apiinfo->row(0)->param6;
                                	        $param7 = $apiinfo->row(0)->param7;
                                	        
                                	        $header_key1 = $apiinfo->row(0)->header_key1;
                                	        $header_key2 = $apiinfo->row(0)->header_key1;
                                	        $header_key3 = $apiinfo->row(0)->header_key1;
                                	        $header_key4 = $apiinfo->row(0)->header_key1;
                                	        $header_key5 = $apiinfo->row(0)->header_key1;
                                	        $header_value1 = $apiinfo->row(0)->header_value1;
                                	        $header_value2 = $apiinfo->row(0)->header_value2;
                                	        $header_value3 = $apiinfo->row(0)->header_value3;
                                	        $header_value4 = $apiinfo->row(0)->header_value4;
                                	        $header_value5 = $apiinfo->row(0)->header_value5;
                                	        
                                	        $balance_check_api_method = $apiinfo->row(0)->balance_check_api_method;
                                	        $balance_ceck_api = $apiinfo->row(0)->balance_ceck_api;
                                	        $status_check_api_method = $apiinfo->row(0)->status_check_api_method;
                                	        $status_check_api = $apiinfo->row(0)->status_check_api;
                                	        $validation_api_method = $apiinfo->row(0)->validation_api_method;
                                	        $validation_api = $apiinfo->row(0)->validation_api;
                                	        $transaction_api_method = $apiinfo->row(0)->transaction_api_method;
                                	        $api_prepaid = $apiinfo->row(0)->api_prepaid;
                                	        $api_dth = $apiinfo->row(0)->api_dth;
                                	        $api_postpaid = $apiinfo->row(0)->api_postpaid;
                                	        
                                	        $api_electricity = $apiinfo->row(0)->api_electricity;
                                	        $api_gas = $apiinfo->row(0)->api_gas;
                                	        $api_insurance = $apiinfo->row(0)->api_insurance;
                                	        $dunamic_callback_url = $apiinfo->row(0)->dunamic_callback_url;
                                	        $response_parser = $apiinfo->row(0)->response_parser;
                                	        
                                	        
                                	        $recharge_response_type = $apiinfo->row(0)->recharge_response_type;
                                	        $response_separator = $apiinfo->row(0)->response_separator;
                                	        
                                	        $recharge_response_status_field = $apiinfo->row(0)->recharge_response_status_field;
                                	        $recharge_response_opid_field = $apiinfo->row(0)->recharge_response_opid_field;
                                	        $recharge_response_apirefid_field = $apiinfo->row(0)->recharge_response_apirefid_field;
                                	        
                                	        $recharge_response_balance_field = $apiinfo->row(0)->recharge_response_balance_field;
                                	        $recharge_response_remark_field = $apiinfo->row(0)->recharge_response_remark_field;
                                	        $recharge_response_stat_field = $apiinfo->row(0)->recharge_response_stat_field;
                                	        
                                	        $recharge_response_fos_field = $apiinfo->row(0)->recharge_response_fos_field;
                                	        $recharge_response_otf_field = $apiinfo->row(0)->recharge_response_otf_field;
                                	        
                                	         $recharge_response_lapunumber_field = $apiinfo->row(0)->recharge_response_lapunumber_field;
                                	         $recharge_response_message_field = $apiinfo->row(0)->recharge_response_message_field;
                                	         $pendingOnEmptyTxnId = $apiinfo->row(0)->pendingOnEmptyTxnId;
                                	         $RecRespSuccessKey = $apiinfo->row(0)->RecRespSuccessKey;
                                	         $RecRespPendingKey = $apiinfo->row(0)->RecRespPendingKey;
                                	         $RecRespFailureKey = $apiinfo->row(0)->RecRespFailureKey;
                                	          
                                	         ///////////////////////////////////////////
                                	         ////////////////////////////////////////
                                	         ///////////////////////
                                	         ///////////////////////////////////////////
                                	         
                                                	    $OpParam1 = '';
                                                	    $OpParam2 = '';
                                                	    $OpParam3 = '';
                                                	    $OpParam4 = '';
                                                	    $OpParam5 = '';
                                            if($operatorcode_rslt->num_rows() == 1)
                                            {
                                                $OpParam1 = $operatorcode_rslt->row(0)->OpParam1;
                                                $OpParam2 = $operatorcode_rslt->row(0)->OpParam2;
                                                $OpParam3 = $operatorcode_rslt->row(0)->OpParam3;
                                                $OpParam4 = $operatorcode_rslt->row(0)->OpParam4;
                                                $OpParam5 = $operatorcode_rslt->row(0)->OpParam5;
                                            }
                                            $url = $hostname;
                                	        
                                	        if($transaction_api_method == "GET")
                                	        {
                                	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
                                	            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);
                                	            
                                	            $url = $hostname.$api_prepaid;
                                	            $url  = str_replace("@mn",$Mobile, $url);
                                	            $url  = str_replace("@amt",$Amount, $url);
                                	            $url  = str_replace("@opparam1",$OpParam1, $url);
                                	            $url  = str_replace("@opparam2",$OpParam2, $url);
                                	            $url  = str_replace("@opparam3",$OpParam3, $url);
                                	            $url  = str_replace("@opparam4",$OpParam4, $url);
                                	            $url  = str_replace("@opparam5",$OpParam5, $url);
                                	            $url  = str_replace("@reqid",$recharge_id, $url);
                                	            $response = $this->common->callurl(trim($url),$recharge_id);  
                                	        }
                                	        if($transaction_api_method == "POST")
                                	        {
                                	            ///Recharge?apiToken=@param&mn=@mn&op=@op1&amt=@amt&reqid=@reqid&field1=&field2=
                                	            $api_prepaid  = str_replace("@param1",$param1, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param2",$param2, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param3",$param3, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param4",$param4, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param5",$param5, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param6",$param6, $api_prepaid);
                                	            $api_prepaid  = str_replace("@param7",$param7, $api_prepaid);
                                	            
                                	            $url = $hostname.$api_prepaid;
                                	            $url  = str_replace("@mn",$Mobile, $url);
                                	            $url  = str_replace("@amt",$Amount, $url);
                                	            $url  = str_replace("@opparam1",$OpParam1, $url);
                                	            $url  = str_replace("@opparam2",$OpParam2, $url);
                                	            $url  = str_replace("@opparam3",$OpParam3, $url);
                                	            $url  = str_replace("@opparam4",$OpParam4, $url);
                                	            $url  = str_replace("@opparam5",$OpParam5, $url);
                                	            $url  = str_replace("@reqid",$recharge_id, $url);
                                	            
                                	            
                                	            $postdata = explode("?",$url)[1];
                                	            $response = $this->common->callurl_post(trim($url),$postdata,$recharge_id);  
                                	        }
                                	        
                                	        
                                            if($recharge_response_type == "XML")
                                            {
                                                $obj = (array)simplexml_load_string( $response);
                                               
                                                $recharge_response_status_field = str_replace("<","",$recharge_response_status_field);
                                                $recharge_response_status_field = str_replace(">","",$recharge_response_status_field);
                                                
                                                
                                                 $recharge_response_otf_field = str_replace("<","",$recharge_response_otf_field);
                                                $recharge_response_otf_field = str_replace(">","",$recharge_response_otf_field);
                                                
                                                // echo $recharge_response_status_field;
                                                // echo "<br><br>";
                                                // print_r($obj);exit;
                                                
                                                $recharge_response_opid_field = str_replace("<","",$recharge_response_opid_field);
                                                $recharge_response_opid_field = str_replace(">","",$recharge_response_opid_field);
                                                
                                                
                                                $recharge_response_balance_field = str_replace("<","",$recharge_response_balance_field);
                                                $recharge_response_balance_field = str_replace(">","",$recharge_response_balance_field);
                                                
                                                if(isset($obj[$recharge_response_status_field]))
                                                {
                                                    $statusvalue = $obj[$recharge_response_status_field];
                                                
                                                    $operator_id = json_encode($obj[$recharge_response_opid_field]);
                                                    $operator_id = str_replace('"','',$operator_id);
                                                    $lapubalance = 0;
                                                    if(isset($obj[$recharge_response_balance_field]))
                                                    {
                                                        $lapubalance = $obj[$recharge_response_balance_field];    
                                                    }
                                                    
                                                    
                                                    
                                                    $roffer = 0;
                                                    if(isset($obj[$recharge_response_otf_field]))
                                                    {
                                                        $roffer = $obj[$recharge_response_otf_field];    
                                                    }
                                                    
                                                    $success_key_array = explode(",",$RecRespSuccessKey);
                                                    $failure_key_array = explode(",",$RecRespFailureKey);
                                                    $pending_key_array = explode(",",$RecRespPendingKey);
                                                    
                                                   
                                                    if (in_array($statusvalue, $success_key_array)) 
                                                    {
                                                        $status = 'Success';
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false,$lapubalance,0,false,$roffer);
                                    					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);
                                                    }
                                                    else if (in_array($statusvalue, $failure_key_array)) 
                                                    {
                                                        $status = 'Failure';
                                                        $this->dofailure($recharge_id,$operator_id,$status,$Mobile,$Amount,$response_type,$rechargeBy,$company_id,$ApiInfo->row(0)->Id,$user_id,$order_id,$lapubalance,$allowed_retry);
                                                    }
                                                    else  if (in_array($statusvalue, $pending_key_array)) 
                                                    {
                                                        $status = 'Pending';
                                                        $operator_id = "";
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                    				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);  
                                                    }   
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);  
                                                }
                                            }
                                            else if($recharge_response_type == "JSON")
                                            {
                                                $obj = (array)json_decode($response);
                                               
                                                
                                                
                                                if(isset($obj[$recharge_response_status_field]))
                                                {
                                                    $statusvalue = $obj[$recharge_response_status_field];
                                                    $operator_id = "";
                                                    if(isset($obj[$recharge_response_status_field]))
                                                    {
                                                    	$operator_id = $obj[$recharge_response_opid_field];	
                                                    }
                                                    
                                                    $lapubalance = 0;
                                                    if(isset($obj[$recharge_response_balance_field]))
                                                    {
                                                        $lapubalance = $obj[$recharge_response_balance_field];    
                                                    }
                                                
                                                
                                                    $roffer = 0;
                                                    if(isset($obj[$recharge_response_otf_field]))
                                                    {
                                                        $roffer = $obj[$recharge_response_otf_field];    
                                                    }
                                                    
                                                    
                                                    $success_key_array = explode(",",$RecRespSuccessKey);
                                                    $failure_key_array = explode(",",$RecRespFailureKey);
                                                    $pending_key_array = explode(",",$RecRespPendingKey);
                                                    
                                                   
                                                    if (in_array($statusvalue, $success_key_array)) 
                                                    {
                                                        $status = 'Success';
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false,$lapubalance,0,false,$roffer);
                                    					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);
                                                    }
                                                    else if (in_array($statusvalue, $failure_key_array)) 
                                                    {
                                                        $status = 'Failure';
                                                        $this->dofailure($recharge_id,$operator_id,$status,$Mobile,$Amount,$response_type,$rechargeBy,$company_id,$ApiInfo->row(0)->Id,$user_id,$order_id,$lapubalance,$allowed_retry);
                                                    }
                                                    else  if (in_array($statusvalue, $pending_key_array)) 
                                                    {
                                                        $status = 'Pending';
                                                        $operator_id = "";
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                    				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);  
                                                    }   
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);  
                                                }
                                            }
                                            else if($recharge_response_type == "CSV")
                                            {
                                                $obj = explode($response_separator,$response);
                                               
                                                if(isset($obj[$recharge_response_status_field]))
                                                {
                                                    $statusvalue = $obj[$recharge_response_status_field];
                                                    $operator_id = json_encode($obj[$recharge_response_opid_field]);
                                                    $lapubalance = 0;
                                                    if(isset($obj[$recharge_response_balance_field]))
                                                    {
                                                        $lapubalance = $obj[$recharge_response_balance_field];    
                                                    }
                                                    
                                                    $success_key_array = explode(",",$RecRespSuccessKey);
                                                    $failure_key_array = explode(",",$RecRespFailureKey);
                                                    $pending_key_array = explode(",",$RecRespPendingKey);
                                                    
                                                   
                                                    if (in_array($statusvalue, $success_key_array)) 
                                                    {
                                                        $status = 'Success';
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false,$lapubalance);
                                    					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);
                                                    }
                                                    else if (in_array($statusvalue, $failure_key_array)) 
                                                    {
                                                        $status = 'Failure';
                                                        $this->dofailure($recharge_id,$operator_id,$status,$Mobile,$Amount,$response_type,$rechargeBy,$company_id,$ApiInfo->row(0)->Id,$user_id,$order_id,$lapubalance,$allowed_retry);
                                                    }
                                                    else  if (in_array($statusvalue, $pending_key_array)) 
                                                    {
                                                        $status = 'Pending';
                                                        $operator_id = "";
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                    				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);  
                                                    }   
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile); 
                                                }
                                            } 
                                            else if($recharge_response_type == "PARSER")
                                            {
                                                $rsltmessagesettings = $this->db->query("select * from message_setting where api_id = ?",array($ApiInfo->row(0)->Id));
                                                if($rsltmessagesettings->num_rows() >= 1)
                                                {
                                                    foreach($rsltmessagesettings->result() as $r)
    												{
    													$status_word = $r->status_word;
    													$num_start = $r->number_start;
    													$num_end = $r->number_end;
    													
    													$balance_start = $r->balance_start;
    													$balance_end = $r->balance_end;
    													
    													$operator_id_start = $r->operator_id_start;
    													$operator_id_end = $r->operator_id_end;
    													$status = $r->status;
    													$api_id = $r->api_id;
    													//echo $status_word;exit;
                                                        
    													if (preg_match("/".$status_word."/",$response) == 1 and preg_match("/".$operator_id_start."/",$response) == 1)
    													{
                                                            
    														$mobile_no = $this->get_string_between($response, $num_start, $num_end);
    														$operator_id = $this->get_string_between($response, $operator_id_start, $operator_id_end);
    														
    														$lapubalance = $this->get_string_between($response, $balance_start, $balance_end);
    
    														$operator_id = str_replace("\n","",$operator_id);
    														$mobile_no = str_replace("\n","",$mobile_no);
                                                        	
    														$this->load->model("Update_methods");
    														if($status == "Success" or $status == "Failure")
    														{
    															if($status == "Failure")
    															{
    																$status = 'Failure';
                                                                    $this->dofailure($recharge_id,$operator_id,$status,$Mobile,$Amount,$response_type,$rechargeBy,$company_id,$ApiInfo->row(0)->Id,$user_id,$order_id,$lapubalance,$allowed_retry);
    															}
    															else
    															{
    																$status = 'Success';
                                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false,$lapubalance);
                                                					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);
    															}	
    														}
    														else
    														{
    															$status = 'Pending';
    															$operator_id = "";
    															$order_id = "";
                                            					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile);
    														}
    													}
    													else
    													{
        													$status = 'Pending';
                                                            $operator_id = "";
                                                            $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                        				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile); 
    													}
    												}
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile); 
                                                }     
                                            } 
									    }
									    else
									    {
									        $status = 'Pending';
                                            $operator_id = "";
                                            $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                        				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id,$company_name,$usermobile); 
                        				    
									    }
                                    }
											else
											{
											   $status = "Failure";
        									   $operator_id = "";
        									   $this->db->query("update tblrecharge set recharge_status = 'Failure' where recharge_id  = ?",array($recharge_id));
								                return $this->errorresponse($msg,"Failure",$rechargeBy);	
											}

										}
								else
								{
								    $msg =  'Configuration Missing, Contact Service Provider';
								    return $this->errorresponse($msg,"Failure",$rechargeBy);
								}

							}
							else
							{
							       $msg =  'Internal Server Error 1';
								   return $this->errorresponse($msg,"Failure",$rechargeBy);
							}
						}
						else
						{
						    $msg =  'Commission Calculation Invalid. Please Contact Administrator';
							return $this->errorresponse($msg,"Failure",$rechargeBy);
						}
						
					//////////////////////////////////////////////////////////////////////////////////////////////////////////
					///////////////
					////////////////////////////////////////////////////////////////////////////////////////////////////////////	
					

//******************************************************************************************************************************//							
							
					}
					else
					{
					    $msg =  'InSufficient Balance';
						return $this->errorresponse($msg,"Failure",$rechargeBy);
					}
				}	
			else
			{
			    $msg =  'Invalid Amount';
				return $this->errorresponse($msg,"Failure",$rechargeBy);
			}
		}
		else
		{
		       $msg =  'Recharge Already In Pending Process';
			   return $this->errorresponse($msg,"Failure",$rechargeBy);
		}
	}
	else
	{
	    $msg =  'Retailer Does Not Belong To Any Group';
	    return $this->errorresponse($msg,"Failure",$rechargeBy);
	}
}
public function sendRechargeSMS($company_name,$Mobile,$Amount,$TransactionID,$status,$balance,$senderMobile)
{
	
}
public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		
		if(strlen($start) > 0 )
		{
		    $ini = strpos($string, $start);    
		}
		else
		{
		    $ini = 0;
		}
		if ($ini == 0) return '';
		$ini += strlen($start);
		
		
		
		
		if($end == "")
		{
		    $len = strlen($string);
		}
		else
		{
		    $len = strpos($string, $end, $ini) - $ini;    
		}
		
		return substr($string, $ini, $len);
	}
	private function callurl($url)
	{	
		// $username;exit;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_TIMEOUT,50);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
	private function callTxurl($url)
	{	
		// $username;exit;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
	private function callurl2($url)
	{	
		// $username;exit;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}






	public function checkduplicate($user_id,$number)
	{
		$add_date = $this->getDate();
		$ip ="asdf";
		$rslt = $this->db->query("insert into tbremoveduplication (user_id,add_date,number,ip) values(?,?,?,?)",array($user_id,$add_date,$number,$ip));
		  if($rslt == "" or $rslt == NULL)
		  {
			$this->logentry($add_date,$number,$user_id);
			return false;
		  }
		  else
		  {
			return true;
		  }
	}
	private function logentry($add_date,$number,$user_id)
	{
		$filename = "duplicate_entry.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");
	
		$this->load->helper('file');
		$sapretor = "------------------------------------------------------------------------------------";
		
	write_file($filename." .\n", 'a+');
	write_file($filename, $add_date."\n", 'a+');
	write_file($filename, "Number : ".$number."\n", 'a+');
	write_file($filename, "User Id : ".$user_id."\n", 'a+');
	write_file($filename, $sapretor."\n", 'a+');
	}
	private function getDate()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$date = date("Y-m-d h:i");		
		return $date; 
	}
	public function custom_response($recharge_id,$mobile_no,$amount,$status,$message,$order_id,$response_type,$rechargeBy,$user_id,$company_name = false,$usermobile_number = false)
	{

		if($usermobile_number != false)
		{
			// $smsMessage = "Recharge of ".$company_name."  Number : ".$mobile_no."  Amount : ".$amount." is ".$status."   Operator Id : ".$message;
			// $this->load->model("Sms");
			// $this->Sms->sendPushNotificationToFCMSever($usermobile_number, "Recharge",$smsMessage) ;
		}
		

		return $this->errorresponse($message,$status,$rechargeBy);
	}
	private function callapi($url,$postfields)
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		$buffer = curl_exec($ch);
		curl_close($ch);
		
		return $buffer;
	}
	private function ExecuteAPI($url)
	{	
	
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($ch);	
		curl_close($ch);
		return $buffer;
	}
	private function CheckTimeInterval($mobile,$amount)
	{
		$this->load->library("common");
		$recharge_date = $this->common->getMySqlDate();
		$str_query = "SELECT add_date FROM `tblrecharge` where mobile_no=? and recharge_status != 'Failure' and amount=? and Date(add_date)=?";
		$result = $this->db->query($str_query,array($mobile,$amount,$recharge_date));				
		if($result->num_rows() == 1)
		{
			putenv("TZ=Asia/Calcutta");
			date_default_timezone_set('Asia/Calcutta');
			$stime = date("h:i:s A");		
			$etime = date_format(date_create($result->row(0)->add_date),'h:i:s A');
			if( (( strtotime($stime)  - strtotime($etime)) / 60) > (30))
			{return true;}
			else
			{return false;}
		}
		else
		{
			return true;
		}					
	} 
	private function dofailure($recharge_id,$operator_id,$status,$Mobile,$Amount,$response_type,$rechargeBy,$company_id,$api_id,$user_id,$order_id,$lapubalance,$allowed_retry)
	{
	    $date = $this->common->getDate();
	    $ip = $this->common->getRealIpAddr();
	    
	
		
	    $lapunumber = "";
 		$rerootapirslt = $this->db->query("SELECT a.retry_count FROM reroot_count a where  a.recharge_id = ? and a.retry_count < ? and allowed_retry > 0",array($recharge_id,$allowed_retry));
		if($rerootapirslt->num_rows() == 1)
		{
			$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false);
		}
		else
		{
		    $callback = false;
		    $recharge_info = $this->db->query("
                    		select 
                    		
                    		a.order_id,
                    		a.recharge_by,
                    		a.user_id, 
                    		a.add_date,
                    		a.ExecuteBy,
                    		a.recharge_status,
                    		a.company_id,
                    		a.mobile_no,
                    		a.amount,
                    		a.commission_amount,
                    		a.user_id,
                    		b.company_name,
                    		b.allowed_retry,
                    		c.mobile_no as sendermobile,
                    		d.call_back_url as respurl 
                    		from tblrecharge a
                    		left join tblusers_info d on a.user_id = d.user_id
                    		left join tblcompany b on a.company_id = b.company_id
                    		left join tblusers c on a.user_id = c.user_id 
                    		where 
                    		a.recharge_id = ?",array($recharge_id));
                    		$this->load->model("Update_methods");
		    $this->Update_methods->refundOfAcountReportEntry($recharge_id,$status,$operator_id,$company_id,$user_id,$lapubalance,$lapunumber,$recharge_info,$date,$ip,$rechargeBy,$callback,$recharge_info->row(0)->respurl,$recharge_info->row(0)->order_id);	        
			return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,"Failure",$response_type,$rechargeBy,$user_id);
		}
	}
	private function loging($recharge_id,$actionfrom,$remark)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into tbllogs(recharge_id,add_date,ipaddress,actionfrom,remark) values(?,?,?,?,?)",
						array($recharge_id,$add_date,$ipaddress,$actionfrom,$remark));
	}
}
?>