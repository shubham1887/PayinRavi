<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Common 
{ 
	public function getPerPage()
	{
		return "30";
	}
	public function getCompanyName()
	{
		return "RPays";
	}
	public function getDate()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$date = date("Y-m-d H:i:s");		
		return $date; 
	}
	public  function getpreviousdate($date)
	{ 
		$date1 = str_replace('-', '/', $date);
		$preciusday = date('Y-m-d',strtotime($date1 . "-1 days"));
		return date_format(date_create($preciusday),'Y-m-d');
	}
	public function change_date_format($datatime)
	{
	    putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
	    return date_format(date_create($datatime),'d-m-Y H:i:s');
	}
	public function callurl($url,$recharge_id = 0)
	{
	
		$ch = curl_init();		
		curl_setopt($ch,CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 180); //timeout in seconds
		$buffer = curl_exec($ch);		
		curl_close($ch);		
		$CI =& get_instance();
    	$CI->load->model('Errorlog');
    	$CI->Errorlog->httplog($url,$buffer,$recharge_id);
		
		
		
		return $buffer;
		

	}
	public function callurl_timeout($url,$recharge_id = 0)
	{
	
		$ch = curl_init();		
		curl_setopt($ch,CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$buffer = curl_exec($ch);		
		curl_close($ch);		
		$CI =& get_instance();
    	$CI->load->model('Errorlog');
    	$CI->Errorlog->httplog($url,$buffer,$recharge_id);
		
		
		
		return $buffer;
		
	}
	public function callurl_post($url,$postdata,$recharge_id = 0)
	{
	
		$ch = curl_init();		
		curl_setopt($ch,CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
		$buffer = curl_exec($ch);		
		curl_close($ch);	

		$CI =& get_instance();
    	$CI->load->model('Errorlog');
    	$CI->Errorlog->httplog($url."?".$postdata,$buffer,$recharge_id);
		
		return $buffer;
		
	}
	
	
	
	
	public function callurl_json($url,$postdata,$recharge_id = 0)
	{
	    
	    	$headers = array();
			$headers[] = 'Accept: application/json';
			$headers[] = 'Content-Type: application/json';
			
	    
		$ch = curl_init();		
		curl_setopt($ch,CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
		$buffer = curl_exec($ch);		
		curl_close($ch);		
		$CI =& get_instance();
    	$CI->load->model('Errorlog');
    	$insert_id = $CI->Errorlog->httplog($url."?".$postdata,$buffer,$recharge_id);
		
		return $buffer;
		
	}
	public function GetPassword()
	{
		$n = rand(1000000, 999999999);
	
		return substr($n,0,6);										
	}
	public function GetTxnPassword()
	{
		$n = rand(1000000, 999999999);
	
		return substr($n,0,4);										
	}
	public function getOTP()
	{
		$n = rand(100001, 999999);
		return $n;										
	}
	public function getBonrixOperatorCode($company_id)

	{
		if($company_id == 12)	
		{
			return array(
				"CODE"=>"Airtel",
				"PRE"=>"RR",
			); 
		}							
		else if($company_id == 13)	
		{
			return array(
				"CODE"=>"Vodafone",
				"PRE"=>"RR",
			); 
		}
		else if($company_id == 14)	
		{
			return array(
				"CODE"=>"Aircel",
				"PRE"=>"RR",
			); 
		}
		else if($company_id == 16)	
		{
			return array(
				"CODE"=>"BSNL",
				"PRE"=>"RR",
			); 
		}
		else if($company_id == 35)	
		{
			return array(
				"CODE"=>"BSNL",
				"PRE"=>"STV",
			); 
		}
		else if($company_id == 18)	
		{
			return array(
				"CODE"=>"Docomo",
				"PRE"=>"RR",
			); 
		}
		else if($company_id == 36)	
		{
			return array(
				"CODE"=>"Docomo",
				"PRE"=>"STV",
			); 
		}
		else if($company_id == 23)	
		{
			return array(
				"CODE"=>"Idea",
				"PRE"=>"RR",
			); 
		}
		else if($company_id == 27)	
		{
			return array(
				"CODE"=>"Uninor",
				"PRE"=>"RR",
			); 
		}
		else if($company_id == 28)	
		{
			return array(
				"CODE"=>"Uninor",
				"PRE"=>"STV",
			); 
		}
		else if($company_id == 29)	
		{
			return array(
				"CODE"=>"AirtelDTH",
				"PRE"=>"DTH",
			); 
		}
		else if($company_id == 30)	
		{
			return array(
				"CODE"=>"SunDirect",
				"PRE"=>"DTH",
			); 
		}
		else if($company_id == 31)	
		{
			return array(
				"CODE"=>"TataSky",
				"PRE"=>"DTH",
			); 
		}
		else if($company_id == 32)	
		{
			return array(
				"CODE"=>"RelianceBigTv",
				"PRE"=>"DTH",
			); 
		}
		else if($company_id == 33)	
		{
			return array(
				"CODE"=>"VideoconD2H",
				"PRE"=>"DTH",
			); 
		}
		else if($company_id == 37)	
		{
			return array(
				"CODE"=>"DishTV",
				"PRE"=>"DTH",
			); 
		}
		else if($company_id == 57)	
		{
			return array(
				"CODE"=>"JO",
				"PRE"=>"RR",
			); 
		}
	}
	public function getOperatorCode($api_name,$company_id)
	{
		if($api_name == "MAHARSHI")
		{
			if($company_id == 12)	
			{
				return "RA";
			}							
			else if($company_id == 13)	
			{
				return "RV";
			}
			else if($company_id == 14)	
			{
				return "RC";
			}
			else if($company_id == 16)	
			{
				return "RB"; 
			}
			else if($company_id == 35)	
			{
				return "TB"; 
			}
			else if($company_id == 18)	
			{
				return "RD"; 
			}
			else if($company_id == 36)	
			{
				return "TD"; 
			}
			else if($company_id == 23)	
			{
				return "RI"; 
			}
			else if($company_id == 27)	
			{
				return "RU"; 
			}
			else if($company_id == 28)	
			{
				return "TU"; 
			}
			else if($company_id == 29)	
			{
				return "DA";
			}
			else if($company_id == 30)	
			{
				return "DS";
			}
			else if($company_id == 31)	
			{
				return "DT";
			}
			else if($company_id == 32)	
			{
				return "DB";
			}
			else if($company_id == 33)	
			{
				return "DV";
			}
			else if($company_id == 37)	
			{
				return "DD"; 
			}
			else if($company_id == 57)	
			{
				return "RJ"; 
			}	
		}
		else if($api_name == "RAJAN")
		{
			if($company_id == 12)	//airetl
			{
				return "1";
			}							
			else if($company_id == 13)	//voda
			{
				return "2";
			}
			else if($company_id == 14)	//aircel
			{
				return "6";
			}
			else if($company_id == 16)	 //bsnl topup
			{
				return "3"; 
			}
			else if($company_id == 35)	//bsnl stv
			{
				return "16"; 
			}
			else if($company_id == 18)	//docomo
			{
				return "10"; 
			}
			else if($company_id == 36)	//docomo special
			{
				return "19"; 
			}
			else if($company_id == 23)	//idea
			{
				return "7"; 
			}
			else if($company_id == 27)	 //telenor
			{
				return "14"; 
			}
			else if($company_id == 28) // telenor special	
			{
				return "57"; 
			}
			else if($company_id == 29)	//airtel tv
			{
				return "28";
			}
			else if($company_id == 30)	//sun tv
			{
				return "31";
			}
			else if($company_id == 31)	///tata sky 
			{
				return "32";
			}
			else if($company_id == 32)	//big tv
			{
				return "30";
			}
			else if($company_id == 33)	 // videocon tv
			{
				return "33";
			}
			else if($company_id == 37)	 // dish tv
			{
				return "29"; 
			}
			else if($company_id == 57)	 // jio
			{
				return "58"; 
			}	
		}
		else if($api_name == "Mangalam")
		{
			if($company_id == 12)	
			{
				return "RA";
			}							
			else if($company_id == 13)	
			{
				return "RV";
			}
			else if($company_id == 14)	
			{
				return "RC";
			}
			else if($company_id == 16)	
			{
				return "RB"; 
			}
			else if($company_id == 35)	
			{
				return "TB"; 
			}
			else if($company_id == 18)	
			{
				return "RD"; 
			}
			else if($company_id == 36)	
			{
				return "TD"; 
			}
			else if($company_id == 23)	
			{
				return "RI"; 
			}
			else if($company_id == 27)	
			{
				return "RU"; 
			}
			else if($company_id == 28)	
			{
				return "TU"; 
			}
			else if($company_id == 29)	
			{
				return "DA";
			}
			else if($company_id == 30)	
			{
				return "DS";
			}
			else if($company_id == 31)	
			{
				return "DT";
			}
			else if($company_id == 32)	
			{
				return "DB";
			}
			else if($company_id == 33)	
			{
				return "DV";
			}
			else if($company_id == 37)	
			{
				return "DD"; 
			}
			else if($company_id == 57)	
			{
				return "RJ"; 
			}	
		}
		else if($api_name == "ANSH")
		{
			if($company_id == 12)	//airtel
			{
				return "AT";
			}							
			else if($company_id == 13)	//vodafone
			{
				return "VF";
			}
			else if($company_id == 14)	//aircel
			{
				return "AL";
			}
			else if($company_id == 16)	//bsnl topup
			{
				return "BS"; 
			}
			else if($company_id == 35)	//
			{
				return "BSR"; 
			}
			else if($company_id == 18)	//docomo
			{
				return "TD"; 
			}
			else if($company_id == 36)	//docomo stv
			{
				return "TDS"; 
			}
			else if($company_id == 23)	//idea
			{
				return "ID"; 
			}
			else if($company_id == 27)	//uninor
			{
				return "UN"; 
			}
			else if($company_id == 28)	//uninor special
			{
				return "UNS"; 
			}
			else if($company_id == 29)	//airtel tv
			{
				return "AD";
			}
			else if($company_id == 30)	//sun tv
			{
				return "SD";
			}
			else if($company_id == 31)	//tata sky
			{
				return "TS";
			}
			else if($company_id == 32)	//big tv
			{
				return "BT";
			}
			else if($company_id == 33)	//videocon tv
			{
				return "VT";
			}
			else if($company_id == 37)	//dish tv
			{
				return "DT"; 
			}
			else if($company_id == 57)//jio	
			{
				return "JI"; 
			}	
		}
		else if($api_name == "PAULSON")
		{
			if($company_id == 12)	//Airtel
			{
				return array(
					"CODE"=>"A",
					"PRE"=>0);
			}							
			else if($company_id == 13)	//Vodafone
			{
				return array(
					"CODE"=>"V",
					"PRE"=>0);
			}
			else if($company_id == 14)	//Aircel
			{
				return array(
					"CODE"=>"AI",
					"PRE"=>0);
			}
			else if($company_id == 16)	//BSNL TOPUP
			{
				return array(
					"CODE"=>"B",
					"PRE"=>0);
			}
			else if($company_id == 35)	//BSNL STV
			{
				return array(
					"CODE"=>"B",
					"PRE"=>1);
			}
			else if($company_id == 18)	//Docomo
			{
				return array(
					"CODE"=>"TD",
					"PRE"=>0);
			}
			else if($company_id == 36)	//Docomo Special
			{
				return array(
					"CODE"=>"TD",
					"PRE"=>1);
			}
			else if($company_id == 23)	//Idea
			{
				return array(
					"CODE"=>"RI",
					"PRE"=>0);
			}
			else if($company_id == 27)	//Uninor
			{
				return array(
					"CODE"=>"U",
					"PRE"=>0);
			}
			else if($company_id == 28)	
			{
				return array(
					"CODE"=>"U",
					"PRE"=>1);
			}
			else if($company_id == 29)	//Airtel TV
			{
				return array(
					"CODE"=>"AD",
					"PRE"=>0);
			}
			else if($company_id == 30)	//Sun TV
			{
				return array(
					"CODE"=>"ST",
					"PRE"=>0);
			}
			else if($company_id == 31)	//Tata Sky
			{
				return array(
					"CODE"=>"TS",
					"PRE"=>0);
			}
			else if($company_id == 32)	 //Big TV
			{
					return array(
					"CODE"=>"BD",
					"PRE"=>0);
			}
			else if($company_id == 33)	 //Videocon TV
			{
				return array(
					"CODE"=>"VD",
					"PRE"=>0);
			}
			else if($company_id == 37)	 //Dish TV
			{
				return array(
					"CODE"=>"DT",
					"PRE"=>0);
			}
			else if($company_id == 57)	 //JIO
			{
				return "JIO"; 
			}	
		}
	}
		
	
	public function ExecuteSMSApi($mobile_no,$message,$template_id = "")
	{
		$CI =& get_instance();
    	$CI->load->model('Sms');

		$CI->load->model('Api_model');
    	$smsapi = $CI->Api_model->getsmsapi();
    	//$CI->Sms->insertintable($mobile_no,$message);	
		//$message = rawurlencode($message);
		$url =urldecode( $CI->Api_model->getsmsapiurl($smsapi));
		$url = str_replace("[to]",$mobile_no,$url);
		$url = str_replace("[message]",urlencode($message),$url);
		$url = str_replace("[template_id]",urlencode($template_id),$url);
		
		$opcode = 'aeb9aaa4812159dfrww112'; 
		$mobileno =$mobile_no;
		$message = $message;
		

		//echo $url;exit;
		
		 $CI->Api_model->smslog($url);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$buffer = curl_exec($ch);
		
		curl_close($ch);
		$CI->Sms->addSentMessage($mobile_no,$message,$url.">>".$buffer);
		
			
		return $buffer;
	}
	public function ExecuteSMSApiWowSms($mobile_no,$message)
	{
		$CI =& get_instance();
    	$CI->load->model('Sms');

		$CI->load->model('Api_model');
    	
		$url ='http://client.wowmsg.com/submitsms.jsp?user=PAYINN&key=20ed5890f5XX&mobile=91'.$mobile_no.'&message='.rawurlencode($message).'&senderid=PAYINN&accusage=1&entityid=1201160570131539547&tempid=1207163324561471606';
		$CI->Api_model->smslog($url);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$buffer = curl_exec($ch);
		
		curl_close($ch);
		$CI->Sms->addSentMessage($mobile_no,$message,$buffer);
		
			
		return $buffer;
	}
	
	
	public function getMySqlDate()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$date = date("Y-m-d");		
		return $date; 
	}
	public function getMySqlTime()
	{
		putenv("TZ=Asia/Calcutta");
		date_default_timezone_set('Asia/Calcutta');
		$time = date("h:i:s A");		
		return $time; 
	}
	public function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}	
public function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 
    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 
    $res = ""; 
    if ($Gn) 
    { 
        $res .= $this->convert_number($Gn) . " Million"; 
    } 
    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            $this->convert_number($kn) . " Thousand"; 
    } 
    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            $this->convert_number($Hn) . " Hundred"; 
    } 
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 
    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 
        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 
            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 
    if (empty($res)) 
    { 
        $res = "zero"; 
    } 
    return $res; 
} 
public function ExecuteAPI_Payworld($loginstatus,$agentid,$retailerid,$transid,$operatorcode,$circode,$mobileno,$amount,$product_name,$RechargeType)
	{				

		$ch = curl_init();		
		if($product_name == "GSPL" or $product_name == "Recharge-3G" or $product_name == "Recharge" or  $product_name == "Recharge-STV"){$denomination = $amount;}else{$denomination = 0;}
		if($RechargeType == "Mobile")
		{
		$post_fields= "loginstatus=".$loginstatus."&agentid=".$agentid."&retailerid=".$retailerid."&transid=".$transid."&operatorcode=".$operatorcode."&circode=".$circode."&product=".$product_name."&denomination=$denomination&mobileno=".$mobileno."&recharge=".$amount."&appver=3.38";
		}
		if($RechargeType == "DTH")
		{
		$post_fields = "loginstatus=".$loginstatus."&agentid=".$agentid."&retailerid=".$retailerid."&transid=".$transid."&operatorcode=".$operatorcode."&circode=".$circode."&product=".$product_name."&denomination=$denomination&custid=".$mobileno."&recharge=".$amount."&appver=3.38";	
		}
		if($circode == '7' or $circode == '8')
		{
			if($operatorcode == '14' && $product_name == 'TOPUP')
			{
			$post_fields = "loginstatus=".$loginstatus."&agentid=".$agentid."&retailerid=".$retailerid."&transid=".$transid."&operatorcode=".$operatorcode."&circode=".$circode."&product=".$product_name."&denomination=$amount&mobileno=".$mobileno."&recharge=".$amount."&appver=3.38";
			}
		}
		if($operatorcode == '8')
		{
			$post_fields = "loginstatus=".$loginstatus."&agentid=".$agentid."&retailerid=".$retailerid."&transid=".$transid."&operatorcode=".$operatorcode."&circode=".$circode."&product=".$product_name."&denomination=$amount&mobileno=".$mobileno."&recharge=".$amount."&appver=3.38";
		}
		if($operatorcode == '7')
		{		
$post_fields = "loginstatus=".$loginstatus."&agentid=".$agentid."&retailerid=".$retailerid."&transid=".$transid."&operatorcode=".$operatorcode."&circode=".$circode."&product=".$product_name."&denomination=0&mobileno=".$mobileno."&recharge=".$amount."&appver=3.38";
		}
		if($operatorcode == '31')
		{
$post_fields = "loginstatus=".$loginstatus."&agentid=".$agentid."&retailerid=".$retailerid."&transid=".$transid."&operatorcode=".$operatorcode."&circode=".$circode."&denomination=0&mobileno=".$mobileno."&recharge=".$amount."&appver=3.38";
		}
		$req='http://220.226.204.98/mainlinkpos/purchase/pw_etrans.php3'.$post_fields;
		  $CI =& get_instance();
    	  $CI->load->model('Do_recharge_model');
    	$CI->Do_recharge_model->updateRechargeRequest($req,$transid);
		
		curl_setopt($ch,CURLOPT_URL, 'http://220.226.204.98/mainlinkpos/purchase/pw_etrans.php3');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);		
		$buffer = curl_exec($ch);
		curl_close($ch);		
	
    	$CI->Do_recharge_model->updateRechargeResponse($buffer,$transid);
		return $buffer;
	}
	public function payworldStatusAPI($agentid,$sndtransid,$recharge_id,$product_name)
	{
		$post_fields = "loginstatus=LIVE&agentid=".$agentid."&client_transid=".$recharge_id."&appver=3.38&service=".$product_name;
		$ch = curl_init();	
		curl_setopt($ch,CURLOPT_URL, 'http://220.226.204.98/mainlinkpos/purchase/pw_gettransstatus.php3');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);		
		$buffer = curl_exec($ch);
		curl_close($ch);		
		echo $buffer;
	}
}