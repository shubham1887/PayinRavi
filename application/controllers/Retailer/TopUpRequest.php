<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TopUpRequest extends CI_Controller {
	
	
	private $msg='';
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('AgentUserType') != "Agent") 
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
	public function TopUpRequestBanks()
	{
		header('Content-Type: application/json');
	//	header('Content-Type: application/json')

		if(isset($_POST["requestUser"]))
		{
			$requestUser = trim($this->input->post("requestUser"));
		}


		$rsltbanks = $this->db->query("select 

			'' as ImageUrl,
			CONCAT(b.bank_name,'-',a.account_number,'-',a.ifsc,'-',a.account_name) as BankDetails,
			'' as ReferenceNo,
			a.Id as ReferenceCode,
			b.bank_name as BankName,
			a.account_name as HolderName,
			a.account_number as AccountNo,
			a.ifsc as IFSCCode,
			a.branch as BranchName,
			'' as BankImage,
			a.Id,a.bank_id,a.account_name,a.account_number,a.ifsc,a.branch,a.add_date,b.bank_name from creditmaster_banks a left join tblbank b on a.bank_id = b.bank_id order by a.Id");
		echo json_encode($rsltbanks->result());exit;

	}
	public function index() 
	{
		
	
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		}				
		else 		
		{ 	

				if(
					isset($_POST["WalletType"]) and 
					isset($_POST["PaymentMode"]) and 
					isset($_POST["BankName"]) and 
					isset($_POST["RequestUserID"]) and 
					isset($_POST["CashType"]) and 
					isset($_POST["PaymentAmount"]) and 
					isset($_POST["UserBankName"]) and 
					isset($_POST["BranchName"]) and 
					isset($_POST["ChequeNo"]) and 
					isset($_POST["BranchCode"]) and 
					isset($_POST["TransactionNo"]) and 
					isset($_POST["Location"]) and 
					isset($_POST["PaymentDate"]) and 
					isset($_POST["PaymentTime"]) and 
					isset($_POST["UTRNumber"])
				)
				{
					$WalletType = $this->input->post("WalletType");
					$PaymentMode = $this->input->post("PaymentMode");
					$BankName = $this->input->post("BankName");
					$RequestUserID = $this->input->post("RequestUserID");
					$CashType = $this->input->post("CashType");
					$PaymentAmount = $this->input->post("PaymentAmount");
					$UserBankName = $this->input->post("UserBankName");
					$BranchName = $this->input->post("BranchName");
					$ChequeNo = $this->input->post("ChequeNo");
					$BranchCode = $this->input->post("BranchCode");
					$TransactionNo = $this->input->post("TransactionNo");
					$Location = $this->input->post("Location");
					$PaymentDate = $this->input->post("PaymentDate");
					$PaymentTime = $this->input->post("PaymentTime");
					$UTRNumber = $this->input->post("UTRNumber");
					$user_id = $this->session->userdata("AgentId");

					$image_url = "";
					if (is_uploaded_file($_FILES['TransactionSlip']['tmp_name'])) 
            	    {
            	        
            	        $file_ext=strtolower(end(explode('.',$_FILES['TransactionSlip']['name'])));
                        $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG");
                        if(in_array($file_ext,$expensions)=== false)
                        {
                            
                        }
                        else
                        {
                            $response .= "\nFile Found";
                            if (!file_exists('uploads/'.$this->common->getMySqlDate())) 
                            {
                                mkdir('uploads/'.$this->common->getMySqlDate(), 0777, true);
                            }
                            $uploads_dir = "uploads/".$this->common->getMySqlDate()."/".$user_id.$this->common->getDate().$_FILES["TransactionSlip"]["name"];
                            $tmp_name = $_FILES['TransactionSlip']['tmp_name'];
                            $pic_name = $_FILES['TransactionSlip']['name'];
                            $response .= "\nFile Name : ".$_FILES['TransactionSlip']['name'];
                            move_uploaded_file($tmp_name, $uploads_dir);
                            $response .= "\nFile Uploaded Successfully to the server";
                            $image_url = $uploads_dir;
                        }     
                    }
					$user_id = $this->session->userdata("AgentId");
					if($RequestUserID == 1 or $RequestUserID == $this->session->userdata("DistParentId"))
					{
						$Amount = floatval($PaymentAmount);
						if($Amount > 0)
						{
									$insert_data = $this->db->query("insert into tblautopayreq(user_id,amount,payment_type,transaction_id,status,add_date,ipaddress,client_remark,wallet_type,image_url,host_id,admin_bank_account_id,CashType,UserBank,BranchName,ChequeNo,BranchCode,Location,request_to_user_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
										array($user_id,$Amount,$PaymentMode,$TransactionNo.'-'.$UTRNumber,"Pending",$this->common->getDate(),$this->common->getRealIpAddr(),"",$WalletType,$image_url,1,$BankName,$CashType,$UserBankName,$BranchName,$ChequeNo,$BranchCode,$Location,$RequestUserID));
									if($insert_data == true)
									{
										$this->session->set_flashdata('MESSAGEBOXTYPE', "success");
										$this->session->set_flashdata('MESSAGEBOX', "Request Submitted Successfully");
										redirect(base_url()."Retailer/TopUpRequest");
									}
									else
									{
										$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
										$this->session->set_flashdata('MESSAGEBOX', "Some Error Occured.Please Try Again");
										redirect(base_url()."Retailer/TopUpRequest");
									}
						}
						else
						{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
								$this->session->set_flashdata('MESSAGEBOX', "Invalid Amount Entered");
								redirect(base_url()."Retailer/TopUpRequest");
						}
					}
					else
					{
						$this->session->set_flashdata('MESSAGEBOXTYPE', "error");
						$this->session->set_flashdata('MESSAGEBOX', "Invalid Action");
						redirect(base_url()."Retailer/TopUpRequest");
					}


				}
				else
				{
					$userinfo = $this->db->query("
								SELECT businessname,user_id,Date(add_date) as add_date,mobile_no,status,kyc FROM tblusers where user_id = ?",array($this->session->userdata("AgentId")));
					//print_r($mycomm->result());exit;
					$this->view_data['myinfo'] = $userinfo;
					$this->view_data['message'] =$this->msg;
			
			
					$this->load->view('Retailer/TopUpRequest_view',$this->view_data);	
				}
		}
				
	}	
	
}