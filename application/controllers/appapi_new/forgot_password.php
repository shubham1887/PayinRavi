<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgot_password extends CI_Controller {
	
	public function index()
	{  
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['mobile']))
			{$mobile =  $_GET['mobile'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['mobile']))
			{$mobile =  $_POST['mobile'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		
		echo $this->check_login($mobile);exit;
	
	
	}	
	function check_login($mobile)
	{
		$str_query = "select * from tblusers where  mobile_no=?";
		$result = $this->db->query($str_query,array($mobile));		
		if($result->num_rows() == 1)
		{
			
			if($result->row(0)->status == '1')
			{
				$smsMessage = "Dear ".$result->row(0)->businessname." Your Login Detail User Id : ".$result->row(0)->username."  Password : ".$result->row(0)->password." Transaction Password : ".$result->row(0)->txn_password."";
				
			$this->load->model("Sms");
			$result_sms = $this->common->ExecuteSMSApi($result->row(0)->mobile_no,$smsMessage);
			
			    $resparray = array(
				'status'=>0,
				'message'=>'Your Password Sent To Your Registered Mobile Number'
				);
				echo json_encode($resparray);exit;
			}
			else
			{
			    $resparray = array(
				'status'=>1,
				'message'=>'Your Status Is Not Activated, Please Contact Administrator'
				);
				echo json_encode($resparray);exit;
			}
		}
		else
		{
		    $resparray = array(
			'status'=>1,
			'message'=>'Information Provided Is Not Valid'
			);
			echo json_encode($resparray);exit;
		}		
	}
}
