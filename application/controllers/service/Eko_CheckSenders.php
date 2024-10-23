<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eko_CheckSenders extends CI_Controller {
	
	public function index()
	{ 
		$this->load->model("Eko");
		$rsltuses = $this->db->query("select * from mt3_remitter_registration where EKO = 'no' order by rand() limit 3000");
		$userinfo = $this->db->query("select * from tblusers where usertype_name = 'APIUSER' order by user_id limit 1");
		foreach($rsltuses->result() as $rw)
		{
			echo $this->Eko->remitter_details($rw->mobile,$userinfo);
			echo "<hr>";
		}
		
		
	}	
}
