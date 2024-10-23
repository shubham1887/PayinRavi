<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_cnftransaction extends CI_Controller {


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
	public function checkduplicate($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$type)
{
	$add_date = $this->getDate();
	$ip ="asdf";
	$rslt = $this->db->query("insert into mtstopduplication	 (Amount,user_id,RemitterCode,BeneficiaryCode,add_date,type) values(?,?,?,?,?,?)",array($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$add_date,$type));
	  if($rslt == "" or $rslt == NULL)
	  {
	  	//$this->logentry($add_date,$number,$user_id);
		return false;
	  }
	  else
	  {
	  	return true;
	  }
}
public function logentry($add_date,$number,$user_id)
{
	/*$filename = "duplicate_entry.txt";
	if (!file_exists($filename)) 
	{
		file_put_contents($filename, '');
	} 
	$this->load->library("common");

	$this->load->helper('file');
	$sapretor = "------------------------------------------------------------------------------------";
	
write_file($filename." .\n", 'a+');
write_file($filename, $add_date."\n", 'a+');
write_file($filename, "web Number : ".$number."\n", 'a+');
write_file($filename, "User Id : ".$user_id."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');*/
}
public function getDate()
{
	putenv("TZ=Asia/Calcutta");
	date_default_timezone_set('Asia/Calcutta');
	$date = date("Y-m-d h");		
	return $date; 
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
	  // $this->db->db_debug = TRUE;
	  // error_reporting(-1);
	   //ini_set("display_errors",1);
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache"); 
		if ($this->session->userdata('SdUserType') != "SuperDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
			$MTLOGIN = $this->session->userdata("MT_LOGGED_IN");
			$MTSENDERMOBILE = $this->session->userdata("SenderMobile");
			$MTSdId = $this->session->userdata("MT_USER_ID");
			$user_id = $this->session->userdata("SdId");
			
			
			if($MTLOGIN == true and $MTSdId == $user_id and strlen($MTSENDERMOBILE) == 10)
			{
			    $mt_rslt = 	$userinfo = $this->db->query("select a.user_id,a.businessname,a.username,a.status,a.usertype_name,a.mobile_no,a.parentid,a.mt_access,a.txn_password,a.service,p.client_ip as mastermoney from tblusers a left join tblusers p on a.parentid = p.user_id where a.user_id = ?",array($user_id));
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
						//	$userinfo = $this->db->query("select user_id,parentid,businessname,username,status,usertype_name,mobile_no from tblusers where user_id = ?",array($user_id));
							if($userinfo->num_rows() == 1)
							{
							    $is_mastermoney = $userinfo->row(0)->mastermoney;
								$status = $userinfo->row(0)->status;
								$user_id = $userinfo->row(0)->user_id;
								$businessname = $userinfo->row(0)->businessname;
								$username = $userinfo->row(0)->username;
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
												
												$checkbeneexist = $this->db->query("select a.benificiary_account_no,a.benificiary_ifsc,a.benificiary_name,a.RESP_beneficiary_id,a.bank_id
from mt3_beneficiary_register_temp a 
left join dmr_banks b on a.bank_id = b.Id
where a.remitter_mobile = ? and a.RESP_beneficiary_id = ? and a.status = 'SUCCESS' and a.API = 'MASTERMONEY'
																	order by a.Id desc limit 1",array(
																	$txtRemitterId,$txtBeneId));
											
												if($checkbeneexist->num_rows() > 0)
												{
												
													if($this->checkduplicate($txtAmount,$user_id,$MTSENDERMOBILE, $checkbeneexist->row(0)->RESP_beneficiary_id,"IMPS"))
											//	if(true)
													{
													    
													   $checktransaction = $this->db->query("SELECT Id,add_date FROM mt3_uniquetxnid where user_id = ? and remitter_mobile = ? and account_no = ? and whole_amount = ? and Date(add_date) = ?",
													    array($user_id,$txtRemitterId,$checkbeneexist->row(0)->benificiary_account_no,$txtAmount,$this->common->getMySqlDate()));
                    								    
													    if($checktransaction->num_rows() == 1)
                    								    {
                    								        $last_txn_date = $checktransaction->row(0)->add_date;
                    								        $current_datetime = $this->common->getDate();
                    								        $diff = $this->Update_methods->gethoursbetweentwodates($last_txn_date,$current_datetime);
                    								        if($diff <= 60)
                    								        {
                    								            $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
            													$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Duplicate Entry");
            													redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
            													return "";
                    								        }
                    								    }
													    
													    
														$this->load->model("Mastermoney");
														$resparray = array();
														$amounts_arr = $this->getamountarray(intval($txtAmount));
														
														$whole_amount = intval($txtAmount);
													if($whole_amount <= 25000 and $whole_amount > 0)
													{
													    $data = array(
																'user_id' => $user_id,
																'add_date'  => $this->common->getDate(),
																'ipaddress'  => $this->common->getRealIpAddr(),
																'whole_amount'  => $whole_amount,
																'fraction_json'  =>json_encode($amounts_arr),
																'remitter_id'  => $MTSENDERMOBILE ,
																'remitter_mobile'  => $MTSENDERMOBILE,
																'remitter_name'  => '',
																'account_no'  => $checkbeneexist->row(0)->benificiary_account_no,
																'ifsc'  => $checkbeneexist->row(0)->benificiary_ifsc,
																'bene_name'  => $checkbeneexist->row(0)->benificiary_name,
																'bene_id'  => $checkbeneexist->row(0)->RESP_beneficiary_id,
																'API'  => 'MASTERMONEY',
																'bank_id'  => $checkbeneexist->row(0)->bank_id,
    														);
    														$insertresp = $this->db->insert('mt3_uniquetxnid', $data);
    														if($insertresp == true)
    														{
    															$unique_id =  $this->db->insert_id();
    															foreach($amounts_arr as $amt)
    															{
    																$beneficiaryid = $txtBeneId;
    																$amount = $amt;
    																$mode = $txtTransType;
    																
    																
    																
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                                    
    																
    															
            													   $resp =  $this->Mastermoney->transfer2($MTSENDERMOBILE,$txtBeneId,$amt,$mode,$userinfo,$unique_id,"WEB",$checkbeneexist->row(0)->bank_id,$whole_amount);
            														
    																array_push($resparray,$resp);
    															}
    															$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
    															$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Transaction Done Successfully");
    															redirect(base_url()."Retailer/dmrmm_finalpage?crypt=".$this->Common_methods->encrypt($unique_id));
    															//redirect(base_url()."Retailer/dmrmm_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));	
    														}
    														else
    														{
    															$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
    															$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Data Insertion Error");
    															redirect(base_url()."Retailer/dmrmm_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));	
    														}
													}
													else
													{
													    $this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
														$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Amount");
														redirect(base_url()."Retailer/dmrmm_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));
													}
                    									    
                    									
													}
													else
													{
													$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
													$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Duplicate Entry");
													redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
													}
												
												
													
													
													
												}
												else
												{
													$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
													$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Beneficiary Data");
													redirect(base_url()."Retailer/dmrmm_dashboard?crypt=".$this->Common_methods->encrypt("MyData"));	
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
																	where remitter_mobile = ? and RESP_beneficiary_id = ? and status = 'SUCCESS'  and API = 'MASTERMONEY'
																	order by Id desc limit 1",array(
																	$txtRemitterId,$txtBeneId));
											if($checkbeneexist->num_rows() > 0)
											{
												$formaction = trim($this->input->post("formaction"));
												$hidencrdata = trim($this->input->post("hidencrdata"));
												$txtAmount = floatval(trim($this->input->post("txtAmount")));
												$txtRemark = trim($this->input->post("txtRemark"));
												
												$this->load->view("SuperDealer_new/dmrmm_cnftransaction_view",$this->view_data);
												
												
												$this->view_data["benedata"] = $checkbeneexist;
												$this->view_data["remitter_id"] = trim($this->input->post("crypt_d2"));
												$this->view_data["bene_id"] = trim($this->input->post("crypt_d1"));
												$this->view_data["transtype"] = trim($this->input->post("crypt_d3"));
												$this->load->view("SuperDealer_new/dmrmm_transaction_view",$this->view_data);
												
											}
											else
											{
												$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
												$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Beneficiary Data");
												redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
											}	
											
											
											
											
										}
										else
										{
											$this->view_data["message"] = "";
											$this->load->view("SuperDealer_new/dmrmm_transaction_view",$this->view_data);
										}	
									}
									else
									{
										$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
										$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Internal Server Error. Please Try Later...");
										redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));	
									}
								}
								else
								{
									$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
									$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Your Account Deactivated By Admin");
									redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
								}
							}
							else
							{
								$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
								$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Session Expired. Please try Login Again");
								redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
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
						redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
					}
				}
				else
				{
					$this->session->set_userdata("MTLOGIN",false);
					$this->session->set_userdata("MTSENDERMOBILE","");
					$this->session->set_userdata("MTSdId","");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Unauthorized Access");
					redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
			}
			else
			{
				$this->session->set_userdata("MTLOGIN",false);
				$this->session->set_userdata("MTSENDERMOBILE","");
				$this->session->set_userdata("MTSdId","");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
				$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: User Data Not Match");
				redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("Mydata"));
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