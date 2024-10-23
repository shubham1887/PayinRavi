<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IndoNepal extends CI_Controller {

  function __construct()
  {
      parent:: __construct();
      $this->is_logged_in();
      $this->clear_cache();
  }
  function is_logged_in() 
  {
    if ($this->session->userdata('AgentUserType') != "Agent") 
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
      $this->load->model("IndoNepalPrabhu");
       error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
  }
  public function Receipt()
  {
    if(isset($_GET["Id"]))
    {
      $Id = trim($this->input->get("Id"));
      $user_id = $this->session->userdata("AgentId");
      $result_data = $this->db->query("SELECT 
              a.Id, a.user_id, a.add_date, a.ipaddress, a.CustomerId, a.SenderName, a.SenderGender, 
              a.SenderDoB, a.SenderAddress, a.SenderPhone, a.SenderMobile, a.SenderCity, 
              a.SenderIdType,a.SenderIdNumber,
              a.SenderDistrict, a.SenderState, a.SenderNationality, a.Employer, a.SenderIDType, 
              a.SenderIDNumber, a.ReceiverId, a.ReceiverName, a.ReceiverGender, a.ReceiverAddress, 
              a.ReceiverMobile, a.ReceiverCity, a.SendCountry, a.PayoutCountry, a.PaymentMode, 
              a.CollectedAmount, a.ServiceCharge, a.SendAmount, a.SendCurrency, a.PayAmount, 
              a.PayCurrency, a.ExchangeRate, a.BankBranchId, a.AccountNumber, a.AccountType, 
              a.NewAccountRequest, a.PartnerPinNo, a.IncomeSource, a.RemittanceReason, 
              a.Relationship, a.CSPCode, a.OTPProcessId, a.OTP, a.status, a.response, 
              a.update_datetime, a.update_ip, a.Charge_Amount, a.debited, a.reverted, 
              a.balance, a.debit_amount, a.aCode, a.aMessage, 
              a.aTrnsactionId, a.aPinNo, a.verify_status, a.verify_response, a.verify_code ,
              b.businessname,b.username,b.mobile_no,
              info.postal_address
            FROM indonepal_transaction a
            left join tblusers b on a.user_id = b.user_id
            left join tblusers_info info on a.user_id = info.user_id
 where a.user_id = ? and a.Id = ? order by Id",array($user_id,$Id));

      $this->view_data["data"] = $result_data;
      $this->load->view("Retailer/print_in_online_copy_view",$this->view_data);


    }
  }





  public function getDistrict()
  {


    $rslt = $this->db->query("SELECT * FROM `indonepal_statedistrict_india` where aState = 'Maharashtra'");
    echo json_encode(json_encode($rslt->result()));exit;


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



      $user_id = $this->session->userdata("AgentId");
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

        $rsltbank = $this->IndoNepalPrabhu->getBankName();
        echo json_encode($rsltbank);exit;
        //echo $str;exit;
    }
    public function BankCityList()
    {
        header('Content-Type: application/json');
        $response = file_get_contents('php://input');
        $json_obj = json_decode($response);
        if(isset($json_obj->BankName))
        {
          $BankName = $json_obj->BankName;
          $rsltbank = $this->IndoNepalPrabhu->getBankCity($BankName);
          echo json_encode($rsltbank);exit;
        }
        
        //echo $str;exit; 
    }

    public function BankBranchList()
    {
        header('Content-Type: application/json');
        $response = file_get_contents('php://input');
        $json_obj = json_decode($response);
        if(isset($json_obj->City) and isset($json_obj->BankName))
        {
          $City = $json_obj->City;
          $BankName = $json_obj->BankName;
          $rsltbank = $this->IndoNepalPrabhu->getBankBranch($City,$BankName);
          echo json_encode($rsltbank);exit;
        }
    }


    public function DistrictList()
    {
        header('Content-Type: application/json');
        $response = file_get_contents('php://input');
        $json_obj = json_decode($response);
        if(isset($json_obj->State))
        {
         $State = $json_obj->State;
          $rslt = $this->db->query("select aDistrict from indonepal_statedistrict_india where aState = ?",array($State)); 
          echo json_encode(json_encode($rslt->result()));exit;
        }
    }


    public function Showtransaction()
    {
      header('Content-Type: application/json;charset=utf-8;');
      //echo '"one Rupees only."';exit;
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->trxnamount))
      {

          $amount = $json_obj->trxnamount;
          $PaymentMode = $json_obj->mode;
          $BankBranchId = "";
          if(isset($json_obj->BankBranchId))
          {
            $BankBranchId = $json_obj->BankBranchId;
          }
          $number = $amount;
          $no = floor($number);
          $point = round($number - $no, 2) * 100;
          $hundred = null;
          $digits_1 = strlen($no);
          $i = 0;
          $str = array();
          $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
          $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
          while ($i < $digits_1) 
          {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) 
            {
              $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
              $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
              $str [] = ($number < 21) ? $words[$number] .
                  " " . $digits[$counter] . $plural . " " . $hundred
                  :
                  $words[floor($number / 10) * 10]
                  . " " . $words[$number % 10] . " "
                  . $digits[$counter] . $plural . " " . $hundred;
           } else $str[] = null;
          }
          $str = array_reverse($str);
          $result = implode('', $str);
          $points = ($point) ?
          "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';


          $AmountInWords =  $result . "Rupees";


          $ServiceCharge_data = $this->IndoNepalPrabhu->getServiceCharge($amount,$PaymentMode,$BankBranchId);//($amount);


          $resp_array = array(
            "AmountInWords"=>$AmountInWords,
            "ServiceCharge_data" => json_decode($ServiceCharge_data) 
          );
          echo json_encode($resp_array);
 
      }
      else if(isset($json_obj->trxnamount_collection))
      {
        $amount = $json_obj->trxnamount_collection;
        $number = $amount;
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
          '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
          '7' => 'seven', '8' => 'eight', '9' => 'nine',
          '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
          '13' => 'thirteen', '14' => 'fourteen',
          '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
          '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
          '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
          '60' => 'sixty', '70' => 'seventy',
          '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) 
        {
          $divider = ($i == 2) ? 10 : 100;
          $number = floor($no % $divider);
          $no = floor($no / $divider);
          $i += ($divider == 10) ? 1 : 2;
          if ($number) 
          {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
         } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ?
        "." . $words[$point / 10] . " " . 
        $words[$point = $point % 10] : '';


        $AmountInWords =  $result . "Rupees";


        $ServiceCharge_data = $this->IndoNepalPrabhu->getServiceChargeByCollection($amount);


        $resp_array = array(
          "AmountInWords"=>$AmountInWords,
          "ServiceCharge_data" => json_decode($ServiceCharge_data) 
        );
        echo json_encode($resp_array);
      }
    }
    public function DoFundTransfer()
    {
      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
     
      /*
  {"number":"8238232303","rcptID":"9859","amount":"1000","paymentType":"Cash Payment","refernceNumber":1}

          {"number":"8238232303","remitterID":"","name":"Ravikant Ravikant","rcptID":"8238232303","accountNo":"103201500069","ifscCode":"ICIC0000001","rcptName":"Tejas Badiyani","bankName":"Australia And New Zealand Banking Group Limited","amount":"100","paymentType":"IMPS","refernceNumber":1}
      */
       $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
       header('Content-Type: application/json');
       if($user_info->num_rows() == 1)
       {
          $user_id = $user_info->row(0)->user_id;
          $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
          if(isset($json_obj->number) and isset($json_obj->rcptID) and isset($json_obj->amount)  and isset($json_obj->paymentType) and
            isset($json_obj->refernceNumber) and isset($json_obj->remitancereason))
          {

            $number =  trim((string)$json_obj->number);
            $receiver_id =  trim((string)$json_obj->rcptID);
            $amount =  trim((string)$json_obj->amount);
            $paymentType =  trim((string)$json_obj->paymentType);
            $refernceNumber =  trim((string)$json_obj->refernceNumber);
            $remitancereason =  trim((string)$json_obj->remitancereason);
            $ProcessId =  trim((string)$json_obj->ProcessId);
            $TransOtp =  trim((string)$json_obj->TransOtp);

            $balance = $this->Ew2->getAgentBalance($user_id);
            if($balance > ($amount + 200))
            {
                
                $user_id = $this->session->userdata("AgentId");

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
                            if($amount > 60000)
                            {
                              $resp_array = array(
                                              "StatusCode"=>0,
                                              "Message"=>"Invalid Amount",
                                            );
                              echo json_encode($resp_array);exit;
                                
                            }
                            
                            $order_id = 0;

                        
                            if(ctype_digit($number))
                            {
                                $insta_remitterid = false;
                                $sender_info = $this->db->query("select * from indonepal_customers where Status = 'Verified' and Mobile = ? ",array($number));
                                if($sender_info->num_rows() == 1)
                                {
                                  $receiver_info = $this->db->query("select * from indonepal_ReceiverRegistration where  aReceiverId = ? and CustomerMobile = ?",array($receiver_id,$number));
                                  if($receiver_info->num_rows() == 1)
                                  {
                                    $this->load->model("IndoNepalPrabhu");  
                                    //transfer($sender_info,$receiver_info,$userinfo,$order_id,$SendAmount,$RemittanceReason)  
                                    $resp = $this->IndoNepalPrabhu->transfer($sender_info,$receiver_info,$userinfo,$order_id,$amount,$remitancereason,$ProcessId,$TransOtp);
                                    echo $resp;exit;
                                  }
                                  else
                                  {
                                    echo "invalid receiver id";exit;
                                  }
                                }
                                else
                                {
                                  echo "Invalid Sender";exit;
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
    public function TransferAmountDetails()//IN
    {
      $this->load->model("IndoNepalPrabhu");
      $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
       header('Content-Type: application/json');
       if($user_info->num_rows() == 1)
       {
          $user_id = $user_info->row(0)->user_id;
          $response = file_get_contents('php://input');
          $json_obj = json_decode($response);
         // print_r($json_obj);exit;
          if(isset($json_obj->amount) and isset($json_obj->mobileNumber) and isset($json_obj->accountNo)  and isset($json_obj->tPin) )
          {
            $ReceiverId =  trim((string)$json_obj->RecipientId);
            $PaymentMode =  trim((string)$json_obj->mode);
            
            $amount =  trim((string)$json_obj->amount);
            $mobileNumber =  trim((string)$json_obj->mobileNumber);
            $accountNo =  trim((string)$json_obj->accountNo);
            $tPin =  trim((string)$json_obj->tPin);
            $balance = $this->Ew2->getAgentBalance($user_id);
            if($balance > ($amount + 200))
            {
                $amount_split_array  = array();
                $temparray = array(
                                    "SLNO"=>1,
                                    "Amount"=>$amount,
                                    "ServiceCharge"=> 200,
                                    "MarginAmount"=>0,
                                    "Total"=>$amount + 200
                                  );
                array_push($amount_split_array,$temparray);

                $CustomerId = $this->IndoNepalPrabhu->getCustomerId($mobileNumber);

                $this->load->model("IndoNepalPrabhu");
                $resp_otp = $this->IndoNepalPrabhu->sendOTP_transfer($mobileNumber,$CustomerId,$ReceiverId,$PaymentMode,$user_info);





                $resp_array = array(
                    "StatusCode"=>1,
                    "Message"=>"Success",
                    "Data"=>$amount_split_array,
                    "TotalAmount"=>$amount,
                    "CustomerPayAmount"=>$amount,
                    "TotalCharge"=>200,
                    "TotalMargin"=>0,
                    "TxnRefNumber"=>0001,
                    "OTP_RESPONSE"=>json_decode($resp_otp)
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
          else if(isset($json_obj->amount) and isset($json_obj->mobileNumber)  and isset($json_obj->tPin) )
          {

            $ReceiverId =  trim((string)$json_obj->RecipientId);
            $PaymentMode =  trim((string)$json_obj->mode);
            $amount =  trim((string)$json_obj->amount);
            $mobileNumber =  trim((string)$json_obj->mobileNumber);
            $accountNo =  "";
            $tPin =  trim((string)$json_obj->tPin);
            $PaymentMode =  trim((string)$json_obj->mode);
            $balance = $this->Ew2->getAgentBalance($user_id);
            if($balance > ($amount + 200))
            {
                $CustomerId = $this->IndoNepalPrabhu->getCustomerId($mobileNumber);

                
                $resp_otp = $this->IndoNepalPrabhu->sendOTP_transfer($mobileNumber,$CustomerId,$ReceiverId,$PaymentMode,$user_info);




                $serviceChargeInfo = $this->IndoNepalPrabhu->getServiceCharge($amount,$PaymentMode,"");
                $service_charge_obj = json_decode($serviceChargeInfo);
                if(isset($service_charge_obj->aCollectionAmount))
                {
                      $aCollectionAmount = $service_charge_obj->aCollectionAmount;
                      $aCollectionCurrency = $service_charge_obj->aCollectionCurrency;
                      $aServiceCharge = $service_charge_obj->aServiceCharge;
                      $aTransferAmount = $service_charge_obj->aTransferAmount;
                      $aExchangeRate = $service_charge_obj->aExchangeRate;
                      $aPayoutAmount = $service_charge_obj->aPayoutAmount;
                      $aPayoutCurrency = $service_charge_obj->aPayoutCurrency;
                }

                $amount_split_array  = array();
                $temparray = array(
                                    "SLNO"=>1,
                                    "Amount"=>$amount,
                                    "ServiceCharge"=> $aServiceCharge,
                                    "MarginAmount"=>0,
                                    "Total"=>$amount + $aServiceCharge
                                  );
                array_push($amount_split_array,$temparray);

                $resp_array = array(
                    "StatusCode"=>1,
                    "Message"=>"Success",
                    "Data"=>$amount_split_array,
                    "info_TransferAmount"=>$aTransferAmount,
                    "info_CollectionAmount"=>$aCollectionAmount,
                    "info_ExchangeRate"=>$aExchangeRate,
                    "info_PayoutAmount"=>$aPayoutAmount,
                    "info_TotalCharge"=>$aServiceCharge,
                    "info_TotalMargin"=>0,
                    "TxnRefNumber"=>0001,
                    "OTP_RESPONSE"=>json_decode($resp_otp)
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
    public function RemiRegistration() //IN
    {
      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
      /*
      {number: "8866142003", fname: "ravikant", lName: "chavda", pinCode: "380001", otp: "123456"}
      */
      header('Content-Type: application/json');
      $response = file_get_contents('php://input');


      /*
      fname: $scope.rmtFirstName, 
      DOB: $scope.rmtDOB, 
      Gender: $scope.rmtGender, 
      number: $scope.rmtMobileNumber, 
      EmailId: $scope.rmtEmailId, 
      Nationality: $scope.rmtNationality, 
      Address: $scope.rmtAddress, 
      State: $scope.rmtState, 
      District: $scope.rmtDistrict, 
      City: $scope.rmtCity, 
      IdType: $scope.rmtIdType, 
      IdNumber: $scope.rmtIdNumber, 
      IncomeSource: $scope.rmtIncomeSource, 
      Employeer: $scope.rmtEmployeer, 
      otp: $scope.rmtOtp 
      */
      $json_obj = json_decode($response);
      if(isset($json_obj->fname) and isset($json_obj->DOB) and isset($json_obj->Gender) and isset($json_obj->number)  and isset($json_obj->EmailId)  and isset($json_obj->Nationality)   and isset($json_obj->Address)   and isset($json_obj->State)   and isset($json_obj->District)   and isset($json_obj->City)   and isset($json_obj->IdType)   and isset($json_obj->IdNumber)   and isset($json_obj->IncomeSource)   and isset($json_obj->Employeer)   and isset($json_obj->otp))
      {

        
        $fname =  trim((string)$json_obj->fname);
        $DOB =  trim((string)$json_obj->DOB);
        $Gender =  trim((string)$json_obj->Gender);
        $number =  trim((string)$json_obj->number);
        $EmailId =  trim((string)$json_obj->EmailId);
        $Nationality =  trim((string)$json_obj->Nationality);
        $Address =  trim((string)$json_obj->Address);
        $State =  trim((string)$json_obj->State);
        $District =  trim((string)$json_obj->District);
        if($District > 0)
        {
          $rslt_getDistrictname = $this->db->query("select aDistrict from indonepal_statedistrict_india where Id = ?",array($District));
          if($rslt_getDistrictname->num_rows() == 1)
          {
            $District = $rslt_getDistrictname->row(0)->aDistrict;
          }
        }



        $City =  trim((string)$json_obj->City);
        $IdType =  trim((string)$json_obj->IdType);
        $IdNumber =  trim((string)$json_obj->IdNumber);
        $IncomeSource =  trim((string)$json_obj->IncomeSource);
        $Employeer =  trim((string)$json_obj->Employeer);


        $IDExpiryDate = "";
        $IDIssuedPlace = "";

        $OTP =  trim((string)$json_obj->otp);

        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
        $request_by = "WEB";

        $requestid_rslt = $this->db->query("select ProcessId from indonepal_CustomerRegistrationOtp where CustomerMobile = ? and user_id = ? order by Id desc limit 1",array($number,$this->session->userdata("AgentId")));
        if($requestid_rslt->num_rows() == 1)
        {
            $OTPProcessId = $requestid_rslt->row(0)->ProcessId;
            $this->load->model("IndoNepalPrabhu");
            $remiter_reg_response = $this->IndoNepalPrabhu->createCustomer($fname,$Gender,$DOB,$Address,$number,$State,$District,$City,$Nationality,$EmailId,$Employeer,$IdType,$IdNumber,$IDExpiryDate,$IDIssuedPlace,$IncomeSource,$OTPProcessId,$OTP,$userinfo,$request_by);
            echo json_encode($remiter_reg_response);exit;
        }
        else
        {
            $resp_array = array(
                "status"=>0,
                "StatusCode"=>0,
                "Message"=>"Something Went Wrong.Please Try Again",
                "message"=>"Something Went Wrong.Please Try Again",
                "statuscode"=>"ERR",

            );
            echo json_encode($resp_array);exit;
        }
       // echo $number." ".$fname." ".$lName." ".$pinCode." ".$otp."  ".$requset_id;exit;
        
        //($number,$fname,$lName,$address1,$address2,$pinCode,$requset_id,$otp,$user_info);
        //($number,$user_info,"registrationOtp");
        
      }
    }
    public function GenerateReference()//IN
    {

error_reporting(-1);
ini_set('display_errors',1);
$this->db->db_debug = TRUE;

      header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number))
      {
        $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
        $number =  trim((string)$json_obj->number);
        $this->load->model("IndoNepalPrabhu");
        $remiter_detail = $this->IndoNepalPrabhu->sendOTP_CreateCustomer($number,$user_info);
        echo json_encode($remiter_detail);exit;
      }



     // $resp = '"{\r\n  \"StatusCode\": 1,\r\n  \"Message\": \"OTP sent on mobile number.\",\r\n  \"Data\": null\r\n}"';
    }
    public function ValidateSender() // IN partially done
    {
       header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number))
      {
        $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
        $number =  trim((string)$json_obj->number);
        $this->load->model("IndoNepalPrabhu");
        $remiter_detail = $this->IndoNepalPrabhu->getCustomerByMobile($number,$user_info);
        echo json_encode($remiter_detail);exit;
      }
     
        
    }



    public function GenerateReceiverCashPaymentReference()//IN
    {


      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;

      header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number) and isset($json_obj->name))
      {
        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
        $number =  trim((string)$json_obj->number);
        $name =  trim((string)$json_obj->name);
        $PaymentMode = "Cash Payment";
        $BankBranchId = $AccountNumber = "";

        $this->load->model("IndoNepalPrabhu");
        $receiver_detail = $this->IndoNepalPrabhu->sendOTP_CreateReceiver($number,$name,$PaymentMode,$BankBranchId,$AccountNumber,$userinfo);
        
        echo json_encode($receiver_detail);exit;
      }



     // $resp = '"{\r\n  \"StatusCode\": 1,\r\n  \"Message\": \"OTP sent on mobile number.\",\r\n  \"Data\": null\r\n}"';
    
    }
    public function ReceiverRegistrationCashPayment()//IN
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
      if(isset($json_obj->SenderMobile) and isset($json_obj->ReceiverName) and isset($json_obj->ReceiverGender) and isset($json_obj->ReceiverMobileNo)  and isset($json_obj->ReceiverAddress)  and isset($json_obj->ReceiverRelationship))
      {

        
        $SenderMobile =  trim((string)$json_obj->SenderMobile);
        $ReceiverName =  trim((string)$json_obj->ReceiverName);
        $ReceiverGender =  trim((string)$json_obj->ReceiverGender);
        $ReceiverMobileNo =  trim((string)$json_obj->ReceiverMobileNo);
        $ReceiverAddress =  trim((string)$json_obj->ReceiverAddress);
        $ReceiverRelationship =  trim((string)$json_obj->ReceiverRelationship);
        

        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
        $request_by = "WEB";

        
            $PaymentMode = "Cash Payment";
            $BankBranchId = "";
            $AccountNumber = "";


            $this->load->model("IndoNepalPrabhu");
            $remiter_reg_response = $this->IndoNepalPrabhu->CreateReceiver($SenderMobile,$ReceiverName,$ReceiverGender,$ReceiverMobileNo,$ReceiverAddress,$ReceiverRelationship,$PaymentMode,$BankBranchId,$AccountNumber,$userinfo);

            echo json_encode($remiter_reg_response);exit;
        
       // echo $number." ".$fname." ".$lName." ".$pinCode." ".$otp."  ".$requset_id;exit;
        
        //($number,$fname,$lName,$address1,$address2,$pinCode,$requset_id,$otp,$user_info);
        //($number,$user_info,"registrationOtp");
        
      }
    
    }


    public function ReceiverRegistrationAccountDeposit()//IN
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
      if(isset($json_obj->SenderMobile) and isset($json_obj->ReceiverName) and isset($json_obj->ReceiverGender) and isset($json_obj->ReceiverMobileNo)  and isset($json_obj->ReceiverAddress)  and isset($json_obj->ReceiverRelationship)
        and isset($json_obj->AccountNo) and isset($json_obj->BankBranchName) )
      {

        
        $SenderMobile =  trim((string)$json_obj->SenderMobile);
        $ReceiverName =  trim((string)$json_obj->ReceiverName);
        $ReceiverGender =  trim((string)$json_obj->ReceiverGender);
        $ReceiverMobileNo =  trim((string)$json_obj->ReceiverMobileNo);
        $ReceiverAddress =  trim((string)$json_obj->ReceiverAddress);
        $ReceiverRelationship =  trim((string)$json_obj->ReceiverRelationship);


        $BankBranchId =  trim((string)$json_obj->BankBranchName);
        $AccountNumber =  trim((string)$json_obj->AccountNo);
        

        $userinfo = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
        $request_by = "WEB";

        
            $PaymentMode = "Account Deposit";
           


            $this->load->model("IndoNepalPrabhu");
            $remiter_reg_response = $this->IndoNepalPrabhu->CreateReceiver($SenderMobile,$ReceiverName,$ReceiverGender,$ReceiverMobileNo,$ReceiverAddress,$ReceiverRelationship,$PaymentMode,$BankBranchId,$AccountNumber,$userinfo);

            echo json_encode($remiter_reg_response);exit;
        
       // echo $number." ".$fname." ".$lName." ".$pinCode." ".$otp."  ".$requset_id;exit;
        
        //($number,$fname,$lName,$address1,$address2,$pinCode,$requset_id,$otp,$user_info);
        //($number,$user_info,"registrationOtp");
        
      }
    
    }




    


    function parsedata($soapResponse)
  {
    $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $soapResponse);
    $xml = simplexml_load_string($xml);
    $json = json_encode($xml);
    return $responseArray = json_decode($json,true);
    
    exit;
  }
    public function UploadDocument()
    {

      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;
      $mobile_no = $this->input->post("etCustomerMobile");

      $etIDNumber = $this->input->post("etIDNumber");
      $etIDType = $this->input->post("etIDType");
      $etdocumentType = "ID Card Front";


      //echo $mobile_no."  ".$etIDNumber."   ".$etIDType;exit;

      $user_id = $this->session->userdata("AgentId");

      $sender_info = $this->db->query("SELECT CustomerId FROM `indonepal_customers` where  Mobile = ?",array($mobile_no));
     
      if($sender_info->num_rows() == 1)
      {
          $CustomerId = intval($sender_info->row(0)->CustomerId);
          if (is_uploaded_file($_FILES['file_idProof']['tmp_name'])) 
          {
           $tmp = explode('.',$_FILES['file_idProof']['name']);
           $file_ext=strtolower(end($tmp));
            $expensions= array("jpeg","jpg","png", "JPEG","JPG", "PNG","PDF","pdf");
            if(in_array($file_ext,$expensions)=== false)
            {
                 echo "extension not allowed, please choose a JPEG or PNG file.";exit;
                
            }
            else
            {
                $file_name = $_FILES['file_idProof']['name'];

                $imageFileType = strtolower(pathinfo($_FILES['file_idProof']['tmp_name'],PATHINFO_EXTENSION));
                $image_base64 = base64_encode(file_get_contents($_FILES['file_idProof']['tmp_name']) );
                $fp2 = 'data:image/'.$imageFileType.';base64,'.$image_base64;
                $image2 = true;
                //$prabhu_url='https://sandbox.prabhuindia.com/Api/Send.svc?wsdl';
                $prabhu_url = 'https://www.prabhuindia.com/Api/Send.svc?wsdl';
                $prabhu_username='SAMS_API';
                $prabhu_password='SamS#api951';
                $postfield_data="<Envelope xmlns=\"http://schemas.xmlsoap.org/soap/envelope/\">
                            <Body>
                                <UploadCustomerDocument xmlns=\"http://tempuri.org/\">
                                    <UploadCustomerDocumentRequest>
                                        <UserName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_username."</UserName>
                                        <Password xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$prabhu_password."</Password>
                                        <CustomerId xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$CustomerId."</CustomerId>
                                        <FileName xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$file_name."</FileName>
                                        <DocumentType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$etdocumentType."</DocumentType>
                                        <IDType xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$etIDType."</IDType>
                                        <FileBase64 xmlns=\"http://schemas.datacontract.org/2004/07/Remit.API\">".$image_base64."</FileBase64>
                                    </UploadCustomerDocumentRequest>
                                </UploadCustomerDocument>
                            </Body>
                        </Envelope>";

                  $curl = curl_init();

                  curl_setopt_array($curl, array(
                    CURLOPT_URL => $prabhu_url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS =>$postfield_data,
                    CURLOPT_HTTPHEADER => array(
                      "Content-Type: text/xml",
                      "SOAPAction: http://tempuri.org/ISend/UploadCustomerDocument"
                    ),
                  ));

                  $response = curl_exec($curl);

                 
                  curl_close($curl);
                  $json_obj = $this->parsedata($response);


                   $this->load->model("IndoNepalPrabhu");
                  $this->IndoNepalPrabhu->add_db_log("upload document",$postfield_data,json_encode($json_obj),$prabhu_url,$user_id,"");

                  $this->db->query("insert into indonepal_CustomerRegistrationDocumentUpload(user_id,add_date,ipaddress,CustomerId,FileName,DocumentType,IDType,FileBase64,response) values(?,?,?,?,?,?,?,?,?)",array($user_id,$this->common->getDate(),$this->common->getRealIpAddr(),$CustomerId,$file_name,$etdocumentType,$etIDType,$image_base64, json_encode($json_obj)));

                  /*
                        {"sBody":{"UploadCustomerDocumentResponse":{"UploadCustomerDocumentResult":{"aCode":"000","aMessage":"File Upload Successfully"}}}}
                  */
              
                if(isset($json_obj["sBody"]))
                {
                  $sBody = $json_obj["sBody"];
                  $UploadCustomerDocumentResponse = $sBody["UploadCustomerDocumentResponse"];
                  if(isset($UploadCustomerDocumentResponse["UploadCustomerDocumentResult"]))
                  {
                    $UploadCustomerDocumentResult = $UploadCustomerDocumentResponse["UploadCustomerDocumentResult"];
                    
                    if(isset($UploadCustomerDocumentResult["aCode"]))
                    {
                      $aCode = trim($UploadCustomerDocumentResult["aCode"]);
                      if($aCode == "000")
                      {
                        /*
                        {"sBody":{"CreateCustomerResponse":{"CreateCustomerResult":{"aCode":"000","aMessage":"Success","aCustomerId":"9060"}}}}
                        */
                          
                        $aMessage = trim($UploadCustomerDocumentResult["aMessage"]);
                       
                        
                        
                          $resp_array = array(
                            "message"=>$aMessage,
                            "status"=>0,
                            "statuscode"=>"TXN",
                            "Message"=>$aMessage,
                            "StatusCode"=>1

                          );
                          //return json_encode($resp_array);
                          redirect(base_url()."Retailer/IndoNepal");
                        
                      }
                      else 
                      {
                        
                        $aMessage = trim($UploadCustomerDocumentResult["aMessage"]);

                        $resp_array = array(
                          "message"=>$aMessage,
                          "status"=>1,
                          "statuscode"=>"RNF",
                          "Message"=>$aMessage,
                          "StatusCode"=>0
                        );
                        //return json_encode($resp_array);
                         redirect(base_url()."Retailer/IndoNepal");
                      }
                      

                    }
                  }
                }
                 
            }
          
         
        }
      }


       redirect(base_url()."Retailer/IndoNepal");
      
    }





    public function SenderBeneficiaryList()
    {
       header('Content-Type: application/json');
       $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number))
      {
        $this->load->model("IndoNepalPrabhu");
         $mobile_no =$json_obj->number;
         $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
         $bene_list = $this->IndoNepalPrabhu->getbenelist2($mobile_no,$user_info,0,0);
         echo json_encode($bene_list);exit; 
      }


       
    }

    public function AccountInquiry()
    {
        error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;

      header('Content-Type: application/json');
      $this->load->model("Paytm");
       $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
      //header('Content-Type: application/json');
      $response = file_get_contents('php://input');
      $json_obj = json_decode($response);
      if(isset($json_obj->number) and isset($json_obj->remitterID) and isset($json_obj->name) and isset($json_obj->accountNo)  and isset($json_obj->ifscCode)  and isset($json_obj->bankName)  )
      {
          $mobile_no = trim($json_obj->number);
          $remitterID = trim($json_obj->remitterID);
          $bene_name = trim($json_obj->name);
          $acc_no = trim($json_obj->accountNo);
          $ifsc = trim($json_obj->ifscCode);
          $bank = trim($json_obj->bankName);
         


         // echo $bank;exit;


          $apiresponse = $this->Paytm->verify_bene($mobile_no,$acc_no,$ifsc,$bank,$user_info);
          //($mobile_no,$bene_name,$mobile_no,$acc_no,$ifsc,$bank,$user_info);
          echo $apiresponse;exit;
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
    public function RcptRegistration()
    {

      error_reporting(-1);
      ini_set('display_errors',1);
      $this->db->db_debug = TRUE;

      header('Content-Type: application/json');
      $this->load->model("IndoNepalPrabhu");
       $user_info = $this->db->query("select * from tblusers where user_id = ?",array($this->session->userdata("AgentId")));
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
        if($this->session->userdata('AgentUserType') != "Agent") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        if(isset($_POST["benid"]) and isset($_POST["senderno"]))
        {
            $benid = $this->input->post("benid");
            $senderno = $this->input->post("senderno");    
             header('Content-Type: application/json');



             $user_id = $this->session->userdata("AgentId");
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
        if($this->session->userdata('AgentUserType') != "Agent") 
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
        if($this->session->userdata('AgentUserType') != "Agent") 
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

            $user_id = $this->session->userdata("AgentId");
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
        if($this->session->userdata('AgentUserType') != "Agent") 
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

            $user_id = $this->session->userdata("AgentId");
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
        if($this->session->userdata('AgentUserType') != "Agent") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        header('Content-Type: application/json');

		$mobile_no = $this->input->post("senderno");
		$otp = $this->input->post("otp");
		$benid = $this->input->post("benid");
        $user_id = $this->session->userdata("AgentId");
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
        if($this->session->userdata('AgentUserType') != "Agent") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        $user_id = $this->session->userdata("AgentId");
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

    		if($this->session->userdata('AgentUserType') != "Agent") 
    		{ 
    			echo "LOGIN_FAILED";exit;
    		} 

            $user_id = $this->session->userdata("AgentId");
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
	{}
	public function Register_ben()
	{
        if($this->session->userdata('AgentUserType') != "Agent") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug = TRUE;


        $user_id = $this->session->userdata("AgentId");
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
        if($this->session->userdata('AgentUserType') != "Agent") 
        { 
           echo "LOGIN_FAILED";exit;
        } 
        header('Content-Type: application/json');

        $user_id = $this->session->userdata("AgentId");
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
		if($this->session->userdata('AgentUserType') != "Agent") 
		{ 
			redirect(base_url().'login'); 
		} 
		else 
		{ 
		
		 //  //$otherdb = $this->load->database('otherdb', TRUE); 
			$mt_rslt = $this->db->query("select mt_access from tblusers where user_id = ?",array($this->session->userdata("AgentId") ));
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
			$user=$this->session->userdata('AgentUserType');			
			if(trim($user) == 'Agent')
			{
				if(isset($_POST["hidencrdata"]) and isset($_POST["txtNumber"]))
				{
					//9999999991
					//360880
					
					$hidencrdata = $this->Common_methods->decrypt($this->input->post("hidencrdata"));
				
					if($hidencrdata == $this->session->userdata("session_id"))
					{
						$txtNumber = trim($this->input->post("txtNumber",TRUE));
						$user_id = $this->session->userdata("AgentId");
						
						
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
            $state_array  = array();
            $district_array  = array();
            $statedistrict = $this->db->query("select aState,aDistrict,aStateCode from indonepal_statedistrict_india order by Id");
            foreach($statedistrict->result() as $rwstatedist)	
            {
                array_push($state_array,$rwstatedist->aState);
                array_push($district_array,$rwstatedist->aDistrict);
            }
            $state_array = array_unique($state_array);
            $district_array = array_unique($district_array);
            
						$this->view_data['message'] ="";
            $this->view_data['state_array'] = $state_array;
            $this->view_data['district_array'] = $district_array;
            $this->view_data['message'] ="";
						$this->load->view('Retailer/IndoNepal_view',$this->view_data);
				}
			} 
		}
	}
  public function BindDistrict()
  {
    if(isset($_GET["state"]))
    {
      $state = trim($this->input->get("state"));
      
      $statedistrict = $this->db->query("select aState,aDistrict,aStateCode from indonepal_statedistrict_india where aState = ? group BY aDistrict order by aDistrict" ,array($state));
      $str = '<option value="">select</option>';
        foreach($statedistrict->result() as $rwstatedist)   
        {
            $str .='<option value="'.$rwstatedist->aDistrict.'">'.$rwstatedist->aDistrict.'</option>';
        }
        echo $str;exit;
    }
  }
}	