<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifyparams extends CI_Controller {
	//http://www.MPAY.IN/appapi1/notifyparams?username=&pwd=&key=&imei=&mobile_no=
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['key'])  && isset($_GET['imei'])  )
			{
			    $username = $_GET['username'];
			    $pwd =  $_GET['pwd'];
			    $key =  $_GET['key'];
			    $imei =  $_GET['imei'];
			 
			    
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name from tblusers where username = ? and password = ? and host_id = ?",array($username,$pwd,$host_id));
		if($userinfo->num_rows() == 1)
		{
			$status = $userinfo->row(0)->status;
			$user_id = $userinfo->row(0)->user_id;
			$business_name = $userinfo->row(0)->businessname;
			$username = $userinfo->row(0)->username;
			$usertype_name = $userinfo->row(0)->usertype_name;
			if($status == '1')
			{
				$this->db->query("update tblusers_info set notify_imei=?,notify_key=? where user_id = ?",array($imei,$key,$user_id));
				$resparray = array(
				'status'=>0,
				'message'=>'success'
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
