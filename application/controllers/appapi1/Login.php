<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
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
		
		echo $this->check_login($username,$pwd);exit;
	
	
	}	
	function check_login($username,$password)
	{
	    $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$str_query = "select user_id,usertype_name,status from tblusers where username = ? and password=? and host_id = ?";
		$result = $this->db->query($str_query,array($username,$username,$password,$host_id));		
		if($result->num_rows() == 1)
		{
			
			if($result->row(0)->status == '1')
			{
				echo trim($result->row(0)->usertype_name);exit;
			}
			else
			{
				echo  "false";
			}
		}
		else
		{
			echo "false";
		}		
	}
}
