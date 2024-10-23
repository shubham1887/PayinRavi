<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getpayout extends CI_Controller {


	function __construct()
    {
        parent:: __construct();
        $this->is_logged_in();
        $this->clear_cache();
    }
	function is_logged_in() 
    {
	 	
    }
    function clear_cache()
    {
         header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
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
	public function logentry($data)
	{}
	public function index()
	{

		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;

	
		if(isset($_POST["username"]) and isset($_POST["pwd"])  and isset($_POST["sp_key"])  and isset($_POST["credit_amount"])  and isset($_POST["credit_account"])  and isset($_POST["bene_name"])  and isset($_POST["ifs_code"]))
		{
			$username = trim($this->input->post("username"));
			$pwd = trim($this->input->post("pwd"));
			$sp_key = trim($this->input->post("sp_key"));
			$amount = intval(trim($this->input->post("credit_amount")));
			$account_number = trim($this->input->post("credit_account"));
			$account_name = trim($this->input->post("bene_name"));
			$ifsc = trim($this->input->post("ifs_code"));
			$remarks = trim($this->input->post("remarks"));
			$lat = trim($this->input->post("lat"));
			$long = trim($this->input->post("long"));
			$userinfo = $this->db->query("select * from tblusers where host_id = 1 and username = ? and password = ?",array($username,$pwd));
            if($userinfo->num_rows() == 1)
            {
            	
                $user_id = $userinfo->row(0)->user_id;
                $businessname = $userinfo->row(0)->businessname;
                $usertype_name = $userinfo->row(0)->usertype_name;
                $user_status = $userinfo->row(0)->status;
                $adhar_verified = $userinfo->row(0)->status;
                if($user_status == "1")
                {
                	if($amount >= 1 and $amount <= 200000)
                	{
                		$balance = $this->Ew2->getAgentBalance($user_id);
                		if($balance > $amount + 10)
                		{
                			$transaction_charge = 10;
                    
	                       $rsltinsert = $this->db->query("insert into payout_requests(user_id,add_date,ipaddress,sp_key,external_ref,credit_account,credit_rmn,ifs_code,bene_name,credit_amount,upi_mode,vpa,latitude,longitude,endpoint_ip,remarks,mode,transaction_charge) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
	                            array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$sp_key,"",$account_number,"",$ifsc,$account_name,$amount,"","",$lat,$long,$this->common->getRealIpAddr(),$remarks,$sp_key,$transaction_charge));
	                        if($rsltinsert == true)
	                        {
	                            $insert_id= $this->db->insert_id();

	                            //debit amount code
	                            $credit_user_id = 1;
	                            $debit_user_id = $user_id;
	                            $remark = "PAYOUT : AccNO : ".$account_number;
	                            $description = "PAYOUT : Admin To ".$businessname;
	                            $payment_type = $sp_key;
	                            $admin_remark = "";
	                            $ew = $this->Ew2->PAYOUT_ENTRY($user_id,$insert_id,$amount,$transaction_charge,$description,$remark,$sp_key);
	                            //($user_id,$insert_id,$amount,$transaction_charge,$description,$remark,$sp_key);
	                            //($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark);
	                            if($ew == true)
	                            {
$url = 'https://payin.live/webapi/Payout';
$req = array(
            "username"=> $this->getUsername(),
		    "password"=> $this->getPassword(),
		    "apitoken"=> $this->getToken(),
            "request"=>array(
            					"account_number"=>$account_number,
            					"account_name"=>$account_name,
            					"ifsc"=>$ifsc,
            					"amount"=>$amount,
            					"mode"=>$sp_key,
            					"order_id"=>$insert_id
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
			$resptouser =   array (
                					'status' => 'success',
                    				'infomsg' => $message
                  				);

			$this->Errorlog->httplog("RESPONSE TO USER : ".json_encode($req),json_encode($resptouser));
			echo json_encode($resptouser);exit;

		}
}

	                            }
	                        }
                		}
                	}
                }

            }
		}
		else if(isset($_GET["username"]) and isset($_GET["pwd"])  and isset($_GET["sp_key"])  and isset($_GET["credit_amount"])  and isset($_GET["credit_account"])  and isset($_GET["bene_name"])  and isset($_GET["ifs_code"]))
		{
			$username = trim($this->input->get("username"));
			$pwd = trim($this->input->get("pwd"));
			$sp_key = trim($this->input->get("sp_key"));
			$amount = intval(trim($this->input->get("credit_amount")));
			$account_number = trim($this->input->get("credit_account"));
			$account_name = trim($this->input->get("bene_name"));
			$ifsc = trim($this->input->get("ifs_code"));
			$remarks = trim($this->input->get("remarks"));
			$lat = trim($this->input->get("lat"));
			$long = trim($this->input->get("long"));
			$userinfo = $this->db->query("select * from tblusers where host_id = 1 and username = ? and password = ?",array($username,$pwd));
            if($userinfo->num_rows() == 1)
            {
            	
                $user_id = $userinfo->row(0)->user_id;
                $businessname = $userinfo->row(0)->businessname;
                $usertype_name = $userinfo->row(0)->usertype_name;
                $user_status = $userinfo->row(0)->status;
                $adhar_verified = $userinfo->row(0)->status;
                if($user_status == "1")
                {
                	if($amount >= 1 and $amount <= 200000)
                	{
                		$balance = $this->Ew2->getAgentBalance($user_id);
                		if($balance > $amount + 10)
                		{
                			$transaction_charge = 10;
                    
	                       $rsltinsert = $this->db->query("insert into payout_requests(user_id,add_date,ipaddress,sp_key,external_ref,credit_account,credit_rmn,ifs_code,bene_name,credit_amount,upi_mode,vpa,latitude,longitude,endpoint_ip,remarks,mode,transaction_charge) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
	                            array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$sp_key,"",$account_number,"",$ifsc,$account_name,$amount,"","",$lat,$long,$this->common->getRealIpAddr(),$remarks,$sp_key,$transaction_charge));
	                        if($rsltinsert == true)
	                        {
	                            $insert_id= $this->db->insert_id();

	                            //debit amount code
	                            $credit_user_id = 1;
	                            $debit_user_id = $user_id;
	                            $remark = "PAYOUT : AccNO : ".$account_number;
	                            $description = "PAYOUT : Admin To ".$businessname;
	                            $payment_type = $sp_key;
	                            $admin_remark = "";
	                            $ew = $this->Ew2->PAYOUT_ENTRY($user_id,$insert_id,$amount,$transaction_charge,$description,$remark,$sp_key);
	                            //($user_id,$insert_id,$amount,$transaction_charge,$description,$remark,$sp_key);
	                            //($credit_user_id,$debit_user_id,$amount,$remark,$description,$payment_type,$admin_remark);
	                            if($ew == true)
	                            {
$url = 'https://pdrs.online/webapi/Payout';
$req = array(
            "username"=> "8249705450",
		    "password"=> "123456",
		    "apitoken"=> "6942753088236792774910086614",
            "request"=>array(
            					"account_number"=>$account_number,
            					"account_name"=>$account_name,
            					"ifsc"=>$ifsc,
            					"amount"=>$amount,
            					"mode"=>$sp_key,
            					"order_id"=>$insert_id
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
			$resptouser =   array (
                					'status' => 'success',
                    				'infomsg' => $message
                  				);

			$this->Errorlog->httplog("RESPONSE TO USER : ".json_encode($req),json_encode($resptouser));
			echo json_encode($resptouser);exit;

		}
}

	                            }
	                        }
                		}
                	}
                }

            }
		}
	}




}