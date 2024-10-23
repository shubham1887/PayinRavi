<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetBankStatus extends CI_Controller {
	
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password'])  && isset($_GET['IFSC']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['password'];
				$IFSC =  $_GET['IFSC'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select a.user_id,a.businessname,a.username,a.status,a.usertype_name,info.birthdate
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
			if($status == '1')
			{
			    
			    $rslt = $this->db->query("select * from instantpay_banklist where branch_ifsc = ?",array($IFSC));
			    if($rslt->num_rows() == 1)
			    {
			    	$resp_array = array(
			    			"bank_name"=>$rslt->row(0)->bank_name,
			    			"neft_status"=>$rslt->row(0)->neft_enabled,
			    			"imps_status"=>$rslt->row(0)->imps_enabled,
			    	);
			    	echo json_encode($resp_array);exit;
			    }
			    else
			    {
			    	$resp_array = array(
			    			"bank_name"=>"",
			    			"neft_status"=>"1",
			    			"imps_status"=>"1",
			    	);
			    	echo json_encode($resp_array);exit;
			    }
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
