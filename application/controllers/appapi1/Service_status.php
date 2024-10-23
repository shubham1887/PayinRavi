<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_status extends CI_Controller {
	public function logentry($data)
	{
		
	}
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
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
					    $data_array = array();
					    $common_rslt = $this->db->query("select param as service_type,value as status from admininfo where param = 'DMT1_SERVICE' or param = 'DMT_SERVICE'");
					    foreach($common_rslt->result() as $rw)
					    {
					    	$service_type = $rw->service_type;
					    	if($service_type == "DMT_SERVICE")
					    	{
					    		$service_type = "DMT2_SERVICE";
					    	}

					    	$temparray = array("service_type"=>$service_type,"status"=>$rw->status);
					    	array_push($data_array,$temparray);
					    }
					    echo json_encode($data_array);exit;
					}
					else
					{
						$resparray = array(
						'status'=>1,
						'message'=>'Your account is deactivated. contact your Administrator'
						);
						echo json_encode($resparray);exit;
					}
				}
				else
				{
					$resparray = array(
						'status'=>1,
						'message'=>'Invalid UserId or Password'
						);
						echo json_encode($resparray);exit;
				}
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		 
		
	
	
	}	
}
