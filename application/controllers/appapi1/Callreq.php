<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Callreq extends CI_Controller {
	
	
	
	
	public function index() 
	{
	    if(isset($_GET['username']) && isset($_GET['pwd']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
			
			}
			else if(isset($_POST['username']) && isset($_POST['pwd'])  )
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
			
			}
			else
			{echo 'Paramenter is missing';exit;}			
	
			
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$user_info = $this->db->query("select user_id,businessname,mobile_no from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
			if($user_info->num_rows() == 1)
			{
			    
			    
			    $checkcallreq = $this->db->query("select count(Id) as total from callreq where user_id = ? and status = 'PENDING'",array($user_info->row(0)->user_id));
			    if($checkcallreq->row(0)->total > 0)
			    {
			            $resparray = array(
        				'status'=>1,
        				'message'=>'Your Call Request Already Exist In The System. Our Customer Care Executive Contact You Shortly'
        				);
        			echo json_encode($resparray);exit;   
			    }
			    else
			    {
			        $this->db->query("insert into callreq(user_id,add_date,ipaddress,status) values(?,?,?,?)",array($user_info->row(0)->user_id,$this->common->getDate(),$this->common->getRealIpAddr(),"PENDING"));
    				$this->db->query("insert into tblnotification(title,message,messagefor,add_date,ipaddress,host_id) values(?,?,?,?,?,?)",array("CALL ME",$user_info->row(0)->businessname."  Mobile : ".$user_info->row(0)->mobile_no,"Admin",$this->common->getDate(),$this->common->getRealIpAddr(),$host_id));
    				$resparray = array(
        				'status'=>0,
        				'message'=>'Call Request Received Successfully'
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