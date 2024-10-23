<?php
class Billavennue extends CI_Model 
{ 
  function _construct()
  {
      // Call the Model constructor
      parent::_construct();
  }
  private function getLiveUrl($type)
  { 
    if($type == "balance")
    {
        $url = 'https://api.billavenue.com/billpay/enquireDeposit/fetchDetails/xml';
    }
    
    
    
    return $url;
  }
  private function getKey()
  {
    return "1C7BE9FD837109A6CDF80B10936E26C6";
  }
  private function getAccessCode()
  {
    return "AVOA69BU89HA17HPJD";
  }
  private function getInstituteId()
  {
    return "CC57";
  }
  private function getVersion()
  {
    return "1.0";
  }
  
  private function getOutletId()
  {
    return 4244;
  }
  
  public function balance()
  {
  
      $plainText = '<?xml version="1.0" encoding="UTF-8"?><depositDetailsRequest><fromDate>2017-08-22</fromDate><toDate>2017-09-22</toDate><transType>DR</transType><agents><agentId>CC01CC57AGT000000638</agentId></agents></depositDetailsRequest>';
        $key = $this->getKey();
        $encrypt_xml_data = $this->encrypt($plainText, $key);
        
        $data['accessCode'] =$this->getAccessCode();
        $data['requestId'] = $this->generateRandomString();
        $data['encRequest'] = $encrypt_xml_data;
        $data['ver'] = $this->getVersion();
        $data['instituteId'] = $this->getInstituteId();
        
        $parameters = http_build_query($data);
        
        $url = "https://api.billavenue.com/billpay/enquireDeposit/fetchDetails/xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
       // echo $result . "////////////////////";
        $response = $this->decrypt($result, $key);


//echo $plainText."<hr>";

//echo "Request Id :: ".$data['requestId'];
//echo "<hr>";
//print_r($response);exit;

        $xmlresp = simplexml_load_string($response);
        $Wallet = 0;
        if(isset($xmlresp->currentBalance))
        {
            $Wallet =  $xmlresp->currentBalance;exit;
        }
        //print_r($xmlresp);exit;
       // echo "<pre>";
      // echo htmlentities($response);
      //  exit;
    $this->loging("billavennue_balance",$plainText,$buffer,$Wallet,"Admin");
    return $Wallet;
    
  }
  



 public function complain($txnRefId,$complaintDesc,$complaintDisposition)
  {
      $plainText = '<?xml version="1.0" encoding="UTF-8"?><complaintRegistrationReq><complaintType>Transaction</complaintType><participationType>BILLER</participationType><agentId>CC01CC57AGT000000638</agentId><txnRefId>'.trim($txnRefId).'</txnRefId><billerId /><complaintDesc>'.$complaintDesc.'</complaintDesc><servReason>Agent overcharging</servReason><complaintDisposition>Transaction Successful, account not updated.</complaintDisposition></complaintRegistrationReq>';

/*
  <?xml version="1.0" encoding="UTF-8"?><complaintRegistrationReq><complaintType>Transaction</complaintType><participationType /><agentId /><txnRefId>CC01ACT81667</txnRefId><billerId /><complaintDesc>Complaint initiated through API</complaintDesc><servReason /><complaintDisposition>Transaction Successful, account not updated</complaintDisposition></complaintRegistrationReq>



  <?xml version="1.0" encoding="UTF-8"?><complaintRegistrationReq><complaintType>Transaction</complaintType><participationType /><agentId /><txnRefId>CC01ADH91094</txnRefId><billerId /><complaintDesc>Complaint initiated through API</complaintDesc><servReason /><complaintDisposition>Transaction Successful, account not updated.</complaintDisposition></complaintRegistrationReq>

*/

     
      $plainText = '<?xml version="1.0" encoding="UTF-8"?><complaintRegistrationReq><complaintType>Transaction</complaintType><participationType /><agentId /><txnRefId>'.trim($txnRefId).'</txnRefId><billerId /><complaintDesc>'.$complaintDesc.'</complaintDesc><servReason /><complaintDisposition>'.$complaintDisposition.'</complaintDisposition></complaintRegistrationReq>';
 //    print htmlentities($plainText);exit;

      $rslt = $this->db->query("insert into bbps_complains(add_date,ipaddress,TxnId,ComplainDisposition,complainDesc) values(?,?,?,?,?)",
        array($this->common->getDate(),$this->common->getRealIpAddr(),$txnRefId,$complaintDisposition,$complaintDesc));
      if($rslt == true)
      {
        $insert_id = $this->db->insert_id();
        $key = $this->getKey();
        $encrypt_xml_data = $this->encrypt($plainText, $key);
        $requestId = $this->generateRandomString();
        $data['accessCode'] =$this->getAccessCode();
        $data['requestId'] =  $requestId;
        $data['encRequest'] = $encrypt_xml_data;
        $data['ver'] = $this->getVersion();
        $data['instituteId'] = $this->getInstituteId();
        
        $parameters = http_build_query($data);
        // $url = "https://stgapi.billavenue.com/billpay/extComplaints/register/xml";
        $url = "https://api.billavenue.com/billpay/extComplaints/register/xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        //echo $result . "////////////////////";
        $response = $this->decrypt($result, $key);


        $json_obj = simplexml_load_string($response);
       
        if(isset($json_obj->responseCode))
        {
         
          if($json_obj->responseCode == "000")
          {
              $complain_id = (string)$json_obj->complaintId;
              $responseReason = (string)$json_obj->responseReason;

              $this->db->query("update bbps_complains set ComplainId=?,ComplainMessage=? where Id = ?",array($complain_id,$responseReason,$insert_id));


              return $response;
              // $resp_array = array(
              //   "message"=>$responseReason,
              //   "status"=>"0",
              //   "statuscode"=>"TXN"
              // );
              // return $resp_array;
          }
          else
          {

              $complain_id = (string)$json_obj->complaintId;
              $responseReason = (string)$json_obj->responseReason;
              

              $errorInfo = $json_obj->errorInfo;



              $this->db->query("update bbps_complains set ComplainId=?,ComplainMessage=?,errormessage = ? where Id = ?",array($complain_id,$responseReason,json_encode($errorInfo),$insert_id));


              
            $resp_array = array(
                "message"=>"Something Went Wrong",
                "status"=>"1",
                "statuscode"=>"ERR"
              );
              return $resp_array;
          }
        }
        return $response;
      }

         


        /*

<?xml version="1.0" encoding="UTF-8" standalone="yes"?><complaintRegistrationResp><complaintAssigned>PAYU PAYMENTS PRIVATE LIMITED   02</complaintAssigned><complaintId>CC0120296672580</complaintId><responseCode>000</responseCode><responseReason>SUCCESS</responseReason></complaintRegistrationResp>



<?xml version="1.0" encoding="UTF-8" standalone="yes"?><complaintRegistrationResp><complaintAssigned></complaintAssigned><complaintId></complaintId><responseCode>257</responseCode><responseReason>FAILURE</responseReason><errorInfo><error><errorCode>CMR007</errorCode><errorMessage>Complaint Management - Transaction Ref Id fixed length should be 12 or 20</errorMessage></error><error><errorCode>CMR007</errorCode><errorMessage>Complaint Management - Transaction Ref Id fixed length should be 12 or 20</errorMessage></error></errorInfo></complaintRegistrationResp>
        */

    $this->loging("billavennue_balance",$plainText,$buffer,$Wallet,"Admin");
    return $Wallet;
    
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

public function getSenderInfo($mobile_no)
  {
  /*


URL:- https://dashboard.billavenue.com/agentInstitute/

URL's for production:

DMT Service Request URL: https://api.billavenue.com/billpay/dmt/dmtServiceReq/xml?

DMT Transaction Request URL: https://api.billavenue.com/billpay/dmt/dmtTransactionReq/xml?

Deposit Enquiry URL: https://api.billavenue.com/billpay/enquireDeposit/fetchDetails/xml

Please find the below Credentials for Production Environment:-
Agent Institution ID    CC57
Agent Institution Name    Champion Software Technologies Limited
Access Code    AVOA69BU89HA17HPJD
Working Key    1C7BE9FD837109A6CDF80B10936E26C6
Virtual Account No    AIPL3698CC575241
IFSC Code    ICIC0000104
Bank Name    CMS HUB, Mumbai
Branch Name    ICICI Bank Ltd.
Deposit Balance (INR)    8321.00


  */
    
       $plainText = '<?xml version="1.0" encoding="UTF-8"?><dmtServiceRequest><requestType>SenderDetails</requestType><senderMobileNumber>'.$mobile_no.'</senderMobileNumber><txnType>IMPS</txnType></dmtServiceRequest>';
    echo htmlentities($plainText);
    echo "<br><br>";
        $key = $this->getKey();
        $encrypt_xml_data = $this->encrypt($plainText, $key);
        $requestId = $this->generateRandomString();
        $data['accessCode'] =$this->getAccessCode();
        $data['requestId'] =  $requestId;
        $data['encRequest'] = $encrypt_xml_data;
        $data['ver'] = $this->getVersion();
        $data['instituteId'] = $this->getInstituteId();
        
        $parameters = http_build_query($data);
        
        $url = "https://api.billavenue.com/billpay/dmt/dmtServiceReq/xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        echo $result . "////////////////////";exit;
        $response = $this->decrypt($result, $key);
        echo $response;exit;
        $xmlresp = simplexml_load_string($response);
        print_r($xmlresp);exit;
        if(isset($xmlresp->responseCode))
        {
            $biller = $xmlresp->biller; 
            foreach($biller as $billrow)
            {
               $billerId = trim((string)$billrow->billerId);
               $billerName = trim((string)$billrow->billerName);
               $billerCategory = trim((string)$billrow->billerCategory);
               $billerAdhoc = trim((string)$billrow->billerAdhoc);
               $billerCoverage = trim((string)$billrow->billerCoverage);
               $billerFetchRequiremet = trim((string)$billrow->billerFetchRequiremet);
               $billerPaymentExactness = trim((string)$billrow->billerPaymentExactness);
         
         $supportPendingStatus = trim((string)$billrow->supportPendingStatus);
         $supportDeemed = trim((string)$billrow->supportDeemed);

               $billerSupportBillValidation = trim((string)$billrow->billerSupportBillValidation);
               $billerAmountOptions = trim((string)$billrow->billerAmountOptions);
               $billerPaymentModes = trim((string)$billrow->billerPaymentModes);
               $billerDescription = $billrow->billerDescription;
               $rechargeAmountInValidationRequest = trim((string)$billrow->rechargeAmountInValidationRequest);
               $billerInputParams = $billrow->billerInputParams;

               $rsltinsert = $this->db->query("insert into billavennue_operators(billerId,billerName,billerCategory,billerAdhoc,billerCoverage,billerFetchRequiremet,billerPaymentExactness,supportPendingStatus,supportDeemed,billerAmountOptions,billerPaymentModes)
                values(?,?,?,?,?,?,?,?,?,?,?)",
                array(
                    $billerId,$billerName,$billerCategory,$billerAdhoc,$billerCoverage,$billerFetchRequiremet,$billerPaymentExactness,
                    $supportPendingStatus,$supportDeemed,$billerAmountOptions,$billerPaymentModes
                  )
               );


//print_r($billerInputParams);exit;

               foreach($billerInputParams->paramInfo as $inpprms)
               {
                   $paramName = trim((string)$inpprms->paramName);
                   $dataType = trim((string)$inpprms->dataType);
                   $isOptional = trim((string)$inpprms->isOptional);
                   $minLength = trim((string)$inpprms->minLength);
                   $maxLength = trim((string)$inpprms->maxLength);
                   $regEx = "";

        if($rsltinsert == true)
        {
            $this->db->query("insert into billavennue_operators_billerInputParams(billerId,paramName,dataType,isOptional,minLength,maxLength,regEx) 
            values(?,?,?,?,?,?,?)",
            array(
              $billerId,$paramName,$dataType,$isOptional,$minLength,$maxLength,$regEx
            ));
        }
                   
                   
                   
               }
             
            }
        }
        else
        {
            
        }
        $jsonobj = json_encode($xmlresp);
        
       // echo "<pre>";
       // echo htmlentities($response);
      //  exit;
    $this->loging("billavennue_balance",json_encode($parameters),$buffer,$Wallet,"Admin");
    return $Wallet;
    
  }

  public function getbillerInfo($billerId)
  {
  
      $plainText = '<?xml version="1.0" encoding="UTF-8"?><billerInfoRequest><billerId>'.$billerId.'</billerId></billerInfoRequest>';
       $plainText = '<?xml version="1.0" encoding="UTF-8"?><billerInfoRequest></billerInfoRequest>';
    echo htmlentities($plainText);
    echo "<br><br>";
        $key = $this->getKey();
        $encrypt_xml_data = $this->encrypt($plainText, $key);
        $requestId = $this->generateRandomString();
        $data['accessCode'] =$this->getAccessCode();
        $data['requestId'] =  $requestId;
        $data['encRequest'] = $encrypt_xml_data;
        $data['ver'] = $this->getVersion();
        $data['instituteId'] = $this->getInstituteId();
        
        $parameters = http_build_query($data);
        
        $url = "https://api.billavenue.com/billpay/extMdmCntrl/mdmRequest/xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        //echo $result . "////////////////////";
        $response = $this->decrypt($result, $key);
        echo $response;exit;
        $xmlresp = simplexml_load_string($response);
        print_r($xmlresp);exit;
        if(isset($xmlresp->responseCode))
        {
            $biller = $xmlresp->biller; 
            foreach($biller as $billrow)
            {
               $billerId = trim((string)$billrow->billerId);
               $billerName = trim((string)$billrow->billerName);
               $billerCategory = trim((string)$billrow->billerCategory);
               $billerAdhoc = trim((string)$billrow->billerAdhoc);
               $billerCoverage = trim((string)$billrow->billerCoverage);
               $billerFetchRequiremet = trim((string)$billrow->billerFetchRequiremet);
               $billerPaymentExactness = trim((string)$billrow->billerPaymentExactness);
         
         $supportPendingStatus = trim((string)$billrow->supportPendingStatus);
         $supportDeemed = trim((string)$billrow->supportDeemed);

               $billerSupportBillValidation = trim((string)$billrow->billerSupportBillValidation);
               $billerAmountOptions = trim((string)$billrow->billerAmountOptions);
               $billerPaymentModes = trim((string)$billrow->billerPaymentModes);
               $billerDescription = $billrow->billerDescription;
               $rechargeAmountInValidationRequest = trim((string)$billrow->rechargeAmountInValidationRequest);
               $billerInputParams = $billrow->billerInputParams;

               $rsltinsert = $this->db->query("insert into billavennue_operators(billerId,billerName,billerCategory,billerAdhoc,billerCoverage,billerFetchRequiremet,billerPaymentExactness,supportPendingStatus,supportDeemed,billerAmountOptions,billerPaymentModes)
                values(?,?,?,?,?,?,?,?,?,?,?)",
                array(
                    $billerId,$billerName,$billerCategory,$billerAdhoc,$billerCoverage,$billerFetchRequiremet,$billerPaymentExactness,
                    $supportPendingStatus,$supportDeemed,$billerAmountOptions,$billerPaymentModes
                  )
               );


//print_r($billerInputParams);exit;

               foreach($billerInputParams->paramInfo as $inpprms)
               {
                   $paramName = trim((string)$inpprms->paramName);
                   $dataType = trim((string)$inpprms->dataType);
                   $isOptional = trim((string)$inpprms->isOptional);
                   $minLength = trim((string)$inpprms->minLength);
                   $maxLength = trim((string)$inpprms->maxLength);
                   $regEx = "";

        if($rsltinsert == true)
        {
            $this->db->query("insert into billavennue_operators_billerInputParams(billerId,paramName,dataType,isOptional,minLength,maxLength,regEx) 
            values(?,?,?,?,?,?,?)",
            array(
              $billerId,$paramName,$dataType,$isOptional,$minLength,$maxLength,$regEx
            ));
        }
                   
                   
                   
               }
             
            }
        }
        else
        {
            
        }
        $jsonobj = json_encode($xmlresp);
        
       // echo "<pre>";
       // echo htmlentities($response);
      //  exit;
    $this->loging("billavennue_balance",json_encode($parameters),$buffer,$Wallet,"Admin");
    return $Wallet;
    
  }
  
  public function dblog($user_id,$service_no,$customer_mobile,$billerId,$url,$request,$postdata,$response)
  {
    error_reporting(-1);
    ini_set('display_errors',1);
    $this->db->db_debug = TRUE;
    $add_date = $this->common->getDate();
    $ipaddress = $this->common->getRealIpAddr();
      $this->db->query("insert into bbps_log(user_id,add_date,ipaddress,url,request,postdata,response,service_no,customer_mobile,billerId)
                          values(?,?,?,?,?,?,?,?,?,?)",
                          array($user_id,$add_date,$ipaddress,$url,$request,$postdata,$response,$service_no,$customer_mobile,$billerId));
  }
  public function getbillFetch($billerId,$customerMobile,$service_no,$option1,$option2,$userinfo)
  {
   // echo "here";exit;
    //error_reporting(E_ALL);
    //ini_set("display_errors",1);
    //$this->db->db_debug = TRUE;
    $user_id = $userinfo->row(0)->user_id;
      $plainText = '<?xml version="1.0" encoding="UTF-8"?>
                        <billFetchRequest>
                            <agentId>CC01CC57AGT000000638</agentId>
                            <agentDeviceInfo>
                                <ip>'.$this->common->getRealIpAddr().'</ip>
                                <initChannel>AGT</initChannel>
                                <mac>01-23-45-67-89-ab</mac>
                            </agentDeviceInfo>
                            <customerInfo>
                                <customerMobile>'.$customerMobile.'</customerMobile>
                                <customerEmail />
                                <customerAdhaar />
                                <customerPan />
                            </customerInfo>
                            <billerId>'.trim($billerId).'</billerId>
                            <inputParams>';


                           $rsltbiller_params = $this->db->query("SELECT * FROM billavennue_operators_billerInputParams where billerId = ? order by listing",array($billerId));
                           foreach($rsltbiller_params->result() as $opr_params)
                           {
                              if($opr_params->param == "SERVICENO")
                              {
                                $plainText.='     
                        <input>
                                            <paramName>'.$opr_params->paramName.'</paramName>
                                            <paramValue>'.$service_no.'</paramValue>
                                        </input>';  
                              }
                              else if($opr_params->param == "OPTION1")
                              {
                                $plainText.='     
                        <input>
                                            <paramName>'.$opr_params->paramName.'</paramName>
                                            <paramValue>'.$option1.'</paramValue>
                                        </input>';  
                              }
                              else if($opr_params->param == "MOBILE")
                              {
                                $plainText.='     
                        <input>
                                            <paramName>'.$opr_params->paramName.'</paramName>
                                            <paramValue>'.$customerMobile.'</paramValue>
                                        </input>';  
                              }
                
                           }

                        
                                
                            $plainText.='</inputParams>
                        </billFetchRequest>';
        //echo htmlentities($plainText) ;exit;                
        $key = $this->getKey();
        $encrypt_xml_data = $this->encrypt($plainText, $key);
        
        $data['accessCode'] =$this->getAccessCode();
        $requestId = $this->generateRandomString();
        $data['requestId'] = $requestId;
        $data['encRequest'] = $encrypt_xml_data;
        $data['ver'] = $this->getVersion();
        $data['instituteId'] = $this->getInstituteId();
        
        $parameters = http_build_query($data);
        
        $url = "https://api.billavenue.com/billpay/extBillCntrl/billFetchRequest/xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);




//echo $plainText."<hr>";

//echo "Request Id :: ".$data['requestId'];
//echo "<hr>";


       // echo $result . "////////////////////";
        $response = $this->decrypt($result, $key);
       // echo $response;exit;
$this->dblog($user_id,$service_no,$customerMobile,$billerId,$url,$plainText,json_encode($data),$response);
//loging($methiod,$request,$response,$json_resp,$username)
$this->loging("billavennue_billfetch",json_encode($data),$plainText,$response,"","Admin");



$xml_biller_response = $this->get_string_between($response,"<billerResponse>","</billerResponse>");


//echo  $response;exit;       
        $xmlresp = ((array)simplexml_load_string($response));
       // print_r($xmlresp);exit;
/*
Array ( [responseCode] => 001 [errorInfo] => SimpleXMLElement Object ( [error] => SimpleXMLElement Object ( [errorCode] => E135 [errorMessage] => Mandatory Input Parameter Not Present or mismatch ) ) )


Array ( [responseCode] => 001 [errorInfo] => SimpleXMLElement Object ( [error] => SimpleXMLElement Object ( [errorCode] => BFR004 [errorMessage] => Payment received for the billing period - no bill due ) ) )



{"statuscode":"TXN","status":"Transaction Successful","data":{"dueamount":"122.00","duedate":"16-10-2019","customername":"SAJID BEGAM","billnumber":"201910721900935721","billdate":"01-01-0001","billperiod":"NA","billdetails":[],"customerparamsdetails":[{"Name":"Consumer Number","Value":"721900935721"}],"additionaldetails":[],"reference_id":1226061}}

{"statuscode":"ERR","status":"Unable to get bill details from biller","data":""}



<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<billFetchResponse>
<responseCode>000</responseCode>
<inputParams>
<input>
  <paramName>Loan Account Number</paramName>
  <paramValue>95HRCDFL182029</paramValue>
</input>
</inputParams>
<billerResponse>
    <billAmount>169000</billAmount>
    <customerName>RINKU KAUR</customerName>
</billerResponse>
<additionalInfo>
  <info>
    <infoName>Installment Overdue</infoName>
    <infoValue>332000</infoValue>
  </info>
  <info>
  <infoName>Penal Overdue</infoName>
  <infoValue>0</infoValue></info>
</additionalInfo>
</billFetchResponse>
*/


        if(isset($xmlresp["responseCode"]))
        {
          $responseCode = $xmlresp["responseCode"];
          if(trim($responseCode) == "000")
          {
            
            $billAmount = "0";
            $billDate = "";
            $billNumber = "";
            $billPeriod = "";
            $customerName = "";
            $dueDate = "";


            if(isset($xmlresp["billerResponse"]))
            {
            
              $billerResponse = (array)$xmlresp["billerResponse"];
              if(isset($billerResponse["billAmount"]))
              {
                  $billAmount = $billerResponse["billAmount"];
              }
              if(isset($billerResponse["billDate"]))
              {
                  $billDate = $billerResponse["billDate"];
              }
              if(isset($billerResponse["billNumber"]))
              {
                  $billNumber = $billerResponse["billNumber"];
              }
              if(isset($billerResponse["billPeriod"]))
              {
                  $billPeriod = $billerResponse["billPeriod"];
              }
              if(isset($billerResponse["customerName"]))
              {
                  $customerName = $billerResponse["customerName"];
              }
              if(isset($billerResponse["dueDate"]))
              {
                  $dueDate = $billerResponse["dueDate"];
              }
            }
            

            $add_date = $this->common->getDate();
            $ipaddress = $this->common->getRealIpAddr();
            $customer_mobile = $customerMobile;
            $user_id = $userinfo->row(0)->user_id;
            $company_id = 0;
            $response_message = "BILL FETCH SUCCESSFUL";
            
            $billfetch_insertion = $this->db->query("insert into tblbillcheck(add_date,ipaddress,service_no,option1,option2,customer_mobile,user_id,company_id,billerId,customer_name,billAmount,billDate,billNumber,billPeriod,dueDate,responseCode,response_message,RefId,billerResponse) 
              values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
              array($add_date,$ipaddress,$service_no,$option1,$option2,$customer_mobile,$user_id,$company_id,$billerId,$customerName,($billAmount/100),$billDate,$billNumber,$billPeriod,$dueDate,$responseCode,$response_message,$requestId,$xml_biller_response));
            $insert_id = $this->db->insert_id();



            if(isset($xmlresp["additionalInfo"]))
            {
              $additionalInfo = (array)$xmlresp["additionalInfo"];
              $info = $additionalInfo["info"];
              if(isset($info->infoName))
              {
              $infoName =  $info->infoName;
                  $infoValue =  $info->infoValue;
                  $this->db->query("insert into tblbillcheck_additionalInfo(billcheck_id,infoName,infoValue) values(?,?,?)",array($insert_id,$infoName,$infoValue));
              }
              else
              {
                foreach($info as $info_row)
                {
                  $infoName =  $info_row->infoName;
                  $infoValue =  $info_row->infoValue;


                  $this->db->query("insert into tblbillcheck_additionalInfo(billcheck_id,infoName,infoValue) values(?,?,?)",array($insert_id,$infoName,$infoValue));

                }
              }
              
            }











            $resparray = array(
              "statuscode"=>"TXN",
              "status"=>"0",
              "message"=>"BILL FETCH SUCCESSFUL",
              "particulars"=>array(
                      "dueamount"=>($billAmount/100),
                      "duedate"=>$dueDate,
                      "customername"=>$customerName,
                      "billnumber"=>$billNumber,
                      "billdate"=>$billDate,
                      "billperiod"=>$billPeriod,
                      "reference_id"=>$insert_id
                    ),
              "data"=>array(
                      "dueamount"=>($billAmount/100),
                      "duedate"=>$dueDate,
                      "customername"=>$customerName,
                      "billnumber"=>$billNumber,
                      "billdate"=>$billDate,
                      "billperiod"=>$billPeriod,
                      "reference_id"=>$insert_id,
                      "billdetails"=>array(array("reference_id"=>$insert_id,"Name"=>"0","Value"=>"0")),
                      "customerparamsdetails"=>
                      array(array(
                        "Name"=>"0",
                        "Value"=>"0"
                      )),
                    ),
              "timestamp"=>$this->common->getDate(),
              "ipay_uuid"=>$insert_id,
              "orderid"=>"",
              "environment"=>"PRODUCTION",
              "message"=>"Transaction Successful"
            );

            echo json_encode($resparray);exit;
          }
          else if(trim($responseCode) == "001")
          {
            $errorInfo = $xmlresp["errorInfo"];
            $error = ((array)$errorInfo->error);
            $errorCode = $error["errorCode"];
            $errorMessage = $error["errorMessage"];

            $resparray = array(
              "statuscode"=>"ERR",
              "status"=>1,
              "message"=>$errorMessage
            );
            echo json_encode($resparray);exit;

          }
        }

       //print_r($xmlresp);exit;
       // echo "<pre>";
       // echo htmlentities($response);
      //  exit;
    $this->loging("billavennue_billfetch",json_encode($parameters),$buffer,$Wallet,"Admin");
    return $Wallet;
    
  }




  ///// bill validation api for quick pay
  ///// must call bill validation api for operators for which bill fetch api not available
  public function getbillvalidation($billerId,$customerMobile,$service_no,$option1,$option2,$userinfo)
  {
   // echo "here";exit;
    //error_reporting(E_ALL);
    //ini_set("display_errors",1);
    //$this->db->db_debug = TRUE;
    $user_id = $userinfo->row(0)->user_id;
      $plainText = '<?xml version="1.0" encoding="UTF-8"?>
                        <billValidationRequest>
                            <agentId>CC01CC57AGT000000638</agentId>
                            <billerId>'.trim($billerId).'</billerId>
                            <agentDeviceInfo>
                                <ip>'.$this->common->getRealIpAddr().'</ip>
                                <initChannel>AGT</initChannel>
                                <mac>01-23-45-67-89-ab</mac>
                            </agentDeviceInfo>
                            <customerInfo>
                                <customerMobile>'.$customerMobile.'</customerMobile>
                                <customerEmail />
                                <customerAdhaar />
                                <customerPan />
                            </customerInfo>
                            <inputParams>';


                           $rsltbiller_params = $this->db->query("SELECT * FROM billavennue_operators_billerInputParams where billerId = ? order by listing",array($billerId));
                           foreach($rsltbiller_params->result() as $opr_params)
                           {
                              if($opr_params->param == "SERVICENO")
                              {
                                $plainText.='     
                        <input>
                                            <paramName>'.$opr_params->paramName.'</paramName>
                                            <paramValue>'.$service_no.'</paramValue>
                                        </input>';  
                              }
                              else if($opr_params->param == "OPTION1")
                              {
                                $plainText.='     
                        <input>
                                            <paramName>'.$opr_params->paramName.'</paramName>
                                            <paramValue>'.$option1.'</paramValue>
                                        </input>';  
                              }
                              else if($opr_params->param == "MOBILE")
                              {
                                $plainText.='     
                        <input>
                                            <paramName>'.$opr_params->paramName.'</paramName>
                                            <paramValue>'.$customerMobile.'</paramValue>
                                        </input>';  
                              }
                
                           }

                        
                                
                            $plainText.='</inputParams>
                        </billValidationRequest>';
        //echo htmlentities($plainText) ;exit;                
        $key = $this->getKey();
        $encrypt_xml_data = $this->encrypt($plainText, $key);
        
        $data['accessCode'] =$this->getAccessCode();
        $requestId = $this->generateRandomString();
        $data['requestId'] = $requestId;
        $data['encRequest'] = $encrypt_xml_data;
        $data['ver'] = $this->getVersion();
        $data['instituteId'] = $this->getInstituteId();
        
        $parameters = http_build_query($data);
        
        $url = "https://api.billavenue.com/billpay/extBillCntrl/billValidateRequest/xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);




//echo $plainText."<hr>";

//echo "Request Id :: ".$data['requestId'];
//echo "<hr>";


        echo $result . "////////////////////";exit;
        $response = $this->decrypt($result, $key);
        echo $response;exit;
$this->dblog($user_id,$service_no,$customerMobile,$billerId,$url,$plainText,json_encode($data),$response);
//loging($methiod,$request,$response,$json_resp,$username)
$this->loging("billavennue_billfetch",json_encode($data),$plainText,$response,"","Admin");



$xml_biller_response = $this->get_string_between($response,"<billerResponse>","</billerResponse>");


//echo  $response;exit;       
        $xmlresp = ((array)simplexml_load_string($response));
       // print_r($xmlresp);exit;
/*
Array ( [responseCode] => 001 [errorInfo] => SimpleXMLElement Object ( [error] => SimpleXMLElement Object ( [errorCode] => E135 [errorMessage] => Mandatory Input Parameter Not Present or mismatch ) ) )


Array ( [responseCode] => 001 [errorInfo] => SimpleXMLElement Object ( [error] => SimpleXMLElement Object ( [errorCode] => BFR004 [errorMessage] => Payment received for the billing period - no bill due ) ) )



{"statuscode":"TXN","status":"Transaction Successful","data":{"dueamount":"122.00","duedate":"16-10-2019","customername":"SAJID BEGAM","billnumber":"201910721900935721","billdate":"01-01-0001","billperiod":"NA","billdetails":[],"customerparamsdetails":[{"Name":"Consumer Number","Value":"721900935721"}],"additionaldetails":[],"reference_id":1226061}}

{"statuscode":"ERR","status":"Unable to get bill details from biller","data":""}



<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<billFetchResponse>
<responseCode>000</responseCode>
<inputParams>
<input>
  <paramName>Loan Account Number</paramName>
  <paramValue>95HRCDFL182029</paramValue>
</input>
</inputParams>
<billerResponse>
    <billAmount>169000</billAmount>
    <customerName>RINKU KAUR</customerName>
</billerResponse>
<additionalInfo>
  <info>
    <infoName>Installment Overdue</infoName>
    <infoValue>332000</infoValue>
  </info>
  <info>
  <infoName>Penal Overdue</infoName>
  <infoValue>0</infoValue></info>
</additionalInfo>
</billFetchResponse>
*/


        if(isset($xmlresp["responseCode"]))
        {
          $responseCode = $xmlresp["responseCode"];
          if(trim($responseCode) == "000")
          {
            
            $billAmount = "0";
            $billDate = "";
            $billNumber = "";
            $billPeriod = "";
            $customerName = "";
            $dueDate = "";


            if(isset($xmlresp["billerResponse"]))
            {
            
              $billerResponse = (array)$xmlresp["billerResponse"];
              if(isset($billerResponse["billAmount"]))
              {
                  $billAmount = $billerResponse["billAmount"];
              }
              if(isset($billerResponse["billDate"]))
              {
                  $billDate = $billerResponse["billDate"];
              }
              if(isset($billerResponse["billNumber"]))
              {
                  $billNumber = $billerResponse["billNumber"];
              }
              if(isset($billerResponse["billPeriod"]))
              {
                  $billPeriod = $billerResponse["billPeriod"];
              }
              if(isset($billerResponse["customerName"]))
              {
                  $customerName = $billerResponse["customerName"];
              }
              if(isset($billerResponse["dueDate"]))
              {
                  $dueDate = $billerResponse["dueDate"];
              }
            }
            

            $add_date = $this->common->getDate();
            $ipaddress = $this->common->getRealIpAddr();
            $customer_mobile = $customerMobile;
            $user_id = $userinfo->row(0)->user_id;
            $company_id = 0;
            $response_message = "BILL FETCH SUCCESSFUL";
            
            $billfetch_insertion = $this->db->query("insert into tblbillcheck(add_date,ipaddress,service_no,option1,option2,customer_mobile,user_id,company_id,billerId,customer_name,billAmount,billDate,billNumber,billPeriod,dueDate,responseCode,response_message,RefId,billerResponse) 
              values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
              array($add_date,$ipaddress,$service_no,$option1,$option2,$customer_mobile,$user_id,$company_id,$billerId,$customerName,($billAmount/100),$billDate,$billNumber,$billPeriod,$dueDate,$responseCode,$response_message,$requestId,$xml_biller_response));
            $insert_id = $this->db->insert_id();



            if(isset($xmlresp["additionalInfo"]))
            {
              $additionalInfo = (array)$xmlresp["additionalInfo"];
              $info = $additionalInfo["info"];
              if(isset($info->infoName))
              {
              $infoName =  $info->infoName;
                  $infoValue =  $info->infoValue;
                  $this->db->query("insert into tblbillcheck_additionalInfo(billcheck_id,infoName,infoValue) values(?,?,?)",array($insert_id,$infoName,$infoValue));
              }
              else
              {
                foreach($info as $info_row)
                {
                  $infoName =  $info_row->infoName;
                  $infoValue =  $info_row->infoValue;


                  $this->db->query("insert into tblbillcheck_additionalInfo(billcheck_id,infoName,infoValue) values(?,?,?)",array($insert_id,$infoName,$infoValue));

                }
              }
              
            }











            $resparray = array(
              "statuscode"=>"TXN",
              "status"=>"0",
              "message"=>"BILL FETCH SUCCESSFUL",
              "particulars"=>array(
                      "dueamount"=>($billAmount/100),
                      "duedate"=>$dueDate,
                      "customername"=>$customerName,
                      "billnumber"=>$billNumber,
                      "billdate"=>$billDate,
                      "billperiod"=>$billPeriod,
                      "reference_id"=>$insert_id
                    ),
              "data"=>array(
                      "dueamount"=>($billAmount/100),
                      "duedate"=>$dueDate,
                      "customername"=>$customerName,
                      "billnumber"=>$billNumber,
                      "billdate"=>$billDate,
                      "billperiod"=>$billPeriod,
                      "reference_id"=>$insert_id,
                      "billdetails"=>array(array("reference_id"=>$insert_id,"Name"=>"0","Value"=>"0")),
                      "customerparamsdetails"=>
                      array(array(
                        "Name"=>"0",
                        "Value"=>"0"
                      )),
                    ),
              "timestamp"=>$this->common->getDate(),
              "ipay_uuid"=>$insert_id,
              "orderid"=>"",
              "environment"=>"PRODUCTION",
              "message"=>"Transaction Successful"
            );

            echo json_encode($resparray);exit;
          }
          else if(trim($responseCode) == "001")
          {
            $errorInfo = $xmlresp["errorInfo"];
            $error = ((array)$errorInfo->error);
            $errorCode = $error["errorCode"];
            $errorMessage = $error["errorMessage"];

            $resparray = array(
              "statuscode"=>"ERR",
              "status"=>1,
              "message"=>$errorMessage
            );
            echo json_encode($resparray);exit;

          }
        }

       //print_r($xmlresp);exit;
       // echo "<pre>";
       // echo htmlentities($response);
      //  exit;
    $this->loging("billavennue_billfetch",json_encode($parameters),$buffer,$Wallet,"Admin");
    return $Wallet;
    
  }


  
  public function bill_checkduplicate($user_id,$service_no,$amount)
  {
    //echo $user_id."   ".$service_no."   ".$amount;exit;
    $add_date = $this->common->getDate();
    $df = date_format(date_create($add_date),"Y-m-d H:i");
    $ip = $this->common->getRealIpAddr();
    $rslt = $this->db->query("insert into locking_bill (user_id,service_no,amount,datetime) values(?,?,?,?)",array($user_id,$service_no,$amount,$df));
      if($rslt == "" or $rslt == NULL)
      {
      return false;
      }
      else
      {
        return true;
      }
  }
  public function billpay($userinfo,$billerId,$Amount,$Mobile,$CustomerMobile,$remark,$RefId,$option1,$option2="",$option3="",$done_by = "WEB")
  {
    $url=""; 
    $buffer = "";
    $json_resp = "";
     //error_reporting(-1);
    //ini_set('display_errors', 1);
    //$this->db->db_debug = TRUE;
        $user_id = $userinfo->row(0)->user_id;
          if(true)
          {
           
              $rsltcheck = $this->db->query("SELECT Id FROM `tblbills`  where service_no = ? and user_id = ? and status != 'Failure' and Date(add_date) = ?
ORDER BY `tblbills`.`Id`  DESC",array($Mobile,$userinfo->row(0)->user_id,$this->common->getMySqlDate()));
              if(false)
                //if($rsltcheck->num_rows() == 1)
                {
                    $resp_arr = array(
                "message"=>"Duplicate Request Found.",
                "status"=>1,
                "statuscode"=>"ERR",
              );
              $json_resp =  json_encode($resp_arr);
                }
                else
                {
                  
                    $Amount = intval($Amount);
                $ipaddress = $this->common->getRealIpAddr();
                $payment_mode = "CASH";
                $payment_channel = "AGT";
                
                
                $url= '';
                $buffer = '';
                if($userinfo != NULL)
                {
                    
                  if($userinfo->num_rows() == 1)
                  {
                    
                    $user_id = $userinfo->row(0)->user_id;
                    $usertype_name = $userinfo->row(0)->usertype_name;
                    $user_status = $userinfo->row(0)->status;
                    if($usertype_name == "Agent" or $usertype_name == "APIUSER")
                    {
                      if($user_status == '1')
                      {
                        
                        /*
                        
                {"statuscode":"TXN","status":"Transaction Successful","data":{"dueamount":"140.00","duedate":"04-02-2019","customername":"NISHAT","billnumber":"055440619012212","billdate":"22-01-2019","billperiod":"NA","billdetails":[],"customerparamsdetails":[{"Name":"CA Number","Value":"103761766"}],"additionaldetails":[],"reference_id":46731}}
                */
                        $crntBalance = $this->Common_methods->getAgentBalance($user_id);
                        //f($this->bill_checkduplicate($userinfo->row(0)->user_id,$Mobile,$Amount) == false)
                        if(false)
                        {
                            $resp_arr = array(
                              "message"=>"Please Try Later",
                              "status"=>1,
                              "statuscode"=>"ERR",
                            );
                        $json_resp =  json_encode($resp_arr);
                          $this->loging("RECHARGE","","",$json_resp,$userinfo->row(0)->username);
                          return $json_resp;   
                        }
                        
                        else if(trim($crntBalance) >= trim($Amount))
                        {

                          $quickpay = "N";
                          $billerInfo = $this->db->query("select * from billavennue_operators where billerId = ?",array($billerId));
                          if($billerInfo->num_rows() == 1)
                          {
                            $billerFetchRequiremet = $billerInfo->row(0)->billerFetchRequiremet;
                            if($billerFetchRequiremet == "NOT_SUPPORTED")
                            {
                              $quickpay = "Y";
                            }
                          }
                            $dueamount = "";
                            $duedate = "";
                            $billnumber = "";
                            $billdate = "";
                            $billperiod = "";
                            $custname = "";
                            $billerResponse_xml = "";
                          $billfetch_insertion = $this->db->query("select billerResponse,RefId,Id,add_date,ipaddress,service_no,option1,option2,customer_mobile,user_id,company_id,billerId,customer_name,billAmount,billDate,billNumber,billPeriod,dueDate,responseCode,response_message from tblbillcheck where Id = ? ",array($RefId));

                          if($billfetch_insertion->num_rows() == 1)
                          {
                            $custname = $billfetch_insertion->row(0)->customer_name;

                            $dueamount = $billfetch_insertion->row(0)->billAmount;
                            $duedate = $billfetch_insertion->row(0)->dueDate;
                            $billnumber = $billfetch_insertion->row(0)->billNumber;
                            $billdate = $billfetch_insertion->row(0)->billDate;
                            $billperiod = $billfetch_insertion->row(0)->billPeriod;
                            $insta_ref = $billfetch_insertion->row(0)->RefId;
                            $billerResponse_xml = $billfetch_insertion->row(0)->billerResponse;
                          }
                          
                          $insert_rslt = $this->db->query("insert into tblbills(add_date,ipaddress,user_id,service_no,customer_mobile,company_id,bill_amount,paymentmode,payment_channel,status,customer_name,dueamount,duedate,billnumber,billdate,billperiod,option1,done_by)
                          values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                          array($this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$billerId,$Amount,$payment_mode,$payment_channel,"Pending",$custname,$dueamount,$duedate,$billnumber,$billdate,$billperiod,$option1,$done_by));
                          if($insert_rslt == true)
                          {
                            
                            $insert_id = $this->db->insert_id();
                            
                            $transaction_type = "BILL";
                            
                            
                                          $Charge_Amount =0;
                            
                          
                            $dr_amount = $Amount + $Charge_Amount;
                            $Description = "Service No.  ".$Mobile." Bill Amount : ".$Amount;
                            $sub_txn_type = "BILL";
                            $remark = "Bill PAYMENT";
                            $Charge_Amount = $Charge_Amount;
                            $paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                            if($paymentdebited == true)
                            {
                              
                                $dohold = 'no';
                          $rsltcommon = $this->db->query("select * from common where param = 'BILLHOLD'");
                          if($rsltcommon->num_rows() == 1)
                          {
                              $is_hold = $rsltcommon->row(0)->value;
                            if($is_hold == 1)
                            {
                                $dohold = 'yes';
                            }
                          }
                          
                          //if($dohold == 'yes')
                          if(false)
                        {
                          

                          $resp_arr = array(
                                      "message"=>"Bill Request Submitted Successfully",
                                      "status"=>0,
                                      "statuscode"=>"TUP",
                                      "data"=>array(

                                        "ipay_id"=>"",
                                        "opr_id"=>"",
                                        "status"=>"Pending",
                                        "res_msg"=>"Bill Request Submitted Successfully",
                                      )
                                    );
                          $json_resp =  json_encode($resp_arr); 
                        }
                                else if(true)
                                {

$plainText = '<?xml version="1.0" encoding="UTF-8"?>
<billPaymentRequest>
  <agentId>CC01CC57AGT000000638</agentId>
  <billerAdhoc>false</billerAdhoc>
  <agentDeviceInfo>
        <ip>'.$this->common->getRealIpAddr().'</ip>
        <initChannel>AGT</initChannel>
        <mac>01-23-45-67-89-ab</mac>
    </agentDeviceInfo>
    <customerInfo>
        <customerMobile>'.$CustomerMobile.'</customerMobile>
        <customerEmail />
        <customerAdhaar />
        <customerPan />
    </customerInfo>
  <billerId>'.trim($billerId).'</billerId>
  <inputParams>';
    $rsltbiller_params = $this->db->query("SELECT * FROM billavennue_operators_billerInputParams where billerId = ? order by listing",array($billerId));
       foreach($rsltbiller_params->result() as $opr_params)
       {
          if($opr_params->param == "SERVICENO")
          {
            $plainText.='     
                <input>
                                <paramName>'.$opr_params->paramName.'</paramName>
                                <paramValue>'.$Mobile.'</paramValue>
                            </input>';  
          }
          else if($opr_params->param == "OPTION1")
          {
            $plainText.='     
                <input>
                                <paramName>'.$opr_params->paramName.'</paramName>
                                <paramValue>'.$option1.'</paramValue>
                            </input>';  
          }
          else if($opr_params->param == "MOBILE")
          {
            $plainText.='     
                <input>
                                <paramName>'.$opr_params->paramName.'</paramName>
                                <paramValue>'.$CustomerMobile.'</paramValue>
                            </input>';  
          }
        
       }
  $plainText .= '</inputParams>';
  
  if($billfetch_insertion->num_rows() == 1)
  {
    $plainText .= '<billerResponse>'.$billerResponse_xml.'</billerResponse>';
  /*$plainText .= '<billerResponse>
              <billAmount>'.($billfetch_insertion->row(0)->billAmount*100).'</billAmount>
              <billDate>'.$billfetch_insertion->row(0)->billDate.'</billDate>
              <billNumber>'.$billfetch_insertion->row(0)->billNumber.'</billNumber>
              <billPeriod>'.$billfetch_insertion->row(0)->billPeriod.'</billPeriod>
              <customerName>'.$billfetch_insertion->row(0)->customer_name.'</customerName>
              <dueDate>'.$billfetch_insertion->row(0)->dueDate.'</dueDate>
            </billerResponse>';*/
  }


  $plainText.= '
      <additionalInfo>';
      $additionalInfo_rslt = $this->db->query("select * from tblbillcheck_additionalInfo where billcheck_id = ?",array($RefId));
      if($additionalInfo_rslt->num_rows() >= 1)
      {
        foreach($additionalInfo_rslt->result() as $rwaddinfo)
        {
          $plainText .= '<info>
                  <infoName>'.$rwaddinfo->infoName.'</infoName>
                  <infoValue>'.$rwaddinfo->infoValue.'</infoValue>
                </info>';   
        }
        
      }
        
       
  $plainText.= '</additionalInfo>';
  


  $plainText .='
    <amountInfo>
      <amount>'.($Amount*100).'</amount>
      <currency>356</currency>
      <custConvFee>0</custConvFee>
      <amountTags>
      
      </amountTags>
    </amountInfo>
  ';

$payment_mode = "Cash";
if($billerId == "IDFC00000NATCK")
{
  $payment_mode = "IMPS";
}
  $plainText .= '<paymentMethod>
    <paymentMode>'.$payment_mode.'</paymentMode>
    <quickPay>'.$quickpay.'</quickPay>
    <splitPay>N</splitPay>
  </paymentMethod>
  <paymentInfo>
    <info>
    <infoName>Remarks</infoName>
    <infoValue>Received</infoValue>
    </info>
  </paymentInfo>
</billPaymentRequest>';
                    

$key = $this->getKey();
        $encrypt_xml_data = $this->encrypt($plainText, $key);
        //echo $billfetch_insertion->row(0)->RefId;exit;
        $data['accessCode'] =$this->getAccessCode();
      $req_id = $billfetch_insertion->row(0)->RefId;
      if($req_id =="")
      {
        $req_id = $this->generateRandomString();
        $this->db->query("update tblbills set RefId = ? where Id = ?",array($req_id,$insert_id));
      }
    $data['requestId'] = $req_id;
        
        $data['encRequest'] = $encrypt_xml_data;
        $data['ver'] = $this->getVersion();
        $data['instituteId'] = $this->getInstituteId();
        
        $parameters = http_build_query($data);
        $url = "https://api.billavenue.com/billpay/extBillPayCntrl/billPayRequest/xml";
        $url = "https://api.billavenue.com/billpay/extBillPayCntrl/billPayRequest/xml";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);




//echo $plainText."<hr>";

//echo "Request Id :: ".$data['requestId'];
//echo "<hr>";


       // echo $result . "////////////////////";
        $response = $this->decrypt($result, $key);

        $this->dblog($user_id,$Mobile,$CustomerMobile,$billerId,$url,$plainText,json_encode($data),$response);

        $this->loging("BBPPS",$url." authentication params : ".json_encode($data)."  params : ".$plainText,$result."<------------------>".$response,"",$userinfo->row(0)->username);

/*
<extbillpayresponse>
  <responsecode>000</responsecode>
  <responsereason>Successful</responsereason>
  <txnrefid>CC01ABN45245</txnrefid>
  <approvalrefnumber>AB123456</approvalrefnumber>
  <txnresptype>FORWARD TYPE RESPONSE</txnresptype>
  <inputparams>
    <input>
    <paramname>Loan Account Number</paramname>
    <paramvalue>95HRCDFL182029</paramvalue>
  </inputparams>
  <respamount>169000</respamount>
  <respcustomername>RINKU KAUR</respcustomername>

</extbillpayresponse>


resp 2

<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<ExtBillPayResponse>
  <responseCode>000</responseCode>
  <responseReason>Successful</responseReason>
  <txnRefId>CC01ABT24201</txnRefId>
  <approvalRefNumber>AB123456</approvalRefNumber>
  <txnRespType>FORWARD TYPE RESPONSE</txnRespType>
  <inputParams>
    <input><paramName>Loan Account Number</paramName><paramValue>4160CDFC412943</paramValue></input>
  </inputParams>
  <RespAmount>6400</RespAmount>
  <RespCustomerName>NEHABEN DIPAKBHAI JOSHI</RespCustomerName>
</ExtBillPayResponse>
*/

$responsecode = $this->get_string_between( $response, "responseCode>", "</responseCode>");
$responsereason = $this->get_string_between( $response, "responseReason>", "</responseReason>");
$txnrefid = $this->get_string_between( $response, "txnRefId>", "</txnRefId>");

$approvalrefnumber = $this->get_string_between( $response, "approvalRefNumber>", "</approvalRefNumber>");
//echo $responsecode."   respose : ".$responsereason."    txnid : ".$txnrefid."   aprovalnum : ".$approvalrefnumber;exit;
if($responsecode == "000" and $responsereason == "Successful")
{
  $insert_id = $insert_id;
  $ipay_id = $approvalrefnumber;
  $agent_id = $insert_id;
  $opr_id = $txnrefid;
  
  $trans_amt = "";
  $charged_amt =0.00;
  $opening_bal = "";
  $datetime = "";
  $status = $responsereason;
  $statuscode = "TXN";
  $this->db->query("update tblbills set status = 'Success',ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",
    array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$this->common->getDate(),$status,$statuscode,$status,$insert_id));

  $resp_arr = array(
                "message"=>"SUCCESS",
                "status"=>0,
                "statuscode"=>$statuscode,
                "data"=>array(

                  "ipay_id"=>$ipay_id,
                  "opr_id"=>$opr_id,
                  "status"=>"SUCCESS",
                  "res_msg"=>$responsecode,
                )
              );
  $json_resp =  json_encode($resp_arr); 
  echo $json_resp;exit;
}
else 
{


/*
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<ExtBillPayResponse>
  <responseCode>200</responseCode>
  <responseReason>FAILURE</responseReason>
  <errorInfo>
    <error>
      <errorCode>E701</errorCode>
      <errorMessage>Insufficient balance.</errorMessage>
    </error>
  </errorInfo>
</ExtBillPayResponse>
*/
      if($responsecode == "200" and $responsereason == "FAILURE")
      {

      }
      else
      {
          $resp_arr = array(
               "message"=>$responsereason,
              "status"=>1,
              "statuscode"=>$responsecode,
            );
          $json_resp =  json_encode($resp_arr);
      }


  
}
                              }
                                
                            
                            }
                            else
                            {
                              $resp_arr = array(
                              "message"=>"Payment Error. Please Try Again",
                              "status"=>1,
                              "statuscode"=>"ERR",
                            );
                            $json_resp =  json_encode($resp_arr);
                            }
                          }
                          else
                          {
                            $resp_arr = array(
                                "message"=>"Database Error",
                                "status"=>1,
                                "statuscode"=>"ISB",
                              );
                            $json_resp =  json_encode($resp_arr);
                          }
                        }
                        else
                        {
                          $resp_arr = array(
                              "message"=>"InSufficient Balance 2",
                              "status"=>1,
                              "statuscode"=>"ISB",
                            );
                          $json_resp =  json_encode($resp_arr);
                        }
                        
                      }
                      else
                      {
                        $resp_arr = array(
                              "message"=>"Your Account Deactivated By Admin",
                              "status"=>5,
                              "statuscode"=>"UNK",
                            );
                        $json_resp =  json_encode($resp_arr);
                      }
                        
                    }
                    else
                    {
                      $resp_arr = array(
                              "message"=>"Invalid Access",
                              "status"=>5,
                              "statuscode"=>"UNK",
                            );
                      $json_resp =  json_encode($resp_arr);
                    }
                  }
                  else
                  {
                    $resp_arr = array(
                              "message"=>"Userinfo Missing",
                              "status"=>4,
                              "statuscode"=>"UNK",
                            );
                    $json_resp =  json_encode($resp_arr);
                  }
                  
                }
                else
                {
                  $resp_arr = array(
                              "message"=>"Userinfo Missing",
                              "status"=>4,
                              "statuscode"=>"UNK",
                            );
                  $json_resp =  json_encode($resp_arr);
                  
                }  
                }
            $this->loging("BBPPS",$url." authentication params : ".json_encode($data)."  params : ".$plainText,$result."<------------------>".$response,$json_resp,$userinfo->row(0)->username);
            return $json_resp;   
          }    
      
      
    
  }
  
  public function gethoursbetweentwodates($fromdate,$todate)
  {
     $now_date = strtotime (date ($todate)); // the current date 
    $key_date = strtotime (date ($fromdate));
    $diff = $now_date - $key_date;
    return round(abs($diff) / 60,2);
  }
  


  public function getTransactionChargeInfo($userinfo,$TransactionAmount)
  {
      return 5.00;
  }
  
  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////                  ///////////////////////////////////////////////////
//////////////////////////////////////////    L O G I N G   ////////////////////////////////////////////////////
/////////////////////////////////////////                  /////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
  
  private function loging($methiod,$request,$response,$json_resp,$username)
  {
    
    //echo $methiod." <> ".$request." <> ".$response." <> ".$json_resp." <> ".$username;exit;
    $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
    "username: ".$username.PHP_EOL.
    "Request: ".$request.PHP_EOL.
        "Response: ".$response.PHP_EOL.
    "Downline Response: ".$json_resp.PHP_EOL.
        "Method: ".$methiod.PHP_EOL.
        "-------------------------".PHP_EOL;
    
    
    //echo $log;exit;
    $filename ='inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt';
    if (!file_exists($filename)) 
    {
      file_put_contents($filename, '');
    } 
    
//Save string to log, use FILE_APPEND to append.
    file_put_contents('inlogs/'.$methiod.'log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    
  }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//*************************************** L O G I N G    E N D   H E R E *************************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  
  
  
  
  
  
  
  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// bill payments api
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  public function serviceproviders($userinfo,$spkey)
  {
    if($userinfo != NULL)
    {
      if($userinfo->num_rows() == 1)
      {
        
        $user_id = $userinfo->row(0)->user_id;
        $usertype_name = $userinfo->row(0)->usertype_name;
        $user_status = $userinfo->row(0)->status;
        if($usertype_name == "Agent" or $usertype_name == "APIUSER")
        {
          if($user_status == '1')
          {
              $postparam = '{"token": "'.$this->getToken().'","request": {"mobile": "'.$mobile_no.'"}}';
    
              $headers = array();
              $headers[] = 'Accept: application/json';
              $headers[] = 'Content-Type: application/json';
              
              $url = 'https://www.instantpay.in/ws/api/serviceproviders?token='.$this->getToken().'&spkey='.$spkey.'&format=json';
              $ch = curl_init();
              curl_setopt($ch,CURLOPT_URL,$url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
              curl_setopt($ch, CURLOPT_POST,0);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
              $buffer = curl_exec($ch);
              curl_close($ch);
              
              echo $buffer;exit;
              $json_obj = json_decode($buffer);
            //print_r($json_obj);exit;
              if(isset($json_obj->statuscode) and isset($json_obj->status))
              {
                  $statuscode = $json_obj->statuscode;
                  $status = $json_obj->status;
                  if($statuscode == "RNF")
                  {
                      $resp_arr = array(
                                  "message"=>"Record Not Found",
                                  "status"=>1,
                                  "statuscode"=>"RNF",
                                );
                      $json_resp =  json_encode($resp_arr);
                  }
                  else if($statuscode == "TXN")
                  {
                    $data = $json_obj->data;
                    if(isset($data->remitter) and isset($data->beneficiary))
                    {
                      $remitter = $data->remitter;
                      $beneficiary = $data->beneficiary;
                      
                      
                      if(isset($remitter->name) and isset($remitter->mobile) and isset($remitter->pincode) and isset($remitter->id))
                      {
                        $name = trim((string)$remitter->name);
                        $mobile = trim((string)$remitter->mobile);
                        $pincode = trim((string)$remitter->pincode);
                        $remiterid = trim((string)$remitter->id);
                        $checkremitter = $this->db->query("select * from mt3_remitter_registration where remitter_id = ? and status = 'SUCCESS'",array(trim($remiterid)));
                        if($checkremitter->num_rows() == 0)
                        {
                          $this->db->query("insert into mt3_remitter_registration(user_id,add_date,mobile,name,pincode,status,remitter_id) values(?,?,?,?,?,?,?)",array($user_id,$this->common->getDate(),$mobile_no,$name,$pincode,"SUCCESS",$remiterid));
                        }
                      }
                      
                      
                      
                      $resp_arr = array(
                                "message"=>$status,
                                "status"=>0,
                                "statuscode"=>$statuscode,
                                "remitter"=>$remitter,
                                "beneficiary"=>$beneficiary
                              );
                      $json_resp =  json_encode($resp_arr);
                    }
                    else if(isset($data->remitter))
                    {
                      $remitter = $data->remitter;
                      $resp_arr = array(
                                "message"=>$status,
                                "status"=>0,
                                "statuscode"=>$statuscode,
                                "remitter"=>$remitter,
                                "beneficiary"=>""
                              );
                      $json_resp =  json_encode($resp_arr);
                    }
                    else
                    {
                        $resp_arr = array(
                                  "message"=>"Unknown Response",
                                  "status"=>2,
                                  "statuscode"=>"UNK",
                                );
                      $json_resp =  json_encode($resp_arr);
                    }
                    
                  }
                  else
                  {
                    $resp_arr = array(
                                  "message"=>$status,
                                  "status"=>1,
                                  "statuscode"=>$statuscode,
                                );
                      $json_resp =  json_encode($resp_arr);
                  }

              }
              else
              {
                $resp_arr = array(
                    "message"=>"Internal Server Error, Please Try Later",
                    "status"=>10,
                    "statuscode"=>"UNK",
                  );
                $json_resp =  json_encode($resp_arr);
              }
          }
          else
          {
            $resp_arr = array(
                  "message"=>"Your Account Deactivated By Admin",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
            $json_resp =  json_encode($resp_arr);
          }
            
        }
        else
        {
          $resp_arr = array(
                  "message"=>"Invalid Access",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
          $json_resp =  json_encode($resp_arr);
        }
      }
      else
      {
        $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
        $json_resp =  json_encode($resp_arr);
      }
      
    }
    else
    {
      $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
      $json_resp =  json_encode($resp_arr);
      
    }
    $this->loging("remitter_details",$postparam,$buffer,$json_resp,$userinfo->row(0)->username);
    return $json_resp;
    
  }
  public function recharge_transaction($userinfo,$spkey,$company_id,$Amount,$Mobile,$CustomerMobile,$remark,$option1,$option2="",$option3="",$payment_mode = "CASH",$payment_channel = "AGT",$custname="",$particulars = false)
  {
    $Amount = intval($Amount);
    $ipaddress = $this->common->getRealIpAddr();
    $payment_mode = "CASH";
    $payment_channel = "AGT";
    
    if($spkey == "TPE")
    {
      $payment_mode = "";
      $payment_channel = "";
    }
    $url= '';
    $buffer = '';
    if($userinfo != NULL)
    {
      if($userinfo->num_rows() == 1)
      {
        
        $user_id = $userinfo->row(0)->user_id;
        $usertype_name = $userinfo->row(0)->usertype_name;
        $user_status = $userinfo->row(0)->status;
        if($usertype_name == "Agent" or $usertype_name == "APIUSER")
        {
          if($user_status == '1')
          {
            $crntBalance = $this->Ew2->getAgentBalance($user_id);
            if(floatval($crntBalance) >= floatval($Amount))
            {
                $dueamount = "";
                $duedate = "";
                $billnumber = "";
                $billdate = "";
                $billperiod = "";
              if($particulars != false)
              {
                $custname = $particulars->customername;
                $dueamount = $particulars->dueamount;
                $duedate = $particulars->duedate;
                $billnumber = $particulars->billnumber;
                $billdate = $particulars->billdate;
                $billperiod = $particulars->billperiod;
              }
              
              $insert_rslt = $this->db->query("insert into tblbills(add_date,ipaddress,user_id,service_no,customer_mobile,company_id,bill_amount,paymentmode,payment_channel,status,customer_name,dueamount,duedate,billnumber,billdate,billperiod,option1) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id,$Amount,$payment_mode,$payment_channel,"Pending",$custname,$dueamount,$duedate,$billnumber,$billdate,$billperiod,$option1));
              if($insert_rslt == true)
              {
                $insert_id = $this->db->insert_id();
                $transaction_type = "BILL";
                $dr_amount = $Amount;
                $Description = "Service No.  ".$Mobile." Bill Amount : ".$Amount;
                $sub_txn_type = "BILL";
                $remark = "Bill PAYMENT";
                $Charge_Amount = 0.00;
                $paymentdebited = $this->PAYMENT_DEBIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                if($paymentdebited == true)
                {
                  $headers = array();
                  $headers[] = 'Accept: application/json';
                  $headers[] = 'Content-Type: application/json';

                  $url = 'https://www.instantpay.in/ws/api/transaction?format=json&token='.$this->getToken().'&spkey='.$spkey.'&agentid='.$insert_id.'&amount='.$Amount.'&account='.$Mobile.'&optional1='.$option1.'&optional2='.$option2.'&optional3='.$option3.'&optional4=&optional5=&optional6=&optional7=&optional8='.rawurlencode($remark).'&optional9=23.6036,72.9639|383001&outletid='.$this->getOutletId().'&endpointip='.$ipaddress.'&customermobile='.$CustomerMobile.'&paymentmode='.$payment_mode.'&paymentchannel='.$payment_channel;

                  $ch = curl_init();
                  curl_setopt($ch,CURLOPT_URL,$url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                  curl_setopt($ch, CURLOPT_POST,0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                  $buffer = curl_exec($ch);
                  curl_close($ch);
                  /*
                  {"ipay_id":"1180518152856NUHHQ","agent_id":"1235","opr_id":"1805181529230004","account_no":"8238232303","sp_key":"VFP","trans_amt":10,"charged_amt":9.93,"opening_bal":"18066.10","datetime":"2018-05-18 15:29:14","status":"SUCCESS","res_code":"TXN","res_msg":"Transaction Successful"}
                  */
                  $json_obj = json_decode($buffer);
                  if(isset($json_obj->ipay_errorcode) and isset($json_obj->ipay_errordesc))
                  {
                      $ipay_errorcode = $json_obj->ipay_errorcode;
                      $ipay_errordesc = $json_obj->ipay_errordesc;
                      if($ipay_errorcode == "DTX")
                      {
                        $this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                        
                        $this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$ipay_errorcode,$ipay_errordesc,$insert_id));
                        
                          $resp_arr = array(
                                      "message"=>"Duplicate Transaction",
                                      "status"=>1,
                                      "statuscode"=>"DTX",
                                    );
                          $json_resp =  json_encode($resp_arr);
                      }
                      if($ipay_errorcode == "SPD")
                      {
                        $this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                        
                        $this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$ipay_errorcode,$ipay_errordesc,$insert_id));
                          $resp_arr = array(
                                      "message"=>"Service Provider Downtime",
                                      "status"=>1,
                                      "statuscode"=>"DTX",
                                    );
                          $json_resp =  json_encode($resp_arr);
                      }

                      else
                      {
                        $this->PAYMENT_CREDIT_ENTRY($user_id,$insert_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$Charge_Amount,$userinfo);
                        
                        $this->db->query("update tblbills set status = 'Failure',resp_status=?,res_code=?,res_msg=? where Id = ?",array("FAILURE",$ipay_errorcode,$ipay_errordesc,$insert_id));
                        
                        $resp_arr = array(
                                      "message"=>$ipay_errordesc,
                                      "status"=>1,
                                      "statuscode"=>$ipay_errorcode,
                                    );
                          $json_resp =  json_encode($resp_arr);
                      }

                  }
                  else if(isset($json_obj->ipay_id) and isset($json_obj->agent_id) and isset($json_obj->opr_id) and isset($json_obj->status) and isset($json_obj->res_msg))
                  {
                      $ipay_id = $json_obj->ipay_id;
                      $agent_id = $json_obj->agent_id;
                      $opr_id = $json_obj->opr_id;
                      $status = $json_obj->status;
                      $res_msg = $json_obj->res_msg;
                      $res_code = $json_obj->res_code;
                    
                      $trans_amt = "";
                      $charged_amt = "";
                      $opening_bal = "";
                      $datetime = "";
                      
                    if($status == "SUCCESS")
                    {
                      $this->db->query("update tblbills set status = 'Success',ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$status,$res_code,$res_msg,$insert_id));
                      
                    }
                    else
                    {
                      $this->db->query("update tblbills set ipay_id = ?,opr_id=?,trans_amt=?,charged_amt=?,opening_bal=?,datetime=?,resp_status=?,res_code=?,res_msg=? where Id = ?",array($ipay_id,$opr_id,$trans_amt,$charged_amt,$opening_bal,$datetime,$status,$res_code,$res_msg,$insert_id));
                      
                    }
                    
                      
                      $resp_arr = array(
                                  "message"=>$res_msg,
                                  "status"=>0,
                                  "statuscode"=>$status,
                                  "data"=>array(

                                    "ipay_id"=>$ipay_id,
                                    "opr_id"=>$opr_id,
                                    "status"=>$status,
                                    "res_msg"=>$res_msg,
                                  )
                                );
                      $json_resp =  json_encode($resp_arr);


                  }
                  else 
                  {
                    $resp_arr = array(
                        "message"=>"Some Error Occure",
                        "status"=>10,
                        "statuscode"=>"UNK",
                      );
                    $json_resp =  json_encode($resp_arr);
                  }
                }
                else
                {
                  $resp_arr = array(
                  "message"=>"Payment Error. Please Try Again",
                  "status"=>1,
                  "statuscode"=>"ERR",
                );
                $json_resp =  json_encode($resp_arr);
                }
              }
            }
            else
            {
              $resp_arr = array(
                  "message"=>"InSufficient Balance",
                  "status"=>1,
                  "statuscode"=>"ISB",
                );
              $json_resp =  json_encode($resp_arr);
            }
            
          }
          else
          {
            $resp_arr = array(
                  "message"=>"Your Account Deactivated By Admin",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
            $json_resp =  json_encode($resp_arr);
          }
            
        }
        else
        {
          $resp_arr = array(
                  "message"=>"Invalid Access",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
          $json_resp =  json_encode($resp_arr);
        }
      }
      else
      {
        $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
        $json_resp =  json_encode($resp_arr);
      }
      
    }
    else
    {
      $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
      $json_resp =  json_encode($resp_arr);
      
    }
    $this->loging("RECHARGE",$url,$buffer,$json_resp,$userinfo->row(0)->username);
    return $json_resp;
    
  }
  
  
  public function recharge_transaction_validate($userinfo,$spkey,$company_id,$Amount,$Mobile,$CustomerMobile,$option1 = "")
  {
    $ipaddress = $this->common->getRealIpAddr();
    $payment_mode = "CASH";
    $payment_channel = "AGT";
    $url= '';
    $buffer = '';
    if($userinfo != NULL)
    {
      if($userinfo->num_rows() == 1)
      {
        
        $user_id = $userinfo->row(0)->user_id;
        $usertype_name = $userinfo->row(0)->usertype_name;
        $user_status = $userinfo->row(0)->status;
        if($usertype_name == "Agent" or $usertype_name == "APIUSER")
        {
          if($user_status == '1')
          {
            
              $insert_rslt = $this->db->query("insert into tblbillcheck(add_date,ipaddress,user_id,mobile,customer_mobile,company_id) values(?,?,?,?,?,?)",array($this->common->getDate(),$ipaddress,$user_id,$Mobile,$CustomerMobile,$company_id));
              if($insert_rslt == true)
              {
                $insert_id = $this->db->insert_id();
                $transaction_type = "BILL";
                $dr_amount = $Amount;
                $Description = "Service No.  ".$Mobile." Bill Amount : ".$Amount;
                $sub_txn_type = "BILL";
                $remark = "Bill PAYMENT";
                $Charge_Amount = 0.00;
                
                
                  $headers = array();
                  $headers[] = 'Accept: application/json';
                  $headers[] = 'Content-Type: application/json';

                  
                  
                  $url = 'https://www.instantpay.in/ws/api/transaction?format=json&token='.$this->getToken().'&agentid='.$insert_id.'&amount=10&spkey='.$spkey.'&account='.$Mobile.'&mode=VALIDATE&optional1='.$option1.'&optional2=&optional3=&optional4=&optional5=&optional6=&optional7=&optional8=billcheck&optional9=23.6036,72.9639|383001&outletid='.$this->getOutletId().'&endpointip='.$this->common->getRealIpAddr().'&customermobile='.$CustomerMobile.'&paymentmode='.$payment_mode.'&paymentchannel='.$payment_channel;
                  
                  

                  $ch = curl_init();
                  curl_setopt($ch,CURLOPT_URL,$url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                  curl_setopt($ch, CURLOPT_POST,0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                  $buffer = curl_exec($ch);
                  curl_close($ch);
                  /*
                  {"ipay_id":"1180518152856NUHHQ","agent_id":"1235","opr_id":"1805181529230004","account_no":"8238232303","sp_key":"VFP","trans_amt":10,"charged_amt":9.93,"opening_bal":"18066.10","datetime":"2018-05-18 15:29:14","status":"SUCCESS","res_code":"TXN","res_msg":"Transaction Successful"}
                  */
                //echo $buffer;exit;
                  $json_obj = json_decode($buffer);
                //print_r($json_obj);exit;
                  if(isset($json_obj->ipay_errorcode) and isset($json_obj->ipay_errordesc))
                  {
                      $ipay_errorcode = $json_obj->ipay_errorcode;
                      $ipay_errordesc = $json_obj->ipay_errordesc;
                      if($ipay_errorcode == "IRA")
                      {
                        
                        $particulars = $json_obj->particulars;
                        
                        
                        /*if(isset($particulars->dueamount) and isset($particulars->duedate) and isset($particulars->customername) and isset($particulars->billnumber) and isset($particulars->billdate) and isset($particulars->billperiod))
                        {
                          $dueamount = $particulars->dueamount;
                          $duedate = $particulars->duedate;
                          $customername = $particulars->customername;
                          $billnumber = $particulars->billnumber;
                          $billdate = $particulars->billdate;
                          $billperiod = $particulars->billperiod;
                        }*/
                          $resp_arr = array(
                                      "message"=>"Bill Detail Get Successfully",
                                      "status"=>0,
                                      "statuscode"=>$ipay_errorcode,
                                      "particulars" => $particulars,
                                      "ENCRDATA"=>$this->Common_methods->encrypt($buffer)
                                    );
                          $json_resp =  json_encode($resp_arr);
                      }
                      else
                      {
                        
                        
                        $resp_arr = array(
                                      "message"=>$ipay_errordesc,
                                      "status"=>1,
                                      "statuscode"=>$ipay_errorcode,
                                    );
                          $json_resp =  json_encode($resp_arr);
                      }

                  }
                
              }
            
          }
          else
          {
            $resp_arr = array(
                  "message"=>"Your Account Deactivated By Admin",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
            $json_resp =  json_encode($resp_arr);
          }
            
        }
        else
        {
          $resp_arr = array(
                  "message"=>"Invalid Access",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
          $json_resp =  json_encode($resp_arr);
        }
      }
      else
      {
        $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
        $json_resp =  json_encode($resp_arr);
      }
      
    }
    else
    {
      $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
      $json_resp =  json_encode($resp_arr);
      
    }
    $this->loging("RECHARGE",$url,$buffer,$json_resp,$userinfo->row(0)->username);
    return $json_resp;
    
  }
  
  
  
  
  public function recharge_transaction_postpaid($userinfo,$spkey,$company_id,$Amount,$Mobile,$recharge_id)
  {
    $remark = "Bill Payment";
    $ipaddress = $this->common->getRealIpAddr();
    $payment_mode = "CASH";
    $payment_channel = "AGT";
    $url= '';
    $buffer = '';
    if($userinfo != NULL)
    {
      if($userinfo->num_rows() == 1)
      {
        
        $user_id = $userinfo->row(0)->user_id;
        $usertype_name = $userinfo->row(0)->usertype_name;
        $user_status = $userinfo->row(0)->status;
        if($usertype_name == "Agent" or $usertype_name == "APIUSER")
        {
          if($user_status == '1')
          {
            
            $headers = array();
            $headers[] = 'Accept: application/json';
            $headers[] = 'Content-Type: application/json';


            $url = 'https://www.instantpay.in/ws/api/transaction?format=json&token='.$this->getToken().'&spkey='.$spkey.'&agentid='.$recharge_id.'&amount='.$Amount.'&account='.$Mobile.'&customermobile='.$Mobile;

            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST,0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $buffer = curl_exec($ch);
            curl_close($ch);
            /*
            {"ipay_id":"1180518152856NUHHQ","agent_id":"1235","opr_id":"1805181529230004","account_no":"8238232303","sp_key":"VFP","trans_amt":10,"charged_amt":9.93,"opening_bal":"18066.10","datetime":"2018-05-18 15:29:14","status":"SUCCESS","res_code":"TXN","res_msg":"Transaction Successful"}
            */
            $json_obj = json_decode($buffer);
            if(isset($json_obj->ipay_errorcode) and isset($json_obj->ipay_errordesc))
            {
                $ipay_errorcode = $json_obj->ipay_errorcode;
                $ipay_errordesc = $json_obj->ipay_errordesc;
                if($ipay_errorcode == "DTX")
                {
                  $resp_arr = array(
                                "message"=>"Duplicate Transaction",
                                "status"=>1,
                                "statuscode"=>"DTX",
                              );
                    $json_resp =  json_encode($resp_arr);
                }
                if($ipay_errorcode == "SPD")
                {

                    $resp_arr = array(
                                "message"=>"Service Provider Downtime",
                                "status"=>1,
                                "statuscode"=>"DTX",
                              );
                    $json_resp =  json_encode($resp_arr);
                }

                else
                {


                    $resp_arr = array(
                                "message"=>$ipay_errordesc,
                                "status"=>1,
                                "statuscode"=>$ipay_errorcode,
                              );
                    $json_resp =  json_encode($resp_arr);
                }

            }
            else if(isset($json_obj->ipay_id) and isset($json_obj->agent_id) and isset($json_obj->opr_id) and isset($json_obj->status) and isset($json_obj->res_msg))
            {
                $ipay_id = $json_obj->ipay_id;
                $agent_id = $json_obj->agent_id;
                $opr_id = $json_obj->opr_id;
                $status = $json_obj->status;
                $res_msg = $json_obj->res_msg;
                $res_code = $json_obj->res_code;

                $trans_amt = "";
                $charged_amt = "";
                $opening_bal = "";
                $datetime = "";

                $resp_arr = array(
                            "message"=>$res_msg,
                            "status"=>0,
                            "statuscode"=>$status,
                            "data"=>array(
                              "ipay_id"=>$ipay_id,
                              "opr_id"=>$opr_id,
                              "status"=>$status,
                              "res_msg"=>$res_msg,
                            )
                          );
                $json_resp =  json_encode($resp_arr);


            }
            else 
            {
              $resp_arr = array(
                  "message"=>"Some Error Occure",
                  "status"=>10,
                  "statuscode"=>"UNK",
                );
              $json_resp =  json_encode($resp_arr);
            }
                
          }
          else
          {
            $resp_arr = array(
                  "message"=>"Your Account Deactivated By Admin",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
            $json_resp =  json_encode($resp_arr);
          }
            
        }
        else
        {
          $resp_arr = array(
                  "message"=>"Invalid Access",
                  "status"=>5,
                  "statuscode"=>"UNK",
                );
          $json_resp =  json_encode($resp_arr);
        }
      }
      else
      {
        $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
        $json_resp =  json_encode($resp_arr);
      }
      
    }
    else
    {
      $resp_arr = array(
                  "message"=>"Userinfo Missing",
                  "status"=>4,
                  "statuscode"=>"UNK",
                );
      $json_resp =  json_encode($resp_arr);
      
    }
    $this->loging("RECHARGENORMAL",$url,$buffer,$json_resp,$userinfo->row(0)->username);
    return $json_resp;
    
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  





////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////                                                        ////////////////////////////////
///////////////////////    P A Y M E N T   M E T H O D   S T A R T   H E R E   /////////////////////////////////
//////////////////////                                                        //////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
  
  public function PAYMENT_DEBIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00,$userinfo = false)
  {
    
    if(true)
    {
      
      $this->load->library("common");
      $add_date = $this->common->getDate();
      $date = $this->common->getMySqlDate();
      $ip = $this->common->getRealIpAddr();
      $old_balance = $this->Common_methods->getAgentBalance($user_id);
      $current_balance = $old_balance - $dr_amount;
      
      $tds = 0.00;
      $stax = 0.00;
      if($transaction_type == "BILL")
      {
        $str_query = "insert into  tblewallet(user_id,bill_id,transaction_type,debit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)

        values(?,?,?,?,?,?,?,?,?,?,?)";
        $reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$tds,$stax,$remark));
        
        if($reslut == true)
        {
            $ewallet_id = $this->db->insert_id();
          
            $rslt_updtrec = $this->db->query("update tblbills set debited='yes',reverted='no',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),debit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
          return true;
        }
        else
        {
          return false;
        }

      }
      else
      {
          return false;
      } 
    }
    else
    {
      return true;
    } 
  }
  
  public function PAYMENT_CREDIT_ENTRY($user_id,$transaction_id,$transaction_type,$dr_amount,$Description,$sub_txn_type,$remark,$chargeAmount = 0.00,$userinfo = false)
  {
    $Description = "Refund :".$Description;
    $this->load->library("common");
    $add_date = $this->common->getDate();
    $date = $this->common->getMySqlDate();
    $ip = $this->common->getRealIpAddr();
    $old_balance = $this->Common_methods->getAgentBalance($user_id);
    $current_balance = $old_balance + $dr_amount;
    $tds = 0.00;
    $stax = 0.00;
    if($transaction_type == "BILL")
    {
      $str_query = "insert into  tblewallet(user_id,bill_id,transaction_type,credit_amount,balance,description,add_date,ipaddress,tds,serviceTax,remark)

      values(?,?,?,?,?,?,?,?,?,?,?)";
      $reslut = $this->db->query($str_query,array($user_id,$transaction_id,$transaction_type,$dr_amount,$current_balance,$Description,$add_date,$ip,$tds,$stax,$remark));

      if($reslut == true)
      {
          $ewallet_id = $this->db->insert_id();

          $rslt_updtrec = $this->db->query("update tblbills set debited='yes',reverted='yes',balance=CONCAT_WS(',',balance,?), ewallet_id = CONCAT_WS(',',ewallet_id,?),credit_amount = ? where Id = ?",array($current_balance,$ewallet_id,$dr_amount,$transaction_id));
      }
      else
      {
        return false;
      }

    }
    else
    {
        return false;
    } 
  }
  

////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****************************  P A Y M E N T   M E T H O D   E N D S   H E R E   ****************************//
////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

private function getChargeValue($userinfo,$whole_amount)
{
  $groupinfo = $this->db->query("select * from mt3_group where Id = (select dmr_group from tblusers where user_id = ?)",array($userinfo->row(0)->user_id));
  if($groupinfo->num_rows() == 1)
  {
    if($groupinfo->row(0)->charge_type == "SLAB")
    {
      $getrangededuction = $this->db->query("
      select 
        a.charge_type,
        a.charge_amount as charge_value,
        0 as dist_charge_type,
        0 as dist_charge_value 
        from mt_commission_slabs a 
        where a.range_from <= ? and a.range_to >= ? and group_id = ?",array($whole_amount,$whole_amount,$groupinfo->row(0)->Id));
      if($getrangededuction->num_rows() == 1)
      {
        return $getrangededuction;
      }
    }
    else
    {
      return $groupinfo;  
    }
    
  }
  else
  {
    return false;
  }
}
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
//*********** Encryption Function *********************
public function encrypt($plainText, $key) {
    $secretKey = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $secretKey, OPENSSL_RAW_DATA, $initVector);
    $encryptedText = bin2hex($openMode);
    return $encryptedText;
}

//*********** Decryption Function *********************
public function decrypt($encryptedText, $key) {
    $key = $this->hextobin(md5($key));
    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
    $encryptedText = $this->hextobin($encryptedText);
    $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
    return $decryptedText;
}

//*********** Padding Function *********************
public function pkcs5_pad($plainText, $blockSize) {
    $pad = $blockSize - (strlen($plainText) % $blockSize);
    return $plainText . str_repeat(chr($pad), $pad);
}

//********** Hexadecimal to Binary function for php 4.0 version ********
public function hextobin($hexString) {
    $length = strlen($hexString);
    $binString = "";
    $count = 0;
    while ($count < $length) {
        $subString = substr($hexString, $count, 2);
        $packedString = pack("H*", $subString);
        if ($count == 0) {
            $binString = $packedString;
        } else {
            $binString .= $packedString;
        }

        $count += 2;
    }
    return $binString;
}

//********** To generate ramdom String ********
public function generateRandomString($length = 35) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
  
}

?>