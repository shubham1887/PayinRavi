<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmr2_account_validation extends CI_Controller {
	
	public function index()
	{ 
	
		//http://demo.mpayonline.co/appapi1/dmr_account_validation?
		//username=&password=&remitter_id=&bank_id=&benificiary_account_no=&benificiary_ifsc=
		if($_SERVER['REQUEST_METHOD'] == 'GET') 
		{
		    //username=110001&password=26378080&
		    //remitter_id=8866628967&remittermobile=8866628967&
		    //benificiary_account_no=290620110000778&benificiary_ifsc=BKID0002906&bank_code=BKID
		    
			if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['remitter_id'])  
			&& isset($_GET['bank_id']) && isset($_GET['benificiary_account_no']) 
			&& isset($_GET['benificiary_ifsc']))
			{
			    //echo "inside";exit;
				$username = trim($_GET['username']);
				$pwd =  trim($_GET['password']);
				$remittermobile = $remitter_id = trim($_GET['remitter_id']); 
				
				$benificiary_account_no = trim($_GET['benificiary_account_no']);
				$benificiary_ifsc = trim($_GET['benificiary_ifsc']);
				$bank_id =  trim($_GET['bank_id']);
		
				$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no from tblusers where username = ? and password = ?",array($username,$pwd));
				if($userinfo->num_rows() == 1)
				{
					$status = $userinfo->row(0)->status;
					$user_id = $userinfo->row(0)->user_id;
					$businessname = $userinfo->row(0)->businessname;
					$username = $userinfo->row(0)->username;
					$mobile_no = $userinfo->row(0)->mobile_no;
					$usertype_name = $userinfo->row(0)->usertype_name;
					
					if($status == '1')
					{
						//if($usertype_name  != 'Agent' or $usertype_name  != 'Distributor' or $usertype_name  != 'MasterDealer' )
						if(false)
						{
							$resp_arr = array(
								"message"=>"Invalid Access",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						
						if(ctype_digit($remittermobile))
						{
						  
							$this->load->model("Paytm");
							echo $this->Paytm->verify_bene($remitter_id,$benificiary_account_no,$benificiary_ifsc,$bank_id,$userinfo);
							//($remitter_id,$remittermobile,$benificiary_account_no,$benificiary_ifsc,$userinfo);
						}
						else
						{
							$resp_arr = array(
								"message"=>"Invalid Mobile Number",
								"status"=>1,
								"statuscode"=>"ERR",
								);
							$json_resp =  json_encode($resp_arr);
							echo $json_resp;exit;
						}
						
					}
					else
					{
						$resp_arr = array(
							"message"=>"Your account is deactivated. contact your Administrator",
							"status"=>1,
							"statuscode"=>"ERR",
						);
						$json_resp =  json_encode($resp_arr);
						echo $json_resp;exit;
					}
				}
				else
				{
					$resp_arr = array(
						"message"=>"Authentication Failed",
						"status"=>1,
						"statuscode"=>"ERR",
					);
					$json_resp =  json_encode($resp_arr);
					echo $json_resp;exit;
				}
				
				
			}
			else
			{
				$resp_arr = array(
							"message"=>"Invalid Input",
							"status"=>1,
							"statuscode"=>"ERR",
						);
				$json_resp =  json_encode($resp_arr);
				echo $json_resp;exit;
			}			
		}
		else
		{
			$resp_arr = array(
							"message"=>"Invalid Input",
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
			$AmountArray[3] = $maxamount;
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
	}
}
