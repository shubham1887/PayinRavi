<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_request extends CI_Controller {
	
	
	
	
	public function index() 
	{
	
		
	//http://www.palash.co.in m/appapi1/payment_request?username=&pwd=&banktype=&amount=&txnid=&remark=
			if(isset($_GET['username']) && isset($_GET['pwd'])  && isset($_GET['banktype']) && isset($_GET['amount']) && isset($_GET['txnid']) && isset($_GET['remark'])  && isset($_GET['wallet_type']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$banktype =  $_GET['banktype'];
				$amount = $_GET['amount'];
				$txnid = $_GET['txnid'];
				$remark = $_GET['remark'];
				$wallet_type = $_GET['wallet_type'];
			}
			else if(isset($_POST['username']) && isset($_POST['pwd'])  && isset($_POST['banktype']) && isset($_POST['amount']) && isset($_POST['txnid']) && isset($_POST['remark'])  && isset($_POST['wallet_type']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
				$banktype =  $_POST['banktype'];
				$amount = $_POST['amount'];
				$txnid = $_POST['txnid'];
				$remark = $_POST['remark'];
				$wallet_type = $_POST['wallet_type'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
															
			
			$this->load->model("Do_recharge_model");	
			$this->load->model("Tblcompany_methods");
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$user_info = $this->db->query("select * from tblusers where username = ?  and password = ?",array($username,$pwd,$host_id));
                        //print_r($user_info->result());exit;
			if($user_info->num_rows() == 1)
			{
				$user_id = $user_info->row(0)->user_id;
			
					if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "Distributor" or $user_info->row(0)->usertype_name == "MasterDealer")
					{
						
						if($amount < 10)
						{	
						    $resparr = array(
							    "status"=>1,
							    "message"=>"Minimum amount 10 INR For Payment Request"
							    );
							echo json_encode($resparr);exit;
						}
						
						$banktype =	$banktype;
						$Amount = $amount;
						$txnid =$txnid;
						$remark = $remark;
					$checkexist = $this->db->query("select * from tblautopayreq where amount = ? and status = 'Pending' and wallet_type = ? and user_id = ? ",array($amount,$wallet_type,$user_id));
					if($checkexist->num_rows() == 1)
					{
					    $resparr = array(
							    "status"=>1,
							    "message"=>"The Payment Request With Same Amount Is Already Exist In The System"
							    );
						echo json_encode($resparr);exit;
					}
					else
					{
						$this->db->query("insert into tblautopayreq (user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,remark,wallet_type) values(?,?,?,?,?,?,?,?,?)",array($user_id,$amount,$banktype,$txnid,'Pending',$this->common->getDate(),$this->common->getRealIpAddr(),$remark,$wallet_type));
						
						 $resparr = array(
							    "status"=>0,
							    "message"=>"Your Payment Request Submited Successfully"
							    );
						echo json_encode($resparr);exit;
						//echo "Your Payment Request Submited Successfully";exit;
					}
						
					}	
					else
					{
					    $resparr = array(
							    "status"=>1,
							    "message"=>"Unauthorised Access"
							    );
						echo json_encode($resparr);exit;
					//	echo "Unauthorised Access";exit;
					}
			}
			else
			{
			        $resparr = array(
							    "status"=>1,
							    "message"=>"Unauthorised Access"
							    );
					//echo json_encode($resparr);exit;
			//	echo "Unauthorised Access";exit;
			}
	
	
	}
	

}