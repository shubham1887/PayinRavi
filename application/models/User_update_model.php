<?php
class User_update_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
    public function tblusers_registration_Entry($Parent_id,$Dealername,$Address,$Pin,$State,$City,$contact_person,$MobNo,$Email,$Scheme_id,$aadhar_number,$pan_no,$gst_no,$downline_scheme,$downline_scheme2,$BDate,$service_array,$flatcomm,$flatcomm2,$user_id,$api_id,$api2_id)
	{
	    $host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
	    $landline = "";
	    $user_info = $this->Userinfo_methods->getUserInfo($user_id);
	    if($user_info->num_rows() == 1)
	    {
	       $usertype_name = $user_info->row(0)->usertype_name;
    	    if($usertype_name  == "Agent")
    	    {
    	        $parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ?",array(intval($Parent_id)));
        		if($parent_info->num_rows() ==1 )
        		{
        			if($parent_info->row(0)->usertype_name == "Distributor")
        			{
        				$groupinfo = $this->db->query("select * from tblgroup where Id = ? ",array($Scheme_id));
        				
        				if($groupinfo->num_rows() == 1)
        				{
        					if($groupinfo->row(0)->groupfor == "Agent")
        					{
        						if($user_info->row(0)->mobile_no != $MobNo)
        						{
        							$mobrslt = $this->db->query("select * from tblusers where mobile_no = ?",array($MobNo));
        							if($mobrslt->num_rows() > 0)
        							{
        								$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						
        							$usrrslt = $this->db->query("select * from tblusers where username = ?",array($MobNo));
        							if($usrrslt->num_rows() > 0)
        							{
            							$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        
        						if(true)
        						{
        						   
        							$rsltupdate = $this->db->query("update tblusers 
        								set 
        								username = ?,
        								businessname = ?,
        								parentid = ?,
        								state_id = ?,
        								city_id = ?,
        								mobile_no = ?,
        								scheme_id = ?,
        								flatcomm = ?,
        								flatcomm2 = ?,
        								api_id = ?,
        								api2_id = ?
        								where user_id = ?   
        
        							",array($MobNo,$Dealername,intval($Parent_id),$State,$City,$MobNo,intval($Scheme_id),$flatcomm,$flatcomm2,intval($api_id),intval($api2_id),intval($user_id)));	
        							if($rsltupdate == true)
        							{
        								$rsltupdate = $this->db->query("update tblusers_info 
        								set 
        								postal_address = ?,
        								pincode = ?,
        								aadhar_number = ?,
        								pan_no = ?,
        								gst_no = ?,
        								contact_person = ?,
        								landline = ?,
        								emailid = ?,
        								birthdate = ?
        								where user_id = ?
        
        							",array($Address,$Pin,$aadhar_number,$pan_no,$gst_no,$contact_person,$landline,$Email,$BDate,$user_id));	
        							
        							$this->addservice($user_id,$service_array);
        							
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'Retailer Account details updated successfully.'
                        		            );
                    		            return $resp_arr;
        								
        							}
        							else
        							{
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'Retailer Account details Partially updated successfully.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        					}
        					else
        					{
        						$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Group Selection"
            		            );
            		            return $resp_arr;
        					}
        					
        				}
        				else
        				{
        					$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Parent Selection"
        		            );
        		            return $resp_arr;
        				}
        				
        			}
        			else
        			{
        				$resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		        return $resp_arr;
        			}
        		}
        		else
        		{
        		    $resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		    return $resp_arr;
        		}   
    	    }
    	    else if($usertype_name  == "Distributor")
    	    {
    	        $parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ?",array(intval($Parent_id)));
        		if($parent_info->num_rows() ==1 )
        		{
        			if($parent_info->row(0)->usertype_name == "MasterDealer")
        			{
        				$groupinfo = $this->db->query("select * from tblgroup where Id = ? ",array($Scheme_id));
        				
        				if($groupinfo->num_rows() == 1)
        				{
        					if($groupinfo->row(0)->groupfor == "Distributor")
        					{
        						if($user_info->row(0)->mobile_no != $MobNo)
        						{
        							$mobrslt = $this->db->query("select * from tblusers where mobile_no = ?",array($MobNo));
        							if($mobrslt->num_rows() > 0)
        							{
        								$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						
        							$usrrslt = $this->db->query("select * from tblusers where username = ?",array($MobNo));
        							if($usrrslt->num_rows() > 0)
        							{
            							$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        
        						if(true)
        						{
        						   
        							$rsltupdate = $this->db->query("update tblusers 
        								set 
        								username = ?,
        								businessname = ?,
        								parentid = ?,
        								state_id = ?,
        								city_id = ?,
        								mobile_no = ?,
        								scheme_id = ?,
        								flatcomm = ?,
        								flatcomm2 = ?,
                                        downline_scheme = ?,
                                        downline_scheme2 = ?,
        								api_id = ?,
        								api2_id = ?
        								where user_id = ?   
        
        							",array($MobNo,$Dealername,intval($Parent_id),$State,$City,$MobNo,intval($Scheme_id),$flatcomm,$flatcomm2,intval($downline_scheme),intval($downline_scheme2),intval($api_id),intval($api2_id),intval($user_id)));	
        							if($rsltupdate == true)
        							{
        								$rsltupdate = $this->db->query("update tblusers_info 
        								set 
        								postal_address = ?,
        								pincode = ?,
        								aadhar_number = ?,
        								pan_no = ?,
        								gst_no = ?,
        								contact_person = ?,
        								landline = ?,
        								emailid = ?,
        								birthdate = ?
        								where user_id = ?
        
        							",array($Address,$Pin,$aadhar_number,$pan_no,$gst_no,$contact_person,$landline,$Email,$BDate,$user_id));	
        							
        							$this->addservice($user_id,$service_array);
        							
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'Distributor Account details updated successfully.'
                        		            );
                    		            return $resp_arr;
        								
        							}
        							else
        							{
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'Distributor Account details Partially updated successfully.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        					}
        					else
        					{
        						$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Group Selection"
            		            );
            		            return $resp_arr;
        					}
        					
        				}
        				else
        				{
        					$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Parent Selection"
        		            );
        		            return $resp_arr;
        				}
        				
        			}
        			else
        			{
        				$resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		        return $resp_arr;
        			}
        		}
        		else
        		{
        		    $resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		    return $resp_arr;
        		}   
    	    }
    	    else if($usertype_name  == "MasterDealer")
    	    {
    	        $parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ?",array(intval($Parent_id)));
        		if($parent_info->num_rows() ==1 )
        		{
        			if($parent_info->row(0)->usertype_name == "Admin")
        			{
        				$groupinfo = $this->db->query("select * from tblgroup where Id = ? ",array($Scheme_id));
        				
        				if($groupinfo->num_rows() == 1)
        				{
        					if($groupinfo->row(0)->groupfor == "MasterDealer")
        					{
        						if($user_info->row(0)->mobile_no != $MobNo)
        						{
        							$mobrslt = $this->db->query("select * from tblusers where mobile_no = ?",array($MobNo));
        							if($mobrslt->num_rows() > 0)
        							{
        								$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						
        							$usrrslt = $this->db->query("select * from tblusers where username = ?",array($MobNo));
        							if($usrrslt->num_rows() > 0)
        							{
            							$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        
        						if(true)
        						{
        						   
        							$rsltupdate = $this->db->query("update tblusers 
        								set 
        								username = ?,
        								businessname = ?,
        								parentid = ?,
        								state_id = ?,
        								city_id = ?,
        								mobile_no = ?,
        								scheme_id = ?,
        								flatcomm = ?,
        								flatcomm2 = ?,
        								api_id = ?,
        								api2_id = ?
        								where user_id = ?   
        
        							",array($MobNo,$Dealername,intval($Parent_id),$State,$City,$MobNo,intval($Scheme_id),$flatcomm,$flatcomm2,intval($api_id),intval($api2_id),intval($user_id)));	
        							if($rsltupdate == true)
        							{
        								$rsltupdate = $this->db->query("update tblusers_info 
        								set 
        								postal_address = ?,
        								pincode = ?,
        								aadhar_number = ?,
        								pan_no = ?,
        								gst_no = ?,
        								contact_person = ?,
        								landline = ?,
        								emailid = ?,
        								birthdate = ?
        								where user_id = ?
        
        							",array($Address,$Pin,$aadhar_number,$pan_no,$gst_no,$contact_person,$landline,$Email,$BDate,$user_id));	
        							
        							$this->addservice($user_id,$service_array);
        							
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'Md Account details updated successfully.'
                        		            );
                    		            return $resp_arr;
        								
        							}
        							else
        							{
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'Md Account details Partially updated successfully.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        					}
        					else
        					{
        						$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Group Selection"
            		            );
            		            return $resp_arr;
        					}
        					
        				}
        				else
        				{
        					$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Parent Selection"
        		            );
        		            return $resp_arr;
        				}
        				
        			}
        			else
        			{
        				$resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		        return $resp_arr;
        			}
        		}
        		else
        		{
        		    $resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		    return $resp_arr;
        		}   
    	    }
    	    else if($usertype_name  == "APIUSER")
    	    {
                $Parent_id =1;
    	        $parent_info = $this->db->query("select user_id,businessname,usertype_name,status from tblusers where user_id = ?",array(intval($Parent_id)));
        		if($parent_info->num_rows() ==1 )
        		{
        			if($parent_info->row(0)->usertype_name == "Admin")
        			{
        				$groupinfo = $this->db->query("select * from tblgroup where Id = ? ",array($Scheme_id));
        				
        				if($groupinfo->num_rows() == 1)
        				{
        					if($groupinfo->row(0)->groupfor == "APIUSER")
        					{
        						if($user_info->row(0)->mobile_no != $MobNo)
        						{
        							$mobrslt = $this->db->query("select * from tblusers where mobile_no = ?",array($MobNo));
        							if($mobrslt->num_rows() > 0)
        							{
        								$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						
        							$usrrslt = $this->db->query("select * from tblusers where username = ?",array($MobNo));
        							if($usrrslt->num_rows() > 0)
        							{
            							$resp_arr = array(
                        		            "status"=>1,
                        		            "message"=>'Mobile Number Already Exist, Please Enter Another Mobile Number.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        
        						if(true)
        						{
        						   
        							$rsltupdate = $this->db->query("update tblusers 
        								set 
        								username = ?,
        								businessname = ?,
        								parentid = ?,
        								state_id = ?,
        								city_id = ?,
        								mobile_no = ?,
        								scheme_id = ?,
        								flatcomm = ?,
        								flatcomm2 = ?,
        								api_id = ?,
        								api2_id = ?
        								where user_id = ?   
        
        							",array($MobNo,$Dealername,intval($Parent_id),$State,$City,$MobNo,intval($Scheme_id),$flatcomm,$flatcomm2,intval($api_id),intval($api2_id),intval($user_id)));	
        							if($rsltupdate == true)
        							{
        								$rsltupdate = $this->db->query("update tblusers_info 
        								set 
        								postal_address = ?,
        								pincode = ?,
        								aadhar_number = ?,
        								pan_no = ?,
        								gst_no = ?,
        								contact_person = ?,
        								landline = ?,
        								emailid = ?,
        								birthdate = ?
        								where user_id = ?
        
        							",array($Address,$Pin,$aadhar_number,$pan_no,$gst_no,$contact_person,$landline,$Email,$BDate,$user_id));	
        							
        							$this->addservice($user_id,$service_array);
        							
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'API Account details updated successfully.'
                        		            );
                    		            return $resp_arr;
        								
        							}
        							else
        							{
        								$resp_arr = array(
                        		            "status"=>0,
                        		            "message"=>'API Account details Partially updated successfully.'
                        		            );
                    		            return $resp_arr;
        							}
        						}
        					}
        					else
        					{
        						$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Group Selection"
            		            );
            		            return $resp_arr;
        					}
        					
        				}
        				else
        				{
        					$resp_arr = array(
            		            "status"=>1,
            		            "message"=>"Invalid Parent Selection"
        		            );
        		            return $resp_arr;
        				}
        				
        			}
        			else
        			{
        				$resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		        return $resp_arr;
        			}
        		}
        		else
        		{
        		    $resp_arr = array(
        		            "status"=>1,
        		            "message"=>"Invalid Parent Selection"
        		        );
        		    return $resp_arr;
        		}   
    	    }
	    }
	    
	}
	
	public function addservice($user_id,$service_array)
	{
	    $curretn_ser = array();
	    $check_service = $this->db->query("select a.status,a.service_id,b.service_name from active_services a left join tblservice b on a.service_id = b.service_id where a.user_id = ?",array($user_id));
	    if($check_service->num_rows() > 0)
	    {
	        foreach($check_service->result() as $rwoldser)
	        {
	            $curretn_ser[$rwoldser->service_name] =   $rwoldser->status;  
	        }
	    }
	    
	    $this->load->model("Service_model");
	    $service_rslt = $this->Service_model->getServices();
	    foreach($service_rslt->result() as $ser)
	    {
	       if(isset($service_array[$ser->service_name]))
	       {
	           $status = $service_array[$ser->service_name];
	           if(isset($curretn_ser[$ser->service_name]))
	           {
	               $this->db->query("update active_services set status = ?,last_change_date = ? where user_id = ? and service_id = ? ",array($status,$this->common->getDate(),$user_id,$ser->service_id));
	           }
	           else
	           {
	               $this->db->query("insert into active_services(service_id,user_id,status,add_date,ipaddress) values(?,?,?,?,?)",
	               array($ser->service_id,$user_id,$status,$this->common->getDate(),$this->common->getRealIpAddr()));
	           }
	       }
	    }
	}
}

?>