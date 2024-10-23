<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upi_callback extends CI_Controller {
	public function logentry($data)
	{

		$filename = "inlogs/upiresp.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
		write_file($filename." .\n", 'a+');
		write_file($filename, $this->common->getDate()."\n", 'a+');
		write_file($filename, $data."\n", 'a+');
		write_file($filename, $sapretor."\n", 'a+');
	}
	public function parsingdata()
	{
		$response = 'Amount=1, Status=SUCCESS, TransactionId=SBI8f64c8de5958401a992b67ab855904a1, TransactionRefId=TID1609234114249, ApprovalRefNo=, ResponseCode=UP00';
		$resp_array = explode(",",$response);
		if(count($resp_array) == 6)
		{
			$str_amount = $resp_array[0];
			$str_Status = $resp_array[1];
			$str_TransactionId = $resp_array[2];
			$str_TransactionRefId = $resp_array[3];
			$str_ApprovalRefNo = $resp_array[4];
			$str_ResponseCode = $resp_array[5];

			$amount = explode("=",$str_amount)[1];
			$Status = explode("=",$str_Status)[1];
			$TransactionId = explode("=",$str_TransactionId)[1];
			$TransactionRefId = explode("=",$str_TransactionRefId)[1];
			$ApprovalRefNo = explode("=",$str_ApprovalRefNo)[1];
			$ResponseCode = explode("=",$str_ResponseCode)[1];


			echo "Amount : ".$amount."<br>";
			echo "Status : ".$Status."<br>";
			echo "TransactionId : ".$TransactionId."<br>";
			echo "TransactionRefId : ".$TransactionRefId."<br>";
			echo "ApprovalRefNo : ".$ApprovalRefNo."<br>";
			echo "ResponseCode : ".$ResponseCode."<br>";



		}
	}
	


	public function index()
	{ 


		$data = json_encode($this->input->get());
		$this->logentry($data);
	/*
{
	"username":"1684684515",
	"pwd":"261279",
	"amount":"1",
	"response":"Amount=1, Status=Success, TransactionId=YBLb2de68dfdfb54fc583ae02f2e5fe14f0, TransactionRefId=TID1608792331242, ApprovalRefNo=null, ResponseCode=00",
	"remark":"YBLb2de68dfdfb54fc583ae02f2e5fe14f0"}
	*/
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			if(isset($_GET['username']) && isset($_GET['pwd']) && isset($_GET['amount'])  && isset($_GET['response']) && isset($_GET['remark']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
				$amount =  $_GET['amount'];
				$response =  $_GET['response'];
				$remark =  $_GET['remark'];
			}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['username']) && isset($_POST['pwd']))
			{$username = $_POST['username'];$pwd =  $_POST['pwd'];}
			else
			{echo 'Paramenter is missing';exit;}			
		}
		else
		{
			echo 'Paramenter is missing';exit;
		}



			$host_id =1;
		$userinfo = $this->db->query("select a.mobile_no,a.user_id,a.businessname,a.username,a.status,a.usertype_name,info.birthdate,a.flatcomm
		from tblusers  a 
		left join tblusers_info info on a.user_id = info.user_id
		where 
		a.username = ? and 
		a.password = ? 
		and a.host_id = ?",array($username,$pwd,$host_id));
		if($userinfo->num_rows() == 1)
		{
			$status = $userinfo->row(0)->status;
			$flatcomm = $userinfo->row(0)->flatcomm;
			$user_id = $userinfo->row(0)->user_id;
			$business_name = $userinfo->row(0)->businessname;
			$username = $userinfo->row(0)->username;
			$usertype_name = $userinfo->row(0)->usertype_name;
			$birthdate = $userinfo->row(0)->birthdate;
			if($status == '1')
			{

				$commonrslt = $this->db->query("select * from admininfo where param = 'UPI_BALANCE'");
				if($commonrslt->num_rows() == 1)
				{
					$upi_balance_flag = $commonrslt->row(0)->value;

					if($upi_balance_flag == "AUTO")
					{

						

						$resp_array = explode(",",$response);

						if(count($resp_array) == 6)
						{
							$str_amount = $resp_array[0];
							$str_Status = $resp_array[1];
							$str_TransactionId = $resp_array[2];
							$str_TransactionRefId = $resp_array[3];
							$str_ApprovalRefNo = $resp_array[4];
							$str_ResponseCode = $resp_array[5];

							$resp_amount = explode("=",$str_amount)[1];
							$resp_Status = explode("=",$str_Status)[1];
							$resp_TransactionId = explode("=",$str_TransactionId)[1];
							$resp_TransactionRefId = explode("=",$str_TransactionRefId)[1];
							$resp_ApprovalRefNo = explode("=",$str_ApprovalRefNo)[1];
							$resp_ResponseCode = explode("=",$str_ResponseCode)[1];


							// echo "Amount : ".$amount."<br>";
							// echo "Status : ".$Status."<br>";
							// echo "TransactionId : ".$TransactionId."<br>";
							// echo "TransactionRefId : ".$TransactionRefId."<br>";
							// echo "ApprovalRefNo : ".$ApprovalRefNo."<br>";
							// echo "ResponseCode : ".$ResponseCode."<br>";



							if($resp_Status == "SUCCESS" or $resp_Status == "Success")
							{


								if($amount == $resp_amount)
								{
									$cr_user_id = $user_id;
			    				    $dr_user_id = 1;
			    					$description = "UPI::Admin To ".$userinfo->row(0)->businessname;
			    					$ddlpaymentType = "UPI";
			    					$admin_remark = "Auto Payment By UPI";
			    					$is_revert = false;
			    					$payment_received = $amount;
			    					$acc_parent_id = 1;
			    					$acc_child_id = $user_id;
			    					$txtRemark = "UPI TXN Id : ".$resp_TransactionId;


			    					$ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$amount,$txtRemark,$description,$ddlpaymentType,$admin_remark,$is_revert,$payment_received,$acc_parent_id,$acc_child_id);
			    					if($ewrslt == true)
			    					{
			    					    $this->load->model("Sms");
			                			$this->Sms->receiveBalance($userinfo,$amount);
			                			//if($chkflatcomm == "yes")
			                			if(true)
			                			{
			                			    $flatcom = floatval($userinfo->row(0)->flatcomm);
			                    			$usertype_name = $userinfo->row(0)->usertype_name;
			                    			if($usertype_name == "Agent" or $usertype_name == "MasterDealer" or $usertype_name == "Distributor" or $usertype_name == "SuperDealer")
			                    			{
			                    				if($flatcom > 0)
			                    				{
			                    					$actfcom = ((floatval($amount) * $flatcom)/100);
			                    					$this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$actfcom,"Commission  ".$flatcom." %",$description,$ddlpaymentType,"UPI AUTO COMMISSION");
			                    				}
			                    			}
			                			}
			                			$resparray = array(
										'status'=>0,
										'message'=>'Payment Updated Successfully'
										);
										echo json_encode($resparray);exit;  
			    					    
			    					}



								}
								else
								{
									$resparray = array(
									'status'=>0,
									'message'=>'Response Received Successfully 1'
									);
									echo json_encode($resparray);exit;  
								}
							}

						}










					}
				}


			 	$resparray = array(
				'status'=>0,
				'message'=>'Response Received Successfully 2'
				);
				echo json_encode($resparray);exit;  
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
