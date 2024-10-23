<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetPlan extends CI_Controller { 
	
	public function logentry($data)
	{
		/*$filename = "and2.txt";
		if (!file_exists($filename)) 
		{
			file_put_contents($filename, '');
		} 
		$this->load->library("common");

		$this->load->helper('file');
	
		$sapretor = "------------------------------------------------------------------------------------";
		
write_file($filename." .\n", 'a+');
write_file($filename, $data."\n", 'a+');
write_file($filename, $sapretor."\n", 'a+');*/

	}
	private function getOperatorCode($company_id)
	{
		if($company_id == 29)
		{
			return "Airteldth";
		}
		if($company_id == 30)
		{
			return "Sundirect";
		}
		if($company_id == 31)
		{
			return "TataSky";
		}
		if($company_id == 33)
		{
			return "Videocon";
		}
		if($company_id == 37)
		{
			return "Dishtv";
		}
		
	}
	public function index() 
	{  
	   
		if(isset($_GET["username"]) and isset($_GET["pwd"]) and isset($_GET["number"]) and isset($_GET["operator"]))		
		{
			
			
			
	
				$number = trim($_GET["number"]);
				$operator = trim($_GET["operator"]);
				if($operator == "RV")
				{
				    $operator = "Vodafone";
				}
				if($operator == "RA")
				{
				    $operator = "Airtel";
				}
				if($operator == "RI")
				{
				    $operator = "Idea";
				}
				if($operator == "RB" or $operator == "TB")
        		{
        			  $operator =  "BSNL";
        		}
        		if($operator == "RD" or $operator == "TD")
        		{
        			$operator =  "Tata Docomo";
        		}
				
				//$url = 'https://www.mplan.in/api/plans.php?apikey=090554f3366876d7dfdfddde10697c20&offer=roffer&tel='.$number.'&operator='.rawurlencode($operator);
			$url = 'http://masterpay.in/iphoneapp/getPlan?key2=r3t3ZU5fdMbj2NorgUJTmoTdMMKsia4b&number='.$number.'&operator='.trim($_GET["operator"]);
			//echo $url;exit;
				$ch = curl_init();		
        		curl_setopt($ch,CURLOPT_URL,  $url);
        		
        		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        		$buffer = curl_exec($ch);		
        		curl_close($ch);
        		
        	//	echo "resp : ".$buffer;exit;
				//$this->logentry($buffer);
				echo $buffer;exit;
				
			
		}
		else if(isset($_GET["username"]) and isset($_GET["pwd"]) and isset($_GET["circle"]) and isset($_GET["operator"]))		
		{
			
			$temparray["records"] = array();
			$username = trim($_GET["username"]);
			$pwd = trim($_GET["pwd"]);
		//	echo $username."   ".$pwd;exit;
			
			$userinfo = $this->db->query("select user_id from tblusers where username = ? and password = ? ",array($username,$pwd));
			
		//	echo $userinfo->num_rows();exit;
			
			
				$this->logentry("num_rows : ".$userinfo->num_rows() );
			if($userinfo->num_rows() == 1)
			{
			$this->logentry("step3");
				$operator = trim($_GET["operator"]);
				$circle = trim($_GET["circle"]);
				
				if($operator == "RV")
				{
				    $operator = "Vodafone";
				}
				if($operator == "RA")
				{
				    $operator = "Airtel";
				}
				if($operator == "RI")
				{
				    $operator = "Idea";
				}
				if($operator == "RB" or $operator == "TB")
        		{
        			  $operator =  "BSNL";
        		}
        		if($operator == "RD" or $operator == "TD")
        		{
        			$operator =  "Tata Docomo";
        		}
        		if($operator == "JO" or $operator == "JIO")
        		{
        			$operator =  "Jio";
        		}
				
				//http://www.manpay.in/appapi1/getPlan?username=12&pwd=123&circle=Gujarat&operator=RV
				$url = 'http://www.manpay.in/appapi1/getPlan?username=12&pwd=123&circle='.trim($_GET["circle"]).'&operator='.trim($_GET["operator"]);
			   //echo $url;exit;
			    $this->logentry($url);
			    //var_dump($url);exit;
			   // echo $url;exit;
				//echo $url;exit;

				$resp =  $this->common->callurl($url);
				$this->logentry($resp);
			    echo $resp;exit;
			}
		}
	}	
	public function postpaid() 
	{  
	   
		if(isset($_GET["username"]) and isset($_GET["pwd"]) and isset($_GET["number"]) and isset($_GET["operator"]))		
		{
			
			
			
	
				$number = trim($_GET["number"]);
				$operator = trim($_GET["operator"]);
				if($operator == "PV")
				{
				    $operator = "Vodafone";
				}
				if($operator == "PA")
				{
				    $operator = "Airtel";
				}
				if($operator == "PI")
				{
				    $operator = "Idea";
				}
				if($operator == "PB")
        		{
        			  $operator =  "BSNL";
        		}
        		
				$url = 'https://www.mplan.in/api/Bsnl.php?apikey=090554f3366876d7dfdfddde10697c20&offer=roffer&tel='.$number.'&operator='.$operator;
			
			//echo $url;exit;
				$ch = curl_init();		
        		curl_setopt($ch,CURLOPT_URL,  $url);
        		
        		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        		$buffer = curl_exec($ch);		
        		curl_close($ch);
        		
        	//	echo "resp : ".$buffer;exit;
				//$this->logentry($buffer);
				echo $buffer;exit;
				
			
		}
		else if(isset($_GET["username"]) and isset($_GET["pwd"]) and isset($_GET["circle"]) and isset($_GET["operator"]))		
		{
			
			$temparray["records"] = array();
			$username = trim($_GET["username"]);
			$pwd = trim($_GET["pwd"]);
			
			
			$userinfo = $this->db->query("select user_id from tblusers where mobile_no = ? and password = ? ",array($username,$pwd));
				$this->logentry("num_rows : ".$userinfo->num_rows() );
			if($userinfo->num_rows() == 1)
			{
			$this->logentry("step3");
				$operator = trim($_GET["operator"]);
				$circle = trim($_GET["circle"]);
				
				if($operator == "RV")
				{
				    $operator = "Vodafone";
				}
				if($operator == "RA")
				{
				    $operator = "Airtel";
				}
				if($operator == "RI")
				{
				    $operator = "Idea";
				}
				if($operator == "RB" or $operator == "TB")
        		{
        			  $operator =  "BSNL";
        		}
        		if($operator == "RD" or $operator == "TD")
        		{
        			$operator =  "Tata Docomo";
        		}
        		if($operator == "JO" or $operator == "JIO")
        		{
        			$operator =  "Jio";
        		}
				
				
				$url = 'https://www.mplan.in/api/plans.php?apikey=090554f3366876d7dfdfddde10697c20&cricle='.rawurlencode($circle).'&operator='.rawurlencode($operator);
			   
			    $this->logentry($url);
			    //var_dump($url);exit;
			   // echo $url;exit;
				//echo $url;exit;

				$resp =  $this->common->callurl($url);
				$this->logentry($resp);
			    echo $resp;exit;
			}
		}
	}
}
//50.22.77.79