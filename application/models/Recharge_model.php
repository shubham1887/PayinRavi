<?php
class Recharge_model extends CI_Model 
{	
var $k=0;
function _construct()
{		  
	  parent::_construct();
}



private function checkoperatorlimit($user_id,$company_id)
	{
		$check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($user_id, $company_id));
		if($check_rslt->num_rows() == 1)
		{
			$loadlimit = $check_rslt->row(0)->loadlimit;
			$usedlimit = $check_rslt->row(0)->usedlimit;
			if(intval($usedlimit) > intval($loadlimit) and intval($loadlimit) > 0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	private function updateusedlimit($user_id,$company_id,$amount)
	{
		$check_rslt = $this->db->query("select * from tbluser_commission where user_id = ? and company_id = ?",array($user_id, $company_id));
		if($check_rslt->num_rows() == 1)
		{
			$loadlimit = $check_rslt->row(0)->loadlimit;
			$usedlimit = $check_rslt->row(0)->usedlimit;
			if($loadlimit > 0)
			{
				$usedlimit = $usedlimit + $amount;	
				$this->db->query("update tbluser_commission set usedlimit = ? where user_id = ? and company_id = ?",array($usedlimit,$user_id, $company_id));
			}
		}
		
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
	    $str_query = "select commission,commission_type from  tbluser_commission where company_id = ? and user_id = ?";
		$rslt = $this->db->query($str_query,array($company_id,$user_id));
		if($rslt->num_rows() == 1)
		//if(false)
		{
		    
		    if($rslt->row(0)->commission_type > 0)
		    {
		        $rslt_slabinfo = $this->db->query("SELECT * FROM `mt_commission_slabs` where group_id = ? and range_from <= ? and range_to >= ?",array($rslt->row(0)->commission_type,$Amount,$Amount));
		        if($rslt_slabinfo->num_rows() == 1)
		        {
		            $Commission_Type = $rslt_slabinfo->row(0)->charge_type;
		            $Commission_Per = $rslt_slabinfo->row(0)->charge_amount;
	            	$resparr = array(
    					"Commission_Type"=>$Commission_Type,
    					"Commission_Per"=>$Commission_Per,
    					"TYPE"=>"SLAB",
    					);
    					return $resparr;
		        }
		        else
		        {
		            if($rslt->row(0)->commission > 0 )
        			{
        				$resparr = array(
        					"Commission_Type"=>$rslt->row(0)->commission_type,
        					"Commission_Per"=>$rslt->row(0)->commission,
        					"TYPE"=>"ENTITY",
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
		    else
		    {
		        if($rslt->row(0)->commission > 0 )
    			{
    				$resparr = array(
    					"Commission_Type"=>$rslt->row(0)->commission_type,
    					"Commission_Per"=>$rslt->row(0)->commission,
    					"TYPE"=>"ENTITY",
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
private function errorresponse($message,$rechargeBy)
{
	if($rechargeBy == "GPRS")
	{
		$resparray = array(
		"MESSAGEBOX_MESSAGETYPE"=>"FAILURE",
		"MESSAGEBOX_MESSAGEBODY"=>$message
		);
		return $resparray;
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

	
	/*$rslt = $this->db->query("select recharge_id from tblrecharge where order_id = ? and user_id = ? order by recharge_id",array($order_id,$user_id));
	if($rslt->num_rows() > 0)
	{
		return false;
	}
	else
	{
		return true;
	}*/
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
        if($pendinglimit > $totalpending  or $pendinglimit == 0)
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


public function ProcessRecharge($user_info,$circle_code,$company_id,$Amount,$Mobile,$recharge_type,$service_id,$rechargeBy,$order_id,$is_check_api = false)
{

	// error_reporting(-1);
	// ini_set('display_errors',1);
	// $this->db->db_debug = TRUE;

	$amount = $Amount;
	$response_type = "JSON";

	if($user_info->row(0)->usertype_name != "APIUSER")
	{
		$msg =  "UnAuthorized Access";
		return $this->errorresponse($msg,$rechargeBy);
		
	}
	if($user_info->row(0)->status == 0)
	{
		$msg =  "ERROR::Your Activation disabled, Contact Administrator";
		return $this->errorresponse($msg,$rechargeBy);
	}
	$this->load->model("Tblrecharge_methods");
	$this->load->model("Update_methods");
	$this->load->model("Tblcompany_methods");

	$this->load->model("Insert_model");
	$user_id = $user_info->row(0)->user_id;
	$mobile_no = $user_info->row(0)->mobile_no;
	$usertype = $user_info->row(0)->usertype_name;
	$username = $user_info->row(0)->username;
	$grouping = $user_info->row(0)->grouping;
	$user_id = $user_info->row(0)->user_id;
	$parent_id = $user_info->row(0)->parentid;
	$scheme_id = $user_info->row(0)->scheme_id;
	
	$flatcomm = (($user_info->row(0)->flatcomm * $amount) / 100);

	$company_info = $this->Tblcompany_methods->getCompany_info($company_id);
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
    
    
    if($is_check_api == true)
    {
       // $Tempapiinfo = $this->db->query("select api_name from api_configuration where Id = ?",array($api_id));
       // echo $Tempapiinfo->row(0)->api_name."  company name ".$company_name;exit;     
    }
   
	$groupinfo = $this->db->query("select * from tblgroup where Id = ? and groupfor = 'APIUSER'",array($user_info->row(0)->scheme_id));
	if($groupinfo->num_rows() == 1)
	{
		$minBalLimit = $groupinfo->row(0)->min_balance;
		$service = $groupinfo->row(0)->service;
		if($service == 0)
		{
			$msg =  "ERROR::Your Service Is Deactivated. Please Contact Administration";
			return $this->errorresponse($msg,$rechargeBy);
		}
		
		if($Amount < $minAmt)
		{
			$msg =  "Minimum Amount For This Operator is : ".$minAmt;
			return $this->errorresponse($msg,$rechargeBy);	
		}
		if($Amount > $maxAmt)
		{
			$msg =  "Maximum Amount For This Operator is : ".$maxAmt;
			return $this->errorresponse($msg,$rechargeBy);	
		}
		if(ctype_digit($Mobile)){}
		else
		{
			$msg =  $Mobile."ERROR::Mobile Number Is Not Valid, Please enter valid mobile number";
			return $this->errorresponse($msg,$rechargeBy);	
		}		
	
		if($this->CheckPendingResult($Mobile,$Amount) != true) // Check pending result
		{
			$current_bal = $this->Common_methods->getAgentBalance($user_id);
			if($Amount >= 0)
			{	
					if($current_bal >= ($Amount))
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
							$commission_arr = $this->getCommissionInfo($company_id,$userinfo,$Amount);
							//print_r($commission_arr);exit;
							$commission_type =$commission_arr["Commission_Type"];
							$commission_per =$commission_arr["Commission_Per"];
							
							
							if($commission_type == "AMOUNT")
							{
								$commission_amount = $commission_per;
							}
							else
							{
							    $commission_amount =round((($Amount * $commission_per)/100),4);
								
							}
							
							$flat_commission = "";
							
						
					
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
						        $api_id = $company_info->row(0)->api_id;
						        $ApiInfo = $this->db->query("select * from api_configuration where Id = ?",array($company_info->row(0)->api_id));
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
                                                	    g.commission,
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
								
								
								
							//if($this->validateorderid($user_id,$order_id) == false) 
							//{ 
							//	$this->custom_response("0",$Mobile,$Amount,"Failure","Please Pass Unique Order Id",$order_id,$response_type,$rechargeBy,$user_id);
							//} 	
												
							$str_query = "insert into tblrecharge(
								company_id,amount,mobile_no,user_id,recharge_by,
								recharge_status,add_date,ipaddress,
								commission_amount,commission_per,
								ExecuteBy,order_id,state_id,AdminCommPer,AdminComm,flat_commission) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							$recharge_status = "Pending";
							$result = $this->db->query($str_query,array(
								$company_id,$Amount,$Mobile,$user_id,
								$rechargeBy,$recharge_status,$date,$ip,
								$commission_amount,$commission_per,
								$ExecuteBy,$order_id,$state_id,$adminComPer,$adminCom,$flatcomm));	
							if($result > 0)
							{
								$recharge_id=$this->db->insert_id();
                                $this->db->query("insert into tblpendingrechares(recharge_id,company_id,api_id,mobile_no,amount,status,user_id,add_date,state_id) values(?,?,?,?,?,?,?,?,?)",
                                array($recharge_id,$company_id,$api_id,$Mobile,$Amount,"Pending",$user_id,$this->common->getDate(),$state_id));
								
							    $this->db->query("update pf_values set totalpending = totalpending + 1 where company_id = ? and api_id = ?",array($company_id,$api_id));
							    
                                $this->updateusedlimit($user_id,$company_id,$Amount);
                                if($allowed_retry > 0)
                                {
                                    $this->db->query("insert into reroot_count(recharge_id,allowed_retry,recharge_api,retry_api_1,retry_api_2,retry_api_3) values(?,?,?,?,?,?)",
                                                        array($recharge_id,$allowed_retry,$api_id,$reroot_api1_id,$reroot_api2_id,$reroot_api3_id));    
                                }
							    
							    
							    
							    
								$dr_amount = $Amount - $commission_amount;					
								$dr_amount = $Amount - $commission_amount;					
								//if($ApiInfo->num_rows()== 1) 
								if(true)
								{
                                    $this->load->model("Update_methods");
									$transaction_type = "Recharge";
										
								    $Description = $company_info->row(0)->company_name." | ".$Mobile." | ".$Amount." | Id = ".$recharge_id;
									$this->load->model("Insert_model");
									$ewid = $this->Insert_model->tblewallet_Recharge_DrEntry($user_id,$recharge_id,$transaction_type,$dr_amount,$Description);
										
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
                                	         $RecRespFailureText = $apiinfo->row(0)->RecRespFailureText;
                                	          
                                	         ///////////////////////////////////////////
                                	         ////////////////////////////////////////
                                	         ///////////////////////
                                	         ///////////////////////////////////////////
                                	         $operatorcode_rslt = $this->db->query("
                                                	    select 
                                                	    a.company_id,
                                                	    a.company_name,
                                                	    a.mcode,
                                                	    a.service_id,
                                                	    b.service_name,
                                                	    g.commission,
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
                                                	    order by service_id",array($api_id,$company_id));
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
                                                    
                                                    $roffer = 0;
                                                    if(isset($obj[$recharge_response_otf_field]))
                                                    {
                                                        $roffer = $obj[$recharge_response_otf_field];    
                                                    }
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
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false,$lapubalance,0,false,$roffer);
                                    					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);
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
                                    				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);  
                                                    }   
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);  
                                                }
                                            }
                                            else if($recharge_response_type == "JSON")
                                            {
                                                $obj = (array)json_decode($response);
                                               
                                                
                                                
                                                if(isset($obj[$recharge_response_status_field]))
                                                {
                                                    $statusvalue = $obj[$recharge_response_status_field];
                                                    $operator_id = $obj[$recharge_response_opid_field];
                                                    $roffer = 0;
                                                    if(isset($obj[$recharge_response_otf_field]))
                                                    {
                                                        $roffer = $obj[$recharge_response_otf_field];    
                                                    }
                                                    
                                                    $lapubalance = 0;
                                                    if(isset($obj[$recharge_response_balance_field]))
                                                    {
                                                        $lapubalance = $obj[$recharge_response_balance_field];    
                                                    }
                                                
                                                    $success_key_array = explode(",",$RecRespSuccessKey);
                                                    $failure_key_array = explode(",",$RecRespFailureKey);
                                                    $pending_key_array = explode(",",$RecRespPendingKey);
                                                    $failure_text_array = explode(",",$RecRespFailureText);
                                                    
                                                   
                                                    if($statusvalue != "")
                                                    {
                                                    	foreach($success_key_array as $success_key)
					                           			{
						                           			$statusvalue = trim($statusvalue);
						                           			$success_key = trim($success_key);
						                           			if($statusvalue == $success_key)
						                           			{
						                           				$status = 'Success';
		                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false,$lapubalance,0,false,$roffer);
		                                    					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);
								                                break;
						                           			}
						                           		}

                                                   
						                           		///check failure
						                           		foreach($failure_key_array as $failure_key)
						                           		{
						                           			$statusvalue = trim($statusvalue);
						                           			$failure_key = trim($failure_key);
						                           			if($statusvalue == $failure_key)
						                           			{
						                           				$status = 'Failure';
	                                                        $this->dofailure($recharge_id,$operator_id,$status,$Mobile,$Amount,$response_type,$rechargeBy,$company_id,$ApiInfo->row(0)->Id,$user_id,$order_id,$lapubalance,$allowed_retry);
								                                break;
						                           			}
						                           		}

						                           		///// check failurekeytet
						                           		foreach($failure_text_array as $failure_text)
									               		{
									               			if(strlen($failure_text) >= 6)
									               			{
									               				if (preg_match("/".$failure_text."/",$response)  == 1)
											               		{

										               				$status = 'Failure';
										                        	$this->dofailure($recharge_id,$failure_text,$status,$Mobile,$Amount,$response_type,$rechargeBy,$company_id,$ApiInfo->row(0)->Id,$user_id,$order_id,$lapubalance,$allowed_retry);
										                            break;
										               			
											               		}	
									               			}
									               		}
	                                                }
	                                                else
	                                                {
	                                                	$status = 'Pending';
                                                        $operator_id = "";
                                                        $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                    				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);  
	                                                } 
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);  
                                                }
                                            }
                                            else if($recharge_response_type == "CSV")
                                            {
                                                $obj = explode($response_separator,$response);
                                               
                                                if(isset($obj[$recharge_response_status_field]))
                                                {
                                                    $statusvalue = $obj[$recharge_response_status_field];
                                                    $operator_id = json_encode($obj[$recharge_response_opid_field]);
                                                    
                                                    $roffer = 0;
                                                    if(isset($obj[$recharge_response_otf_field]))
                                                    {
                                                        $roffer = $obj[$recharge_response_otf_field];   
                                                    }
                                                    
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
                                    					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);
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
                                    				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);  
                                                    }   
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id); 
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
                                                					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);
    															}	
    														}
    														else
    														{
    															$status = 'Pending';
    															$operator_id = "";
    															$order_id = "";
                                            					return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);
    														}
    													}
    													else
    													{
        													$status = 'Pending';
                                                            $operator_id = "";
                                                            $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                        				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id); 
    													}
    												}
                                                }
                                                else
                                                {
                                                    $status = 'Pending';
                                                    $operator_id = "";
                                                    $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                                				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id); 
                                                }     
                                            } 
									    }
									    else
									    {
									        $status = 'Pending';
                                            $operator_id = "";
                                            $this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status);  
                        				    return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);  
									    }
                                    }
									else
									{
									   $status = "Failure";
									   $operator_id = "";
									   $this->db->query("update tblrecharge set recharge_status = 'Failure' where recharge_id  = ?",array($recharge_id));
									   return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);  
									}

								}
								else
								{
								    $msg =  'Configuration Missing, Contact Service Provider';
								    return $msg;
								}

							}
							else
							{
								return "Internal Server Error 1";
							}
						}
						else
						{
							return "Commission Calculation Invalid. Please Contact Administrator";
						}
						
					//////////////////////////////////////////////////////////////////////////////////////////////////////////
					///////////////
					////////////////////////////////////////////////////////////////////////////////////////////////////////////	
					

//******************************************************************************************************************************//							
							
					}
					else
					{
					    $resp_status = "Failure";
					    $this->custom_response(0,$Mobile,$Amount,$resp_status,"System Error",$order_id,$response_type,$rechargeBy,$user_id);
					}
				}	
			else
			{
			    $resp_status = "Failure";
			    $this->custom_response(0,$Mobile,$Amount,$resp_status,"Invalid Amoun",$order_id,$response_type,$rechargeBy,$user_id);
			}
		}
		else
		{
			return 'Recharge Already In Pending Process';
		}
	}
	else
	{
		return "Retailer Does Not Belong To Any Group";
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
	public function custom_response($recharge_id,$mobile_no,$amount,$status,$message,$order_id,$response_type,$rechargeBy,$user_id)
	{
		
		if(strtoupper($response_type) == "CSV")
		{
			if($rechargeBy == "GPRS")
			{
				
				$resparray = array(
				"MESSAGEBOX_MESSAGETYPE"=>strtoupper($status),
				"MESSAGEBOX_MESSAGEBODY"=>$message
				);
				return $resparray;
			}
			else
			{
			    
				$response =  $status.",".$recharge_id.",".$order_id.",Number:".$mobile_no.",Amount:".$amount.",".$message.",,,";
				$this->loging($recharge_id,"DOWNLINE_RESPONSE",$response);
				echo $response;exit;
			}
			
		}
		if(strtoupper($response_type) == "XML")
		{
			echo '<RESPONSE>
			<STATUS>'.$status.'</STATUS>
			<TRID>'.$recharge_id.'</TRID>
			<CLIENTID>'.$order_id.'</CLIENTID>
			<MOBILE>'.$mobile_no.'</MOBILE>
			<AMOUNT>'.$amount.'</AMOUNT>
			<MESSAGE>'.$message.'</MESSAGE>
			</RESPONSE>';exit;
		}
		if(strtoupper($response_type) == "JSON")
		{
		    $resparray = array(
		                            "status"=>$status,
		                            "tid"=>$recharge_id,
		                            "order_id"=>$order_id,
		                            "mobile"=>$mobile_no,
		                            "amount"=>$amount,
		                            "operator_id"=>$message,
		                    );
		    echo json_encode($resparray);exit;
		}
		else
		{
			echo "Some Error Occured";exit;
		}
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
			if( (( strtotime($stime)  - strtotime($etime)) / 60) > (60 * 24))
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
	    
	

		if($operator_id == "InSufficient Balance" or $operator_id == "InSufficient Balance")
		{
			$operator_id = "System Error";
		}
		
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
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$rerootapirslt = $this->db->query("SELECT a.reroot_api_id FROM `operatorpendinglimit` a where a.api_id = ? and a.company_id = ? and a.reroot = 'yes'",array($api_id,$company_id));
		if($rerootapirslt->num_rows() == 1)
		{
			$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,true);
			return $this->custom_response($recharge_id,$Mobile,$Amount,"Pending",$operator_id,$order_id,$response_type,$rechargeBy,$user_id);
		}
		else
		{
			$this->Update_methods->updateRechargeStatus($recharge_id,$operator_id,$status,false,$lapubalance);
			return $this->custom_response($recharge_id,$Mobile,$Amount,$status,$operator_id,$order_id,$response_type,$rechargeBy,$user_id);
		}
	}
	private function loging($recharge_id,$actionfrom,$remark)
	{
		/* $add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$this->db->query("insert into tbllogs(recharge_id,add_date,ipaddress,actionfrom,remark) values(?,?,?,?,?)",
						array($recharge_id,$add_date,$ipaddress,$actionfrom,$remark));
						*/
	}
}
?>