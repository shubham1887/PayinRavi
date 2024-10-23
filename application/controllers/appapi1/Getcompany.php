<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getcompany extends CI_Controller {
	
	
	
	
	public function index() 
	{
		error_reporting(-1);
		ini_set('display_errors',1);
		$this->db->db_debug = TRUE;
		/*
		Service LIst

		1 MOBILE
		2 DTH
		3 POSTPAID
		4 LANDLINE
		16 ELECTRICITY
		17 GAS
		30 EMI
		33 FASTTAG
		34 INSURANCE
		35 WATER
		*/
	
		if(isset($_GET["serivce"]))
		{
			$serivce = trim($this->input->get("serivce"));
			$rslt = $this->db->query("select a.company_name,a.company_id,a.imageurl,a.mcode,a.service_id,b.service_name from tblcompany a left join tblservice b on a.service_id = b.service_id where b.service_name = ? order by a.company_name",array($serivce));
		echo json_encode($rslt ->result());exit;
		}	
		
		

	}
	
}