<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetSummary extends CI_Controller {
	//http://www.himachalpay.com/appapi1/balance?username=&pwd=
	public function index()
	{ 
		
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{
			    $username = $_GET['username'];
			    $pwd =  $_GET['pwd'];
			    $host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			    $userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name from tblusers where username = ? and password = ? and host_id = ?",array($username,$pwd,$host_id));
        		if($userinfo->num_rows() == 1)
        		{
        			$status = $userinfo->row(0)->status;
        			$user_id = $userinfo->row(0)->user_id;
        			$business_name = $userinfo->row(0)->businessname;
        			$username = $userinfo->row(0)->username;
        			$usertype_name = $userinfo->row(0)->usertype_name;
        			
        			
        			if($status == '1')
        			{
        			    $opening_balance = 0;
    			       $openingbalance_rslt =$this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) < ? order by Id desc limit 1",array($user_id,$this->common->getMySqlDate()));
    			       if($openingbalance_rslt->num_rows() == 1)
    			       {
    			           $opening_balance = $openingbalance_rslt->row(0)->balance;
    			       }
    			       
    			       $closingbalance_rslt =$this->db->query("select balance from tblewallet where user_id = ? and Date(add_date) <= ? order by Id desc limit 1",array($user_id,$this->common->getMySqlDate()));
    			       if($closingbalance_rslt->num_rows() == 1)
    			       {
    			           $closing_balance = $closingbalance_rslt->row(0)->balance;
    			       }
    			       
    			       $totalrecharge = 0;
    			       $totalcommission = 0;
    			       $rechargerslt = $this->db->query("select IFNULL(Sum(amount),0) as totalrecharge,IFNULL(Sum(commission_amount),0) as totalcommission from tblrecharge where user_id = ? and Date(add_date) = ? and (recharge_status = 'Success' or recharge_status = 'Pending') ",array($user_id,$this->common->getMySqlDate()));
    			       if($rechargerslt->num_rows())
    			       {
    			           $totalrecharge = $rechargerslt->row(0)->totalrecharge;
    			           $totalcommission = $rechargerslt->row(0)->totalcommission;
    			       }
    			       
    			        
    			       $rechargerslt = $this->db->query("select IFNULL(Sum(credit_amount),0) as totalcredit from tblewallet where user_id = ? and transaction_type = 'CRADIT' and Date(add_date) = ? ",array($user_id,$this->common->getMySqlDate()));
    			       if($rechargerslt->num_rows())
    			       {
    			           
    			           $totalcredit = $rechargerslt->row(0)->totalcredit;
    			       }
    			       $rechargerslt1 = $this->db->query("select IFNULL(Sum(debit_amount),0) as totaldebit from tblewallet where user_id = ? and transaction_type = 'DEBIT' and Date(add_date) = ? ",array($user_id,$this->common->getMySqlDate()));
    			       if($rechargerslt1->num_rows())
    			       {
    			           
    			           $totaldebit = $rechargerslt1->row(0)->totaldebit;
    			       }
    			       $rechargerslt1 = $this->db->query("select IFNULL(Sum(credit_amount),0) as totalpayment  from tblewallet where user_id = ? and transaction_type = 'PAYMENT' and Date(add_date) = ? ",array($user_id,$this->common->getMySqlDate()));
    			       if($rechargerslt1->num_rows())
    			       {
    			           
    			           $totalpayment = $rechargerslt1->row(0)->totalpayment;
    			       }
    			       
    			       
    			       $resparr = array(
    			           "opening"=>$opening_balance,
    			           "purchase"=>$totalcredit + $totalpayment,
    			           "transfer"=>$totaldebit,
    			           "totalrecharge"=>$totalrecharge,
    			           "totalcommission"=>$totalcommission,
    			           "closing"=>$closing_balance
    			           );
    			           echo json_encode($resparr);exit;
    			       
        			}
        		}
			    
			    
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
	
		
	
	
	}	
}
