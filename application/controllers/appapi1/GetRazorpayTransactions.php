<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetRazorpayTransactions extends CI_Controller {
	
	public function index()
	{ 
		// error_reporting(-1);
		// ini_set('display_errors',1);
		// $this->db->db_debug = TRUE;
		
		
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['from']) && isset($_GET['to']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$from =  $_GET['from'];
				$to =  $_GET['to'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
		
		
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
			    
			    $rslt = $this->db->query("
			    	SELECT 
			    	Id,add_date,amount,payment_from,resp_status,description 
			    	FROM tbl_razorpay_order
			    	where 
			    	resp_status != 'created' and
			    	user_id = ? and 
			    	Date(add_date) BETWEEN ? and ?
			    	",array($user_id,$from,$to));
			    echo json_encode($rslt->result());exit;

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
