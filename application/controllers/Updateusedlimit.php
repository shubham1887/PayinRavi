<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updateusedlimit extends CI_Controller {

	public function index()
	{	
		$this->db->query("update tbluser_commission set usedlimit = ?",array("0"));	
		echo "done";exit;
	}
}
