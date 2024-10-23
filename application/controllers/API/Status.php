<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller { 
	
	

	public function index() 
	{  
	
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_REQUEST['userid']) && isset($_REQUEST['pin']) && isset($_REQUEST['txnid']) && isset($_REQUEST['uniqueid']) )
			{
				$username = $_REQUEST['userid'];
				$pwd =  $_REQUEST['pin'];
				$orderid =  $_REQUEST['uniqueid'];
				$txnid =  $_REQUEST['txnid'];
				//echo $txnid;exit; 
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			if(isset($_GET['userid']) && isset($_GET['pin']) && isset($_GET['txnid']) && isset($_GET['uniqueid']))
			{
				$username = $_GET['userid'];
				$pwd =  $_GET['pin'];
				$orderid =  $_GET['uniqueid'];
				$txnid =  $_GET['txnid'];
							}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		
		$USERINFO = $this->Userinfo_methods->getUserInfoByUsernamePwd2($username,$pwd);
		
		if($USERINFO->num_rows() == 1)
		{
		$user_id = $USERINFO->row(0)->user_id;
		$client_ip = $USERINFO->row(0)->client_ip;
		$client_ip2 = $USERINFO->row(0)->client_ip2;
		$client_ip3 = $USERINFO->row(0)->client_ip3;
		$client_ip4 = $USERINFO->row(0)->client_ip4;
		$client_ip5 = $USERINFO->row(0)->client_ip5;
		$ip_address = $this->getRequestURLIp();
		//if($client_ip == $ip_address or $client_ip2 == $ip_address or $client_ip3 == $ip_address or $client_ip4 == $ip_address or $client_ip5 == $ip_address)
		if(true)
		{
		if($this->Userinfo_methods->check_login($username,$pwd) == true)
		{
			
			if($USERINFO->row(0)->usertype_name == "APIUSER")
			{
				$status = $this->getRechargeStatus($USERINFO->row(0)->user_id,$txnid,$orderid);
				echo $status;
			}
		}
		else
		{
			echo "ERROR::Authentication Fail";exit;
		}
		}
		else
		{
			echo "ERROR::Invalid IP Address";exit;
		}		
		}
		else
		{
			echo "ERROR::Authentication Fail";exit;
		}
		
		
				
	}
	public function getRequestURLIp()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
		
	}	
	public function getRechargeStatus($user_id,$txnid,$orderid)
	{
		//echo $orderid;exit;
		if($txnid != NULL or $txnid != "")
		{
			$str_query  = "select recharge_status,operator_id,mobile_no,amount,order_id,recharge_id from tblrecharge where recharge_id = ? and user_id = ?";
			$rslt = $this->db->query($str_query,array($txnid,$user_id));
			if($rslt->num_rows() > 0)
			{
				return $rslt->row(0)->recharge_status.'#'.$rslt->row(0)->operator_id.'#'.$rslt->row(0)->recharge_id.'#'.$rslt->row(0)->mobile_no.'#'.$rslt->row(0)->amount.'#'.$rslt->row(0)->order_id;
			}
			else
			{
				return "Transaction Not Found";
			}
		}
		else if($orderid != NULL or orderid != "")
		{
			$str_query  = "select recharge_status,operator_id,mobile_no,amount,order_id,recharge_id from tblrecharge where order_id = ? and user_id = ?";
			$rslt = $this->db->query($str_query,array($orderid,$user_id));
			if($rslt->num_rows() > 0)
			{
				return $rslt->row(0)->recharge_status.'#'.$rslt->row(0)->operator_id.'#'.$rslt->row(0)->recharge_id.'#'.$rslt->row(0)->mobile_no.'#'.$rslt->row(0)->amount.'#'.$rslt->row(0)->order_id;
			}
			else
			{
				return "Transaction Not Found";
			}
		}
	}
	public function statuswithopid()
	{
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['order_id']))
			{$username = $_GET['username'];$pwd =  $_GET['pwd'];$order_id = $_GET['order_id'];}
			else
			{echo 'ERROR::Paramenter is missing';exit;}	
			$rslt = $this->db->query("select recharge_status,operator_id,mobile_no from tblrecharge where order_id = ? and user_id = (select user_id from tblusers where username = ? and txn_password = ?)",array($order_id,$username,$pwd));	
			if($rslt->num_rows() == 1)
			{
				echo $rslt->row(0)->recharge_status."#".$rslt->row(0)->operator_id."   Number=".$rslt->row(0)->mobile_no;
			}
			else
			{
				echo "Failure#NIL";
			}	
			
	}
}
//50.22.77.79