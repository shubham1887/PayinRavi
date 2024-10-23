<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_request extends CI_Controller {
	

	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	public function index() 
	{
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 
      //  var_dump($this->session->userdata('aloggedin'));exit;
		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{
		//    echo "else";exit;
			if($this->input->post('btnSearch') == "Search")
			{
			    $host_id= $this->session->userdata("SdId");
				$this->load->model("Report");
				$from_date = $this->input->post("txtFrom",TRUE);
				$to_date = $this->input->post("txtTo",TRUE);
				$ddlbank = $this->input->post("ddlbank",TRUE);
				
				$this->view_data['result_mdealer'] = $this->db->query("
				select a.*,
				b.businessname,b.username 
				from tblautopayreq a
				left join tblusers b on a.user_id = b.user_id
				where 
			
				Date(a.add_date) >= ? and Date(a.add_date) <= ? and 
				a.status = 'Pending' and (b.usertype_name ='MasterDealer' or b.usertype_name ='Distributor') and b.host_id = ? and
				if(? != 'ALL',	a.payment_type like '%".$ddlbank."%',true)",array($from_date,$to_date,$host_id,$ddlbank));
				$this->view_data['message'] =$this->msg;
				$this->view_data['from'] =$from_date;
				$this->view_data['to'] =$to_date;
				$this->view_data['ddlbank'] =$ddlbank;
				$this->load->view('SuperDealer/payment_request_view',$this->view_data);	
			}					
			else
			{
				
						$today_date = $this->common->getMySqlDate();
						$this->view_data['result_mdealer'] = $this->db->query("
						select 
						a.*,
						b.businessname,
						b.username 
						from tblautopayreq a
						left join tblusers b on a.user_id = b.user_id 
						left join tblusers c on b.parentid = c.user_id
						where 
						a.status = 'Pending' and (b.usertype_name = 'MasterDealer' or b.usertype_name = 'Distributor') and b.host_id = ?",array($this->session->userdata("SdId")));
						$this->view_data['message'] =$this->msg;
						$this->view_data['from'] =$today_date;
						$this->view_data['to'] =$today_date;
						$this->view_data['ddlbank'] ="ALL";
						$this->load->view('SuperDealer/payment_request_view',$this->view_data);	
			
			}
		} 
	}	
	public function updaterequest()
	{
	    
		if($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			echo "exit"; exit;
		}
		if(isset($_GET["amount"]) and isset($_GET["txnPwd"]) and isset($_GET["ddlstatus"]) and isset($_GET["txtAdminRemark"]) and isset($_GET["hidid"]))
		{
			$hidid = trim($_GET["hidid"]);
		   
			$amount = trim($_GET["amount"]);
			$txnPwd = trim($_GET["txnPwd"]);
			$ddlstatus = trim($_GET["ddlstatus"]);
			$txtAdminRemark = trim($_GET["txtAdminRemark"]);
			if($amount >= 0)
			{
			
				if($ddlstatus == "Approve")
				{
					$rsltuserinfo = $this->db->query("select * from tblusers where usertype_name = 'SuperDealer' and user_id = ?",array($this->session->userdata("SdId")));
					if($rsltuserinfo->num_rows() == 1)
					{
					    
						$txn_password = $rsltuserinfo->row(0)->txn_password;
						if($txn_password == $txnPwd)
						{
						    
						    if($wallet_type == "Wallet2")
						    {
						        $sd_balance = $this->Ew2->getAgentBalance($this->session->userdata("SdId"));    
						    }
						    else
						    {
						        $sd_balance = $this->Common_methods->getAgentBalance($this->session->userdata("SdId"));
						    }
						    
						    
						    if($sd_balance >= $amount)
						    {
						        $payreqinfo = $this->db->query("select a.*,b.businessname,b.usertype_name,b.flatcomm from tblautopayreq a left join tblusers b on a.user_id = b.user_id 
						        where b.host_id = ? and  a.Id = ? ",array($this->session->userdata("SdId"),$hidid));
    							if($payreqinfo->num_rows() == 1)
    							{
    								$status = $payreqinfo->row(0)->status;
    								$rsamount = $payreqinfo->row(0)->amount;
    								$wallet_type = $payreqinfo->row(0)->wallet_type;
    								if($rsamount == $amount)
    								{
    									if($status == "Pending")
    									{
    										$user_id = $payreqinfo->row(0)->user_id;
    										$flatcomm = $payreqinfo->row(0)->flatcomm;
    										$usertype_name = $payreqinfo->row(0)->usertype_name;
    										$credit_user_id = $user_id;
    										$debit_user_id = $this->session->userdata("SdId");
    										$remark =$payreqinfo->row(0)->payment_type."  , ".$payreqinfo->row(0)->transaction_id." , ".$txtAdminRemark;
    										$description = "Admin To ".$payreqinfo->row(0)->businessname;
    										$payment_type = "CASH";
                                    		if(false)
                                    		{
                                    		    	echo "Duplicate Request";exit;	
                                    		}
                                    		else
                                    		{exit;
                                    		    
                                    		    if($wallet_type == "Wallet2")
                                    		    {
                                    		        
                                    		        if($this->Ew2->getAgentBalance($this->session->userdata("SdId"))  >= $amount )
                                    		        {
                                    		            $ewid = $this->Ew2->tblewallet_Payment_CrDrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type);    
                                    		        }
                                    		        
                                    		        
                                    		    }
                                    		    else
                                    		    {
                                    		         if($this->Common_methods->getAgentBalance($this->session->userdata("SdId"))  >= $amount )
                                    		         {
                                    		            $ewid = $this->Insert_model->tblewallet_Payment_CrDrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type);         
                                    		         }
                                    		    }
                                    		    
                                    		    
        										if($ewid > 0)
        										{
        											$this->db->query("update tblautopayreq set status = 'Approve',admin_remark = ? where Id= ?",array($txtAdminRemark,$hidid));
        											if($usertype_name == "MasterDealer" or $usertype_name == "Distributor")
        											{
        											    
        											    
        												if($flatcomm > 0 and $wallet_type == "Wallet1")
        												{
        												     $actfcom = ((floatval($amount) * $flatcomm)/100);
        												    if($this->Common_methods->getAgentBalance($this->session->userdata("SdId"))  >= $actfcom )
        												    {
        													    $this->Insert_model->tblewallet_Payment_CrDrEntry($credit_user_id,$debit_user_id,$actfcom,"Commission  ".$flatcomm." %",$description,$payment_type);    
        												    }
        													
        												}
        											}
        										
        											
        											echo "Fund Transfer Successfully";exit;	
        										}
        										else
        										{
        										    $this->db->query("delete from paymentrequest_locking where payment_request_id = ?",array($payreqinfo->row(0)->Id));
        											echo "Fund Transfer Failed";	
        										}
                                    		}
    										
    										
    									}
    									else
    									{
    										echo "Already Updated";exit;
    									}
    								}
    								else
    								{
    									echo "Confirm Amount Not Match";exit;
    								}
    							}
    							else
    							{
    								echo "Invalid Request";exit;
    							}   
						    }
						    else
						    {
						        echo "InSufficient Balance";exit;
						    }
						}
						else
						{
							echo "Invalid Password";exit;
						}
					}
				}
				else if($ddlstatus == "Reject")
				{
				   
					$rsltuserinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("SdId")));
					
					if($rsltuserinfo->num_rows() == 1)
					{
						$txn_password = $rsltuserinfo->row(0)->txn_password;
					
						if($txn_password == $txnPwd)
						{
							$payreqinfo = $this->db->query("select tblautopayreq.*,businessname from tblautopayreq,tblusers where tblusers.user_id = tblautopayreq.user_id and  Id = ?  and tblusers.host_id = ? ",array($hidid,$this->session->userdata("SdId")));
							if($payreqinfo->num_rows() == 1)
							{
								$status = $payreqinfo->row(0)->status;
								$rsamount = $payreqinfo->row(0)->amount;
								if($rsamount == $amount)
								{
									if($status == "Pending")
									{
										$this->db->query("update tblautopayreq set status = 'Reject',admin_remark = ? where Id= ?",array($txtAdminRemark,$hidid));
										$msg = 'Your request Rejected for Rs. '.$payreqinfo->row(0)->amount.' Transfer in '.$payreqinfo->row(0)->payment_type.'  with Ref./Branch '.$payreqinfo->row(0)->transaction_id."  With Admin Reason : ".$txtAdminRemark;
					//9137732050
									
										$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($payreqinfo->row(0)->user_id));
										$this->common->ExecuteSMSApi($userinfo->row(0)->mobile_no,$msg);
										echo "Payment Request Rejected";exit;
									}
									else
									{
										echo "Already Updated";exit;
									}
								}
								else
								{
									echo "Confirm Amount Not Match";exit;
								}
								
							}
							else
							{
								echo "Invalid Request";exit;
							}
						}
						else
						{
							echo "Invalid Password";exit;
						}
					}
				}
			}
			else
			{
				echo "Invalid Amount";exit;
			}
		}
		else
		{
			echo "invalid Input";exit;
		}
	}
	public function getDate()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$date = date("Y-m-d h:i");		
		return $date; 
	}
	public function checkduplicate($payment_request_id)
	{
		$add_date = $this->getDate();
		$ip ="asdf";
		$rslt = $this->db->query("insert into paymentrequest_locking (payment_request_id,add_date,ipaddress) values(?,?,?)",array($payment_request_id,$add_date,$this->common->getRealIpAddr()));
		  if($rslt == "" or $rslt == NULL)
		  {
			return false;
		  }
		  else
		  {
		  	return true;
		  }
	}
}