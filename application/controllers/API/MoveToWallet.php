<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MoveToWallet extends CI_Controller {
	private $msg='';public $perpage;
	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
        $this->load->model("Ewallet_aeps");

        error_reporting(-1);
        ini_set('display_errors',1);
        $this->db->db_debug = TRUE;
		$this->perpage=25;
				//redirect("http://mastermoney.in/ApiLogout");exit;
    }
    public function logentry($data)
	{

		$filename = "inlogs/MoveToWallet.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
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
				$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache"); 

		if ($this->session->userdata('ApiUserType') != "APIUSER") 
		{ 
			redirect(base_url().'login?crypt='.$this->Common_methods->encrypt("MyData")); 
		}				
		else 		
		{ 	

		 	if($this->input->post('btnSubmit') == "Submit")
			{
					$user_id = $this->session->userdata("ApiId");
					$businessname = $this->session->userdata("ApiBusinessName");
					if(isset($_POST["txtAmount"]))
					{
						$user_id = $this->session->userdata("ApiId");
						$amount = intval(trim($this->input->post("txtAmount")));
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
	                            $credit_user_id = $user_id;
	                            $debit_user_id = 1;
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



									$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","SUCCESS");
									$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Balance Transfer Successfully Done");

	                            	redirect(base_url()."API/MoveToWallet");
	                            }
	                        }
	                        else
	                        {
	                        	$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
								$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","Some Error Occured");

                            	redirect(base_url()."API/MoveToWallet");
	                        }
						}
						else
						{
							$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
							$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","InSufficient Balance");
							redirect(base_url()."API/MoveToWallet");
						}
					}
					else
					{
						redirect(base_url()."API/MoveToWallet");
					}
			}	
			
			else
			{
				$user=$this->session->userdata('ApiUserType');
				if(trim($user) == 'APIUSER' )
				{
					$this->view_data["is_edit"] = 'no';
					$user_id = $this->session->userdata("ApiId");
					$rsltcheck = $this->db->query("
						select 
						a.* ,b.bank_name
						from  payout_banks  a
						left join dmr_banks b on a.bank_id = b.Id
						where a.user_id = ?",array($user_id));
					if($rsltcheck->num_rows() == 1)
					{
							$this->view_data["is_edit"] = 'yes';	
					}

					$this->view_data["rsltdata"] = $rsltcheck;
					$this->view_data["bankid"] = '';
					$this->view_data["message"] = "Message";
					$this->load->view("API/MoveToWallet_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
}