<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Balance extends CI_Controller {
	
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']) )
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select a.user_id,a.businessname,a.username,a.status,a.usertype_name,info.birthdate,a.kyc
		from tblusers  a 
		left join tblusers_info info on a.user_id = info.user_id
		where 
		a.username = ? and 
		a.password = ? 
		and a.host_id = ?",array($username,$pwd,$host_id));
		if($userinfo->num_rows() == 1)
		{
			$status = $userinfo->row(0)->status;
			$user_id = $userinfo->row(0)->user_id;
			$business_name = $userinfo->row(0)->businessname;
			$username = $userinfo->row(0)->username;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$birthdate = $userinfo->row(0)->birthdate;
			$kyc = $userinfo->row(0)->kyc;
			if($status == '1')
			{
			    if($birthdate == "0000-00-00")
			    {
			        $birthdate = false;
			    }

			    $adhar_kyc = "false";
			    if($kyc == "yes")
			    {
			    	$adhar_kyc = "true";
			    }


			    $balance = round($this->Common_methods->getAgentBalance($user_id),2);
			    $balance2 = round($this->Ew2->getAgentBalance($user_id),2);
				$resparray = array(
				'Name'=>$business_name,
				'UserId'=>$username,
				'Type'=>$usertype_name,
				'Balance'=>$balance,
				'Balance2'=>$balance2,
				"Birthdate"=>$birthdate,
				'Error'=>0,
				'Message'=>'SUCCESS',
				'UPI_ID'=>'',
				'UPI_PARTY_NAME'=>'',
				"aadharkyc"=>$adhar_kyc
				);
				echo json_encode($resparray);exit;
			}
			else
			{
				$resparray = array(
				'Error'=>1,
				'Message'=>'Your account is deactivated. contact your Administrator'
				);
				echo json_encode($resparray);exit;
			}
		}
		else
		{
			$resparray = array(
				'Error'=>1,
				'Message'=>'Invalid UserId or Password'
				);
				echo json_encode($resparray);exit;
		}
	
	
	}	
}
