<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dthactivationreq extends CI_Controller {
	
	
	
	
	public function index() 
	{
	
		
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['plan_id'])  && isset($_GET['Name']) && isset($_GET['number']) && isset($_GET['pincode']) && isset($_GET['address']))
			{
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['pwd']);
				$plan_id = trim($_GET['plan_id']);
				$Name =  trim($_GET['Name']);
				$number = trim($_GET['number']);
				$pincode = trim($_GET['pincode']);
				$address = trim($_GET['address']);
			}
			else if(isset($_POST['username']) && isset($_POST['pwd']) && isset($_POST['plan_id'])  && isset($_POST['Name']) && isset($_POST['number']) && isset($_POST['pincode']) && isset($_POST['address']))
			{
				$username = trim($_POST['username']);
				$pwd =  trim($_POST['pwd']);
				$plan_id = trim($_POST['plan_id']);
				$Name =  trim($_POST['Name']);
				$number = trim($_POST['number']);
				$pincode = trim($_POST['pincode']);
				$address = trim($_POST['address']);
			}
			else
			{echo 'Paramenter is missing';exit;}			
			
			$user_info = $this->db->query("select * from tblusers where username = ? and password = ? and status = 1",array($username,$pwd));
			if($user_info->num_rows() == 1)
			{
			
					if($user_info->row(0)->usertype_name == "Agent" )
					{
					
					
					
						$checkplan = $this->db->query("select * from tblactivation where user_id = ? and plan_id = ? and status = 'Pending'",array($user_info->row(0)->user_id,$plan_id));
					if($checkplan->num_rows() >= 1)
					{
						$resparray = array(
										"message"=>"Request Already Exist",
										"status"=>1);
										echo json_encode($resparray);exit;
					}
					else
					{
						$rsltPlan = $this->db->query("select * from tbldthplans where Id = ?",array($plan_id));
						if($rsltPlan->num_rows() == 1)
						{
							$user_id = $user_info->row(0)->user_id;
							$company_id = $rsltPlan->row(0)->company_id;
							$amount = $rsltPlan->row(0)->amount;
							$commission = $rsltPlan->row(0)->commission;
							$add_date = $this->common->getDate();
							$ipaddress = $this->common->getRealIpAddr();
							if($amount > 0)
							{
								$current_bal = $this->Common_methods->getAgentBalance($user_id);
								$dramount = $amount - $commission;
								if($current_bal >= $dramount)
								{
	
									$str_query = "insert into tblactivation(company_id,plan_id,name,number,address,pincode,amount,commission,add_date,ipaddress,status,user_id) values(?,?,?,?,?,?,?,?,?,?,?,?)";
									$this->db->query($str_query,array($company_id,$plan_id,$Name,$number,$address,$pincode,$amount,$commission,$add_date,$ipaddress,"Pending",$user_id));
									$activation_id = $this->db->insert_id();
									$rsltactivation = $this->db->query("select tblactivation.*,(select businessname from tblusers where tblusers.user_id = tblactivation.user_id) as businessname,(select company_name from tblcompany where tblcompany.company_id = tblactivation.company_id) as company_name,(select plan_name from tbldthplans where tbldthplans.Id = tblactivation.plan_id) as plan_name,(select amount from tbldthplans where tbldthplans.Id = tblactivation.plan_id) as plan_amount,(select commission from tbldthplans where tbldthplans.Id = tblactivation.plan_id) as plan_commission from tblactivation where Id=?",array($activation_id));
									$transaction_type = "DTH_ACTIVATION";
									$Description = "DTH_ACTIVATION >> Operator Name : ".$rsltactivation->row(0)->company_name." | Plan Name : ".$rsltactivation->row(0)->plan_name." | Plan Amount : ".$rsltactivation->row(0)->plan_amount." | Plan Commission : ".$rsltactivation->row(0)->plan_commission."  | Activation_Id = ".$activation_id;
								$this->load->model("Insert_model");
								$ewid = $this->Insert_model->tblewallet_DTHActivation_DrEntry($user_id,$activation_id,$transaction_type,$dramount,$Description);
								$msg = "New Activation ::".$rsltactivation->row(0)->company_name.' , '.$rsltactivation->row(0)->plan_name.'  , '.$Name.'  ,  '.$address.' ,  '.$pincode.'  ,  '.$number;
									
									$this->db->query("update tblactivation set ewallet_id = ? where Id = ?",array($ewid,$activation_id));
									
									
									
									$resparray = array(
				"message"=>"Your Request Sent Successfully",
				"status"=>0,
				"data"=>array(
				
					'CompanyName'=>$rsltactivation->row(0)->company_name,
					'PlanAmount'=>$rsltactivation->row(0)->plan_amount,
					'Commission'=>$rsltactivation->row(0)->plan_commission,
					'RequestId'=>$activation_id,
					'CustomerName'=>$Name,
					)
				);
				echo json_encode($resparray);exit;
									
									
									
								}
								else
								{
									$resparray = array(
				"message"=>"Insufficient Balance",
				"status"=>1);
				echo json_encode($resparray);exit;
								}
							}
							else
							{
								$resparray = array(
										"message"=>"Invalid Amount",
										"status"=>1);
										echo json_encode($resparray);exit;
							}
						}
						else
						{
							$resparray = array(
										"message"=>"Invalid Operation, Plan Does Not Exist",
										"status"=>1);
										echo json_encode($resparray);exit;
						}
						
					}
					
					
						
					}	
			}
			else
			{
				$resparray = array(
										"message"=>"Unauthorised Access",
										"status"=>1);
										echo json_encode($resparray);exit;
			}
	
	
	}
	private function check_login($username,$password)
	{
		$userinfo = $this->db->query("select * from tblusers where username = ? and password = ?",array($username,$password));
	}
	public function getmcode($mcode)
	{
		$rslt = $this->db->query("select company_id from tblcompany where mcode = ?",array($mcode));
		if($rslt->num_rows() > 0)
		{
			return $rslt->row(0)->company_id;
		}
		else
		{
			return false;
		}
		
	}	

}