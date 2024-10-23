<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BalanceTransfer extends CI_Controller {
	private $msg='';
	function __construct()
    { 
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
		if ($this->session->userdata('ausertype') != "Admin") 
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

		if ($this->session->userdata('aloggedin') != TRUE) 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$data['message']='';				
			if($this->input->post("btnSubmit") == "Submit")
			{		
				
				$ency_hiduserid = $this->Common_methods->encrypt($this->input->post("hiduserid",TRUE));
				$ency_txtAmount = $this->Common_methods->encrypt($this->input->post("txtAmount",TRUE));	
				$ency_txtRemark = $this->Common_methods->encrypt($this->input->post("txtRemark",TRUE));	
				


				$hiduserid = $this->input->post("hiduserid",TRUE);
				$txtAmount = $this->input->post("txtAmount",TRUE);	
				$txtRemark = $this->input->post("txtRemark",TRUE);	

				$user_id = $this->Common_methods->decrypt($hiduserid);
				
				$result_user = $this->db->query("
				select 
					a.user_id,
					a.businessname,
					a.mobile_no,
					a.usertype_name,
					b.state_id,
					b.city_id,
					b.postal_address,
					b.pincode,
					b.aadhar_number,
					b.pan_no,
					b.gst_no,
					b.landline,
					b.emailid,
					b.contact_person,
					b.call_back_url,
					b.client_ip,
					b.client_ip2,
					b.client_ip3,
					b.client_ip4,
					a.dmr_group
					from tblusers a
					left join tblusers_info b on a.user_id = b.user_id
					where a.user_id=? and usertype_name = 'APIUSER'",array($user_id));	
					
					$this->view_data["result_user"] = $result_user;
					$this->view_data["amount"] = $txtAmount;
					$this->view_data["remark"] = $txtRemark;
					$this->view_data["encryptedid"] = $ency_hiduserid;
					$this->view_data["encryptedamount"] = $ency_txtAmount;
					$this->view_data["encryptedremark"] = $ency_txtRemark;
					
					$amountinwords = $this->convert_number($txtAmount);
					$this->view_data["amountinwords"] = $amountinwords;
					$this->load->view('_Admin/BalanceTransfer_confirm_view',$this->view_data);	
				
			}
			else if($this->input->post("btnSubmit") == "Confirm")
			{		
			
						
				$user_id = $this->Common_methods->decrypt($this->input->post("hiduserid",TRUE));
				$encr_hiduserid = $this->Common_methods->decrypt($this->Common_methods->decrypt($this->input->post("encr_hiduserid",TRUE)));
				$amount = $this->Common_methods->decrypt($this->input->post("encryptedamount",TRUE));
				$remark = $this->Common_methods->decrypt($this->input->post("encryptedremark",TRUE));
				if($amount > 0)
				{
					$result_user = $this->db->query("
					select 
						a.user_id,
						a.businessname,
						a.mobile_no,
						a.usertype_name,
						b.state_id,
						b.city_id,
						b.postal_address,
						b.pincode,
						b.aadhar_number,
						b.pan_no,
						b.gst_no,
						b.landline,
						b.emailid,
						b.contact_person,
						b.call_back_url,
						b.client_ip,
						b.client_ip2,
						b.client_ip3,
						b.client_ip4,
						a.dmr_group
						from tblusers a
						left join tblusers_info b on a.user_id = b.user_id
						where a.user_id=? and usertype_name = 'APIUSER'",array($user_id));	
						
						if($result_user->num_rows() == 1)	
						{
							$adminbalance_result = $this->db->query("select balance from tblewallet where user_id = 1 order by Id desc limit 1");
							if($adminbalance_result->num_rows() == 1)
							{
								$balance = $adminbalance_result->row(0)->balance;
								if($balance >= $amount)
								{
									$cr_user_id = $user_id;
									$debit_user_id = 1;
									$payment_type = "CASH";
									$description = "Admin To ".$result_user->row(0)->businessname."[".$result_user->row(0)->mobile_no."]";
									$resparray = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$debit_user_id,$amount,$remark,$description,$payment_type);
									if(isset($resparray["status"]) and isset($resparray["message"]) )
									{
										$status = $resparray["status"];
										$message = $resparray["message"];
										if($status == "0")
										{	
											$this->session->set_flashdata('MESSAGEBOXTYPE', "SUCCESS");
											$this->session->set_flashdata('MESSAGEBOX', $message);
											redirect(base_url()."_Admin/UserList");
										}
										else
										{
											$this->session->set_flashdata('MESSAGEBOXTYPE', "FAILURE");
											$this->session->set_flashdata('MESSAGEBOX', $message);
											redirect(base_url()."_Admin/UserList");
										}
										
									}
									else
									{
										$this->session->set_flashdata('MESSAGEBOXTYPE', "FAILURE");
										$this->session->set_flashdata('MESSAGEBOX', "Internal Server Error");
										redirect(base_url()."_Admin/UserList");
									}
									
									
								}
								else
								{
									$this->session->set_flashdata('MESSAGEBOXTYPE', "FAILURE");
									$this->session->set_flashdata('MESSAGEBOX', "InSufficient Balance");
									redirect(base_url()."_Admin/UserList");
								}
							}
							else
							{
								$this->session->set_flashdata('MESSAGEBOXTYPE', "FAILURE");
								$this->session->set_flashdata('MESSAGEBOX', "InSufficient Balance");
								redirect(base_url()."_Admin/UserList");
							}
							
						}
				}
				else
				{
				
				}
			}
			else
			{
			
			if(isset($_GET["cryptid"]))
			{
				$cryptuserid = trim($this->input->get("cryptid"));

				$user_id = $this->Common_methods->decrypt($cryptuserid);
				$result_user = $this->db->query("
				select 
					a.user_id,
					a.businessname,
					a.mobile_no,
					a.usertype_name,
					b.state_id,
					b.city_id,
					b.postal_address,
					b.pincode,
					b.aadhar_number,
					b.pan_no,
					b.gst_no,
					b.landline,
					b.emailid,
					b.contact_person,
					b.call_back_url,
					b.client_ip,
					b.client_ip2,
					b.client_ip3,
					b.client_ip4,
					a.dmr_group
					from tblusers a
					left join tblusers_info b on a.user_id = b.user_id
					where a.user_id=? and usertype_name = 'APIUSER'",array($user_id));	
					
					$this->view_data["result_user"] = $result_user;
					$this->load->view('_Admin/BalanceTransfer_view',$this->view_data);
			}
				
			}
		} 			
	}
	public function convert_number($number) 
	{ 
	
		if (($number < 0) || ($number > 999999999)) 
		{ 
		throw new Exception("Number is out of range");
		} 
	
		$Gn = floor($number / 1000000);  /* Millions (giga) */ 
		$number -= $Gn * 1000000; 
		$kn = floor($number / 1000);     /* Thousands (kilo) */ 
		$number -= $kn * 1000; 
		$Hn = floor($number / 100);      /* Hundreds (hecto) */ 
		$number -= $Hn * 100; 
		$Dn = floor($number / 10);       /* Tens (deca) */ 
		$n = $number % 10;               /* Ones */ 
	
		$res = ""; 
	
		if ($Gn) 
		{ 
			$res .= $this->convert_number($Gn) . " Million"; 
		} 
	
		if ($kn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				$this->convert_number($kn) . " Thousand"; 
		} 
	
		if ($Hn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				$this->convert_number($Hn) . " Hundred"; 
		} 
	
		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); 
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
			"Seventy", "Eigthy", "Ninety"); 
	
		if ($Dn || $n) 
		{ 
			if (!empty($res)) 
			{ 
				$res .= " and "; 
			} 
	
			if ($Dn < 2) 
			{ 
				$res .= $ones[$Dn * 10 + $n]; 
			} 
			else 
			{ 
				$res .= $tens[$Dn]; 
	
				if ($n) 
				{ 
					$res .= "-" . $ones[$n]; 
				} 
			} 
		} 
	
		if (empty($res)) 
		{ 
			$res = "zero"; 
		} 
	
		return $res; 
	} 
}
