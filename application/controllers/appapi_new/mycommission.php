<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mycommission extends CI_Controller {
	
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['password']))
			{$username = $_GET['username'];$pwd =  $_GET['password'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['password']))
			{$username = $_POST['username'];$pwd =  $_POST['password'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		$host_id = 1;
		$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name from tblusers where username = ?  and password = ? ",array($username,$pwd));
		if($userinfo->num_rows() == 1)
		{
			$status = $userinfo->row(0)->status;
			$user_id = $userinfo->row(0)->user_id;
			$business_name = $userinfo->row(0)->businessname;
			$username = $userinfo->row(0)->username;
			$usertype_name = $userinfo->row(0)->usertype_name;
			if($status == '1')
			{
				$temparr = array();
				$commarr = array();
					
					$mycomm = $this->db->query("
		select 
		a.company_id,
		a.company_name,
	    a.mcode ,
		a.service_id,
		IFNULL(b.commission,0) as commission
		from tblcompany a
		left join tbluser_commission b on a.company_id = b.company_id and b.user_id = ?
		order by a.service_id,a.company_name ",array($user_id));
					foreach($mycomm->result() as $r)
					{
					    $service_id = $r->service_id;
					    $service_name = "";
					    if($service_id == 1)
					    {
					        $service_name = "MOBILE";
					    }
					    else if($service_id == 2)
					    {
					        $service_name = "DTH";
					    }
					    else if($service_id == 3)
					    {
					        $service_name = "POSTPAID";
					    }
					    else if($service_id == 6)
					    {
					        $service_name = "GAS";
					    }
					    else if($service_id == 8)
					    {
					        $service_name = "LANDLINE";
					    }
					    else if($service_id == 9)
					    {
					        $service_name = "WATER";
					    }
					    else if($service_id == 10)
					    {
					        $service_name = "INSURANCE";
					    }
					    else if($service_id == 5)
					    {
					        $service_name = "ELECTRICITY";
					    }
						
						$temparr = array(
							"CompanyName"=>$r->company_name,
							"commission"=>$r->commission,
						    "TYPE"=>$service_name,
							"mcode"=>$r->mcode,
						);
						
						array_push($commarr,$temparr);
					}
				
				$resparray = array(
					'Error'=>0,
					'Message'=>'SUCCESS',
					'data'=>$commarr
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
