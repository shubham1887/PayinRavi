<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends CI_Controller {
	
	
	
	
	public function index() 
	{
	    if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['oldpwd']) && isset($_GET['newpwd']) )
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$oldpwd = $_GET['oldpwd'];
				$newpwd = $_GET['newpwd'];
			}
			else if(isset($_POST['username']) && isset($_POST['pwd']) && isset($_POST['oldpwd']) && isset($_POST['newpwd']) )
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				$oldpwd = $_POST['oldpwd'];
				$newpwd = $_POST['newpwd'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
	
			
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$user_info = $this->db->query("select * from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
			if($user_info->num_rows() == 1)
			{
			
					if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "FOS" or $user_info->row(0)->usertype_name == "Distributor"  or $user_info->row(0)->usertype_name == "MasterDealer")
					{
						if($user_info->row(0)->password == $oldpwd)
						{
							$this->db->query("update tblusers set password = ? where user_id = ?",array($newpwd,$user_info->row(0)->user_id));
							$resparray = array(
				'status'=>0,
				'message'=>'Password Changed Successfully'
				);
				echo json_encode($resparray);exit;
							
						}
						else
						{
						        $resparray = array(
				'status'=>1,
				'message'=>'Old Password Not Match'
				);
				echo json_encode($resparray);exit;
						}
					}	
					else
					{
					        $resparray = array(
				'status'=>1,
				'message'=>'Unauthorised Access'
				);
				echo json_encode($resparray);exit;
					
					}
			}
			else
			{
				$resparray = array(
				'status'=>1,
				'message'=>'Unauthorised Access'
				);
				echo json_encode($resparray);exit;
			}
	
	
	}
	

}