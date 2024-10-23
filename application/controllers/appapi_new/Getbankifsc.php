<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getbankifsc extends CI_Controller {
	
	public function index()
	{ 
		$rslt = $this->db->query("select bank_name,ifsc from dmr_banks order by bank_name");
		echo json_encode($rslt->result());exit;
	}	
}
