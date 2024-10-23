<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Icici_callback extends CI_Controller {
	public function decrypt()
    { 
    error_reporting(-1);
    ini_set('display_errors',1);
    $this->db->db_debug = TRUE;
        //$raw_response = file_get_contents('php://input');
        $raw_response = 'B4RflTzlng/K1ccoj8H9KzppPl8vYnf0T+iPwJWv90qFHNyriUVCxwnouEnEtn1iqXc8BmFOVVJSPfeCWuwIxPJSloWRXKPu7VGpUzRxorWxjvJ1l7VzHIETU9zYiwhyPhgz2+Helh1iNuXPtH+qR+OBFMy762FQMVP1w5X3Hj+lJjmGM/OMuCA+03MMbRVeK+J2PVoz3Q6hXPS5DlyWNWKSvlgaqq/E30rw1eVqYtXRetbQ4ibLqpqqq0HByDgAFl6ykAMdqb6G1Vm6lZYgGR1m48uC3pqIBdb33cwf6AytaHeAaMK7JFyM+pV31faLGLV4xRdyhnDVFkwzghB3I8lsTk2EXAj4v/l1sUgpkr33NuWx7ffsiWPO+bMTKBw1S4WH6d4t7mxvLhnuoIoTO5ojYafOfmMuduPKbP/HEnwfW9MtzR9/TmHktyjwodkPp3O0SYNAdEf/bmCFqQAE2N/G1bYncCAbLWRMmN+PQk+hJr+J75GB3cmWD6fbVPOoBkx9UFMZ3nPbUXiOTI6CVjhSX73aEPD4irJNBumU6p4AAfn0tq5fwXpOn5HJb9S5+l23xdQqpAQ8Ow73cXVAMO1N8FTbqab+uIGL1CSXi+SlZVlHfrdihJmu7unFYGwiAhx4Gc+MpEKiX3qL6QutD3LdSU8VtGJjaaEr/4DRF8M=';
        //$this->logentry($raw_response);

        $fp= fopen("../../pay2topup_keys/paytotopup-selfsigned_privatekey.key","r");
        $priv_key=fread($fp,8192);
        fclose($fp);

        $res = openssl_get_privatekey($priv_key, "");
        // echo "Private Key : ".$res;
        openssl_private_decrypt(base64_decode($raw_response), $newsource, $res);
        //echo "<hr>";
        echo $newsource;exit;
        $json_resp = json_decode($newsource);
       // print_r($json_resp);exit;
        if(isset($json_resp->TxnStatus))
        {
            $TxnStatus = $json_resp->TxnStatus;
            $subMerchantId = $json_resp->subMerchantId;
            $PayerAmount = $json_resp->PayerAmount;
            $ResponseCode = "";
            if(isset($json_resp->ResponseCode))
            {
                $ResponseCode = $json_resp->ResponseCode;    
            }
            
            $PayerName = $json_resp->PayerName;
            $terminalId = $json_resp->terminalId;
            $TxnInitDate = $json_resp->TxnInitDate;
            $merchantTranId = $json_resp->merchantTranId;
            $PayerMobile = $json_resp->PayerMobile;
            $BankRRN = $json_resp->BankRRN;
            $merchantId = $json_resp->merchantId;

            $PayerVA = $json_resp->PayerVA;
            $TxnCompletionDate = $json_resp->TxnCompletionDate;


            $usermobile =  $this->Encr->decrypt($merchantTranId);

            $insertion = $this->db->query("insert into icici_payments_callback(
                                        TxnStatus,subMerchantId,PayerAmount,
                                        ResponseCode,PayerName,terminalId,
                                        TxnInitDate,merchantTranId,PayerMobile,
                                        BankRRN,merchantId,PayerVA,
                                        TxnCompletionDate,mobile_no
                                        )
                                        values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                        array(
                                            $TxnStatus,$subMerchantId,$PayerAmount,
                                        $ResponseCode,$PayerName,$terminalId,
                                        $TxnInitDate,$merchantTranId,$PayerMobile,
                                        $BankRRN,$merchantId,$PayerVA,
                                        $TxnCompletionDate,$usermobile
                                        ));
            if($insertion == true)
            {
                $check_urtduplicate = $this->db->query("insert into icici_payments_remove_duplicate(BankRRN,add_date) values(?,?)",array($BankRRN,$this->common->getDate()));
                if($check_urtduplicate == true)
                {
                    $userinfo = $this->db->query("select * from tblusers where mobile_no = ?",array($usermobile));
                    if($userinfo->num_rows() == 1)
                    {
                            $user_id = $userinfo->row(0)->user_id;
                            if($TxnStatus == "SUCCESS")
                            {
                                $cr_user_id = $user_id;
                                $dr_user_id = 1;
                                $description = "Admin To ".$userinfo->row(0)->businessname;
                                $payment_type = "UPI";
                                $Amount = $PayerAmount;
                                $txtRemark = "By ".$PayerVA." REF:".$BankRRN;
                                $ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$Amount,$txtRemark,$description,$payment_type);

                               // echo "OK";exit;
                            }
                    }
                    $resp_array = array(
                                    "Response"=>"Success",
                                    "Code"=>"11",
                                );
                     echo json_encode($resp_array);exit;  
                }
                else
                {
                    $resp_array = array(
                                    "Response"=>"Duplicate UTR",
                                    "Code"=>"06",
                                );
                    echo json_encode($resp_array);exit;
                }
            }


        }




        echo "OK";exit;
    }   
	public function logentry($data)
	{

		$filename = "inlogs/icici_resp.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $this->common->getDate()."\n", 'a+');
write_file($filename, $this->common->getRealIpAddr()."\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');
	}
    public function getuserid($merchantTranId)
    {
        $rslt = $this->db->query("select user_id from icici_qr_requests where merchantTranId = ?",array($merchantTranId));
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->user_id;
        }
        else
        {
            return false;
        }
    }
     public function getwallettype($merchantTranId)
    {
        $rslt = $this->db->query("select wallet_type from icici_qr_requests where merchantTranId = ?",array($merchantTranId));
        if($rslt->num_rows() == 1)
        {
            return $rslt->row(0)->wallet_type;
        }
        else
        {
            return "main";
        }
    }
	public function index()
    { 
        $raw_response = file_get_contents('php://input');
        
        $fp= fopen("../../pay2topup_keys/paytotopup-selfsigned_privatekey.key","r");
        $priv_key=fread($fp,8192);
        fclose($fp);

        $res = openssl_get_privatekey($priv_key, "");
        // echo "Private Key : ".$res;
        openssl_private_decrypt(base64_decode($raw_response), $newsource, $res);
        //echo "<hr>";
        $json_resp = json_decode($newsource);
       // print_r($json_resp);exit;
        if(isset($json_resp->TxnStatus))
        {
            $TxnStatus = $json_resp->TxnStatus;
            $subMerchantId = $json_resp->subMerchantId;
            $PayerAmount = $json_resp->PayerAmount;
            $ResponseCode = "";
            if(isset($json_resp->ResponseCode))
            {
                $ResponseCode = $json_resp->ResponseCode;    
            }
            
            $PayerName = $json_resp->PayerName;
            $terminalId = $json_resp->terminalId;
            $TxnInitDate = $json_resp->TxnInitDate;
            $merchantTranId = $json_resp->merchantTranId;
            $PayerMobile = $json_resp->PayerMobile;
            $BankRRN = $json_resp->BankRRN;
            $merchantId = $json_resp->merchantId;

            $PayerVA = $json_resp->PayerVA;
            $TxnCompletionDate = $json_resp->TxnCompletionDate;




            $user_id =  $this->getuserid($merchantTranId);
            if($user_id != false)
            {

                $wallet_type = $this->getwallettype($merchantTranId);

                $insertion = $this->db->query("insert into icici_payments_callback(
                                        TxnStatus,subMerchantId,PayerAmount,
                                        ResponseCode,PayerName,terminalId,
                                        TxnInitDate,merchantTranId,PayerMobile,
                                        BankRRN,merchantId,PayerVA,
                                        TxnCompletionDate,mobile_no
                                        )
                                        values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                        array(
                                            $TxnStatus,$subMerchantId,$PayerAmount,
                                        $ResponseCode,$PayerName,$terminalId,
                                        $TxnInitDate,$merchantTranId,$PayerMobile,
                                        $BankRRN,$merchantId,$PayerVA,
                                        $TxnCompletionDate,$user_id
                                        ));
                if($insertion == true)
                {
                    $check_urtduplicate = $this->db->query("insert into icici_payments_remove_duplicate(BankRRN,add_date) values(?,?)",array($BankRRN,$this->common->getDate()));
                    if($check_urtduplicate == true)
                    {
                        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
                        if($userinfo->num_rows() == 1)
                        {
                                $user_id = $userinfo->row(0)->user_id;
                                $parentid = $userinfo->row(0)->parentid;
                                $flatcomm = $userinfo->row(0)->flatcomm;
                                if($TxnStatus == "SUCCESS")
                                {
                                    $cr_user_id = $user_id;
                                    $dr_user_id = 1;
                                    $description = "Admin To ".$userinfo->row(0)->businessname;
                                    $payment_type = "UPI";
                                    $Amount = $PayerAmount;
                                    $txtRemark = "By ".$PayerVA." REF:".$BankRRN;
                                    if($wallet_type == "dmr")
                                    {

                                        $ewrslt = $this->Ew2->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$Amount,$txtRemark,$description,$payment_type);
                                    }
                                    else
                                    {
                                            $ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$Amount,$txtRemark,$description,$payment_type);    
                                            if($flatcomm > 0 and $flatcomm < 5)
                                            {
                                                $flat_commission_amount = (($Amount * $flatcomm)/100);
                                                    $ewrslt2 = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$flat_commission_amount,"Commission : ".$txtRemark,"Commission : ".$description,$payment_type);    


                                                $distinfo = $this->db->query("select * from tblusers where user_id = ?",array($parentid));
                                                if($distinfo->num_rows() == 1)
                                                {
                                                    $dist_flatcomm = $distinfo->row(0)->flatcomm;
                                                    if($dist_flatcomm > 0 and $dist_flatcomm > $flatcomm)
                                                    {
                                                        $dist_flatcomm = $dist_flatcomm - $flatcomm;
                                                        $dist_flat_commission_amount = (($Amount * $dist_flatcomm)/100);

                                                        $ewrslt3 = $this->Insert_model->tblewallet_Payment_CrDrEntry($distinfo->row(0)->user_id,$dr_user_id,$dist_flat_commission_amount,"Commission : ".$txtRemark,"Commission : ".$description,$payment_type);    

                                                        $mdinfo = $this->db->query("select * from tblusers where user_id = ?",array($distinfo->row(0)->parentid));
                                                        if($mdinfo->num_rows() == 1)
                                                        {
                                                            $md_flatcomm = $mdinfo->row(0)->flatcomm;
                                                            if($md_flatcomm > 0 and $md_flatcomm > $dist_flatcomm)
                                                            {
                                                                 $md_flatcomm = $md_flatcomm - $distinfo->row(0)->flatcomm;
                                                                $md_flat_commission_amount = (($Amount * $md_flatcomm)/100);

                                                                $ewrslt4 = $this->Insert_model->tblewallet_Payment_CrDrEntry($mdinfo->row(0)->user_id,$dr_user_id,$md_flat_commission_amount,"Commission : ".$txtRemark,"Commission : ".$description,$payment_type);       
                                                            }
                                                        }

                                                    }
                                                }


                                            }
                                    }

                                    

                                   // echo "OK";exit;
                                }
                        }
                        $resp_array = array(
                                        "Response"=>"Success",
                                        "Code"=>"11",
                                    );
                         echo json_encode($resp_array);exit;  
                    }
                    else
                    {
                        $resp_array = array(
                                        "Response"=>"Duplicate UTR",
                                        "Code"=>"06",
                                    );
                        echo json_encode($resp_array);exit;
                    }
                }    
            }
            else
            {
                $usermobile =  $this->Encr->decrypt($merchantTranId);
                $insertion = $this->db->query("insert into icici_payments_callback(
                                            TxnStatus,subMerchantId,PayerAmount,
                                            ResponseCode,PayerName,terminalId,
                                            TxnInitDate,merchantTranId,PayerMobile,
                                            BankRRN,merchantId,PayerVA,
                                            TxnCompletionDate,mobile_no
                                            )
                                            values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                            array(
                                                $TxnStatus,$subMerchantId,$PayerAmount,
                                            $ResponseCode,$PayerName,$terminalId,
                                            $TxnInitDate,$merchantTranId,$PayerMobile,
                                            $BankRRN,$merchantId,$PayerVA,
                                            $TxnCompletionDate,$usermobile
                                            ));
                if($insertion == true)
                {
                        
                    $check_urtduplicate = $this->db->query("insert into icici_payments_remove_duplicate(BankRRN,add_date) values(?,?)",array($BankRRN,$this->common->getDate()));
                    if($check_urtduplicate == true)
                    {
                        $userinfo = $this->db->query("select * from tblusers where mobile_no = ?",array($usermobile));
                        if($userinfo->num_rows() == 1)
                        {
                                $user_id = $userinfo->row(0)->user_id;
                                if($TxnStatus == "SUCCESS")
                                {
                                    $cr_user_id = $user_id;
                                    $dr_user_id = 1;
                                    $description = "Admin To ".$userinfo->row(0)->businessname;
                                    $payment_type = "UPI";
                                    $Amount = $PayerAmount;
                                    $txtRemark = "By ".$PayerVA." REF:".$BankRRN;
                                    $ewrslt = $this->Insert_model->tblewallet_Payment_CrDrEntry($cr_user_id,$dr_user_id,$Amount,$txtRemark,$description,$payment_type);
                                }
                        }    
                    }
                            
                        
                        
                }
            }

            


        }




        echo "OK";exit;
    }   
}
