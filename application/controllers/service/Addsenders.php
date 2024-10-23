<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addsenders extends CI_Controller {
	
	public function index()
	{  
	
		if(isset($_GET["mobile"]) and isset($_GET["firstname"]) and isset($_GET["lastname"]) and isset($_GET["pincode"]))
		{
			$mobile_no = $_GET["mobile"];
			$name = $_GET["firstname"];
			$lname = $_GET["lastname"];
			$pincode = $_GET["pincode"];
			$checkremitterexist = $this->db->query("select Id from mt3_remitter_registration where mobile = ?",array($mobile_no));
			if($checkremitterexist->num_rows() == 0)
			{
				$rsltinsert = $this->db->query("insert into mt3_remitter_registration(add_date,ipaddress,mobile,name,lastname,pincode)
				values(?,?,?,?,?,?)",
				array(
				$this->common->getDate(),
				$this->common->getRealIpAddr(),
				$mobile_no,
				$name,
				$lname,
				$pincode
				));
				if($rsltinsert == true)
				{
					echo file_get_contents("https://masterpay.pro/appapi1/getsender_temp/update_rowbymobile?Id=".$mobile_no);
				}
			}
		}
		
	}	
}
