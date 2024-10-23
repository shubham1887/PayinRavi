<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_request_list extends CI_Controller {
	
	
	
	
	public function index() 
	{
	
		
	
			if(isset($_GET['username']) && isset($_GET['pwd']))
			{
				$username = $_GET['username'];
				$pwd =  $_GET['pwd'];
			
			}
			else if(isset($_POST['username']) && isset($_POST['pwd']))
			{
				$username = $_POST['username'];
				$pwd =  $_POST['pwd'];
			
			}
			else
			{echo 'Paramenter is missing';exit;}			
															
			
			$this->load->model("Do_recharge_model");	
			$this->load->model("Tblcompany_methods");
			$host_id = $this->Common_methods->getHostId($this->white->getDomainName());
			$user_info = $this->db->query("select * from tblusers where username = ?  and password = ? and host_id = ?",array($username,$pwd,$host_id));
                        //print_r($user_info->result());exit;
			if($user_info->num_rows() == 1)
			{
				$user_id = $user_info->row(0)->user_id;
			
					if($user_info->row(0)->usertype_name == "Agent" or $user_info->row(0)->usertype_name == "Distributor" or  $user_info->row(0)->usertype_name == "MasterDealer")
					{
						
						
						$checkexist = $this->db->query("select * from tblautopayreq where user_id = ? order by Id desc limit 20",array($user_id));
					
							$dataarr = array();
							foreach($checkexist->result() as $row)
							{
							
								if($row->payment_type == ""){$payment_type = "NOT SELECTED";}else {$payment_type = $row->payment_type ;}
								if($row->transaction_id == ""){$transaction_id = "NOT Entered";}else {$transaction_id = $row->transaction_id ;}
								if($row->remark == ""){$remark = "NO REMARK";}else {$remark = $row->remark ;}
								if($row->admin_remark == ""){$admin_remark = "NO REMARK";}else {$admin_remark = $row->admin_remark ;}
								
								
								
										$temparr = array(
														"id"=>$row->Id,
														"add_date"=>$row->add_date,
														"amount"=>$row->amount,
														"payment_type"=>$row->payment_type,
														"transaction_id"=>$row->transaction_id,
														"status"=>$row->status,
														"remark"=>$row->remark,
														"admin_remark"=>$row->admin_remark,
														"wallet_type"=>$row->wallet_type,
											
													);
										array_push($dataarr,$temparr);
								
							}
							
								$resp = array(
								"message"=>"Success",
								"status"=>0,
								"data"=>$dataarr
								);
								echo json_encode($resp);exit;
								
						
							
											
					}	
					else
					{
						echo "Unauthorised Access";exit;
					}
			}
			else
			{
				echo "Unauthorised Access";exit;
			}
	
	
	}
	

}