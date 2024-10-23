<?php
class Insert_model extends CI_Model 
{	
	function _construct()
	{
		  // Call the Model constructor
		  parent::_construct();
	}
	public function tblewallet_Payment_CrDrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$is_revert = false,$payment_received = 0,$acc_parent_id = 0,$acc_child_id = 0)
	{	
		
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "PAYMENT";
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		$str_query = "insert into  tblpayment(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type, 	payment_date,payment_time)
		values(?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type,$payment_date,$payment_time));
		$payment_id = $this->db->insert_id();
		if($payment_id > 1)
		{
		    
		    
		    $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		    $this->db->query("BEGIN;");
			$credit_amount = $amount;
			$debit_amount = $amount;
			$old_balance_debit_user_id = $this->Common_methods->getCurrentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,admin_remark)
			values(?,?,?,?,?,?,?,?,?,?,?)";
			$reslut = $this->db->query($str_query,array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$admin_remark));
			if($reslut == true)
			{
				
				$old_balance_credit_user_id = $this->Common_methods->getCurrentBalance($credit_user_id);
				$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;
				$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,admin_remark)
				values(?,?,?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$admin_remark));
				$this->db->query("COMMIT;");

				$this->load->model("Credit_master");
				
				$acc_credit_amount = $credit_amount;
				$creditrevert = 0;
				if($is_revert == true)
				{
					$acc_credit_amount = 0;
					$creditrevert = $credit_amount;
				}

				if($acc_parent_id  > 0 and $acc_child_id > 0)
				{
					$this->Credit_master->credit_entry($acc_parent_id,$acc_child_id,$acc_credit_amount,$creditrevert,$payment_received,$remark,$add_date,$payment_type);	
				}
				

				return true;
			}
			else
			{
			    $this->db->query("ROLLBACK;");
			}
		}
	}
		public function tblewallet_Payment_Cr_Commission($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$is_revert = false,$payment_received = 0,$acc_parent_id = 0,$acc_child_id = 0)
	{	
		
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "COMMISSION";
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		$str_query = "insert into  tblpayment(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type, 	payment_date,payment_time)
		values(?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type,$payment_date,$payment_time));
		$payment_id = $this->db->insert_id();
		if($payment_id > 1)
		{
		    
		    
		    $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		    $this->db->query("BEGIN;");
			$credit_amount = $amount;
			$debit_amount = $amount;
			$old_balance_debit_user_id = $this->Common_methods->getCurrentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,admin_remark)
			values(?,?,?,?,?,?,?,?,?,?,?)";
			$reslut = $this->db->query($str_query,array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$admin_remark));
			if($reslut == true)
			{
				
				$old_balance_credit_user_id = $this->Common_methods->getCurrentBalance($credit_user_id);
				$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;
				$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,admin_remark)
				values(?,?,?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($credit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$admin_remark));
				$this->db->query("COMMIT;");

				$this->load->model("Credit_master");
				
				$acc_credit_amount = $credit_amount;
				$creditrevert = 0;
				if($is_revert == true)
				{
					$acc_credit_amount = 0;
					$creditrevert = $credit_amount;
				}

				if($acc_parent_id  > 0 and $acc_child_id > 0)
				{
					$this->Credit_master->credit_entry($acc_parent_id,$acc_child_id,$acc_credit_amount,$creditrevert,$payment_received,$remark,$add_date,$payment_type);	
				}
				

				return true;
			}
			else
			{
			    $this->db->query("ROLLBACK;");
			}
		}
	}
		public function tblewallet_Payment_CrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$is_revert = false,$payment_received = 0,$acc_parent_id = 0,$acc_child_id = 0)
	{	
		
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
				$transaction_type = "DEBIT";

		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		$str_query = "insert into  tblpayment(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type, 	payment_date,payment_time)
		values(?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type,$payment_date,$payment_time));
		$payment_id = $this->db->insert_id();
		if($payment_id > 1)
		{
		    
		    
		    $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		    $this->db->query("BEGIN;");
			$credit_amount = $amount;
			$debit_amount = $amount;
			$old_balance_debit_user_id = $this->Common_methods->getCurrentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,admin_remark)
			values(?,?,?,?,?,?,?,?,?,?,?)";
			$reslut = $this->db->query($str_query,array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$admin_remark));
			if($reslut == true)
			{
		$transaction_type1 = "CRADIT";
				
				$old_balance_credit_user_id = $this->Common_methods->getCurrentBalance($credit_user_id);
				$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;
				$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,admin_remark)
				values(?,?,?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($credit_user_id,$payment_id,$transaction_type1,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$admin_remark));
				$this->db->query("COMMIT;");

				$this->load->model("Credit_master");
				
				$acc_credit_amount = $credit_amount;
				$creditrevert = 0;
				if($is_revert == true)
				{
					$acc_credit_amount = 0;
					$creditrevert = $credit_amount;
				}

				if($acc_parent_id  > 0 and $acc_child_id > 0)
				{
					$this->Credit_master->credit_entry($acc_parent_id,$acc_child_id,$acc_credit_amount,$creditrevert,$payment_received,$remark,$add_date,$payment_type);	
				}
				

				return true;
			}
			else
			{
			    $this->db->query("ROLLBACK;");
			}
		}
	}
	public function tblewallet_Payment_DrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark = "",$is_revert = false,$payment_received = 0,$acc_parent_id = 0,$acc_child_id = 0)
	{	
		
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$date = $this->common->getMySqlDate();
		$transaction_type = "DEBIT";
		$payment_master_id =  0;
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		$str_query = "insert into  tblpayment(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type, 	payment_date,payment_time)
		values(?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($payment_master_id,$credit_user_id,$amount,$payment_type,$debit_user_id,$remark,$add_date,$ipaddress,$transaction_type,$payment_date,$payment_time));
		$payment_id = $this->db->insert_id();
		if($payment_id > 1)
		{
		    
		    
		    $this->db->query("SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		    $this->db->query("BEGIN;");
			$credit_amount = $amount;
			$debit_amount = $amount;
			$old_balance_debit_user_id = $this->Common_methods->getCurrentBalance($debit_user_id);
			$current_balance_debit_user_id = $old_balance_debit_user_id - $credit_amount;
			$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,debit_amount,balance,ipaddress,payment_type,admin_remark)
			values(?,?,?,?,?,?,?,?,?,?,?)";
			$reslut = $this->db->query($str_query,array($debit_user_id,$payment_id,$transaction_type,$remark,$description,$add_date,$credit_amount,$current_balance_debit_user_id,$ipaddress,$payment_type,$admin_remark));
			if($reslut == true)
			{
				$transaction_type1 = "CRADIT";
				
				$old_balance_credit_user_id = $this->Common_methods->getCurrentBalance($credit_user_id);
				$current_balance_credit_user_id = $old_balance_credit_user_id + $credit_amount;
				$str_query = "insert into  tblewallet(user_id,payment_id,transaction_type,remark,description,add_date,credit_amount,balance,ipaddress,payment_type,admin_remark)
				values(?,?,?,?,?,?,?,?,?,?,?)";
				$reslut = $this->db->query($str_query,array($credit_user_id,$payment_id,$transaction_type1,$remark,$description,$add_date,$credit_amount,$current_balance_credit_user_id,$ipaddress,$payment_type,$admin_remark));
				$this->db->query("COMMIT;");

				$this->load->model("Credit_master");
				
				$acc_credit_amount = $credit_amount;
				$creditrevert = 0;
				if($is_revert == true)
				{
					$acc_credit_amount = 0;
					$creditrevert = $credit_amount;
				}

				if($acc_parent_id  > 0 and $acc_child_id > 0)
				{
					$this->Credit_master->credit_entry($acc_parent_id,$acc_child_id,$acc_credit_amount,$creditrevert,$payment_received,$remark,$add_date,$payment_type);	
				}
				

				return true;
			}
			else
			{
			    $this->db->query("ROLLBACK;");
			}
		}
	}
	public function tblewallet_Recharge_CrDrEntry($user_id,$recharge_id,$transaction_type,$cr_amount,$dr_amount,$Description)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$old_balance = $this->Common_methods->getCurrentBalance($user_id);
		$current_balance = $old_balance + $cr_amount;
		
		$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,credit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$cr_amount,$current_balance,$Description,$add_date));
	}
	public function tblewallet_Recharge_CrEntry($user_id,$recharge_id,$transaction_type,$cr_amount,$Description)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();
		$old_balance = $this->Common_methods->getCurrentBalance($user_id);
		$current_balance = $old_balance + $cr_amount;
		
		$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,credit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$cr_amount,$current_balance,$Description,$add_date));
		$this->load->model("Sms");
		$ewallet_id = $this->db->insert_id();
		//$this->Sms->sendRefundRechargeSMS($current_balance,$old_balance,$cr_amount,$user_id,$recharge_id);
		return $ewallet_id;
	}
	
	
	//////////////////////////////////////////////
	////////////////////////////Debit Recharge Amount From ewallet
	////////////////////////////////////////////
	public function tblewallet_Recharge_DrEntry($user_id,$recharge_id,$transaction_type,$dr_amount,$Description)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();

		$old_balance = $this->Common_methods->getCurrentBalance($user_id);
		$current_balance = $old_balance - $dr_amount;
		
		$str_query = "insert into  tblewallet(user_id,recharge_id,transaction_type,debit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$recharge_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date));
		$ewallet_id = $this->db->insert_id();
		$rslt_updtrec = $this->db->query("update tblrecharge set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?) where recharge_id = ?",array($current_balance,$ewallet_id,$recharge_id));
		return $ewallet_id;
	}
	public function tblpayment_Payment_CrDrEntry($payment_master_id,$cr_user_id,$amount,$payment_type,$dr_user_id,$remark,$transaction_type)
	{	
		$this->load->library("common");
		$this->load->model("common_methods");
		$add_date = $this->common->getDate();
		$payment_date = $this->common->getMySqlDate();
		$payment_time = $this->common->getMySqlTime();	
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into  tblpayment(payment_master_id,cr_user_id,amount,payment_type,dr_user_id,remark,add_date,ipaddress,transaction_type, 	payment_date,payment_time)
		values(?,?,?,?,?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($payment_master_id,$cr_user_id,$amount,$payment_type,$dr_user_id,$remark,$add_date,$ipaddress,$transaction_type,$payment_date,$payment_time));
		
		return $this->db->insert_id();
	}
	
	public function getChildCount($user_id)
	{
		$rslt = $this->db->query("select count(user_id) as total from tblusers where parentid = ?",array($user_id));
		if($rslt->num_rows() == 1)
		{
			return $rslt->row(0)->total;
		}
		return 0;
	}
	public function tblusers_registration_Entry($parentid,$distributer_name,$postal_address,$pincode,$state_id,$city_id,$contact_person,$mobile_no,$emailid,$usertype_name,$status,$scheme_id,$username,$password,$aadhar,$pan,$gst,$downline_scheme,$downline_scheme2,$BDate,$service_array,$FirstName = "",$MiddleName = "",$LastName = "")
	{
	    // var_dump($downline_scheme);exit;
	    
	     // error_reporting(-1);
    	 //    ini_set('display_errors',1);
    	 //    $this->db->db_debug = TRUE;
	//    echo "state id ".$state_id."    ".$city_id;exit;
		/*if(true)
		{
			$resparr = array(
							"message"=>"User Registration Service Will Start In 24 Hours",
							"status"=>1
							);
			return json_encode($resparr);
		}*/
	   $host_id = $this->Common_methods->getHostId($this->white->getDomainName());	
		if(strlen($username) <= 5)
		{
			$resparr = array(
							"message"=>"Minimum 6 Character  Required For UserId",
							"status"=>1
							);
			return json_encode($resparr);
		}
		
		$checkuserexist = $this->db->query("select user_id from tblusers where mobile_no = ? and host_id = ?",array($mobile_no,$host_id));
		if($checkuserexist->num_rows() == 1)
		{
			$resparr = array(
								"message"=>"Mobile Number Already Exist",
								"status"=>1
								);
								return json_encode($resparr);
		}
		$checkuserexist2 = $this->db->query("select user_id from tblusers where username = ? and host_id = ?",array($username,$host_id));
		if($checkuserexist2->num_rows() == 1)
		{
			$resparr = array(
								"message"=>"UserId Already Exist",
								"status"=>1
								);
								return json_encode($resparr);
		}
		
		else
		{
		 
			$add_date = $this->common->getDate();
			$ipaddress = $this->common->getRealIpAddr();
			$password = $this->common->GetPassword();
			if($usertype_name == "Agent")
			{
			    $fos_id = 0;
				$parentinfo = $this->db->query("select user_id,parentid,usertype_name,mobile_no,status,businessname,downline_scheme,downline_scheme2,id_limit from tblusers where user_id = ? and host_id = ?",array(intval($parentid),intval($host_id)));
			
				if($parentinfo->num_rows() == 1)
				{
					
					$id_limit = $parentinfo->row(0)->id_limit;
					$childcount = $this->getChildCount(intval($parentid));
					
					
					
					
					$parent_type = $parentinfo->row(0)->usertype_name;
					$parent_mobile_no = $parentinfo->row(0)->mobile_no;
					$parent_status = $parentinfo->row(0)->status;
					$parent_user_id = $parentinfo->row(0)->user_id;
					$parent_downline_scheme = $parentinfo->row(0)->downline_scheme;
					$parent_downline_scheme2 = $parentinfo->row(0)->downline_scheme2;
					
					
					$downline_sheme_info = $this->db->query("select * from tblgroup where Id = ?",array($parent_downline_scheme));
					//if($downline_sheme_info->num_rows() == 1)
					if($id_limit > $childcount)
					{
						//$downline_groupfor = $downline_sheme_info->row(0)->groupfor;
						//if($downline_groupfor == "Agent")
						if(true)
						{
							if($parent_type == "Distributor")
							{
								if($parent_status == '1')
								{

										$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,fos_id,host_id,FirstName,MiddleName,LastName) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
										$rlst = $this->db->query($str_query,array($parentid,$distributer_name,
										$state_id,$city_id,$mobile_no,$usertype_name,
										$add_date,$ipaddress,"1",$scheme_id,$username,$password,$password,$fos_id,$host_id,$FirstName,$MiddleName,$LastName));		
										$reg_id = $this->db->insert_id();
										if($reg_id > 1)
										{
											$insertinfo = $this->db->query("insert into tblusers_info(user_id,add_date,ipaddress,postal_address,pincode,aadhar_number,pan_no,gst_no,emailid,birthdate) 
											values(?,?,?,?,?,?,?,?,?,?)",
											array($reg_id,$this->common->getDate(),$this->common->getRealIpAddr(),$postal_address,$pincode,$aadhar,$pan,$gst,$emailid,$BDate));


                                            $this->addservice($reg_id,$service_array);

											$this->load->model("Sms");
											$this->Sms->registration($password,$mobile_no,$password,$emailid,$distributer_name);	
											$resparr = array(
											"message"=>"Account Registration Successful",
											"status"=>0,
											"user_id"=>$reg_id,
											"user_type"=>$usertype_name
											);
											return json_encode($resparr);
											return $reg_id;
										}
										else
										{
											$resparr = array(
											"message"=>"Some Error Occured, Try again later..",
											"status"=>1
											);
											return json_encode($resparr);
										}

								}
								else
								{
									$resparr = array(
										"message"=>"Your Account Is Deactivated By Administrator",
										"status"=>1
									);
									return json_encode($resparr);
								}
							}
							else
							{
								$resparr = array(
										"message"=>"Invalid Operation Performed",
										"status"=>1
									);
									return json_encode($resparr);
							}
						}
						else
						{
							$resparr = array(
										"message"=>"Commission Group Not Selected For Download",
										"status"=>1
									);
								return json_encode($resparr);
							
						}
					}
					else
					{
						$resparr = array(
										"message"=>"Your Id Limit Over.Contact Administrator",
										"status"=>1
									);
						return json_encode($resparr);
					}
					
					
					
					

				}

			}
			if($usertype_name == "FOS")
			{
			    
				$parentinfo = $this->db->query("select user_id,usertype_name,mobile_no,status,businessname,downline_scheme,downline_scheme2 from tblusers where user_id = ? and host_id = ?",array(intval($parentid),intval($host_id)));
			
				if($parentinfo->num_rows() == 1)
				{
					$parent_type = $parentinfo->row(0)->usertype_name;
					$parent_mobile_no = $parentinfo->row(0)->mobile_no;
					$parent_status = $parentinfo->row(0)->status;
					$parent_user_id = $parentinfo->row(0)->user_id;
					$parent_downline_scheme = $parentinfo->row(0)->downline_scheme;
					$parent_downline_scheme2 = $parentinfo->row(0)->downline_scheme2;
					$parent_downline_fos = "";
					if($parent_type == "Distributor")
					{
						if($parent_status == '1')
						{
						    
								$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,host_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
								$rlst = $this->db->query($str_query,array($parentid,$distributer_name,
								$state_id,$city_id,$mobile_no,$usertype_name,
								$add_date,$ipaddress,"1",26,$username,$password,$password,$host_id));		
								$reg_id = $this->db->insert_id();
								if($reg_id > 1)
								{
									$insertinfo = $this->db->query("insert into tblusers_info(user_id,add_date,ipaddress,postal_address,pincode,aadhar_number,pan_no,gst_no,emailid,birthdate) 
									values(?,?,?,?,?,?,?,?,?,?)",
									array($reg_id,$this->common->getDate(),$this->common->getRealIpAddr(),$postal_address,$pincode,$aadhar,$pan,$gst,$emailid,$BDate));
									
									
									$this->addservice($reg_id,$service_array);
									
									$this->load->model("Sms");
									$this->Sms->registration($password,$mobile_no,$password,$emailid,$distributer_name);	
									
									$resparr = array(
									"message"=>"Account Registration Successful",
									"status"=>0,
									"user_id"=>$reg_id,
									"user_type"=>$usertype_name
									);
									return json_encode($resparr);
									return $reg_id;
								}
								else
								{
									$resparr = array(
									"message"=>"Some Error Occured, Try again later..",
									"status"=>1
									);
									return json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
								"message"=>"Your Account Is Deactivated By Administrator",
								"status"=>1
							);
							return json_encode($resparr);
						}
					}
					else
					{
						$resparr = array(
								"message"=>"Invalid Operation Performed",
								"status"=>1
							);
							return json_encode($resparr);
					}

				}

			}
			else if($usertype_name == "Distributor")
			{
				$parentinfo = $this->db->query("select user_id,usertype_name,mobile_no,status,businessname,downline_scheme,downline_scheme2 from tblusers where user_id = ? and host_id = ?",array(intval($parentid),intval($host_id)));
				if($parentinfo->num_rows() == 1)
				{
					$parent_type = $parentinfo->row(0)->usertype_name;
					$parent_mobile_no = $parentinfo->row(0)->mobile_no;
					$parent_status = $parentinfo->row(0)->status;
					$parent_user_id = $parentinfo->row(0)->user_id;
					$parent_businessname = $parentinfo->row(0)->businessname;
					$downline_scheme = $parentinfo->row(0)->downline_scheme;
					$downline_scheme2 = $parentinfo->row(0)->downline_scheme2;
					
					if($parent_type == "MasterDealer")
					{
						if($parent_status == '1')
						{
								$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,downline_scheme,downline_scheme2,host_id,FirstName,MiddleName,LastName) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
								$rlst = $this->db->query($str_query,array($parentid,$distributer_name,
								$state_id,$city_id,$mobile_no,$usertype_name,
								$add_date,$ipaddress,"1",52,$username,$password,$password,$downline_scheme2,0,$host_id,$FirstName,$MiddleName,$LastName));		
								$reg_id = $this->db->insert_id();
								if($reg_id > 1)
								{
									$insertinfo = $this->db->query("insert into tblusers_info(user_id,add_date,ipaddress,postal_address,pincode,aadhar_number,pan_no,gst_no,emailid,birthdate) 
									values(?,?,?,?,?,?,?,?,?,?)",
									array($reg_id,$this->common->getDate(),$this->common->getRealIpAddr(),$postal_address,$pincode,$aadhar,$pan,$gst,$emailid,$BDate));
									//$this->setCommission($reg_id,$scheme_id,$usertype_name);
									
									$this->addservice($reg_id,$service_array);
									
									$this->load->model("Sms");
									$this->Sms->registration($password,$mobile_no,$password,$emailid,$distributer_name);	
									$resparr = array(
									"message"=>"Account Registration Successful",
									"status"=>0,
									"user_id"=>$reg_id,
									"user_type"=>$usertype_name
									);
									return json_encode($resparr);
									return $reg_id;
								}
								else
								{
									$resparr = array(
									"message"=>"Some Error Occured, Try again later..",
									"status"=>1
									);
									return json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
								"message"=>"Your Account Is Deactivated By Administrator",
								"status"=>1
							);
							return json_encode($resparr);
						}
					}
					else
					{
						$resparr = array(
								"message"=>"Invalid Operation Performed",
								"status"=>1
							);
							return json_encode($resparr);
					}

				}

			}
			else if($usertype_name == "MasterDealer")
			{
			  
				$parentinfo = $this->db->query("select user_id,usertype_name,mobile_no,status,businessname from tblusers where user_id = ? and host_id = ?",array(intval($parentid),intval($host_id)));
			    if($parentinfo->num_rows() == 1)
				{
					$parent_type = $parentinfo->row(0)->usertype_name;
					$parent_mobile_no = $parentinfo->row(0)->mobile_no;
					$parent_status = $parentinfo->row(0)->status;
					$parent_user_id = $parentinfo->row(0)->user_id;
					$parent_businessname = $parentinfo->row(0)->businessname;
					if($parent_type == "Admin" or $parent_type == "SuperDealer")
					{
						if($parent_status == '1')
						{
								$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,downline_scheme,downline_scheme2,host_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
								$rlst = $this->db->query($str_query,array($parentid,$distributer_name,
								$state_id,$city_id,$mobile_no,$usertype_name,
								$add_date,$ipaddress,"1",$scheme_id,$username,$password,$password,$downline_scheme,$downline_scheme2,$host_id));		
								$reg_id = $this->db->insert_id();
								if($reg_id > 1)
								{
									$insertinfo = $this->db->query("insert into tblusers_info(user_id,add_date,ipaddress,postal_address,pincode,aadhar_number,pan_no,gst_no,emailid,birthdate) 
									values(?,?,?,?,?,?,?,?,?,?)",
									array($reg_id,$this->common->getDate(),$this->common->getRealIpAddr(),$postal_address,$pincode,$aadhar,$pan,$gst,$emailid,$BDate));
									//$this->setCommission($reg_id,$scheme_id,$usertype_name);
									
									$this->addservice($reg_id,$service_array);
									
									$this->load->model("Sms");
									$this->Sms->registration($password,$mobile_no,$password,$emailid,$distributer_name);	
									$resparr = array(
									"message"=>"Account Registration Successful",
									"status"=>0,
									"user_id"=>$reg_id,
									"user_type"=>$usertype_name
									);
									return json_encode($resparr);
									return $reg_id;
								}
								else
								{
									$resparr = array(
									"message"=>"Some Error Occured, Try again later..",
									"status"=>1
									);
									return json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
								"message"=>"Your Account Is Deactivated By Administrator",
								"status"=>1
							);
							return json_encode($resparr);
						}
					}
					else
					{
						$resparr = array(
								"message"=>"Invalid Operation Performed",
								"status"=>1
							);
							return json_encode($resparr);exit;
					}

				}

			}
			else if($usertype_name == "SuperDealer")
			{
				$host_id = 1;
				$parentinfo = $this->db->query("select user_id,usertype_name,mobile_no,status,businessname from tblusers where user_id = ? and host_id = ?",array(intval($parentid),intval($host_id)));
				//print_r($parentinfo->result());exit;
				if($parentinfo->num_rows() == 1)
				{
					$parent_type = $parentinfo->row(0)->usertype_name;
					$parent_mobile_no = $parentinfo->row(0)->mobile_no;
					$parent_status = $parentinfo->row(0)->status;
					$parent_user_id = $parentinfo->row(0)->user_id;
					$parent_businessname = $parentinfo->row(0)->businessname;
					if($parent_type == "Admin")
					{
						if($parent_status == '1')
						{
						
								$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,downline_scheme,downline_scheme2,host_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
								$rlst = $this->db->query($str_query,array($parentid,$distributer_name,
								$state_id,$city_id,$mobile_no,$usertype_name,
								$add_date,$ipaddress,"1",27,$username,$password,$password,$downline_scheme,$downline_scheme2,$host_id));		
								$reg_id = $this->db->insert_id();
								if($reg_id > 1)
								{
									//$this->db->query("insert into tblhost(Id,host_name,add_date,ipaddress) values(?,?,?,?)",array($reg_id,$DomainName,$this->common->getDate(),$this->common->getRealIpAddr()));
									
									$this->db->query("update tblusers set host_id = ? where user_id = ?",array($reg_id,$reg_id));
									
									$insertinfo = $this->db->query("insert into tblusers_info(user_id,add_date,ipaddress,postal_address,pincode,aadhar_number,pan_no,gst_no,emailid,birthdate) 
									values(?,?,?,?,?,?,?,?,?,?)",
									array($reg_id,$this->common->getDate(),$this->common->getRealIpAddr(),$postal_address,$pincode,$aadhar,$pan,$gst,$emailid,$BDate));
									//$this->setCommission($reg_id,$scheme_id,$usertype_name);
									
									$this->addservice($reg_id,$service_array);
									
									$this->load->model("Sms");
									$this->Sms->registration($username,$password,$mobile_no,$emailid,$distributer_name);	
									$resparr = array(
									"message"=>"Account Registration Successful",
									"status"=>0,
									"user_id"=>$reg_id,
									"user_type"=>$usertype_name
									);
									return json_encode($resparr);
									return $reg_id;
								}
								else
								{
									$resparr = array(
									"message"=>"Some Error Occured, Try again later..",
									"status"=>1
									);
									return json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
								"message"=>"Your Account Is Deactivated By Administrator",
								"status"=>1
							);
							return json_encode($resparr);
						}
					}
					else
					{
						$resparr = array(
								"message"=>"Invalid Operation Performed",
								"status"=>1
							);
							return json_encode($resparr);exit;
					}

				}

			}
			else if($usertype_name == "APIUSER")
			{
				$parentinfo = $this->db->query("select user_id,usertype_name,mobile_no,status,businessname from tblusers where user_id = ? and host_id = ?",array(intval($parentid),intval($host_id)));
				if($parentinfo->num_rows() == 1)
				{
					$parent_type = $parentinfo->row(0)->usertype_name;
					$parent_mobile_no = $parentinfo->row(0)->mobile_no;
					$parent_status = $parentinfo->row(0)->status;
					$parent_user_id = $parentinfo->row(0)->user_id;
					$parent_businessname = $parentinfo->row(0)->businessname;
					if($parent_type == "Admin")
					{
						if($parent_status == '1')
						{
						    
						   
								$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,downline_scheme,downline_scheme2,host_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
								$rlst = $this->db->query($str_query,array($parentid,$distributer_name,
								$state_id,$city_id,$mobile_no,$usertype_name,
								$add_date,$ipaddress,"1",$scheme_id,$username,$password,$password,$downline_scheme,$downline_scheme2,$host_id));		
								$reg_id = $this->db->insert_id();
								if($reg_id > 1)
								{
									$insertinfo = $this->db->query("insert into tblusers_info(user_id,add_date,ipaddress,postal_address,pincode,aadhar_number,pan_no,gst_no,emailid) values(?,?,?,?,?,?,?,?,?)",array($reg_id,$this->common->getDate(),$this->common->getRealIpAddr(),$postal_address,$pincode,$aadhar,$pan,$gst,$emailid));
									//$this->setCommission($reg_id,$scheme_id,$usertype_name);
									
									$this->addservice($reg_id,$service_array);
									
									$this->load->model("Sms");
									$this->Sms->registration($password,$mobile_no,$password,$emailid,$distributer_name);	
									$resparr = array(
									"message"=>"Account Registration Successful",
									"status"=>0,
									"user_id"=>$reg_id,
									"user_type"=>$usertype_name
									);
									return json_encode($resparr);
									return $reg_id;
								}
								else
								{
									$resparr = array(
									"message"=>"Some Error Occured, Try again later..",
									"status"=>1
									);
									return json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
								"message"=>"Your Account Is Deactivated By Administrator",
								"status"=>1
							);
							return json_encode($resparr);
						}
					}
					else
					{
						$resparr = array(
								"message"=>"Invalid Operation Performed",
								"status"=>1
							);
							echo json_encode($resparr);exit;
					}

				}

			}
			else if($usertype_name == "WEBSITE")
			{
				$host_id = 1;
				$parentinfo = $this->db->query("select user_id,usertype_name,mobile_no,status,businessname from tblusers where user_id = ? and host_id = ?",array(intval($parentid),intval($host_id)));
				//print_r($parentinfo->result());exit;
				if($parentinfo->num_rows() == 1)
				{
					$parent_type = $parentinfo->row(0)->usertype_name;
					$parent_mobile_no = $parentinfo->row(0)->mobile_no;
					$parent_status = $parentinfo->row(0)->status;
					$parent_user_id = $parentinfo->row(0)->user_id;
					$parent_businessname = $parentinfo->row(0)->businessname;
					if($parent_type == "Admin")
					{
						if($parent_status == '1')
						{
						
								$str_query = "insert into  tblusers(parentid,businessname,state_id,city_id,mobile_no,usertype_name,add_date,ipaddress,status,scheme_id,username,password,txn_password,downline_scheme,downline_scheme2,host_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
								$rlst = $this->db->query($str_query,array($parentid,$distributer_name,
								$state_id,$city_id,$mobile_no,$usertype_name,
								$add_date,$ipaddress,"1",27,$username,$password,$password,$downline_scheme,$downline_scheme2,$host_id));		
								$reg_id = $this->db->insert_id();
								if($reg_id > 1)
								{
									
									
									$insertinfo = $this->db->query("insert into tblusers_info(user_id,add_date,ipaddress,postal_address,pincode,aadhar_number,pan_no,gst_no,emailid,birthdate) 
									values(?,?,?,?,?,?,?,?,?,?)",
									array($reg_id,$this->common->getDate(),$this->common->getRealIpAddr(),$postal_address,$pincode,$aadhar,$pan,$gst,$emailid,$BDate));
									
									$resparr = array(
									"message"=>"Account Registration Successful",
									"status"=>0,
									"user_id"=>$reg_id,
									"user_type"=>$usertype_name
									);
									return json_encode($resparr);
									return $reg_id;
								}
								else
								{
									$resparr = array(
									"message"=>"Some Error Occured, Try again later..",
									"status"=>1
									);
									return json_encode($resparr);
								}
							
						}
						else
						{
							$resparr = array(
								"message"=>"Your Account Is Deactivated By Administrator",
								"status"=>1
							);
							return json_encode($resparr);
						}
					}
					else
					{
						$resparr = array(
								"message"=>"Invalid Operation Performed",
								"status"=>1
							);
							return json_encode($resparr);exit;
					}

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
	
	public function tblcompany_Entry($company_name,$operator_code,$service_id,$long_code_format,$logo_path,$long_code_no,$product_name)
	{
		$this->load->library("common");
		$this->load->model("common_methods");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblcompany(company_name,operator_code,service_id,add_date,ipaddress,long_code_format,logo_path,long_code_no,product_name) values(?,?,?,?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($company_name,$operator_code,$serviceID,$add_date,$ipaddress,$long_code_format,$logo_path,$long_code_no,$product_name));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function tblapi_Entry($api_name,$username,$password,$API_mode,$status)
	{
		$this->load->library("common");
		$this->load->model("common_methods");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblapi(api_name,username,password,API_mode,add_date,ipaddress,status) values(?,?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($api_name,$username,$password,$API_mode,$add_date,$ipaddress,$status));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function tblcommission_Entry($company_id,$api_id,$commission_per,$scheme_id)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblcommission(company_id,api_id,commission_per,scheme_id,add_date,ipaddress) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($company_id,$api_id,$commission_per,$scheme_id,$add_date,$ipaddress));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function tblratailertype_Entry($retailer_type_name)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblratailertype(retailer_type_name,add_date,ipaddress) values(?,?,?)";
		$result = $this->db->query($str_query,array($retailer_type_name,$add_date,$ipaddress));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function tblstate_Entry($state_name,$codes,$circle_code)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblstate(state_name,codes,circle_code,add_date,ipaddress) values(?,?,?,?,?)";
		$result = $this->db->query($str_query,array($state_name,$codes,$circle_code,$add_date,$ipaddress));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function tblcity_Entry($city_name,$state_id)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblcity(city_name,state_id,add_date,ipaddress) values(?,?,?,?)";
		$result = $this->db->query($str_query,array($city_name,$state_id,$add_date,$ipaddress));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function tblscheme_Entry($scheme_name,$scheme_description,$amount,$scheme_type)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblscheme(scheme_name,scheme_description,amount,scheme_type,add_date,ipaddress) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($scheme_name,$scheme_description,$amount,$scheme_type,$add_date,$ipaddress));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	public function tblbank_Entry($bank_name)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tblbank(bank_name,add_date,ipaddress) values(?,?,?)";
		$result = $this->db->query($str_query,array($bank_name,$add_date,$ipaddress));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	public function tbluser_bank_Entry($bank_id,$ifsc_code,$account_number,$branch_name,$user_id)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tbluser_bank(bank_id,ifsc_code,account_number,branch_name,user_id,add_date,ip_address) values(?,?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($bank_id,$ifsc_code,$account_number,$branch_name,$user_id,$add_date,$ipaddress));		
		if($result > 0)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	public function ref_comm_entry($user_id,$payment_id,$amount,$comm_per,$disc,$comm_type,$reg_user_id)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$str_query = "insert into ref_comm(user_id,payment_id,amount,comm_per,add_date,disc,comm_type,reg_user_id) values(?,?,?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($user_id,$payment_id,$amount,$comm_per,$add_date,$disc,$comm_type,$reg_user_id));
		return true;
	}
	public function  tblmodule_rights($user_id,$add_date,$ipaddress,$isDTH,$isMobile,$isAccount,$isAIR)
	{
		$str_query = "insert into tblmodule_rights(user_id,add_date,ipaddress,isDTH,isMobile,isAccount,isAIR) values(?,?,?,?,?,?,? )";
		$rlst = $this->db->query($str_query,array($user_id,$add_date,$ipaddress,$isDTH,$isMobile,$isAccount,$isAIR));
		return true;
	}
	public function  tblfree_recharge_scheme_12($user_id,$add_date)
	{
		$str_query = "insert into tblfree_recharge_scheme_12(user_id,add_date,payment_date,status) values(?,?,?,?)";
		$newdate  = $add_date;
		for($i=0;$i<12;$i++)
		{
			$time = strtotime($newdate);
			$final = date("Y-m-d", strtotime("+1 month", $time));
			$rslt = $this->db->query($str_query,array($user_id,$add_date,$final,"false"));
			$newdate = $final;
			
		}
	}
	public function free_rec_comm_entry($user_id,$payment_id,$amount,$disc)
	{
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$str_query = "insert into free_rec_comm(user_id,payment_id,amount,add_date,disc) values(?,?,?,?,?)";
		$result = $this->db->query($str_query,array($user_id,$payment_id,$amount,$add_date,$disc));
		return true;
	}
	public function getCreditPaymentDescription($credit_user_id, $debit_user_id,$amount)
	{
		$credit_user_info = $this->Userinfo_methods->getUserInfo($credit_user_id);
		$debit_user_info = $this->Userinfo_methods->getUserInfo($debit_user_id);
		return "Direct Payment By  ".$debit_user_info->row(0)->businessname." [".$debit_user_info->row(0)->username."]  (".$debit_user_info->row(0)->usertype_name.")  To ".$credit_user_info->row(0)->businessname." [".$credit_user_info->row(0)->username."]  (".$credit_user_info->row(0)->usertype_name." )" ;
	}
	public function getRevertPaymentDescription($cr_user_id, $dr_user_id,$amount)
	{
		$credit_user_info = $this->Userinfo_methods->getUserInfo($cr_user_id);
		$debit_user_info = $this->Userinfo_methods->getUserInfo($dr_user_id);
		return "Direct Revert By ".$credit_user_info->row(0)->businessname." [".$credit_user_info->row(0)->username."] (".$credit_user_info->row(0)->usertype_name.")  From ".$debit_user_info->row(0)->businessname." [".$debit_user_info->row(0)->username."] (".$debit_user_info->row(0)->usertype_name." )" ;
	}
	public function tblflatcommissionEntry($user_id,$depositAmount,$amount,$commPer,$description,$payment_status)
	{
		$add_date = $this->common->getDate();
		$str_query = "insert into tblflatcommission(user_id,depositAmount,amount,commPer,add_date,description,payment_status) values(?,?,?,?,?,?,?) ";
		$rslt = $this->db->query($str_query,array($user_id,$depositAmount,$amount,$commPer,$add_date,$description,$payment_status));
		return true;
	}
	public function addComplaint($user_id,$str_message)
	{
		$this->load->library('common');
		$date = $this->common->getMySqlDate();
		$str_query = "insert into tblcomplain(user_id,complain_date,complain_status,message,complain_type,recharge_id) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($user_id,$date,'Pending',$str_message,"",""));		
		if($result > 0)
		{
			return $this->db->insert_id();
			//return true;
		}
		else
		{
			return false;
		}		
	}
	
	public function addComplaint1($user_id,$str_message,$recharge_id)
	{
		$this->load->library('common');
		$date = $this->common->getMySqlDate();
		$str_query = "insert into tblcomplain(user_id,recharge_id,complain_date,complain_status,message,complain_type) values(?,?,?,?,?,?)";
		$result = $this->db->query($str_query,array($user_id,$recharge_id,$date,'Pending',$str_message,""));		
		if($result > 0)
		{
			return $this->db->insert_id();
			//return true;
		}
		else
		{
			return false;
		}		
	}
	public function tbluserrightsEntry($user_id,$AIR,$MOBILE,$DTH,$SMS,$GPRS,$WEB,$add_date)
	{
		$str_query = "insert into tbluserrights(user_id,AIR,MOBILE,DTH,SMS,GPRS,WEB,add_date) values(?,?,?,?,?,?,?,?)";
		$rslt = $this->db->query($str_query,array($user_id,$AIR,$MOBILE,$DTH,$SMS,$GPRS,$WEB,$add_date));
		return true;
	}
	public function setCommission($reg_id,$scheme_id,$usertype_name)
	{
			$rslt = $this->db->query("select * from tblcompany");
			foreach($rslt->result() as $row)
			{
				$comm = $this->getCommByScheme($row->company_id,$scheme_id,$usertype_name);
				$this->user_commission_entry($reg_id,$row->company_id,$comm);
			}
	}
	public function tblewallet_MoneyTransfer_DrEntry($user_id,$activation_id,$transaction_type,$dr_amount,$Description)
	{
		
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();

		$old_balance = $this->Common_methods->getCurrentBalance($user_id);
		$current_balance = $old_balance - $dr_amount;
		
		$str_query = "insert into tblewallet(user_id,activation_id,transaction_type,debit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$activation_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date));
		$ewallet_id = $this->db->insert_id();
		return $ewallet_id;
	}
	public function tblewallet_MoneyTransfer_CrEntry($user_id,$activation_id,$transaction_type,$dr_amount,$Description)
	{
		
		$this->load->library("common");
		$add_date = $this->common->getDate();
		$date = $this->common->getMySqlDate();

		$old_balance = $this->Common_methods->getCurrentBalance($user_id);
		$current_balance = $old_balance + $dr_amount;
		
		$str_query = "insert into tblewallet(user_id,activation_id,transaction_type,credit_amount,balance,description,add_date)
		values(?,?,?,?,?,?,?)";
		$reslut = $this->db->query($str_query,array($user_id,$activation_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date));
		$ewallet_id = $this->db->insert_id();
		return $ewallet_id;
	}
	public function getCommByScheme($company_id,$scheme_id,$usertype_name)
	{
		$rslt = $this->db->query("select * from tblgroupapi where group_id = ? and company_id = ?",array($scheme_id,$company_id));
		if($rslt->num_rows() > 0)
		{
			return 	$rslt->row(0)->	commission;
		}
		else
		{
		return 0;
		}
	}
	public function user_commission_entry($reg_id,$company_id,$comm)
	{
		$add_date = $this->common->getDate();
		$ipaddress = $this->common->getRealIpAddr();
		$str_query = "insert into tbluser_commission(user_id,company_id,commission,add_date,ipaddress) values(?,?,?,?,?)";
		$rslt = $this->db->query($str_query,array($reg_id,$company_id,$comm,$add_date,$ipaddress));
	}
	public function refundOfAcountReportEntry($recharge_id)
	{
		$rsltrech = $this->db->query("select * from tblrecharge where recharge_id = ? and user_id != 1",array($recharge_id));
		if($rsltrech->num_rows() == 1)
		{
			/*$MdId = $rsltrech->row(0)->MdId;
			$MdComPer = $rsltrech->row(0)->MdComPer;
			$MdComm = $rsltrech->row(0)->MdComm;
			$MdCom_Given = $rsltrech->row(0)->MdCom_Given;
			
			$DId = $rsltrech->row(0)->DId;
			$DComPer = $rsltrech->row(0)->DComPer;
			$DComm = $rsltrech->row(0)->DComm;
			$DCom_Given = $rsltrech->row(0)->DCom_Given;
			
			
			$FosId = $rsltrech->row(0)->FosId;
			$FosComPer = $rsltrech->row(0)->FosComPer;
			$FosComm = $rsltrech->row(0)->FosComm;
			$FosCom_Given = $rsltrech->row(0)->FosCom_Given;*/
			
			$user_id = $rsltrech->row(0)->user_id;
			$commission_amount = $rsltrech->row(0)->commission_amount;
			$commission_per = $rsltrech->row(0)->commission_per;
			
			$amount = $rsltrech->row(0)->amount;
			$debited = $rsltrech->row(0)->debited;
			$reverted = $rsltrech->row(0)->reverted;
			
			
			if($reverted == "no")
			{
				$this->db->query("update tblrecharge set reverted = 'yes' where recharge_id = ?",array($recharge_id));
				$rslt = $this->db->query("select credit_amount,debit_amount,description from tblewallet where recharge_id = ? and user_id = ?",array($recharge_id,$user_id));
				if($rslt->num_rows() == 1)
				{
					
					$date = $this->common->getDate();
					$cr_amount = $amount - $commission_amount;
					$transaction_type = "Recharge_Refund";
					
					$Description = "Refund : ".$rslt->row(0)->description." | Revert Date = ".$date;
					$ewallet_id = $this->tblewallet_Recharge_CrEntry($user_id,$recharge_id,$transaction_type,$cr_amount,$Description);
					$this->db->query("update tblrecharge set reverted = 'yes',debited = 'no',ewallet_id = CONCAT_WS(',',ewallet_id,?) where recharge_id = ?",array($ewallet_id,$recharge_id));
					
				//	$this->load->model("Commission");
				//	$this->Commission->ParentCommission_reverse($recharge_id);
				}
			}
		}
		
		
	}
	public function getCommissionInfo($company_id,$user_id,$scheme_id)
	{
		$str_query = "select * from  tbluser_commission where company_id = ? and user_id = ?";
		$rslt = $this->db->query($str_query,array($company_id,$user_id));
		if($rslt->num_rows() == 1)
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
				$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
				$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
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
		else
		{
			$str_query = "select * from  tblgroupapi where company_id = ? and group_id = ?";
			$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
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
	public function getCommissionRange($company_id,$user_id,$scheme_id)
	{	
		
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
				$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
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
			$rslt = $this->db->query($str_query,array($company_id,$scheme_id));
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
	
}

?>