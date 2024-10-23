<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {
	
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{$username = $_GET['username'];$pwd =  $_GET['pwd'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['pwd']))
			{$username = $_POST['username'];$pwd =  $_POST['pwd'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		
		$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name from tblusers where username = ?  and password = ?",array($username,$pwd));
		if($userinfo->num_rows() == 1)
		{
			$user_id = $userinfo->row(0)->user_id;
			$status = $userinfo->row(0)->status;
			$business_name = $userinfo->row(0)->businessname;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$username = $userinfo->row(0)->username;
			if($status == '1')
			{
				
				$resparray = array(
				'Name'=>$business_name,
				'UserId'=>$username,
				'Type'=>$usertype_name,
				'Balance'=>$this->Common_methods->getAgentBalance($user_id),
				'Error'=>0,
				'Message'=>'SUCCESS'
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
