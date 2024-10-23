<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetCustomerName extends CI_Controller { 
	
	
	private function getOperatorCode($company_id)
	{
		if($company_id == "DA")
		{
			return "Airteldth";
		}
		if($company_id == "DS")
		{
			return "Sundirect";
		}
		if($company_id == "DT")
		{
			return "TataSky";
		}
		if($company_id == "DV")
		{
			return "Videocon";
		}
		if($company_id == "DD")
		{
			return "Dishtv";
		}
		
	}
	public function index() 
	{  
		if(isset($_GET["username"]) and isset($_GET["pwd"]) and isset($_GET["mcode"]))		
		{
		    
		   
			$username = trim($_GET["username"]);
			$pwd = trim($_GET["pwd"]);
			$mcode = trim($_GET["mcode"]);
			$number = trim($_GET["number"]);
			$rsltcompany_info = $this->db->query("select company_id from tblcompany where mcode = ?",array($mcode));
			if($rsltcompany_info->num_rows() == 1)
			{
				//$url = 'https://www.mplan.in/api/Dthinfo.php?apikey=090554f3366876d7dfdfddde10697c20&offer=roffer&tel='.$_GET["number"].'&operator='.rawurlencode($this->getOperatorCode($_GET["mcode"]));
				//echo $url;exit;
				//$url = 'http://www.himachalpay.com/api_users/getCustomerName?username=500002&pwd=0000&mcode='.$this->getOperatorCode($mcode)."&number=".$number;
				$url = 'http://masterpay.in/iphoneapp/getCustomerName?username=110001&pwd=12345&number='.$number.'&mcode='.$mcode;
				
				$resp = $this->common->callurl($url);
				echo $resp;exit;
				
			}
		}
		else if(isset($_GET["key"]) and isset($_GET["number"]) and isset($_GET["mcode"]))		
		{
			$key = trim($_GET["key"]);
			$mcode = trim($_GET["mcode"]);
			$number = trim($_GET["number"]);
			$rsltcompany_info = $this->db->query("select company_id from tblcompany where mcode = ?",array($mcode));
			if($rsltcompany_info->num_rows() == 1)
			{
				$url = 'https://www.mplan.in/api/Dthinfo.php?apikey=090554f3366876d7dfdfddde10697c20&offer=roffer&tel='.$_GET["number"].'&operator='.rawurlencode($this->getOperatorCode($_GET["mcode"]));
				//echo $url;exit;
				//$url = 'http://www.himachalpay.com/api_users/getCustomerName?username=500002&pwd=0000&mcode='.$this->getOperatorCode($mcode)."&number=".$number;
				//$url = 'http://masterpay.in/iphoneapp/getCustomerName?username=110001&pwd=12345&number='.$number.'&mcode='.$mcode;
				$resp = $this->common->callurl2($url);
				echo $resp;exit;
				
			}
		}
		else if(isset($_POST["username"]) and isset($_POST["pwd"]) and isset($_POST["mcode"]))		
		{
			$username = trim($_POST["username"]);
			$pwd = trim($_POST["pwd"]);
			$mcode = trim($_POST["mcode"]);
			$number = trim($_POST["number"]);
			$rsltcompany_info = $this->db->query("select company_id from tblcompany where mcode = ?",array($mcode));
			if($rsltcompany_info->num_rows() == 1)
			{
				//$url = 'https://www.mplan.in/api/Dthinfo.php?apikey=cef19e2eae125cbbf795e816a85ff9a8&offer=roffer&tel='.$_GET["number"].'&operator='.rawurlencode($this->getOperatorCode($_GET["mcode"]));
				$url = 'http://www.himachalpay.com/api_users/getCustomerName?username=500002&pwd=0000&mcode='.$this->getOperatorCode($mcode)."&number=".$number;
				$resp = file_get_contents($url);
				echo $resp;exit;
				
			}
		}
	}	
}
//50.22.77.79