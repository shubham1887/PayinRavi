<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AddBank extends CI_Controller {
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

		$filename = "inlogs/payout.txt";
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
					$bank_id = intval(trim($this->input->post("ddlbank")));
					$AccHolderName = $this->input->post("txtAccHolderName");
					$AccNumber = $this->input->post("txtAccNumber");
					$Ifsc = substr($this->input->post("txtIfsc"),0,11);

					$rsltcheck = $this->db->query("select * from payout_banks where user_id = ?",array($user_id));
					if($rsltcheck->num_rows() == 0)
					{
						$rslt = $this->db->query("insert into payout_banks(user_id,bank_id,account_name,account_number,ifsc,status,add_date,ipaddress) values(?,?,?,?,?,?,?,?)",
						array($user_id,$bank_id ,$AccHolderName,$AccNumber,$Ifsc,"DeActive",$this->common->getDate(),$this->common->getRealIpAddr()));
						if($rslt == true)
						{
							redirect(base_url()."API/AddBank");
						}
					}
					else if(isset($_POST["txtAmount"]))
					{
						$user_id = $this->session->userdata("ApiId");
						$amount = intval(trim($this->input->post("txtAmount")));
						$mode = trim($this->input->post("ddlmode"));
						$balance = $this->Common_methods->getAgentBalance($user_id);


						$rsltcheck = $this->db->query("
						select 
						a.* ,b.bank_name
						from  payout_banks  a
						left join dmr_banks b on a.bank_id = b.Id
						where 
						a.status = 'Active' and
						a.user_id = ?",array($user_id));
						if($rsltcheck->num_rows() == 1)
						{
							if($balance >= $amount)
							{
								
								$this->view_data["rsltdata"] = $rsltcheck;
								$this->view_data["amount"] = $amount;
								$this->view_data["mode"] = $mode;
								$this->view_data["bankid"] = '';
								$this->view_data["message"] = "Message";
								$this->load->view("API/AddBank_confirmPayout_view",$this->view_data);	
							}
							else
							{
								
								if($rsltcheck->num_rows() == 1)
								{
										$this->view_data["is_edit"] = 'yes';	
								}
								$this->view_data["MESSAGEBOXTYPE"] = 'FAILURE';
								$this->view_data["MESSAGEBOX"] = 'InSufficient Balance';

								$this->view_data["rsltdata"] = $rsltcheck;
								$this->view_data["bankid"] = '';
								$this->view_data["message"] = "Message";
								$this->load->view("API/AddBank_view",$this->view_data);		
							}
						}
						else
						{
							if($rsltcheck->num_rows() == 1)
							{
									$this->view_data["is_edit"] = 'yes';	
							}
							$this->view_data["MESSAGEBOXTYPE"] = 'FAILURE';
							$this->view_data["MESSAGEBOX"] = 'No Active Banks Found';

							$this->view_data["rsltdata"] = $rsltcheck;
							$this->view_data["bankid"] = '';
							$this->view_data["message"] = "Message";
							$this->load->view("API/AddBank_view",$this->view_data);		
						}
					}
					else
					{
						redirect(base_url()."API/AddBank");
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
					$this->load->view("API/AddBank_view",$this->view_data);
				}
				else
				{redirect(base_url().'login');}																								
			}
		} 
	}
	public function payout()
	{
		if(isset($_POST["hidAmount"]))
		{
			$user_id = $this->session->userdata("ApiId");
			$username = $this->session->userdata("ApiUserName");
			$amount = $this->Encr->decrypt($this->input->post("hidAmount"));
			$mode = $this->Encr->decrypt($this->input->post("hidMode"));
			if($amount > 0)
			{
				$balance = $this->Ewallet_aeps->getAgentBalance($user_id);
				if($balance >= ($amount + 10))
				{
					$userbank = $this->db->query("
						select 
						a.* ,b.bank_name
						from  payout_banks  a
						left join dmr_banks b on a.bank_id = b.Id
						where a.user_id = ?",array($user_id));	
					if($userbank->num_rows() == 1)
					{
						$account_number = $userbank->row(0)->account_number;
						$account_name = $userbank->row(0)->account_name;
						$ifsc = $userbank->row(0)->ifsc;
						$bank_id = $userbank->row(0)->bank_id;

						$rsltinsert = $this->db->query("insert into payout_requests(user_id,add_date,ipaddress,sp_key,external_ref,credit_account,credit_rmn,ifs_code,bene_name,credit_amount,upi_mode,vpa,latitude,longitude,endpoint_ip,remarks,mode) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
							array($this->session->userdata("ApiId"),$this->common->getDate(),$this->common->getRealIpAddr(),"DPN","",$account_number,"",$ifsc,$account_name,$amount,"","","23.022505","72.571365",$this->common->getRealIpAddr(),$username,$mode));
						if($rsltinsert == true)
						{
							$insert_id= $this->db->insert_id();
							$external_ref = "PAYOUT".$insert_id;
							$this->db->query("update payout_requests set external_ref = ? where Id = ?",array($external_ref ,$insert_id));

							$cr_user_id = 1;
						    $dr_user_id = $user_id;
							$description = "PAYOUT >> Admin To ".$this->session->userdata("ApiBusinessName");
							$payment_type = "PAYOUT";
							$transaction_charge = 10;
							
							$payout_id = $insert_id;							

							$this->load->model("Ewallet_aeps");

							$ewrslt = $this->Ewallet_aeps->PayoutDebitEntry($user_id,$amount,$transaction_charge,$payout_id,$description);
							//($cr_user_id,$dr_user_id,$amount,"PAYOUT",$description,$payment_type);
							if($ewrslt == true)
							{

								

//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// start payout api call ////////////////////////////////////////////////


$url = 'https://pdrs.online/webapi/Payout';
$req = array(
            "username"=> $this->getUsername(),
            "password"=> $this->getPassword(),
            "apitoken"=> $this->getToken(),
            "request"=>array(
                                "account_number"=>$account_number,
                                "account_name"=>$account_name,
                                "ifsc"=>$ifsc,
                                "amount"=>$amount,
                                "mode"=>$mode,
                                "order_id"=>"PAYOUT".$insert_id
                            )
    );

$ch = curl_init();
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json'
));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
curl_setopt($ch, CURLOPT_URL, $url);
$buffer = $response = $buffer = curl_exec($ch);
curl_close($ch);
$this->load->model("Errorlog");
$this->Errorlog->httplog($url.">>".json_encode($req),$buffer);
$json_obj = json_decode($buffer);
if(isset($json_obj->message) and isset($json_obj->status) and isset($json_obj->statuscode) )
{
        $message = $json_obj->message;
        $status = $json_obj->status;
        $statuscode = $json_obj->statuscode;
        if($statuscode == "TXN")
        {
            $data = $json_obj->data;
            $tid = trim((string)$data->tid);
            $bank_ref_num = trim((string)$data->opr_id);
            $recipient_name = trim((string)$data->name);
            $this->db->query("update payout_requests set status = 'Success',bank_ref_no=?,resp_bene_name=?,UNIQUEID=? where Id = ?",array($bank_ref_num,$recipient_name,$tid,$insert_id));



            $this->session->set_flashdata("MESSAGEBOXTYPE","SUCCESS");
    		$this->session->set_flashdata("MESSAGEBOX","Transaction Done Successfully");
							

        //     $resptouser =   array (
        //                             'status' => 'success',
        //                             'infomsg' => $message
        //                         );

        //     $this->Errorlog->httplog("RESPONSE TO USER : ".json_encode($req),json_encode($resptouser));
        //     echo json_encode($resptouser);exit;

        }
}





///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////// END PAYOUT API CALL /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
//XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX//
///////////////////////////////////////////////////////////////////////////////////////////////









							}
							else
							{
								$this->session->set_flashdata("MESSAGEBOXTYPE","FAILURE");
    							$this->session->set_flashdata("MESSAGEBOX","Some Error Occured");
								$this->db->query("update payout_requests set status = 'Failure',response = 'Payment Failure' where Id = ?",array($insert_id));
							}
						}

					}
				}
				else
				{
					$this->session->set_flashdata("MESSAGEBOXTYPE","FAILURE");
					$this->session->set_flashdata("MESSAGEBOX","InSufficient Fund");
					
				}
			}
			
		}
		redirect(base_url()."API/AddBank");
		
	}
}