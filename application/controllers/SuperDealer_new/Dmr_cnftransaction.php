<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr_cnftransaction extends CI_Controller {


	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('SdUserType') != "SuperDealer") 
{ 
redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
}
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
    }
	 public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	public function index()
	{	
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$user_id = $this->session->userdata("SdId");
			$MTLOGIN = $this->session->userdata("MTLOGIN");
			$MTSENDERMOBILE = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
			$MTSdId = $this->Common_methods->decrypt($this->session->userdata("MTSdId"));
			$REMITTERID = $this->Common_methods->decrypt($this->session->userdata("REMITTERID"));
			
			
			if($MTLOGIN == true and $MTSdId == $user_id and strlen($MTSENDERMOBILE) == 10)
			{
				$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("SdId") ));
				if($mt_rslt->num_rows() == 1)
				{
					$mtaccess = $mt_rslt->row(0)->mt_access;
					if($mtaccess == '1')
					{
						$user=$this->session->userdata('SdUserType');			
						if(trim($user) == 'MasterDealer')
						{
							$txtNumber = $MTSENDERMOBILE;
							$user_id = $this->session->userdata("SdId");
							$userinfo = $this->db->query("select user_id,parentid,businessname,username,status,usertype_name,emailid,mobile_no from tblusers where user_id = ?",array($user_id));
							if($userinfo->num_rows() == 1)
							{
								$status = $userinfo->row(0)->status;
								$user_id = $userinfo->row(0)->user_id;
								$businessname = $userinfo->row(0)->businessname;
								$username = $userinfo->row(0)->username;
								$emailid = $userinfo->row(0)->emailid;
								$mobile_no = $userinfo->row(0)->mobile_no;
								$usertype_name = $userinfo->row(0)->usertype_name;
								if($status == '1')
								{
									if(ctype_digit($txtNumber))
									{
										
										
										
										if(isset($_POST["crypt_d7"]) and isset($_POST["crypt_d8"]) and isset($_POST["crypt_d9"]) and isset($_POST["crypt_d10"]) and isset($_POST["crypt_d11"]))
										{
											
											$hidencrdata =  $this->Common_methods->decrypt($this->input->post("hidencrdata"));
											$formaction = $this->input->post("formaction");
											
											
											if($formaction == "CNFTXN")
											{
												$txtBeneId = $this->Common_methods->decrypt($this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d7")))));
												$txtRemitterId =  $this->Common_methods->decrypt($this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d8")))));
												$txtTransType =  $this->Common_methods->decrypt($this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d9")))));
												$txtAmount =  $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d10"))));
												$txtRemark =  $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($this->input->post("crypt_d11"))));
												
												$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where remitterid = ? and RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1",array(
																	$txtRemitterId,$txtBeneId));
												if($checkbeneexist->num_rows() > 0)
												{
												
													
												
													$this->load->model("Instapay");
													$resparray = array();
													
													$amounts_arr = $this->getamountarray(intval($txtAmount));
													
													$whole_amount = intval($txtAmount);
													$data = array(
															'user_id' => $user_id,
															'add_date'  => $this->common->getDate(),
															'ipaddress'  => $this->common->getRealIpAddr(),
															'whole_amount'  => $whole_amount,
															'fraction_json'  =>json_encode($amounts_arr),
															'remitter_id'  => $REMITTERID ,
															'remitter_mobile'  => $MTSENDERMOBILE,
															'remitter_name'  => '',
															'account_no'  => $checkbeneexist->row(0)->benificiary_account_no,
															'ifsc'  => $checkbeneexist->row(0)->benificiary_ifsc,
															'bene_name'  => $checkbeneexist->row(0)->benificiary_name,
															'bene_id'  => $checkbeneexist->row(0)->RESP_beneficiary_id,
													);
													$insertresp = $this->db->insert('mt3_uniquetxnId', $data);
													if($insertresp == true)
													{
														$unique_id =  $this->db->insert_id();
														foreach($amounts_arr as $amt)
														{
															$beneficiaryid = $txtBeneId;
															$amount = $amt;
															$mode = $txtTransType;
															
															$resp =  $this->Instapay->transfer($MTSENDERMOBILE,$txtBeneId,$amt,$mode,$userinfo,$unique_id);	
															array_push($resparray,$resp);
														}
														$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
														$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Transaction Done Successfully");
														redirect(base_url()."Retailer/dmr_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));	
													}
													else
													{
														$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
														$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Data Insertion Error");
														redirect(base_url()."Retailer/dmr_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));	
													}
													
													
												}
												else
												{
													$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
													$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Beneficiary Data");
													redirect(base_url()."Retailer/dmr_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));	
												}	
												
												
												
												
											}
										}
										else if(isset($bene_id) and isset($remitter_id) and isset($transtype) and isset($Amount) and isset($Remark))
										{
											$txtBeneId = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($bene_id)));
											$txtRemitterId = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($remitter_id)));
											$txtTransType = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($transtype)));
											$txtAmount = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($Amount)));
											$txtRemark = $this->Common_methods->decrypt($this->Common_methods->decrypt(trim($Remark)));
											
											
											$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where remitterid = ? and RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1",array(
																	$txtRemitterId,$txtBeneId));
											if($checkbeneexist->num_rows() > 0)
											{
												$formaction = trim($this->input->post("formaction"));
												$hidencrdata = trim($this->input->post("hidencrdata"));
												$txtAmount = floatval(trim($this->input->post("txtAmount")));
												$txtRemark = trim($this->input->post("txtRemark"));
												
												$this->load->view("SuperDealer_new/dmr_cnftransaction_view",$this->view_data);
												
												
												$this->view_data["benedata"] = $checkbeneexist;
												$this->view_data["remitter_id"] = trim($this->input->post("crypt_d2"));
												$this->view_data["bene_id"] = trim($this->input->post("crypt_d1"));
												$this->view_data["transtype"] = trim($this->input->post("crypt_d3"));
												$this->load->view("SuperDealer_new/dmr_transaction_view",$this->view_data);
												
											}
											else
											{
												$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
												$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Beneficiary Data");
												redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));	
											}	
											
											
											
											
										}
										else
										{
											$this->view_data["message"] = "";
											$this->load->view("SuperDealer_new/dmr_transaction_view",$this->view_data);
										}	
									}
									else
									{
										$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
										$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Internal Server Error. Please Try Later...");
										redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));	
									}
								}
								else
								{
									$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
									$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Your Account Deactivated By Admin");
									redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));
								}
							}
							else
							{
								$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
								$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Session Expired. Please try Login Again");
								redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"));
							}
						} 
					}
					else
					{
						$this->session->set_userdata("MTLOGIN",false);
						$this->session->set_userdata("MTSENDERMOBILE","");
						$this->session->set_userdata("MTSdId","");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
						$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
						redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
					}
				}
				else
				{
					$this->session->set_userdata("MTLOGIN",false);
					$this->session->set_userdata("MTSENDERMOBILE","");
					$this->session->set_userdata("MTSdId","");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
					redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			else
			{
				$this->session->set_userdata("MTLOGIN",false);
				$this->session->set_userdata("MTSENDERMOBILE","");
				$this->session->set_userdata("MTSdId","");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: User Data Not Match");
				redirect(base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("Mydata"));
			}
		
			
			
			
			
			
		}
	}
	public function getAccountvalidate()
	{
		$user_id = $this->session->userdata("SdId");
		$MTLOGIN = $this->session->userdata("MTLOGIN");
		$MTSENDERMOBILE = $this->Common_methods->decrypt($this->session->userdata("MTSENDERMOBILE"));
		$MTSdId = $this->Common_methods->decrypt($this->session->userdata("MTSdId"));
		if(isset($_POST["bid"]))
		{
			$beneid = trim($_POST["bid"]);
			$checkbeneexist = $this->db->query("select * from mt3_beneficiary_register_temp 
																	where RESP_beneficiary_id = ? and status = 'SUCCESS' 
																	order by Id desc limit 1",array(
																	$beneid));
			if($checkbeneexist->num_rows() > 0)
			{
				$remittermobile = $MTSENDERMOBILE;
				$remitter_id = $checkbeneexist->row(0)->RESP_remitter_id;
				$benificiary_account_no = $checkbeneexist->row(0)->benificiary_account_no;
				$benificiary_ifsc = $checkbeneexist->row(0)->benificiary_ifsc;
				$userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
				$this->load->model("Instapay");
				echo $this->Instapay->account_validate($remitter_id,$remittermobile,$benificiary_account_no,$benificiary_ifsc,$userinfo);
			}
			else
			{
				$resp_arr = array(
										"message"=>"Beneficiary Not Found",
										"status"=>1,
										"statuscode"=>"RNF",
									);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}
		}
		else
		{
				$resp_arr = array(
										"message"=>"Invalid Operation",
										"status"=>1,
										"statuscode"=>"ERR",
									);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
		}
	}
	private function getamountarray($Amount)
	{
		$maxamount = 5000;
		$AmountArray = array();
		$n= $Amount / $maxamount;
		if($n < 1)
		{
			$AmountArray[0] = $Amount;
			return $AmountArray;
		}
		else if($n == 1)
		{
			$AmountArray[0] = $Amount;
			return $AmountArray;
		}
		else if($n < 2)
		{
			$i = 1;
			$sctamt = $n - $i;
			$part1 = $maxamount * $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $part1;
			$AmountArray[1] = $part2;
			return $AmountArray;
			
		}
		else if($n == 2)
		{
			$i = 2;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			return $AmountArray;
		}
		else if($n < 3)
		{
			$i = 2;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $part2;
			return $AmountArray;
			
		}
		else if($n == 3)
		{
			$i = 3;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			return $AmountArray;
		}
		else if($n < 4)
		{
			$i = 3;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $part2;
			return $AmountArray;
			
		}
		else if($n == 4)
		{
			$i = 4;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			return $AmountArray;
		}
		else if($n < 5)
		{
			$i = 4;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $part2;
			return $AmountArray;
			
		}
		else if($n == 5)
		{
			$i = 5;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			return $AmountArray;
		}
		
		else if($n < 6)
		{
			$i = 5;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $part2;
			return $AmountArray;
			
		}
		else if($n == 6)
		{
			$i = 6;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			return $AmountArray;
		}
		
		
		
		
		
		
		
		else if($n < 7)
		{
			$i = 6;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $part2;
			return $AmountArray;
			
		}
		else if($n == 7)
		{
			$i = 7;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			return $AmountArray;
		}
		else if($n < 8)
		{
			$i = 7;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $part2;
			return $AmountArray;
			
		}
		else if($n == 8)
		{
			$i = 8;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			return $AmountArray;
		}
		else if($n < 9)
		{
			$i = 8;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $part2;
			return $AmountArray;
			
		}
		else if($n == 9)
		{
			$i = 9;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			return $AmountArray;
		}
		else if($n < 10)
		{
			$i = 9;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $part2;
			return $AmountArray;
			
		}
		else if($n == 10)
		{
			$i = 10;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			return $AmountArray;
		}
		else if($n < 11)
		{
			$i = 10;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $part2;
			return $AmountArray;
			
		}
		else if($n == 11)
		{
			$i = 11;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			return $AmountArray;
		}
		else if($n < 12)
		{
			$i = 11;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $part2;
			return $AmountArray;
			
		}
		else if($n == 12)
		{
			$i = 12;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $maxamount;
			return $AmountArray;
		}
		else if($n < 13)
		{
			$i = 12;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $maxamount;
			$AmountArray[12] = $part2;
			return $AmountArray;
			
		}
		else if($n == 13)
		{
			$i = 13;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $maxamount;
			$AmountArray[12] = $maxamount;
			return $AmountArray;
		}
		else if($n < 14)
		{
			$i = 13;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $maxamount;
			$AmountArray[12] = $maxamount;
			$AmountArray[13] = $part2;
			return $AmountArray;
			
		}
		else if($n == 14)
		{
			$i = 14;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $maxamount;
			$AmountArray[12] = $maxamount;
			$AmountArray[13] = $maxamount;
			return $AmountArray;
		}
		else if($n < 15)
		{
			$i = 14;
			$sctamt = $n - $i;
			$part2 = $sctamt * $maxamount;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $maxamount;
			$AmountArray[12] = $maxamount;
			$AmountArray[13] = $maxamount;
			$AmountArray[14] = $part2;
			return $AmountArray;
			
		}
		else if($n == 15)
		{
			$i = 15;
			$AmountArray[0] = $maxamount;
			$AmountArray[1] = $maxamount;
			$AmountArray[2] = $maxamount;
			$AmountArray[3] = $maxamount;
			$AmountArray[4] = $maxamount;
			$AmountArray[5] = $maxamount;
			$AmountArray[6] = $maxamount;
			$AmountArray[7] = $maxamount;
			$AmountArray[8] = $maxamount;
			$AmountArray[9] = $maxamount;
			$AmountArray[10] = $maxamount;
			$AmountArray[11] = $maxamount;
			$AmountArray[12] = $maxamount;
			$AmountArray[13] = $maxamount;
			$AmountArray[14] = $maxamount;
			return $AmountArray;
		}
		
		
		
		
		
		
		
		
	}
}	