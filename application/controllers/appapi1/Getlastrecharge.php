<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getlastrecharge extends CI_Controller {
	
	
	
	
	public function index() 
	{
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET["username"]) and isset($_GET["password"]))
			{
				$username = trim($_GET["username"]);
				$password = trim($_GET["password"]);
				$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
				$userinfo = $this->db->query("select user_id from tblusers where username = ?  and password = ?",array($username,$password,$host_id));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;	
					$rslt = $this->db->query("select company_name,mcode,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.user_id = ? order by recharge_id desc limit 4",array($user_id));
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
			
			
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST["username"]) and isset($_POST["password"]))
			{
				$username = trim($_POST["username"]);
				$password = trim($_POST["password"]);
				$userinfo = $this->db->query("select user_id from tblusers where (username = ? or mobile_no = ?) and password = ?",array($username,$username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;	
					$rslt = $this->db->query("select company_name,mcode,recharge_id,tblrecharge.mobile_no,tblrecharge.amount,tblrecharge.add_date,tblrecharge.operator_id,tblrecharge.recharge_status from tblrecharge,tblcompany where tblcompany.company_id = tblrecharge.company_id and tblrecharge.user_id = ? order by recharge_id desc limit 50",array($user_id));
				}
				else
				{
					echo "Invalid User";exit;
				}
			}
			
		}
		
		if((isset($_POST["username"]) and isset($_POST["password"])) or (isset($_GET["username"]) and isset($_GET["password"])))
        {
		$resparray = array();
		$resparray["data"] = array();
		foreach($rslt->result() as $row)
		{
		
		$data = array(
				'id'=>$row->recharge_id,
				'mcode'=>$row->mcode,
				'operator'=>$row->company_name,
				'mobile'=>$row->mobile_no,
				'amount'=>$row->amount,
				'status'=>$row->recharge_status,
				'operator_id'=>$row->operator_id,
				'recDate'=>$row->add_date,
				);
				array_push($resparray["data"],$data);
		
		}
		echo json_encode($resparray);exit;
         }
         else
         {
               echo "Paramter Missing";exit;
         }
	
		

	}
	
}