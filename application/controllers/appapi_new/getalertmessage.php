<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getalertmessage extends CI_Controller {
	
	
	
	
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
		$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
		if($userinfo->num_rows() == 1)
		{
			$user_id = $userinfo->row(0)->user_id;
			$status = $userinfo->row(0)->status;
			$business_name = $userinfo->row(0)->business_name;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$username = $userinfo->row(0)->username;
			if($status == '1')
			{
				$rsltgetmsg = $this->db->query("select * from common where param = 'RESPMSG'");
				if($rsltgetmsg->num_rows() == 1)
				{
				    $message = $rsltgetmsg->row(0)->value;
				    $data = array(
				        'status'=>0,
						'message'=>$message,
						);
				
				    echo json_encode($data);exit;
				}
				else
				{
				    	$resparray = array(
    				'status'=>1,
    				'message'=>'No Message'
    				);
    				echo json_encode($resparray);exit;
				}
			
			
			
				
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