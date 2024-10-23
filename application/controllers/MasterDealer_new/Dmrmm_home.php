<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dmrmm_home extends CI_Controller {

  function __construct()
  {
      parent:: __construct();
      $this->is_logged_in();
      $this->clear_cache();
  }
  function is_logged_in() 
  {
    if ($this->session->userdata('MdUserType') != "MasterDealer") 
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
       error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
  }









    public function checkduplicate($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$type)
    {
        $add_date = $this->getDate();
        $ip ="asdf";
        $rslt = $this->db->query("insert into mtstopduplication (Amount,user_id,RemitterCode,BeneficiaryCode,add_date,type) values(?,?,?,?,?,?)",array($Amount,$user_id,$RemitterCode,$BeneficiaryCode,$add_date,$type));
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


    public function SubDmtTransactions()
    {
      header('Content-Type: application/json');



      $user_id = $this->session->userdata("MdId");
      $rsltreport = $this->db->query('
        SELECT 
        unique_id as Trxnid,
        Id as OrderID,
        Id as SplitId,
        RemiterMobile as Number,
        "" as Sendername,
        AccountNumber as Accountno,
        RESP_name as Accountname,
        "" as Bankname,
        IFSC,
        RESP_opr_id as OptID,
        CASE
            WHEN Status = "SUCCESS" THEN "Success"
            WHEN Status = "FAILURE" THEN "Failure"
            ELSE "Pending"
        END Status,
        add_date as Trxndate,message as Reason,mode as Trxntype,Amount,"" as OperatorName FROM `mt3_transfer`
        where user_id = ?
ORDER BY `mt3_transfer`.`Id`  DESC limit 10',array($user_id));
      echo json_encode($rsltreport->result());exit;

    }
    public function BankNameList()
    {
        header('Content-Type: application/json');
        $rsltbank = $this->db->query("select * from bank_master");
        echo json_encode(json_encode($rsltbank->result()));exit;
        //echo $str;exit;
    }
    public function Showtransaction()
    {
      header('Content-Type: application/json;charset=utf-8;');
      echo '"one Rupees only."';exit;
    }
    public function DoFundTransfer()
    {
     
      /*
          {"number":"8238232303","remitterID":"","name":"Ravikant Ravikant","rcptID":"8238232303","accountNo":"103201500069","ifscCode":"ICIC0000001","rcptName":"Tejas Badiyani","bankName":"Australia And New Zealand Banking Group Limited","amount":"100","paymentType":"IMPS","refernceNumber":1}
      */
       $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("MdId")));
       header('Content-Type: application/json');
       if($user_info->num_rows() == 1)
       {
          $user_id = $user_info->row(0)->user_id;
          $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
          if(isset($json_obj->number) and isset($json_obj->name) and isset($json_obj->rcptID)  and isset($json_obj->accountNo) and
            isset($json_obj->ifscCode) and isset($json_obj->rcptName) and isset($json_obj->bankName)  and isset($json_obj->amount) and
            isset($json_obj->paymentType) and isset($json_obj->refernceNumber))
          {

            $number =  trim((string)$json_obj->number);
            $name =  trim((string)$json_obj->name);
            $rcptID =  trim((string)$json_obj->rcptID);
            $accountNo =  trim((string)$json_obj->accountNo);
            $ifscCode =  trim((string)$json_obj->ifscCode);
            $rcptName =  trim((string)$json_obj->rcptName);
            $bankName =  trim((string)$json_obj->bankName);
            $amount =  trim((string)$json_obj->amount);
            $paymentType =  trim((string)$json_obj->paymentType);
            $refernceNumber =  trim((string)$json_obj->refernceNumber);
            


            $balance = $this->Ew2->getAgentBalance($user_id);
            if($balance > ($amount + 25))
            {
                
                $NUMBER = $number;
                $type = $paymentType;
                $account = $accountNo;
                $ifsc = $ifscCode;
                $dmtpin = "";
                $amount = $amount;
                $bankname = $bankName;

                $benCode = $rcptID;
                $servicefee = 0;
                $idprooftype = 0;
                $idproofnumber = "";


                $order_id = 0;
                $remittermobile = $NUMBER;
                $beneficiaryid = $benCode;
                $mode = $type;
                $unique_id = 0;
                $done_by = "WEB";
                $bank_id = $benCode;
                $whole_amount = $amount;
                $bene_id = $beneficiaryid;

                $user_id = $this->session->userdata("MdId");

                $userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,parentid,mt_access,txn_password,password from tblusers where user_id = ?",array($user_id));
                    if($userinfo->num_rows() == 1)
                    {
                        $status = $userinfo->row(0)->status;
                        $user_id = $userinfo->row(0)->user_id;
                        $businessname = $userinfo->row(0)->businessname;
                        $username = $userinfo->row(0)->username;
                        $mobile_no = $userinfo->row(0)->mobile_no;
                        $usertype_name = $userinfo->row(0)->usertype_name;
                        $mt_access = $userinfo->row(0)->mt_access;
                        $txn_password = $userinfo->row(0)->txn_password;
                        $login_password = $userinfo->row(0)->password;
                        if($status == '1')
                        {
                            
                            if($amount > 25000)
                            {
                              $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Invalid Amount",
                                            );
                              echo json_encode($resp_array);exit;
                                
                            }
                        
                            if(ctype_digit($remittermobile))
                            {
                                $insta_remitterid = false;

                                $checkbeneexist = $this->db->query("select * from beneficiaries 
                                                                                where sender_mobile  = ? and Id  = ? ",
                                                                                array($remittermobile,$bene_id));
                                            // echo "resp here : ";
                                // print_r($checkbeneexist->result());exit;
                                if($checkbeneexist->num_rows() >= 1)
                                {
                                    if($this->checkduplicate($amount,$user_id,$remittermobile, $bene_id,"IMPS"))
                                    {
                                        $this->load->model("Paytm");
                                        $resparray = array();
                                        $amounts_arr = $this->getamountarray(intval($amount));
                                        $whole_amount = intval($amount);
                                        $data = array(
                                                'user_id' => $user_id,
                                                'add_date'  => $this->common->getDate(),
                                                'ipaddress'  => $this->common->getRealIpAddr(),
                                                'whole_amount'  => $whole_amount,
                                                'fraction_json'  =>json_encode($amounts_arr),
                                                'remitter_id'  => $remittermobile,
                                                'remitter_mobile'  => $remittermobile,
                                                'remitter_name'  => '',
                                                'account_no'  => $checkbeneexist->row(0)->account_number,
                                                'ifsc'  => $checkbeneexist->row(0)->IFSC,
                                                'bene_name'  => $checkbeneexist->row(0)->bene_name,
                                                'bene_id'  => $checkbeneexist->row(0)->paytm_bene_id,
                                                'API'  => 'PAYTM',
                                        );
                                        $insertresp = $this->db->insert('mt3_uniquetxnid', $data);
                                        if($insertresp == true)
                                        {
                                            $unique_id =  $this->db->insert_id();
                                            //echo $unique_id;exit;
                                            foreach($amounts_arr as $amt)
                                            {
                                                $beneficiaryid = $checkbeneexist->row(0)->paytm_bene_id;
                                                $amount = $amt;
                                                $balance = $this->Ew2->getAgentBalance($user_id);
                                                $beneficiary_array = $checkbeneexist;
                                                if(floatval($balance) > $amount)
                                                {
                                                    $resp =  $this->Paytm->transfer($remittermobile,$beneficiary_array,$amount,$mode,$userinfo,0,$unique_id);
                                                    //($remittermobile,$beneficiaryid,$amount,$mode,$userinfo,$unique_id,"ANDROID",$bank_id,$whole_amount);

                                                    //array_push($resparray,json_decode($resp));        
                                                }
                                                    
                                                    
                                            }

                                            $resp_array = array(
                                              "StatusCode"=>1,
                                              "Message"=>"Transfer Successful",
                                              "TransactionRef"=>$unique_id,
                                              "OrderID"=>""
                                            );
                                            echo json_encode($resp_array);exit;
                                        }
                                        else
                                        {
                                          $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Internal Server Occured",
                                            );
                                          echo json_encode($resp_array);exit;
                                        }
                                    }
                                    else
                                    {
                                        $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Duplicate Entry.Try After 1 Hour",
                                            );
                                          echo json_encode($resp_array);exit;
                                    }
                                }
                                else
                                {
                                    $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Internal Server Occured",
                                            );
                                          echo json_encode($resp_array);exit;
                                }
                            }
                            else
                            {
                                $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Invalid Mobile Number",
                                            );
                                          echo json_encode($resp_array);exit;
                            }
                            
                        }
                        else
                        {
                            $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Your account is deactivated. contact your Administrator",
                                            );
                                          echo json_encode($resp_array);exit;
                        }
                    }
                    else
                    {
                      $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Authentication Failed",
                                            );
                                          echo json_encode($resp_array);exit;
                    }
                /*
final response *********************

{"StatusCode":1,"Message":"Transfer Successful","TransactionRef":188608,"OrderID":100564216}
                */
            }
            else
            {
              $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"InSufficient Balance",
                                            );
                              echo json_encode($resp_array);exit;
            }
          }
       } 
    }
    public function TransferAmountDetails()
    {
      $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("MdId")));
       header('Content-Type: application/json');
       if($user_info->num_rows() == 1)
       {
          $user_id = $user_info->row(0)->user_id;
          $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
          if(isset($json_obj->amount) and isset($json_obj->mobileNumber) and isset($json_obj->accountNo)  and isset($json_obj->tPin) )
          {

            $amount =  trim((string)$json_obj->amount);
            $mobileNumber =  trim((string)$json_obj->mobileNumber);
            $accountNo =  trim((string)$json_obj->accountNo);
            $tPin =  trim((string)$json_obj->tPin);
            $balance = $this->Ew2->getAgentBalance($user_id);
            if($balance > ($amount + 25))
            {
                $amount_split_array  = array();
                $temparray = array(
                                    "SLNO"=>1,
                                    "Amount"=>$amount,
                                    "ServiceCharge"=> (($amount * 1)/100),
                                    "MarginAmount"=>3,
                                    "Total"=>$amount + (($amount * 1)/100) - 3
                                  );
                array_push($amount_split_array,$temparray);

                $resp_array = array(
                    "StatusCode"=>1,
                    "Message"=>"Success",
                    "Data"=>$amount_split_array,
                    "TotalAmount"=>$amount,
                    "CustomerPayAmount"=>$amount,
                    "TotalCharge"=>7,
                    "TotalMargin"=>3,
                    "TxnRefNumber"=>0001
              );

              echo json_encode($resp_array);exit;

                  /*
                  "{\"StatusCode\":1,\"Message\":\"Success\",\"Data\":[{\"SLNO\":1,\"Amount\":\"100\",\"ServiceCharge\":1,\"MarginAmount\":3,\"Total\":98}],\"TotalAmount\":\"100\",\"CustomerPayAmount\":\"100\",\"TotalCharge\":7,\"TotalMargin\":3,\"TxnRefNumber\":1}"


                  {"StatusCode":1,"Message":"Success","Data":[{"SLNO":1,"Amount":100,"ServiceCharge":10.00,"MarginAmount":3.00,"Total":107.00}],"TotalAmount":107.00,"CustomerPayAmount":110.00,"TotalCharge":10.00,"TotalMargin":3.00,"TxnRefNumber":188578}
                  */
            }
            else
            {

              $resp_array = array(
                    "StatusCode"=>0,
                    "Message"=>"ou don\u0027t have sufficient balance to transaction",
                    "Data"=>null,
                    "TotalAmount"=>0,
                    "CustomerPayAmount"=>0,
                    "TotalCharge"=>0,
                    "TotalMargin"=>0,
                    "TxnRefNumber"=>0
              );

              echo json_encode($resp_array);exit;
            }
          }
       }
      
      /*
      {amount: "10", mobileNumber: "8238232303", accountNo: "31360526355", tPin: "1234"}
      */
      
    }
    public function RemiRegistration()
    {
      error_reporting(-1);
ini_set('display_errors',1);
$this->db->db_debug = TRUE;
      /*
      {number: "8866142003", fname: "ravikant", lName: "chavda", pinCode: "380001", otp: "123456"}
      */
      header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number) and isset($json_obj->fname) and isset($json_obj->lName)  and isset($json_obj->pinCode)  and isset($json_obj->otp))
      {

        $number =  trim((string)$json_obj->number);
        $fname =  trim((string)$json_obj->fname);
        $lName =  trim((string)$json_obj->lName);
        $pinCode =  trim((string)$json_obj->pinCode);
        $otp =  trim((string)$json_obj->otp);


        $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("MdId")));
        

        $address1 = "ahmedabad";
        $address2 = "gujarat";
        $requset_id = "";

        $requestid_rslt = $this->db->query("select request_id from sender_registration_getotp where sender_mobile = ? order by Id desc limit 1",array($number));
        if($requestid_rslt->num_rows() == 1)
        {
          $requset_id = $requestid_rslt->row(0)->request_id;
        }
       // echo $number." ".$fname." ".$lName." ".$pinCode." ".$otp."  ".$requset_id;exit;
        $this->load->model("Paytm");
        $remiter_detail = $this->Paytm->remitter_registration($number,$fname,$lName,$address1,$address2,$pinCode,$requset_id,$otp,$user_info);
        //($number,$user_info,"registrationOtp");
        echo json_encode($remiter_detail);exit;
      }
    }
    public function GenerateReference()
    {

error_reporting(-1);
ini_set('display_errors',1);
$this->db->db_debug = TRUE;

      header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number))
      {
        $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("MdId")));
        $number =  trim((string)$json_obj->number);
        $this->load->model("Paytm");
        $remiter_detail = $this->Paytm->remitter_registration_getotp($number,$user_info,"registrationOtp");
        echo json_encode($remiter_detail);exit;
      }



     // $resp = '"{\r\n  \"StatusCode\": 1,\r\n  \"Message\": \"OTP sent on mobile number.\",\r\n  \"Data\": null\r\n}"';
    }
    public function ValidateSender()
    {
       header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number))
      {
        $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("MdId")));
        $number =  trim((string)$json_obj->number);
        $this->load->model("Paytm");
        $remiter_detail = $this->Paytm->remitter_details($number,$user_info);
        $json_obj = json_decode($remiter_detail);
        //echo $remiter_detail;exit;
        if(isset($json_obj->status) and isset($json_obj->response_code))
        {
          $status = trim($json_obj->status);
          $response_code = trim($json_obj->response_code);
          if($status == "success")
          {
            if($response_code == "1032")
            {
              $resp_arr = array(
                                "StatusCode"=>2,
                                "Message"=>"Remitter mobile number not exist",
                                "Data"=>null
              );
              echo json_encode(json_encode($resp_arr));exit;
            }
            else
            {
                $firstName = trim($json_obj->firstName);
              $lastName = trim($json_obj->lastName);
              $customerMobile = trim($json_obj->customerMobile);
              $limitLeft = trim($json_obj->limitLeft);


              $resparra["StatusCode"] = 1;
                $resparra["Message"] = "Success";
                $resparra["Data"] = array(
                    "MobileNo"=>$customerMobile,
                    "Name"=>$firstName." ".$lastName,
                    "RemitterID"=>"",
                    "PinCode"=>"411041",
                    "MonthlyLimit"=> 25000.00,
                    "AvailableLimit"=>$limitLeft,
                    "AvailableLimit2"=>0,
                    "AvailableLimit3"=>0,
                );       
                echo json_encode(json_encode($resparra));exit;
            }
          }
          else
          {

            $resp_arr = array(
                                "StatusCode"=>2,
                                "Message"=>"Remitter mobile number not exist",
                                "Data"=>null
            );
            echo json_encode(json_encode($resp_arr));exit;
          }
        }
        else
        {
          $resp_arr = array(
                                "StatusCode"=>2,
                                "Message"=>"Remitter mobile number not exist",
                                "Data"=>null
            );
            echo json_encode(json_encode($resp_arr));exit;
        }
        
      }
     
        header('Content-Type: application/json');
        $str = '"{\"StatusCode\":1,\"Message\":\"Success\",\"Data\":{\"MobileNo\":\"8866142009\",\"Name\":\"ravikant chavda\",\"RemitterID\":\"\",\"PinCode\":\"411041\",\"MonthlyLimit\":25000,\"AvailableLimit\":\"25000\",\"AvailableLimit2\":0,\"AvailableLimit3\":0}}"';


        /*$str = '"{\"StatusCode\": 1,\"Message\": \"Success\",\"Data\": {\"MobileNo\": \"8238232303\",\"Name\": \"Ravikant Ravikant\",\"RemitterID\": \"290016840\",\"PinCode\": 411041,\"MonthlyLimit\": 25000.00,\"AvailableLimit\": 25000.0,\"AvailableLimit2\": 24594.0,\"AvailableLimit3\": 25000.00}}"';*/

        $resparra["StatusCode"] = 1;
        $resparra["Message"] = "Success";
        $resparra["Data"] = array(
            "MobileNo"=>"8238232303",
            "Name"=>"Ravikant Ravikant",
            "RemitterID"=>"290016840",
            "PinCode"=>"411041",
            "MonthlyLimit"=> 25000.00,
            "AvailableLimit"=>25000.0,
            "AvailableLimit2"=>24594.0,
            "AvailableLimit3"=>25000.00,
        );       
        echo json_encode(json_encode($resparra));exit;
    }
    public function SenderBeneficiaryList()
    {
       header('Content-Type: application/json');
       $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number))
      {
        $this->load->model("Paytm");
         $mobile_no =$json_obj->number;
         $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("MdId")));
         $bene_list = $this->Paytm->getbenelist2($mobile_no,$user_info,0,0);
         echo json_encode($bene_list);exit; 
      }


       
    }

    public function RcptRegistration()
    {

      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;

      header('Content-Type: application/json');
      $this->load->model("Paytm");
       $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("MdId")));
      //header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number) and isset($json_obj->remitterID) and isset($json_obj->name) and isset($json_obj->accountNo)  and isset($json_obj->ifscCode)  and isset($json_obj->bankID)  )
      {
          $mobile_no = trim($json_obj->number);
          $remitterID = trim($json_obj->remitterID);
          $bene_name = trim($json_obj->name);
          $acc_no = trim($json_obj->accountNo);
          $ifsc = trim($json_obj->ifscCode);
          $bank = trim($json_obj->bankID);
          $verify = trim($json_obj->verify);


         // echo $bank;exit;


          $apiresponse = $this->Paytm->add_benificiary($mobile_no,$bene_name,$mobile_no,$acc_no,$ifsc,$bank,$user_info);
          echo json_encode($apiresponse);exit;
          /*
          "{\r\n  \"StatusCode\": 1,\r\n  \"Message\": \"Recipient added successfully.\",\r\n  \"Data\": {\r\n    \"RecipientCode\": 390135416\r\n  }\r\n}"
          */
      }
      else
      {
          $resp_array = array("StatusCode"=>0,"Message"=>"Sum Error Occured");
          echo json_encode(json_encode($resp_array));exit;
      }
    }


    public function getDate()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$date = date("Y-m-d h");		
		return $date; 
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
	 public function get_string_between($string, $start, $end)
	 { 
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}

    public function Delete_ben()
    {
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        if(isset($_POST["benid"]) and isset($_POST["senderno"]))
        {
            $benid = $this->input->post("benid");
            $senderno = $this->input->post("senderno");    
             header('Content-Type: application/json');



             $user_id = $this->session->userdata("MdId");
             $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
            $this->load->model("Instapay");
            $resp = $this->Instapay->beneficiary_remove($senderno,$benid,$userinfo); 
            echo '{"statuscode":"TXN","status":"Otp Sent To Registered Mobile Number","data":{"otp":"1"}}';;exit;
            echo '{"statuscode":"TXN","status":"Beneficiary Delete Successfully","data":{"otp":"0"}}';;exit;
            /*
            {"statuscode":"TXN","status":"Beneficiary Delete Successfully","data":{"otp":"0"}}
            */
        }
        
    }

	public function Imps_check_transfer()
	{
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
		$dmtpin = "";
		$account = "";
		$amount = "";

		if(isset($_POST["dmtpin"]) and isset($_POST["account"]) and isset($_POST["amount"]))
		{
			$dmtpin = trim($this->input->post("dmtpin"));
			$account = trim($this->input->post("account"));
			$amount = trim($this->input->post("amount"));

        header('Content-Type: application/json');

            echo '{"Details":"","status":"Success"}';exit;
		}



		/*
				{"Details":"","status":"Success"}

				{"Details":"Wrong Pin!!! Please Enter Correct Pin!!!","status":"Failed"}

				{"Details":" Amount Should be Greater Than Rs. 100","status":"Failed"}
		*/

	}

    public function imps_transfer()
    {
    	header('Content-Type: application/json');
    	error_reporting(-1);
    	ini_set('display_errors',1);
    	$this->db->db_debug = TRUE;
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        if(isset($_POST["NUMBER"]) and isset($_POST["type"]) and isset($_POST["account"]) and isset($_POST["ifsc"]))
        {
            $NUMBER = $this->input->post("NUMBER");
            $type = $this->input->post("type");
            $account = $this->input->post("account");
            $ifsc = $this->input->post("ifsc");
            $dmtpin = $this->input->post("dmtpin");
            $amount = $this->input->post("amount");
            $bankname = $this->input->post("bankname");

            $benCode = $this->input->post("benCode");
            $servicefee = $this->input->post("servicefee");
            $idprooftype = $this->input->post("idprooftype");
            $idproofnumber = $this->input->post("idproofnumber");


            $order_id = 0;
            $remittermobile = $NUMBER;
            $beneficiaryid = $benCode;
            $mode = $type;
            $unique_id = 0;
            $done_by = "WEB";
            $bank_id = $benCode;
            $whole_amount = $amount;
            $bene_id = $beneficiaryid;

            $user_id = $this->session->userdata("MdId");
            $userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no,parentid,mt_access,txn_password,password from tblusers where user_id = ?",array($user_id));
                if($userinfo->num_rows() == 1)
                {
                    $status = $userinfo->row(0)->status;
                    $user_id = $userinfo->row(0)->user_id;
                    $businessname = $userinfo->row(0)->businessname;
                    $username = $userinfo->row(0)->username;
                    $mobile_no = $userinfo->row(0)->mobile_no;
                    $usertype_name = $userinfo->row(0)->usertype_name;
                    $mt_access = $userinfo->row(0)->mt_access;
                    $txn_password = $userinfo->row(0)->txn_password;
                    $login_password = $userinfo->row(0)->password;
                    if($status == '1')
                    {
                       
                        if($login_password != $dmtpin)
                        {
                            $resp_arr = array(
                                "message"=>"Invalid Transaction Password",
                                "status"=>1,
                                "statuscode"=>"ERR",
                                );
                            $json_resp =  json_encode($resp_arr);
                            echo $json_resp;exit;
                        }
                        if($mt_access != '1')
                        {
                            $resp_arr = array(
                                "message"=>"Service Down. Try After Some Time",
                                "status"=>1,
                                "statuscode"=>"ERR",
                                );
                            $json_resp =  json_encode($resp_arr);
                            echo $json_resp;exit;
                        }
                        if($amount > 25000)
                        {
                            $resp_arr = array(
                                        "message"=>"Invalid Amount",
                                        "status"=>1,
                                        "statuscode"=>"ERR",
                                        );
                            $json_resp =  json_encode($resp_arr);
                            echo $json_resp;exit;
                        }
                    
                        if(ctype_digit($remittermobile))
                        {


                            $insta_remitterid = false;

                            $sender_info = $this->db->query("select * from remitters where mobile  = ?",array($remittermobile));
                            if($sender_info->num_rows() == 1)
                            {
                                $insert_rslt = true;
                                $insta_verified =  $sender_info->row(0)->insta_verified;
                                $insta_remitter_id =  $sender_info->row(0)->insta_remitter_id;
                                if($insta_remitter_id > 0)
                                {
                                    $insta_remitterid = $insta_remitter_id;
                                }
                            }



                            
                            $checkbeneexist = $this->db->query("select bene_name,benemobile,IFSC,account_number,insta_bene_id,insta_remitter_id from beneficiaries 
                                                                            where insta_remitter_id  = ? and insta_bene_id  = ? ",
                                                                            array($insta_remitterid,$bene_id));
                                        // echo "resp here : ";
                            // print_r($checkbeneexist->result());exit;
                            if($checkbeneexist->num_rows() >= 1)
                            {
                                if($this->checkduplicate($amount,$user_id,$insta_remitterid, $bene_id,"IMPS"))
                                {
                                    $this->load->model("Instapay");
                                    $resparray = array();
                                    $amounts_arr = $this->getamountarray(intval($amount));
                                    $whole_amount = intval($amount);
                                    $data = array(
                                            'user_id' => $user_id,
                                            'add_date'  => $this->common->getDate(),
                                            'ipaddress'  => $this->common->getRealIpAddr(),
                                            'whole_amount'  => $whole_amount,
                                            'fraction_json'  =>json_encode($amounts_arr),
                                            'remitter_id'  => $checkbeneexist->row(0)->insta_remitter_id,
                                            'remitter_mobile'  => $remittermobile,
                                            'remitter_name'  => '',
                                            'account_no'  => $checkbeneexist->row(0)->account_number,
                                            'ifsc'  => $checkbeneexist->row(0)->IFSC,
                                            'bene_name'  => $checkbeneexist->row(0)->bene_name,
                                            'bene_id'  => $checkbeneexist->row(0)->insta_bene_id,
                                            'API'  => 'INSTAPAY',
                                    );
                                    $insertresp = $this->db->insert('mt3_uniquetxnid', $data);
                                    if($insertresp == true)
                                    {
                                        $unique_id =  $this->db->insert_id();
                                        //echo $unique_id;exit;
                                        foreach($amounts_arr as $amt)
                                        {
                                            $beneficiaryid = $checkbeneexist->row(0)->insta_bene_id;
                                            $amount = $amt;
                                            $balance = $this->Common_methods->getAgentBalance($user_id);
                                            
                                            if(floatval($balance) > $amount)
                                            {
                                                $resp =  $this->Instapay->transfer2($remittermobile,$beneficiaryid,$amount,$mode,$userinfo,$unique_id,"ANDROID",$bank_id,$whole_amount);

                                                array_push($resparray,json_decode($resp));        
                                            }
                                                
                                                
                                        }

                                        $total_transfer = 0;
                                        $rlstcheck_done = $this->db->query("SELECT a.unique_id,a.Id,a.add_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock

FROM `mt3_transfer` a

 where a.unique_id = ? order by a.Id desc",array($unique_id));
                                        if($rlstcheck_done->num_rows() >= 1)
                                        {
                                        	$main_status = "Pending";
                                        	$main_status_done = false;
                                        	$detail_array = array();
                                        	foreach ($rlstcheck_done->result() as $res_prt) 
                                        	{

                                        		if($res_prt->Status == "SUCCESS" and $main_status_done == false)
                                        		{
                                        			$main_status = "Success";
                                        			$main_status_done = true;
                                        			$total_transfer += $res_prt->Amount;
                                        		}
                                        		else if($res_prt->Status == "PENDING" and $main_status_done == false)
                                        		{
                                        			$main_status = "Pending";
                                        			$main_status_done = true;
                                        			$total_transfer += $res_prt->Amount;
                                        		}
                                        		else if(($res_prt->Status == "FAILURE" or $res_prt->Status == "FAILED") and $main_status_done == false)
                                        		{
                                        			$main_status = "Failed";
                                        			$main_status_done = true;
                                        		}
                                        		$temparray = array(
                                        			"Amount"=>$res_prt->Amount,
                                        			"Status"=>$res_prt->Status,
                                        			"bankrefid"=>$res_prt->RESP_opr_id
                                        		);
                                        		array_push($detail_array,$temparray);
                                        	}


                                        	$resparray = array(
                                        		"Accountno"=>$rlstcheck_done->row(0)->AccountNumber,
                                        		"Ifsccode"=>$rlstcheck_done->row(0)->IFSC,
                                        		"BankName"=>"",
                                        		"TotalAmount"=>$total_transfer,
                                        		"Time"=>$rlstcheck_done->row(0)->add_date,
                                        		"orderid"=>$rlstcheck_done->row(0)->Id,
                                        		"logo"=>"",
                                        		"firmname"=>$rlstcheck_done->row(0)->RESP_name,
                                        		"servicefee"=>"0",
                                        		"tax"=>"0",
                                        		"total"=>$rlstcheck_done->row(0)->Amount,
                                        		"remainretailer"=>"",
                                        		"status"=>$main_status,
                                        		"data"=>$detail_array
                                        	);
                                        }
                                        echo json_encode($resparray);exit;
                                    }
                                    else
                                    {
                                        $resp_arr = array(
                                            "message"=>"Internal Server Occured",
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
                                        "message"=>"Duplicate Entry.Try After 1 Hour",
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
                                        "message"=>"Internal Server Occured",
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



            // $this->load->model("Instapay");
            // $resp = $this->Instapay->transfer2($remittermobile,$beneficiaryid,$amount,$mode,$userinfo,$unique_id,$done_by,$bank_id,$whole_amount,$order_id);
            //echo $resp;exit;
        }
        

    }


	public function DMTreportnew()
	{
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
		$strres= '
<style>
    #example tbody tr td{padding:10px;}
</style>
<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="width: 186px;">Beneficiary&nbsp;Account</th>

                <th>Amount</th>
                <th>Beneficiary&nbsp;Bank&nbsp;Name</th>
                <th>Time</th>

                <th>Bank&nbsp;RRN</th>
   
            </tr>
        </thead>
            <tbody>';

            $user_id = $this->session->userdata("MdId");
                $rsltdmr = $this->db->query("SELECT bank.bank_name,a.unique_id,a.Id,a.add_date,a.edit_date,a.user_id,a.DId,a.MdId,a.Charge_type,a.charge_value,a.Charge_Amount,a.RemiterMobile,
a.debit_amount,a.credit_amount,a.remitter_id,a.BeneficiaryId,a.AccountNumber,
a.IFSC,a.Amount,a.Status,a.debited, a.ewallet_id,a.balance,a.remark,a.mode,
a.RESP_statuscode,a.RESP_status,a.RESP_ipay_id,a.RESP_ref_no,a.RESP_opr_id,a.RESP_name,a.row_lock,
b.businessname,b.mobile_no


FROM `mt3_transfer` a
left join tblusers b on a.user_id = b.user_id
left join dezire_banklist bank on a.bank_id = bank.Id
where a.user_id = ? order by Id desc limit 10",array($user_id));
                foreach($rsltdmr->result() as $rwdmr)
                {
                    $strres .= '<tr>
                        <td>
                            <img style="height:20px;width:20px;margin-right:3px;float:left; background-color:green;" src=../../ashok-images/correct.svg />
                            '.$rwdmr->AccountNumber.'
                        </td>

                        <td>'.$rwdmr->Amount.'</td>
                        <td>'.$rwdmr->RESP_name.'</td>
                        <td>'.$rwdmr->add_date.'</td>

                        <td>'.$rwdmr->RESP_opr_id.'</td>
                    </tr>';
                }
                    
            $strres .= '</tbody>
</table>';
$strres .= '<script>
    $(document).ready(function () {
        $("#example").dataTable({
            "searching": false,
            "bPaginate": false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true
        });
    });
</script>';


$strres .= '<div class="modal mastetr222Modal in" id="aepstableclickpop" tabindex="-1" role="dialog" style="display: none;">
    
    <div class="col-md-4 new-prent-page" id="aepspopshow">
        <div class="body-border-bottom" style="margin-bottom: 20px;">
            <button type="button" class="btn waves-effect" data-dismiss="modal">
                <i class="fa fa-times fulltextbodycolor fullbodydycolorbg" aria-hidden="true"></i>
            </button>
        </div>
        <div class="col-md-12 Confirm-Payment">
            
            <div class="container-fluid">
                <div class="col-md-6 successful">
                    <p>Transaction Successful</p>
                    <span> </span>
                </div>
               
            </div>
            <div class="container-fluid transaction" style="width:100%;">
                <p style="color:white;">transaction details</p>
                <ul class="transaction-detail" style="width:100%;">
                    <li class="transaction-left"><span>Retailer Firm</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                    <li class="transaction-left"><span>Aadhaar Number</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                    <li class="transaction-left"><span>Register Mobile</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                    <li class="transaction-left"><span>AEPS Mode</span></li>
                    <li class="transaction-right" style="float:right;"><span>BALANCE</span></li>
                    <li class="transaction-left"><span>A/C Remain</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                </ul>

            </div>
        </div>
    </div>
    </div>
    




<div class="modal mastetr222Modal in" id="aepstableclickpopee" tabindex="-1" role="dialog" style="display: none;">

    <div class="col-md-4 new-prent-page" id="aepspopshowe">
        <div class="body-border-bottom" style="margin-bottom: 20px;">
            <button type="button" class="btn waves-effect" data-dismiss="modal">
                <i class="fa fa-times fulltextbodycolor fullbodydycolorbg" aria-hidden="true"></i>
            </button>
        </div>
        <div class="col-md-12 Confirm-Payment">

            <div class="container-fluid">
                <div class="col-md-6 successful">
                    <p>Transaction Successful</p>
                    <span> </span>
                </div>

            </div>
            <div class="container-fluid transaction" style="width:100%;">
                <p style="color:white;">transaction details</p>
                <ul class="transaction-detail" style="width:100%;">
                    <li class="transaction-left"><span>Retailer Firm</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                    <li class="transaction-left"><span>Aadhaar Number</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                    <li class="transaction-left"><span>Register Mobile</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                    <li class="transaction-left"><span>AEPS Mode</span></li>
                    <li class="transaction-right" style="float:right;"><span>BALANCE</span></li>
                    <li class="transaction-left"><span>A/C Remain</span></li>
                    <li class="transaction-right" style="float:right;"><span></span></li>
                </ul>

            </div>
        </div>
    </div>
</div>';

echo $strres;exit;
	}



	public function Otp_verify_sender()
	{
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        header('Content-Type: application/json');

		$mobile_no = $this->input->post("senderno");
		$otp = $this->input->post("otp");
		$benid = $this->input->post("benid");
        $user_id = $this->session->userdata("MdId");
        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
        if($userinfo->num_rows() == 1)
        {
            $this->load->model("Instapay");
            $resp = $this->Instapay->remitter_resend_otp2($mobile_no,$otp,$userinfo);

            $json_obj = json_decode($resp);
            if(isset($json_obj->statuscode) and isset($json_obj->message))
            {
                $statuscode = $json_obj->statuscode;
                $message = $json_obj->message;
                $status = $json_obj->status;
                if($statuscode == "TXN")
                {
                    $resparray = array(
                            "statuscode"=>$statuscode,
                            "status"=>$message,
                            "data"=>array()
                    );
                    echo json_encode($resparray);exit;
                }
                else
                {
                    $resparray = array(
                            "statuscode"=>$statuscode,
                            "status"=>$message,
                            "data"=>array()
                    );
                    echo json_encode($resparray);exit;
                }
            }
            else
            {
                $resparray = array(
                            "statuscode"=>"ERR",
                            "status"=>"Unknown Response From Server",
                            "data"=>array()
                    );
                echo json_encode($resparray);exit;
            }
        }

		/*
			{"statuscode":"ERR","status":"downstream system fails","data":{}}
		*/
	}
	public function Register_sender() // it also used for resend otp
	{
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        $user_id = $this->session->userdata("MdId");
        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
        if($userinfo->num_rows() == 1)
        {
            if(isset($_POST["senderno"]) and isset($_POST["name"]))
            {
                $mobile_no = $this->input->post("senderno");
                $firstname = $this->input->post("name");
                $lastname = "abc";
                $pincode = "380001";
                $this->load->model("Instapay");
                $resp =  $this->Instapay->remitter_registration2($mobile_no,$firstname,$lastname,$pincode,$userinfo);

                header('Content-Type: application/json');

                $json_obj = json_decode($resp);
                if(isset($json_obj->message) and isset($json_obj->statuscode))
                {
                    $message = $json_obj->message;
                    $statuscode = $json_obj->statuscode;
                    if($statuscode == "TXN")
                    {
                        $is_verified = $json_obj->is_verified;
                        $remitter = array(
                            "id"=>$mobile_no,
                            "is_verified"=>$is_verified
                        );
                        $resp_array = array(
                            "statuscode"=>$statuscode,
                            "status"=>$message,
                            "data"=>array(
                                "remitter"=>$remitter
                            ),
                        );
                        echo json_encode($resp_array);exit;
                    }
                    else
                    {
                        $resp_array = array(
                            "statuscode"=>$statuscode,
                            "status"=>$message
                        );
                        echo json_encode($resp_array);exit;
                    }
                }
                else
                {
                    $resp_array = array(
                            "statuscode"=>"ERR",
                            "status"=>"Invalid Response From Server. Please Try Again"
                        );
                    echo json_encode($resp_array);exit;
                }
            }
            else
            {
                $resp_array = array(
                            "statuscode"=>"ERR",
                            "status"=>"Invalid Response From Server. Please Try Again"
                        );
                    echo json_encode($resp_array);exit;
            }
        }
		

		/*
				response

				{"statuscode":"TXN","status":"OTP sent successfully","data":{"remitter":{"id":"3eda39d4-b881-486c-8240-3389f9bb5bf8","is_verified":0}}}
		*/
	}
	public function Senderdetails()
	{
        header('Content-Type: application/json');
		if(isset($_POST["senderno"]))
		{

    		if($this->session->userdata('MdUserType') != "MasterDealer") 
    		{ 
    			echo "LOGIN_FAILED";exit;
    		} 

            $user_id = $this->session->userdata("MdId");
            $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));
    		$mobile_no = trim($this->input->post("senderno"));


            $this->load->model("Instapay");
            $senderinfo = $this->Instapay->remitter_details($mobile_no,$userinfo);
            $json_obj = json_decode($senderinfo);
            if(isset($json_obj->statuscode) and isset($json_obj->status)  and isset($json_obj->message))
            {
                $statuscode = $json_obj->statuscode;
                $status = $json_obj->status;
                $message = $json_obj->message;
                if($statuscode == "TXN")
                {
                    $remitter = $json_obj->remitter;
                    $beneficiary = $json_obj->beneficiary; 
                    $resparray = array(
                        "statuscode"=>$statuscode,
                        "status"=>$status,
                        "data"=>array(
                            "remitter"=>$remitter,
                            "beneficiary" => $beneficiary
                        )
                    );   
                     echo json_encode(json_encode($resparray));exit;
                }
                else
                {
                    $resparray = array(
                        "statuscode"=>$statuscode,
                        "status"=>$message,
                        "data"=>array(
                            "beneficiary" => array()
                        )
                    );   
                     echo json_encode(json_encode($resparray));exit;
                   // echo '{\"statuscode\":\"RNF\",\"status\":\"User does not exists\",\"data\":{\"beneficiary\":[]}}';exit;
                }
            }
		}
	}
	public function BindBankDdllist()
	{
		echo '{"data":[{"Disabled":false,"Group":null,"Selected":false,"Text":"AIRTEL PAYMENTS BANK LIMITED","Value":"AIRP0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALLAHABAD BANK","Value":"ALLA0210001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"APNA SAHAKARI BANK LIMITED","Value":"ASBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALMORA URBAN COOPERATIVE BANK LIMITED","Value":"AUCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHARAT COOPERATIVE BANK MUMBAI LIMITED","Value":"BCBM0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CENTRAL BANK OF INDIA","Value":"CBIN0280658"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CENTRAL CO-OPERATIVE BANK LTD. ARA.","Value":"IBKL0722CCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CORPORATION BANK","Value":"CORP0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE COSMOS CO OPERATIVE BANK LIMITED","Value":"COSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CREDIT AGRICOLE CORPORATE AND INVESTMENT BANK CALYON BANK","Value":"CRLY0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DCB BANK LIMITED","Value":"DCBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HDFC BANK","Value":"HDFC0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ICICI BANK LIMITED","Value":"ICIC0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDIAN BANK","Value":"IDIB000A001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDIAN OVERSEAS BANK","Value":"IOBA0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAMMU AND KASHMIR BANK LIMITED","Value":"JAKA0AALLAH"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JALGAON JANATA SAHAKARI BANK LIMITED","Value":"JJSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAXMI VILAS BANK","Value":"LAVB0000101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK OF MAHARASHTRA","Value":"MAHB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALAGERIA CENTRAL CO-OPERATIVE BANK LTD","Value":"IBKL0752BCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANASKANTHA DISTRICT CENTRAL CO-OP. BANK LTD.","Value":"GSCB0BKD001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TELANGANA STATE CO OPERATIVE APEX BANK LIMITED","Value":"APBL0000138"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DIST COOP CENTRAL BANK KAKINADA KARAPA","Value":"APBL0004053"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KRISHNA DIST. CO-OP. CENTRAL BANK LTD.,PAYAKAPURAM","Value":"APBL0006052"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KRISHNA DCC BANK JAVVARPETA","Value":"APBL0006053"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GUNTUR DIST. CO-OP. CENTRAL BANK LTD., MANDADAM","Value":"APBL0007036"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI POTTI SRI RAMULU NELLORE DISTRICT COOPERATIVE CENTRAL BANK LTD., RAPUR","Value":"APBL0009019"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHITTOOR DCCB LTD ANGALLU","Value":"APBL0010028"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ADILABAD DCC BANK LTD., BRANCH BELA","Value":"APBL0019022"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DISTRICT CENTRAL CO-OP BANK LTD.,KHAMMAM, ROTARY NAGAR","Value":"APBL0022034"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HOWRAH DISTRICT CENTRAL CO-OPERTAIVE BANK LTD","Value":"GSCB0GRKB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AHMEDABD DISTRICT CO-OP. BANK LTD.","Value":"GSCB0ADC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHARUCH DISTRICT CENTRAL CO-OP. BANK LTD","Value":"GSCB0BRC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KODINAR TALUKA CO-OP. BANKING UNION LTD","Value":"GSCB0KDT001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HOWRAH DISTRICT CENTRAL CO-OPERTAIVE BANK LTD/ THE WEST BENGAL STATE COOPERATIVE BANK LTD","Value":"WBSC0HCCB14"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHATPARA NAIHATI COOP BANK LTD. BHATPARA MAIN BR","Value":"WBSC0BUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TAMLUK GHATAL CENTRAL COOPERATIVE BANK LTD","Value":"WBSC0TCCB18"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AKOLA MERCHANT CO OP BANK LTD","Value":"HDFC0CAMBLA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALWAYE URBAN CO-OP","Value":"FDRL0AUCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DARJEELING DISTRICT CENTRAL CO-OPERATIVE BANK LTD","Value":"WBSC0DJCB12"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GONDAL NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UGNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GUJARAT AMBUJA COOP BANK LTD","Value":"GSCB0UGACBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOLKATA POLICE CO-OPERATIVE BANK LTD","Value":"WBSC0KPCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UBABRA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ANDHRA PRADESH STATE COOPERATIVE BANK LIMITED","Value":"APBL0004050"},{"Disabled":false,"Group":null,"Selected":false,"Text":"A B BANK LIMITED","Value":"HDFC0CABBLM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ABHINANDAN URBAN COOP BANK LTD","Value":"HDFC0CACH05"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ABHINAV SAHKARI BK- NANDIVLI","Value":"SVCB0007017"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ACE COOPERATIVE BANK LTD","Value":"IBKL0100ACB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ADAR P.D.PATIL SAH BANK LTD. KARAD","Value":"HDFC0CPDPBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ADARSH CO-OPERATIVE BANK LTD.","Value":"HDFC0CADARS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ADARSH MAHILA MERCNT CO-OP BANK LTD","Value":"HDFC0CAMMCO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ADARSH MAHILA NAGARI SAHAKARI BANK AURANGABAD BRANCH","Value":"KKBK0AMSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AGARTALA CO OP URBAN BANK LTD","Value":"UTIB0SACUB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AHILYADEVI URBAN CO - OPERATIVE BANK LTD","Value":"IBKL0478ADC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AHMEDNAGAR DIST CENTRAL CO-OP BANK","Value":"UTIB0SADCC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AHMEDNAGAR SHAHAR S BK- GARKHEDA","Value":"SVCB0008018"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AHMEDNAGAR ZILLA PRATHMIK SHIKSHAK","Value":"UTIB0SAZP01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AJINKYATARA MAHILA SAHKARI BANK LTD","Value":"IBKL0451AMS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AJMER CENTRAL COOP BANK LTD","Value":"RSCB0011001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AKHAND ANAND CO OP BANK LTD","Value":"HDFC0CAACOB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALAPUZHA DISTRICT COOPERATIVE BANK","Value":"UTIB0SADC83"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALAVI CO-OPERATIVE BANK LIMITED","Value":"HDFC0CALAVI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALIBAG CO OP URBAN BANK LTD ALIBAG","Value":"IBKL0299ACB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALIGARH ZILLA SAHAKARI BANK LTD","Value":"ICIC00AZSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALLAHABAD DISTRICT COOPERATIVE BANK LTD.","Value":"ICIC00ALDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMAN SAHAKARI BANK LTD ICHALKARANJI","Value":"ICIC00AMSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMBAJOGAI PEOPLES CO-OP BANK LTD","Value":"HDFC0CAPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMBARNATH JAI HIND COOP BANK LTD","Value":"ICIC00AJHCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMBIKA MAHILA SAH BANK LTD","Value":"HDFC0CAMSBA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMBIKAPUR C G","Value":"UTIB0SJSA01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMRAVATI ZILLA MAHILA SAH BANK LTD","Value":"HDFC0CAZMSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMRELI JILLA SAHAKARI BANK LTD.","Value":"GSCB0AMR001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMRELI NAGRIK SAHKARI BANK LTD","Value":"IBKL0697ANS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANDAMAN and NICOBAR STATE COOP BANK LTD","Value":"HDFC0CANSCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANDHRA BANK","Value":"ANDB0CG7001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANDHRA PRADESH GRAMEEN VIKAS BANK RRB","Value":"SBIN0RRAPGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANNASAHEB MAGAR SAHAKARI BANK LTD. BHOSARI","Value":"IBKL0250A10"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANNASAHEB SAVANT CO OP URBAN BANK","Value":"HDFC0CMAHAD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AP MAHAJANS COOP URBAN BANK","Value":"UTIB0SAPM01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"APANI SAHAKARI BANK LTD.","Value":"HDFC0CAPANI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ARMY BASE WORKSHOP CREDIT CO PRIMARY BANK LTD","Value":"ICIC00ABWCC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ARUNACHAL PRADESH CO-OPERATIVE APEX BANK, NAHARLAGUN","Value":"IBKL0161APC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ARUNACHAL PRADESH RURAL BANK, NAHARILAGUN RRB","Value":"SBIN0RRARGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ARYAVART GB-GOMTI NAGAR BR","Value":"BKID0ARYAGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ASHOK NAGARI SAHKARI BK LTD-PIMPRI","Value":"SVCB0022002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ASHOK SAHAKARI BANK LTD","Value":"ICIC00ASHSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ASTHA MAHILA NAGRIK SAHAKARI BANK","Value":"HDFC0CAMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AZAD URBAN BANK-HO","Value":"IBKL0069AZB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BAGALKOT DIST CENTRAL COOP BANK LTD","Value":"IBKL01071BD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BAIDYABATI SHEORAPHULI COOP BANK","Value":"HDFC0CBDSCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALASINOR NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UBNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALASORE BHADRAK CENTRAL COOP LTD","Value":"HDFC0CBBCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALOTRA URBAN CO-OPERATIVE BANK LTD","Value":"ICIC00BALUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALTIKURI COOPERATIVE BANK LTD","Value":"HDFC0CBCBMN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALUSSERY COOP URBAN BANK LTD","Value":"IBKL0114BCU"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANARAS MERCANTILE CO-OPERATIVE BANK LTD","Value":"ICIC00BMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANASKANTHA MERCANTILE CO. BK. LTD","Value":"HDFC0CTBMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANDA DISTRICT CO-OPERATIVE BANK LTD","Value":"ICIC00BDCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANGALORE CITY COOP BANK","Value":"INDB0BCCB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANGALORE RURAL RAMANAGAR COOP BANK","Value":"KSCB0002001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BAPUJI CO-OPERATIVE BANK LTD, DAVANGERE","Value":"IBKL0364BCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BARAN KENDRIYA SAHAKARI BANKLTD","Value":"RSCB0039001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BARAN NAGRIK SAHKARI BANK LTD","Value":"HDFC0CBNB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BARODA CENTRAL CO-OP. BANK LTD.","Value":"GSCB0BRD001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BASODA NAGRIK SAHAKARI BANK MYDT","Value":"HDFC0CNSBGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BASTI ZILA SAHKARI BANK LTD. BASTI","Value":"ICIC00BDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BEAWAR URBAN CO-OPERATIVE BANK LTD","Value":"HDFC0CBWRUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BEED DISTRICT CENTRAL","Value":"UTIB0SBDCC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BELGAUM INDUSTRIAL COOP BANK LTD","Value":"HDFC0CBICBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BELGAUM ZILLA RANI CHANNAMMA MAHILA SAHAKARI BANK NIYAMIT","Value":"IBKL0101BZR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BETUL NAGRIK SAHAKARI BANK MARYADIT","Value":"UTIB0SBNSBM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHADRADRI C U BANK- BHADRACHALAM","Value":"SRCB0BCB003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHAGINI NIVEDITA SAHAKARI BANK LTD","Value":"HDFC0CBNBNK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHAGYODAYA FRIENDS UR COOP BNK LTD","Value":"HDFC0CBFUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHARATHIYA SAHAKARA BANK NIYAMITHA","Value":"HDFC0CBSBN1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHARATI SAHAKARI BANK- BANER","Value":"SVCB0010023"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHAUSAHEB BIRAJDAR NAGARI SAH BANK","Value":"UTIB0SBBSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHAVANI SAHAKARI BANK LTD","Value":"IBKL0579BSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHAVANI URBAN CO OP BANK LTD","Value":"ICIC00BHAUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHAVASARA KSHATRIYA COOP BANK HO","Value":"BKID099BKCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHEL EMPLOYEES COOPERATIVE BANK LTD","Value":"ICIC00BECBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHILWARA MAHILA URBAN COOP BANK LTD","Value":"HDFC0CBMUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHILWARA URBAN CO-OP BANK LTD","Value":"HDFC0CBHLUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHINGAR URBAN CO OP BANK LTD BOLHEGAON","Value":"KKBK0BUCB06"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHUJ MERCHANTILE BANK","Value":"FDRL01BMCOB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BIJAPUR CO-OP CENTRAL BANK LTD","Value":"KSCB0014001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BIJAPUR DISTRICT MAHILA CO OP BANK","Value":"UTIB0SBDMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BIJAPUR SAHAKARI BANK NIYAMIT","Value":"UTIB0S0VSBN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BILAGI PATTANA SAHAKARI BANK","Value":"IBKL01071BP"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BIRDEV SAHAKARI BANK ICHALKARANJI","Value":"ICIC00BDSBI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BOMBAY MERCANTILE CO OP BANK LTD","Value":"UTIB0SBMCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BRAHMAWART COMMERCIAL CO-OPERATIVE BANK LTD","Value":"ICIC00BCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BRAMHAPURI URBAN COOP BANK LTD","Value":"HDFC0CBUCBB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CAUVERI KALPATARU GRAMEENA BANK","Value":"SBMY0RRCKGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CENTRAL MADHYA PRADESH GRAMIN BANK","Value":"CBIN0R20002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CENTRALISED COLLECTION HUB","Value":"UTIB0CCH274"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CG RAJYA SAHAKRI BANK MARYADIT RAIPUR","Value":"CBIN0CGDCBN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHAITANYA COOP URBAN BANK LTD DILSUKHNAGAR","Value":"KKBK0CCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHAITANYA MAHILA CO OP BANK LTD","Value":"UTIB0SCHAIT"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHAMOLI ZILA SAHAKARI BANK LTD","Value":"ICIC00DCBCM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHAMOLI ZILA SAHKARI BANK LIMITED","Value":"IBKL070CZSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHEMBUR NAGARIK SAHAKARI BANK - BHANDUP","Value":"SRCB0CNS010"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHHATTISGARH GRAMIN BANK","Value":"SBIN0RRCHGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHIKMAGALUR DISTRICT COOP BANK LTD","Value":"KSCB0012001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHIKMAGALUR JILLA MAHILA SAHAKARA","Value":"UTIB0SCJMSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHIPLUN URBAN BANK - LANJA","Value":"SVCB0006015"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHITRADURGA CENTRAL CO-OP BANK LTD","Value":"KSCB0004001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHITTORGARH CENTRAL COOP BANK LTD","Value":"RSCB0019001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHITTORGARH URBAN CO-OP BANK LTD","Value":"HDFC0CCUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHOPDA PEOPLES COOP BANK LTD CHOPDA","Value":"HDFC0CCPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHURU ZILA URBAN CO-OP BANK LTD","Value":"HDFC0CRCZUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHURUZILA URBAN COOP BANK LTD","Value":"HDFC0CCZUC2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITIZEN CO OPERATIVE BANK LTD","Value":"ICIC00CCOBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITIZEN CO-OPERATIVE BANK LTD.NOIDA","Value":"HDFC0CCBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITIZENS CO-OPERATIVE BANK LTD","Value":"IBKL01642C1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITY CO OPERATIVE BANK LTD","Value":"UTIB0SCCOBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITY CO-OPERATIVE BANK LTD","Value":"HDFC0CCCBHO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"COASTAL LOCAL AREA BANK LTD","Value":"MAHB000CB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"COL R D NIKAM SAINIK SAH BANK LTD","Value":"HDFC0CRNSSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"COLOUR MERCHANT\u0027S CO-OP. BANK LTD.","Value":"HDFC0CCMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"COMMERCIAL CO OPERATIVE BANK LTD","Value":"ICIC00COMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CORPORATE BANKING BRANCH","Value":"UTIB0NPSKRV"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CUTTACK CENTRAL CO-OPERATIVE BANK ATHAGARHA","Value":"IBKL0217C05"},{"Disabled":false,"Group":null,"Selected":false,"Text":"D.Y.PATIL SAHAKARI BANK LTD, KOLHAPUR","Value":"IBKL0463DYP"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAC URB COOP BANK  LTD,PETH VADGAON","Value":"HDFC0CDACUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DADASAHEB RAMRAO PATIL CO OP BANK","Value":"HDFC0CDPRBD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DADASAHEB RAMRAO PATIL COOP BANK","Value":"UTIB0SDRP01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAIVADNYA SAHAKARA BANK NIYAMIT","Value":"HDFC0CDSBNB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAPOLI URBAN CO-OP. BANK LTD","Value":"IBKL0116DPC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DARUSSALAM CO-OP URBAN BANK LTD","Value":"HDFC0CDUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DATTATRAYA MAHARAJ KALAMBE JAOLI SAHAKARI BANK LTD","Value":"ICIC00DMKJA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAUSA","Value":"RSCB0037008"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAUSA URBAN COOPERATIVE BANK","Value":"ICIC00DAUSA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAVANAGERE CENTRAL CO-OP BANK LTD","Value":"KSCB0701001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAVANGERE HARIHAR URBAN SAHAKARA","Value":"UTIB0SDHUSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DAYALBAGH MAHILA CO OP BANK LTD","Value":"IBKL0080DMC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DECCAN GRAMEENA BANK","Value":"SBHY0RRDCGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEENDAYAL N S BANK LTD AMBAJOGAI","Value":"HDFC0CDNSBA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEENDAYAL NAGARI SAHAKARI BANK LTD","Value":"ICIC00DDNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEFENCE ACCOUNTS COOPBKLTD-CDA(O)","Value":"SVCB0014003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEOGHAR JAMATRA CENTRAL COOP BANK","Value":"UTIB0SDJCC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEVI GAYATRI CO-OP URBAN BANK LTD","Value":"HDFC0CDGCUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEVIKA URBAN CO-OPERATIVE BANK LTD","Value":"ICIC00DUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEVYANI SAHAKARI BANK MARYADIT KOPARGAON","Value":"HDFC0CSSCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DHAKURIA CO OP BANK LTD DHAKURIA","Value":"BKID000DCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DHARMAVIR SAMBHAJI BK- AMBEGAON","Value":"SVCB0004008"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DHULE AND NANDURBAR DISTRICT CENTRAL CO OP BANK LTD","Value":"IBKL0483DND"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DHULE AND NANDURBAR JILHA SARKARI NAU","Value":"UTIB0SDNJS1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DHULE VIKAS SAHAKARI BANK LTD","Value":"UTIB0SDVS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DIST. COOP BANK LTD, LAKHIMPUR KHIRI","Value":"ICIC00KHIRI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DISTRICT CO-OPERATIVE BANK","Value":"ICIC00MORAD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DISTRICT CO-OPERATIVE BANK LTD, FAIZABAD","Value":"ICIC00FDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DISTRICT COOPERATIVE BANK LTD,VARANASI","Value":"ICIC00VDCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DISTRICT CO-OPERATIVE BANK LTD.","Value":"IBKL0236DCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DR BABASAHEB AMBEDKAR SAH BANK LTD","Value":"HDFC0CASB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DR BABASAHEB AMBEDKAR UR CO BANK","Value":"HDFC0CBAUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DR BABASAHEB AMBEDKAR URBAN COOP","Value":"UTIB0SDBAU1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DR JAIPRAKASH MUNDADA UR CO BNK LTD","Value":"HDFC0CDJMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DR JAIPRAKASH MUNDADA URBAN CO OP","Value":"UTIB0SJMUC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DR PANJABRAO DESHMUKH UR CO BNK LTD","Value":"HDFC0CPDB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DUMKA CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0SDCBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DURGAPUR MAHILA COOP BANK LTD","Value":"HDFC0CDMOBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DURGAPUR STEEL PEOPLES CO-OPERATIVE BANK LTD","Value":"IBKL0256DSC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"EASTERN and NORTH EAST FRONTIER RLWAY","Value":"HDFC0CENFRB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ELLAQUAI DEHATI BANK RRB","Value":"SBIN0RRELGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ETAH DISTRICT COOPERATIVE BANK LTD","Value":"ICIC00ETDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ETAWAH URBAN COOP BANK LTD","Value":"HDFC0CEUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"EXCELLENT CO-OP. BANK LTD.MUMBAI","Value":"HDFC0CECBL2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"FINO PAYMENTS BANK LTD","Value":"ICIC00FINPY"},{"Disabled":false,"Group":null,"Selected":false,"Text":"FIROZABAD DISTRICT CENTRAL COOPERATIVE BANK LTD.","Value":"ICIC00FZSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"FIROZABAD ZILA SAHAKARI BANK LTD","Value":"UTIB0SFZB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GAJANAN NAGARI SAHAKARI BANK LTD","Value":"ICIC00GNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GANDHIDHAM COOPERATIVE BANK","Value":"ICIC00GDMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GANDHINAGAR NAG. CO-OP. BANK LTD","Value":"HDFC0CGNCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GANRAJ NAGARI SAHAKARI BANK LTD","Value":"ICIC00GRNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GANRAJ NAGARI SAHAKARI BANK LTD BEED","Value":"HDFC0CGANRJ"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GAUTAM SAHAKARI BANK- KOPARGAON","Value":"SVCB0047003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GHOGHAMBA VIBHAG NAGRIK SAH BANK LTD","Value":"HDFC0CGVNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GODAVARI LAXMI CO-OP BANK LTD, BRANCH JALGAON","Value":"KKBK0GLCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GODAVARI URBAN CO-OP BANK LTD.","Value":"HDFC0CGCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GODHRA URBAN COOP BANK LTD","Value":"UTIB0SGUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GOMTI NAGARIYA SAHAKARI BANK LTD","Value":"ICIC00GOMTI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GUARDIAN BANK -BEGUR BRANCH","Value":"SVCB0002002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GUJARAT AMBUJA CO OP BANK LTD ODHAV","Value":"KKBK0GACB03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GUJARAT MERCANTILE CO-OP. BANK LTD","Value":"HDFC0CGMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GULBARGA YADAGIR CO-OP BANK LTD","Value":"KSCB0017001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GULSHAN MERCANTILE URBAN CO-OPERATIVE BANK LTD","Value":"IBKL01529GM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GUNA NAGRIK SAHAKARI BANK MARYA","Value":"UTIB0SGNSBM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HADAGALI URBAN COOPERATIVE BANK","Value":"UTIB0SHUCBH"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HAMIRPUR DISTRICT CO OPERATIVE BANK LTD MAHOBA","Value":"ICIC00HDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HANUMANGARH","Value":"RSCB0038016"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HARDOI URBAN CO OPERATIVE BANK LTD","Value":"HDFC0CHUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HARIHARESHWAR SAHAKARI BANK LTD, WAI","Value":"ICIC00HHSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HASSAN DISTRICT COOP CENTRAL BANK","Value":"UTIB0SHDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HEAD OFFICE, SANTACRUZ","Value":"IBKL0100AC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HIMATNAGAR NAGARIK SAHAKARI BANK","Value":"IBKL0218HNS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HINDUSTAN COOP BK- DIVA EAST","Value":"SVCB0001020"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HUTATMA SAHAKARI BANK LTD WALWA","Value":"ICIC00HSBLW"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HUTATMA SHAHKARI BANK LTD WALWA","Value":"IBKL0116HSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IDUKKI DISTRICT COOPERATIVE BANK","Value":"UTIB0SIDB99"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ILKAL COOPERATIVE BANK LTD","Value":"UTIB0SICB25"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IMPHAL URBAN CO OPERATIVE BANK","Value":"UTIB0SIUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDAPUR URBAN CO OP BANK LTD","Value":"ICIC00IUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDAPUR URBAN CO OP BANK LTD INDAPUR","Value":"ICIC00INDPR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDEPEDENCE CO-OP BANK LTD NASIK","Value":"HDFC0CICBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDIRA  MAHILA  SAHAKARI BANK LTD","Value":"HDFC0CIMBO1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDIRA MAHILA NAGARI SAHAKARI BANK LTD LATUR","Value":"KKBK0IMNSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDIRA MAHILA SAHAKARI BANK LTD H O BRANCH","Value":"KKBK0IMSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDIRA MAHILA SAHKARI BANK LTD","Value":"ICIC00IMSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDORE PREMIER CO-OP. BANK LTD. INDORE","Value":"CBIN0MPDCAO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDORE SWAYAMSIDH MAHILA CO-OP BANK","Value":"HDFC0CISWAM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDRAPRASTHA SEHKARI BANK LTD","Value":"UTIB0SIPSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INTEGRAL URBAN CO-OP BANK LTD.","Value":"HDFC0CIUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IRINJALAKUDA TOWN CO-OP BANK LTD","Value":"HDFC0CITC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"J C COOP BANK LTD ALIPURDUAR","Value":"WBSC0JCCB17"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JABALPUR MAHILA NAGRIK SHAKARI BANK","Value":"IBKL0052JMM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAGRUTI COOPERATIVE URBAN BANK LTD SAINIKPURI","Value":"KKBK0JCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAI BHAVANI SAH BANK LTD BHAWANI PETH","Value":"KKBK0JBSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAI TULJA BHAVANI UR BANK CO OP LTD","Value":"HDFC0CJTUCE"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAIHIND COOPBKWAKAD-PMPRI CHINCHWD","Value":"SVCB0011002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAIPRAKASH NARAYAN NAGRI SAHAKARI BANK","Value":"ICIC00JPNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAIPRAKASH NARYN NAG SAH BK HINGOLI","Value":"SVCB0031006"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JALAUN DISTRICT CO-OPERATIVE BANK LTD","Value":"ICIC00JDCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JALNA DIST CENTRAL COOP BANK LTD","Value":"IBKL0530JDC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JALNA MERCHANTS COOP BANK LTD JALNA","Value":"HDFC0CJMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JALORE NAGRIK SAHKARI BANK LIMITED","Value":"HDFC0CJALOR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAMIA COOPERATIVE BANK LIMITED, ABUL FAZAL ENCLAVE","Value":"UTIB0SJCB03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAMMU AND KASHMIR STATE COOP BANK","Value":"UTIB0SJKCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAMNAGAR DISTRICT CENTRAL CO-OP. BANK LTD","Value":"GSCB0JMN001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAMPETA COOPERATIVE URBAN BANK LTD","Value":"UTIB0SJCUB2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANAKALYAN CO OP BANK LTD","Value":"HDFC0CJCB03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANATA CO OP BANK LTD","Value":"IBKL0101JCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANATA CO-OP BANK LTD","Value":"HDFC0CJBMLG"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANATA SAH BANK LTD KURDUWADI","Value":"HDFC0CJSBLK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANATA SAHAKAR BANK LTD AMRAVATI- SHIRAGAON KASBA","Value":"SVCB0043004"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANATA SAHAKARI BANK LTD","Value":"UTIB0SJSBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANATA SAHAKARI BANK LTD GONDIA","Value":"HDFC0CGONJB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANKALYAN URBAN CO OP BANK LTD","Value":"HDFC0CJUCBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANSEVA NAGARI SAH BANK LTD BHOOM","Value":"HDFC0CJNSBB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANSEWA URBAN COOP BANK LTD","Value":"UTIB0SJUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANSEWA URBAN CO-OP BANK LTD","Value":"ICIC00JUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANTA SAHAKARI BANK LTD, AJARA","Value":"ICIC00JSBLA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAWAHAR SAHAKARI BANK LTD HUPARI","Value":"IBKL0116JCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JHALAWAR KENDRIYA SAHKARI BANK LTD","Value":"RSCB0024001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JHARKHAND GB-RANCHI BR","Value":"BKID0JHARGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JHARKHAND STATE CO-OPERATIVE BANK LTD","Value":"IBKL0063JCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JIJAMATA MAHILA SAHAKARI BANK LTD,BELGAUM","Value":"IBKL0101JMS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JIJAU COMMERCIAL CO-OP BANK LTD, ACHALPUR CAMP BRANCH","Value":"SRCB0JCB005"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JILA SAHAKARI BANK MYDT, DATIA","Value":"CBIN0MPDCAI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JILA SAHAKARI KENDRIYA BANK","Value":"UTIB0JSBR01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JILA SAHAKARI KENDRIYA BANK MYDT","Value":"UTIB0SJSN01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JILA SAHKARI KENDRIYA BANK MARYADIT","Value":"UTIB0SJSJ01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JIVAJI SAHAKARI BANK LTD,HEAD OFFICE,ICHALKARANJI","Value":"IBKL0467JSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JSC VTB BANK","Value":"HDFC0CVTB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JUBILEE HILLS MERCANTILE COOP URBAN","Value":"UTIB0SJUBH2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JUNAGADH JILLA SAHAKARI BANK LTD.","Value":"GSCB0JND001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KADUTHURUTHY URBAN CO OP BANK LTD","Value":"UTIB0SKU399"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KALYANSAGAR URBAN CO OP BANK LTD","Value":"HDFC0CKUCBP"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KAMALA COOPERATIVE BANK LTD.","Value":"IBKL0478KCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KANARA DISTRICT CENTRAL CO-OP BANK","Value":"KSCB0016001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KANKARIA MANINAGAR NAG. SAH. BK LTD","Value":"HDFC0CKMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KANNUR DISTRICT  CO-OPERATIVE BANK","Value":"UTIB0SKDC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KANNUR DISTRICT CO-OP BANK LTD.","Value":"IBKL0340K01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KANPUR ZILLA SAHAKARI BANK LTD","Value":"ICIC00KZSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KARAMANA CO OPERATIVE URBAN BANK LTD MAIN BRANCH","Value":"KKBK0KCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KARNALA NAGARI SAHAKARI BANK","Value":"UTIB0SKNSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KARNATAKA CENTRAL COOP BANK LTD","Value":"KSCB0015001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KASHMIR MERCANTILE CO OP BANK LTD","Value":"HDFC0CKAMCO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KEDARNATH URBAN CO OP BANK LTD","Value":"ICIC00KNUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KEMPEGOWDA PATTANA SOUHARDA SAHAKARI BANK NIYAMITHA","Value":"IBKL0362KSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KEONJHAR CENTRAL COOOPERATIVE BANK","Value":"UTIB0SKCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KHARDAH CO OPERATIVE BANK LTD","Value":"WBSC0KUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KHARDAH COOPERATIVE BANK LIMITED","Value":"ICIC00KDCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KHATRA PEOPLE\u0027S COOP BANK LTD","Value":"HDFC0CKPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KHORDHA CENTRAL COOP BANK BHUBANE","Value":"IBKL0042KC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOHINOOR SAH BANK LTD ICHALKARANJI","Value":"HDFC0CKSBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOILKUNTLA COOP BK LTD- BALAJI COMPLEX","Value":"SVCB0026004"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOKAN MERCANTILE CO-OP BANK LTD CENTRAL OFFICE BR","Value":"KKBK0KMCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOLAR CHIKKABALLAPUR CO-OP BANK LTD","Value":"KSCB0003001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOLHAPUR DISTRICT CENTRAL CO-OP. BANK LTD.","Value":"IBKL0463KDC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOLKATA MAHILA COOP BANK","Value":"WBSC0MUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KONOKLOTA MAHILA URBAN CO-OPERATIVE BANK LTD,GAR ALI BRANCH","Value":"IBKL0743KMC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOTA NAGRIK SAHAKARI BANK LIMITED","Value":"HDFC0CKNB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOTAK MAHINDRA BANK LIMITED","Value":"KKBK0PCBL04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOTTAKKAL CO OP URBAN BANK LTD","Value":"UTIB0SKCU78"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOTTAYAM CO-OPERATIVE URBAN BANK LTD","Value":"IBKL0027K01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOTTAYAM DISTRICT CO OPERATIVE BANK","Value":"UTIB0SKDB88"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOYANA SAHAKARI BANK LTD KARAD","Value":"IBKL0470KSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KRISHNA BHIMA SAMRUDDHI LAB","Value":"HDFC0CKBS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KRISHNA MERCANTILE COOP BANK LTD","Value":"UTIB0SKMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KRISHNA SAHAKARI BANK LTD, RETHARE BK","Value":"IBKL0470KRS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KRUSHISEVA URBAN CO-OPERATIVE BANK LTD,KOLE","Value":"IBKL0540KUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KUMBHI KASARI SAHAKARI BANK LTD, KALE BR.","Value":"IBKL0463KS4"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KURLA N S BANK BARVE ROAD","Value":"SRCB0KNS002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KUTCH COOPERATIVE BANK LTD","Value":"ICIC00KUTCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KUTTIADY COOPERATIVE URBAN BANK LTD","Value":"IBKL01307KU"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAKHIMPUR URBAN COOP BANK LTD","Value":"ICIC00LKUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LALA URBAN CO OP BANK LTD","Value":"HDFC0CLALAB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LALBAUG CO-OP BANK LTD","Value":"HDFC0CLCBL0"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LANGPI DEHANGI RURAL BANK RRB","Value":"SBIN0RRLDGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LATUR DISTRICT CENTRAL CO-OPERATIVE BANK LTD","Value":"IBKL0497LDC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAXMI MAHILA NAGRIK SAHAKARI BANK","Value":"HDFC0CLMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAXMI SAHAKARI BANK NIYAMIT","Value":"UTIB0SLSBNG"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAXMI SAHAKARI BANK NIYAMIT, GULEDGUDD HEAD OFFICE","Value":"IBKL01071LS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAXMI URBAN CO OP BANK LTD","Value":"ICIC00LUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAXMIBAI MAHILA NAGARIK SAHAKARI BANK LTD","Value":"ICIC00LMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LIC CO-OPERATIVE BANK","Value":"IBKL0186LEC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LILUAH CO OPERATIVE BANK LTD","Value":"HDFC0CLLC02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LOKMANGAL CO-OPERATIVE BANK LTD.","Value":"IBKL0478LOK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LOKNETE DATTAJI PATIL SAHKARI BANK","Value":"UTIB0SLDP47"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LONAVALA SAHAKARI BANK LTD","Value":"HDFC0CLSABL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LUCKNOW URBAN CO OP BANK LTD","Value":"SRCB0LUB262"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LUNAWADA NAGRIK SAHKARI BANK LTD","Value":"UTIB0SLNSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"M S CO-OPERATIVE BANK LTD","Value":"IBKL0553MSC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"M.D. PAWAR PEOPLEÌ¢‰ÛåÂÌÄ‰ÛÊS CO-OPERATIVE BANK LIMITED","Value":"ICIC00MDPPC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAA SHARDA MAHILA NAGRIK BANK","Value":"ICIC00MSMNB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MADHESHWARI URBAN  DEV CO OP BANK","Value":"HDFC0CMUDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MADHYA BHARAT GRAMIN BANK","Value":"SBIN0RRMBGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAGADH CENTRAL COOP BANK LTD","Value":"IBKL0414MCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAH. NAGARI SAH.BK-AHMEDPUR","Value":"SVCB0024004"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHABHAIRAB COOPERATIVE URBAN BANK","Value":"HDFC0CMBCUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHALAKSHMI CO-OPERATIVE BANK LTD, UDUPI","Value":"IBKL0186MC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHARANA PRATAP COOP URBAN BANK LTD","Value":"ICIC00MPCUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHATAMA FULE DISTRICT URBAN COOPERATIVE BANK LT","Value":"HDFC0CMFB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHAVEER CO-OP URBAN BANK LTD","Value":"HDFC0CMCUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHEMDAVAD URBAN PEOPLES COOP BANK","Value":"UTIB0MUPC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHESH SAHAKARI BANK LTD,PUNE","Value":"HDFC0CMASBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHESH SAHAKARI BANK MARKET YARD","Value":"SRCB0MSBLPN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHESH URBAN CO OPERATIVE BANK LTD","Value":"ICIC00MAUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHESH URBAN COOPBANK","Value":"UTIB0SMUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHILA CO OP NAGARIK BANK LTD","Value":"HDFC0CTMCNB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHILA CO-OP BANK ADMINISTRATIVE OFFICE","Value":"SRCB0MCB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHILA NAGRIK SAHA BANK MYDT","Value":"HDFC0CMNSBM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHILA SAHAKARI BANK LTD","Value":"HDFC0CMSBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHISHMATI NAGRIK SAHAKARI BANK","Value":"ICIC00MMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MALAPPURAM DISTRICT CO-OPERATIVE BANK-MALAPPURAM","Value":"IBKL0209M01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANDYA DISTRICT COOP BANK LTD","Value":"KSCB0008001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANGAL COOP BANK DAHISAR E","Value":"MDCB0680375"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANGAL CO-OPERATIVE BANK LIMITED, DAHISAR EAST","Value":"IBKL0691M04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANGALDAI NAGAR SAMABAI BANK LTD","Value":"UTIB0SMNSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANJARA MAHILA URBAN COOP BIDAR","Value":"UTIB0SMMUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Mansarovar Urban Co-op Bank Ltd","Value":"SRCB0001MCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANTHA URBAN CO OP BANK LTD MANTHA","Value":"KKBK0MUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANVI PATTANA SOUH SAHAKARI BK NI","Value":"HDFC0CMPS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MARATHA CO OP BANK LTD","Value":"IBKL0101MCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MARKANDEY NAGARI SAHAKARI BANK LTD","Value":"ICIC00MNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MARKETYARD COMM COOP BANK LTD","Value":"GSCB0UMCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MATHURA ZILLA SAHAKARI BANK LTD.","Value":"ICIC00MZSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MEGHALAYA RURAL BANK RRB","Value":"SBIN0RRMEGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MEHSANA DISTRICT CENTRAL CO-OP. BANK LTD","Value":"GSCB0MSN001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MEHSANA MAHILA SAHAKARI BANK LTD","Value":"HDFC0CMMSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MERCHANTS COOPERATIVE BANK LIMITED","Value":"UTIB0SMCBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MERCHANTS LIBERAL COOP BANK","Value":"UTIB0SMLCBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MIDNAPORE PEOPLES COOP BANK LTD","Value":"IBKL0420MPC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MILLATH CO OPERATIVE BANK LTD","Value":"UTIB0S00MCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MIZORAM RURAL BANK RRB","Value":"SBIN0RRMIGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MODEL CO OP BANK LTD","Value":"HDFC0CMODEL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MOGAVEERA CO-OP BANK","Value":"IBKL0452MCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MONGHYR JAMUI CENTRAL CO-OPERATIVE BANK LTD","Value":"IBKL01078MJ"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MUDGAL URBAN CO-OPERATIVE BANK LTD","Value":"UTIB0SMUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MUGBERIA CENTRAL CO OPERATIVE BANK LTD","Value":"WBSC0MGCB12"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MUKTAI COOPERATIVE BANK LTD NIPHAD","Value":"KKBK0MCBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MUMBAI MAHA PALIKA SVCB DADAR","Value":"MDCB0680301"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MUZAFFARPUR CENTRAL COOP BANK","Value":"IBKL0294MCC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MYSORE CHAMARAJANAGAR CO-OP BANK","Value":"KSCB0007001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MYSORE MERCH COOP BANK","Value":"SVCB0027002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MYSORE SILK CLOTH MERCHANT CO OP BANK LTD BANGALORE BRANCH","Value":"KKBK0MSCMB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MYSORE ZILLA MAHILA SAHAKARA BANK NIYAMITHA","Value":"IBKL01092MZ"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NADAPURAM COOP URBAN BANK LTD","Value":"IBKL0114NUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NADIA DISTRICT CENTRAL CO-OPERATIVE BANK LTD","Value":"WBSC0NDCB18"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGALAND RURAL BANK RRB","Value":"SBIN0RRNLGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGAR SAHKARI BANK","Value":"IBKL01064NS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGARIK SAH BANK MYDT JAGDALPUR","Value":"HDFC0CNSBMJ"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGAUR URBAN CO-OPERATIVE BANK LTD","Value":"HDFC0CNUCB2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGINA URBAN CO-OP BANK LTD","Value":"HDFC0CNGUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGPUR MAH PALIKA KARM SAH B L GANDHI NG","Value":"KKBK0NMPK04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGRIK SAHAKARI BANK MARYADIT RAJGARH BIAORA","Value":"KKBK0NSBM01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGRIK SAHKARI BANK CHHAWANI","Value":"INDB0NSBG07"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGRIK SAHKARI BANK LTD.","Value":"IBKL0015NSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGRIK SAHKARI BANK MARYADIT JHABUA","Value":"UTIB0STNSBM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NALANDA CENTRAL CO-OPERATIVE BANK LTD","Value":"IBKL0780NCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NALBARI URBAN CO OP BANK LTD","Value":"UTIB0SNUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NANDANI SAHAKARI BANK LTD","Value":"ICIC00NNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NANDED DISCTRICT CENTRAL CO OP BANK","Value":"UTIB0SNDCC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NARIMAN POINT","Value":"IBKL0100AC4"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NARMADA MALWA GB-INDORE BR","Value":"BKID0NAMRGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NASHIK DIST GIRNA CO-OP BANK LTD","Value":"HDFC0CNDGCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NASHIK JILHA MAHILA VIKAS SAH BANK","Value":"HDFC0CNJMVB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NASHIK ZILHA SARKARI AND PARISHAD K","Value":"KKBK0NZSPK1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NATIONAL URBAN COOPERATIVE BANK","Value":"IBKL01870N1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAVABHARAT CO OP URBAN BANK LTD A S RAO NAGAR","Value":"KKBK0NCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAVI MUMBAI CO-OP BANK LTD VASHI SECTOR 10 BRANCH","Value":"IBKL0123NMC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAVSARJAN INDUSTRIAL CO OP BANK LTD","Value":"HDFC0CNICBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NEC SAHAR","Value":"IBKL0100AC5"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NEELA KRISHNA COOP URBAN BANK","Value":"HDFC0CNEELA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NEFT MALWA GRAMIN BANK","Value":"STBP0RRMLGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NELLORE CO-OPERATIVE URBAN BANK","Value":"IBKL0337NCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NIDHI CO-OP BANK LTD","Value":"ICIC00NIDHI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NILESHWAR CO OP URBAN BANK LTD","Value":"IBKL0340N01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NIPTC, SAHAR","Value":"IBKL0100AC6"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NIRMAL URBAN COOP BANK LTD","Value":"HDFC0CNB311"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NISHIGANDHA SAHAKARI BANK LTD","Value":"ICIC00NGSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NOIDA COMMERCIAL CO OP BANK LTD JEWAR","Value":"INDB0NCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NORTHERN RAILWAY PRIMARY COOP BANK","Value":"UTIB0SNRP03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NPS TRUSTEE BANK","Value":"UTIB0NPS001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NTB, SANTACRUZ","Value":"IBKL0100AC3"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NUTAN SAHAKARI BANK LTD. ICHALKARANJI HUPARI","Value":"IBKL0467NS4"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NYAYAMITRA SAHAKARA BANK","Value":"UTIB0SNSBNB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ODE URBAN CO OP BANK LTD","Value":"HDFC0CODEBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OLD AIRPORT, SANTACRUZ","Value":"IBKL0100AC2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OMERGA JANTA SAHAKARI BANK LTD","Value":"ICIC00OJSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OMKAR NAGARIYA SAHKARI BANK LTD","Value":"HDFC0CONSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OMPRAKASH DEORA PEOPLES COOP BK HINGOLI- MALAD EAST","Value":"SVCB0009028"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PADMASHREE DR. VITTHALRAO VIKHE PATIL CO-OP BANK LTD - NASHIK","Value":"SVCB0040002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PADMAVATHI COOP URBAN BANK LTD","Value":"HDFC0CPADMA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PALAKKAD DISTRICT  CO-OP. BANK LTD","Value":"UTIB0SPKD21"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PALAMOOR COOP URBAN BANK","Value":"UTIB0SPCUB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PALI URBAN CO-OPERATIVE BANK LTD","Value":"HDFC0CPUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PALUS SAHAKARI BANK LTD PALUS","Value":"UTIB0SPSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PANCHMAHAL DISTRICT CO-OP. BANK LTD.","Value":"GSCB0PDC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PARNER TALUKA SAINIK SAHAKARI BANK LTD JAMKHED","Value":"KKBK0PTSB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PARSHWANATH CO-OP BANK LTD KOLHAPUR","Value":"HDFC0CPCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PATAN NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UPATAN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PATAN NAGRIK SAHAKARI BANK LTD","Value":"HDFC0CPNSBP"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PATLIPUTRA CENTRAL COOPERATIVE BANK LTD.","Value":"IBKL0140PCC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PAVANA SAHAKARI BANK LTD","Value":"IBKL0087PSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PAYANGADI URBAN CO-OP BANK LTD. PAYANGADI MAIN BRANCH","Value":"IBKL0340PC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PAYYANUR CO OPERATIVE TOWN BANK LTD.","Value":"ICIC00PCTBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PILIBHIT DISTRICT CO-OPERATIVE BANK LTD","Value":"ICIC00PDCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PIMPALGOAN MER CO OP BANK","Value":"HDFC0CPIMCO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PIMPRI CHINCHWAD SAHAKARI BANK","Value":"IBKL0087PCS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PITHORAGARH JILA SAHKARI BANK","Value":"IBKL0768PJS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PONDICHERRY STATE COOPERATIVE BANK LTD.","Value":"TNSC0160101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PORBANDAR VIBHAGIYA NAGRIK SAHKARI BANK LTD","Value":"HDFC0CPVNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRAGATHI CO-OPERATIVE BANK LTD","Value":"ICIC00PRCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRAGATI SAHAKARI CO-OPERATIVE BANK","Value":"HDFC0CPSCBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRAGATI URBAN CO OP BANK LTD","Value":"HDFC0CPRAGT"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRATAP COOP BANK BHULESHWAR","Value":"MDCB0680376"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRERNA NAGARI SAHAKARI BANK LTD AURANGABAD","Value":"KKBK0PNSL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRIYADARSHANI MAH NAG SAH BANK LTD","Value":"HDFC0CPMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRIYADARSHANI NAGARI SAHAKARI BANK JALANA BRANCH","Value":"KKBK0PNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRIYADARSHINI URBAN COOP BANK","Value":"UTIB0SPUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PROGRESSIVE CO OP BANK DADAR BRANCH","Value":"KKBK0PCBL03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PROGRESSIVE MERCANTILE CO.OP.BANK LTD.","Value":"GSCB0UPMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PUNE MERCHANTS CO-OPERATIVE BANK LTD","Value":"IBKL0548PMC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PUNE URBAN BANK-GANESHNAGAR","Value":"SVCB0005007"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PURVANCHAL CO-OPERATIVE BANK LTD. GHAZIPUR","Value":"ICIC00PURVA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PURVANCHAL GRAMIN BANK","Value":"SBIN0RRPUGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"R S COOP BANK BORIVALI E","Value":"MDCB0680324"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAE BARELI DISTRICT COOPERATIVE BANK LTD","Value":"ICIC00RBDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAICHUR DISTRICT CENTRAL COOPERATIVE BANK LTD","Value":"IBKL0296RDC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAIGAD SAHKARI BANK LTD","Value":"HDFC0C0RSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAILWAY EMPLOYEE COOPERATIVE BANK","Value":"UTIB0SRECB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAIPUR URBAN MERCANTILE CO BANK LTD","Value":"HDFC0CTRUMC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJ RAJESHWARI MAHILA NAGRIK SAHAK","Value":"KKBK0RRMN01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJADHANI CO OPERATIVE URBAN BANK LTD HASTHINAPURAM","Value":"KKBK0RCUB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJAPUR URBAN COOP BANK LTD","Value":"ICIC00RUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJARAMBAPU SAHAKARI BANK LTD","Value":"IBKL0116RBS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJARSHI SHAHU SAH BANK LTD.PUNE","Value":"HDFC0CRSSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJASTHAN MARUDHARA GRAMIN BANK","Value":"RMGB0000631"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJKOT DISTRICT CENTRAL CO-OP. BANK LTD.","Value":"GSCB0RJT001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJMATA URBAN COOP BANK LIMITED","Value":"UTIB0SRJUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJPUTANA MAHILA URB COOP BANK LTD","Value":"HDFC0CRMUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAMESHWAR COOP BANK BORIVALI W","Value":"MDCB0680354"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAMGARHIA CO-OP BANK LTD","Value":"IBKL0413RCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAMPUR ZILA SAHAKARI BANK LTD","Value":"ICIC00RAMPR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RANAGHAT PEOPLE\u0027S COOPERATIVE BANK","Value":"HDFC0CRAPCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RANI LAXMIBAI URBAN CO.OP BANK","Value":"HDFC0CRLUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RATANCHAND SHAH SAHAKARI BANK LTD","Value":"UTIB0SRSSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RATNAGIRI DISTRICT CENTRAL  CO-OPERATIVE BANK LTD","Value":"UTIB0SRDCC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RENDAL SAHAKARI BANK LTD, RENDAL","Value":"IBKL0116RSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RENUKA NAGRIK SAHAKARI BANK MYDT","Value":"HDFC0CRENUK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"S M K SAHAKARI BANK LTD","Value":"RSCB0030003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SABARKANTHA DISTRICT CENTRAL CO-OP. BANK LTD.","Value":"GSCB0SKB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SADALGA URBAN SOUHARDA SAHAKARI","Value":"UTIB0SSUSSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SADGURU GAHININATH SAH BANK LTD","Value":"HDFC0CSGUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SADGURU NAGRIK SAHAKARI BANK MYDT.","Value":"HDFC0CSNSBM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SADHANA SAHAKARI BANK LTD","Value":"IBKL0041SSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SADHANA SAHAKARI BANK LTD HADAPSAR","Value":"HDFC0CSBL02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAHYADRI  SAHAKARI BANK- HEAD OFFICE","Value":"SVCB0013999"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAHYOG URBAN CO OP BANK LTD","Value":"IBKL0538SAH"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAHYOG URBAN CO OP BANK LTD UDGIR LATUR","Value":"KKBK0SCBU03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAIBABA NAGARI SAH BANK L MANWATH","Value":"KKBK0SBSB03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAIBABA NAGARI SAHAKARI  BANK LTD SELU","Value":"UTIB0SSNS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMARTH URBAN COOP BANK LTD","Value":"ICIC00SUCBO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMATA COOPERATIVE DEVELOPMENT BANK","Value":"HDFC0CSAMAT"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMATA SAH BANK - OSHIWARA","Value":"SRCB0SAM001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMATA SAHAKARI BANK LTD","Value":"ICIC00SAMSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMATHA MAHILA CO-OP URBAN BANK LTD DILSUKHNAGAR","Value":"KKBK0SMUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMPADA SAHAKARI BANK LTD","Value":"IBKL0459SBS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMRUDDHI CO-OP BANK LTD","Value":"IBKL0041SCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SANDUR PATTANA SOUHARDA SAHAKARI BANK","Value":"IBKL0776SPS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SANGLI SAHAKARI BANK LIMITED","Value":"UTIB0SSSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SANGLI URBAN CO OP BANK LTD SANGLI","Value":"HDFC0CSUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SANMATI SAHAKARI BANK LTD ICHALKARANJI","Value":"ICIC00SSBLI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SANMITRA MAHILA NAG SAH BANK MYDT","Value":"HDFC0CSMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SANMITRA SAHAKARI BANK LTD HO","Value":"KKBK0SMBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARASPUR NAGARIK CO.OP.BANK LTD.","Value":"GSCB0USNCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARASWATI SHAKARI BANK LIMITED OZAR","Value":"KKBK0SSBL02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARDAR BHILADWALA PARDI PEOPLE COOP","Value":"UTIB0SBPP12"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARDAR VALLABHBHAI SAHAKARI BANK LTD","Value":"GSCB0USRDAR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARDAR VALLABHBHAI SAHAKARI BANKLTD","Value":"HDFC0CSVSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARDARGUNJ MERCANTILE COOP BANK LTD","Value":"GSCB0USGUNJ"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARJERAO D NAIK SHIR BK-BAHADURWADI","Value":"SVCB0030011"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARVODAYA CO-OP BANK","Value":"IBKL0443SCC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SASARAM BHABHUA CENTRAL COOPERATIVE BANK LTD.","Value":"IBKL0782SBC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SATLUJ GRAMIN BANK BATHINDA","Value":"PSIB0SGB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAURASHTRA GRAMIN BANK","Value":"SBIN0RRSRGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAWAI MADHOPUR URBAN CO-OP LTD","Value":"HDFC0CSWMUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SEC MERCANTILE COOP URBAN BANK","Value":"UTIB0SSMCU1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SECUNDERABAD UCB - MUSHEERABAD","Value":"SVCB0029002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SEVEN HILLS COOPERATIVE URBAN BANK","Value":"UTIB0SHCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHAHJAHANPUR DISTRICT CENTRAL CO-OPERATIVE BANK LTD.","Value":"ICIC00SJDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHAJAPUR NAGRIK SAHAKARI BANK MARY","Value":"KKBK0SNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHANKAR NAGARI SAHKARI BK- CIDCO AURANGABAD","Value":"SVCB0023010"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHARAD NAGARI SAHAKARI BANK LTD.","Value":"IBKL0478SNB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHARAD SAHAKARI BANK LTD,MANCHAR","Value":"HDFC0CSHSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIHORI NAGARIK SAHAKARI BANK LTD.","Value":"GSCB0USHNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHILLONG COOP URBAN BANK LTD","Value":"IBKL0158S01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIMOGA CENTRAL CO-OP BANK LTD","Value":"KSCB0005001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIVA SAHAKARI BANK NMT TARIKERE","Value":"UTIB0SSVA01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIVAJI NAGARI PAITHAN","Value":"ICIC00SHNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIVDAULAT SAH BANK LTD","Value":"HDFC0CSDSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIVSHAKTI URBAN CO OP BANK LTD","Value":"UTIB0SUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE BASAVESHWAR COOP BANK BELGAUM","Value":"IBKL0101SBC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE BASAVESHWAR URBAN CO OP BANK","Value":"UTIB0SBUBRN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE BASAVESHWAR URBAN COOP BANK LTD,RANEBENNUR","Value":"IBKL0069BUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE BHAVNAGAR NAGRIK SAHAKARI BANK LTD","Value":"GSCB0USBNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE CHHANI NAGRIK SAHAKARI BANK LTD","Value":"HDFC0CSCNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE DHARTI CO OPERATIVE BANK LTD","Value":"HDFC0CDHRTI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE GAJANAN URBAN CO-PERATIVE BANK LTD","Value":"IBKL0069GUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE GVERDHNSNGH RAGUVNSHI SH BK L","Value":"HDFC0CGRSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE LAXMI CO OP BANK LTD PUNE","Value":"HDFC0CSLCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE LODRA NAGRIK SAHKARI BANK LTD","Value":"GSCB0ULNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE MAHALAXMI COOP CRD BK- BELGAUM","Value":"SVCB0012003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE MAHAVIR SAHAKARI BANK LTD JALGAON","Value":"KKBK0SMSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE MORBI NAGARIK SAHAKARI BANK LTD","Value":"GSCB0USMNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE PARSWANATH CO OPERATIVE BANK","Value":"HDFC0CSPCBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE SAVARKUNDLA NAGRIK SAHAKARI BANK LTD.","Value":"GSCB0USAVAR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE SAVLI  NAGRIK SAHKARI  BANK LTD","Value":"GSCB0USAVLI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE TALAJA NAGARIK SAHA BANK LTD","Value":"KKBK0TNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE VIRPUR URBAN SAHAKARI BANK LTD","Value":"GSCB0UVIRPU"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI ARIHANT COOP BANK LTD","Value":"ICIC00ARIHT"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI BALAJI URBAN CO-OPERATIVE BANK LTD","Value":"ICIC00SBUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI GAJANAN MAHARAJ URBAN CO OP BANK LTD  JALNA","Value":"KKBK0GMUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI GANESH SAH BANK- WALHEKARWADI","Value":"SVCB0019004"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI JANATA SAHAKARI BANK LTD","Value":"GSCB0USJSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI KRISHNA CO OP BANK LTD- BHIWAPUR","Value":"SVCB0037004"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI LAXMI MAHILA SAHAKARI BANK LTD","Value":"GSCB0ULAXMI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI MAHANT SHIVAYOGI CO OP BANK","Value":"UTIB0SSMSSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI PRAGATI PATTAN SAHAKARI BANK","Value":"UTIB0SSPPSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI REVANSIDDESHWAR SAHAKARI BANK","Value":"UTIB0S0SRPS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI RUKHMINI SAHAKARI BANK LTD AHMEDNAGAR","Value":"KKBK0SRSB06"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI SHIDDESHWAR CO OP BANK LTD","Value":"UTIB0SSSCBV"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI VEERSHAIV COOP BANK LTD KOLH","Value":"HDFC0CVCB28"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI VIJAY MAHANTESH COOP BANK","Value":"UTIB0SSVMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRIRAM URBAN CO-OPERATIVE BANK LTD NAGPUR GANDHIBAG","Value":"KKBK0SUCB03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIDDAGANGA URBAN CO-OPERATIVE BANK","Value":"IBKL0362SUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIDDHESHWAR SAHAKARI BANK LTD LATUR","Value":"HDFC0CSID02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIDDHESHWAR URBAN CO-OP BANK MARYADIT SILLOD","Value":"ICIC00SIDUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIHOR MERCANTILE COOP BANK","Value":"HDFC0CHOKSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIKAR KENDRIYA SAHAKARI BANKLTD","Value":"RSCB0031001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIKKIMSTATE COOPERATIVE BANK LTD","Value":"IBKL0108SIC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SINDHUDURG CO-OPERATIVE BANK LTD.","Value":"IBKL0726SCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIR M VISHWESHARAIAH SAHAKAR BANK NIYAMITHA, GULBARGA","Value":"IBKL0876SMV"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIR M VISVESVARAYA CO-OPERATIVE BANK LIMITED - BSK III STAGE BRANCH","Value":"INDB0VCB005"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIRCILLA URBAN BK SIRCILLA","Value":"SVCB0025002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SOUBHAGYA MAHILA SOUHARDHA SAHAKARI BANK NIYAMITHA GADAG","Value":"IBKL0069SMS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREE CHARAN BANK BANASWADI","Value":"INDB0SCSC08"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREE CHARAN SOUHARDHA CO-OPERATIVE BANK  LIMITED","Value":"UTIB0SSCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREE MAHAYOGI LAKSHAMMA CO-OP BANK LTD- MARKET YARD","Value":"SVCB0048003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREE MAHAYOGI LAKSHMAMMA COOP BANK","Value":"UTIB0SAVB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREE NARAYAN GURU COOP BK- CBD BELAPUR","Value":"SVCB0020007"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREE THYAGARAJA CO OPERATIVE URBAN BANK LTD  BSK ONE","Value":"INDB0STCB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREENIDHI SOUH BANK  MARATHALLI","Value":"INDB0SSBN03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SREENIVASA PADMAVATHI COOPERATIVE BANK","Value":"FDRL0SPCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI AMBABHAVANI URBAN COOP BANK LTD","Value":"UTIB0SSAUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI BANASHANKAR MAHILA CO OP BANK LTD CUBBONPET","Value":"INDB0SBMC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI BHAGAVATHI CO-OPERATIVE BANK LTD","Value":"IBKL01117SB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI BHARATHI COOP BK-HIMAYATHNGR","Value":"SVCB0017002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI GANAPATHI URBAN CO-OP BANK LT- SHIMOGA","Value":"SVCB0045003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI GANESH COOPERATIVE BANK LIMITED","Value":"UTIB0SGAN11"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI GAYATRI CO-OPERATIVE URBAN BANK LTD","Value":"KKBK0SGCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI GOKARNATH COOPERATIVE BANK LIMITED","Value":"IBKL0078GOK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI KALIDASA SAHAKARA BANK NIYAMITHA","Value":"ICIC00SKSBN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI KANNIKAPARAMESWARI COOPBANK LTD","Value":"HDFC0CSKPCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI RAMA COOPERATIVE BANK LIMITED","Value":"HDFC0CSRCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI SATYA SAI NAGARIK SAHAKARI BANK MARYADIT- BHOPAL","Value":"SVCB0051002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI SEETHARAGHAVA SOUHARDA SAH BANK","Value":"UTIB0SSSSBN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI SHARADA MAHILA CO OP BANK LTD J C ROAD","Value":"INDB0SSMB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRI SHIVESHWAR NAGRI SAHAKARI BANK","Value":"UTIB0SSSN01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SRIMATHA MAHILA SAHAKARI BANK BANGALORE","Value":"INDB0SMSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"STAMBADRI COOP URBAN BANK","Value":"UTIB0SSTM01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"STANDARD URBAN COOP BANK LTD","Value":"IBKL001SUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"STATE TRANSPORT  BANK BARAMATI","Value":"IBKL0617S05"},{"Disabled":false,"Group":null,"Selected":false,"Text":"STATE TRANSPORT BANK MUMBAI CENTRAL","Value":"MDCB0680266"},{"Disabled":false,"Group":null,"Selected":false,"Text":"STERLING URBAN CO-OP BANK LTD","Value":"HDFC0CSTUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SUDHA COOP URBAN BANK HUZUR NAGAR","Value":"UTIB0SSUD05"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SUMERPUR MERC. URBAN CO-OP BANK LTD","Value":"HDFC0CS2109"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SUNDARLAL SAVJI CO OP BANK LTD PUNE BRANCH","Value":"SRCB0SSB022"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SURENDRANAGAR DISTRICT CENTRAL CO-OP. BANK LTD","Value":"GSCB0SNR001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SWARNA BHARATHI SAHAKARA BANK NIYAMITHA, BASAVANAGUDI","Value":"IBKL01084SB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"T G C COOP BANK LTD RAMJIBANPUR","Value":"WBSC0TCCB21"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TALIPARAMBA CO OP URBAN BANK","Value":"IBKL0340T01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TARAPUR COOPERATIVE URBAN BANK LTD","Value":"HDFC0CTCUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TARAPUR CO-OPERATIVE URBAN BANK LTD.","Value":"GSCB0UTCUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TEACHERS CO-OPERATIVE BANK LTD.","Value":"IBKL0186T00"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TEHRI GARHWAL ZILA SAHAKARI BANK LTD","Value":"ICIC00TGZSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TEHRI GARHWAL ZILA SAHKARI BANK","Value":"IBKL070TGZS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TERNA NAGARI SAHAKARI BANK LTD. OSMANABAD","Value":"ICIC00TNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TEXTILE TRADERS CO-OP. BANK LTD.","Value":"HDFC0CTTCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THA UTTARPARA COOPERATIVE BANK LTD","Value":"HDFC0CTUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THASRA PEOPLES CO-OP.BANK LTD","Value":"ICIC00TPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE  KHEDA  PEOPLES COOPERATIVE BANK LTD","Value":"GSCB0UKPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ADARSH COOPERATIVE URBAN BANK LTD","Value":"ICIC00ADRSH"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ADINATH CO OP BANK LTD","Value":"HDFC0CADIBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AGRASEN NAGARI SAH BANK LTD","Value":"HDFC0CTANSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AGROHA CO OPERATIVE URBAN BANK LIMITED BALANAGAR","Value":"KKBK0ACUB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AGS EMPLOYEES\u0027 CO-OP BANK LTD","Value":"HDFC0CAGSBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AJARA URBAN CO-OP BANK LTD","Value":"IBKL0116AUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ALMEL URBAN COOPERATIVE BANK","Value":"UTIB0SALMEL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ALNAVAR URBAN COOPERATIVE BANK LTD","Value":"ICIC00ALUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ALWAR CENTRAL COOP BANKLTD","Value":"RSCB0012001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AMBALA CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0ACCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AMOD NAGRIK COOP BANK LTD","Value":"HDFC0CANCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AMRAVATI MERCHANTS CO BNK LTD","Value":"HDFC0CAMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AMRITSAR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SASR01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ANAND MERCANTILE  CO-OPERATIVE BANK LTD.","Value":"UTIB0SAMC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ANAND MERCANTILE CO-OP BANK","Value":"ICIC00TAMCO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ANANTHPUR COOP TOWN BANK  LTD - HINDUPUR","Value":"SVCB0034005"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ANKOLA URBAN COOP BANK LTD","Value":"IBKL0069AUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AP JANATA COOP URBAN BANK LTD","Value":"HDFC0CAPJBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ARSIKERE URBAN CO OPERATIVE BANK LTD","Value":"UTIB0SAUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ARYA VAISHYA COOP BANK LTD- DHARWAD","Value":"SVCB0052005"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ARYAPURAM CO-OP URBAN BANK LTD","Value":"HDFC0CACUB9"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ARYAPURAM CO-OPERATIVE URBAN BANK LTD","Value":"ICIC00ACUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ASKA COOP CENTRAL BANK LIMITED","Value":"UTIB0SASKAC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AZAD CO OPERATIVE BANK LTD","Value":"UTIB0SAZADB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BALLARI DISTRICT COOP CENTRAL BANK LTD,HO,HOSAPETE","Value":"KSCB0020001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BANSWARA CENTRAL COOP BANKLTD","Value":"RSCB0013001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BANTRA CO-OPERTIVE BANK LTD","Value":"HDFC0CBCBBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BARDOLI  NAGRIK SAH BANK LTD","Value":"GSCB0UTBNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BARMER CENTRAL COOP BANKLTD","Value":"RSCB0014001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BARODA CITY CO OPERATIVE BANK LTD FATEHGUNJ BRANCH","Value":"KKBK0BCCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BATHINDA CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SBCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BAVLA NAGRIK SAHAKARI BANK LTD","Value":"HDFC0CTBNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BAVLA NAGRIK SAHAKARI BANK LTD HEAD OFFICE","Value":"KKBK0BNSB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BECHRAJI NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UTBSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHABHAR VIBHAG NAG SAH BANK LTD","Value":"HDFC0CBVNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHABHAR VIBHAG NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UBHABH"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHADGAON PEOPLES COOP BNK","Value":"HDFC0CBPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHADRAN PEOPLES COOP BANK LTD","Value":"UTIB0SBPCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHAGYALAKSHMI MAHILA SAH BANK","Value":"HDFC0CBLMSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHAGYODAYA COOPERATIVE BANK LTD","Value":"ICIC00TBHCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHARATPUR CENTRAL COOP BANK LTD","Value":"RSCB0015001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHATKAL URBAN COOPERATIVE BANK LTD MAIN","Value":"UTIB0SBUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHIWANI CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0BHIW01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BHUJ COMMERCIAL CO OP BANK LTD","Value":"UTIB0BCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BODELI URBAN COOPERATIVE BANK LTD","Value":"KKBK0TBUC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CALICUT CO-OPERATIVE URBAN","Value":"FDRL0CCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CATHOLIC COOP U B- SECUNDERABAD","Value":"SVCB0032002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CENTARAL COOP BANK LTD","Value":"RSCB0034001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHAMBA URBAN COOP BANK LTD","Value":"HDFC0C0CUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHANASMA COMM COOP BANK LTD","Value":"GSCB0UCCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHANASMA NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UCHANA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHANASMA NAGRIK SAHA. BANK LTD.","Value":"HDFC0CCNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHANDGAD URBAN CO-OP BANK LIMITED","Value":"ICIC00CUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHANDIGARH STATE COOPERATIVE BANK LTD","Value":"UTIB0CSCB22"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHANDWAD MERCHANT S COOP BANK LTD","Value":"ICIC00CMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHARADA NAGRIK SAHAKARI BANK LTD.","Value":"GSCB0UCNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHARADA NAGRIK SAHKARI BANK LTD","Value":"HDFC0CCHNAG"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHEMBUR NAGARIK SAHAKARI BANK LTD","Value":"ICIC00CNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHENNAI CENTRAL COOPERATIVE BANK LTD.","Value":"TNSC0010500"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHITNAVISPURA SAHAKARI BANK LTD BUTIBORI","Value":"KKBK0TCSB06"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHOPDA PEOPLES CO-OP BANK LTD","Value":"UTIB0SCPCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHURU CENTRAL COOP BANK LTD","Value":"RSCB0020001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CITIZEN CO OP BANK LTD - RAJAJINAGAR, DR. RAJKUMAR ROAD","Value":"SVCB0039002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CITIZEN COOP BANK LTD","Value":"UTIB0STCCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CITIZEN CO-OP. BANK LTD.","Value":"HDFC0CTZNBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CO OP BANK OF MEHSANA LTD HEAD OFFICE","Value":"KKBK0CBML01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE COMMERCIAL CO OPERATIVE BANK LT","Value":"HDFC0COMMCO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE COOPERATIVE BANK OF MEHSANA LTD","Value":"GSCB0UCOBML"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DAHANU ROAD JANATA CO OP BANK","Value":"KKBK0DJCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DAHOD MERCANTILE COOP BANK LTD ANAJ MARKET YARD BRANCH","Value":"KKBK0DMCB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DAVANGERE URBAN COOP BANK LTD","Value":"IBKL0069DUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DECCAN COOP URBAN BANK LTD DILSUKHNAGAR BRANCH","Value":"KKBK0DCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DEOLA MERCHANTS COOP BANK LTD","Value":"ICIC00TDMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DEVGAD URBAN CO OP BANK LTD","Value":"HDFC0CDEVUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DHANBAD CENTRAL CO-OPERATIVE BANK LTD","Value":"UTIB0SDCCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DHARMAJ PEOPLES  COOPERATIVE BANK LTD","Value":"GSCB0UDHARM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DINDIGUL CENTRAL COOPERATIVE BANK LTD,","Value":"TNSC0011700"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DISTRICT COOP CENTRAL BANK LTD BIDAR","Value":"KSCB0018001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DISTRICT CO-OPERATIVE BANK LTD AGRA","Value":"ICIC00AGDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DISTRICT COOPERATIVE BANK LTD, BARABANKI","Value":"ICIC00BBDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DISTRICT COOPERATIVE BANK LTD, LALITPUR","Value":"ICIC00LDCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DISTRICT COOPERATIVE BANK LTD, UNNAO","Value":"ICIC00UDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DISTRICT COPERATIVE BANK BIJONR","Value":"UTIB0SBDC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DUNGARPUR CENTRAL COOP LTD","Value":"RSCB0021001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DURGA COOPERATIVE URBAN BANK","Value":"UTIB0SDCUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE EENADU CO OP URBAN BANK LTD","Value":"HDFC0CEENAD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ELURI CO-OP URBAN BANK LTD GUNTUR","Value":"ICIC00ELURI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ELURU URBAN COOP BANK LIMITED","Value":"ICIC00TECUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE FARIDABAD CENTRAL  CO-OPERATIVE BANK LIMITED","Value":"UTIB0SFCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE FARIDKOT CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SFDK03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE FATEHABAD CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0FCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE FATEHGARH SAHIB CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0SFGH01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE FAZILKA CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SFAZ01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE FEROKE CO-OPERATIVE URBAN","Value":"FDRL012FCUB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GADHINGLAJ URBAN COOPERATIVE BANK","Value":"ICIC00GUCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GANDHIDHAM MER CO OP BANK LTD","Value":"INDB0GMCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GANDHIDHAM MERCANTILE CO OP BANK LTD GANDHIDHAM","Value":"KKBK0GMCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GANDHINAGAR URBAN CO. BANK LTD","Value":"HDFC0CTGUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GANGANAGAR KENDRIYA SAHAKARI BANK","Value":"RSCB0033001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GAYATRI CO-OPERATIVE URBAN BANK LTD","Value":"ICIC00GAYAT"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GHATAL PEOPLE\u0027S COOP BANK LTD","Value":"HDFC0CGPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GHOTI MERCHANTS COOP BANK LTD","Value":"UTIB0SGMCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GHOTI MERCHANTS CO-OP BANK LTD","Value":"ICIC00GMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GIRIDIH CENTRAL COOP BANK LTD","Value":"UTIB0SGIRB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GOA URBAN CO OP BANK LTD","Value":"HDFC0CGUB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GONDIA DISTRICT BANK","Value":"UTIB0SGDC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GOOTY CO-OP TOWN BANK LTD- GOOTY","Value":"SVCB0053002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GUNTUR COOP URBAN BANK LTD","Value":"UTIB0SGUB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GURDASPUR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SGDS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GURGAON CENTRAL  COOPERATIVE BANK LIMITED","Value":"UTIB0SGCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HALOL MERCANTILE COOP BANK LTD","Value":"HDFC0CHMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HANSOT NAGARIC SAHAKARI BANK LTD","Value":"GSCB0UTHNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HANUMANTHANAGAR COOP BANK LTD","Value":"HDFC0CHCBHN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HARYANA STATE COOPERATIVE  APEX BANK LTD","Value":"UTIB0HSCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HASTI CO-OP. BANK LTD","Value":"HDFC0CHB101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HAVERI URBAN COOPERATIVE BANK","Value":"UTIB0SUBHVR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HAVERI URBAN COOPERATIVE BANK LTD, HAVERI","Value":"ICIC00HAVCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HAZARIBAG CENTRAL CO OP BANK","Value":"UTIB0SHCCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HISAR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0HCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HOSHIARPUR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SHSP01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HOTEL INDUSTRIALISTS CO-OP BANK LTD- BALAPET","Value":"SVCB0041269"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HUBLI URBAN COOP BANK  HIREPETH","Value":"SVCB0033008"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HUKKERI URBAN COOP BANK LTD","Value":"HDFC0CTHUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE IDAR NAGARIK SAHAKARI BANK LTD.","Value":"GSCB0UIDARB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE INNESPETA CO-OPERATIVE URBAN BANK LTD- RAJAHMUNDRY","Value":"SVCB0049002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ISLAMPUR URBAN COOP BANK LTD","Value":"HDFC0CTIUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JAIPUR CENTRAL COOP BANK LTD","Value":"RSCB0022001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JAISALMER CENTRAL COOP BANK LTD","Value":"RSCB0036001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JALANDHAR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SJAL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JALNA PEOPLES COOP BANK LTD","Value":"HDFC0CJPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JALORE CENTRAL COOP BANK LTD","Value":"RSCB0023002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JALPAIGURI CTRL BANK BANARHAT","Value":"WBSC0JCCB11"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JAMBUSAR PEOPLES CO.OP.BANK LTD.","Value":"GSCB0UJPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JAMKHANDI URBAN CO-OPERATIVE BANK LTD","Value":"ICIC00TJUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JAMNAGAR MAHILA SAHAKARI BANK LTD","Value":"GSCB0UJAMNA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JAMNAGAR PEOPLES CO OP BANK LT","Value":"HDFC0CTJPCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JANATA CO.OP. BANK LTD.GODHRA","Value":"ICIC00JCBLG"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JAYNAGAR-MOZILPUR PEOPLE S CO-OPT. BANK LTD.","Value":"IBKL0086JMC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JHAJJAR CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0JCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JHALOD URBAN CO OP BANK LTD JHALOD","Value":"KKBK0JUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JIND CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0JIND01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KAIRA DISTRICT CENTRAL CO OP BANK LTD","Value":"ICIC00KAIRA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KAITHAL CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0KAIT01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KAKINADA COOP TOWN BANK","Value":"UTIB0SKCTBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KAKINADA TOWN CO OP TOWN BANK","Value":"IBKL0093KTC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KALNA TOWN CREDIT CO-OP BANKLTD","Value":"HDFC0CKTCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KALOL URBAN CO-OP. BANK LTD","Value":"HDFC0CTKUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KALWAN MERCHANTS COOP BANK LTD-ABHONAÌ¢‰ÛåÂÌÄåÁ","Value":"SVCB0038003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KANAKAMAHALAKSHMI CO OP BANK","Value":"UTIB0STKCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KAPURTHALA CENTRAL  CO-OP BANK LTD","Value":"UTIB0SKPT01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KARAD JANATA SAHAKARI BANK LTD","Value":"HDFC0CKJSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KARJAN NAGARIK SAHAKARI BANK LTD","Value":"ICIC00TKNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KARJAN NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UTKSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KARMALA URBAN CO-OP BANK LTD","Value":"HDFC0CKRMAL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KARNAL CENTRAL CO  OPERATIVE BANK LTD","Value":"UTIB0KCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KARNAVATI BANK LTD VASTRAPUR BR","Value":"KKBK0TKCB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KHAMBHAT NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UKNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KHEDA PEOPLE\u0027S CO.OP. BANK LTD","Value":"ICIC00KPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KHERALU NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UTKNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KONARK URBAN CO-OP BANK LTD - MAIN BRANCH","Value":"KJSB0KUB252"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KOPARGAON PEOPLES COOP BANK LTD - YEOLA","Value":"SVCB0035006"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KORAPUT CENTRAL COOP BANK LTD","Value":"UTIB0SKOCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KOSAMBA  MERC COOP BANK LTD","Value":"GSCB0UKMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KOTA CENTRAL COOP BANK LTD","Value":"RSCB0027001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KOYLANCHAL URBAN COOP BANK LTD","Value":"HDFC0CKOUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KRANTHI COOP URBAN BANK LTD","Value":"UTIB0SKRN01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KRISHNANAGAR CITY COOP BANK LTD","Value":"HDFC0CKCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KURUKSHETRA CENTRAL  COOPERATIVE BANK LTD.","Value":"UTIB0KURU01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE LASALGAON MERCHANTS CO-OP BANK LTD-MAIN LASALGAON","Value":"SVCB0036002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE LAXMI CO OP BANK LTD SOLAPUR","Value":"HDFC0CTLCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE LIMBASI URBAN CO OP BANK LTD","Value":"GSCB0ULUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE LUDHIANA CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SLDH01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE LUNAWADA PEOPLES CO-OP BANK LTD","Value":"HDFC0CLPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MAHANAGAR CO OPERATIVE URBAN BANK LIMITED KACHIGUDA","Value":"KKBK0MCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MAHARAJA CO-OPEARTIVE URBAN BANK LTD","Value":"IBKL0031MCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MAHENDERGARH CENTRAL COOP BANK","Value":"UTIB0SMCCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MAHILA VIKAS CO OP BANK LTD AHMEDABAD","Value":"KKBK0MVCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MAHILA VIKAS CO-OP BANK LTD","Value":"HDFC0CMVCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MAHUDHA NAGRIK SAHAKARI BANK","Value":"UTIB0STMNB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MALPUR NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UMALPU"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANDAL NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UMNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANDAPETA COOP TOWN BANK","Value":"UTIB0SMCTBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANDVI MERCANTILE COOP BANK LTD","Value":"UTIB0SMMCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANDVI NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UTMNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANGALORE CATHOLIC CO OPERATIVE BANK LTD","Value":"IBKL0078MCC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANGALORE CO-OPERATIVE TOWN BANK LIMITED","Value":"IBKL0078MCT"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANIPUR WOMENS COOP BANK LTD","Value":"UTIB0SMWCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANJERI COOP URBAN BANK LIMITED","Value":"ICIC00MCUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANSA CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SMSA01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANSA NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UMANBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MATTANCHERRY MAHAJANIK COOPERATIVE BANK LTD EDAKOCHI","Value":"KKBK0MMCB03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MATTANCHERRY SARVAJANIK COOPERATIVE BANK LTD MAIN BRANCH","Value":"KKBK0MSCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MAYANI URBAN COOP BANK LTD","Value":"ICIC00TMUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MEENACHIL EAST URBAN CO OP BANK","Value":"FDRL01MEUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MEGHRAJ NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UMNCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MEHSANA JILLA PANCHAYAT KARMACHARI COOP BANK LTD.","Value":"GSCB0UMEHSA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MODASA NAGARIK SAHAKARI BANK LTD GANESHPUR","Value":"KKBK0MNSB03"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MODEL COOPERATIVE URBAN BANK LTD","Value":"KKBK0TMCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MOIRANG PRIMARY COOP BANK","Value":"UTIB0SMPCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MOTI URBAN CO OP BANK LTD","Value":"UTIB0STMUC1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MUSLIM CO OP BANK HUNSUR","Value":"INDB0TMCB04"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NABADWIP COOP CREDIT BANK LTD","Value":"HDFC0CNCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NADIAD PEOPLES COOP BANK LTD","Value":"UTIB0NPCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAGALAND STATE CO OP BANK LTD","Value":"UTIB0SNSCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAGAUR CENTRAL COOP BANK LTD","Value":"RSCB0028001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAKODAR URBAN COOP BANK LTD,NAKODAR","Value":"HDFC0CNHUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NANDURBAR MERCHANTS CO OP BANK LTD","Value":"KKBK0NMCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NARODA NAGRIK COOP BANK LTD","Value":"GSCB0UNNCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NARODA NAGRIK CO-OP. BANK LTD","Value":"HDFC0CTNNCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NASIK DIST CENTRAL COOP BANK L","Value":"ICIC00NDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NATIONAL CO OPERATIVE BANK LIMITED","Value":"UTIB0SNCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NATIONAL CO-OP BANK LTD BHAYANDAR","Value":"KKBK0TNCB10"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAVJEEVAN COOP BANK LTD","Value":"ICIC00NVJVN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAWANSHAHR CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0SNWS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NEHRUNAGAR CO OP BANK LTD BANGALORE","Value":"INDB0NNCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NEW AGRA URBAN CO-OPERATIVE BANK LTD","Value":"IBKL0080NAC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NEYYATTINKARA CO OP URBAN BK LTD BALARAMAPURAM ME","Value":"KKBK0NTCUB4"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NILAMBUR CO-OPERATIVE URBA","Value":"FDRL0NCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NIPHAD URBAN CO OP BANK LTD NIPHAD","Value":"KKBK0NUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PACHORA PEOPLES COOP BANK LTD","Value":"HDFC0CPPCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PADRA NAGAR NAG SAH BANK LTD","Value":"GSCB0UPNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PALI CENTRAL COOP BANKLTD","Value":"RSCB0029001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PANCHKULA CENTRAL COOPERATIVE BANK LTD.","Value":"UTIB0SPKL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PANDHARPUR  MERCHANTS CO-OP BANK LTD,PANDHARPUR","Value":"ICIC00PMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PANIHATI COOPERATIVE BANK LTD","Value":"HDFC0CTPHCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PANIPAT CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0PCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PATDI NAGRIK SAHAKARI BANK LTD.","Value":"GSCB0UTPNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PATIALA CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SPCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PIJ PEOPLES COOP BANK LTD","Value":"ICIC00PPCOB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PRAGATI CO.OP.BANK LTD.","Value":"GSCB0UTPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PRODDATUR COOP TOWN BANK","Value":"UTIB0SPTB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PUNJAB STATE CO-OP BANK","Value":"UTIB0PSCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RADDI SAHAKARA BANK NIYAMITA","Value":"IBKL0069RSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RADHASOMAY URBAN COOPRATIVE BANK LTD","Value":"IBKL0080RUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RAJASTHAN URBAN COOPERATIVE BANK LTD","Value":"UTIB0SRUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RAJKOT COMMERCIAL CO-OPERATIVE BANK LTD","Value":"ICIC00RCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RAJPIPLA  NAGRIK SAHAKARI BANK LTD.","Value":"GSCB0URNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RANCHI KHUNTI CENTRAL  CO-OPERATIVE BANK LTD","Value":"IBKL0063RKC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RANDER PEOPLE\u0027S CO OP BANK LTD","Value":"HDFC0CRPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RANDHEJA COMMERCIAL COOP BANK LTD","Value":"GSCB0URANDH"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RANGA REDDY COOP URBAN BANK LTD DILSUKHNAGAR","Value":"KKBK0RRUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE REVDANDA CO-OP URBAN BANK LTD- ALIBAG","Value":"SVCB0042003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE REWARI CENTRAL  COOPERATIVE BANK LTD.","Value":"UTIB0REWA01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ROHTAK CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0RCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ROPAR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SRCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SALAL SARVODAY NAGARIK SAHAKARI BANK LTD.","Value":"GSCB0USSNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SAMASTIPUR DISTRICT CENTRAL CO-OPERATIVE BANK LTD","Value":"IBKL0065SDC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SAMMCO BANK LIMITED APMC YARD","Value":"INDB0SAMC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SANGAMNER MERCH CO OP BANK LTD","Value":"HDFC0CTSMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SANGRUR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SANTRAMPUR URBAN CO-OPERATIVE BANK LTD","Value":"GSCB0USUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SARDAR GUNJ MERC COOP BANK LTD","Value":"GSCB0USMCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SARSA PEOPLES CO OPERATIVE BANK LTD.","Value":"GSCB0USARSA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SARVODAYA NAGRIK SAHKARI BANK LTD","Value":"GSCB0UTSNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SARVODAYA SAHAKARI BANK LTD MODASA","Value":"KKBK0TSSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SAS NAGAR CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SAS001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SATANA MERCHANTS CO OP BANK LTD","Value":"KKBK0TSMC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SATANA MERCHANTS COOP BANK LTD","Value":"ICIC00TSMCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SATHAMBA PEOPLES COOP BANK LTD","Value":"GSCB0USATHM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SAURASHTRA CO.OPERATIVE BANK LTD.","Value":"GSCB0USAURA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SEVALIA URBAN CO. OP BANK LTD","Value":"ICIC00SEVUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SHIRPUR MERCHANTÌ¢‰ÛåÂÌÄ‰ÛÊS CO-OP BANK LTD SHIRPUR","Value":"KKBK0SMCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SHIRPUR PEOPLES CO-OP LTD SHIRPUR BRANCH","Value":"KKBK0SPCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SINOR NAGARIK SAHAKARI BANK LTD","Value":"ICIC00SNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SIROHI CENTRAL COOP BANK LTD","Value":"RSCB0032099"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SIRSA CENTRAL COOPERATIVE  BANK LTD","Value":"UTIB0SIRS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SIVAGANGAI DISTRICT CENTRAL COOPERATIVE BANK LTD.","Value":"TNSC0011900"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SOLAPUR DISTRICT CENTRAL COOPERATIVE BANK LTD","Value":"ICIC00SDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SONEPAT CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0SONE01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SUVIKAS PEOPLE\u0027S CO-OPERATIVE BANK LTD","Value":"ICIC00SPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SWASAKTHI MERCANTILE CO-OPERATIVE URBAN BANK LTD","Value":"IBKL0089SMC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TALOD NAGARIK SAHAKARI BANK LTD","Value":"ICIC00TTNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TALOD NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UTNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TAMILNADU INDUSTRIAL CO-OPERATIVE BANK LTD","Value":"TNSC0015000"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TARN TARAN CENTRAL COOPERATIVE BANK LTD","Value":"UTIB0STTN01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE THOOTHUKUDI DISTRICT CENTRAL COOPERATIVE BANK LTD.","Value":"TNSC0012100"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TIRUR URBAN CO-OPERATIVE BANK LTD","Value":"ICIC00TUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TIRUVANNAMALAI DISTRICT CENTRAL COOPERATIVE BANK LTD.","Value":"TNSC0012000"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TOWN COOPERATIVE BANK LIMITED","Value":"UTIB0STCBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TUMKUR DIST COOP CENTRAL BK LTD","Value":"HDFC0CTDCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UDAIPUR CENTRAL COOP BANK LTD","Value":"RSCB0035001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UDGIR URBAN CO-OP BANK LTD","Value":"HDFC0CUUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UDUPI CO OPERATIVE TOWN BANK","Value":"UTIB0SUCTBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UNA PEOPLES CO-OPERATIVE BANK L","Value":"HDFC0CUPCBA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UNAVA NAGRIK SAHAKARI BANK LTD","Value":"GSCB0UUNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UNION COOPERATIVE BANK LTD","Value":"GSCB0UUNION"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UNION CO-OPERATIVE BANK LTD","Value":"ICIC00UNICB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UNITED CO-OPERATIVE BANK LTD","Value":"GSCB0UUCOBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE URBAN CO OP BANK LTD CHOPDA","Value":"KKBK0UCB502"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE URBAN CO OP BANK LTD JALGAON","Value":"KKBK0UCB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE URBAN CO-OP BANK LTD","Value":"ICIC00UCBLD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE URBAN CO-OPERATIVE BANK LTD","Value":"HDFC0CURBAN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UTTARPARA CO OPERATIVE BANK LTD","Value":"UTIB0UCBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UTTARSANDA PEOPLES CO OP BANK L","Value":"INDB0UPCO01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VADALI NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UVNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VAIDYANATH URBAN COOP BANK","Value":"UTIB0SVUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VAIDYANATH URBAN CO-OP BANK LTD","Value":"ICIC00VUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VAISH CO-OP.COMM. BANK LTD.","Value":"HDFC0CTVCBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VALLABH VIDYANAGAR COMM COOP BANK LTD","Value":"HDFC0CVVCAN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VALSAD MAHILA NAGRIK SAHAKARI BANK LTD","Value":"ICIC00VMNSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VARDHMAN CO-OPERATIVE BANK LTD","Value":"ICIC00TVCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VEJALPUR NAGRIK SAHAKARI BANK","Value":"UTIB0VNSBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VERAVAL MERCANTILE CO-OP BANK L","Value":"HDFC0CVMCBA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VERAVAL PEOPLES CO.OP.BANK LTD.","Value":"GSCB0UVPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VERAVAL PEOPLE\u0027S CO-OP BANK LTD","Value":"HDFC0CVPCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VIJAPUR NAGARIK SAHAKARI BANK LTD.","Value":"GSCB0UTVNBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VILLUPURAM DISTRICT CENTRAL COOPERATIVE BANK LTD.","Value":"TNSC0012200"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VIRAMGAM MERCANTILE COOP BANK LTD","Value":"GSCB0UVIRAM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VIRUDHUNAGAR DISTRICT CENTRAL COOPERATIVE BANK LTD.","Value":"TNSC0011800"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VISAKHAPATNAM CO-OP BANK LTD","Value":"IBKL0031VCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VSV CO OPERATIVE BANK LTD","Value":"HDFC0CVSVCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE WASHIM URBAN COOP BANK LTD","Value":"HDFC0CWUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE WAYANAD DIST CO-OP BANK LT","Value":"FDRL0WDCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE WOMENS COOP BANK LTD PANAJI GOA","Value":"HDFC0CWOMEN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE YAMUNA NAGAR CENTRAL CO  OPERATIVE BANK LTD","Value":"UTIB0YCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE YASHWANT CO-OP BANK LTD PHALTAN","Value":"HDFC0CYACBP"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE YAVATMAL MAHILA SAH BANK LTD","Value":"HDFC0CYMSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE YEMMIGANUR COOP TOWN BANK LTD","Value":"UTIB0SYMG01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TIRUMALA COOP URB BK - MALAKPET HYD","Value":"SVCB0028002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TKUCBL KALOL","Value":"KKBK0KUBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TUCBL ANGADIPPURAM","Value":"IBKL0763P13"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TUMKUR VEERASHAIVA CO OPERATIVE BANK LTD","Value":"IBKL0362TVC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UDAIPUR MAHILA URBAN CO-OP BANK LTD","Value":"ICIC00UMUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UDGIR URBAN CO OP BANK LTD LATUR","Value":"KKBK0UCBL02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UDGIR URBAN COOP BANK","Value":"ICIC00UUUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UDGIR URBAN CO--OPERATIVE BANK","Value":"IBKL0538UUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UDHAM SINGH NAGAR DISTRICT CO-OPERATIVE BANK LTD","Value":"ICIC00USNDC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UDYAM VIKAS SAHAKARI BANK LTD PUNE","Value":"HDFC0CUDYAM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UJJAIN AUDHYOGIK VIKAS NAGRIK SAHAK","Value":"HDFC0CUAVNB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UMIYA URBAN CO-OP BANK LTD ITWARI NAGAR","Value":"KKBK0UUCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UNITED INDIA COOPERATIVE BANK LTD","Value":"UTIB0SUICB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UNJHA NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UUNJBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"URBAN COOP BANK LTD, BASTI","Value":"ICIC00BASTI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"URBAN CO-OPERATIVE BANK LTD, BAREILLY","Value":"IBKL0232UCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTKAL GRAMYA BANK RRB","Value":"SBIN0RRUKGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTTAR BANGA KSHETRIYA GRAMIN BANK COOCHBEHAR","Value":"CBIN0R40012"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTTAR BIHAR GRAMIN BANK MUZAFFARPUR","Value":"CBIN0R10001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTTAR PRADESH CO-OPERATIVE BANK LTD.","Value":"IBKL0015UPC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTTAR PRADESH STATE COOPERATIVE BANK LTD","Value":"ICIC00UPSCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTTARANCHAL GRAMIN BANK","Value":"SBIN0RRUTGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTTARKASHI ZILA SAHKARI BANK LTD","Value":"IBKL01209UC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VADNAGAR NAGARIK SAHAKARI BANK LTD","Value":"GSCB0UVNGBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VAIJANATH APPA SARAF MARAT NSBL","Value":"HDFC0CVASM1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VAISHYA NAGARI","Value":"ICIC00VANSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VAISHYA NAGARI SAH BANK LTD","Value":"HDFC0CVNB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VAISHYA NAGARI SAH BANK PARBHANI","Value":"UTIB0SVNS07"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VAISHYA SAHAKARI BANK LTD. MUMBAI","Value":"IBKL0501VSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VALMIKI URBAN CO OP BANK LTD PATHRI","Value":"KKBK0VUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VALSAD DISRICT CENTRAL CO-OP. BANK LTD.","Value":"GSCB0VDC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VANANCHAL GRAMIN BANK","Value":"SBIN0RRVCGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VARDHAMAN MAHILA COOP URBAN BANK LTD","Value":"HDFC0CVB010"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VASAI JANATA SAHKARI BANK LTD","Value":"HDFC0CVJSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIDARBHA MERCHANTS U.C.B. LTD DHAMANGAON","Value":"IBKL00410V7"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIDHARBHA KONKAN GRAMIN BANK HO NAGPUR","Value":"BKID0WAINGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIDYA BANK - SINHGAD ROAD","Value":"SVCB0003014"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIJAY COMMERCIAL CO OP BANK LTD MARKETING YARD","Value":"KKBK0VCCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIKAS COOPERATIVE BANK LTD","Value":"ICIC00VBLTR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIKAS SAHAKARI BANK LTD","Value":"IBKL0478VSB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIKAS SOUHARDA CO OP BANK LTD","Value":"HDFC0CVIKAS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIKAS SOUHARDA CO OPERATIVE BANK LTD","Value":"ICIC00VSCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIKAS URBAN COOPERATIVE BANK NIYAMITHA","Value":"ICIC00VIKAS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIKRAMADITYA NAGRIK SAHKARI BANK LTD.","Value":"ICIC00VNSBU"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VISHWANATHRAO PATIL MURGUD SAHAKARI BANK, ASSEMBLY ROAD","Value":"IBKL0116VMB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VYSYA COOPERATIVE BANK LTD","Value":"UTIB0SVCBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WAI URBAN COOP BK LTD - THERGAON","Value":"SVCB0016019"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WANI NAGRI SAHKARI BANK LTD","Value":"HDFC0CWNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARANGAL URBAN COOP BANK LIMITED","Value":"ICIC00WUCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARANGAL URBAN COOP BANK LTD","Value":"UTIB0SWUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARDHA DIST ASHIRWAD MAHILA NAG SAH","Value":"UTIB0SWDAM1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARDHA ZILAPARISHAD EMPLOYEES URBAN","Value":"UTIB0SWJP01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARDHA ZILLA PARISHAD EMPLOYEES URBAN CO-OP BANK","Value":"ICIC00WZPEC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARDHAMAN URBAN CO-OPERATIVE BANK LTD","Value":"IBKL0510WUC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WB BSG CCAVENUE INTEGRATION","Value":"KKBK0CCAVEN"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WBBSG BILLDESK INTEGRATION","Value":"KKBK0BILDSK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"YASHWANT NAGARI SAHAKARI BANK LTD","Value":"HDFC0CYNSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"YESHWANT URBAN CO OP BANK LTD UDGIR","Value":"KKBK0YUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"YOUTH DEVELOPMENT COOP BANK LTD.KOL","Value":"HDFC0CYDCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ZILA SAHAKARI BANK LTD MAU","Value":"ICIC00ZSMAU"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ZILA SAHKARI BANK LTD","Value":"ICIC00MIRZA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ZILA SAHKARI BANK LTD MORADABAD","Value":"IBKL0122SBM"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ABHYUDAYA COOPERATIVE BANK LIMITED","Value":"ABHY0065001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ROYAL BANK OF SCOTLAND N V","Value":"ABNA0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE AKOLA DISTRICT CENTRAL COOPERATIVE BANK","Value":"ADCC0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AKOLA JANATA COMMERCIAL COOPERATIVE BANK","Value":"AKJB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALLAHABAD UP GRAMEEN BANK","Value":"BKIDPARYGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AHMEDABAD MERCANTILE COOPERATIVE BANK","Value":"AMCB0660002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AUSTRALIA AND NEW ZEALAND BANKING GROUP LIMITED","Value":"ANZB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANDHRA PRAGATHI GRAMEENA BANK","Value":"APGB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE A.P. MAHESH COOPERATIVE URBAN BANK LIMITED","Value":"APMC0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BASSEIN CATHOLIC COOPERATIVE BANK LIMITED","Value":"BACB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK OF BARODA","Value":"BARB0AAMBUR"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BARCLAYS BANK","Value":"BARC0INBB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK OF BAHARAIN AND KUWAIT BSC","Value":"BBKM0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK OF CEYLON","Value":"BCEY0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANDHAN BANK LIMITED","Value":"BDBL0001000"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK OF INDIA","Value":"BKID0000150"},{"Disabled":false,"Group":null,"Selected":false,"Text":"B N P PARIBAS","Value":"BNPA0009008"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK OF AMERICA","Value":"BOFA0BG3978"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK OF TOKYO MITSUBISHI LIMITED","Value":"BOTM0BL3626"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITIZEN CREDIT COOPERATIVE BANK LIMITED","Value":"CCBL0209002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JP MORGAN BANK","Value":"CHAS0INBX01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITI BANK","Value":"CITI0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITY UNION BANK LIMITED","Value":"CIUB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CAPITAL SMALL FINANCE BANK LIMITED","Value":"CLBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CANARA BANK","Value":"CNRB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CREDIT SUISEE AG","Value":"CRES0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI CHHATRAPATI RAJASHRI SHAHU URBAN COOPERATIVE BANK LIMITED","Value":"CRUB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CATHOLIC SYRIAN BANK LIMITED","Value":"CSBK0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"COMMONWEALTH BANK OF AUSTRALIA","Value":"CTBA0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHINATRUST COMMERCIAL BANK LIMITED","Value":"CTCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEVELOPMENT BANK OF SINGAPORE","Value":"DBSS0IN0811"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEOGIRI NAGARI SAHAKARI BANK LTD. AURANGABAD","Value":"DEOB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEUSTCHE BANK","Value":"DEUT0000PBC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEPOSIT INSURANCE AND CREDIT GUARANTEE CORPORATION","Value":"DICG0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DELHI STATE COOPERATIVE BANK LIMITED","Value":"DLSC0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DHANALAKSHMI BANK","Value":"DLXB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DOMBIVLI NAGARI SAHAKARI BANK LIMITED","Value":"DNSB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DOHA BANK QSC","Value":"DOHB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"EXPORT IMPORT BANK OF INDIA","Value":"EIBI0HO0001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"EQUITAS SMALL FINANCE BANK LIMITED","Value":"ESFB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"FEDERAL BANK","Value":"FDRL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"FIRSTRAND BANK LIMITED","Value":"FIRN0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GREATER BOMBAY COOPERATIVE BANK LIMITED","Value":"GBCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE GADCHIROLI DISTRICT CENTRAL COOPERATIVE BANK LIMITED","Value":"GDCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GURGAON GRAMIN BANK","Value":"GGBK0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HASTI COOP BANK LTD","Value":"HCBL0000101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HIMACHAL PRADESH STATE COOPERATIVE BANK LTD","Value":"HPSC0000051"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HSBC BANK","Value":"HSBC0110002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WOORI BANK","Value":"HVBK0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANK INTERNASIONAL INDONESIA","Value":"IBBK0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IDBI BANK","Value":"IBKL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDUSTRIAL BANK OF KOREA","Value":"IBKO0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDUSTRIAL AND COMMERCIAL BANK OF CHINA LIMITED","Value":"ICBK0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IDFC BANK LIMITED","Value":"IDFB0010201"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IDUKKI DISTRICT CO OPERATIVE BANK LTD","Value":"IDUK0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDUSIND BANK","Value":"INDB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANASEVA SAHAKARI BANK LIMITED","Value":"JANA0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANASEVA SAHAKARI BANK BORIVLI LIMITED","Value":"JASB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE JALGAON PEOPELS COOPERATIVE BANK LIMITED","Value":"JPCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANAKALYAN SAHAKARI BANK LIMITED","Value":"JSBL0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANATA SAHAKARI BANK LIMITED","Value":"JSBP0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KANGRA CENTRAL COOPERATIVE BANK LIMITED","Value":"KACE0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KALLAPPANNA AWADE ICHALKARANJI JANATA SAHAKARI BANK LIMITED","Value":"KAIJ0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KANGRA COOPERATIVE BANK LIMITED","Value":"KANG0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KARNATAKA BANK LIMITED","Value":"KARB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KALUPUR COMMERCIAL COOPERATIVE BANK","Value":"KCCB0AKL045"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KALYAN JANATA SAHAKARI BANK","Value":"KJSB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KERALA GRAMIN BANK","Value":"KLGB0040101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KURMANCHAL NAGAR SAHAKARI BANK LIMITED","Value":"KNSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KEB Hana Bank","Value":"KOEX0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KARAD URBAN COOPERATIVE BANK LIMITED","Value":"KUCB0488000"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KARUR VYSYA BANK","Value":"KVBL0001101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KARNATAKA VIKAS GRAMEENA BANK","Value":"KVGB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Maharashtra Gramin Bank","Value":"MAHG00000SC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHANAGAR COOPERATIVE BANK","Value":"MCBL0960002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MUMBAI DISTRICT CENTRAL COOPERATIVE BANK LIMITED","Value":"MDCB0680001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MIZUHO BANK LTD","Value":"MHCB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHARASHTRA STATE COOPERATIVE BANK","Value":"MSCI0LCBS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MASHREQBANK PSC","Value":"MSHQ0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MEHSANA URBAN COOPERATIVE BANK","Value":"MSNU0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MUNICIPAL COOPERATIVE BANK LIMITED","Value":"MUBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NATIONAL AUSTRALIA BANK LIMITED","Value":"NATA0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NATIONAL BANK OF ABU DHABI PJSC","Value":"NBAD0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGPUR NAGARIK SAHAKARI BANK LIMITED","Value":"NGSB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NEW INDIA COOPERATIVE BANK LIMITED","Value":"NICB0000003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NASIK MERCHANTS COOPERATIVE BANK LIMITED","Value":"NMCB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NUTAN NAGARIK SAHAKARI BANK LIMITED","Value":"NNSB0128002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BANK OF NOVA SCOTIA","Value":"NOSC0000DEL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAINITAL BANK LIMITED","Value":"NTBL0AGR072"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGAR URBAN CO OPERATIVE BANK","Value":"NUCB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAVNIRMAN CO-OPERATIVE BANK LIMITED","Value":"NVNM0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HSBC BANK OMAN SAOG","Value":"OIBA0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ORIENTAL BANK OF COMMERCE","Value":"ORBC0000023"},{"Disabled":false,"Group":null,"Selected":false,"Text":"G P PARSIK BANK","Value":"PJSB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRAGATHI KRISHNA GRAMIN BANK","Value":"PKGB0010500"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PUNJAB AND MAHARSHTRA COOPERATIVE BANK","Value":"PMCB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRIME COOPERATIVE BANK LIMITED","Value":"PMEC0USVSBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PANDHARPUR URBAN CO OP. BANK LTD. PANDHARPUR","Value":"PUCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PUNJAB NATIONAL BANK","Value":"PUNB0038600"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RABOBANK INTERNATIONAL","Value":"RABO0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RBL Bank Limited","Value":"RATN0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RESERVE BANK OF INDIA, PAD","Value":"RBIS0AHPA01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJKOT NAGRIK SAHAKARI BANK LIMITED","Value":"RNSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJGURUNAGAR SAHAKARI BANK LIMITED","Value":"RSBL0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE RAJASTHAN STATE COOPERATIVE BANK LIMITED","Value":"RSCB0017012"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SBER BANK","Value":"SABR0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAHEBRAO DESHMUKH COOPERATIVE BANK LIMITED","Value":"SAHE0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMARTH SAHAKARI BANK LTD","Value":"SBLS0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"STANDARD CHARTERED BANK","Value":"SCBL0036001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SURAT DISTRICT COOPERATIVE BANK LIMITED","Value":"SDCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHINHAN BANK","Value":"SHBK0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SOLAPUR JANATA SAHAKARI BANK LIMITED","Value":"SJSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIKSHAK SAHAKARI BANK LIMITED","Value":"SKSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SUMITOMO MITSUI BANKING CORPORATION","Value":"SMBC0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIVALIK MERCANTILE CO OPERATIVE BANK LTD","Value":"SMCB0001000"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SOCIETE GENERALE","Value":"SOGE0INBB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARASWAT COOPERATIVE BANK LIMITED","Value":"SRCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SBM BANK MAURITIUS LIMITED","Value":"STCB0000065"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SURAT NATIONAL COOPERATIVE BANK LIMITED","Value":"SUNB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SUTEX COOPERATIVE BANK LIMITED","Value":"SUTB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SEVA VIKAS COOPERATIVE BANK LIMITED","Value":"SVBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SYNDICATE BANK","Value":"SYNB0000005"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE THANE BHARAT SAHAKARI BANK LIMITED","Value":"TBSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE THANE DISTRICT CENTRAL COOPERATIVE BANK LIMITED","Value":"TDCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TUMKUR GRAIN MERCHANTS COOPERATIVE BANK LIMITED","Value":"TGMB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TAMIL NADU STATE APEX COOPERATIVE BANK","Value":"TNSC0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TELANGANA STATE COOP APEX BANK","Value":"TSAB0000101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UNION BANK OF INDIA","Value":"UBIN0530018"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCO BANK","Value":"UCBA0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UNITED OVERSEAS BANK LIMITED","Value":"UOVB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UNITED BANK OF INDIA","Value":"UTBI0AAD648"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VARACHHA COOPERATIVE BANK LIMITED","Value":"VARA0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIJAYA BANK","Value":"VIJB0001001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VISHWESHWAR SAHAKARI BANK LIMITED","Value":"VSBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VASAI VIKAS SAHAKARI BANK LIMITED","Value":"VVSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WESTPAC BANKING CORPORATION","Value":"WPAC0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ADINATH COOP BANK LTD HO","Value":"YESB0ACB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANGUL CENTRAL COOP BANK MAIN","Value":"YESB0ACCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMRAVATI DCC BANK HEAD OFFICE","Value":"YESB0ADB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALWAR URBAN COOP BANK ALWAR","Value":"YESB0ALWUCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMALNER URBAN COOP BANK LTD","Value":"YESB0AMALCO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ASTHA MAHILA NAGRIK SAHAKARI BANK MARYADIT","Value":"YESB0AMN001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMBEDKAR NAGRIK SAHKARI BANK LTD","Value":"YESB0ANBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ANENDESHWARI NAGRIK SAHAKARI BANK","Value":"YESB0ANSBM1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AP RAJA MAHESHWARI BANK AMEERPET","Value":"YESB0APRAJ1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AHMEDNAGAR ZPSS BANK HEAD OFFICE","Value":"YESB0APSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ARUNACHAL PRADESH SCB NAHARLAGUN","Value":"YESB0ARCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ARIHANT URBAN COOPERATIVE BANK LTD","Value":"YESB0ARUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ASSOCIATE COOP BANK RING ROAD","Value":"YESB0ASCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AMRAVATI Z P SSB HO","Value":"YESB0ASSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AKOLA URBAN COOP BANK MAIN BRANCH","Value":"YESB0AUB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AKOLA URBAN COOP BANK HO","Value":"YESB0AUBHO1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AURANGABAD DCC BANK HO","Value":"YESB0AURDCC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ALMORA ZILA SAHKARI BANK H O","Value":"YESB0AZSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALASORE BHADRAK CCB HEAD OFFICE","Value":"YESB0BBCB00"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BOUDH COOP CENTRAL BANK HEAD OFFICE","Value":"YESB0BCCB00"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BALASORE COOP URBAN BANK LTD","Value":"YESB0BCUB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BOLANGIR DCCB HEAD OFFICE","Value":"YESB0BDCB00"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHADOHI URBAN COOP BANK GYANPUR","Value":"YESB0BHUC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BRAHMADEODADA BANK SIDDHESHWAR PETH","Value":"YESB0BMSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE BANKI CENTRAL COOP BANK LTD","Value":"YESB0BNKCCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BHAVANA RISHI COOP BANK LB NAGAR","Value":"YESB0BRCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BANDA URBAN COOP BANK GULAR NAKA","Value":"YESB0BUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITIZENS URBAN COOP BANK HO","Value":"YESB0CB0001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHIKHLI URBAN COOP BANK CHIKHLI","Value":"YESB0CCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CHANDRAPUR DCC BANK BABUPETH","Value":"YESB0CDC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CITIZENS COOP BANK JAMMU C O","Value":"YESB0CJ0101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE CKP COOPERATIVE BANK LTD","Value":"YESB0CKPBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CMS NATIONAL OPERATING CENTRE MMR","Value":"YESB0CMSNOC"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CHARTERED SAHAKARI BANK NIYAMITHA","Value":"YESB0CSB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB CUTTACK TINIKONIA BAGICHA","Value":"YESB0CUB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"CUTTACK BANK STREET JAJPUR ROAD","Value":"YESB0CUB102"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB CUTTACK JAGATSINGPUR","Value":"YESB0CUB202"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB CUTTACK SALIPUR","Value":"YESB0CUB302"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB CUTTACK JAJPUR TOWN","Value":"YESB0CUB402"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DISTRICT COOP BANK LTD BARABANKI","Value":"YESB0DBBK01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTTARKASHI ZILA SAH BANK","Value":"YESB0DCBU01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OSMANABAD DIST CENTRAL COOP BANK","Value":"YESB0DCC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OSMANABAD DCC COLLEGE ROAD","Value":"YESB0DCC101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEVELOPMENT COOP BANK SWAROOP NAGAR","Value":"YESB0DEVB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"YES PAY WALLET - CUSTOMER IFSC","Value":"YESB0DIGI01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DELHI NAGRIK SEH BANK SUBZI MANDI","Value":"YESB0DNB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DELHI NAGRIK SEH BANK HO","Value":"YESB0DNB100"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE DELHI ST COOP BANK DARYAGANJ","Value":"YESB0DSC002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB DEHRADUN","Value":"YESB0DUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DEHRADUN DISTT COOP BANK H O","Value":"YESB0DZSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE FAIZ MERCANTILE COOP BANK","Value":"YESB0FAIZBK"},{"Disabled":false,"Group":null,"Selected":false,"Text":"FINANCIAL COOP BANK HO","Value":"YESB0FINCO2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GARHA COOP BANK LTD HATT ROAD","Value":"YESB0GCBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GANDHI COOP URBAN BANK VIJAYAWADA","Value":"YESB0GCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GODAVARI LAXMI COOP BANK NAVI PETH","Value":"YESB0GLCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GANDHIDHAM MERCANTILE COOP BANK LTD","Value":"YESB0GMCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHRI GAJANAN MAHARAJ UCB BHOKARDAN","Value":"YESB0GMUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GANDHIBAGH SAHAKARI BANK HO","Value":"YESB0GSB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"GODAVARI URBAN COOP BANK MAIN BRNCH","Value":"YESB0GUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HP STATE CO-OP BANK SUBZI MANDI","Value":"YESB0HPB051"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HP STATE CO-OP BANK BO BARMANA","Value":"YESB0HPB101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HP STATE CO-OP BANK BHABA NAGAR","Value":"YESB0HPB251"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HP STATE CO-OP BANK BO BAGSIAD","Value":"YESB0HPB301"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HP STATE CO-OP BANK BO BHARANOO","Value":"YESB0HPB401"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE HP STATE CO-OP BANK BADRI NGR","Value":"YESB0HPB551"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HAVELI SAHAKARI BANK HEAD OFFICE","Value":"YESB0HSBLM0"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HINDUSTAN SHIPYARD STAFF COOP BANK","Value":"YESB0HSCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INDORE CLOTH MKT COOP BANK H O","Value":"YESB0ICMB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"INNOVATIVE COOP URBAN BANK LTD","Value":"YESB0ICUBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NASHIK DISTT IMC BANK MAIN","Value":"YESB0IMCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IMPERIAL URBAN COOP BANK JALANDHAR","Value":"YESB0IUBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IMPERIAL URBAN COOP BANK FAIZABAD","Value":"YESB0IUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JAI BHAVANI SAHAKARI BANK LTD HADAPSAR","Value":"YESB0JBSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANASEVA COOP BANK GANJMAL","Value":"YESB0JCBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JOGINDRA CENTRAL COOP BANK SOLAN","Value":"YESB0JCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JIVAN COMM COOP BANK HO","Value":"YESB0JIVAN1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANALAXMI COOP BANK HEAD OFFICE","Value":"YESB0JLCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KHATTRI COOP URBAN BANK DARYAGANJ","Value":"YESB0KCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KAIRA DISTRICT CENTRAL COOP BANK","Value":"YESB0KDCC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KHALILABAD NAGAR SAH BANK COLLECTRT","Value":"YESB0KHBKCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KHORDA CENTRAL COOP BANK SADAR","Value":"YESB0KHCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KOLLAM DISTRICT COOP BANK LTD","Value":"YESB0KLMDCB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"KOTA MAHILA NAGRIK BANK GUMANPURA","Value":"YESB0KMNSB2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE KADI NAG SAH BANK NARANPURA","Value":"YESB0KNB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE KUNBI SAHAKARI BANK PAREL","Value":"YESB0KSB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LAXMI MAHILA NAG SAH BANK HO","Value":"YESB0LMNSB2"},{"Disabled":false,"Group":null,"Selected":false,"Text":"LOKVIKAS NAGARI SAH BANK H O","Value":"YESB0LNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR GURU NANAK INTER COLL","Value":"YESB0LUBGNI"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR KHERI ROAD","Value":"YESB0LUBKRD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR","Value":"YESB0LUBLMP"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR MOHAMMDI","Value":"YESB0LUBMOH"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR NIGHASAN ROAD","Value":"YESB0LUBNRD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR OEL","Value":"YESB0LUBOEL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR PALIA KALAN","Value":"YESB0LUBPAL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB LAKHIMPUR SINGHAI","Value":"YESB0LUBSNG"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MIZORAM COOP APEX BANK HEAD OFFICE","Value":"YESB0MAB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANNDESHI MAHILA SAHAKARI BANK LTD","Value":"YESB0MAN001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MEGHALAYA COOP APEX BANK HEAD OFF","Value":"YESB0MCA001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAYURBHANJ CENTRAL COOP BANK LTD","Value":"YESB0MCCBHO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MONGHYR DCC BANK LTD","Value":"YESB0MDCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAKARPURA IND EST COOP BANK HO","Value":"YESB0MIEB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHANAGAR NAGRIK SAH BANK BAIRAGARH","Value":"YESB0MNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHILA SAMRIDHI BANK BAPU BAZAR","Value":"YESB0MSB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHILA SAMRIDHI BANK SALUMBER","Value":"YESB0MSB175"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANIPUR SCB IMPHAL","Value":"YESB0MSCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Mizoram Urban Coop Development Bank","Value":"YESB0MUDC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE MANIPUR WOMEN S COOP BANK LTD","Value":"YESB0MWCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGAR SAHKARI BANK LTD GORAKHPUR","Value":"YESB0NBGKP1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NATIONAL COOP BANK LTD","Value":"YESB0NBL002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NOBLE COOPERATIVE BANK LTD SEC 22","Value":"YESB0NCB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE NAWADA CENTRAL COOP BANK LTD","Value":"YESB0NCCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAYAGARH DCCB HO BRANCH","Value":"YESB0NDB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAINITAL DCB HEAD OFFICE","Value":"YESB0NDCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NE EC RLY EMP PRIMARY COOP BANK LTD","Value":"YESB0NEEC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAKODAR HINDU URBAN COOP BANK LTD","Value":"YESB0NHUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NATIONAL I E COOP C and BANKING SOC L - HEAD OFFICE","Value":"YESB0NIE001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NASHIK JILHA MAHILA BANK GOLE CLNY","Value":"YESB0NMVB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAVNIRMAN COOP URBAN BANK LTD","Value":"YESB0NNCUBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NASHIK RD DEOLALI VYAPARI SAH BANK","Value":"YESB0NRDB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NORTHERN RLY PR COOP BANK MAIN BRNCH","Value":"YESB0NRPCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGAR SAHKARI BANK MAHARAJGANJ","Value":"YESB0NSB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NAGAR VIKAS SAHKARI BANK HARDOI","Value":"YESB0NVSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NASHIK ZILHA S AND P KARMACHARI BANK","Value":"YESB0NZSPKB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OJHAR MERCHANTS BANK MAIN","Value":"YESB0OMCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"OMKAR NAGREEYA SAH BANK KAUSHALPURI","Value":"YESB0OMKAR1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"POCHAMPALLY COOP BANK POCHAMPALLY","Value":"YESB0PCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PARBHANI DISTRICT CENTRAL COOP BANK","Value":"YESB0PDBHO1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PURNEA DISTRICT CENTRAL COOP BANK","Value":"YESB0PDCCBL"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PANCHKULA URBAN COOP BANK LTD","Value":"YESB0PKUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRAGATI MAHILA NAGRIK SAHAKARI BANK","Value":"YESB0PMNSB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"POSTAL AND RMS EMP COOP BANK AMBALA","Value":"YESB0PRMS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRAGATI SAHAKARI BANK LTD ACY","Value":"YESB0PSB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PARASPAR SAHAYAK COOP BANK MTH COMP","Value":"YESB0PSCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PUSAD UCB MAIN BRANCH","Value":"YESB0PUB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE COOP BANK OF RAJKOT PANCHNATHRD","Value":"YESB0RAJ001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAVI COMMERCIAL URBAN COOP BANK","Value":"YESB0RCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJLAXMI UCB ASHOK STAMBH","Value":"YESB0RLB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RAJSAMAND URBAN COOP BANK RAJSAMAND","Value":"YESB0RUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SATYASHODHAK SAHAKARI BANK","Value":"YESB0SATYA0"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SAMBALPUR DCCB LTD BARGARH","Value":"YESB0SBPB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SANGHAMITRA COOP URBN BANK NALGONDA","Value":"YESB0SCUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE DHARTI COOP BANK HEAD OFFICE","Value":"YESB0SDB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SOLAPUR DIST CENTRAL COOP BANK","Value":"YESB0SDC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIVAM SAHAKARI BANK LTD","Value":"YESB0SHIV01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIHOR MERCANTILE COOP BANK SIHOR","Value":"YESB0SIMC11"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIND COOP URBAN BANK PG ROAD","Value":"YESB0SIND01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHUBHLAKSHMI MAH COOP BANK HO","Value":"YESB0SLMCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHUBHLAKSHMI MAH COOP BANK VIJAYNGR","Value":"YESB0SLMVB4"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MAHESH URBAN COOP BANK LTD","Value":"YESB0SMBLHO"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SUNDARGARH DCCB BARGAON","Value":"YESB0SNGB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SMRITI NAGRIK SAH BANK MANDSAUR","Value":"YESB0SNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SARVODAYA SAH BANK HEAD OFFICE","Value":"YESB0SSBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SIKKIM STATE COOP BANK HO BRANCH","Value":"YESB0SSCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SAMARTH URBAN COOP BANK OSMANABAD","Value":"YESB0SUB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHIMLA URBAN COOP BANK LTD","Value":"YESB0SUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SHREE VARDHAMAN BANK RAOPURA","Value":"YESB0SVSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TEXCO BANK RING ROAD","Value":"YESB0TCB002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MANSA NAGRIK SAH BANK MARKET YARD","Value":"YESB0TMNS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TRANSPORT COOP BANK TRANSPORT NAGAR","Value":"YESB0TPBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PARWANOO URBAN COOP BANK PARWANOO","Value":"YESB0TPCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE PURI URBAN COOP BANK MAIN BR","Value":"YESB0TPUCB1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SATARA SAHAKARI BANK HO WADALA","Value":"YESB0TSSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE TURA URBAN COOP BANK TURA","Value":"YESB0TURA01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UJJAIN AUDHYOGIK VIKAS NAGRIK BANK","Value":"YESB0UAVNS1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE UNITED COOP BANK HEAD OFFICE","Value":"YESB0UBL001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE URBAN COOP BANK MAIN","Value":"YESB0UCBR01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UMA COOPERATIVE BANK NIZAMPURA","Value":"YESB0UMA002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UNITED MERC COOP BANK BILHAUR","Value":"YESB0UMCBBB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UMIYA URBAN COOP BANK HEAD OFFICE","Value":"YESB0UMIB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UJJAIN NAGRIK SAH BANK FREEGANZ","Value":"YESB0UNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UNITED PURI NIMAPARA CCB MAIN BRANCH","Value":"YESB0UPNC01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UJJAIN PARASPAR SAH BANK DEWAS GATE","Value":"YESB0UPSBL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UCB BASTI GANDHI NAGAR","Value":"YESB0URBAN1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UTKAL COOP BANKING SOC BHUBANESHWAR","Value":"YESB0UTKAL1"},{"Disabled":false,"Group":null,"Selected":false,"Text":"UDAIPUR UCB PANNADHAY MARG","Value":"YESB0UUCB02"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VYAPARIK AUDYOGIK SAH BANK HO","Value":"YESB0VASB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VAISH COOP ADARSH BANK DARYAGANJ","Value":"YESB0VCA001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VASANTDADA NAGARI SAHAKARI BANK LTD","Value":"YESB0VDSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VISHWAKARMA SAH BANK HEAD OFFICE","Value":"YESB0VISB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIMA KAMGAR COOP BANK HEAD OFFICE","Value":"YESB0VKCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VAIJAPUR MERCHANTS BANK LASUR STN","Value":"YESB0VMCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIDARBHA MERCHANTS UCB HINGANGHAT","Value":"YESB0VMUB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VAISH COOP NEW BANK HO","Value":"YESB0VNB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"VIKRAMADITYA NAGRIK SAHAKARI BANK","Value":"YESB0VNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE VSV COOPERATIVE BANK LTD","Value":"YESB0VSV001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WANA NAGRI SAHKARI BANK HEAD OFFICE","Value":"YESB0WANA01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARDHA NAGRI BANK HEAD OFFICE","Value":"YESB0WNSB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"WARANGAL URBAN COOP BANK HO","Value":"YESB0WUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE YAVATMAL DCC BANK HO","Value":"YESB0YDC001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"YADAGIRI LNS COOP URBN BANK BHONGIR","Value":"YESB0YLNS01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE YAVATMAL UCB MAIN","Value":"YESB0YUCB01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ZILA SAHKARI BANK LUCKNOW MAIN BR","Value":"YESB0ZSBL01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE ZOROASTRIAN COOPERATIVE BANK LIMITED","Value":"ZCBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"NKGSB COOPERATIVE BANK LIMITED","Value":"NKGS0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PRATHAMA BANK","Value":"PRTH0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PUNJAB AND SIND BANK","Value":"PSIB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"STATE BANK OF INDIA","Value":"SBIN0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"SOUTH INDIAN BANK","Value":"SIBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"THE SHAMRAO VITHAL COOPERATIVE BANK","Value":"SVCB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TJSB SAHAKARI BANK LTD","Value":"TJSB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TAMILNAD MERCANTILE BANK LIMITED","Value":"TMBL0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AXIS BANK","Value":"UTIB0000003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"YES BANK","Value":"YESB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"BARODA RAJASTHAN GRAMIN BANK","Value":"BARB0BRGBXX"},{"Disabled":false,"Group":null,"Selected":false,"Text":"PAYTM PAYMENTS BANK","Value":"PYTM0123456"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Bihar Kshetriya Gramin Bank","Value":"UCBA0RRBBKG"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Baroda Uttar Pradesh Gramin Bank","Value":"BARB0BUPGBX"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Madhya Bihar Gramin Bank","Value":"PUNB0MBGB06"},{"Disabled":false,"Group":null,"Selected":false,"Text":"AU Small Finance Bank","Value":"AUBL0002212"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Kashi Gomati Samyut Gramin Bank","Value":"UBIN0RRBKGS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"The Amravati District Central Co-Operative Bank","Value":"YESB0ADB048"},{"Disabled":false,"Group":null,"Selected":false,"Text":"HDFC Bank credit card","Value":"HDFC0000128"},{"Disabled":false,"Group":null,"Selected":false,"Text":"State Bank of India credit card","Value":"SBIN00CARDS"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Citibank credit card","Value":"CITI0000003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IndusInd Bank credit card","Value":"INDB0000018"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Syndicate Bank credit card","Value":"SYNB0002915"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Axis Bank credit card","Value":"UTIB0000400"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Yes Bank Credit Card","Value":"YESB0CMSNOC "},{"Disabled":false,"Group":null,"Selected":false,"Text":"HSBC Bank credit card","Value":"HSBC0400002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"IDBI BANK credit card","Value":"IBKL0NEFT01"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Punjab National Bank credit card","Value":"PUNB0112000"},{"Disabled":false,"Group":null,"Selected":false,"Text":"American Express Gold credit card","Value":"SCBL0036020"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Indian Overseas Bank  Credit card","Value":"IOBA0009043"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Bank of  India credit Card","Value":"BKID0000101"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Union Bank of India credit  Card","Value":"UBIN0580104"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ICICI Bank credit card","Value":"ICIC0000103"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Vijaya Bank  Credit Card","Value":"VIJB0009020"},{"Disabled":false,"Group":null,"Selected":false,"Text":"kotak bank credit card","Value":"KKBK0000958"},{"Disabled":false,"Group":null,"Selected":false,"Text":"bank of baroda credit card","Value":"BARB0COLABA"},{"Disabled":false,"Group":null,"Selected":false,"Text":"andhra bank credit card","Value":"ANDB0000782"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Ujjivan Small Finance Bank","Value":"UJVN0001111"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Utkarsh Small Finance Bank","Value":"UTKS0001376"},{"Disabled":false,"Group":null,"Selected":false,"Text":"ESAF Small Finance Bank","Value":"ESMF0001134"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Suryoday Small Finance Bank","Value":"SURY0000017"},{"Disabled":false,"Group":null,"Selected":false,"Text":"aditya birla payment bank","Value":"ABPB0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"indian post payment bank","Value":"IPOS0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"jio payment bank","Value":"JIOP0000001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"nsdl payment bank","Value":"NSPB0000002"},{"Disabled":false,"Group":null,"Selected":false,"Text":"sarva up gramin bank","Value":"PUNB0SUPGB5"},{"Disabled":false,"Group":null,"Selected":false,"Text":"TBC BANK","Value":"TBCBGE22830"},{"Disabled":false,"Group":null,"Selected":false,"Text":"DBS BANK","Value":"DBSS0IN0811"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Jodhpur Central Co-Operative Bank","Value":"RSCB0026001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"madhyanchal gramin bank","Value":"SBIN0RRMBGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"sarva haryana gramin bank","Value":"PUNB0HGB001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"punjab gramin bank","Value":"PUNB0PGB003"},{"Disabled":false,"Group":null,"Selected":false,"Text":"The Surat Peoples Co-op Bank Ltd","Value":"SPCB0251009"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Gramin Bank Of Aryavart","Value":"BKID0ARYAGB"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Rajkot Peoples Co-Operative Bank Ltd","Value":"IBKL01642RP"},{"Disabled":false,"Group":null,"Selected":false,"Text":"Baroda Gujarat Gramin Bank","Value":"BARB0BGGBXX"},{"Disabled":false,"Group":null,"Selected":false,"Text":"RBL Credit Card","Value":"RATN0CRCARD"},{"Disabled":false,"Group":null,"Selected":false,"Text":"The Gujarat state co-operative Bank","Value":"GSCB0AMR001"},{"Disabled":false,"Group":null,"Selected":false,"Text":"JANA SMALL FINANCE BANK LTD","Value":"JSFB0004537"},{"Disabled":false,"Group":null,"Selected":false,"Text":"MADHYA PRADESH GRAMIN BANK","Value":"CBIN0R20002"}]}';
	}
	public function Register_ben()
	{
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;


        $user_id = $this->session->userdata("MdId");
        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));


		$mobile_no = $this->input->post("senderno");
		$acc_no = $this->input->post("account");
		$ifsc = $this->input->post("ifsccode");
		$bankname = $this->input->post("originalifsccode");
        $bene_name = $this->input->post("benname");
        $bene_mobile = $mobile_no;
        $bank_id  = 0;

        $this->load->model("Instapay");
        $resp = $this->Instapay->beneficiary_register($mobile_no,$bene_name,$bene_mobile,$ifsc,$acc_no,$userinfo,$bank_id);

        header('Content-Type: application/json');
       
		/*
        $resp_arr = array(
            "message"=>"Beneficiary Registration Successful",
            "status"=>0,
            "statuscode"=>"TXN",
            "remiter_id"=>$remiterid,
            "beneid"=>$beneid
        );
        */
        $json_obj = json_decode($resp);
        if(isset($json_obj->message) and isset($json_obj->status) and isset($json_obj->statuscode))
        {
            $message = $json_obj->message;
            $status = $json_obj->status;
            $statuscode = $json_obj->statuscode;
            if($statuscode == "TXN")
            {
                $remiter_id = $json_obj->remiter_id;
                $beneid = $json_obj->beneid;
                $resp_array = array(
                    "statuscode"=>$statuscode,
                    "status"=>$status,
                    "data"=>array(
                            "remitter"=>array(
                                                  "id"=>$mobile_no  
                                            ),
                            "beneficiary"=>array(
                                                    "status"=>"0",
                                                   "id"=>$beneid  
                                            )
                    )
                );
                echo json_encode( $resp_array);exit;
            }
        }
       
		echo '{"statuscode":"TXN","status":"Transaction Successful","data":{"remitter":{"id":"9df65d80104e4b2cb5700974d149f489"},"beneficiary":{"status":"0","id":"9df65d80104e4b2cb5700974d149f489"}}}';
		
	}
	public function Verify_account()
	{
        if($this->session->userdata('MdUserType') != "MasterDealer") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        header('Content-Type: application/json');

        $user_id = $this->session->userdata("MdId");
        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($user_id));

		$mobile_no = $this->input->post("NUMBER");
		$acc_no = $this->input->post("account");
		$ifsc = $this->input->post("benIFSC");
		$bankname = $this->input->post("bankname");
        $bank_id = "";
        $this->load->model("Instapay");
        $resp = $this->Instapay->verify_bene($mobile_no,$acc_no,$ifsc,$bank_id,$userinfo);
        $json_obj = json_decode($resp);
        if(isset($json_obj->status) and isset($json_obj->message) and isset($json_obj->statuscode))
        {
            $status = $json_obj->status;
            $message = $json_obj->message;
            $statuscode = $json_obj->statuscode;
            if($statuscode == "TXN")
            {
                $recipient_name = $json_obj->recipient_name;
                $resp_array = array(
                        "statuscode"=>$statuscode,
                        "status"=>$message,
                        "Local"=>"",
                        "data"=>array("benename"=>$recipient_name)
                );
                echo json_encode($resp_array);exit;
            }
            else
            {
                 $resp_array = array(
                        "statuscode"=>$statuscode,
                        "status"=>$message,
                        "Local"=>""
                );
                echo json_encode($resp_array);exit;
            }
        }
        else
        {
            $resp_array = array(
                        "statuscode"=>"ERR",
                        "status"=>"Unknown Response From Server. Pleaes Try Again",
                        "Local"=>""
                );
            echo json_encode($resp_array);exit;
        }
		echo '{"statuscode":"LOW","status":"Balance Fatching Problem."}';
	}
	public function index()
	{	
		if($this->session->userdata('MdUserType') != "MasterDealer") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
		
		 //  //$otherdb = $this->load->database('otherdb', TRUE); 
			$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("MdId") ));
			if($mt_rslt->num_rows() == 1)
			{
				$mtaccess = $mt_rslt->row(0)->mt_access;
				if($mtaccess != '1')
				{
					redirect(base_url()."Retailer/recharge_home?crypt=".$this->Common_methods->encrypt("Mydata"));
				}
				
			}
			
			
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache"); 
			$user=$this->session->userdata('MdUserType');			
			if(trim($user) == 'MasterDealer')
			{
				if(isset($_POST["hidencrdata"]) and isset($_POST["txtNumber"]))
				{
					//9999999991
					//360880
					
					$hidencrdata = $this->Common_methods->decrypt($this->input->post("hidencrdata"));
				
					if($hidencrdata == $this->session->userdata("session_id"))
					{
						$txtNumber = trim($this->input->post("txtNumber",TRUE));
						$user_id = $this->session->userdata("MdId");
						
						
					//	$otherdb = $this->load->database('otherdb', TRUE);
						
						$userinfo = $this->db->query("select user_id,businessname,username,status,usertype_name,mobile_no from tblusers where user_id = ?",array($user_id));
						if($userinfo->num_rows() == 1)
						{
							$status = $userinfo->row(0)->status;
							$user_id = $userinfo->row(0)->user_id;
							$business_name = $userinfo->row(0)->businessname;
							$username = $userinfo->row(0)->username;
							$mobile_no = $userinfo->row(0)->mobile_no;
							$usertype_name = $userinfo->row(0)->usertype_name;
							if($status == '1')
							{
								if(ctype_digit($txtNumber))
								{
									
									    $rsltcommon = $this->db->query("select * from common where param = 'DMRSERVICE'");
        							    if($rsltcommon->num_rows() == 1)
        							    {
        							        $is_service = $rsltcommon->row(0)->value;
        							    	if($is_service == "DOWN")
        							    	{
        							    	    $resp_arr = array(
                    								"message"=>"Service Temporarily Down",
                    								"status"=>1,
                    								"statuscode"=>"ERR",
                    								);
                        						$this->session->set_flashdata("MESSAGEBOXTYPE","FAILURE");
                        						$this->session->set_flashdata("MESSAGEBOX","Service Temporarily Down");
												$this->view_data["MESSAGEBOX"] = "Service Temporarily Down";
												redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
        							    	}
        							    }
									    
									    
									      
									        $this->load->model("Mastermoney");
    										$jsonresp =  $this->Mastermoney->remitter_details($txtNumber,$userinfo);
    									    $jsonobj = json_decode($jsonresp);
    									
    										if(isset($jsonobj->message) and isset($jsonobj->status) and isset($jsonobj->statuscode))
    										{
    											$message = trim((string)$jsonobj->message);
    											$status = trim((string)$jsonobj->status);
    											$statuscode = trim((string)$jsonobj->statuscode);
    										//	echo $statuscode;exit;
    											if($status == "1" and  ($statuscode == "RNF" or $statuscode == "323"))
    											{
    											    
    											    $this->session->set_flashdata("f_sendermobile",$txtNumber);
    												redirect(base_url()."Retailer/dmrmm_sender_registration?crypt1=".$this->Common_methods->encrypt($txtNumber)."&crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
    											}
    											else if($status == "0" and $statuscode == "TXN")
    											{
    													
    														$this->session->set_userdata("SenderMobile",$txtNumber);
    														$this->session->set_userdata("MT_USER_ID",$user_id);
    														$this->session->set_userdata("MT_LOGGED_IN",TRUE);
    														redirect(base_url()."Retailer/dmrmm_dashboard?crypt=".$this->Common_methods->encrypt("getcustomerinfo"));
    											}
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
					else
					{
							$this->session->set_flashdata("MESSAGEBOX_MESSAGETYPE","FAILURE");
							$this->session->set_flashdata("MESSAGEBOX_MESSAGEBODY","MESSAGE :: Invalid Request");
							redirect(base_url()."Retailer/dmrmm_home?crypt=".$this->Common_methods->encrypt("MyData"));
					}
				}	
				else
				{		
						$this->view_data['message'] ="";
						$this->load->view('MasterDealer_new/dmrmm_home_view',$this->view_data);
				}
			} 
		}
	}
}	