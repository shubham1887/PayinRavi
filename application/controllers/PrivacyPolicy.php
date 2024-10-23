<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class PrivacyPolicy extends CI_Controller {


	public function index()
	{ 
		$data = array();
        $rsltadmininfo = $this->db->query("select * from admininfo");
        foreach($rsltadmininfo->result() as $rwainf)
        {
            $data[$rwainf->param]=$rwainf->value;
            
        }
	       
		$this->view_data["data"]=$data;
		$this->view_data["message"] = "";
		$this->load->view("PrivacyPolicy_view",$this->view_data);
	}
	
}

