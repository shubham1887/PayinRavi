<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rechargesum extends CI_Controller {
	
	public function index()
	{ 
	
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']) )
			{$username = $_GET['username'];$pwd =  $_GET['pwd']; }
			else if(isset($_GET['username']) && isset($_GET['pwd']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{ 
			if(isset($_POST['username']) && isset($_POST['pwd']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				
			}
			else if(isset($_POST['username']) && isset($_POST['pwd']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				
			}
			
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
	    $date =  $this->common->getMySqlDate();
	    $date =  '2019-03-16';
	    $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
		$userinfo = $this->db->query("select user_id,businessname,username,status,mobile_no,usertype_name,password from tblusers where username = ? and password = ? and host_id = ?",array($username,$pwd,$host_id));
		if($userinfo->num_rows() == 1)
		{
			$user_id = $userinfo->row(0)->user_id;
			$status = $userinfo->row(0)->status;
			$business_name = $userinfo->row(0)->businessname;
			$username = $userinfo->row(0)->username;
			$mobile_no = $userinfo->row(0)->mobile_no;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$password = $userinfo->row(0)->password;
			if($status == '1')
			{
		
			$str_totalqry = "select IFNULL(Sum(amount),0) as totalRecahrge from tblrecharge where tblrecharge.recharge_status = 'Success' and Date(add_date) =? and tblrecharge.user_id = ?  ";
		$str_ptotalqry = "select IFNULL(Sum(amount),0) as totalRecahrge from tblrecharge where tblrecharge.recharge_status = 'Pending' and Date(add_date) =? and tblrecharge.user_id = ? ";
		$str_ftotalqry = "select IFNULL(Sum(amount),0) as totalRecahrge from tblrecharge where tblrecharge.recharge_status = 'Failure' and Date(add_date) =? and tblrecharge.user_id = ? ";
		
		
		$totalrslt = $this->db->query($str_totalqry,array($date,$user_id));
		$ptotalrslt = $this->db->query($str_ptotalqry,array($date,$user_id));
		$ftotalrslt = $this->db->query($str_ftotalqry,array($date,$user_id));
			
		
			
				$resparray = array(
				"message"=>"success",
				"status"=>0,
				"data"=>array(
				
					'SUCCESS'=>$totalrslt->row(0)->totalRecahrge,
					'FAILURE'=>$ftotalrslt->row(0)->totalRecahrge,
					'PENDING'=>$ptotalrslt->row(0)->totalRecahrge,
					)
				);
				echo json_encode($resparray);exit;
			}
			else
			{
				$resparray = array(
				'message'=>'Your account is deactivated. contact your Administrator',
				'status'=>1
				);
				echo json_encode($resparray);exit;
			}
		}
		else
		{
			$resparray = array(
				'message'=>'Invalid UserId or Password',
				'status'=>1
				);
				echo json_encode($resparray);exit;
		}
	
	
	}	
}
