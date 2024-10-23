<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setbirthdate extends CI_Controller {
	//http://www.himachalpay.com/appapi1/balance?username=&pwd=
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{
			    $username = $_GET['username'];
			    $pwd =  $_GET['pwd'];
			    $in_birthdate = $_GET['birthdate'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
	
		else
		{
			echo 'Paramenter is missing';exit;
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
			   $this->db->query("update tblusers_info set birthdate = ? where user_id = ? ",array( $in_birthdate,$user_id));
			   	$resparray = array(
				'status'=>0,
				'message'=>'Birthdate Updated Successfully'
				);
				echo json_encode($resparray);exit;
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
}
