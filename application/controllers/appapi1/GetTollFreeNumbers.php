<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GetTollFreeNumbers extends CI_Controller {
	
	public function index()
	{ 
	    $rslt  = $this->db->query("SELECT a.*,b.company_name FROM `tollfreenumbers` a left join tblcompany b on a.company_id = b.company_id");
	    $mainarray = array();
	    $mainarray["message"] = "Success";
	    $mainarray["msgcode"] = "0";
	    $mainarray["data"] = array();
	    $temparray = array();
	    foreach($rslt->result() as $r)
	    {
	       $temparray = array(
	           "id"=>$r->company_name,
	           "banner_image"=>$r->number,
	           ); 
	           array_push($mainarray["data"], $temparray);
	    }
	    echo json_encode($mainarray);exit;
	}	
}
