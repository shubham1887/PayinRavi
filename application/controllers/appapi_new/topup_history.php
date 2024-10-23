<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topup_history extends CI_Controller {
	
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['date']))
			{$username = $_GET['username'];$pwd =  $_GET['pwd'];$date =  $_GET['date'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['pwd']) && isset($_POST['date']))
			{$username = $_POST['username'];$pwd =  $_POST['pwd'];$date =  $_POST['date'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');					
		$date = date_format(date_create($date),'Y-m-d');
		$AUTHENTICATION = $this->check_login($username,$pwd);
		if($AUTHENTICATION == false)
		{
			echo 'false';	
		}
		else
		{
		    $host_id = 1;
			$userinfo = $this->db->query("select user_id,usertype_name, from tblusers where username = ?  and password = ?",array($username,$pwd,$host_id));
			if($userinfo->num_rows()  == 1)
			{
				if($userinfo->row(0)->usertype_name == 'Agent')
				{
					$xml_return = '';
					$user_id = $userinfo->row(0)->user_id;
					$str_query = "select tblewallet.* from tblewallet where user_id = '$user_id' and DATE(add_date) = '$date' and transaction_type = 'PAYMENT' and credit_amount > 0 order by tblewallet.Id desc";
					$rslt = $this->db->query($str_query);
					if($rslt->num_rows() > 0)
					{
						foreach($rslt->result()as $result)
						{
							$description = $result->description;
							$before_balance = $result->balance - $result->credit_amount;
							$credit_amount = $result->credit_amount;
							$balance = $result->balance;
							$add_date = $result->add_date;
							$xml_return .=$description.'#'.$before_balance.'#'.$credit_amount.'#'.$balance.'#'.$add_date.'@@';			
							
						}
						echo $xml_return;exit;
					}
				}
				else if($userinfo->row(0)->usertype_name == 'WLAgent')
				{
					$xml_return = '';
					$user_id = $userinfo->row(0)->user_id;
					$str_query = "select WLtblewallet.* from WLtblewallet where user_id = '$user_id' and DATE(add_date) = '$date' and transaction_type = 'PAYMENT' and credit_amount > 0 order by WLtblewallet.Id desc";
					$rslt = $this->db->query($str_query);
					if($rslt->num_rows() > 0)
					{
						foreach($rslt->result()as $result)
						{
							$description = $result->description;
							$before_balance = $result->balance - $result->credit_amount;
							$credit_amount = $result->credit_amount;
							$balance = $result->balance;
							$add_date = $result->add_date;
							$xml_return .=$description.'#'.$before_balance.'#'.$credit_amount.'#'.$balance.'#'.$add_date.'@@';			
							
						}
						echo $xml_return;exit;
					}
				}
				
			}
			
			
		}		
	
	
	}	
	function check_login($username,$password)
	{
		$str_query = "select user_id,usertype_name,status from tblusers where (username = ? or mobile_no = ?) and password=?";
		$result = $this->db->query($str_query,array($username,$username,$password));		
		if($result->num_rows() == 1)
		{
			
			if($result->row(0)->status == '1')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}		
	}
}
