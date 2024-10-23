<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_pin extends CI_Controller {
	
	
	//http://www.mypaymall.in/appapi1/Change_pin?username=&pwd=&oldpin=&newpin=
	
	public function index() 
	{
	
		
	

			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['oldpin']) && isset($_GET['newpin']) )
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$oldpin = trim($_GET['oldpin']);
				$newpin = trim($_GET['newpin']);
			}
			else if(isset($_POST['username']) && isset($_POST['pwd']) && isset($_POST['oldpin']) && isset($_POST['newpin']) )
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				$oldpin = trim($_POST['oldpin']);
				$newpin = trim($_POST['newpin']);
			}
			else
			{echo 'Paramenter is missing';exit;}			
	
			
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$user_info = $this->db->query("select * from tblusers where username = ? and password = ? ",array($username,$pwd));
			if($user_info->num_rows() == 1)
			{
			
					if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "Distributor"  or $user_info->row(0)->usertype_name == "MasterDealer")
					{
						if($user_info->row(0)->txn_password == $oldpin)
						{
							$this->db->query("update tblusers set txn_password = ? where user_id = ?",array($newpin,$user_info->row(0)->user_id));
							$resparray = array(
				'status'=>0,
				'message'=>'Pin Changed Successfully'
				);
				echo json_encode($resparray);exit;
							
						}
						else
						{
						        $resparray = array(
				'status'=>0,
				'message'=>'Old Pin Not Match'
				);
				echo json_encode($resparray);exit;
						}
					}	
					else
					{
					        $resparray = array(
				'status'=>0,
				'message'=>'Unauthorised Access'
				);
				echo json_encode($resparray);exit;
					
					}
			}
			else
			{
				$resparray = array(
				'status'=>0,
				'message'=>'Unauthorised Access'
				);
				echo json_encode($resparray);exit;
			}
	
	
	}
	

}