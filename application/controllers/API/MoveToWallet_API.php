<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MoveToWallet_API extends CI_Controller {
	private $msg='';public $perpage;
	function __construct()
    {
        parent:: __construct();
        $this->clear_cache();
        $this->load->model("Ewallet_aeps");

        error_reporting(-1);
        ini_set('display_errors',1);
        
		
    }
    
	private function getToken()
    {
        $rslt = $this->db->query("SELECT param1,param2,param3 FROM api_configuration where api_name = 'PDRS'");
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->param3;
        }
        return "";
    }
    private function getUsername()
    {
        $rslt = $this->db->query("SELECT param1,param2,param3 FROM api_configuration where api_name = 'PDRS'");
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->param1;
        }
        return "";
    }
    private function getPassword()
    {
        $rslt = $this->db->query("SELECT param1,param2,param3 FROM api_configuration where api_name = 'PDRS'");
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->param2;
        }
        return "";
    }
	function is_logged_in() 
    {
	 	if ($this->session->userdata('ApiUserType') != "APIUSER") 
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
	public function index()  
	{
		 	
			if(isset($_GET["username"]) and isset($_GET["password"]) and isset($_GET["amount"]))
			{
				$username = trim($this->input->get("username"));
				$password = trim($this->input->get("password"));
				$amount = trim($this->input->get("amount"));
				$userinfo = $this->db->query("select * from tblusers where usertype_name = 'APIUSER' and username = ? and password = ?",array($username,$password));
				if($userinfo->num_rows() == 1)
				{
					$user_id = $userinfo->row(0)->user_id;
                    $businessname = $userinfo->row(0)->businessname;
					$amount = intval($amount);
					$transaction_charge = 0;
					$sp_key = "W2W";
					$remarks = "Move To DMT Wallet";
					$lat = $long = "";
					$balance = $this->Ewallet_aeps->getAgentBalance($user_id);
					if($balance >= $amount)
					{
						$rsltinsert = $this->db->query("insert into payout_requests(user_id,add_date,ipaddress,sp_key,external_ref,credit_account,credit_rmn,ifs_code,bene_name,credit_amount,upi_mode,vpa,latitude,longitude,endpoint_ip,remarks,mode,transaction_charge) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                            array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$sp_key,"","","","","",$amount,"","",$lat,$long,$this->common->getRealIpAddr(),$remarks,$sp_key,$transaction_charge));
                        if($rsltinsert == true)
                        {
                            $insert_id= $this->db->insert_id();

                            //debit amount code
                            $account_number = "";
                            $credit_user_id = 1;
                            $debit_user_id = $user_id;
                            $remark = "PAYOUT : AccNO : ".$account_number;
                            $description = "PAYOUT : Admin To ".$businessname;
                            $payment_type = $sp_key;
                            $admin_remark = "";
                            $ew = $this->Ewallet_aeps->MoveToMainWalletDebitEntry($user_id,$amount,$transaction_charge,$insert_id,$description);
                            if($ew == true)
                            {
                            	$credit_user_id = $user_id;
                            	$debit_user_id = 1;
                            	$remark = "Aeps Wallet To DMT Wallet";
                            	$this->Ew2->tblewallet_Payment_CrDrEntry($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type);

                                $resp_array = array(
                                    "status"=>0,
                                    "statuscode"=>"TXN",
                                    "message"=>"Move To Wallet Successfully Done"
                                );
                                echo json_encode($resp_array);exit;

                            }
                        }
                        else
                        {
                        	$resp_array = array(
                                    "status"=>1,
                                    "statuscode"=>"ERR",
                                    "message"=>"Some Error Occured"
                                );
                            echo json_encode($resp_array);exit;
                        }
					}
						
				}
			}
            else
            {
                $resp_array = array(
                                    "status"=>1,
                                    "statuscode"=>"ERR",
                                    "message"=>"Parameter Missing"
                                );
                echo json_encode($resp_array);exit;
            }	
					
			
		 
	}
}