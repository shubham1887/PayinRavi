<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr2_getbanklist extends CI_Controller {
	
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{$username = $_GET['username'];$pwd =  $_GET['pwd']; }
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}
		$mainarr = array();
		$mainarr["results"] = array();
		$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name from tblusers where username = ? and password = ?",array($username,$pwd));
		if($userinfo->num_rows() == 1)
		{
			$user_id = $userinfo->row(0)->user_id;
			$status = $userinfo->row(0)->status;
			$business_name = $userinfo->row(0)->businessname;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$username = $userinfo->row(0)->username;
			if($status == '1')
			{
				
				$bankresult = $this->db->query("select a.BankName as bank_name,a.Id,a.ifscCode as ifsc from bank_master a  order by a.BankName");
				$mainarr["results"] = $bankresult->result();
				
				echo json_encode($mainarr);exit;
			}
			else
			{
				$resparray = array(
				'Error'=>1,
				'Message'=>'Your account is deactivated. contact your Administrator'
				);
				echo json_encode($resparray);exit;
			}
		}
		else
		{
			$resparray = array(
				'Error'=>1,
				'Message'=>'Invalid UserId or Password'
				);
				echo json_encode($resparray);exit;
		}
	
	
	}	
	public function test()
	{ 
		
	
				$response = '';
				$bankresult = $this->db->query("select a.bank_name,a.bankcode,a.field1 as bank_id,a.ifsc from dmr_banks a where bank_name like '".$bank_name."%'  order by bank_name");
				$mainarr["results"] = $bankresult->result();
				foreach($bankresult->result() as $rw)
				{
				   $response .= $rw->bank_name."@@".$rw->bankcode."@@".$rw->bank_id;
				}
				
				echo $response ;exit;
			
	
	
	}
}
