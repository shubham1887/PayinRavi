<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetTarget extends CI_Controller {
	
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
		
		        $target = $this->db->query("select * from tbltarget where user_id = ?",array($user_id));
		        if($target->num_rows() == 1)
		        {
		            $totalsale = 0;
		            $sales = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where recharge_status = 'Success' and user_id = ? and MONTH(add_date) = ?",array($user_id,"04"));
		            if($sales->num_rows() == 1)
		            {
		                $totalsale = $sales->row(0)->total;
		            }
		            $balance = $this->Common_methods->getAgentBalance($user_id);
		            $balance2 = round($this->Ew2->getAgentBalance($user_id),2);
		            $resparray = array(
    				"message"=>"success",
    				"status"=>0,
    				"data"=>array(
    				
    					'RECHARGE_TARGET'=>$target->row(0)->target,
    					'RECHARGE_SALES'=>$totalsale,
    					'DMT_TARGET'=>0,
    					'DMT_SALES'=>0,
    					'Wallet1'=>$balance,
    					'Wallet2'=>$balance2,
    					)
    				);
    				echo json_encode($resparray);exit;
		        }
		        else
		        {
		            $totalsale = 0;
		            $sales = $this->db->query("select IFNULL(Sum(amount),0) as total from tblrecharge where recharge_status = 'Success' and user_id = ? and MONTH(add_date) = ?",array($user_id,"04"));
		            if($sales->num_rows() == 1)
		            {
		                $totalsale = $sales->row(0)->total;
		            }
		            $balance = $this->Common_methods->getAgentBalance($user_id);
		            $balance2 = round($this->Ew2->getAgentBalance($user_id),2);
		            $resparray = array(
    				"message"=>"success",
    				"status"=>0,
    				"data"=>array(
    				
    					'RECHARGE_TARGET'=>"50000",
    					'RECHARGE_SALES'=>$totalsale,
    					'DMT_TARGET'=>0,
    					'DMT_SALES'=>0,
    					'Wallet1'=>$balance,
    					'Wallet2'=>$balance2,
    					)
    				);
    				echo json_encode($resparray);exit;
		        }
			    
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
